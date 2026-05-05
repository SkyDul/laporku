FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip curl \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer (untuk AWS SDK)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer require aws/aws-sdk-php

# Set document root ke /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Izin folder uploads
RUN chmod -R 755 /var/www/html/public/uploads

EXPOSE 80
