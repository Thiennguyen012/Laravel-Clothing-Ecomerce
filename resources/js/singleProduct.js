// singleProduct.js - Xử lý riêng cho trang chi tiết sản phẩm

// Variant data from PHP (inject vào view)
window.variants = window.variants || [];
window.variantMap = window.variantMap || {};
window.selectedSize = null;
window.selectedColor = null;
window.selectedVariant = null;

// Các hàm xử lý chọn size, color, cập nhật variant, quantity, tab, ...
// (Copy logic từ script trong singleProduct.blade.php, loại bỏ phần lấy variants từ @json nếu đã có)

// ... (Đặt toàn bộ code JS xử lý variant, tab, quantity, ... ở đây)

// Để sử dụng được biến từ blade, trong blade phải có:
// <script>window.variants = @json($product->variants ?? []);</script>
