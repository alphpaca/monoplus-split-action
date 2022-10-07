FROM composer:2.4 AS composer

FROM php:8.1-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN echo 'deb http://deb.debian.org/debian bullseye-backports main' >> /etc/apt/sources.list

RUN echo 'deb http://deb.debian.org/debian bullseye-backports main' >> /etc/apt/sources.list; \
    apt-get update -y; \
    apt-get install python3 git git-filter-repo -y;

WORKDIR /app

COPY . .

RUN composer install --no-dev --no-interaction --optimize-autoloader

ENTRYPOINT ["php", "/app/monoplus-split"]
