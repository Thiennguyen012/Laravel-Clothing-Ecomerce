// cart.js - Xử lý riêng cho trang giỏ hàng

// Hàm hiển thị thông báo đẹp
function showNotification(message, type = "info") {
    // Xóa thông báo cũ nếu có
    const existingNotification = document.querySelector(".cart-notification");
    if (existingNotification) {
        existingNotification.remove();
    }

    // Tạo thông báo mới
    const notification = document.createElement("div");
    notification.className = "cart-notification";

    const colors = {
        success: "border-green-400 bg-green-50 text-green-800",
        error: "border-red-400 bg-red-50 text-red-800",
        info: "border-blue-400 bg-blue-50 text-blue-800",
    };

    const icons = {
        success:
            '<svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
        error: '<svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
        info: '<svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>',
    };

    notification.innerHTML = `
        <div class="border-l-4 p-4 ${colors[type]} vietnamese-text">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${icons[type]}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(notification);

    // Tự động ẩn sau 5 giây
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Hàm hiển thị toast notification mới
function showCartToast(message = "Cập nhật số lượng thành công!") {
    const toast = document.getElementById("cart-toast");
    const msg = document.getElementById("cart-toast-message");
    if (msg) msg.textContent = message;
    toast.classList.remove("hidden");
    setTimeout(() => {
        toast.classList.add("hidden");
    }, 2500);
}

// Các hàm xử lý cập nhật số lượng, xóa sản phẩm, xóa toàn bộ giỏ hàng
function updateQuantity(variantId, newQuantity) {
    if (newQuantity < 1) return;
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    fetch("/cart/update", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
        },
        body: JSON.stringify({
            variant_id: variantId,
            quantity: newQuantity,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showCartToast("Cập nhật số lượng thành công!");
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotification(
                    "Không thể cập nhật số lượng: " +
                        (data.message || "Lỗi không xác định"),
                    "error"
                );
            }
        })
        .catch((error) => {
            showNotification("Có lỗi xảy ra khi cập nhật số lượng", "error");
        });
}

// Hàm hiển thị modal confirm delete
function showDeleteModal(variantId) {
    const modal = document.getElementById("delete-modal");
    const confirmBtn = document.getElementById("confirm-delete");

    // Lưu variantId để sử dụng khi confirm
    confirmBtn.setAttribute("data-variant-id", variantId);

    modal.classList.remove("hidden");
}

// Hàm đóng modal confirm delete
function closeDeleteModal() {
    const modal = document.getElementById("delete-modal");
    modal.classList.add("hidden");
}

// Hàm xử lý khi user confirm xóa
function confirmDelete() {
    const confirmBtn = document.getElementById("confirm-delete");
    const variantId = confirmBtn.getAttribute("data-variant-id");

    closeDeleteModal();
    removeItem(variantId);
}

function removeItem(variantId) {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    fetch("/cart/remove", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
        },
        body: JSON.stringify({
            variant_id: variantId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showCartToast("Đã xóa sản phẩm khỏi giỏ hàng!");
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotification(
                    "Không thể xóa sản phẩm: " +
                        (data.message || "Lỗi không xác định"),
                    "error"
                );
            }
        })
        .catch((error) => {
            showNotification("Có lỗi xảy ra khi xóa sản phẩm", "error");
        });
}

function clearCart() {
    if (!confirm("Bạn có chắc muốn xóa toàn bộ giỏ hàng?")) return;
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    fetch("/cart/clear", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showNotification("Đã xóa toàn bộ giỏ hàng!", "success");
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotification(
                    "Không thể xóa giỏ hàng: " +
                        (data.message || "Lỗi không xác định"),
                    "error"
                );
            }
        })
        .catch((error) => {
            showNotification("Có lỗi xảy ra khi xóa giỏ hàng", "error");
        });
}

window.updateQuantity = updateQuantity;
window.removeItem = removeItem;
window.clearCart = clearCart;
window.showDeleteModal = showDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.confirmDelete = confirmDelete;
