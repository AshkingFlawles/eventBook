<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel
# EventBook Laravel Project

This is a Laravel-based web application with a Vue.js frontend using Vite.

## Getting Started

Follow these steps to clone and run the project locally.

### 1. Clone the repository

```bash
git clone https://github.com/AshkingFlawles/eventBook.git
cd eventBook
```

### 2. Pull the latest changes

```bash
git pull origin master
```

### 3. Install PHP dependencies

Make sure you have [Composer](https://getcomposer.org/) installed.

```bash
composer install
```

### 4. Install JavaScript dependencies

Make sure you have [Node.js](https://nodejs.org/) and npm installed.

```bash
npm install
```

### 5. Set up environment variables

Copy the example environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file to configure your database and other settings as needed.

### 6. Run database migrations

```bash
php artisan migrate
```

### 7. Run additional artisan commands (if any)

If you have any queued jobs or other services, start them as needed. For example:

```bash
php artisan queue:work
```

*(Optional, depending on your app requirements)*

### 8. Start the development servers

Run the Laravel backend server (optional if you use a separate server):

```bash
php artisan serve
```

Run the frontend development server (Vite):

```bash
npm run dev
```

### 9. Access the application

Open your browser and navigate to:

- Login page: [http://localhost:5173/api/login](http://localhost:5173/api/login)
- Register page: [http://localhost:5173/api/register](http://localhost:5173/api/register)

---

## Notes

- Make sure your database is running and accessible with the credentials set in `.env`.
- Adjust ports if needed depending on your local setup.
- For production deployment, build the frontend assets with `npm run build` and configure your web server accordingly.

---

## Troubleshooting

If you encounter permission issues, try running:

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## License

This project is private software, not for distrubution. 
All rights reserved.
