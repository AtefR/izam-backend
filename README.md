# Izam Backend

this project was made as a task for izam using Laravel 12.

## API Endpoints

| Method | Endpoint           | Description                                   | Auth Required |
|--------|--------------------|-----------------------------------------------|---------------|
| GET    | `/api/login`       | issues a Sanctum token                        | No            |
| GET    | `/api/categories`  | List all categories                           | No            |
| GET    | `/api/products`    | List all products with pagination and filters | No            |
| POST   | `/api/orders`      | Place an order with validation                | Yes           |
| GET    | `/api/orders/{id}` | View order information                        | Yes           |

**Notes:**

- Authentication token should be sent as Bearer token in the Authorization header.

## Authentication

- Implemented via **Laravel Sanctum**
- Login endpoint (handled by frontend) issues a Sanctum token
- Order endpoints are protected and require a valid authenticated user

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
