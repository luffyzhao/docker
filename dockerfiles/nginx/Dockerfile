#------------------------------------------------------------
#
#  用途: 开发环境的基础结构
#  构成: nginx:1.15.7
#
# @version    1.0
# @author     Luffy Zhao
#

#------------------------------------------------------------
# FROM
FROM nginx:1.15.7

#------------------------------------------------------------
MAINTAINER Luffy Zhao

# Timezone
RUN /bin/cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo 'Asia/Shanghai' > /etc/timezone

RUN mkdir /etc/nginx/snippets;
ADD conf/fastcgi.conf /etc/nginx/
ADD conf/snippets/fastcgi-php.conf /etc/nginx/snippets/