#------------------------------------------------------------
#
#  用途: 开发环境的基础结构
#  构成: ubuntu:16.04 + mariadb
#
# @version    1.0
# @author     Luffy Zhao
#

#------------------------------------------------------------
# FROM
FROM ubuntu:16.04

#------------------------------------------------------------
MAINTAINER Luffy Zhao

# #------------------------------------------------------------
# # 换源
RUN mv /etc/apt/sources.list /etc/apt/sources.list.bak
ADD config/source.list /etc/apt/sources.list
RUN apt-get update; \
	rm -rf /var/lib/apt/lists/*;

# #------------------------------------------------------------
# # 定义ENV
ENV MARIADB_VERSION="10.3"


# #------------------------------------------------------------
# # 安装依赖 和 APACHE
RUN apt-get install -y lsb-core software-properties-common apache2 gcc g++ zlib1g-dev autoconf cmake libcurl4-gnutls-dev libtool libssl-dev libncurses5-dev; \
	rm -rf /var/lib/apt/lists/*;

# #------------------------------------------------------------
# # 安装 MariaDB
RUN apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8; \
	add-apt-repository 'deb [arch=amd64,arm64,i386,ppc64el] http://mirrors.tuna.tsinghua.edu.cn/mariadb/repo/$MARIADB_VERSION/ubuntu xenial main'; \
	apt-get update; \
	DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server; \
	rm -rf /var/lib/apt/lists/*; \
	/usr/bin/mysql_install_db; \
	mysqladmin -u root password '123456'; \
	CREATE USER 'root'@'%' IDENTIFIED BY '123456' ;
				GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION ;

VOLUME /var/lib/mysql

EXPOSE 3306
CMD ["mysqld"]
