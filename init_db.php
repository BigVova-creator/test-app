<?php
/**
 * Инициализация базы данных.
 * Запуск: php init_db.php  или откройте /init_db.php в браузере.
 * Создаёт database.db, таблицы users / products / sponsors и тестовые товары.
 * Повторный запуск безопасен — существующие данные не дублируются.
 */

require_once __DIR__ . '/includes/db.php';

$existed = file_exists(DB_PATH);

$pdo = new PDO('sqlite:' . DB_PATH);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = initDatabase($pdo);

$lines = [
    $existed ? 'Файл database.db уже существовал.' : 'Файл database.db создан.',
    'Таблицы users, products, sponsors готовы.',
    $result['products_added'] > 0
        ? "Добавлено тестовых товаров: {$result['products_added']}."
        : 'Товары уже есть в каталоге — пропускаем наполнение.',
];

if (PHP_SAPI === 'cli') {
    echo implode(PHP_EOL, $lines) . PHP_EOL;
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Инициализация БД — TechStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="container section">
    <div class="auth-card">
        <h1>База данных готова ✅</h1>
        <ul class="init-list">
            <?php foreach ($lines as $line): ?>
                <li><?= htmlspecialchars($line) ?></li>
            <?php endforeach; ?>
        </ul>
        <a class="btn btn-primary btn-block" href="pages/index.php">Перейти на главную</a>
    </div>
</main>
</body>
</html>
