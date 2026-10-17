<?php
// Tên file: trang_chu.php (2 từ)
require_once __DIR__ . '/ket_noi.php';

// Lấy danh sách sản phẩm từ MySQL
$san_pham_list = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT sp.*, dm.ten_danh_muc, nd.ho_ten AS nguoi_dang 
                        FROM san_pham sp 
                        JOIN danh_muc dm ON sp.danh_muc_id = dm.id 
                        JOIN nguoi_dung nd ON sp.nguoi_dung_id = nd.id 
                        ORDER BY sp.id DESC");
    $san_pham_list = $stmt->fetchAll();
}

// Nếu chưa có dữ liệu CSDL, sử dụng danh sách 24 sản phẩm mẫu
if (empty($san_pham_list)) {
    $san_pham_list = [
        // THỜI TRANG & PHỤ KIỆN (8 sản phẩm)
        ['id' => 1, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Túi xách Coach da nâu Canvas Signature', 'gia_nhan' => 1875000, 'gia_niem_yet' => 2500000, 'tinh_trang' => 'Mới 95%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'da_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80'],
        ['id' => 2, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Áo Blazer thiết kế Chic Studio Size M', 'gia_nhan' => 1480000, 'gia_niem_yet' => 1850000, 'tinh_trang' => 'Mới 98%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=600&q=80'],
        ['id' => 3, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Áo khoác dạ Zara Size M Camel', 'gia_nhan' => 600000, 'gia_niem_yet' => 850000, 'tinh_trang' => 'Mới 90%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?auto=format&fit=crop&w=600&q=80'],
        ['id' => 4, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Balo MCM Stark Backpack Cognac', 'gia_nhan' => 6800000, 'gia_niem_yet' => 8500000, 'tinh_trang' => 'Mới 97%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80'],
        ['id' => 5, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Kính mát Gentle Monster Her 01', 'gia_nhan' => 3200000, 'gia_niem_yet' => 4200000, 'tinh_trang' => 'Mới 99%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=600&q=80'],
        ['id' => 6, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Túi xách Gucci Dionysus Mini GG', 'gia_nhan' => 14000000, 'gia_niem_yet' => 17500000, 'tinh_trang' => 'Mới 96%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=600&q=80'],
        ['id' => 7, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Đồng hồ nam Tissot Le Locle Automatic', 'gia_nhan' => 7100000, 'gia_niem_yet' => 8900000, 'tinh_trang' => 'Mới 98%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=80'],
        ['id' => 8, 'danh_muc_id' => 1, 'ten_danh_muc' => 'Thời trang & phụ kiện', 'ten_san_pham' => 'Ví cầm tay Pedro Leather Fold Wallet', 'gia_nhan' => 750000, 'gia_niem_yet' => 990000, 'tinh_trang' => 'Mới 95%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=600&q=80'],

        // ĐỒ CÔNG NGHỆ (8 sản phẩm)
        ['id' => 9, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Bàn phím cơ Custom Keychron Q1 Pro', 'gia_nhan' => 3000000, 'gia_niem_yet' => 3750000, 'tinh_trang' => 'Mới 99%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80'],
        ['id' => 10, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Tai nghe Sony WH-1000XM4 xám', 'gia_nhan' => 4000000, 'gia_niem_yet' => 4990000, 'tinh_trang' => 'Mới 97%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80'],
        ['id' => 11, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Máy ảnh Sony A6400 Kit 16-50mm', 'gia_nhan' => 12200000, 'gia_niem_yet' => 15200000, 'tinh_trang' => 'Mới 98%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=600&q=80'],
        ['id' => 12, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'iPad Air 5 M1 64GB WiFi Starlight', 'gia_nhan' => 10500000, 'gia_niem_yet' => 12900000, 'tinh_trang' => 'Mới 99%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80'],
        ['id' => 13, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Loa Bluetooth Marshall Stanmore II', 'gia_nhan' => 5200000, 'gia_niem_yet' => 6500000, 'tinh_trang' => 'Mới 96%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=600&q=80'],
        ['id' => 14, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Nintendo Switch OLED White Fullbox', 'gia_nhan' => 5800000, 'gia_niem_yet' => 7200000, 'tinh_trang' => 'Mới 98%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?auto=format&fit=crop&w=600&q=80'],
        ['id' => 15, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Chuột máy tính Logitech MX Master 3S', 'gia_nhan' => 1600000, 'gia_niem_yet' => 2100000, 'tinh_trang' => 'Mới 99%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=600&q=80'],
        ['id' => 16, 'danh_muc_id' => 2, 'ten_danh_muc' => 'Đồ công nghệ', 'ten_san_pham' => 'Tai nghe Apple AirPods Pro 2 USB-C', 'gia_nhan' => 3900000, 'gia_niem_yet' => 4800000, 'tinh_trang' => 'Mới 98%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&w=600&q=80'],

        // GIÀY DÉP (8 sản phẩm)
        ['id' => 17, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày sneaker MLB Chunky Liner Size 38.5', 'gia_nhan' => 1050000, 'gia_niem_yet' => 1400000, 'tinh_trang' => 'Mới 95%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80'],
        ['id' => 18, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày cao gót Charles & Keith Size 37', 'gia_nhan' => 450000, 'gia_niem_yet' => 600000, 'tinh_trang' => 'Mới 90%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'cho_duyet_het_hang', 'hinh_anh' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=600&q=80'],
        ['id' => 19, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày Jordan 1 Retro High OG Chicago 42', 'gia_nhan' => 3800000, 'gia_niem_yet' => 4650000, 'tinh_trang' => 'Mới 97%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=600&q=80'],
        ['id' => 20, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày Nike Air Force 1 07 White 41', 'gia_nhan' => 1600000, 'gia_niem_yet' => 2100000, 'tinh_trang' => 'Mới 96%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=600&q=80'],
        ['id' => 21, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày Adidas Ultraboost Light Size 42', 'gia_nhan' => 2200000, 'gia_niem_yet' => 2900000, 'tinh_trang' => 'Mới 98%', 'nguoi_dang' => 'Trần Hải Yến', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80'],
        ['id' => 22, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày Christian Louboutin Kate 85mm', 'gia_nhan' => 11000000, 'gia_niem_yet' => 14200000, 'tinh_trang' => 'Mới 95%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1596568359553-a56de6970068?auto=format&fit=crop&w=600&q=80'],
        ['id' => 23, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày New Balance 530 White Silver 39', 'gia_nhan' => 1800000, 'gia_niem_yet' => 2350000, 'tinh_trang' => 'Mới 97%', 'nguoi_dang' => 'Đỗ Tuấn Kiệt', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=600&q=80'],
        ['id' => 24, 'danh_muc_id' => 3, 'ten_danh_muc' => 'Giày dép', 'ten_san_pham' => 'Giày lười Loafer Pedro Calfskin 40', 'gia_nhan' => 1250000, 'gia_niem_yet' => 1650000, 'tinh_trang' => 'Mới 96%', 'nguoi_dang' => 'Nguyễn Thu Trang', 'trang_thai' => 'dang_ban', 'hinh_anh' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=600&q=80'],
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sàn Đồ Ký Gửi - ConsignHub</title>
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
                    <a href="trang_chu.php" class="text-blue-600 font-semibold">Sàn Ký Gửi</a>
                    <a href="trang_ca_nhan.php" class="hover:text-blue-600 transition-colors">Trang Cá Nhân & Đăng Đồ</a>
                    <a href="trang_ho_tro.php" class="hover:text-blue-600 transition-colors">Hỗ Trợ</a>
                </nav>
            </div>

            <div class="flex items-center gap-4 flex-1 max-w-md justify-end">
                <div class="relative w-full max-w-xs">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="text" id="tim-kiem-san-pham" placeholder="Tìm kiếm sản phẩm ký gửi gần giống nhất..." 
                           class="w-full h-10 pl-9 pr-4 rounded-lg bg-slate-100 border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all">
                </div>

                <div id="nav-login-btn">
                    <button onclick="openModal('modal-dang-nhap')" class="h-10 px-4 rounded-lg bg-blue-600 text-white font-medium text-sm hover:bg-blue-700 transition-colors shadow-sm whitespace-nowrap">
                        Đăng nhập
                    </button>
                </div>

                <div id="nav-user-profile" class="hidden flex items-center gap-2">
                    <a href="trang_ca_nhan.php" class="flex items-center gap-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" class="w-8 h-8 rounded-full object-cover ring-2 ring-blue-500/20" alt="Avatar">
                        <span id="user-name-display" class="text-sm font-semibold text-slate-800 hidden sm:inline-block">Nguyễn Thu Trang</span>
                    </a>
                    <button onclick="thucHienDangXuat()" title="Đăng xuất" class="p-1.5 rounded-lg text-slate-500 hover:text-red-600 hover:bg-slate-100 transition-colors">
                        <span class="material-symbols-outlined text-lg">logout</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 pt-20 pb-16">
        <div class="max-w-7xl mx-auto px-4 space-y-8">
            
            <!-- HERO BANNER -->
            <div class="bg-gradient-to-r from-blue-900 to-indigo-800 rounded-2xl p-6 md:p-10 text-white shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                <div class="space-y-2 max-w-2xl relative z-10">
                    <span class="inline-block px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs uppercase tracking-wider font-semibold">
                        Sàn ký gửi C2C minh bạch & kiểm định
                    </span>
                    <h1 class="text-2xl md:text-4xl font-bold tracking-tight">Sàn Đồ Ký Gửi Cá Nhân Tuyển Chọn</h1>
                    <p class="text-blue-100 text-sm md:text-base">Mỗi món đồ ký gửi đều trải qua quy trình kiểm duyệt chất lượng 5 bước trước khi niêm yết công khai.</p>
                </div>
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/15 shrink-0 relative z-10">
                    <div>
                        <div class="text-xl font-bold">100% Auth</div>
                        <div class="text-xs text-blue-200">Thẩm định vật lý</div>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div>
                        <div class="text-xl font-bold">Escrow 48h</div>
                        <div class="text-xs text-blue-200">Tạm giữ an toàn</div>
                    </div>
                </div>
            </div>

            <!-- CATEGORY FILTER BAR (MỤC NHỎ: Tất cả, Thời trang & phụ kiện, Đồ công nghệ, Giày dép) -->
            <div class="bg-white p-2 rounded-xl shadow-sm border border-slate-200 flex items-center gap-2 overflow-x-auto">
                <button data-cat-id="0" class="danh-muc-btn active px-4 py-2 rounded-lg text-sm font-medium bg-blue-600 text-white transition-all whitespace-nowrap">
                    Tất cả (<?= count($san_pham_list) ?>)
                </button>
                <button data-cat-id="1" class="danh-muc-btn px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-all whitespace-nowrap">
                    Thời trang & phụ kiện
                </button>
                <button data-cat-id="2" class="danh-muc-btn px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-all whitespace-nowrap">
                    Đồ công nghệ
                </button>
                <button data-cat-id="3" class="danh-muc-btn px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-all whitespace-nowrap">
                    Giày dép
                </button>
            </div>

            <!-- PRODUCT SHOWCASE GRID (HIỂN THỊ 24 SẢN PHẨM CHIA ĐỀU) -->
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Đồ Ký Gửi Đang Mở Bán
                    </h2>
                </div>

                <div id="no-product-msg" class="hidden col-span-full text-center py-12 text-slate-500 font-medium">
                    Không tìm thấy sản phẩm nào gần giống nhất với từ khóa tìm kiếm!
                </div>

                <div id="danh-sach-san-pham" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($san_pham_list as $sp): ?>
                        <article class="san-pham-card group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden border border-slate-100" 
                                 data-cat-id="<?= $sp['danh_muc_id'] ?>" data-title="<?= htmlspecialchars($sp['ten_san_pham']) ?>">
                            <div>
                                <div class="relative aspect-square overflow-hidden bg-slate-100">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= $sp['hinh_anh'] ?>" alt="<?= htmlspecialchars($sp['ten_san_pham']) ?>">
                                    <div class="absolute top-3 left-3 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm text-emerald-600 text-xs font-semibold shadow-sm">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <?= $sp['trang_thai'] === 'dang_ban' ? 'Đang mở bán' : ($sp['trang_thai'] === 'da_ban' ? 'Đã bán' : 'Chờ duyệt') ?>
                                    </div>
                                    <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-sm text-white text-xs font-medium">
                                        <?= $sp['tinh_trang'] ?>
                                    </div>
                                </div>

                                <div class="p-4 space-y-2">
                                    <div class="flex items-center gap-1.5 text-blue-600 text-xs font-semibold">
                                        <span class="material-symbols-outlined text-[15px]">verified</span>
                                        <?= htmlspecialchars($sp['ten_danh_muc'] ?? 'Thời trang') ?>
                                    </div>
                                    <h3 class="text-base font-semibold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                        <?= htmlspecialchars($sp['ten_san_pham']) ?>
                                    </h3>
                                    <div class="flex items-baseline gap-2 pt-1">
                                        <span class="text-lg font-bold text-slate-900"><?= number_format($sp['gia_niem_yet'], 0, ',', '.') ?> đ</span>
                                        <span class="text-xs text-slate-400 line-through"><?= number_format($sp['gia_nhan'] * 1.2, 0, ',', '.') ?> đ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 pt-0 space-y-3">
                                <div class="p-2 rounded-lg bg-slate-50 flex items-center justify-between">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            <?= mb_substr($sp['nguoi_dang'] ?? 'N', 0, 1) ?>
                                        </div>
                                        <span class="text-xs font-medium text-slate-800 truncate"><?= htmlspecialchars($sp['nguoi_dang'] ?? 'Người đăng') ?></span>
                                    </div>
                                    <span class="text-xs text-amber-500 font-semibold flex items-center gap-0.5">★ 4.9</span>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="openChatWidget(<?= $sp['id'] ?>, '<?= addslashes($sp['ten_san_pham']) ?>')" 
                                            class="h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center justify-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">chat_bubble_outline</span> Liên hệ
                                    </button>
                                    <button onclick="openBuyModal(<?= $sp['id'] ?>, '<?= addslashes($sp['ten_san_pham']) ?>', <?= $sp['gia_niem_yet'] ?>, '<?= addslashes($sp['nguoi_dang'] ?? 'Người đăng') ?>', '<?= $sp['hinh_anh'] ?>')" 
                                            class="h-9 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold flex items-center justify-center transition-colors shadow-sm">
                                        Mua ngay
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- PHẦN ĐÁNH GIÁ (BẮT BUỘC ĐĂNG NHẬP ĐỂ VIẾT) -->
            <section class="space-y-4 pt-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">rate_review</span>
                        Đánh Giá & Nhận Xét
                    </h2>
                    <button onclick="openReviewModal()" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition-colors shadow-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">edit</span> Viết đánh giá
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- KHỐI A: ĐÁNH GIÁ ĐỒ ĐÃ NHẬN -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600">inventory_2</span>
                                    Khối A: Đánh Giá Đồ Đã Nhận
                                </h3>
                                <p class="text-xs text-slate-500">Hình ảnh & cảm nhận thực tế từ người mua hàng</p>
                            </div>
                            <span class="text-sm font-bold text-emerald-600">99.4% Đúng mô tả</span>
                        </div>

                        <div class="space-y-3">
                            <div class="p-3.5 rounded-lg bg-slate-50 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-xs flex items-center justify-center">T</div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-900">Thái Nam Long</div>
                                            <div class="text-[11px] text-slate-500">Đã mua: Túi đeo chéo da YSL</div>
                                        </div>
                                    </div>
                                    <div class="text-amber-500 text-xs">★★★★★</div>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed">"Nhận hàng đóng gói cẩn thận 3 lớp bọc bong bóng. Túi nguyên form, da mềm xịn không một vết xước dăm nào."</p>
                            </div>

                            <div class="p-3.5 rounded-lg bg-slate-50 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-xs flex items-center justify-center">M</div>
                                        <div>
                                            <div class="text-xs font-bold text-slate-900">Mai Phương Thảo</div>
                                            <div class="text-[11px] text-slate-500">Đã mua: Tai nghe Sony WH-1000XM4</div>
                                        </div>
                                    </div>
                                    <div class="text-amber-500 text-xs">★★★★★</div>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed">"Độ mới đúng 98% như niêm yết, đầy đủ bao da dây cáp zin, nghe nhạc âm trầm ấm rất thích."</p>
                            </div>
                        </div>
                    </div>

                    <!-- KHỐI B: TRẢI NGHIỆM DỊCH VỤ SÀN -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-blue-600">verified_user</span>
                                    Khối B: Trải Nghiệm Dịch Vụ Sàn
                                </h3>
                                <p class="text-xs text-slate-500">Đánh giá chất lượng vận hành từ cộng đồng</p>
                            </div>
                            <span class="text-sm font-bold text-amber-500">★ 4.9 / 5.0</span>
                        </div>

                        <div class="space-y-3">
                            <div class="p-3.5 rounded-lg bg-slate-50 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-700 font-semibold text-[11px]">Người ký gửi</span>
                                        <span class="text-xs font-bold text-slate-900">Hoàng Minh Quân</span>
                                    </div>
                                    <span class="text-xs text-slate-400">2 ngày trước</span>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed">"Dịch vụ thẩm định tận nơi rất nhanh, đồ báo bán thành công là tiền về ví số dư chỉ sau đúng 30 phút!"</p>
                            </div>

                            <div class="p-3.5 rounded-lg bg-slate-50 space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 font-semibold text-[11px]">Người mua</span>
                                        <span class="text-xs font-bold text-slate-900">Lê Ngọc Diệp</span>
                                    </div>
                                    <span class="text-xs text-slate-400">5 ngày trước</span>
                                </div>
                                <p class="text-xs text-slate-700 leading-relaxed">"Thích nhất cơ chế giữ tiền trung gian (Escrow) của ConsignHub. Kiểm hàng 48h yên tâm tuyệt đối."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- FLOATING CHAT BUBBLE & WINDOW (LIÊN HỆ CHAT GÓC PHẢI THU NHỎ NỔI BONG BÓNG) -->
    <div id="chat-bubble" onclick="openChatWidget(0, '')" class="chat-bubble" title="Chat liên hệ">
        <span class="material-symbols-outlined text-2xl">chat</span>
    </div>

    <div id="chat-window" class="chat-window">
        <div class="chat-header">
            <span id="chat-product-title" class="text-sm font-semibold truncate max-w-[260px]">Chat liên hệ người bán</span>
            <button onclick="closeChatWidget()" class="text-white/80 hover:text-white text-lg font-bold" title="Thu nhỏ thành bong bóng">&times;</button>
        </div>
        <div id="chat-messages" class="chat-messages">
            <div class="chat-msg other">Xin chào! Bạn muốn tư vấn hoặc nhắn tin về món đồ ký gửi này ạ?</div>
        </div>
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." 
                   onkeypress="if(event.key==='Enter') guiTinNhanChat()"
                   class="flex-1 px-3 py-1.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-600">
            <button onclick="guiTinNhanChat()" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                Gửi
            </button>
        </div>
    </div>

    <!-- MODAL MUA NGAY -->
    <div id="modal-mua-ngay" class="modal-overlay">
        <div class="modal-card space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Xác Nhận Mua Hàng</h3>
                <button onclick="closeModal('modal-mua-ngay')" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>

            <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-lg border border-slate-100">
                <img id="buy-modal-image" src="" class="w-16 h-16 rounded-lg object-cover bg-slate-200" alt="">
                <div>
                    <h4 id="buy-modal-title" class="font-bold text-slate-900 text-sm line-clamp-1">---</h4>
                    <div class="text-xs text-slate-500">Người đăng: <span id="buy-modal-seller" class="font-semibold text-slate-700">---</span></div>
                    <div class="text-blue-600 font-bold text-base mt-0.5" id="buy-modal-price">0 đ</div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Phương thức thanh toán</label>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-blue-500 cursor-pointer transition-colors">
                        <input type="radio" name="phuong_thuc_tt" value="tien_mat" checked class="text-blue-600 focus:ring-blue-500">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Thanh toán tiền mặt khi nhận hàng (COD)</div>
                            <div class="text-[11px] text-slate-500">Thanh toán cho bưu tá khi đồng kiểm ngoại quan</div>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-blue-500 cursor-pointer transition-colors">
                        <input type="radio" name="phuong_thuc_tt" value="chuyen_khoan" class="text-blue-600 focus:ring-blue-500">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Chuyển khoản ngân hàng (VietQR Escrow)</div>
                            <div class="text-[11px] text-slate-500">Số tiền tạm giữ bảo vệ 48h cho đến khi hoàn tất</div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button onclick="closeModal('modal-mua-ngay')" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                    Hủy
                </button>
                <button onclick="xacNhanMuaNgay()" class="px-5 py-2 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 shadow-sm">
                    Xác nhận mua hàng
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL VIẾT ĐÁNH GIÁ -->
    <div id="modal-danh-gia" class="modal-overlay">
        <div class="modal-card space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Viết Đánh Giá Mới</h3>
                <button onclick="closeModal('modal-danh-gia')" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Đánh giá sao</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rate_stars" value="5" checked><label for="star5">★</label>
                        <input type="radio" id="star4" name="rate_stars" value="4"><label for="star4">★</label>
                        <input type="radio" id="star3" name="rate_stars" value="3"><label for="star3">★</label>
                        <input type="radio" id="star2" name="rate_stars" value="2"><label for="star2">★</label>
                        <input type="radio" id="star1" name="rate_stars" value="1"><label for="star1">★</label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Loại đánh giá</label>
                    <select id="review-type" class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                        <option value="dich_vu">Đánh giá Trải nghiệm Dịch vụ Sàn</option>
                        <option value="san_pham">Đánh giá Đồ đã nhận</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nội dung đánh giá</label>
                    <textarea id="review-content" rows="4" placeholder="Chia sẻ cảm nhận thực tế của bạn..." 
                              class="w-full p-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600 resize-none"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button onclick="closeModal('modal-danh-gia')" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">
                    Hủy
                </button>
                <button onclick="guiDanhGia()" class="px-5 py-2 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 shadow-sm">
                    Gửi đánh giá
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL ĐĂNG NHẬP / ĐĂNG KÝ CÓ TABS -->
    <div id="modal-dang-nhap" class="modal-overlay">
        <div class="modal-card space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <div class="flex items-center gap-4 w-full">
                    <button id="tab-btn-login" onclick="switchAuthTab('login')" class="flex-1 py-2 text-center text-xs font-bold border-b-2 border-blue-600 text-blue-600">
                        Đăng Nhập
                    </button>
                    <button id="tab-btn-register" onclick="switchAuthTab('register')" class="flex-1 py-2 text-center text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                        Đăng Ký Mới
                    </button>
                </div>
                <button onclick="closeModal('modal-dang-nhap')" class="text-slate-400 hover:text-slate-600 text-xl font-bold ml-2">&times;</button>
            </div>

            <!-- TAB ĐĂNG NHẬP -->
            <div id="login-form-box" class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tên đăng nhập</label>
                    <input type="text" id="login-username" value="trangnguyen" placeholder="Ví dụ: trangnguyen" 
                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mật khẩu</label>
                    <input type="password" id="login-password" value="password123" placeholder="Nhập mật khẩu" 
                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                </div>
                <div class="flex items-center justify-between pt-2">
                    <span class="text-[11px] text-slate-500">Demo: <b>trangnguyen</b> / <b>password123</b></span>
                    <button onclick="thucHienDangNhap()" class="px-5 py-2 rounded-lg bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 shadow-sm">
                        Đăng nhập
                    </button>
                </div>
            </div>

            <!-- TAB ĐĂNG KÝ -->
            <div id="register-form-box" class="space-y-3 hidden">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tên đăng nhập <span class="text-red-500">*</span></label>
                    <input type="text" id="reg-username" placeholder="Nhập tên đăng nhập mới" 
                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mật khẩu riêng <span class="text-red-500">*</span></label>
                    <input type="password" id="reg-password" placeholder="Tối thiểu 6 ký tự" 
                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" id="reg-fullname" placeholder="Ví dụ: Nguyễn Văn A" 
                           class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Số điện thoại <span class="text-red-500">*</span></label>
                        <input type="text" id="reg-phone" placeholder="0912..." 
                               class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" id="reg-email" placeholder="email@gmail.com" 
                               class="w-full h-10 px-3 border border-slate-200 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button onclick="thucHienDangKy()" class="px-5 py-2 rounded-lg bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 shadow-sm">
                        Đăng ký tài khoản
                    </button>
                </div>
            </div>
        </div>
    </div>

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
