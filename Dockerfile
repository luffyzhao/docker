#------------------------------------------------------------
#
#  用途: 开发环境的基础结构
#  构成: CentOS7 + Apache + PHP7(Xdebug) + Redis + mysql
#
# @version    1.0
# @author     Luffy Zhao
#

#------------------------------------------------------------
# FROM
FROM ubuntu:16.04

#------------------------------------------------------------
MAINTAINER Luffy Zhao

#------------------------------------------------------------
# 换源
RUN mv /etc/apt/sources.list /etc/apt/sources.list.bak
ADD config/source.list /etc/apt/sources.list
RUN apt-get update


ENV MYSQL_VERSION="5.7"

#------------------------------------------------------------
# 安装依赖
#------------------------------------------------------------
RUN apt-get install -y lsb-core

RUN mkdir /var/soft/

#------------------------------------------------------------
# APACHE 和 MYSQL
RUN apt-get install -y apache2 mysql-server-core-${MYSQL_VERSION}
RUN rm -rf /var/lib/apt/lists/*

