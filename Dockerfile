# Laravel E-commerce Docker Container
# 
# Quick Start:
# 1. docker-compose up -d --build
# 2. docker-compose exec php php artisan migrate --force
# 3. docker-compose exec php php artisan db:seed
# 4. Access: http://localhost
#
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
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (latest stable)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies (production)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . /var/www

# Copy package.json and package-lock.json for better caching
COPY package*.json ./

# Install and build frontend dependencies
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Create symlink for storage (if it doesn't exist)
RUN if [ ! -L /var/www/public/storage ]; then php artisan storage:link; fi

# Run composer scripts after copying all files
RUN composer dump-autoload --optimize

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
