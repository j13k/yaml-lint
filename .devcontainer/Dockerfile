# Tracks the latest PHP release.
FROM php:8.5-cli-trixie

# git for version control and Composer source installs; unzip for Composer dist installs.
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
