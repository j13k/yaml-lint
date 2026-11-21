# Production image: yaml-lint with the dependencies locked in composer.lock.
# Published to Docker Hub by .github/workflows/docker.yml when a release is tagged.

# The dependencies are plain PHP, so install them on the build machine's own platform.
FROM --platform=$BUILDPLATFORM composer:2 AS deps

# The version that `yaml-lint --version` reports. The release workflow sets it to the tag.
ARG APP_VERSION=dev-master
ENV COMPOSER_ROOT_VERSION=${APP_VERSION}

WORKDIR /app

COPY composer.json composer.lock ./
COPY bin bin
COPY src src
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# Tracks the latest PHP release.
FROM php:8.6-cli-alpine

# Pick up Alpine package fixes without waiting for the PHP image to be rebuilt.
RUN apk upgrade --no-cache

COPY --from=deps /app /app

WORKDIR /workdir

ENTRYPOINT ["php", "/app/bin/yaml-lint"]
