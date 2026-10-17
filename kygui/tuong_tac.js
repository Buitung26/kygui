/* Tên file: tuong_tac.js (2 từ) */

document.addEventListener('DOMContentLoaded', function() {
    // 1. KIỂM TRA TRẠNG THÁI ĐĂNG NHẬP BAN ĐẦU
    checkAuthStatus();

    // 2. TÌM KIẾM DỮ LIỆU SẢN PHẨM TRÊN TRANG CHỦ (LIVE SEARCH FUZZY MATCH)
    const searchInput = document.getElementById('tim-kiem-san-pham');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const tukhoa = this.value.trim();
            debounceTimer = setTimeout(() => {
                thucHienTimKiem(tukhoa, getActiveCategoryId());
            }, 250);
        });
    }

    // 3. LỌC THEO DANH MỤC TRÊN TRANG CHỦ
    const categoryBtns = document.querySelectorAll('.danh-muc-btn');
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            categoryBtns.forEach(b => {
                b.classList.remove('active', 'bg-blue-600', 'text-white');
                b.classList.add('bg-slate-100', 'text-slate-700');
            });
            
            this.classList.remove('bg-slate-100', 'text-slate-700');
            this.classList.add('active', 'bg-blue-600', 'text-white');

            const catId = this.getAttribute('data-cat-id') || 0;
            const tukhoa = searchInput ? searchInput.value.trim() : '';
            thucHienTimKiem(tukhoa, catId);
        });
    });

    // 4. LỌC DANH SÁCH ĐỒ KÝ GỬI CỦA TÔI (TRANG CÁ NHÂN)
    const myItemTabs = document.querySelectorAll('.tab-do-toi');
    if (myItemTabs.length > 0) {
        myItemTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                myItemTabs.forEach(t => t.classList.remove('bg-white', 'text-blue-700', 'shadow-sm'));
                myItemTabs.forEach(t => t.classList.add('text-slate-600'));

                this.classList.remove('text-slate-600');
                this.classList.add('bg-white', 'text-blue-700', 'shadow-sm');

                const status = this.getAttribute('data-status') || 'tat_ca';
                taiDanhSachDoCuaToi(status);
            });
        });
    }

    const myItemsContainer = document.getElementById('danh-sach-do-cua-toi');
    if (myItemsContainer) {
        myItemsContainer.addEventListener('click', function(event) {
            const button = event.target.closest('button[data-action]');
            if (!button || !myItemsContainer.contains(button)) return;

            if (button.dataset.action === 'edit') {
                suaDoKyGui(button);
            } else if (button.dataset.action === 'delete') {
                xoaDoKyGui(button.dataset.productId);
            }
        });
    }

    // 5. TÌM KIẾM DI CHUYỂN PHÂN KHU (TRANG HỖ TRỢ)
    const supportSearchInput = document.getElementById('tim-kiem-ho-tro');
    const supportSearchBtn = document.getElementById('btn-tim-kiem-ho-tro');
    
    if (supportSearchInput && supportSearchBtn) {
        const triggerSupportSearch = () => {
            const query = supportSearchInput.value.toLowerCase().trim();
            if (!query) return;

            const sections = document.querySelectorAll('[data-phankhu]');
            let matchedSection = null;

            sections.forEach(sec => {
                const text = sec.innerText.toLowerCase();
                const keywords = sec.getAttribute('data-keywords') || '';
                if (text.includes(query) || keywords.toLowerCase().includes(query)) {
                    if (!matchedSection) matchedSection = sec;
                }
            });

            if (matchedSection) {
                matchedSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                matchedSection.classList.add('section-highlight');
                setTimeout(() => {
                    matchedSection.classList.remove('section-highlight');
                }, 2500);
            } else {
                alert('Không tìm thấy phân khu nội dung phù hợp với từ khóa "' + query + '"!');
            }
        };

        supportSearchBtn.addEventListener('click', triggerSupportSearch);
        supportSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') triggerSupportSearch();
        });
    }

    // 6. XỬ LÝ SUBMIT FORM ĐĂNG KÝ KÝ GỬI MÓN ĐỒ MỚI
    const formDangDo = document.getElementById('form-dang-do');
    if (formDangDo) {
        formDangDo.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!requireAuth()) return;

            const formData = new FormData(this);
            const isEditing = Boolean(formData.get('san_pham_id'));
            formData.append('action', isEditing ? 'cap_nhat_do' : 'dang_do');

            fetch('xu_ly.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    huySuaDoKyGui();
                    taiDanhSachDoCuaToi('tat_ca');
                }
            })
            .catch(() => {
                alert('Không thể kết nối để lưu thông tin sản phẩm. Vui lòng thử lại.');
            });
        });
    }
});

