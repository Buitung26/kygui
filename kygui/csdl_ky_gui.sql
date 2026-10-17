-- Cơ sở dữ liệu Web Quản lý Hàng hóa Ký gửi (ConsignHub)
-- Tên file: csdl_ky_gui.sql (2 từ)

CREATE DATABASE IF NOT EXISTS `ql_hang_ky_gui` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ql_hang_ky_gui`;

DROP TABLE IF EXISTS `danh_gia`;
DROP TABLE IF EXISTS `tin_nhan`;
DROP TABLE IF EXISTS `don_hang`;
DROP TABLE IF EXISTS `san_pham`;
DROP TABLE IF EXISTS `danh_muc`;
DROP TABLE IF EXISTS `nguoi_dung`;

-- 1. Bảng người dùng (Đăng nhập / Đăng ký / Thông tin cá nhân)
CREATE TABLE `nguoi_dung` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ten_dang_nhap` VARCHAR(50) NOT NULL UNIQUE,
  `mat_khau` VARCHAR(255) NOT NULL,
  `ho_ten` VARCHAR(100) NOT NULL,
  `ma_kh` VARCHAR(20) NOT NULL UNIQUE,
  `sdt` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100),
  `so_tai_khoan` VARCHAR(100) DEFAULT 'VCB - 007100129xxxx (Chi nhánh SGD)',
  `vi_ky_gui` DECIMAL(15,2) DEFAULT 15450000.00,
  `da_quyet_toan` DECIMAL(15,2) DEFAULT 12000000.00,
  `san_sang_thanh_toan` DECIMAL(15,2) DEFAULT 3450000.00,
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng danh mục sản phẩm
CREATE TABLE `danh_muc` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ten_danh_muc` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Bảng sản phẩm ký gửi (Tổ tổng 24 sản phẩm chia đều 3 danh mục)
CREATE TABLE `san_pham` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nguoi_dung_id` INT NOT NULL,
  `ten_san_pham` VARCHAR(255) NOT NULL,
  `danh_muc_id` INT NOT NULL,
  `tinh_trang` VARCHAR(50) NOT NULL,
  `mo_ta` TEXT,
  `gia_nhan` DECIMAL(15,2) NOT NULL,
  `gia_niem_yet` DECIMAL(15,2) NOT NULL,
  `hinh_anh` VARCHAR(255) DEFAULT 'default.jpg',
  `trang_thai` ENUM('dang_ban', 'da_ban', 'cho_duyet_het_hang') DEFAULT 'dang_ban',
  `ngay_dang` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_muc`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Bảng đơn hàng
CREATE TABLE `don_hang` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `san_pham_id` INT NOT NULL,
  `nguoi_mua_id` INT NOT NULL,
  `gia_tien` DECIMAL(15,2) NOT NULL,
  `phuong_thuc_tt` ENUM('tien_mat', 'chuyen_khoan') NOT NULL,
  `ngay_mua` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` VARCHAR(50) DEFAULT 'thanh_cong',
  FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`nguoi_mua_id`) REFERENCES `nguoi_dung`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Bảng tin nhắn chat
CREATE TABLE `tin_nhan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nguoi_gui_id` INT NOT NULL,
  `nguoi_nhan_id` INT DEFAULT NULL,
  `san_pham_id` INT DEFAULT NULL,
  `noi_dung` TEXT NOT NULL,
  `ngay_gui` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`nguoi_gui_id`) REFERENCES `nguoi_dung`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Bảng đánh giá
