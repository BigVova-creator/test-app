const productList = document.getElementById('product-list');
const productsCount = document.getElementById('products-count');
const searchInput = document.getElementById('search-input');
const sortSelect = document.getElementById('sort');
const inStockCheckbox = document.getElementById('in-stock');
const params = new URLSearchParams(window.location.search);
const categoryName = params.get('c') || '';
const isCategoryPage = window.location.pathname.endsWith('category.html');
const memoryOrder = ['64 GB', '128 GB', '256 GB', '512 GB', '1 TB'];

let allProducts = [];

searchInput.value = params.get('q') || '';

function uniqueValues(field) {
    const values = [];
    allProducts.forEach(function (product) {
        if (product[field] && !values.includes(product[field])) {
            values.push(product[field]);
        }
    });
    return values;
}

function fillFilter(field, values) {
    const box = document.getElementById(field + '-box');
    const list = document.getElementById(field + '-filter');
    const selected = params.get(field);

    if (values.length === 0) {
        box.hidden = true;
        return;
    }

    list.innerHTML = values.map(function (value) {
        const checked = value === selected ? 'checked' : '';
        return `<label class="check"><input type="checkbox" name="${field}" value="${value}" ${checked}> ${value}</label>`;
    }).join('');
}

function checkedValues(name) {
    const values = [];
    document.querySelectorAll('input[name="' + name + '"]:checked').forEach(function (input) {
        values.push(input.value);
    });
    return values;
}

function filterProducts() {
    const text = searchInput.value.trim().toLowerCase();
    const brands = checkedValues('brand');
    const memories = checkedValues('memory');
    const types = checkedValues('type');
    const categoryInput = document.querySelector('input[name="category"]:checked');
    const category = categoryInput ? categoryInput.value : '';

    let result = allProducts.filter(function (product) {
        const fullText = (product.brand + ' ' + product.name + ' ' + product.description).toLowerCase();

        if (category && product.category !== category) return false;
        if (brands.length > 0 && !brands.includes(product.brand)) return false;
        if (memories.length > 0 && !memories.includes(product.memory)) return false;
        if (types.length > 0 && !types.includes(product.type)) return false;
        if (inStockCheckbox.checked && product.stock === 0) return false;
        return fullText.includes(text);
    });

    if (sortSelect.value === 'price-asc') {
        result.sort(function (a, b) { return a.price - b.price; });
    } else if (sortSelect.value === 'price-desc') {
        result.sort(function (a, b) { return b.price - a.price; });
    } else if (sortSelect.value === 'name') {
        result.sort(function (a, b) { return (a.brand + a.name).localeCompare(b.brand + b.name); });
    }

    productsCount.textContent = result.length + ' produse';

    if (result.length === 0) {
        productList.innerHTML = '<p class="empty">Nu am găsit niciun produs după filtrele alese.</p>';
        return;
    }

    showProducts(productList, result);
}

function setupPage() {
    if (!isCategoryPage) {
        setActiveNav('products');
        return;
    }

    setActiveNav(categoryName);
    document.title = categoryName + ' - TechStore';
    document.getElementById('page-title').textContent = categoryName;
    document.getElementById('breadcrumbs').innerHTML =
        '<a href="index.html">Acasă</a> / <a href="product.html">Produse</a> / <span></span>';
    document.querySelector('#breadcrumbs span').textContent = categoryName;
}

function loadProducts() {
    let url = API_URL + '?action=products';

    if (isCategoryPage) {
        url += '&category=' + encodeURIComponent(categoryName);
    }

    fetch(url)
        .then(function (response) {
            return response.json();
        })
        .then(function (products) {
            if (products.error) {
                productList.innerHTML = '<p class="empty">' + products.error + '</p>';
                return;
            }

            if (products.length === 0) {
                productList.innerHTML = '<p class="empty">Această categorie nu există. <a href="product.html">Vezi toate produsele</a></p>';
                return;
            }

            allProducts = products;

            fillFilter('brand', uniqueValues('brand').sort());
            fillFilter('memory', memoryOrder.filter(function (memory) {
                return uniqueValues('memory').includes(memory);
            }));
            fillFilter('type', uniqueValues('type').sort());

            filterProducts();
        })
        .catch(function () {
            productList.innerHTML = '<p class="empty">Produsele nu au putut fi încărcate.</p>';
        });
}

document.querySelector('.sidebar').addEventListener('change', filterProducts);
sortSelect.addEventListener('change', filterProducts);
searchInput.addEventListener('input', filterProducts);

searchInput.form.addEventListener('submit', function (event) {
    event.preventDefault();
    filterProducts();
});

document.getElementById('reset-filters').addEventListener('click', function () {
    document.querySelectorAll('.sidebar input[type="checkbox"]').forEach(function (input) {
        input.checked = false;
    });

    const allCategories = document.querySelector('input[name="category"][value=""]');
    if (allCategories) {
        allCategories.checked = true;
    }

    searchInput.value = '';
    sortSelect.value = 'default';
    filterProducts();
});

setupPage();
loadProducts();
