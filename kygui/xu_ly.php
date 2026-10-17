<?php
// Tên file: xu_ly.php (2 từ)
require_once __DIR__ . '/ket_noi.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_REQUEST['action'] ?? '';

function luu_anh_san_pham(&$loi) {
    if (!isset($_FILES['hinh_anh']) || $_FILES['hinh_anh']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES['hinh_anh']['error'] !== UPLOAD_ERR_OK) {
        $loi = 'Không thể tải ảnh lên. Vui lòng thử lại.';
        return false;
    }

    if ($_FILES['hinh_anh']['size'] > 5 * 1024 * 1024) {
        $loi = 'Ảnh không được vượt quá 5 MB.';
        return false;
    }

    $imageInfo = @getimagesize($_FILES['hinh_anh']['tmp_name']);
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];
    $mimeType = $imageInfo['mime'] ?? '';
    if (!$imageInfo || !isset($extensions[$mimeType])) {
        $loi = 'Tệp tải lên phải là ảnh JPG, PNG, GIF hoặc WEBP hợp lệ.';
        return false;
    }

    $targetDir = __DIR__ . '/uploads/';
    if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
        $loi = 'Không thể tạo thư mục lưu ảnh.';
        return false;
    }

    $fileName = bin2hex(random_bytes(16)) . '.' . $extensions[$mimeType];
    if (!move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $targetDir . $fileName)) {
        $loi = 'Không thể lưu ảnh sản phẩm. Vui lòng thử lại.';
        return false;
    }

    return 'uploads/' . $fileName;
}

// 1. TÌM KIẾM SẢN PHẨM / LỌC DANH MỤC (GẦN GIỐNG NHẤT - FUZZY MATCH)
if ($action === 'tim_kiem_san_pham') {
    $tukhoa = trim($_GET['tukhoa'] ?? '');
    $danh_muc_id = intval($_GET['danh_muc_id'] ?? 0);

    if ($pdo) {
        $sql = "SELECT sp.*, dm.ten_danh_muc, nd.ho_ten AS nguoi_dang 
                FROM san_pham sp 
                JOIN danh_muc dm ON sp.danh_muc_id = dm.id 
                JOIN nguoi_dung nd ON sp.nguoi_dung_id = nd.id 
                WHERE 1=1";
        $params = [];

        if ($danh_muc_id > 0) {
            $sql .= " AND sp.danh_muc_id = ?";
            $params[] = $danh_muc_id;
        }

        if (!empty($tukhoa)) {
            $sql .= " AND (sp.ten_san_pham LIKE ? OR sp.mo_ta LIKE ? OR sp.tinh_trang LIKE ? OR dm.ten_danh_muc LIKE ? OR nd.ho_ten LIKE ?)";
            $params[] = "%$tukhoa%";
            $params[] = "%$tukhoa%";
            $params[] = "%$tukhoa%";
            $params[] = "%$tukhoa%";
            $params[] = "%$tukhoa%";
        }

        $sql .= " ORDER BY sp.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $san_pham = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $san_pham]);
    } else {
        echo json_encode(['success' => true, 'data' => []]);
    }
    exit;
}

// 2. GỬI TIN NHẮN CHAT (BẮT BUỘC ĐĂNG NHẬP)
if ($action === 'gui_chat') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để nhắn tin liên hệ!']);
        exit;
    }

    $noi_dung = trim($_POST['noi_dung'] ?? '');
    $san_pham_id = intval($_POST['san_pham_id'] ?? 0);
    $user_id = get_current_user_id();

    if (empty($noi_dung)) {
        echo json_encode(['success' => false, 'message' => 'Nội dung tin nhắn không được để trống!']);
        exit;
    }

    if ($pdo) {
        $stmt = $pdo->prepare("INSERT INTO tin_nhan (nguoi_gui_id, san_pham_id, noi_dung) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $san_pham_id > 0 ? $san_pham_id : null, $noi_dung]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Đã gửi tin nhắn!',
        'chat' => [
            'noi_dung' => htmlspecialchars($noi_dung),
            'ngay_gui' => date('H:i d/m/Y')
        ]
    ]);
    exit;
}

