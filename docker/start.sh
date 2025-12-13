#!/bin/bash
set -e

# Run standard Laravel optimizations (can be skipped in dev)
# php artisan optimize

# Ensure connection to DB (check sqlite file inside container?)
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

# Run migrations
# php artisan migrate --force

# Start PHP-FPM
php-fpm
