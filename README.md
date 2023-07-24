# About Project

This project is a geographic information system development project for mapping tourist destinations in the Trenggalek District. Visit the website at [Wisata Trenggalek](https://wisata-trenggalek.com). This project also implemented unit testing with PHPUnit.

# Getting Started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/9.x/installation)

Install all the dependencies using composer
```
composer install
```
Copy the example env file and make the required configuration changes in the .env file
```
Windows (CMD) : copy .env.example .env | Linux (Bash) : cp .env.example .env
```
Generate a new application key
```
php artisan key:generate
```
Run the database migrations (**Set the database connection in .env before migrating**)
```
php artisan migrate
```
Create a storage symbolic link, so that the files in storage can be accessed from the web
```
php artisan storage:link
```
Start the local development server
```
php artisan serve
```
You can now access the server at http://localhost:8000

## Database Seeding

**Populate the database with seed data with relationships. This can help you to quickly start it with some ready content.**

Run the database seeder
```
php artisan db:seed
```
***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command
```
php artisan migrate:fresh
```
Or you can directly run the migration and database seeder commands together
```
php artisan migrate:fresh --seed
```

# Tech Stacks that I Used

- [Laravel](https://laravel.com/docs/9.x/) framework version 9.x
- [Laravel Breeze](https://laravel.com/docs/9.x/starter-kits#laravel-breeze) for authentication scaffolding
- [Laravel Pint](https://laravel.com/docs/9.x/pint) for code style standard
- [Tailwind CSS](https://tailwindcss.com/) for CSS framework
- [Alpine.js](https://alpinejs.dev/) a lightweight JavaScript framework
- [Leaflet](https://leafletjs.com/) a open-source JavaScript library
- [Swipper](https://swiperjs.com/) a modern mobile touch slider
- [TinyMCE](https://www.tiny.cloud/) a open source rich text editor

# Laravel License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