// 3. MUA NGAY (XÁC NHẬN ĐƠN HÀNG - BẮT BUỘC ĐĂNG NHẬP)
if ($action === 'mua_ngay') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để mua hàng!']);
        exit;
    }

    $san_pham_id = intval($_POST['san_pham_id'] ?? 0);
    $phuong_thuc = $_POST['phuong_thuc'] ?? 'tien_mat';
    $user_id = get_current_user_id();

    if ($san_pham_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không hợp lệ!']);
        exit;
    }

    if ($pdo) {
        $stmt = $pdo->prepare("SELECT gia_niem_yet FROM san_pham WHERE id = ?");
        $stmt->execute([$san_pham_id]);
        $sp = $stmt->fetch();

        if ($sp) {
            $gia = $sp['gia_niem_yet'];
            $stmtInsert = $pdo->prepare("INSERT INTO don_hang (san_pham_id, nguoi_mua_id, gia_tien, phuong_thuc_tt) VALUES (?, ?, ?, ?)");
            $stmtInsert->execute([$san_pham_id, $user_id, $gia, $phuong_thuc]);

            // Cập nhật trạng thái sản phẩm sang đã bán
            $stmtUpdate = $pdo->prepare("UPDATE san_pham SET trang_thai = 'da_ban' WHERE id = ?");
            $stmtUpdate->execute([$san_pham_id]);

            echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công! Cảm ơn bạn đã giao dịch qua ConsignHub.']);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Đã mua hàng thành công (Demo)!']);
    exit;
}

// 4. VIẾT ĐÁNH GIÁ (BẮT BUỘC ĐĂNG NHẬP)
if ($action === 'viet_danh_gia') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để viết đánh giá!']);
        exit;
    }

    $so_sao = intval($_POST['so_sao'] ?? 5);
    $loai_danh_gia = $_POST['loai_danh_gia'] ?? 'dich_vu';
    $noi_dung = trim($_POST['noi_dung'] ?? '');
    $user_id = get_current_user_id();

    if (empty($noi_dung)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập nội dung đánh giá!']);
        exit;
    }

    if ($pdo) {
        $stmt = $pdo->prepare("INSERT INTO danh_gia (nguoi_danh_gia_id, loai_danh_gia, so_sao, noi_dung) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $loai_danh_gia, $so_sao, $noi_dung]);
    }

    echo json_encode(['success' => true, 'message' => 'Cảm ơn bạn đã gửi đánh giá!']);
    exit;
}

// 5. ĐĂNG KÝ GỬI MÓN ĐỒ MỚI (TRANG CÁ NHÂN - BẮT BUỘC ĐĂNG NHẬP)
if ($action === 'dang_do') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để đăng ký gửi đồ!']);
        exit;
    }

    $ten_san_pham = trim($_POST['ten_san_pham'] ?? '');
    $danh_muc_id  = intval($_POST['danh_muc_id'] ?? 1);
    $tinh_trang   = trim($_POST['tinh_trang'] ?? 'Mới 98%');
    $mo_ta        = trim($_POST['mo_ta'] ?? '');
    $gia_nhan     = floatval($_POST['gia_nhan'] ?? 0);
    $gia_niem_yet = floatval($_POST['gia_niem_yet'] ?? ($gia_nhan * 1.25));
    $user_id      = get_current_user_id();

    if (empty($ten_san_pham) || $gia_nhan <= 0) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền tên món đồ và mức giá bạn muốn nhận về!']);
        exit;
    }

    // Xử lý upload ảnh sản phẩm vào thư mục local
    $hinh_anh_path = 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80';
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . '/uploads/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . rand(100, 999) . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['hinh_anh']['name']));
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file)) {
            $hinh_anh_path = 'uploads/' . $file_name;
        }
    }

    if ($pdo) {
        $stmt = $pdo->prepare("INSERT INTO san_pham (nguoi_dung_id, ten_san_pham, danh_muc_id, tinh_trang, mo_ta, gia_nhan, gia_niem_yet, hinh_anh, trang_thai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'dang_ban')");
        $stmt->execute([$user_id, $ten_san_pham, $danh_muc_id, $tinh_trang, $mo_ta, $gia_nhan, $gia_niem_yet, $hinh_anh_path]);
    }

    echo json_encode(['success' => true, 'message' => 'Đã lưu và gửi duyệt món đồ ký gửi mới thành công!']);
    exit;
}

