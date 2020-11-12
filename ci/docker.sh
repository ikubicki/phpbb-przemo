#!/bin/bash

set -e
if [ "$DIR" == "" ]; then
    DIR=$(pwd)
fi
CONFIG=''

if [[ "$@" == *"-config"* ]]; then 
    CONFIG="-v $DIR/ci/config.php:/var/www/html/forum/config.php"
fi

network_exists=$(docker network ls | grep przemo | xargs)
if [ "$network_exists" == "" ]; then
    docker network create przemo
fi

db_volume_exists=$(docker volume ls | grep przemo_db_volume | xargs)
if [ "$db_volume_exists" == "" ]; then
    docker volume create przemo_db_volume
fi

cache_volume_exists=$(docker volume ls | grep przemo_cache_volume | xargs)
if [ "$cache_volume_exists" == "" ]; then
    docker volume create przemo_cache_volume
fi

image_exists=$(docker image ls | grep przemo/php | xargs)
if [ "$image_exists" == "" ]; then
    docker build -t przemo/php:7.4-dev -f ci/Dockerfile ci
fi

db_exists=$(docker ps | grep przemo_db | xargs)
if [ "$db_exists" == "" ]; then
    docker run -d \
        --network przemo \
        --name przemo_db \
        -v przemo_db_volume:/var/lib/mysql \
        -e MYSQL_ROOT_PASSWORD=root \
        -e MYSQL_USER=przemodbuser \
        -e MYSQL_PASSWORD=przemodbpass \
        -e MYSQL_DATABASE=przemo \
        -p 3306:3306 \
        mysql:8.0 \
            --character-set-server=utf8mb4 \
            --collation-server=utf8mb4_unicode_ci
fi

app_exists=$(docker ps | grep przemo_app | xargs)
if [ ! "$app_exists" == "" ]; then
    docker rm przemo_app -f
fi
docker run -d \
    --network przemo \
    --name przemo_app \
    -v $DIR/ci/index.php:/var/www/html/index.php \
    -v $DIR:/var/www/html/forum \
    $CONFIG \
    -v przemo_cache_volume:/var/www/html/cache \
    -p 80:80 \
    -p 443:443 \
    -e ADMIN_NAME=admin \
    -e ADMIN_EMAIL=admin@example.com \
    -e ADMIN_PASS=qwerty \
    -e DBHOST=przemo_db \
    -e DBNAME=przemo \
    -e DBUSER=przemodbuser \
    -e DBPASS=przemodbpass \
    przemo/php:7.4-dev

docker exec -it przemo_app chmod 0777 /var/www/html/cache