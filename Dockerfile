# Use the official PHP image from the Docker Hub
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev git unzip libxml2-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl

# Set the working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy the custom php.ini configuration
COPY php.ini /usr/local/etc/php/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000
EXPOSE 9000

# Command to run the application
CMD ["php-fpm"]
