# Laravel Clothing E-commerce

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## 🛍️ About This Project

A modern e-commerce application built with Laravel for clothing sales, featuring:

-   📦 Product catalog with categories and variants
-   🔍 Advanced filtering system (category, price range)
-   👤 User authentication and admin panel
-   🛒 Shopping cart functionality with real-time updates
-   🎨 Responsive design with Tailwind CSS
-   🐳 Docker containerization for easy deployment

## 🚀 Quick Start with Docker

### Prerequisites

-   Docker Desktop installed
-   Git
-   Ports 80 and 3307 available

### Setup Commands

```bash
# 1. Clone repository
git clone https://github.com/Thiennguyen012/Laravel-Clothing-Ecomerce.git
cd Laravel-Clothing-Ecomerce

# 2. Build and start containers
docker-compose up -d --build

# 3. Wait 30 seconds for MySQL, then run setup
docker-compose exec php php artisan migrate --force
docker-compose exec php php artisan db:seed
docker-compose exec php php artisan storage:link
docker-compose exec php chmod -R 755 storage/app/public
docker-compose exec php php artisan cache:clear

# 4. Access application
# Web: http://localhost
# Products: http://localhost/products
```

### 📋 Detailed Setup Guide

For complete setup instructions, see: **[DOCKER_SETUP.md](DOCKER_SETUP.md)**

## 🌐 Access Points

-   **Website**: http://localhost
-   **Database**: localhost:3307 (user: laravel, password: hehehe)

## 🛠️ Troubleshooting

If you encounter issues, check the troubleshooting section in [DOCKER_SETUP.md](DOCKER_SETUP.md)

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
