#!/usr/bin/env bash
set -e

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

service nginx start
php-fpm