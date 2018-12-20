#------------------------------------------------------------
#
#  用途: 开发环境的基础结构
#  构成: php:7.3.0
#
# @version    1.0
# @author     Luffy Zhao
#

#------------------------------------------------------------
# FROM
FROM php:7.3.0-cli

#------------------------------------------------------------
MAINTAINER Luffy Zhao

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev; \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j$(nproc) gd; \
    docker-php-ext-install pdo_mysql; \
    pecl install redis; \
    pecl install inotify; \
    pecl install ds; \
    pecl install swoole; \
    docker-php-ext-enable redis inotify ds swoole;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    composer --ansi --version --no-interaction;
RUN apt-get install -y git;

RUN mkdir /var/www

VOLUME ["/usr/local/etc/php"]