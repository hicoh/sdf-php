ARG PHP_VERSION=8.0

FROM php:${PHP_VERSION}-fpm as php

RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip git libcurl4-openssl-dev pkg-config libssl-dev cron vim && \
    rm -rf /var/lib/apt/lists/*

FROM php AS builder

WORKDIR /var/www/html

ARG XDEBUG=1
ENV XDEBUG_VERSION "3.0.2"
ENV XDEBUG_ENABLED $XDEBUG
COPY xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini-disabled
RUN set -eux \
 && if [ "$XDEBUG_ENABLED" = "1" ]; then \
        pecl install xdebug-$XDEBUG_VERSION && docker-php-ext-enable xdebug; \
        mv $PHP_INI_DIR/conf.d/xdebug.ini-disabled $PHP_INI_DIR/conf.d/xdebug.ini; \
    fi

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_CACHE_DIR /var/cache/composer
VOLUME $COMPOSER_CACHE_DIR
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/

# php extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN chown www-data:www-data -R /var/www/html/ /var/log /var/cache && \
    chmod 755 -R /var/www/html/ /var/log /var/cache
