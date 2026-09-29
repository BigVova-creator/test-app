<?php
/**
 * Подключение к SQLite через PDO и создание схемы БД.
 */

const DB_PATH = __DIR__ . '/../database.db';

/**
 * Создаёт таблицы и наполняет каталог тестовыми товарами (если он пуст).
 */
function initDatabase(PDO $pdo): array
{
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS users (
            id            INTEGER PRIMARY KEY AUTOINCREMENT,
            name          TEXT    NOT NULL,
            email         TEXT    NOT NULL UNIQUE,
            password_hash TEXT    NOT NULL,
            created_at    TEXT    NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ');

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS products (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            name        TEXT    NOT NULL,
            category    TEXT    NOT NULL,
            description TEXT    NOT NULL,
            price       INTEGER NOT NULL,
            image       TEXT    NOT NULL,
            is_popular  INTEGER NOT NULL DEFAULT 0
        )
    ');

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS sponsors (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            name       TEXT NOT NULL,
            company    TEXT NOT NULL,
            email      TEXT NOT NULL,
            message    TEXT NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        )
    ');

    $added = 0;
    $count = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();

    if ($count === 0) {
        $products = [
            ['Nova X12 Pro', 'Смартфоны', '6.7" AMOLED 120 Гц, 256 ГБ, тройная камера 108 Мп.', 89990, 'assets/img/phone-blue.svg', 1],
            ['Pixelon 8', 'Смартфоны', 'Чистый Android, отличная ночная съёмка, 128 ГБ.', 54990, 'assets/img/phone-green.svg', 1],
            ['Orbit Mini', 'Смартфоны', 'Компактный 5.8" флагман с батареей на 2 дня.', 39990, 'assets/img/phone-pink.svg', 0],
            ['SoundWave Max', 'Наушники', 'Полноразмерные, активное шумоподавление, 40 ч работы.', 24990, 'assets/img/headphones-dark.svg', 1],
            ['AirBeat Buds', 'Наушники', 'TWS-наушники с кейсом, IPX5, прозрачный режим.', 9990, 'assets/img/earbuds-white.svg', 1],
            ['BassPro Studio', 'Наушники', 'Студийные мониторные наушники с отсоединяемым кабелем.', 15490, 'assets/img/headphones-orange.svg', 0],
        ];

        $stmt = $pdo->prepare('
            INSERT INTO products (name, category, description, price, image, is_popular)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        foreach ($products as $product) {
            $stmt->execute($product);
            $added++;
        }
    }

    return ['products_added' => $added];
}

/**
 * Возвращает единственное PDO-подключение. Если файла БД нет —
 * он будет создан и инициализирован автоматически.
 */
function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $isNew = !file_exists(DB_PATH);

        $pdo = new PDO('sqlite:' . DB_PATH);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('PRAGMA foreign_keys = ON');

        if ($isNew) {
            initDatabase($pdo);
        }
    }

    return $pdo;
}
