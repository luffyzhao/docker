# Docker

## 开发环境

- 修改 `docker-compose.yml` 注意，只修改项目目录，不要修改 `./dockerfiles` 开头的目录。`E:` 盘符开头的目录都要修改成自己对应的目录

### 启动
docker-composer up -d

### PHP 容器
docker-compose exec php7.1 /bin/bash

### nginx 容器
docker-compose exec nginx /bin/bash

### mysql 容器
docker-compose exec mysql /bin/bash

### redis 容器
docker-compose exec redis /bin/bash