<?php
$pageTitle  = 'Каталог';
$activePage = 'catalog';
require_once __DIR__ . '/../includes/header.php';

$products = db()->query('SELECT * FROM products ORDER BY category DESC, price DESC')->fetchAll();

// Группируем товары по категориям
$categories = [
    'Смартфоны' => ['id' => 'smartphones', 'icon' => '📱', 'items' => []],
    'Наушники'  => ['id' => 'headphones', 'icon' => '🎧', 'items' => []],
];
foreach ($products as $product) {
    $categories[$product['category']]['items'][] = $product;
}
?>

<section class="page-hero">
    <div class="container">
        <h1>Каталог</h1>
        <p>Смартфоны и наушники от проверенных производителей</p>
    </div>
</section>

<section class="container section">
    <div class="search-box">
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
        <input type="search" id="live-search" placeholder="Начните вводить название товара…" autocomplete="off" aria-label="Поиск товаров">
        <span class="search-count" id="search-count"></span>
    </div>

    <?php foreach ($categories as $title => $category): ?>
        <?php if (!$category['items']) continue; ?>
        <div class="category-block" id="<?= $category['id'] ?>">
            <h2 class="category-title"><?= $category['icon'] ?> <?= e($title) ?></h2>
            <div class="product-grid">
                <?php foreach ($category['items'] as $product): ?>
                    <?php include __DIR__ . '/../includes/product_card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="empty-state" id="no-results" hidden>
        <span>🔍</span>
        <p>По вашему запросу ничего не найдено</p>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
