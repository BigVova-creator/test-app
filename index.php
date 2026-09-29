<?php
$pageTitle  = 'Главная';
$activePage = 'home';
require_once __DIR__ . '/includes/header.php';

$popular = db()->query('SELECT * FROM products WHERE is_popular = 1 ORDER BY id')->fetchAll();

$slides = [
    [
        'title' => 'Скидки до −30% на смартфоны',
        'text'  => 'Только до конца месяца — флагманы по цене среднего класса.',
        'cta'   => 'Смотреть смартфоны',
        'href'  => 'catalog.php#smartphones',
        'class' => 'slide-blue',
        'icon'  => 'assets/img/phone-blue.svg',
    ],
    [
        'title' => 'Наушники в подарок',
        'text'  => 'При покупке любого смартфона от 50 000 ₽ — AirBeat Buds бесплатно.',
        'cta'   => 'Подробнее',
        'href'  => 'catalog.php#headphones',
        'class' => 'slide-purple',
        'icon'  => 'assets/img/earbuds-white.svg',
    ],
    [
        'title' => 'Бесплатная доставка',
        'text'  => 'Доставим любой заказ за 1 день по Москве и за 3 дня по России.',
        'cta'   => 'В каталог',
        'href'  => 'catalog.php',
        'class' => 'slide-orange',
        'icon'  => 'assets/img/headphones-orange.svg',
    ],
];
?>

<section class="container section">
    <div class="slider" data-autoplay="5000" aria-roledescription="carousel" aria-label="Акции магазина">
        <div class="slider-track">
            <?php foreach ($slides as $i => $slide): ?>
                <div class="slide <?= $slide['class'] ?>" role="group" aria-label="Слайд <?= $i + 1 ?> из <?= count($slides) ?>">
                    <div class="slide-content">
                        <span class="slide-tag">Акция</span>
                        <h2><?= e($slide['title']) ?></h2>
                        <p><?= e($slide['text']) ?></p>
                        <a href="<?= $slide['href'] ?>" class="btn btn-light"><?= e($slide['cta']) ?></a>
                    </div>
                    <img class="slide-image" src="<?= $slide['icon'] ?>" alt="" aria-hidden="true">
                </div>
            <?php endforeach; ?>
        </div>

        <button class="slider-btn slider-prev" type="button" aria-label="Предыдущий слайд">‹</button>
        <button class="slider-btn slider-next" type="button" aria-label="Следующий слайд">›</button>
        <div class="slider-dots" role="tablist"></div>
    </div>
</section>

<section class="container section">
    <div class="features">
        <div class="feature"><span>🚚</span><div><b>Доставка за 1 день</b><small>По Москве и области</small></div></div>
        <div class="feature"><span>🛡️</span><div><b>Гарантия 2 года</b><small>Официальная техника</small></div></div>
        <div class="feature"><span>💳</span><div><b>Рассрочка 0%</b><small>Без переплат</small></div></div>
        <div class="feature"><span>↩️</span><div><b>Возврат 14 дней</b><small>Без лишних вопросов</small></div></div>
    </div>
</section>

<section class="container section">
    <div class="section-head">
        <h2>Популярные товары</h2>
        <a href="catalog.php" class="link-arrow">Весь каталог →</a>
    </div>
    <div class="product-grid">
        <?php foreach ($popular as $product): ?>
            <?php include __DIR__ . '/includes/product_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
