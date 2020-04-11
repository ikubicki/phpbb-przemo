#!/bin/bash

pwd=$(pwd)

if [[ "$@" == *"-pull"* ]]; then
    echo "Pulling required images"
    docker pull php:7.4-apache
    docker pull mysql:5.7
fi

echo "Running docker build"
docker build -t local/przemo3 .

networkcheck=$(docker network ls | grep przemo3)

if [ "$networkcheck" == "" ]; then
    echo "Creating docker network przemo3"
    docker network create przemo3
fi

if [[ "$@" == *"-dbrefresh"* ]]; then
    echo "Removing DB resources"
    docker rm -f przemo3db
    docker volume rm -f przemo3db
fi

volumecheck=$(docker volume ls | grep przemo3 | grep local)

if [ "$volumecheck" == "" ]; then
    echo "Creating docker volume przemo3db"
    docker volume create przemo3db
fi

dbcheck=$(docker ps | grep dbprzemo3)

if [ "$dbcheck" == "" ]; then
    echo "Creating mysql container"
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
    echo "Removing existing application docker container"
    docker rm -f appprzemo3
fi

echo "Creating application docker container"
docker run -d \
    --name appprzemo3 \
    --network=przemo3 \
    -p 88:80 \
    -e DBCONN="mysql:host=dbprzemo3;port=33066;dbname=przemo3" \
    -e DBUSER="przemo3" \
    -e DBPASS="przemo3" \
    -e DEBUG=1 \
    -v $(pwd):/var/php \
    local/przemo3

