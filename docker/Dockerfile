FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install zip pdo pdo_mysql intl gd \
    && rm -rf /var/lib/apt/lists/

RUN pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /var/www/registration-form/

COPY custom.ini /usr/local/etc/php/conf.d/custom.ini