CREATE TABLE `danh_gia` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nguoi_danh_gia_id` INT NOT NULL,
  `san_pham_id` INT DEFAULT NULL,
  `loai_danh_gia` ENUM('san_pham', 'dich_vu') DEFAULT 'dich_vu',
  `so_sao` INT NOT NULL DEFAULT 5,
  `noi_dung` TEXT NOT NULL,
  `ngay_danh_gia` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`nguoi_danh_gia_id`) REFERENCES `nguoi_dung`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DỮ LIỆU MẪU (SEED DATA)
INSERT INTO `nguoi_dung` (`id`, `ten_dang_nhap`, `mat_khau`, `ho_ten`, `ma_kh`, `sdt`, `email`, `vi_ky_gui`, `da_quyet_toan`, `san_sang_thanh_toan`) VALUES
(1, 'trangnguyen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Thu Trang', 'KH-8821', '0988432109', 'thutrang@gmail.com', 15450000.00, 12000000.00, 3450000.00),
(2, 'dotuankiet', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Đỗ Tuấn Kiệt', 'KH-1092', '0912345678', 'tuankiet@gmail.com', 5000000.00, 3000000.00, 2000000.00),
(3, 'tranhaiyen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Hải Yến', 'KH-3382', '0933888999', 'haiyen@gmail.com', 8200000.00, 5000000.00, 3200000.00);

INSERT INTO `danh_muc` (`id`, `ten_danh_muc`, `slug`) VALUES
(1, 'Thời trang & phụ kiện', 'thoi-trang-phu-kien'),
(2, 'Đồ công nghệ', 'do-cong-nghe'),
(3, 'Giày dép', 'giay-dep');

-- 24 SẢN PHẨM CHIA ĐỀU MỖI DANH MỤC 8 SẢN PHẨM
INSERT INTO `san_pham` (`id`, `nguoi_dung_id`, `ten_san_pham`, `danh_muc_id`, `tinh_trang`, `mo_ta`, `gia_nhan`, `gia_niem_yet`, `hinh_anh`, `trang_thai`) VALUES
-- 8 SẢN PHẨM: THỜI TRANG & PHỤ KIỆN (Danh mục 1)
(1, 1, 'Túi xách Coach da nâu Canvas Signature', 1, 'Mới 95%', 'Túi Coach da thật chuẩn auth, còn hóa đơn Tràng Tiền Plaza.', 1875000.00, 2500000.00, 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=600&q=80', 'da_ban'),
(2, 1, 'Áo Blazer thiết kế Chic Studio Size M', 1, 'Mới 98%', 'Áo Blazer màu kem lướt 1 lần, chất vải mềm giữ phom cực chuẩn.', 1480000.00, 1850000.00, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(3, 3, 'Áo khoác dạ Zara Size M Camel', 1, 'Mới 90%', 'Áo khoác dạ Zara màu Camel ấm áp, cúc phụ nguyên vẹn.', 600000.00, 850000.00, 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(4, 3, 'Balo MCM Stark Backpack Cognac Visetos', 1, 'Mới 97%', 'Balo MCM họa tiết monogram cổ điển, đinh tán kim loại sáng bóng.', 6800000.00, 8500000.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(5, 1, 'Kính mát Gentle Monster Her 01', 1, 'Mới 99%', 'Kính râm Gentle Monster màu đen Fullbox khăn lau gọng kính.', 3200000.00, 4200000.00, 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(6, 3, 'Túi xách Gucci Dionysus Mini GG Super Fake Auth', 1, 'Mới 96%', 'Túi Gucci đinh mạ bạc cao cấp khóa đầu rồng dán tem kiểm định.', 14000000.00, 17500000.00, 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(7, 2, 'Đồng hồ nam Tissot Le Locle Automatic', 1, 'Mới 98%', 'Đồng hồ cơ Thụy Sỹ Tissot dây kim loại Fullbox dán tem.', 7100000.00, 8900000.00, 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(8, 1, 'Ví cầm tay Pedro Leather Fold Wallet', 1, 'Mới 95%', 'Ví nam Pedro da bò thật mềm mịn, nhiều ngăn đựng thẻ.', 750000.00, 990000.00, 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=600&q=80', 'dang_ban'),

-- 8 SẢN PHẨM: ĐỒ CÔNG NGHỆ (Danh mục 2)
(9, 2, 'Bàn phím cơ Custom Keychron Q1 Pro', 2, 'Mới 99%', 'Keychron Q1 Pro Fullbox đầy đủ phụ kiện gõ siêu êm.', 3000000.00, 3750000.00, 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(10, 2, 'Tai nghe Sony WH-1000XM4 xám', 2, 'Mới 97%', 'Tai nghe chống ồn Sony chính hãng, pin trâu 30 tiếng.', 4000000.00, 4990000.00, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(11, 2, 'Máy ảnh Sony A6400 Kit 16-50mm', 2, 'Mới 98%', 'Máy ảnh Sony chụp quay 4K lấy nét cực nhanh 3000 shot.', 12200000.00, 15200000.00, 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(12, 1, 'iPad Air 5 M1 64GB WiFi Starlight', 2, 'Mới 99%', 'iPad Air 5 chip M1 pin 99% không vết xước kèm bao da.', 10500000.00, 12900000.00, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(13, 3, 'Loa Bluetooth Marshall Stanmore II', 2, 'Mới 96%', 'Loa Marshall âm trầm ấm áp trang trí vintage siêu đẹp.', 5200000.00, 6500000.00, 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(14, 2, 'Máy chơi game Nintendo Switch OLED White', 2, 'Mới 98%', 'Nintendo Switch màn OLED hình nét đã dán cường lực kèm thẻ 128GB.', 5800000.00, 7200000.00, 'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(15, 2, 'Chuột máy tính Logitech MX Master 3S', 2, 'Mới 99%', 'Logitech MX Master 3S lướt siêu êm cho dân văn phòng coder.', 1600000.00, 2100000.00, 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(16, 1, 'Tai nghe Apple AirPods Pro 2 USB-C', 2, 'Mới 98%', 'AirPods Pro 2 bản sạc USB-C còn bảo hành Apple Care.', 3900000.00, 4800000.00, 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&w=600&q=80', 'dang_ban'),

-- 8 SẢN PHẨM: GIÀY DÉP (Danh mục 3)
(17, 3, 'Giày sneaker MLB Chunky Liner Size 38.5', 3, 'Mới 95%', 'Giày MLB đế nguyên gai, sạch đẹp như mới.', 1050000.00, 1400000.00, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(18, 1, 'Giày cao gót Charles & Keith Size 37', 3, 'Mới 90%', 'Charles & Keith da đen gót nhọn 7cm.', 450000.00, 600000.00, 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=600&q=80', 'cho_duyet_het_hang'),
(19, 3, 'Giày Jordan 1 Retro High OG Chicago Size 42', 3, 'Mới 97%', 'Giày Nike Jordan 1 phối màu Chicago da thật siêu đẹp.', 3800000.00, 4650000.00, 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(20, 2, 'Giày thể thao Nike Air Force 1 07 Triple White 41', 3, 'Mới 96%', 'Nike AF1 trắng tinh trâm đi lướt 2-3 lần sạch đẹp.', 1600000.00, 2100000.00, 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(21, 3, 'Giày chạy bộ Adidas Ultraboost Light Size 42', 3, 'Mới 98%', 'Adidas Ultraboost đế êm siêu nhẹ tập gym chạy bộ cực đã.', 2200000.00, 2900000.00, 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(22, 1, 'Giày cao gót Christian Louboutin Kate 85mm', 3, 'Mới 95%', 'Louboutin đế đỏ huyền thoại Size 36.5 nguyên hộp bảo vệ.', 11000000.00, 14200000.00, 'https://images.unsplash.com/photo-1596568359553-a56de6970068?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(23, 2, 'Giày New Balance 530 White Silver Size 39', 3, 'Mới 97%', 'New Balance 530 phối màu bạc retro thời thượng.', 1800000.00, 2350000.00, 'https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=600&q=80', 'dang_ban'),
(24, 1, 'Giày lười Loafer Pedro Calfskin Black Size 40', 3, 'Mới 96%', 'Giày lười Pedro da bò bóng sang trọng cho quý ông.', 1250000.00, 1650000.00, 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=600&q=80', 'dang_ban');

-- CÁC ĐÁNH GIÁ MẪU
INSERT INTO `danh_gia` (`nguoi_danh_gia_id`, `san_pham_id`, `loai_danh_gia`, `so_sao`, `noi_dung`) VALUES
(2, 1, 'san_pham', 5, 'Nhận hàng bọc bong bóng 3 lớp. Túi nguyên form, da mềm xịn không xước dăm.'),
(3, 4, 'dich_vu', 5, 'Dịch vụ thẩm định nhanh chóng, giữ tiền trung gian Escrow rất an tâm!'),
(1, 10, 'san_pham', 5, 'Tai nghe Sony WH-1000XM4 chất lượng âm thanh hay, chống ồn đỉnh cao.');
