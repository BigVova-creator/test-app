CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    category TEXT NOT NULL,
    description TEXT NOT NULL,
    price INTEGER NOT NULL,
    image TEXT NOT NULL,
    is_popular INTEGER NOT NULL DEFAULT 0
);

INSERT INTO products (name, category, description, price, image, is_popular) VALUES
('Nova X12 Pro', 'Telefoane', 'Ecran AMOLED de 6,7" la 120 Hz, 256 GB memorie și cameră triplă de 108 MP.', 17999, 'phone-blue.svg', 1),
('Pixelon 8', 'Telefoane', 'Android curat, fotografii foarte bune pe timp de noapte și 128 GB memorie.', 10999, 'phone-green.svg', 1),
('Orbit Mini', 'Telefoane', 'Telefon compact de 5,8" cu o baterie care ține până la două zile.', 7499, 'phone-pink.svg', 0),
('SoundWave Max', 'Căști', 'Căști over-ear cu anulare activă a zgomotului și până la 40 de ore de autonomie.', 4999, 'headphones-dark.svg', 1),
('AirBeat Buds', 'Căști', 'Căști wireless cu carcasă de încărcare, rezistente la apă IPX5.', 1299, 'earbuds-white.svg', 1),
('BassPro Studio', 'Căști', 'Căști de studio cu sunet clar și cablu detașabil.', 2799, 'headphones-orange.svg', 0);
