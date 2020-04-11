FROM php:7.4-apache
LABEL maintainer="irek@ixdude.com"
ADD .  /var/php
RUN echo "" > /var/php/config.php && \
    rm -rf /var/php/cache && \
    mkdir 0777 /var/php/cache && \
    rm -rf /var/www/html && \
    ln -sf /var/php/web /var/www/html