// GLOBAL STATE & AUTH HELPERS
let isUserLoggedIn = false;
let currentUser = null;
let currentChatProductId = null;
let currentBuyProductId = null;
let currentMyItemsStatus = 'tat_ca';

function checkAuthStatus() {
    fetch('xac_thuc.php?action=kiem_tra')
        .then(res => res.json())
        .then(data => {
            isUserLoggedIn = data.logged_in;
            currentUser = data.user;
            capNhatGiaoDienUser();
        })
        .catch(() => {
            isUserLoggedIn = false;
            capNhatGiaoDienUser();
        });
}

function capNhatGiaoDienUser() {
    const loginNav = document.getElementById('nav-login-btn');
    const userNav = document.getElementById('nav-user-profile');
    const userNameSpan = document.getElementById('user-name-display');

    if (loginNav && userNav) {
        if (isUserLoggedIn) {
            loginNav.classList.add('hidden');
            userNav.classList.remove('hidden');
            if (userNameSpan && currentUser) {
                userNameSpan.innerText = currentUser.ho_ten;
            }
        } else {
            loginNav.classList.remove('hidden');
            userNav.classList.add('hidden');
        }
    }
}

function requireAuth(callback) {
    if (!isUserLoggedIn) {
        alert('Yêu cầu bắt buộc đăng nhập để thực hiện chức năng này!');
        openModal('modal-dang-nhap');
        return false;
    }
    if (callback) callback();
    return true;
}

function getActiveCategoryId() {
    const activeBtn = document.querySelector('.danh-muc-btn.active');
    return activeBtn ? (activeBtn.getAttribute('data-cat-id') || 0) : 0;
}

// THỰC HIỆN TÌM KIẾM SẢN PHẨM QUA AJAX HẶC CLIENT-SIDE
function thucHienTimKiem(tukhoa, danhMucId) {
    const grid = document.getElementById('danh-sach-san-pham');
    if (!grid) return;

    fetch(`xu_ly.php?action=tim_kiem_san_pham&tukhoa=${encodeURIComponent(tukhoa)}&danh_muc_id=${danhMucId}`)
        .then(res => res.json())
        .then(resData => {
            if (resData.success && resData.data && resData.data.length > 0) {
                hienThiDanhSachSanPham(resData.data);
            } else {
                locSanPhamClientSide(tukhoa, danhMucId);
            }
        })
        .catch(() => {
            locSanPhamClientSide(tukhoa, danhMucId);
        });
}

function locSanPhamClientSide(tukhoa, danhMucId) {
    const cards = document.querySelectorAll('.san-pham-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const catId = card.getAttribute('data-cat-id');
        const title = card.getAttribute('data-title').toLowerCase();
        
        let matchCat = (danhMucId == 0 || catId == danhMucId);
        let matchText = (tukhoa === '' || title.includes(tukhoa.toLowerCase()));

        if (matchCat && matchText) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });

    const emptyMsg = document.getElementById('no-product-msg');
    if (emptyMsg) {
        if (visibleCount === 0) {
            emptyMsg.classList.remove('hidden');
        } else {
            emptyMsg.classList.add('hidden');
        }
    }
}

