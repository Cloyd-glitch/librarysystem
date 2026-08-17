FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libxml2-dev zip unzip libzip-dev nginx \
    && docker-php-ext-install pdo_mysql pdo_pgsql bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod +x docker/start.sh \
    && chown -R www-data:www-data storage bootstrap/cache public

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 10000
CMD ["docker/start.sh"]