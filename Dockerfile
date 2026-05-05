FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip curl \
    && docker-php-ext-install pdo pdo_mysql gd

# Tingkatkan batas ukuran upload file PHP
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini

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

# Menerima argumen build dari GitHub Actions
ARG DB_HOST
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG APP_URL
ARG CLOUDFRONT_DOMAIN
ARG AWS_ACCESS_KEY_ID
ARG AWS_SECRET_ACCESS_KEY
ARG AWS_REGION

# Tulis ke .env agar fungsi getEnvVar di PHP bisa membacanya tanpa masalah Apache
RUN echo "DB_HOST=${DB_HOST}" > /var/www/html/.env && \
    echo "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env && \
    echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env && \
    echo "DB_PASSWORD=${DB_PASSWORD}" >> /var/www/html/.env && \
    echo "APP_URL=${APP_URL}" >> /var/www/html/.env && \
    echo "CLOUDFRONT_DOMAIN=${CLOUDFRONT_DOMAIN}" >> /var/www/html/.env && \
    echo "AWS_ACCESS_KEY_ID=${AWS_ACCESS_KEY_ID}" >> /var/www/html/.env && \
    echo "AWS_SECRET_ACCESS_KEY=${AWS_SECRET_ACCESS_KEY}" >> /var/www/html/.env && \
    echo "AWS_REGION=${AWS_REGION}" >> /var/www/html/.env

RUN chown www-data:www-data /var/www/html/.env
