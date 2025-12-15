#!/bin/bash
set -e

if [ -e /var/run/docker.sock ]; then
    chmod 666 /var/run/docker.sock
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -d vendor ]; then
    composer install --no-interaction --optimize-autoloader
fi

if ! grep -q "APP_KEY=base64" .env; then
    php artisan key:generate
fi

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

php artisan migrate --force

php artisan optimize:clear

chmod -R 777 storage bootstrap/cache

php-fpm
