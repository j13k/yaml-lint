# Stage 1: Install production dependencies
FROM composer:2 AS deps

ARG APP_VERSION=dev
ENV COMPOSER_ROOT_VERSION=${APP_VERSION}

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# Stage 2: Production image
FROM php:8.4-cli-alpine

COPY --from=deps /app/vendor /app/vendor
COPY bin /app/bin
COPY src /app/src
COPY composer.json /app/composer.json

WORKDIR /workdir

ENTRYPOINT ["php", "/app/bin/yaml-lint"]
