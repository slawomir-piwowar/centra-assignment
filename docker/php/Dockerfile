FROM php:7.4-fpm

WORKDIR /var/www

COPY . .

RUN apt-get update && apt-get install -y libicu-dev git zip unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

ENTRYPOINT ["sh", "./docker/php/entrypoint.sh"]
