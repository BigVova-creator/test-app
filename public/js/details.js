const detailsBox = document.getElementById('product-details');
const productId = new URLSearchParams(window.location.search).get('id');

function showSimilar(product) {
    fetch(API_URL + '?action=products&category=' + encodeURIComponent(product.category))
        .then(function (response) {
            return response.json();
        })
        .then(function (products) {
            const similar = products.filter(function (item) {
                return item.id !== product.id;
            }).slice(0, 4);

            if (similar.length > 0) {
                document.getElementById('similar-section').hidden = false;
                showProducts(document.getElementById('similar-products'), similar);
            }
        })
        .catch(function () {});
}

fetch(API_URL + '?action=product&id=' + encodeURIComponent(productId))
    .then(function (response) {
        return response.json();
    })
    .then(function (product) {
        if (product.error) {
            detailsBox.innerHTML = '<p class="empty">' + product.error + ' <a href="product.html">Înapoi la produse</a></p>';
            return;
        }

        const categoryLink = document.getElementById('breadcrumb-category');
        categoryLink.textContent = product.category;
        categoryLink.href = 'category.html?c=' + encodeURIComponent(product.category);
        document.getElementById('breadcrumb-name').textContent = productName(product);
        document.title = productName(product) + ' - TechStore';
        setActiveNav(product.category);

        let specs = '<li><span>Brand</span> ' + product.brand + '</li>';
        specs += '<li><span>Categorie</span> ' + product.category + '</li>';
        if (product.memory) {
            specs += '<li><span>Memorie</span> ' + product.memory + '</li>';
        }
        if (product.type) {
            specs += '<li><span>Tip</span> ' + product.type + '</li>';
        }
        specs += '<li><span>Disponibilitate</span> ' + (product.stock > 0 ? product.stock + ' buc. în stoc' : 'Stoc epuizat') + '</li>';

        detailsBox.innerHTML = `
            <div class="details">
                <div class="details-image">
                    <img src="${IMAGES_URL}${product.image}" alt="${productName(product)}">
                </div>
                <div class="details-info">
                    <span class="product-category">${product.category}</span>
                    <h1>${productName(product)}</h1>
                    ${stockText(product)}
                    <p class="details-price">${formatPrice(product.price)}</p>
                    <p class="details-description">${product.description}</p>
                    <ul class="details-specs">${specs}</ul>
                    <button type="button" class="btn btn-primary" id="add-button" ${product.stock === 0 ? 'disabled' : ''}>
                        <i class="fa-solid fa-cart-plus"></i> Adaugă în coș
                    </button>
                    <ul class="details-list">
                        <li><i class="fa-solid fa-truck-fast"></i> Livrare în 1-2 zile</li>
                        <li><i class="fa-solid fa-shield-halved"></i> Garanție 2 ani</li>
                        <li><i class="fa-solid fa-rotate-left"></i> Retur în 14 zile</li>
                    </ul>
                </div>
            </div>
        `;

        document.getElementById('add-button').addEventListener('click', function () {
            addToCart(product);
        });

        showSimilar(product);
    })
    .catch(function () {
        detailsBox.innerHTML = '<p class="empty">Produsul nu a putut fi încărcat.</p>';
    });
