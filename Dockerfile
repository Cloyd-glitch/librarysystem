FROM php:8.3-fpm

# Install system dependencies including PostgreSQL dev library
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libxml2-dev zip unzip libzip-dev nginx \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod +x docker/start.sh \
    && chown -R www-data:www-data storage bootstrap/cache public

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Expose port
EXPOSE 10000

# Start the application
CMD ["docker/start.sh"]