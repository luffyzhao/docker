#------------------------------------------------------------
#
#  用途: 开发环境的基础结构
#  构成: php:7.3.0-fpm-stretch
#
# @version    1.0
# @author     Luffy Zhao
#

#------------------------------------------------------------
# FROM
FROM php:7.3.0-fpm-stretch

#------------------------------------------------------------
MAINTAINER Luffy Zhao

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql

VOLUME ["/usr/local/etc/php-fpm.d", "/usr/local/etc/php"]