FROM node:25-alpine AS builder
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run dev

FROM php:8.5-cli

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

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

COPY . .
COPY --from=builder /app/public ./public
RUN composer dump-autoload --optimize

COPY docker/custom.ini /usr/local/etc/php/conf.d/custom.ini

COPY docker/startserver.sh /usr/local/bin/startserver.sh
RUN sed -i 's/\r$//' /usr/local/bin/startserver.sh && chmod +x /usr/local/bin/startserver.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/startserver.sh"]
