# TechStore

Magazin online de telefoane, căști și accesorii, făcut cu PHP, MySQL, HTML, CSS și JavaScript.

## Pornire cu XAMPP

1. Copiați folderul proiectului în `C:\xampp\htdocs\techstore`.
2. Porniți **Apache** și **MySQL** din XAMPP Control Panel.
3. Deschideți http://localhost/techstore

Baza de date `techstore` se creează automat la prima pornire, din fișierul `database/schema.sql`.
Se poate importa și manual din phpMyAdmin (Import -> `database/schema.sql`).

Datele de conectare la MySQL sunt în `config/database.php` (implicit utilizatorul `root` fără parolă, ca în XAMPP).

## Pagini

- `pages/index.html` - pagina principală
- `pages/product.html` - toate produsele cu filtre
- `pages/category.html` - produsele unei categorii (de exemplu `category.html?c=Telefoane`)
- `pages/details.html` - pagina unui produs
- `pages/login.html` - autentificare
- `pages/register.html` - înregistrare
- `pages/account.html` - contul utilizatorului și coșul

## Structura

```
app/Models         Product.php, User.php
app/Services       ProductService.php, UserService.php
config             database.php
database           schema.sql
public             css, js, images
pages              paginile HTML
index.php          cererile către server
```
