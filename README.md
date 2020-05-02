# Commerce

This project is used for technical test in Glints

## Installation

This project uses laravel 7.0

```bash
git clone https://github.com/muhaliusman/commerce.git
cd commerce
cp .env.example .env
composer install
php artisan key:generate
```

Create database and then change parameter DB_DATABASE in .env file.
After that, run migrate and seed command.

```bash
php artisan migrate --seed
```

Run artisan serve.

```bash
php artisan serve
```

Then open your browser and access this url http://localhost:8000 (default)