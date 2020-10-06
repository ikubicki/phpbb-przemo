FROM php:7.4-apache

RUN apt-get update -y && \
    apt-get install -y zip libzip-dev libpng-dev && \
    apt-get clean -y && \
    usermod -u 1000 www-data && groupmod -g 1000 www-data && \
    a2enmod rewrite && a2enmod headers && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip pdo_mysql mysqli gd && \
    docker-php-ext-enable pdo_mysql mysqli gd

#DEBUG
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug