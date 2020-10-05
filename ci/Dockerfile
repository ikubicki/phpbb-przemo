FROM php:7.4-apache

RUN a2enmod rewrite && a2enmod headers && \
    docker-php-ext-install pdo_mysql mysqli && \
    docker-php-ext-enable pdo_mysql mysqli

#DEBUG
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug