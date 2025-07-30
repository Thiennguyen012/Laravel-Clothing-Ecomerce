// Thêm vào giỏ hàng từ trang chi tiết sản phẩm
function addToCartSingleProduct() {
    // Lấy variant id và số lượng
    const variantId = document.getElementById("selected-variant-id")?.value;
    const quantity = parseInt(
        document.getElementById("quantity")?.value || "1"
    );
    if (!variantId) {
        if (window.showChooseVariantModal) {
            window.showChooseVariantModal();
        } else {
            alert(
                "Vui lòng chọn đầy đủ size và màu sắc trước khi thêm vào giỏ hàng!"
            );
        }
        return;
    }
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    // Lấy giá của variant nếu có
    let price = null;
    if (window.variants && Array.isArray(window.variants)) {
        const variant = window.variants.find((v) => v.id == variantId);
        if (variant) price = variant.price;
    }
    fetch("/cart/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
        },
        body: JSON.stringify({
            variant_id: variantId,
            quantity: quantity,
            price: price,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                updateCartCount && updateCartCount(data.cart_count);
                showAddToCartModal();
            } else {
                alert(data.message || "Thêm vào giỏ hàng thất bại!");
            }
            // Hiển thị modal thông báo thêm vào giỏ hàng thành công
            function showAddToCartModal() {
                const modal = document.getElementById("addToCartSuccessModal");
                if (!modal) return;
                modal.classList.remove("hidden");
                // Tự động ẩn sau 2.5s
                if (window._addToCartModalTimeout)
                    clearTimeout(window._addToCartModalTimeout);
                window._addToCartModalTimeout = setTimeout(() => {
                    modal.classList.add("hidden");
                }, 2500);
            }
            function closeAddToCartModal() {
                const modal = document.getElementById("addToCartSuccessModal");
                if (modal) modal.classList.add("hidden");
            }
            window.showAddToCartModal = showAddToCartModal;
            window.closeAddToCartModal = closeAddToCartModal;
        })
        .catch(() => {
            alert("Có lỗi xảy ra khi thêm vào giỏ hàng!");
        });
}
window.addToCartSingleProduct = addToCartSingleProduct;

// Xây dựng variantMap từ window.variants nếu có
if (window.variants && Array.isArray(window.variants)) {
    window.variantMap = {};
    window.variants.forEach((variant) => {
        if (variant.size && variant.color) {
            if (!window.variantMap[variant.size]) {
                window.variantMap[variant.size] = {};
            }
            window.variantMap[variant.size][variant.color] = variant;
        }
    });
}

window.selectedSize = null;
window.selectedColor = null;
window.selectedVariant = null;

function selectSize(size) {
    if (window.selectedSize === size) {
        window.selectedSize = null;
        window.selectedVariant = null;
        document.querySelectorAll(".size-option").forEach((btn) => {
            btn.classList.remove(
                "border-blue-500",
                "text-blue-600",
                "bg-blue-50"
            );
            if (!btn.disabled)
                btn.classList.add("border-gray-300", "text-gray-700");
        });
        updateColorOptionsWithoutSize();
        hideVariantInfo();
        return;
    }
    window.selectedSize = size;
    window.selectedVariant = null;
    document.querySelectorAll(".size-option").forEach((btn) => {
        btn.classList.remove("border-blue-500", "text-blue-600", "bg-blue-50");
        if (!btn.disabled)
            btn.classList.add("border-gray-300", "text-gray-700");
    });
    const selectedBtn = document.querySelector(`[data-size="${size}"]`);
    selectedBtn.classList.remove("border-gray-300", "text-gray-700");
    selectedBtn.classList.add("border-blue-500", "text-blue-600", "bg-blue-50");
    updateColorOptionsWithSize();
    updateSelectedVariant();
}

function selectColor(color) {
    if (window.selectedColor === color) {
        window.selectedColor = null;
        window.selectedVariant = null;
        document.querySelectorAll(".color-option").forEach((btn) => {
            btn.classList.remove(
                "border-blue-500",
                "text-blue-600",
                "bg-blue-50"
            );
            if (!btn.disabled)
                btn.classList.add("border-gray-300", "text-gray-700");
        });
        updateSizeOptionsWithoutColor();
        hideVariantInfo();
        return;
    }
    window.selectedColor = color;
    window.selectedVariant = null;
    document.querySelectorAll(".color-option").forEach((btn) => {
        btn.classList.remove("border-blue-500", "text-blue-600", "bg-blue-50");
        if (!btn.disabled)
            btn.classList.add("border-gray-300", "text-gray-700");
    });
    const selectedBtn = document.querySelector(`[data-color="${color}"]`);
    if (!selectedBtn.disabled) {
        selectedBtn.classList.remove("border-gray-300", "text-gray-700");
        selectedBtn.classList.add(
            "border-blue-500",
            "text-blue-600",
            "bg-blue-50"
        );
    }
    updateSizeOptionsWithColor();
    updateSelectedVariant();
}

