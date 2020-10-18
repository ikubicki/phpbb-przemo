FROM php:7.4-apache

RUN apt-get update -y && \
    apt-get install -y zip libzip-dev libpng-dev && \
    apt-get clean -y && \
    usermod -u 1000 www-data && groupmod -g 1000 www-data && \
    a2enmod rewrite && a2enmod headers && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip pdo_mysql mysqli gd && \
    docker-php-ext-enable pdo_mysql mysqli gd


RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=PL/ST=DS/L=Wroclaw/O=Security/OU=Development/CN=localhost"
RUN a2ensite default-ssl
RUN a2enmod ssl

#DEBUG
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug