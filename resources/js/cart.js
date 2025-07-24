// cart.js - Xử lý riêng cho trang giỏ hàng

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
                window.location.reload();
            } else {
                alert(
                    "Không thể cập nhật số lượng: " +
                        (data.message || "Lỗi không xác định")
                );
            }
        })
        .catch((error) => {
            alert("Có lỗi xảy ra khi cập nhật số lượng");
        });
}

function removeItem(variantId) {
    if (!confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) return;
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
                window.location.reload();
            } else {
                alert(
                    "Không thể xóa sản phẩm: " +
                        (data.message || "Lỗi không xác định")
                );
            }
        })
        .catch((error) => {
            alert("Có lỗi xảy ra khi xóa sản phẩm");
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
                window.location.reload();
            } else {
                alert(
                    "Không thể xóa giỏ hàng: " +
                        (data.message || "Lỗi không xác định")
                );
            }
        })
        .catch((error) => {
            alert("Có lỗi xảy ra khi xóa giỏ hàng");
        });
}

window.updateQuantity = updateQuantity;
window.removeItem = removeItem;
window.clearCart = clearCart;
