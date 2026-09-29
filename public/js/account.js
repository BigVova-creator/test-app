function showCart() {
    const cart = getCart();
    const cartList = document.getElementById('cart-list');
    let total = 0;

    if (cart.length === 0) {
        cartList.innerHTML = '<p class="empty">Coșul este gol. <a href="product.html">Vezi produsele</a></p>';
        document.getElementById('cart-total').textContent = formatPrice(0);
        return;
    }

    cartList.innerHTML = cart.map(function (item) {
        total += item.price * item.quantity;

        return `
            <div class="cart-item">
                <img src="${IMAGES_URL}${item.image}" alt="${item.name}">
                <div class="cart-item-info">
                    <a href="details.html?id=${item.id}">${item.name}</a>
                    <span>${item.quantity} x ${formatPrice(item.price)}</span>
                </div>
                <strong>${formatPrice(item.price * item.quantity)}</strong>
                <button type="button" class="remove-btn" data-id="${item.id}" aria-label="Șterge">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
    }).join('');

    document.getElementById('cart-total').textContent = formatPrice(total);

    cartList.querySelectorAll('.remove-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const newCart = getCart().filter(function (item) {
                return item.id !== Number(button.dataset.id);
            });
            saveCart(newCart);
            showCart();
        });
    });
}

fetch(API_URL + '?action=user')
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        if (!data.user) {
            window.location.href = 'login.html';
            return;
        }

        const date = data.user.createdAt.split(' ')[0].split('-');

        document.getElementById('user-name').textContent = data.user.name;
        document.getElementById('user-email').textContent = data.user.email;
        document.getElementById('user-date').textContent = date[2] + '.' + date[1] + '.' + date[0];
    });

document.getElementById('logout-btn').addEventListener('click', function () {
    fetch(API_URL + '?action=logout', { method: 'POST' })
        .then(function () {
            window.location.href = 'index.html';
        });
});

showCart();
