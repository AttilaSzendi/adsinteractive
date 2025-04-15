#!/bin/bash

set -e

cd /application

mkdir -p storage/framework/views storage/framework/cache storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

if [ ! -f .env ]; then
    cp .env.example .env
fi

sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
sed -i 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' .env
sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env

composer install --no-interaction

php artisan config:clear || true
php artisan key:generate || true
php artisan view:clear || true
php artisan route:clear || true

exec "$@"
