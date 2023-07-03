FROM php:8.2-alpine

RUN apk update && apk add -u \
    zlib-dev \
    libzip-dev

RUN docker-php-ext-install zip

RUN apk add postgresql-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN apk add -u \
    composer \
    php-xml

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Uncomment to install xdebug 
#
# RUN apk add --no-cache pcre-dev ${PHPIZE_DEPS} \
#     && apk add --update linux-headers \
#     && pecl install xdebug \
#     && docker-php-ext-enable xdebug \
#     && apk del pcre-dev ${PHPIZE_DEPS}

# RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.log=/var/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini 

WORKDIR /app/src

EXPOSE 8080

CMD sh -c "composer install && php migration.php && php -S 0.0.0.0:8080 router.php"
