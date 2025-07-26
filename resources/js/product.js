// Xử lý bộ lọc sản phẩm cho trang sản phẩm

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    // Set checkbox states based on URL parameters
    const inStockCheckbox = document.getElementById("inStockCheckbox");
    if (inStockCheckbox && urlParams.get("inStock") === "true") {
        inStockCheckbox.checked = true;
    }
    // Set category radio based on URL parameters
    const categoryId = urlParams.get("categoryId");
    if (categoryId) {
        const categoryRadio = document.querySelector(
            `input[name="category"][value="${categoryId}"]`
        );
        if (categoryRadio) {
            categoryRadio.checked = true;
        }
    }
    // Set price range radio based on URL parameters
    const minPrice = urlParams.get("minPrice");
    const maxPrice = urlParams.get("maxPrice");
    if (minPrice && maxPrice) {
        let priceRangeValue = "";
        if (minPrice == 0 && maxPrice == 500000) {
            priceRangeValue = "0-500000";
        } else if (minPrice == 500000 && maxPrice == 1000000) {
            priceRangeValue = "500000-1000000";
        } else if (minPrice == 1000000 && maxPrice == 2000000) {
            priceRangeValue = "1000000-2000000";
        } else if (minPrice == 2000000 && maxPrice == 999999999) {
            priceRangeValue = "2000000+";
        }
        if (priceRangeValue) {
            const priceRadio = document.querySelector(
                `input[name="price_range"][value="${priceRangeValue}"]`
            );
            if (priceRadio) {
                priceRadio.checked = true;
            }
        }
    }
    // Set sort select based on URL parameters
    const order = urlParams.get("order");
    const sortSelect = document.querySelector('select[name="sort"]');
    if (order && sortSelect) {
        sortSelect.value = order;
    }
});

window.filterProducts = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const category = document.querySelector('input[name="category"]:checked');
    const priceRange = document.querySelector(
        'input[name="price_range"]:checked'
    );
    const inStock = document.querySelector('input[name="in_stock"]:checked');
    const sortSelect = document.querySelector('select[name="sort"]');
    let params = new URLSearchParams(window.location.search);
    params.delete("categoryId");
    if (category && category.value) {
        params.set("categoryId", category.value);
    }
    params.delete("minPrice");
    params.delete("maxPrice");
    if (priceRange && priceRange.value) {
        switch (priceRange.value) {
            case "0-500000":
                params.set("minPrice", 0);
                params.set("maxPrice", 500000);
                break;
            case "500000-1000000":
                params.set("minPrice", 500000);
                params.set("maxPrice", 1000000);
                break;
            case "1000000-2000000":
                params.set("minPrice", 1000000);
                params.set("maxPrice", 2000000);
                break;
            case "2000000+":
                params.set("minPrice", 2000000);
                params.set("maxPrice", 999999999);
                break;
        }
    }
    params.delete("inStock");
    if (inStock && inStock.checked) {
        params.set("inStock", "true");
    }
    params.delete("order");
    if (sortSelect && sortSelect.value && sortSelect.value !== "newest") {
        params.set("order", sortSelect.value);
    }
    window.location.href = "/products?" + params.toString();
};

window.handleSortChange = function (value) {
    filterProducts();
};

window.clearFilters = function () {
    window.location.href = "/products";
};

window.removeFilter = function (filterName) {
    const urlParams = new URLSearchParams(window.location.search);
    switch (filterName) {
        case "category":
            urlParams.delete("categoryId");
            break;
        case "price_range":
            urlParams.delete("minPrice");
            urlParams.delete("maxPrice");
            break;
        case "in_stock":
            urlParams.delete("inStock");
            break;
        case "sort":
            urlParams.delete("order");
            break;
    }
    const queryString = urlParams.toString();
    if (queryString) {
        window.location.href = "/products?" + queryString;
    } else {
        window.location.href = "/products";
    }
};
