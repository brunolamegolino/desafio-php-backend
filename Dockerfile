FROM php:8.2-alpine

RUN apk update && apk add -u \
    zlib-dev \
    libzip-dev

RUN docker-php-ext-install zip

RUN apk add postgresql-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN apk add sqlite sqlite-dev && \
    docker-php-ext-install pdo_sqlite

RUN apk add -u \
    composer \
    php-xml

RUN sqlite3 tests/database.db

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /app

WORKDIR /app/src

RUN composer install

EXPOSE 8080

# CMD ["php", "migration.php", "&&", "php", "-S", "0.0.0.0:8080", "router.php"]
CMD sh -c "php migration.php && php -S 0.0.0.0:8080 router.php"
