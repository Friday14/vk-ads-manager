FROM php:7.2.10-fpm-alpine

RUN apk add --no-cache --virtual .persistent-deps \
       bash

RUN set -xe \
    && apk add --no-cache --virtual .build-deps \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql

COPY ./scheduler.sh /usr/app/scheduler.sh
COPY ./queue.sh /usr/app/queue.sh

WORKDIR /var/www
