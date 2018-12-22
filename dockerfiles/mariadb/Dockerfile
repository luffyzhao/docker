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

# # Timezone
# RUN /bin/cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
#     && echo 'Asia/Shanghai' > /etc/timezone

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
# # 安装依赖
RUN apt-get install -y software-properties-common; \
	rm -rf /var/lib/apt/lists/*;

# #------------------------------------------------------------
# # 安装 MariaDB
RUN apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8; \
	add-apt-repository 'deb [arch=amd64,arm64,i386,ppc64el] http://mirrors.tuna.tsinghua.edu.cn/mariadb/repo/$MARIADB_VERSION/ubuntu xenial main'; \
	apt-get update; \
	DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server; \
	rm -rf /var/lib/apt/lists/*; \
	rm -rf /var/lib/mysql; \
	mkdir -p /var/lib/mysql /var/run/mysqld; \
	chown -R mysql:mysql /var/lib/mysql /var/run/mysqld; \
	chmod 777 /var/run/mysqld; \
	find /etc/mysql/ -name '*.cnf' -print0 \
		| xargs -0 grep -lZE '^(bind-address|log)' \
		| xargs -rt -0 sed -Ei 's/^(bind-address|log)/#&/';

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

VOLUME ["/var/lib/mysql", "/etc/mysql/conf.d"]

USER mysql

EXPOSE 3306

ENTRYPOINT ["/docker-entrypoint.sh"]
 
CMD ["mysqld"]