function hienThiDanhSachSanPham(items) {
    const grid = document.getElementById('danh-sach-san-pham');
    if (!grid) return;

    if (items.length === 0) {
        grid.innerHTML = `<div class="col-span-full text-center py-12 text-slate-500 font-medium">Không tìm thấy sản phẩm nào gần giống nhất với từ khóa!</div>`;
        return;
    }

    grid.innerHTML = items.map(sp => `
        <article class="san-pham-card group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden border border-slate-100" 
                 data-cat-id="${sp.danh_muc_id}" data-title="${sp.ten_san_pham}">
            <div>
                <div class="relative aspect-square overflow-hidden bg-slate-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="${sp.hinh_anh}" alt="${sp.ten_san_pham}">
                    <div class="absolute top-3 left-3 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm text-emerald-600 text-xs font-semibold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        ${sp.trang_thai === 'dang_ban' ? 'Đang mở bán' : (sp.trang_thai === 'da_ban' ? 'Đã bán' : 'Chờ duyệt')}
                    </div>
                    <div class="absolute bottom-3 right-3 px-2 py-0.5 rounded-md bg-slate-900/80 backdrop-blur-sm text-white text-xs font-medium">
                        ${sp.tinh_trang}
                    </div>
                </div>

                <div class="p-4 space-y-2">
                    <div class="flex items-center gap-1.5 text-blue-600 text-xs font-semibold">
                        <span class="material-symbols-outlined text-[15px]">verified</span>
                        ${sp.ten_danh_muc || 'Hàng ký gửi'}
                    </div>
                    <h3 class="text-base font-semibold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                        ${sp.ten_san_pham}
                    </h3>
                    <div class="flex items-baseline gap-2 pt-1">
                        <span class="text-lg font-bold text-slate-900">${Number(sp.gia_niem_yet).toLocaleString('vi-VN')} đ</span>
                        <span class="text-xs text-slate-400 line-through">${Number(sp.gia_nhan * 1.2).toLocaleString('vi-VN')} đ</span>
                    </div>
                </div>
            </div>

            <div class="p-4 pt-0 space-y-3">
                <div class="p-2 rounded-lg bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                            ${sp.nguoi_dang ? sp.nguoi_dang.charAt(0) : 'N'}
                        </div>
                        <span class="text-xs font-medium text-slate-800 truncate">${sp.nguoi_dang || 'Người ký gửi'}</span>
                    </div>
                    <span class="text-xs text-amber-500 font-semibold flex items-center gap-0.5">★ 4.9</span>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <button onclick="openChatWidget(${sp.id}, '${sp.ten_san_pham.replace(/'/g, "\\'")}')" 
                            class="h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center justify-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">chat_bubble_outline</span> Liên hệ
                    </button>
                    <button onclick="openBuyModal(${sp.id}, '${sp.ten_san_pham.replace(/'/g, "\\'")}', ${sp.gia_niem_yet}, '${sp.nguoi_dang || 'Người ký gửi'}', '${sp.hinh_anh}')" 
                            class="h-9 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold flex items-center justify-center transition-colors shadow-sm">
                        Mua ngay
                    </button>
                </div>
            </div>
        </article>
    `).join('');
}

