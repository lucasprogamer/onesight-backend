FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

RUN useradd -ms /bin/bash appuser
USER appuser

COPY --chown=appuser:appuser . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

