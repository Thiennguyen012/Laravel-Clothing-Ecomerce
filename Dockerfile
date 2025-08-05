# Use the official PHP FPM image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer (latest stable)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# # Copy application code
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Install PHP dependencies (production)
RUN composer install --no-dev --optimize-autoloader

RUN php artisan storage:link
# Build frontend (tailwind, breeze, etc.)
RUN npm ci && npm run build

# # Cache Laravel config and routes
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache
   

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