// TẢI ĐỒ KÝ GỬI CỦA TÔI (TRANG CÁ NHÂN)
function taiDanhSachDoCuaToi(status) {
    const container = document.getElementById('danh-sach-do-cua-toi');
    if (!container) return;
    currentMyItemsStatus = status;

    fetch(`xu_ly.php?action=lay_san_pham_toi&trang_thai=${status}`)
        .then(res => res.json())
        .then(resData => {
            if (resData.success && resData.data) {
                if (resData.data.length === 0) {
                    container.innerHTML = `<div class="p-8 text-center text-slate-500 font-medium">Chưa có món đồ nào thuộc mục này.</div>`;
                    return;
                }
                container.innerHTML = resData.data.map(sp => `
                    <div class="bg-white rounded-xl p-4 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border border-slate-100">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-slate-100 shrink-0">
                                <img src="${sp.hinh_anh}" class="w-full h-full object-cover" alt="">
                            </div>
                            <div class="min-w-0 space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${sp.trang_thai === 'da_ban' ? 'bg-emerald-100 text-emerald-700' : (sp.trang_thai === 'dang_ban' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700')}">
                                        ${sp.trang_thai === 'da_ban' ? 'ĐÃ BÁN' : (sp.trang_thai === 'dang_ban' ? 'ĐANG BÁN' : 'CHỜ DUYỆT / HẾT HẠN')}
                                    </span>
                                </div>
                                <h3 class="font-semibold text-slate-900 truncate">${sp.ten_san_pham}</h3>
                                <p class="text-xs text-slate-500">${sp.ten_danh_muc || 'Thời trang'} • Tình trạng ${sp.tinh_trang}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between w-full md:w-auto gap-6 shrink-0">
                            <div class="text-left md:text-right">
                                <div class="text-xs text-slate-400">Giá niêm yết: ${Number(sp.gia_niem_yet).toLocaleString('vi-VN')} đ</div>
                                <div class="font-bold text-blue-600">Thực nhận: ${Number(sp.gia_nhan).toLocaleString('vi-VN')} đ</div>
                            </div>
                            <button type="button" data-item="${encodeURIComponent(JSON.stringify(sp))}" data-action="edit"
                                class="px-3 py-2 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">edit</span> Chỉnh sửa
                            </button>
                            <button type="button" data-product-id="${Number(sp.id)}" data-action="delete"
                                class="px-3 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 text-xs font-bold transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">delete</span> Xóa
                            </button>
                        </div>
                    </div>
                `).join('');
            }
        });
}

function xoaDoKyGui(productId) {
    if (!productId || !confirm('Bạn có chắc muốn xóa món đồ này khỏi danh sách ký gửi?')) return;

    const formData = new FormData();
    formData.append('action', 'xoa_do');
    formData.append('san_pham_id', productId);

    fetch('xu_ly.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            const form = document.getElementById('form-dang-do');
            if (form && form.elements.namedItem('san_pham_id').value === String(productId)) {
                huySuaDoKyGui();
            }
            taiDanhSachDoCuaToi(currentMyItemsStatus);
        }
    })
    .catch(() => {
        alert('Không thể kết nối để xóa món đồ. Vui lòng thử lại.');
    });
}

