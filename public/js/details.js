const detailsBox = document.getElementById('product-details');
const productId = new URLSearchParams(window.location.search).get('id');

fetch(API_URL + '?action=product&id=' + encodeURIComponent(productId))
    .then(function (response) {
        return response.json();
    })
    .then(function (product) {
        if (product.error) {
            detailsBox.innerHTML = '<p class="empty">' + product.error + ' <a href="product.html">Înapoi la produse</a></p>';
            return;
        }

        document.title = product.name + ' - TechStore';
        document.getElementById('breadcrumb-name').textContent = product.name;

        detailsBox.innerHTML = `
            <div class="details">
                <div class="details-image">
                    <img src="../public/images/products/${product.image}" alt="${product.name}">
                </div>
                <div class="details-info">
                    <span class="product-category">${product.category}</span>
                    <h1>${product.name}</h1>
                    <p class="details-price">${formatPrice(product.price)}</p>
                    <p class="details-description">${product.description}</p>
                    <ul class="details-list">
                        <li><i class="fa-solid fa-check"></i> În stoc</li>
                        <li><i class="fa-solid fa-truck-fast"></i> Livrare în 1-2 zile</li>
                        <li><i class="fa-solid fa-shield-halved"></i> Garanție 2 ani</li>
                    </ul>
                    <button type="button" class="btn btn-primary" id="add-button">
                        <i class="fa-solid fa-cart-plus"></i> Adaugă în coș
                    </button>
                </div>
            </div>
        `;

        document.getElementById('add-button').addEventListener('click', function () {
            addToCart(product);
        });
    })
    .catch(function () {
        detailsBox.innerHTML = '<p class="empty">Produsul nu a putut fi încărcat.</p>';
    });
