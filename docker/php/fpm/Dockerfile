FROM php:7.3-fpm-alpine

RUN apk update && apk add --no-cache shadow freetype-dev libjpeg-turbo-dev libpng-dev

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo_mysql gd

# Permissions
RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && chown www-data:www-data -R /var/www

WORKDIR /var/www
