FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libpq-dev \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/backend

COPY ../backend/composer.json ../backend/composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY ../backend ./

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000