function suaDoKyGui(button) {
    const form = document.getElementById('form-dang-do');
    if (!form || !button) return;

    let item;
    try {
        item = JSON.parse(decodeURIComponent(button.dataset.item));
    } catch (error) {
        alert('Không thể tải thông tin sản phẩm cần chỉnh sửa. Vui lòng tải lại trang.');
        return;
    }

    const categorySelect = form.elements.namedItem('danh_muc_id');
    if (![...categorySelect.options].some(option => option.value === String(item.danh_muc_id))) {
        const categoryOption = new Option(item.ten_danh_muc || 'Danh mục hiện tại', String(item.danh_muc_id));
        categoryOption.dataset.editOption = 'true';
        categorySelect.add(categoryOption);
    }

    const conditionSelect = form.elements.namedItem('tinh_trang');
    if (![...conditionSelect.options].some(option => option.value === item.tinh_trang)) {
        const conditionOption = new Option(item.tinh_trang, item.tinh_trang);
        conditionOption.dataset.editOption = 'true';
        conditionSelect.add(conditionOption);
    }

    form.elements.namedItem('san_pham_id').value = item.id;
    form.elements.namedItem('ten_san_pham').value = item.ten_san_pham || '';
    categorySelect.value = item.danh_muc_id || '';
    conditionSelect.value = item.tinh_trang || '';
    form.elements.namedItem('mo_ta').value = item.mo_ta || '';
    form.elements.namedItem('gia_nhan').value = item.gia_nhan || '';
    form.elements.namedItem('gia_niem_yet').value = item.gia_niem_yet || '';

    const imagePreview = document.getElementById('anh-san-pham-preview');
    const imageContainer = document.getElementById('anh-san-pham-hien-tai');
    imagePreview.src = item.hinh_anh || '';
    imageContainer.classList.remove('hidden');
    document.getElementById('tieu-de-form-dang-do').textContent = 'Chỉnh Sửa Thông Tin Món Đồ';
    document.getElementById('nhan-nut-gui-do').textContent = 'Lưu Thay Đổi';
    document.getElementById('huy-sua-do').classList.remove('hidden');
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function huySuaDoKyGui() {
    const form = document.getElementById('form-dang-do');
    if (!form) return;

    form.reset();
    form.elements.namedItem('san_pham_id').value = '';
    form.querySelectorAll('select option[data-edit-option="true"]').forEach(option => option.remove());
    document.getElementById('tieu-de-form-dang-do').textContent = 'Đăng Ký Gửi Món Đồ Mới';
    document.getElementById('nhan-nut-gui-do').textContent = 'Gửi Duyệt Món Đồ Ký Gửi';
    document.getElementById('huy-sua-do').classList.add('hidden');
    document.getElementById('anh-san-pham-hien-tai').classList.add('hidden');
    document.getElementById('anh-san-pham-preview').src = '';
}

// OPEN/CLOSE MODAL HELPERS
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('active');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('active');
}

function switchAuthTab(tab) {
    const loginForm = document.getElementById('login-form-box');
    const registerForm = document.getElementById('register-form-box');
    const tabLoginBtn = document.getElementById('tab-btn-login');
    const tabRegisterBtn = document.getElementById('tab-btn-register');

    if (tab === 'login') {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
        tabLoginBtn.className = 'flex-1 py-2 text-center text-xs font-bold border-b-2 border-blue-600 text-blue-600';
        tabRegisterBtn.className = 'flex-1 py-2 text-center text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800';
    } else {
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
        tabRegisterBtn.className = 'flex-1 py-2 text-center text-xs font-bold border-b-2 border-blue-600 text-blue-600';
        tabLoginBtn.className = 'flex-1 py-2 text-center text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800';
    }
}

// 7. CỬA SỔ CHAT NHỎ GÓC PHẢI (YÊU CẦU ĐĂNG NHẬP)
function openChatWidget(productId, productTitle) {
    if (!requireAuth()) return;

    currentChatProductId = productId;
    const chatWin = document.getElementById('chat-window');
    const chatBubble = document.getElementById('chat-bubble');
    const chatTitle = document.getElementById('chat-product-title');

    if (chatTitle) chatTitle.innerText = productTitle ? `Hỏi về: ${productTitle}` : 'Chat trao đổi người bán';
    if (chatWin) chatWin.classList.add('active');
    if (chatBubble) chatBubble.classList.add('hidden');
}

function closeChatWidget() {
    const chatWin = document.getElementById('chat-window');
    const chatBubble = document.getElementById('chat-bubble');

    if (chatWin) chatWin.classList.remove('active');
    if (chatBubble) chatBubble.classList.remove('hidden');
}

function guiTinNhanChat() {
    if (!requireAuth()) return;

    const input = document.getElementById('chat-input');
    const messagesBox = document.getElementById('chat-messages');

    if (!input || !input.value.trim()) return;

    const noiDung = input.value.trim();
    input.value = '';

    const msgDiv = document.createElement('div');
    msgDiv.className = 'chat-msg me';
    msgDiv.innerText = noiDung;
    messagesBox.appendChild(msgDiv);
    messagesBox.scrollTop = messagesBox.scrollHeight;

    fetch('xu_ly.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=gui_chat&san_pham_id=${currentChatProductId || 0}&noi_dung=${encodeURIComponent(noiDung)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            setTimeout(() => {
                const replyDiv = document.createElement('div');
                replyDiv.className = 'chat-msg other';
                replyDiv.innerText = 'Dạ ConsignHub đã ghi nhận nhắn tin của bạn và thông báo cho người đăng!';
                messagesBox.appendChild(replyDiv);
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }, 800);
        }
    });
}

