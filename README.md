# Izam Backend

this project was made as a task for izam using Laravel 12.

## Running the project

clone the project

```bash
git clone https://github.com/AtefR/izam-backend.git
cd izam-backend
```

install dependencies

```bash
composer install
```

configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

run the migration and seed the database

```bash
php artisan migrate --seed
```
