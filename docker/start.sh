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

# ---------------------------------------
echo "Arreglando permisos..."
chown -R www-data:www-data /var/www/database
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache


chmod -R 775 /var/www/database
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
# ---------------------------------------

echo "Iniciando PHP-FPM..."
php-fpm -D

echo "Iniciando Nginx..."
nginx -g "daemon off;"
