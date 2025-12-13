#!/bin/bash
set -e

# Copy .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install dependencies if vendor missing
if [ ! -d vendor ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Generate key if not set
if ! grep -q "APP_KEY=base64" .env; then
    php artisan key:generate
fi

# Create SQLite DB if using sqlite and file missing
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

# Run migrations
php artisan migrate --force

# Optimizations
php artisan optimize:clear

# Set permissions
chmod -R 777 storage bootstrap/cache

# Start PHP-FPM
php-fpm