// 6. CẬP NHẬT THÔNG TIN MÓN ĐỒ KÝ GỬI CỦA NGƯỜI DÙNG
if ($action === 'cap_nhat_do') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để chỉnh sửa món đồ!']);
        exit;
    }

    if (!$pdo) {
        echo json_encode(['success' => false, 'message' => 'Không thể kết nối cơ sở dữ liệu để cập nhật sản phẩm.']);
        exit;
    }

    $san_pham_id = intval($_POST['san_pham_id'] ?? 0);
    $ten_san_pham = trim($_POST['ten_san_pham'] ?? '');
    $danh_muc_id = intval($_POST['danh_muc_id'] ?? 0);
    $tinh_trang = trim($_POST['tinh_trang'] ?? '');
    $mo_ta = trim($_POST['mo_ta'] ?? '');
    $gia_nhan = filter_var($_POST['gia_nhan'] ?? null, FILTER_VALIDATE_FLOAT);
    $gia_niem_yet = filter_var($_POST['gia_niem_yet'] ?? null, FILTER_VALIDATE_FLOAT);
    $user_id = get_current_user_id();

    if ($san_pham_id <= 0 || $ten_san_pham === '' || $danh_muc_id <= 0 || $tinh_trang === '' ||
        $gia_nhan === false || $gia_nhan <= 0 || $gia_niem_yet === false || $gia_niem_yet <= 0) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ tên, danh mục, tình trạng và mức giá hợp lệ.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT hinh_anh FROM san_pham WHERE id = ? AND nguoi_dung_id = ?");
    $stmt->execute([$san_pham_id, $user_id]);
    $item = $stmt->fetch();
    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy món đồ hoặc bạn không có quyền chỉnh sửa món đồ này.']);
        exit;
    }

    $stmtCategory = $pdo->prepare("SELECT id FROM danh_muc WHERE id = ?");
    $stmtCategory->execute([$danh_muc_id]);
    if (!$stmtCategory->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Danh mục sản phẩm không hợp lệ.']);
        exit;
    }

    $uploadError = null;
    $uploadedImage = luu_anh_san_pham($uploadError);
    if ($uploadedImage === false) {
        echo json_encode(['success' => false, 'message' => $uploadError]);
        exit;
    }

    $imagePath = $uploadedImage ?? $item['hinh_anh'];
    $stmtUpdate = $pdo->prepare(
        "UPDATE san_pham
         SET ten_san_pham = ?, danh_muc_id = ?, tinh_trang = ?, mo_ta = ?,
             gia_nhan = ?, gia_niem_yet = ?, hinh_anh = ?
         WHERE id = ? AND nguoi_dung_id = ?"
    );
    $stmtUpdate->execute([
        $ten_san_pham, $danh_muc_id, $tinh_trang, $mo_ta,
        $gia_nhan, $gia_niem_yet, $imagePath, $san_pham_id, $user_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Đã cập nhật thông tin món đồ thành công!']);
    exit;
}

// 7. XÓA MÓN ĐỒ KÝ GỬI CỦA NGƯỜI DÙNG
if ($action === 'xoa_do') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để xóa món đồ!']);
        exit;
    }

    if (!$pdo) {
        echo json_encode(['success' => false, 'message' => 'Không thể kết nối cơ sở dữ liệu để xóa sản phẩm.']);
        exit;
    }

    $san_pham_id = intval($_POST['san_pham_id'] ?? 0);
    $user_id = get_current_user_id();
    if ($san_pham_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Món đồ không hợp lệ.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM san_pham WHERE id = ? AND nguoi_dung_id = ?");
    $stmt->execute([$san_pham_id, $user_id]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy món đồ hoặc bạn không có quyền xóa món đồ này.']);
        exit;
    }

    $stmtOrder = $pdo->prepare("SELECT id FROM don_hang WHERE san_pham_id = ? LIMIT 1");
    $stmtOrder->execute([$san_pham_id]);
    if ($stmtOrder->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa món đồ đã có đơn hàng để bảo toàn lịch sử giao dịch.']);
        exit;
    }

    $stmtDelete = $pdo->prepare("DELETE FROM san_pham WHERE id = ? AND nguoi_dung_id = ?");
    $stmtDelete->execute([$san_pham_id, $user_id]);
    if ($stmtDelete->rowCount() !== 1) {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa món đồ. Vui lòng tải lại trang và thử lại.']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Đã xóa món đồ khỏi danh sách ký gửi.']);
    exit;
}

// 8. LẤY ĐỒ KÝ GỬI CỦA TÔI
if ($action === 'lay_san_pham_toi') {
    if (!is_logged_in()) {
        echo json_encode(['success' => false, 'require_login' => true, 'message' => 'Vui lòng đăng nhập để xem danh sách đồ ký gửi!']);
        exit;
    }

    $trang_thai = $_GET['trang_thai'] ?? 'tat_ca';
    $user_id = get_current_user_id();

    if ($pdo) {
        $sql = "SELECT sp.*, dm.ten_danh_muc FROM san_pham sp JOIN danh_muc dm ON sp.danh_muc_id = dm.id WHERE sp.nguoi_dung_id = ?";
        $params = [$user_id];

        if ($trang_thai !== 'tat_ca' && !empty($trang_thai)) {
            $sql .= " AND sp.trang_thai = ?";
            $params[] = $trang_thai;
        }

        $sql .= " ORDER BY sp.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $items]);
    } else {
        echo json_encode(['success' => true, 'data' => []]);
    }
    exit;
}
?>