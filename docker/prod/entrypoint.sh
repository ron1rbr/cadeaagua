#!/bin/sh
set -e

mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php-fpm