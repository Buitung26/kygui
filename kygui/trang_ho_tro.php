<?php
// Tên file: trang_ho_tro.php (3 từ)
require_once __DIR__ . '/ket_noi.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trung Tâm Hỗ Trợ & Tra Cứu Phân Khu - ConsignHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="giao_dien.css">
    <script src="tuong_tac.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col support-page-content">

    <!-- HEADER / NAVIGATION -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-8">
                <a href="trang_chu.php" class="flex items-center gap-2 font-bold text-2xl text-blue-700 tracking-tight">
                    <span class="material-symbols-outlined text-3xl">storefront</span> ConsignHub
                </a>
                <nav class="hidden md:flex items-center gap-8 font-semibold text-base text-slate-600">
                    <a href="trang_chu.php" class="hover:text-blue-600 transition-colors">Sàn Ký Gửi</a>
                    <a href="trang_ca_nhan.php" class="hover:text-blue-600 transition-colors">Trang Cá Nhân & Đăng Đồ</a>
                    <a href="trang_ho_tro.php" class="text-blue-600 font-bold border-b-2 border-blue-600 pb-1">Hỗ Trợ</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <a href="trang_ca_nhan.php" class="flex items-center gap-2">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" class="w-9 h-9 rounded-full object-cover ring-2 ring-blue-500/20" alt="Avatar">
                    <span class="text-base font-bold text-slate-800 hidden sm:inline-block">Nguyễn Thu Trang</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 space-y-12">

            <!-- HERO SEARCH SEARCH BAR -->
            <div class="text-center space-y-6 max-w-4xl mx-auto pt-4">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100 text-blue-800 text-sm font-extrabold uppercase tracking-wider shadow-sm">
                    <span class="material-symbols-outlined text-lg">menu_book</span> Trung tâm hỗ trợ & Tra cứu phân khu tự động
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Cẩm Nang & Hướng Dẫn Ký Gửi Minh Bạch
                </h1>
                <p class="text-slate-700 text-lg md:text-xl leading-relaxed">
                    Gõ từ khóa có liên quan vào ô tìm kiếm bên dưới, màn hình sẽ tự động di chuyển mượt mà trực tiếp đến đúng phân khu nội dung tương ứng.
                </p>

                <!-- SEARCH BAR WITH SECTION JUMPING -->
                <div class="bg-white p-3 rounded-2xl shadow-xl border-2 border-blue-100 flex items-center gap-3 max-w-3xl mx-auto">
                    <span class="material-symbols-outlined text-blue-600 text-3xl pl-2">search</span>
                    <input type="text" id="tim-kiem-ho-tro" placeholder="Tra cứu: lưu kho, biểu phí 80/20, giải ngân, quy trình 4 bước, kho bãi..." 
                           class="w-full h-12 border-0 focus:outline-none text-base font-semibold text-slate-800 placeholder-slate-400">
                    <button id="btn-tim-kiem-ho-tro" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-base transition-colors shadow-md whitespace-nowrap flex items-center gap-2">
                        <span>Tra cứu ngay</span>
                        <span class="material-symbols-outlined text-lg">arrow_downward</span>
                    </button>
                </div>
            </div>

            <!-- PHÂN KHU 1: CHỈ SỐ VẬN HÀNH CHÍNH -->
            <section data-phankhu="1" data-keywords="luu kho 60 ngay bieu phi 80 20 lich giai ngan ngay 05 va 20 tieu chuan do moi 85 chi so van hanh" 
                     class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 space-y-6 transition-all">
                <div class="border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-sm uppercase">Phân Khu 01</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-base font-bold text-blue-600">Quy Chuẩn Vận Hành Cốt Lõi</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Thông Số Vận Hành & Quy Định Trọng Tâm</h2>
                    <p class="text-base text-slate-600 mt-1">Bảng cam kết minh bạch được áp dụng nhất quán trên toàn bộ hệ thống ConsignHub.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 hover:border-blue-500 transition-all">
                        <div class="text-3xl font-extrabold text-blue-700">60 Ngày</div>
                        <h3 class="font-bold text-lg text-slate-900">Thời Gian Lưu Kho Miễn Phí</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Sản phẩm được lưu kho, bảo quản phòng lạnh và quảng bá liên tục trong 60 ngày hoàn toàn không mất phí.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 hover:border-blue-500 transition-all">
                        <div class="text-3xl font-extrabold text-emerald-600">80% / 20%</div>
                        <h3 class="font-bold text-lg text-slate-900">Tỷ Lệ Chiết Khấu Sàn</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Người gửi thực nhận trọn vẹn 80% giá trị bán. 20% hoa hồng sàn bao gồm trọn gói thẩm định, chụp ảnh studio và bảo vệ Escrow.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 hover:border-blue-500 transition-all">
                        <div class="text-3xl font-extrabold text-blue-700">Ngày 05 & 20</div>
                        <h3 class="font-bold text-lg text-slate-900">Lịch Chuyển Khoản Định Kỳ</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Tự động quyết toán doanh thu đơn hàng thành công trực tiếp về tài khoản ngân hàng cá nhân vào 2 kỳ cố định mỗi tháng.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 hover:border-blue-500 transition-all">
                        <div class="text-3xl font-extrabold text-amber-500">≥ 85%</div>
                        <h3 class="font-bold text-lg text-slate-900">Tiêu Chuẩn Nhận Hàng</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Cam kết 100% hàng chính hãng Authentic, độ mới đạt từ 85% trở lên, hoạt động hoàn hảo không lỗi hỏng.</p>
                    </div>
                </div>
            </section>

            <!-- PHÂN KHU 2: QUY TRÌNH KÝ GỬI 4 BƯỚC -->
            <section data-phankhu="2" data-keywords="quy trinh 4 buoc khai bao chup anh gui hang ve kho niem yet ban hang nhan tien" 
                     class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 space-y-6 transition-all">
                <div class="border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-sm uppercase">Phân Khu 02</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-base font-bold text-blue-600">Thao Tác Thực Hiện</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Quy Trình Ký Gửi 4 Bước Chi Tiết Từ A Đến Z</h2>
                    <p class="text-base text-slate-600 mt-1">Hướng dẫn cụ thể cho người dùng từ lúc bắt đầu đăng sản phẩm đến khi nhận tiền mặt/chuyển khoản.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <span class="px-3 py-1 rounded-lg bg-blue-600 text-white font-extrabold text-xs">Bước 01</span>
                        <h3 class="font-bold text-xl text-slate-900">Khai Báo & Đăng Đồ</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Truy cập Trang Cá Nhân, nhập tên món đồ, chọn loại danh mục (Thời trang & phụ kiện, Đồ công nghệ, Giày dép), mô tả chi tiết, mức giá nhận về và tải ảnh lên.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <span class="px-3 py-1 rounded-lg bg-blue-600 text-white font-extrabold text-xs">Bước 02</span>
                        <h3 class="font-bold text-xl text-slate-900">Gửi Hàng Về Kho</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Yêu cầu bưu tá đến lấy đồ tận nhà miễn phí nội thành hoặc trực tiếp mang món đồ tới Trung tâm tiếp nhận kho gần nhất để ký biên bản.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <span class="px-3 py-1 rounded-lg bg-blue-600 text-white font-extrabold text-xs">Bước 03</span>
                        <h3 class="font-bold text-xl text-slate-900">Niêm Yết & Lưu Kho</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Chuyên viên kỹ thuật thẩm định thật giả, vệ sinh khử khuẩn, chụp ảnh studio sắc nét và niêm yết chính thức trên sàn Sàn Ký Gửi.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <span class="px-3 py-1 rounded-lg bg-emerald-600 text-white font-extrabold text-xs">Bước 04</span>
                        <h3 class="font-bold text-xl text-slate-900">Thanh Toán Doanh Thu</h3>
                        <p class="text-base text-slate-600 leading-relaxed">Khi người mua thanh toán tiền mặt (COD) hoặc chuyển khoản, 80% giá trị bán sẽ được cập nhật tự động vào ví cá nhân và chuyển về STK ngân hàng.</p>
                    </div>
                </div>
            </section>

            <!-- PHÂN KHU 3: BIỂU PHÍ HOA HỒNG CHI TIẾT -->
            <section data-phankhu="3" data-keywords="bieu phi hoa hong chiet khau phan khuc gia tri mien phi luu kho" 
                     class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 space-y-6 transition-all">
                <div class="border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-sm uppercase">Phân Khu 03</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-base font-bold text-blue-600">Minh Bạch Tài Chính</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Biểu Phí Hoa Hồng & Quyền Lợi Toàn Diện</h2>
                    <p class="text-base text-slate-600 mt-1">Chi tiết mức hoa hồng sàn trừ trên từng phân khúc giá trị sản phẩm ký gửi.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-base border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b-2 border-slate-200 text-slate-800 font-extrabold">
                                <th class="p-4">Phân khúc giá trị</th>
                                <th class="p-4">Hoa hồng sàn</th>
                                <th class="p-4">Thực nhận người gửi</th>
                                <th class="p-4">Phí lưu kho</th>
                                <th class="p-4">Dịch vụ đính kèm</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-bold text-slate-900">Dưới 2.000.000 đ</td>
                                <td class="p-4 text-blue-700 font-extrabold">20%</td>
                                <td class="p-4 font-extrabold text-emerald-600">80% giá niêm yết</td>
                                <td class="p-4">Miễn phí (60 ngày)</td>
                                <td class="p-4">Chụp ảnh studio 3 góc nét</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-bold text-slate-900">Từ 2.000.000 đ - 10.000.000 đ</td>
                                <td class="p-4 text-blue-700 font-extrabold">18%</td>
                                <td class="p-4 font-extrabold text-emerald-600">82% giá niêm yết</td>
                                <td class="p-4">Miễn phí (60 ngày)</td>
                                <td class="p-4">Chụp Studio + Clip 360°</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 font-bold text-slate-900">Trên 10.000.000 đ (Dòng Hàng Hiệu)</td>
                                <td class="p-4 text-blue-700 font-extrabold">15%</td>
                                <td class="p-4 font-extrabold text-emerald-600">85% giá niêm yết</td>
                                <td class="p-4">Miễn phí (60 ngày)</td>
                                <td class="p-4">Studio Pro + Thẩm định AI Entrupy</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- PHÂN KHU 4: TIÊU CHUẨN TIẾP NHẬN DO'S & DON'TS -->
            <section data-phankhu="4" data-keywords="danh muc duoc phep tu choi do cong nghe thoi trang dong ho hang fake rach nat" 
                     class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 space-y-6 transition-all">
                <div class="border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-sm uppercase">Phân Khu 04</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-base font-bold text-blue-600">Quy Chuẩn Kiểm Định</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Danh Mục Được Phép & Từ Chối Tiếp Nhận</h2>
                    <p class="text-base text-slate-600 mt-1">Quy định phân loại kỹ lưỡng bảo vệ cộng đồng mua bán an toàn.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-6 rounded-2xl bg-emerald-50 border-2 border-emerald-200 space-y-4">
                        <h3 class="font-extrabold text-xl text-emerald-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-2xl">check_circle</span> Được Phép Ký Gửi
                        </h3>
                        <ul class="text-base text-slate-800 space-y-2 pl-6 list-disc leading-relaxed">
                            <li><strong>Thời trang & Phụ kiện:</strong> Túi xách, balo, áo khoác, kính mát chính hãng Authentic.</li>
                            <li><strong>Đồ công nghệ:</strong> Bàn phím cơ, tai nghe chống ồn, máy ảnh, iPad, loa bluetooth còn dùng tốt.</li>
                            <li><strong>Giày dép:</strong> Sneaker chính hãng, giày cao gót, giày lười da thật mới ≥ 85%.</li>
                        </ul>
                    </div>

                    <div class="p-6 rounded-2xl bg-red-50 border-2 border-red-200 space-y-4">
                        <h3 class="font-extrabold text-xl text-red-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-2xl">cancel</span> Từ Chối Tiếp Nhận
                        </h3>
                        <ul class="text-base text-slate-800 space-y-2 pl-6 list-disc leading-relaxed">
                            <li><strong>Hàng giả, nhái:</strong> Hàng Fake, Replica, Super Fake xâm phạm quyền sở hữu trí tuệ.</li>
                            <li><strong>Đồ hỏng hóc:</strong> Sản phẩm rách nát, nổ da, hỏng tính năng chính không thể dùng bình thường.</li>
                            <li><strong>Mỹ phẩm/Nước hoa:</strong> Các loại dung dịch đã mở nắp hoặc không còn nguyên seal bảo vệ.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- PHÂN KHU 5: CÂU HỎI THƯỜNG GẶP FAQ -->
            <section data-phankhu="5" data-keywords="faq cau hoi thuong gap thoi gian kiem duyet 60 ngay hoan tien escrow" 
                     class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 space-y-6 transition-all">
                <div class="border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-sm uppercase">Phân Khu 05</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-base font-bold text-blue-600">Giải Đáp Thắc Mắc</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Câu Hỏi Thường Gặp & Điều Lệ Chi Tiết (FAQ)</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-lg text-slate-900">Q: Sau bao lâu đồ ký gửi được duyệt lên sàn?</h3>
                        <p class="text-base text-slate-700 leading-relaxed">A: Kỹ thuật viên kiểm định 5 bước và niêm yết công khai trong vòng 24 giờ làm việc từ khi nhận hàng.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-lg text-slate-900">Q: Nếu không bán được sau 60 ngày thì xử lý thế nào?</h3>
                        <p class="text-base text-slate-700 leading-relaxed">A: Quý khách có thể chọn Flash Sale giảm giá, gia hạn thêm 30 ngày hoặc nhận lại đồ hoàn toàn miễn phí bãi kho.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-lg text-slate-900">Q: Người mua thanh toán qua phương thức nào?</h3>
                        <p class="text-base text-slate-700 leading-relaxed">A: Hỗ trợ tiền mặt khi nhận hàng (COD) hoặc chuyển khoản ngân hàng qua cổng tạm giữ bảo vệ Escrow 48h.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-lg text-slate-900">Q: Làm sao để rút tiền từ Ví Ký Gửi & Quyết Toán?</h3>
                        <p class="text-base text-slate-700 leading-relaxed">A: Nhấn "Rút tiền ngay" trên Trang Cá Nhân, hệ thống sẽ tự động chuyển khoản về STK ngân hàng đã đăng ký.</p>
                    </div>
                </div>
            </section>

            <!-- PHÂN KHU 6: HỆ THỐNG KHO BÃI & ĐIỂM BÀN GIAO -->
            <section data-phankhu="6" data-keywords="dia diem kho bai trung tam kiem dinh dia chi cskh zalo hotline hcm ha noi" 
                     class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200 space-y-6 transition-all">
                <div class="border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-sm uppercase">Phân Khu 06</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-base font-bold text-blue-600">Địa Điểm & CSKH</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Hệ Thống Kho Bãi & Điểm Tiếp Nhận Ký Gửi</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-slate-900 text-xl">Kho Trung Tâm TP.HCM</h3>
                        <p class="text-base text-slate-700">184 Nguyễn Trãi, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh</p>
                        <p class="text-base text-blue-700 font-extrabold">Hotline: 028 7777 8888</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-slate-900 text-xl">Kho Trung Tâm Hà Nội</h3>
                        <p class="text-base text-slate-700">92 Tràng Thi, Phường Hàng Bông, Quận Hoàn Kiếm, Hà Nội</p>
                        <p class="text-base text-blue-700 font-extrabold">Hotline: 024 7777 9999</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <h3 class="font-extrabold text-slate-900 text-xl">Tổng Đài & Zalo CSKH</h3>
                        <p class="text-base text-slate-700">Zalo OA 24/7: ConsignHub Vietnam</p>
                        <p class="text-base text-emerald-600 font-extrabold">Email: hotro@consignhub.vn</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 py-10 text-sm text-slate-600">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>© 2026 ConsignHub. Nền tảng ký gửi đồ cá nhân minh bạch & uy tín.</p>
            <div class="flex items-center gap-6">
                <a href="trang_ho_tro.php" class="hover:text-slate-900 font-medium">Điều khoản sử dụng</a>
                <a href="trang_ho_tro.php" class="hover:text-slate-900 font-medium">Bảo mật thông tin</a>
            </div>
        </div>
    </footer>

</body>
</html>
