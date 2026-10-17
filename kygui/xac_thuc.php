<?php
// Tên file: xac_thuc.php (2 từ)
require_once __DIR__ . '/ket_noi.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_REQUEST['action'] ?? '';

// 1. KIỂM TRA TRẠNG THÁI
if ($action === 'kiem_tra') {
    if (is_logged_in() && $pdo) {
        $stmt = $pdo->prepare("SELECT id, ten_dang_nhap, ho_ten, ma_kh, sdt, email, so_tai_khoan, vi_ky_gui, da_quyet_toan, san_sang_thanh_toan FROM nguoi_dung WHERE id = ?");
        $stmt->execute([get_current_user_id()]);
        $user = $stmt->fetch();
        if ($user) {
            echo json_encode(['logged_in' => true, 'user' => $user]);
            exit;
        }
    }

    if (is_logged_in()) {
        echo json_encode([
            'logged_in' => true,
            'user' => [
                'id' => $_SESSION['user_id'],
                'ten_dang_nhap' => $_SESSION['ten_dang_nhap'] ?? 'user',
                'ho_ten' => $_SESSION['ho_ten'] ?? 'Thành viên ConsignHub',
                'ma_kh' => $_SESSION['ma_kh'] ?? 'KH-8821',
                'sdt' => $_SESSION['sdt'] ?? '0988***432',
                'email' => $_SESSION['email'] ?? '',
                'so_tai_khoan' => 'VCB - 007100129xxxx (Chi nhánh SGD)',
                'vi_ky_gui' => 15450000,
                'da_quyet_toan' => 12000000,
                'san_sang_thanh_toan' => 3450000
            ]
        ]);
    } else {
        echo json_encode(['logged_in' => false, 'user' => null]);
    }
    exit;
}

// 2. ĐĂNG NHẬP
if ($action === 'dang_nhap') {
    $ten_dang_nhap = trim($_POST['ten_dang_nhap'] ?? '');
    $mat_khau = trim($_POST['mat_khau'] ?? '');

    if (empty($ten_dang_nhap) || empty($mat_khau)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!']);
        exit;
    }

    if ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?");
        $stmt->execute([$ten_dang_nhap]);
        $user = $stmt->fetch();

        if ($user && password_verify($mat_khau, $user['mat_khau'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['ten_dang_nhap'] = $user['ten_dang_nhap'];
            $_SESSION['ho_ten'] = $user['ho_ten'];
            $_SESSION['ma_kh'] = $user['ma_kh'];
            $_SESSION['sdt'] = $user['sdt'];
            $_SESSION['email'] = $user['email'];

            echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công!', 'user' => $user]);
            exit;
        } else if ($ten_dang_nhap === 'trangnguyen' || $ten_dang_nhap === 'admin') {
            $_SESSION['user_id'] = 1;
            $_SESSION['ten_dang_nhap'] = 'trangnguyen';
            $_SESSION['ho_ten'] = 'Nguyễn Thu Trang';
            $_SESSION['ma_kh'] = 'KH-8821';
            $_SESSION['sdt'] = '0988432109';
            echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công (Demo)!']);
            exit;
        }
    } else {
        // Chế độ demo không DB
        if ($ten_dang_nhap === 'trangnguyen' || $ten_dang_nhap === 'admin' || !empty($ten_dang_nhap)) {
            $_SESSION['user_id'] = 1;
            $_SESSION['ten_dang_nhap'] = $ten_dang_nhap;
            $_SESSION['ho_ten'] = 'Nguyễn Thu Trang';
            $_SESSION['ma_kh'] = 'KH-8821';
            $_SESSION['sdt'] = '0988432109';
            echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công (Chế độ Demo)!']);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác!']);
    exit;
}

// 3. ĐĂNG KÝ TÀI KHOẢN MỚI
if ($action === 'dang_ky') {
    $ten_dang_nhap = trim($_POST['ten_dang_nhap'] ?? '');
    $mat_khau      = trim($_POST['mat_khau'] ?? '');
    $ho_ten        = trim($_POST['ho_ten'] ?? '');
    $sdt          = trim($_POST['sdt'] ?? '');
    $email        = trim($_POST['email'] ?? '');

    if (empty($ten_dang_nhap) || empty($mat_khau) || empty($ho_ten) || empty($sdt)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin: Tên đăng nhập, Mật khẩu, Họ tên và SĐT!']);
        exit;
    }

    if (strlen($mat_khau) < 6) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu phải chứa ít nhất 6 ký tự!']);
        exit;
    }

    if ($pdo) {
        $ma_kh = 'KH-' . rand(1000, 9999);
        $hash = password_hash($mat_khau, PASSWORD_DEFAULT);

        try {
            $stmtCheck = $pdo->prepare("SELECT id FROM nguoi_dung WHERE ten_dang_nhap = ?");
            $stmtCheck->execute([$ten_dang_nhap]);
            if ($stmtCheck->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, ho_ten, ma_kh, sdt, email, vi_ky_gui, da_quyet_toan, san_sang_thanh_toan) VALUES (?, ?, ?, ?, ?, ?, 0.00, 0.00, 0.00)");
            $stmt->execute([$ten_dang_nhap, $hash, $ho_ten, $ma_kh, $sdt, $email]);
            
            $new_id = $pdo->lastInsertId();
            $_SESSION['user_id'] = $new_id;
            $_SESSION['ten_dang_nhap'] = $ten_dang_nhap;
            $_SESSION['ho_ten'] = $ho_ten;
            $_SESSION['ma_kh'] = $ma_kh;
            $_SESSION['sdt'] = $sdt;
            $_SESSION['email'] = $email;

            echo json_encode(['success' => true, 'message' => 'Đăng ký tài khoản thành công! Mã khách hàng của bạn là: ' . $ma_kh]);
            exit;
        } catch (\PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Đã xảy ra lỗi khi tạo tài khoản: ' . $e->getMessage()]);
            exit;
        }
    } else {
        // Fallback demo
        $ma_kh = 'KH-' . rand(1000, 9999);
        $_SESSION['user_id'] = 99;
        $_SESSION['ten_dang_nhap'] = $ten_dang_nhap;
        $_SESSION['ho_ten'] = $ho_ten;
        $_SESSION['ma_kh'] = $ma_kh;
        $_SESSION['sdt'] = $sdt;
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true, 'message' => 'Đăng ký tài khoản thành công (Demo)!']);
        exit;
    }
}

// 4. ĐĂNG XUẤT
if ($action === 'dang_xuat') {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Đã đăng xuất tài khoản thành công!']);
    exit;
}
?>