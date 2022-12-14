# Dockerfile

# This Dockerfile stolen from odan/slim4-skeleton:
# - https://github.com/odan/slim4-skeleton
# - https://github.com/odan/slim4-skeleton/blob/master/Dockerfile

# Use this dockerfile to run the application.
#
# Start the server using docker-compose:
#
#   docker-compose build
#   docker-compose up

FROM php:8.2-apache

### system dependecies
RUN apt-get update \
 && apt-get install -y \
 git \
 libssl-dev \
 libmcrypt-dev \
 libicu-dev \
 libpq-dev \
 libjpeg62-turbo-dev \
 libjpeg-dev  \
 libpng-dev \
 zlib1g-dev \
 libonig-dev \
 libxml2-dev \
 libzip-dev \
 gettext \
 ca-certificates \
 unzip


### CA Certificates, if behind certain firewalls with SSL inspection
COPY ./resources/docker/ca-certificates/* /usr/local/share/ca-certificates/
RUN update-ca-certificates

### PHP dependencies
RUN docker-php-ext-install \
 intl \
 mbstring \
 gettext \
 pdo \
 zip

### Xdebug
RUN pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.client_port=9000' >>  /usr/local/etc/php/conf.d/xdebug.ini \
 && echo 'xdebug.remote_cookie_expire_time=36000' >>  /usr/local/etc/php/conf.d/xdebug.ini


### Composer
RUN curl -sS https://getcomposer.org/installer | php && \
 mv composer.phar /usr/local/bin/composer



### Apache Modules
### as needed for "Apache Server Configs"
### See: h5bp/server-configs-apache
RUN a2enmod autoindex
RUN a2enmod deflate
RUN a2enmod expires
RUN a2enmod headers
RUN a2enmod include
RUN a2enmod mime
RUN a2enmod setenvif
RUN a2enmod ssl
RUN a2enmod rewrite

### Set Apache ServerName
RUN echo "ServerName docker" >> /etc/apache2/apache2.conf

### Open Ports
EXPOSE 80
EXPOSE 443
