<?php
// Tên file: trang_ca_nhan.php (3 từ)
require_once __DIR__ . '/ket_noi.php';

$logged_in = is_logged_in();
$user_id = get_current_user_id();

$user_info = null;
$my_items = [];

if ($logged_in && $pdo && $user_id) {
    // 1. Lấy thông tin cá nhân từ CSDL MySQL
    $stmt = $pdo->prepare("SELECT * FROM nguoi_dung WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_info = $stmt->fetch();

    // 2. Lấy đồ ký gửi của tôi từ MySQL
    $stmtItems = $pdo->prepare("SELECT sp.*, dm.ten_danh_muc 
                               FROM san_pham sp 
                               JOIN danh_muc dm ON sp.danh_muc_id = dm.id 
                               WHERE sp.nguoi_dung_id = ? 
                               ORDER BY sp.id DESC");
    $stmtItems->execute([$user_id]);
    $my_items = $stmtItems->fetchAll();
} else if ($logged_in) {
    // Fallback demo user
    $user_info = [
        'ho_ten' => $_SESSION['ho_ten'] ?? 'Nguyễn Thu Trang',
        'ma_kh' => $_SESSION['ma_kh'] ?? 'KH-8821',
        'sdt' => $_SESSION['sdt'] ?? '0988432109',
        'email' => $_SESSION['email'] ?? 'thutrang@gmail.com',
        'so_tai_khoan' => 'VCB - 007100129xxxx (Chi nhánh SGD)',
        'vi_ky_gui' => 15450000,
        'da_quyet_toan' => 12000000,
        'san_sang_thanh_toan' => 3450000
    ];

    $my_items = [
        ['id' => 1, 'ten_san_pham' => 'Túi xách Coach da nâu Canvas Signature', 'ten_danh_muc' => 'Thời trang & phụ kiện', 'tinh_trang' => 'Mới 95%', 'gia_nhan' => 1875000, 'gia_niem_yet' => 2500000, 'trang_thai' => 'da_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80'],
        ['id' => 2, 'ten_san_pham' => 'Áo Blazer thiết kế Chic Studio Size M', 'ten_danh_muc' => 'Thời trang & phụ kiện', 'tinh_trang' => 'Mới 98%', 'gia_nhan' => 1480000, 'gia_niem_yet' => 1850000, 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=600&q=80'],
        ['id' => 18, 'ten_san_pham' => 'Giày cao gót Charles & Keith Size 37', 'ten_danh_muc' => 'Giày dép', 'tinh_trang' => 'Mới 90%', 'gia_nhan' => 450000, 'gia_niem_yet' => 600000, 'trang_thai' => 'cho_duyet_het_hang', 'hinh_anh' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=600&q=80'],
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân & Đăng Đồ - ConsignHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="giao_dien.css">
    <script src="tuong_tac.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

    <!-- HEADER / NAVIGATION -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-8">
                <a href="trang_chu.php" class="flex items-center gap-2 font-bold text-xl text-blue-700 tracking-tight">
                    <span class="material-symbols-outlined text-2xl">storefront</span> ConsignHub
                </a>
                <nav class="hidden md:flex items-center gap-6 font-medium text-sm text-slate-600">
                    <a href="trang_chu.php" class="hover:text-blue-600 transition-colors">Sàn Ký Gửi</a>
                    <a href="trang_ca_nhan.php" class="text-blue-600 font-semibold">Trang Cá Nhân & Đăng Đồ</a>
                    <a href="trang_ho_tro.php" class="hover:text-blue-600 transition-colors">Hỗ Trợ</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <?php if ($logged_in && $user_info): ?>
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" class="w-8 h-8 rounded-full object-cover ring-2 ring-blue-500/20" alt="Avatar">
                        <span class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($user_info['ho_ten']) ?></span>
                        <button onclick="thucHienDangXuat()" title="Đăng xuất" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-lg">logout</span>
                        </button>
                    </div>
                <?php else: ?>
                    <button onclick="openModal('modal-dang-nhap')" class="h-10 px-4 rounded-lg bg-blue-600 text-white font-medium text-sm hover:bg-blue-700 transition-colors shadow-sm">
                        Đăng nhập / Đăng ký
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 pt-20 pb-16">
        <div class="max-w-7xl mx-auto px-4 space-y-8">

            <?php if (!$logged_in): ?>
                <!-- BẮT BUỘC ĐĂNG NHẬP HOẶC ĐĂNG KÝ MỚI VÀO TRANG CÁ NHÂN & ĐĂNG ĐỒ -->
                <section class="max-w-lg mx-auto py-12">
                    <div class="bg-white rounded-2xl p-8 shadow-md border border-slate-200 space-y-6">
                        <div class="text-center space-y-2">
                            <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined text-3xl">lock</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">Yêu Cầu Đăng Nhập</h2>
                            <p class="text-xs text-slate-500">Bạn cần đăng nhập tài khoản hoặc đăng ký mới để truy cập Trang Cá Nhân & Đăng Đồ ký gửi.</p>
                        </div>

                        <!-- TABS ĐĂNG NHẬP / ĐĂNG KÝ -->
                        <div class="flex items-center border-b border-slate-200">
                            <button id="page-tab-login" onclick="switchAuthTab('login')" class="flex-1 py-2.5 text-center text-sm font-bold border-b-2 border-blue-600 text-blue-600">
                                Đăng Nhập
                            </button>
                            <button id="page-tab-register" onclick="switchAuthTab('register')" class="flex-1 py-2.5 text-center text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                                Đăng Ký Tài Khoản Mới
                            </button>
                        </div>

                        <!-- FORM ĐĂNG NHẬP -->
                        <div id="login-form-box" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tên đăng nhập</label>
                                <input type="text" id="login-username" value="trangnguyen" placeholder="Nhập tên đăng nhập" 
                                       class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Mật khẩu riêng</label>
                                <input type="password" id="login-password" value="password123" placeholder="Nhập mật khẩu" 
                                       class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <span class="text-[11px] text-slate-500">Demo: <b>trangnguyen</b> / <b>password123</b></span>
                                <button onclick="thucHienDangNhap()" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition-colors">
                                    Đăng nhập ngay
                                </button>
                            </div>
                        </div>

                        <!-- FORM ĐĂNG KÝ MỚI -->
                        <div id="register-form-box" class="space-y-4 hidden">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tên đăng nhập mới <span class="text-red-500">*</span></label>
                                <input type="text" id="reg-username" placeholder="Ví dụ: myuser123" 
                                       class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Mật khẩu riêng <span class="text-red-500">*</span></label>
                                <input type="password" id="reg-password" placeholder="Tối thiểu 6 ký tự" 
                                       class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                                <input type="text" id="reg-fullname" placeholder="Ví dụ: Nguyễn Văn A" 
                                       class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                                    <input type="text" id="reg-phone" placeholder="0912..." 
                                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                                    <input type="email" id="reg-email" placeholder="email@gmail.com" 
                                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button onclick="thucHienDangKy()" class="w-full py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-colors">
                                    Tạo tài khoản mới
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <!-- KHI ĐÃ ĐĂNG NHẬP: HIỂN THỊ TRANG CÁ NHÂN & ĐĂNG ĐỒ -->

                <!-- PHẦN 1: THÔNG TIN CÁ NHÂN & CÁC THẺ VÍ MYSQL -->
                <section class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" class="w-16 h-16 rounded-full object-cover shadow-sm ring-4 ring-slate-100" alt="Avatar">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h1 class="text-2xl font-bold text-slate-900"><?= htmlspecialchars($user_info['ho_ten']) ?></h1>
                                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">Mã: <?= htmlspecialchars($user_info['ma_kh']) ?></span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">verified</span> Ký gửi VIP
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-xs text-slate-500 flex-wrap">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-slate-400">call</span> SĐT: <?= htmlspecialchars($user_info['sdt']) ?>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-slate-400">account_balance</span> STK: <?= htmlspecialchars($user_info['so_tai_khoan'] ?? 'VCB - 007100129xxxx (Chi nhánh SGD)') ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button onclick="thucHienDangXuat()" class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-700 hover:text-red-600 text-xs font-bold transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">logout</span> Đăng xuất
                        </button>
                    </div>

                    <!-- Wallet Overview Metrics Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Ví ký gửi & Quyết toán -->
                        <div class="lg:col-span-5 bg-gradient-to-br from-blue-700 to-indigo-800 text-white rounded-2xl p-6 shadow-md flex flex-col justify-between relative overflow-hidden">
                            <div class="space-y-1 relative z-10">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs uppercase font-semibold text-blue-200 tracking-wider">Ví Ký Gửi & Quyết Toán</span>
                                    <span class="material-symbols-outlined text-blue-200">account_balance_wallet</span>
                                </div>
                                <p class="text-xs text-blue-100">Lưu trữ chính xác trong CSDL MySQL</p>
                                <div class="text-3xl font-extrabold pt-2"><?= number_format($user_info['vi_ky_gui'], 0, ',', '.') ?> <span class="text-lg font-normal">đ</span></div>
                            </div>
                            <div class="pt-4 border-t border-white/10 text-xs text-blue-100 flex items-center justify-between">
                                <span>Tỷ lệ hoàn tất bán đồ: <strong>83.3%</strong></span>
                                <span class="text-emerald-300 font-semibold">+3.450.000 đ tháng này</span>
                            </div>
                        </div>

                        <!-- Đã quyết toán -->
                        <div class="lg:col-span-3 bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-slate-400">
                                    <span class="text-xs uppercase font-semibold text-slate-500 tracking-wider">Đã quyết toán</span>
                                    <span class="material-symbols-outlined text-emerald-500 text-xl">check_circle</span>
                                </div>
                                <p class="text-xs text-slate-500">Số tiền đã chuyển thành công về STK</p>
                                <div class="text-2xl font-bold text-slate-900 pt-1"><?= number_format($user_info['da_quyet_toan'], 0, ',', '.') ?> <span class="text-xs text-slate-400 font-normal">đ</span></div>
                            </div>
                            <div class="pt-2 text-[11px] text-slate-400">Giao dịch đã xác thực</div>
                        </div>

                        <!-- Sẵn sàng thanh toán -->
                        <div class="lg:col-span-4 bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-slate-400">
                                    <span class="text-xs uppercase font-semibold text-slate-500 tracking-wider">Sẵn sàng thanh toán</span>
                                    <span class="material-symbols-outlined text-blue-600 text-xl">schedule</span>
                                </div>
                                <p class="text-xs text-slate-500">Số tiền chờ nhận đợt quyết toán tới</p>
                                <div class="text-2xl font-bold text-blue-600 pt-1"><?= number_format($user_info['san_sang_thanh_toan'], 0, ',', '.') ?> <span class="text-xs text-slate-400 font-normal">đ</span></div>
                            </div>
                            <div class="pt-3">
                                <button onclick="alert('Đã gửi yêu cầu rút tiền thành công!')" class="w-full h-9 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-base">payments</span> Rút tiền ngay
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- PHẦN 2: FORM ĐĂNG KÝ GỬI MÓN ĐỒ MỚI (LƯU MYSQL & FOLDER LƯU ẢNH LOCAL) -->
                <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200 space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <span class="text-xs uppercase font-bold text-blue-600 tracking-wider">Ký gửi đồ hiệu & sản phẩm cá nhân</span>
                        <h2 id="tieu-de-form-dang-do" class="text-2xl font-bold text-slate-900">Đăng Ký Gửi Món Đồ Mới</h2>
                        <p class="text-xs text-slate-500 mt-1">Sản phẩm sẽ được thẩm định và lưu thông tin trực tiếp vào dữ liệu MySQL.</p>
                    </div>

                    <form id="form-dang-do" class="space-y-6">
                        <input type="hidden" name="san_pham_id" value="">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            <!-- Cột nhập text/thông tin (7 Cột) -->
                            <div class="lg:col-span-7 space-y-4">
                                <!-- Tên món đồ -->
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Tên món đồ cần gửi bán <span class="text-red-500">*</span></label>
                                    <input type="text" name="ten_san_pham" required placeholder="VD: Túi Coach Dionysus, Bàn phím Keychron Q1, Giày Jordan 1..." 
                                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600 transition-colors">
                                </div>

                                <!-- Danh mục phân loại (Thời trang & phụ kiện, Đồ công nghệ, Giày dép) & Tình trạng -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold text-slate-700">Danh mục phân loại <span class="text-red-500">*</span></label>
                                        <select name="danh_muc_id" required class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                                            <option value="1">Thời trang & phụ kiện</option>
                                            <option value="2">Đồ công nghệ</option>
                                            <option value="3">Giày dép</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold text-slate-700">Tình trạng ước tính <span class="text-red-500">*</span></label>
                                        <select name="tinh_trang" required class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600">
                                            <option value="Mới 100%">Mới 100% (Nguyên hộp/tag)</option>
                                            <option value="Mới 98%" selected>Mới 98% (Like new, dùng lướt 1-2 lần)</option>
                                            <option value="Mới 95%">Mới 95% (Rất tốt, ít vết xước mờ)</option>
                                            <option value="Mới 90%">Mới 90% (Có dấu vết sử dụng nhẹ)</option>
                                            <option value="Mới 85%">Mới 85% (Tình trạng trung bình khá)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Mô tả -->
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Mô tả phụ kiện kèm theo & ghi chú khiếm khuyết</label>
                                    <textarea name="mo_ta" rows="3" placeholder="Ví dụ: Còn đầy đủ hóa đơn mua tại Tràng Tiền Plaza, hộp sổ nguyên vẹn..." 
                                              class="w-full p-3 border border-slate-200 rounded-lg text-sm text-slate-800 focus:outline-none focus:border-blue-600 resize-none"></textarea>
                                </div>

                                <!-- Giá bạn muốn nhận về & Shop đề xuất niêm yết -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold text-slate-700">Giá bạn muốn nhận về (đ) <span class="text-red-500">*</span></label>
                                        <input type="number" id="gia_nhan_input" name="gia_nhan" required placeholder="2000000" 
                                               oninput="document.getElementById('gia_niem_yet_input').value = Math.round(this.value * 1.25)"
                                               class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm font-bold text-blue-600 focus:outline-none focus:border-blue-600">
                                        <p class="text-[11px] text-slate-500">Số tiền thực chuyển vào tài khoản của bạn khi bán xong</p>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold text-slate-700">Shop đề xuất niêm yết (đ)</label>
                                        <input type="number" id="gia_niem_yet_input" name="gia_niem_yet" placeholder="2500000" 
                                               class="w-full h-10 px-3 border border-slate-200 rounded-lg text-sm font-bold text-slate-800 bg-white focus:outline-none focus:border-blue-600">
                                        <p class="text-[11px] text-emerald-600 font-medium">Bao gồm hoa hồng dịch vụ & bảo hiểm niêm yết</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Ảnh (Lưu riêng trong folder trên máy) -->
                            <div class="lg:col-span-5 space-y-2 flex flex-col">
                                <label class="block text-xs font-bold text-slate-700">Tải ảnh sản phẩm (Tải lên và lưu trong folder trên máy)</label>
                                <div id="anh-san-pham-hien-tai" class="hidden items-center gap-3 rounded-lg border border-slate-200 p-2">
                                    <img id="anh-san-pham-preview" src="" alt="Ảnh sản phẩm hiện tại" class="h-16 w-16 rounded-md object-cover">
                                    <span class="text-xs text-slate-500">Ảnh hiện tại sẽ được giữ nguyên nếu bạn không chọn ảnh mới.</span>
                                </div>
                                <div class="flex-1 border-2 border-dashed border-slate-300 hover:border-blue-500 bg-slate-50 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer transition-colors relative min-h-[220px]">
                                    <input type="file" name="hinh_anh" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                    <span class="material-symbols-outlined text-4xl text-blue-600 mb-2">cloud_upload</span>
                                    <p class="text-xs font-bold text-slate-800">Bấm chọn tệp ảnh hoặc kéo thả vào đây</p>
                                    <p class="text-[11px] text-slate-500 mt-1">Ảnh sẽ được lưu riêng vào thư mục <code>uploads/</code> trên máy và cập nhật đường dẫn vào MySQL.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2 border-t border-slate-100">
                            <button id="huy-sua-do" type="button" onclick="huySuaDoKyGui()" class="hidden px-6 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition-colors">
                                Hủy chỉnh sửa
                            </button>
                            <button id="nut-gui-do" type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md transition-colors flex items-center gap-2">
                                <span id="nhan-nut-gui-do">Gửi Duyệt Món Đồ Ký Gửi</span>
                                <span class="material-symbols-outlined text-lg">send</span>
                            </button>
                        </div>
                    </form>
                </section>

                <!-- PHẦN 3: ĐỒ KÝ GỬI CỦA TÔI (LẤY DỮ LIỆU CÓ TRONG MYSQL) -->
                <section class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">Đồ Ký Gửi Của Tôi</h2>
                            <p class="text-xs text-slate-500">Hiển thị dữ liệu thực tế lưu trữ trong CSDL MySQL</p>
                        </div>

                        <!-- Các mục nhỏ: Tất cả, Đang bán, Đã bán, Chờ duyệt/hết hàng -->
                        <div class="flex items-center p-1 bg-slate-200/80 rounded-xl overflow-x-auto text-xs font-semibold">
                            <button data-status="tat_ca" class="tab-do-toi active px-3.5 py-1.5 rounded-lg bg-white text-blue-700 shadow-sm whitespace-nowrap">Tất cả</button>
                            <button data-status="dang_ban" class="tab-do-toi px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 whitespace-nowrap">Đang bán</button>
                            <button data-status="da_ban" class="tab-do-toi px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 whitespace-nowrap">Đã bán</button>
                            <button data-status="cho_duyet_het_hang" class="tab-do-toi px-3.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 whitespace-nowrap">Chờ duyệt / Hết hàng</button>
                        </div>
                    </div>

                    <div id="danh-sach-do-cua-toi" class="space-y-3">
                        <?php foreach ($my_items as $item): ?>
                            <div class="bg-white rounded-xl p-4 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border border-slate-100">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-slate-100 shrink-0">
                                        <img src="<?= htmlspecialchars($item['hinh_anh'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover" alt="">
                                    </div>
                                    <div class="min-w-0 space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $item['trang_thai'] === 'da_ban' ? 'bg-emerald-100 text-emerald-700' : ($item['trang_thai'] === 'dang_ban' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') ?>">
                                                <?= $item['trang_thai'] === 'da_ban' ? 'ĐÃ BÁN' : ($item['trang_thai'] === 'dang_ban' ? 'ĐANG BÁN' : 'CHỜ DUYỆT / HẾT HẠN') ?>
                                            </span>
                                        </div>
                                        <h3 class="font-semibold text-slate-900 truncate"><?= htmlspecialchars($item['ten_san_pham']) ?></h3>
                                        <p class="text-xs text-slate-500"><?= htmlspecialchars($item['ten_danh_muc'] ?? 'Thời trang', ENT_QUOTES, 'UTF-8') ?> • Tình trạng <?= htmlspecialchars($item['tinh_trang'], ENT_QUOTES, 'UTF-8') ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between w-full md:w-auto gap-6 shrink-0">
                                    <div class="text-left md:text-right">
                                        <div class="text-xs text-slate-400">Giá niêm yết: <?= number_format($item['gia_niem_yet'], 0, ',', '.') ?> đ</div>
                                        <div class="font-bold text-blue-600">Thực nhận: <?= number_format($item['gia_nhan'], 0, ',', '.') ?> đ</div>
                                    </div>
                                    <button type="button"
                                            data-item="<?= rawurlencode(json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG)) ?>"
                                            data-action="edit"
                                            class="px-3 py-2 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-base">edit</span> Chỉnh sửa
                                    </button>
                                    <button type="button" data-product-id="<?= (int) $item['id'] ?>" data-action="delete"
                                            class="px-3 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 text-xs font-bold transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-base">delete</span> Xóa
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>© 2026 ConsignHub. Nền tảng ký gửi đồ cá nhân minh bạch & uy tín.</p>
            <div class="flex items-center gap-4">
                <a href="trang_ho_tro.php" class="hover:text-slate-800">Điều khoản sử dụng</a>
                <a href="trang_ho_tro.php" class="hover:text-slate-800">Bảo mật thông tin</a>
            </div>
        </div>
    </footer>

</body>
</html>