// 8. CỬA SỔ MUA NGAY (YÊU CẦU ĐĂNG NHẬP)
function openBuyModal(id, title, price, seller, image) {
    if (!requireAuth()) return;

    currentBuyProductId = id;
    document.getElementById('buy-modal-title').innerText = title;
    document.getElementById('buy-modal-price').innerText = Number(price).toLocaleString('vi-VN') + ' đ';
    document.getElementById('buy-modal-seller').innerText = seller;
    document.getElementById('buy-modal-image').src = image;

    openModal('modal-mua-ngay');
}

function xacNhanMuaNgay() {
    if (!requireAuth()) return;

    const phuongThuc = document.querySelector('input[name="phuong_thuc_tt"]:checked')?.value || 'tien_mat';

    fetch('xu_ly.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=mua_ngay&san_pham_id=${currentBuyProductId}&phuong_thuc=${phuongThuc}`
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        closeModal('modal-mua-ngay');
        location.reload();
    });
}

// 9. CỬA SỔ VIẾT ĐÁNH GIÁ (YÊU CẦU ĐĂNG NHẬP)
function openReviewModal() {
    if (!requireAuth()) return;
    openModal('modal-danh-gia');
}

function guiDanhGia() {
    if (!requireAuth()) return;

    const soSao = document.querySelector('input[name="rate_stars"]:checked')?.value || 5;
    const loaiDanhGia = document.getElementById('review-type')?.value || 'dich_vu';
    const noiDung = document.getElementById('review-content')?.value || '';

    if (!noiDung.trim()) {
        alert('Vui lòng viết nội dung đánh giá!');
        return;
    }

    fetch('xu_ly.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=viet_danh_gia&so_sao=${soSao}&loai_danh_gia=${loaiDanhGia}&noi_dung=${encodeURIComponent(noiDung)}`
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        closeModal('modal-danh-gia');
    });
}

// 10. ĐĂNG NHẬP / ĐĂNG KÝ XỬ LÝ
function thucHienDangNhap() {
    const username = document.getElementById('login-username').value.trim();
    const pass = document.getElementById('login-password').value.trim();

    if (!username || !pass) {
        alert('Vui lòng nhập tên đăng nhập và mật khẩu!');
        return;
    }

    fetch('xac_thuc.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=dang_nhap&ten_dang_nhap=${encodeURIComponent(username)}&mat_khau=${encodeURIComponent(pass)}`
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            closeModal('modal-dang-nhap');
            location.reload();
        }
    });
}

function thucHienDangKy() {
    const username = document.getElementById('reg-username').value.trim();
    const pass     = document.getElementById('reg-password').value.trim();
    const fullname = document.getElementById('reg-fullname').value.trim();
    const phone    = document.getElementById('reg-phone').value.trim();
    const email    = document.getElementById('reg-email').value.trim();

    if (!username || !pass || !fullname || !phone) {
        alert('Vui lòng điền đầy đủ các thông tin đăng ký!');
        return;
    }

    fetch('xac_thuc.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=dang_ky&ten_dang_nhap=${encodeURIComponent(username)}&mat_khau=${encodeURIComponent(pass)}&ho_ten=${encodeURIComponent(fullname)}&sdt=${encodeURIComponent(phone)}&email=${encodeURIComponent(email)}`
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            closeModal('modal-dang-nhap');
            location.reload();
        }
    });
}

function thucHienDangXuat() {
    fetch('xac_thuc.php?action=dang_xuat')
        .then(() => location.reload());
}
