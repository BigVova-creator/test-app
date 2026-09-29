const API_URL = '../index.php';

function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ') + ' lei';
}

function getCart() {
    try {
        return JSON.parse(localStorage.getItem('cart')) || [];
    } catch (error) {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

function addToCart(product) {
    const cart = getCart();
    const item = cart.find(function (cartItem) {
        return cartItem.id === product.id;
    });

    if (item) {
        item.quantity++;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }

    saveCart(cart);
    showMessage('Produsul a fost adăugat în coș.');
}

function updateCartCount() {
    let count = 0;
    getCart().forEach(function (item) {
        count += item.quantity;
    });
    document.getElementById('cart-count').textContent = count;
}

function showMessage(text) {
    const message = document.getElementById('message');
    message.textContent = text;
    message.hidden = false;

    clearTimeout(showMessage.timer);
    showMessage.timer = setTimeout(function () {
        message.hidden = true;
    }, 2500);
}

function productCard(product) {
    return `
        <div class="product-card">
            <a href="details.html?id=${product.id}" class="product-image">
                <img src="../public/images/products/${product.image}" alt="${product.name}">
            </a>
            <div class="product-info">
                <span class="product-category">${product.category}</span>
                <h3><a href="details.html?id=${product.id}">${product.name}</a></h3>
                <p class="product-price">${formatPrice(product.price)}</p>
                <div class="product-buttons">
                    <a href="details.html?id=${product.id}" class="btn btn-outline">Detalii</a>
                    <button type="button" class="btn btn-primary add-to-cart" data-id="${product.id}">
                        <i class="fa-solid fa-cart-plus"></i> Cumpără
                    </button>
                </div>
            </div>
        </div>
    `;
}

function showProducts(container, products) {
    container.innerHTML = products.map(productCard).join('');

    container.querySelectorAll('.add-to-cart').forEach(function (button) {
        button.addEventListener('click', function () {
            const product = products.find(function (item) {
                return item.id === Number(button.dataset.id);
            });
            addToCart(product);
        });
    });
}

function loadUser() {
    fetch(API_URL + '?action=user')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.user) {
                const link = document.getElementById('account-link');
                link.href = 'account.html';
                link.querySelector('span').textContent = data.user.name;
            }
        });
}

document.getElementById('menu-btn').addEventListener('click', function () {
    document.getElementById('nav').classList.toggle('open');
});

updateCartCount();
loadUser();

const popularProducts = document.getElementById('popular-products');

if (popularProducts) {
    fetch(API_URL + '?action=products')
        .then(function (response) {
            return response.json();
        })
        .then(function (products) {
            const popular = products.filter(function (product) {
                return product.isPopular;
            });
            showProducts(popularProducts, popular);
        })
        .catch(function () {
            popularProducts.innerHTML = '<p class="empty">Produsele nu au putut fi încărcate.</p>';
        });
}