function updateColorOptionsWithSize() {
    document.querySelectorAll(".color-option").forEach((btn) => {
        const color = btn.getAttribute("data-color");
        const variant =
            window.variantMap[window.selectedSize] &&
            window.variantMap[window.selectedSize][color];
        const hasStock = variant && variant.quantity > 0;
        if (hasStock) {
            btn.disabled = false;
            btn.classList.remove(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
            btn.classList.add(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600"
            );
        } else {
            btn.disabled = true;
            btn.classList.remove(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600",
                "border-blue-500",
                "text-blue-600",
                "bg-blue-50"
            );
            btn.classList.add(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
        }
    });
}

function updateColorOptionsWithoutSize() {
    document.querySelectorAll(".color-option").forEach((btn) => {
        const color = btn.getAttribute("data-color");
        const hasAnyStock =
            window.variants.filter((v) => v.color === color && v.quantity > 0)
                .length > 0;
        if (hasAnyStock) {
            btn.disabled = false;
            btn.classList.remove(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
            btn.classList.add(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600"
            );
        } else {
            btn.disabled = true;
            btn.classList.remove(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600",
                "border-blue-500",
                "text-blue-600",
                "bg-blue-50"
            );
            btn.classList.add(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
        }
    });
}

function updateSizeOptionsWithColor() {
    document.querySelectorAll(".size-option").forEach((btn) => {
        const size = btn.getAttribute("data-size");
        const variant =
            window.variantMap[size] &&
            window.variantMap[size][window.selectedColor];
        const hasStock = variant && variant.quantity > 0;
        if (hasStock) {
            btn.disabled = false;
            btn.classList.remove(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
            btn.classList.add(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600"
            );
        } else {
            btn.disabled = true;
            btn.classList.remove(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600",
                "border-blue-500",
                "text-blue-600",
                "bg-blue-50"
            );
            btn.classList.add(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
        }
    });
}

function updateSizeOptionsWithoutColor() {
    document.querySelectorAll(".size-option").forEach((btn) => {
        const size = btn.getAttribute("data-size");
        const hasAnyStock =
            window.variants.filter((v) => v.size === size && v.quantity > 0)
                .length > 0;
        if (hasAnyStock) {
            btn.disabled = false;
            btn.classList.remove(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
            btn.classList.add(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600"
            );
        } else {
            btn.disabled = true;
            btn.classList.remove(
                "border-gray-300",
                "text-gray-700",
                "cursor-pointer",
                "hover:border-blue-500",
                "hover:text-blue-600",
                "border-blue-500",
                "text-blue-600",
                "bg-blue-50"
            );
            btn.classList.add(
                "border-gray-200",
                "text-gray-400",
                "cursor-not-allowed",
                "bg-gray-50"
            );
        }
    });
}

function updateSelectedVariant() {
    if (window.selectedSize && window.selectedColor) {
        window.selectedVariant =
            window.variantMap[window.selectedSize] &&
            window.variantMap[window.selectedSize][window.selectedColor];
        if (window.selectedVariant && window.selectedVariant.quantity > 0) {
            showVariantInfo();
            updateQuantityMax();
        }
    }
}

function showVariantInfo() {
    const infoDiv = document.getElementById("selected-variant-info");
    const detailsSpan = document.getElementById("selected-details");
    const stockSpan = document.getElementById("selected-stock");
    const priceSpan = document.getElementById("selected-price");
    const variantInput = document.getElementById("selected-variant-id");
    detailsSpan.textContent = `Size ${window.selectedSize}, Màu ${window.selectedColor}`;
    stockSpan.textContent = window.selectedVariant.quantity;
    priceSpan.textContent =
        new Intl.NumberFormat("vi-VN").format(window.selectedVariant.price) +
        "đ";
    variantInput.value = window.selectedVariant.id;
    infoDiv.classList.remove("hidden");
}

function hideVariantInfo() {
    const infoDiv = document.getElementById("selected-variant-info");
    const variantInput = document.getElementById("selected-variant-id");
    infoDiv.classList.add("hidden");
    variantInput.value = "";
}

function updateQuantityMax() {
    const quantityInput = document.getElementById("quantity");
    if (window.selectedVariant) {
        quantityInput.max = Math.min(window.selectedVariant.quantity, 10);
        if (parseInt(quantityInput.value) > window.selectedVariant.quantity) {
            quantityInput.value = window.selectedVariant.quantity;
        }
    }
}

function changeMainImage(src) {
    document.getElementById("mainImage").src = src;
}

function decreaseQuantity() {
    const input = document.getElementById("quantity");
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function increaseQuantity() {
    const input = document.getElementById("quantity");
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);
    if (currentValue < maxValue) {
        input.value = currentValue + 1;
    }
}

function showTab(tabName) {
    document.querySelectorAll(".tab-content").forEach((tab) => {
        tab.classList.add("hidden");
    });
    document.querySelectorAll(".tab-button").forEach((button) => {
        button.classList.remove("active", "border-blue-500", "text-blue-600");
        button.classList.add(
            "border-transparent",
            "text-gray-500",
            "hover:text-gray-700",
            "hover:border-gray-300"
        );
    });
    document.getElementById(tabName + "-tab").classList.remove("hidden");
    event.target.classList.remove(
        "border-transparent",
        "text-gray-500",
        "hover:text-gray-700",
        "hover:border-gray-300"
    );
    event.target.classList.add("active", "border-blue-500", "text-blue-600");
}

document.addEventListener("DOMContentLoaded", function () {
    const activeButton = document.querySelector(".tab-button.active");
    if (activeButton) {
        activeButton.classList.add("border-blue-500", "text-blue-600");
        activeButton.classList.remove("border-transparent", "text-gray-500");
    }
    document.querySelectorAll(".tab-button:not(.active)").forEach((button) => {
        button.classList.add(
            "border-transparent",
            "text-gray-500",
            "hover:text-gray-700",
            "hover:border-gray-300"
        );
    });
});

// Gán các hàm vào window để HTML gọi được
window.selectSize = selectSize;
window.selectColor = selectColor;
window.decreaseQuantity = decreaseQuantity;
window.increaseQuantity = increaseQuantity;
window.changeMainImage = changeMainImage;
window.showTab = showTab;
