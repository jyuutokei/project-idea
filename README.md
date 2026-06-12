# CRUD application that I followed to study Laravel in Laracast
[Laravel 2026 Course by Laracast](https://laracasts.com/series/laravel-from-scratch-2026)

## Added production Docker configuration setup for Nginx + PHP-FPM (referenced Docker Laravel prod. setup docs) and FrankenPHP (multiple sources) (with only SQLite DB support)
* [Branch for Nginx + PHP-FPM](https://github.com/jyuutokei/project-idea/tree/with-docker-phpfpm-nginx)
* [Branch for FrankenPHP](https://github.com/jyuutokei/project-idea/tree/with-docker-frankenphp)

### Steps
* Run `composer run setup`
* Run `docker compose -f compose up --build -d`
