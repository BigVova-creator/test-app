<?php
$pageTitle  = 'О магазине';
$activePage = 'about';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>О магазине</h1>
        <p>Мы делаем покупку техники простой, честной и приятной</p>
    </div>
</section>

<section class="container section about-intro">
    <div class="about-text">
        <h2>Кто мы</h2>
        <p>
            TechStore начинался в 2018 году как небольшой шоурум для друзей и знакомых.
            Сегодня это интернет-магазин, которому доверяют более 50 000 покупателей по всей России.
        </p>
        <p>
            Мы продаём только оригинальную технику от официальных поставщиков, тестируем каждую
            новинку сами и честно рассказываем о плюсах и минусах — чтобы вы выбрали именно то, что нужно.
        </p>
    </div>
    <div class="stats">
        <div class="stat"><b>50K+</b><span>довольных клиентов</span></div>
        <div class="stat"><b>8 лет</b><span>на рынке</span></div>
        <div class="stat"><b>4.9 ★</b><span>средняя оценка</span></div>
        <div class="stat"><b>24/7</b><span>поддержка</span></div>
    </div>
</section>

<section class="container section">
    <h2 class="text-center">Наши преимущества</h2>
    <div class="advantages">
        <div class="advantage">
            <span class="advantage-icon">✅</span>
            <h3>Только оригинал</h3>
            <p>Работаем напрямую с дистрибьюторами. Вся техника с официальной гарантией.</p>
        </div>
        <div class="advantage">
            <span class="advantage-icon">⚡</span>
            <h3>Быстрая доставка</h3>
            <p>Курьером за 1 день по Москве, до пунктов выдачи — от 2 дней по стране.</p>
        </div>
        <div class="advantage">
            <span class="advantage-icon">💬</span>
            <h3>Честные консультации</h3>
            <p>Эксперты помогут подобрать гаджет под ваши задачи, а не под план продаж.</p>
        </div>
        <div class="advantage">
            <span class="advantage-icon">💰</span>
            <h3>Лучшие цены</h3>
            <p>Регулярно сравниваем цены с рынком и вернём разницу, если найдёте дешевле.</p>
        </div>
    </div>
</section>

<section class="container section">
    <div class="contacts-card">
        <div>
            <h2>Контакты</h2>
            <ul class="contacts-list">
                <li><span>📍</span> Москва, ул. Цифровая, 42 (ТЦ «Гигабайт», 2 этаж)</li>
                <li><span>📞</span> <a href="tel:+78001234567">8 (800) 123-45-67</a> — бесплатно по России</li>
                <li><span>✉️</span> <a href="mailto:hello@techstore.example">hello@techstore.example</a></li>
                <li><span>🕒</span> Ежедневно с 10:00 до 22:00</li>
            </ul>
        </div>
        <div class="contacts-cta">
            <p>Хотите стать нашим партнёром?</p>
            <a href="sponsors.php" class="btn btn-light">Стать спонсором</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
