FROM php:7.2-fpm-stretch

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        zip \
        unzip \
        libzip-dev \
        git \
        curl \
        gnupg \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install mbstring pdo pdo_mysql zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && usermod -u 1000 www-data \
    && chown www-data:www-data -R /var/www

# Node
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash \
    && apt-get -y --no-install-recommends install nodejs

WORKDIR /var/www
