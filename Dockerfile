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

# Copy Apache config (optional if needed)
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

# Run migrations (ignore errors if no DB yet)
RUN php artisan migrate --force || true

# ✅ Railway uses PORT environment variable (default: 8080)
EXPOSE 8080
ENV PORT=8080

# ✅ Make Apache listen on Railway’s dynamic port
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
    && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Start Apache
CMD ["apache2-foreground"]
