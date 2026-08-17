php artisan storage:link
php artisan route:cache
php artisan view:cache
php artisan migrate --force

service nginx start
php-fpm