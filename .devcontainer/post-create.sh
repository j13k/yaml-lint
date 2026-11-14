#!/usr/bin/env bash
# Runs once after the dev container is created (postCreateCommand).
set -euo pipefail

# Box's signing key, as published in its installation docs:
# https://github.com/box-project/box/blob/main/doc/installation.md
BOX_GPG_FINGERPRINT=41539BBD4020945DB378F98B2DF45277AEF09A2F

composer install --no-interaction

# --force replaces hooks already in .git/hooks, which is shared with the host.
vendor/bin/captainhook install --force --no-interaction

# Installs Box into tools/ (see .phive/phars.xml). Trusting the key up front avoids
# PHIVE's interactive prompt.
phive --no-progress install --trust-gpg-keys "$BOX_GPG_FINGERPRINT"
