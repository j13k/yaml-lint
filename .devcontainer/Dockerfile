# Tracks the latest PHP release.
FROM php:8.5-cli-trixie

# git for version control and Composer source installs; unzip for Composer dist installs;
# gnupg for PHIVE's signature checks.
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip gnupg \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# PHIVE installs Box (see .phive/phars.xml) for building the PHAR. The download is
# checked against phar.io's signing key, as published in PHIVE's installation docs:
# https://github.com/phar-io/phive#installation
ARG PHIVE_VERSION=0.16.0
ARG PHIVE_GPG_FINGERPRINT=6AF725270AB81E04D79442549D8A98B29B2D5D79
RUN set -eux; \
    export GNUPGHOME="$(mktemp -d)"; \
    url="https://github.com/phar-io/phive/releases/download/${PHIVE_VERSION}/phive-${PHIVE_VERSION}.phar"; \
    curl -fsSL -o /usr/local/bin/phive "$url"; \
    curl -fsSL -o /tmp/phive.phar.asc "$url.asc"; \
    curl -fsSL "https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x${PHIVE_GPG_FINGERPRINT}" | gpg --batch --import; \
    gpg --batch --status-fd 1 --verify /tmp/phive.phar.asc /usr/local/bin/phive | grep -q "VALIDSIG ${PHIVE_GPG_FINGERPRINT}"; \
    chmod +x /usr/local/bin/phive; \
    gpgconf --kill all; \
    rm -rf "$GNUPGHOME" /tmp/phive.phar.asc
