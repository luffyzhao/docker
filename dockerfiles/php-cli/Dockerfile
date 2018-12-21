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

ENV SWOOLE_VERSION="4.2.10"
ENV PHPREDIS_VERSION="4.2.0"
ENV PHPINOTIFY_VERSION="2.0.0"
ENV PHPDS_VERSION="1.2.7"

# Timezone
RUN /bin/cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo 'Asia/Shanghai' > /etc/timezone

# #------------------------------------------------------------
# # Libs
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev curl git zip libz-dev libssl-dev libnghttp2-dev libpcre3-dev libzip-dev \
        && apt-get clean \
        && apt-get autoremove

    
# #------------------------------------------------------------
# # extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j$(nproc) gd; \
    docker-php-ext-install pdo_mysql; \
    docker-php-ext-install bcmath; \
    docker-php-ext-install zip;

# #------------------------------------------------------------
# # ds extension
RUN curl http://pecl.php.net/get/ds-${PHPDS_VERSION}.tgz -o /tmp/ds.tar.tgz \
    && pecl install /tmp/ds.tar.tgz \
    && rm -rf /tmp/ds.tar.tgz \
    && docker-php-ext-enable ds

# #------------------------------------------------------------
# # inotify extension
RUN curl http://pecl.php.net/get/inotify-${PHPINOTIFY_VERSION}.tgz -o /tmp/inotify.tar.tgz \
    && pecl install /tmp/inotify.tar.tgz \
    && rm -rf /tmp/inotify.tar.tgz \
    && docker-php-ext-enable inotify

# #------------------------------------------------------------
# # Redis extension
RUN curl http://pecl.php.net/get/redis-${PHPREDIS_VERSION}.tgz -o /tmp/redis.tar.tgz \
    && pecl install /tmp/redis.tar.tgz \
    && rm -rf /tmp/redis.tar.tgz \
    && docker-php-ext-enable redis

# #------------------------------------------------------------
# # Swoole extension
RUN curl https://github.com/swoole/swoole-src/archive/v${SWOOLE_VERSION}.tar.gz -o /tmp/swoole.tar.gz -L \
    && mkdir -p swoole \
    && tar -zxvf /tmp/swoole.tar.gz -C swoole --strip-components=1 \
    && rm /tmp/swoole.tar.gz \
    && ( \
    cd swoole \
    && phpize \
    && ./configure --enable-mysqlnd --enable-openssl --enable-http2 \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r swoole \
    && docker-php-ext-enable swoole

# #------------------------------------------------------------
# # Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    composer --ansi --version --no-interaction;


# #------------------------------------------------------------
# # 创建工作目录
RUN mkdir /var/www;

COPY ./start.sh /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

WORKDIR /var/www


VOLUME ["/var/www"]