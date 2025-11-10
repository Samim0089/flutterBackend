# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && a2enmod rewrite

# Set global ServerName to suppress AH00558 warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy custom Apache config for Laravel (optional if needed)
# Create docker/000-default.conf in your project with proper <VirtualHost> settings
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for storage, cache, and public folder
RUN chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 755 storage bootstrap/cache public

# Clear Laravel caches
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Optional: Run migrations automatically (skip errors)
RUN php artisan migrate --force || true

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
