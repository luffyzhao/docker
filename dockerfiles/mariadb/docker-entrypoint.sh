#!/bin/bash

set -eo pipefail
shopt -s nullglob

if [ "${1:0:1}" = '-' ]; then
    set -- mysqld "$@"
fi

DATA_DIR='/var/lib/mysql'


if [ "$1" = 'mysqld' ]; then
    if [ ! -d "$DATA_DIR/mysql" ]; then 
        echo 'Running mysql_install_db ...'
        /usr/bin/mysql_install_db --user=mysql --datadir="$DATA_DIR" >/dev/null 2>&1
        echo 'Finished mysql_install_db'
 
        tempSqlFile='/tmp/mysql-first-time.sql'

        if [ "$MYSQL_ROOT_PASSWORD" ]; then

            cat > "$tempSqlFile" <<-EOF
                SET @@SESSION.SQL_LOG_BIN=0;
            
                DELETE FROM mysql.user WHERE user NOT IN ('mysql.sys', 'mysqlxsys', 'root') OR host NOT IN ('localhost') ;
                GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}' WITH GRANT OPTION;
                DROP DATABASE IF EXISTS test;
                FLUSH PRIVILEGES ;
EOF
        else
            cat > "$tempSqlFile" <<-EOF
                SET @@SESSION.SQL_LOG_BIN=0;

                DELETE FROM mysql.user WHERE user NOT IN ('mysql.sys', 'mysqlxsys', 'root') OR host NOT IN ('localhost') ;
                GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '123456' WITH GRANT OPTION;
                DROP DATABASE IF EXISTS test;
                FLUSH PRIVILEGES ;
EOF
        fi
 
            set -- "$@" --init-file="$tempSqlFile"
        fi
 
    chown -R mysql:mysql "$DATA_DIR"
fi
 
echo "$@"

exec "$@"