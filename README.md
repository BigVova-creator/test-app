# TechStore

Magazin online de telefoane și căști, făcut cu PHP, SQLite, HTML, CSS și JavaScript.

## Pornire

Este nevoie de PHP 8 cu extensia `pdo_sqlite`.

```bash
php -S localhost:8000
```

Apoi deschideți http://localhost:8000

Baza de date `storage/database.db` se creează automat la prima pornire, din fișierul `database/schema.sql`.

## Pagini

- `pages/index.html` - pagina principală cu produsele populare
- `pages/product.html` - toate produsele, căutare și filtrare pe categorii
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
storage            baza de date SQLite
index.php          cererile către server
```
