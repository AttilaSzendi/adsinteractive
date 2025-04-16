#!/bin/bash

set -e

cd /application

mkdir -p storage/framework/views storage/framework/cache storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

if [ ! -f .env ]; then
    cp .env.example .env
    chmod 666 .env
fi

sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
sed -i 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' .env
sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env

composer install --no-interaction

php artisan config:clear
php artisan key:generate
php artisan view:clear
php artisan route:clear

exec "$@"
