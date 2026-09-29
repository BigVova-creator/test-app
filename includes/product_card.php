<?php
/** Карточка товара. Ожидает переменную $product. */
?>
<article class="product-card"
         data-name="<?= e(mb_strtolower($product['name'])) ?>"
         data-category="<?= e(mb_strtolower($product['category'])) ?>"
         data-description="<?= e(mb_strtolower($product['description'])) ?>">
    <div class="product-image">
        <img src="../<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" loading="lazy">
        <?php if ($product['is_popular']): ?>
            <span class="badge">Хит</span>
        <?php endif; ?>
    </div>
    <div class="product-body">
        <span class="product-category"><?= e($product['category']) ?></span>
        <h3 class="product-name"><?= e($product['name']) ?></h3>
        <p class="product-description"><?= e($product['description']) ?></p>
        <div class="product-footer">
            <span class="product-price"><?= price((int) $product['price']) ?></span>
            <button type="button" class="btn btn-primary btn-sm js-add-to-cart" data-name="<?= e($product['name']) ?>">
                В корзину
            </button>
        </div>
    </div>
</article>
