# Hardware Store

A PHP and MySQL web application for browsing computer hardware and managing a shopping cart. Built as a school project with Bootstrap and custom CSS.

## Features

- Product categories for processors, graphics cards, motherboards, cases, power supplies, RAM, and storage
- Individual product pages with images, descriptions, and prices
- User registration and login with hashed passwords
- Session-based shopping cart with quantity updates, item removal, and subtotal calculation
- Shared PHP template for category pages

## Built With

- PHP and PDO
- MySQL or MariaDB
- HTML, CSS, and Bootstrap 5.2.3
- JavaScript and jQuery

## Getting Started

### Requirements

- Apache with PHP support
- PHP 8 or later with the `pdo_mysql` extension enabled
- MySQL or MariaDB
- An internet connection for the external stylesheets, scripts, and icons

A local environment such as XAMPP can provide Apache, PHP, and MariaDB.

### Installation

1. Clone this repository or download and extract its ZIP archive.
2. Place the project in your Apache document root, for example `htdocs/hardware-store` when using XAMPP.
3. Start Apache and MySQL/MariaDB.
4. Import `database.sql` using phpMyAdmin or the MySQL command-line client. The script creates the `hardware_store` database and its tables, then inserts sample products.
5. Update the database connection settings to match your local environment.
6. Open `http://localhost/hardware-store/` in your browser. Adjust the URL if you use a different folder name or Apache port.

### Database Configuration

The included connection settings are:

| Setting | Value |
| --- | --- |
| Host | `127.0.0.1` |
| Port | `3307` |
| Database | `hardware_store` |
| Username | `root` |
| Password | Empty |

Database connections are currently defined in `classes/dbh.classes.php`, `home.php`, `product.php`, `cart.php`, `update_cart.php`, and the seven category pages. Update each connection if your settings differ. For example, many local installations use port `3306`.

```php
$username = "root";
$password = "";
$pdo = new PDO(
    'mysql:host=127.0.0.1;port=3307;dbname=hardware_store;charset=utf8mb4',
    $username,
    $password
);
```

## Project Structure

```text
classes/                         Registration, login, and database classes
includes/                        Form handlers and shared category template
Ref/                             Product images and other image assets
home.php                         Home page and featured products
product.php                      Product details
cart.php                         Shopping cart
update_cart.php                  Cart quantity update endpoint
processors.php                   Processor category
VideoCards.php                   Graphics card category
motherboards.php                 Motherboard category
cases.php                        Case category
power-supplies.php               Power supply category
RAM.php                          RAM category
storage.php                      Storage category
logIn.html                       Login page
signUp.html                      Registration page
style.css                        Custom styles
database.sql                     Database schema and sample products
```

## Project Status

This is an educational project rather than a complete online store. Search and checkout are placeholders; payment processing and order management are not implemented. Category pages currently display one product each because their queries use `LIMIT 1`.

The supplied database contains sample products, descriptions, and prices. You can create a user account through the registration page.

