// Products page JavaScript functionality
console.log("Products.js loaded");

// Function to handle filters and URL parameters
function clearFilters() {
    // Xóa tất cả filter parameters
    var params = new URLSearchParams(window.location.search);
    params.delete("categoryId");
    params.delete("price_range");
    params.delete("minPrice");
    params.delete("maxPrice");
    params.delete("inStock");
    params.delete("order");
    params.set("page", 1);
    window.location.search = params.toString();
}

function removeFilter(filterType) {
    var params = new URLSearchParams(window.location.search);
    switch (filterType) {
        case "category":
            params.delete("categoryId");
            break;
        case "price_range":
            params.delete("price_range");
            params.delete("minPrice");
            params.delete("maxPrice");
            break;
        case "in_stock":
            params.delete("inStock");
            break;
        case "sort":
            params.delete("order");
            break;
    }
    params.set("page", 1);
    window.location.search = params.toString();
}

function handleSortChange(sortValue) {
    var params = new URLSearchParams(window.location.search);
    if (sortValue) {
        params.set("order", sortValue);
    } else {
        params.delete("order");
    }
    params.set("page", 1);
    window.location.search = params.toString();
}

// Export functions for global access
window.clearFilters = clearFilters;
window.removeFilter = removeFilter;
window.handleSortChange = handleSortChange;
