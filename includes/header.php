<?php
/**
 * Общая шапка сайта.
 * Перед подключением задайте $pageTitle и $activePage.
 */
require_once __DIR__ . '/functions.php';

$pageTitle  = $pageTitle ?? 'TechStore';
$activePage = $activePage ?? '';
$user       = currentUser();

$navItems = [
    'home'     => ['index.php', 'Главная'],
    'catalog'  => ['catalog.php', 'Каталог'],
    'about'    => ['about.php', 'О магазине'],
    'sponsors' => ['sponsors.php', 'Спонсорам'],
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — TechStore</title>
    <link rel="icon" href="../assets/img/logo.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo" aria-label="TechStore — на главную">
            <img src="../assets/img/logo.svg" alt="" width="36" height="36">
            <span>Tech<b>Store</b></span>
        </a>

        <button class="burger" type="button" aria-label="Открыть меню" aria-expanded="false" aria-controls="main-nav">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-wrap" id="main-nav">
            <nav class="main-nav">
                <?php foreach ($navItems as $key => [$href, $label]): ?>
                    <a href="<?= $href ?>" class="<?= $activePage === $key ? 'active' : '' ?>"><?= $label ?></a>
                <?php endforeach; ?>
            </nav>

            <div class="auth-buttons">
                <?php if ($user): ?>
                    <span class="user-greeting">👋 <?= e($user['name']) ?></span>
                    <a href="logout.php" class="btn btn-outline btn-sm">Выйти</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline btn-sm <?= $activePage === 'login' ? 'active' : '' ?>">Вход</a>
                    <a href="register.php" class="btn btn-primary btn-sm">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<?php $flashes = takeFlashes(); ?>
<?php if ($flashes): ?>
    <div class="container flash-container">
        <?php foreach ($flashes as $flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<main>
