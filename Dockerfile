FROM php:8.1-cli-alpine

COPY --from=composer/composer:2-bin /composer /usr/bin/composer

RUN apk update; \
    apk add --no-cache git python3 py3-pip openssh;

RUN pip3 install git-filter-repo

WORKDIR /app

COPY . .

RUN composer install --no-dev --no-interaction --optimize-autoloader

ENTRYPOINT ["php", "/app/monoplus-split"]
