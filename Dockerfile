FROM php:8.3-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && docker-php-ext-install pcntl

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo -e "xdebug.mode=coverage\nzend_extension = xdebug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app
COPY . .

RUN composer install --prefer-dist --no-interaction

CMD ["vendor/bin/pest"]
