FROM php:8.3-fpm

USER root
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html/
COPY --chown=www-data:www-data . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

RUN composer install
RUN npm install