#!/bin/bash

pwd=$(pwd)

docker pull php:7.4-apache
docker pull mysql:5.7

docker build -t local/przemo3 .
docker network create przemo3
docker volume create przemo3db

dbcheck=$(docker ps | grep dbprzemo3)

if [ "$dbcheck" == "" ]; then
    docker rm -f dbprzemo3
    docker run -d \
        --name dbprzemo3 \
        --network=przemo3 \
        -p 33066:3306 \
        -e MYSQL_ROOT_PASSWORD=przemoroot \
        -e MYSQL_USER=przemo3 \
        -e MYSQL_PASSWORD=przemo3 \
        -v przemo3db:/var/lib/mysql \
        -v $pwd"/bin/mysql-default-schema.sql":/docker-entrypoint-initdb.d/01-init.sql \
        mysql:5.7
fi

appcheck=$(docker ps -a | grep appprzemo3)

if [ ! "$appcheck" == "" ]; then
    docker rm -f appprzemo3
fi
docker run -d \
    --name appprzemo3 \
    --network=przemo3 \
    -p 88:80 \
    -e DBCONN="mysql:host=dbprzemo3;port=33066;dbname=przemo3" \
    -e DBUSER="przemo3" \
    -e DBPASS="przemo3" \
    -v $(pwd):/var/php \
    local/przemo3

