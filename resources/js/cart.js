// cart.js - Xử lý riêng cho trang giỏ hàng

// Biến lưu trữ variant_id cần xóa
let currentDeleteVariantId = null;

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
                showNotification("success", "Đã cập nhật số lượng sản phẩm");
                // Reload page after a short delay to show the notification
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(
                    "error",
                    data.message || "Không thể cập nhật số lượng"
                );
            }
        })
        .catch((error) => {
            showNotification("error", "Có lỗi xảy ra khi cập nhật số lượng");
        });
}

function removeItem(variantId) {
    // Lưu variant_id và hiển thị modal
    currentDeleteVariantId = variantId;
    showDeleteModal();
}

function showDeleteModal() {
    const modal = document.getElementById("deleteConfirmModal");
    if (modal) {
        modal.classList.remove("hidden");
    }
}

function closeDeleteModal() {
    const modal = document.getElementById("deleteConfirmModal");
    if (modal) {
        modal.classList.add("hidden");
    }
    currentDeleteVariantId = null;
}

function confirmDelete() {
    if (!currentDeleteVariantId) return;

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
            variant_id: currentDeleteVariantId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            closeDeleteModal();
            if (data.success) {
                showNotification("success", "Đã xóa sản phẩm khỏi giỏ hàng");
                // Reload page after a short delay to show the notification
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(
                    "error",
                    data.message || "Không thể xóa sản phẩm"
                );
            }
        })
        .catch((error) => {
            closeDeleteModal();
            showNotification("error", "Có lỗi xảy ra khi xóa sản phẩm");
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
                showNotification("success", "Đã xóa toàn bộ giỏ hàng");
                // Reload page after a short delay to show the notification
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(
                    "error",
                    data.message || "Không thể xóa giỏ hàng"
                );
            }
        })
        .catch((error) => {
            showNotification("error", "Có lỗi xảy ra khi xóa giỏ hàng");
        });
}

// Function to show notification
function showNotification(type, message) {
    // Tạo notification element
    const notification = document.createElement("div");
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300 transform translate-x-full`;

    if (type === "success") {
        notification.className += " bg-green-500 text-white";
    } else {
        notification.className += " bg-red-500 text-white";
    }

    notification.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                ${
                    type === "success"
                        ? '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                        : '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
                }
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <div class="ml-4 flex-shrink-0">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;

    // Thêm vào DOM
    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove("translate-x-full");
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add("translate-x-full");
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Gán các hàm vào window để HTML gọi được
window.updateQuantity = updateQuantity;
window.removeItem = removeItem;
window.clearCart = clearCart;
window.showNotification = showNotification;
window.showDeleteModal = showDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.confirmDelete = confirmDelete;
