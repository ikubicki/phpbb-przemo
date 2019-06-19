FROM irekk/centos:0.11
LABEL maintainer="irek@ixdude.com"
ADD .  /var/www/app/htdocs
RUN echo "" > /var/www/app/htdocs/config.php
CMD ["/usr/sbin/httpd", "-DFOREGROUND"]