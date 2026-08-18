echo "=== DEBUG: checking public/build contents ==="
ls -la public/build/ || echo "public/build directory does not exist"
echo "=== DEBUG: manifest.json contents ==="
cat public/build/manifest.json 2>/dev/null || echo "manifest.json not found"
echo "=== END DEBUG ==="

php artisan config:clear
php artisan storage:link
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --force

service nginx start
php-fpm