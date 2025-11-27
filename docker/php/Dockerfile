FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    libzip-dev \
    zip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    pkg-config \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql zip gd


RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install mongodb && docker-php-ext-enable mongodb


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN composer require mongodb/laravel-mongodb:^5.5 -W
RUN composer require phpoffice/phpspreadsheet && composer require barryvdh/laravel-dompdf


LABEL authors="HeadSplit"

CMD ["php-fpm"]
