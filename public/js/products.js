const productList = document.getElementById('product-list');
const productsCount = document.getElementById('products-count');
const searchInput = document.getElementById('search-input');
const categoryButtons = document.querySelectorAll('.category-btn');
const params = new URLSearchParams(window.location.search);

let allProducts = [];
let currentCategory = params.get('category') || 'Toate';

searchInput.value = params.get('q') || '';

function filterProducts() {
    const text = searchInput.value.trim().toLowerCase();

    const filtered = allProducts.filter(function (product) {
        const sameCategory = currentCategory === 'Toate' || product.category === currentCategory;
        const hasText = product.name.toLowerCase().includes(text)
            || product.description.toLowerCase().includes(text);
        return sameCategory && hasText;
    });

    productsCount.textContent = filtered.length + ' produse';

    if (filtered.length === 0) {
        productList.innerHTML = '<p class="empty">Nu am găsit niciun produs.</p>';
        return;
    }

    showProducts(productList, filtered);
}

function setActiveButton() {
    categoryButtons.forEach(function (button) {
        button.classList.toggle('active', button.dataset.category === currentCategory);
    });
}

categoryButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        currentCategory = button.dataset.category;
        setActiveButton();
        filterProducts();
    });
});

searchInput.addEventListener('input', filterProducts);

searchInput.form.addEventListener('submit', function (event) {
    event.preventDefault();
    filterProducts();
});

setActiveButton();

fetch(API_URL + '?action=products')
    .then(function (response) {
        return response.json();
    })
    .then(function (products) {
        allProducts = products;
        filterProducts();
    })
    .catch(function () {
        productList.innerHTML = '<p class="empty">Produsele nu au putut fi încărcate.</p>';
    });
