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
FROM redis:5.0.4

#------------------------------------------------------------
MAINTAINER Luffy Zhao

# Timezone
RUN /bin/cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo 'Asia/Shanghai' > /etc/timezone