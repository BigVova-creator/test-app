CREATE DATABASE IF NOT EXISTS techstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE techstore;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    category VARCHAR(50) NOT NULL,
    type VARCHAR(50) DEFAULT NULL,
    price INT NOT NULL,
    memory VARCHAR(20) DEFAULT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    is_popular TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (name, brand, category, type, price, memory, description, image, stock, is_popular) VALUES
('iPhone 15', 'Apple', 'Telefoane', NULL, 16999, '128 GB', 'Ecran Super Retina XDR de 6,1", cip A16 Bionic, cameră principală de 48 MP și port USB-C.', 'apple-iphone-15.svg', 12, 1),
('iPhone 15 Pro', 'Apple', 'Telefoane', NULL, 23999, '256 GB', 'Carcasă din titan, cip A17 Pro, ecran ProMotion de 120 Hz și trei camere.', 'apple-iphone-15-pro.svg', 7, 1),
('iPhone 15 Pro Max', 'Apple', 'Telefoane', NULL, 36999, '1 TB', 'Cel mai mare iPhone, ecran de 6,7", zoom optic 5x și baterie pentru o zi întreagă.', 'apple-iphone-15-pro-max.svg', 3, 0),
('Galaxy S24', 'Samsung', 'Telefoane', NULL, 15999, '256 GB', 'Ecran Dynamic AMOLED 2X de 6,2", procesor Exynos 2400 și funcții Galaxy AI.', 'samsung-galaxy-s24.svg', 10, 1),
('Galaxy S24 Ultra', 'Samsung', 'Telefoane', NULL, 26999, '512 GB', 'Stylus S Pen inclus, cameră de 200 MP, zoom 100x și ramă din titan.', 'samsung-galaxy-s24-ultra.svg', 5, 0),
('Galaxy A55', 'Samsung', 'Telefoane', NULL, 7499, '128 GB', 'Ecran Super AMOLED de 6,6", rezistent la apă IP67 și baterie de 5000 mAh.', 'samsung-galaxy-a55.svg', 20, 1),
('Galaxy A15', 'Samsung', 'Telefoane', NULL, 2999, '64 GB', 'Telefon accesibil cu ecran de 6,5", baterie de 5000 mAh și cameră de 50 MP.', 'samsung-galaxy-a15.svg', 25, 0),
('Xiaomi 14', 'Xiaomi', 'Telefoane', NULL, 14999, '512 GB', 'Camere Leica, procesor Snapdragon 8 Gen 3 și încărcare rapidă de 90 W.', 'xiaomi-14.svg', 6, 0),
('Redmi Note 13 Pro', 'Xiaomi', 'Telefoane', NULL, 5999, '256 GB', 'Cameră de 200 MP, ecran AMOLED de 120 Hz și încărcare rapidă de 67 W.', 'xiaomi-redmi-note-13-pro.svg', 18, 1),
('Pixel 8', 'Google', 'Telefoane', NULL, 12999, '128 GB', 'Android curat cu 7 ani de actualizări, cip Tensor G3 și fotografii excelente.', 'google-pixel-8.svg', 8, 0),
('Pixel 8 Pro', 'Google', 'Telefoane', NULL, 17999, '256 GB', 'Ecran Super Actua de 6,7", trei camere și termometru integrat.', 'google-pixel-8-pro.svg', 0, 0),
('OnePlus 12', 'OnePlus', 'Telefoane', NULL, 14499, '512 GB', 'Snapdragon 8 Gen 3, 16 GB RAM, camere Hasselblad și încărcare de 80 W.', 'oneplus-12.svg', 4, 1),
('AirPods Pro 2', 'Apple', 'Căști', 'In-ear', 4499, NULL, 'Căști wireless cu anulare activă a zgomotului, audio spațial și carcasă USB-C.', 'apple-airpods-pro-2.svg', 15, 1),
('Galaxy Buds2 Pro', 'Samsung', 'Căști', 'In-ear', 2999, NULL, 'Căști wireless cu sunet Hi-Fi de 24 de biți și anulare inteligentă a zgomotului.', 'samsung-galaxy-buds2-pro.svg', 9, 0),
('WH-1000XM5', 'Sony', 'Căști', 'Over-ear', 6499, NULL, 'Căști over-ear wireless cu una dintre cele mai bune anulări de zgomot și 30 de ore de autonomie.', 'sony-wh-1000xm5.svg', 6, 1),
('Husă silicon iPhone 15', 'Apple', 'Accesorii', NULL, 499, NULL, 'Husă din silicon cu interior din microfibră, compatibilă cu MagSafe.', 'apple-husa-iphone-15.svg', 30, 0),
('Sticlă de protecție Galaxy S24', 'Samsung', 'Accesorii', NULL, 249, NULL, 'Sticlă securizată 9H, montare ușoară și compatibilă cu senzorul de amprentă.', 'samsung-sticla-galaxy-s24.svg', 40, 0),
('Încărcător USB-C 20W', 'Apple', 'Încărcătoare', NULL, 449, NULL, 'Încărcător original USB-C de 20 W pentru încărcare rapidă a iPhone-ului.', 'apple-incarcator-20w.svg', 22, 0),
('Încărcător rapid 25W', 'Samsung', 'Încărcătoare', NULL, 399, NULL, 'Încărcător Super Fast Charging de 25 W cu port USB-C.', 'samsung-incarcator-25w.svg', 0, 0),
('Apple Watch Series 9', 'Apple', 'Smartwatch-uri', NULL, 8999, NULL, 'Ecran mai luminos, cip S9, monitorizare a pulsului și a somnului.', 'apple-watch-series-9.svg', 5, 1),
('Galaxy Watch6', 'Samsung', 'Smartwatch-uri', NULL, 5499, NULL, 'Ecran rotund Super AMOLED, analiză a compoziției corporale și GPS.', 'samsung-galaxy-watch6.svg', 7, 0);
