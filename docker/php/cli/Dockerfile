FROM php:7.3-cli-alpine

RUN apk update && apk add --no-cache unzip bash freetype-dev libjpeg-turbo-dev libpng-dev

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo_mysql gd

# Composer
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
	&& composer global require hirak/prestissimo --no-plugins --no-scripts \
	&& rm -rf /root/.composer/cache

COPY wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

WORKDIR /var/www
