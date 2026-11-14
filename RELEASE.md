# Release Process

This document describes how to create a new release of yaml-lint.

## Versioning

yaml-lint follows [Semantic Versioning](https://semver.org/). The public interface is the
command line: options, output and exit codes.

| Release | When | Examples |
| --- | --- | --- |
| Patch (`1.1.x`) | Bug fixes and compatible updates | Bug fixes, dependency security updates (the PHAR bundles them), support for new PHP or symfony/yaml versions |
| Minor (`1.x.0`) | New features, or dropping support | New CLI options or behaviour, dropping old PHP or symfony/yaml versions |
| Major (`x.0.0`) | Breaking changes to the CLI | Removing or changing options, output format or exit codes |

Dropping old PHP or symfony/yaml versions is a minor release because Composer keeps
installing the last compatible release on older environments, so nothing breaks.

Changes that affect only development, CI or documentation don't need a release of their
own. They go out with the next release.

Tags use the bare version number, with no `v` prefix (for example `1.1.8`).

## Prerequisites

- PHIVE and Box. The dev container has both (Box is installed into `tools/` when the
  container is created). Elsewhere, install PHIVE and run `phive install`.
- GPG key set up for signing
- Push access to the GitHub repository

## Steps

### 1. Update Version and Changelog

1. Update the version constant in `src/yaml-lint.php`:

   ```php
   define('APP_VERSION', 'x.y.z');
   ```

2. Update `CHANGELOG.md`:
   - Check the entries under `## [Unreleased]`, then rename the heading to `## [x.y.z] - YYYY-MM-DD`.
   - At the bottom, change the `[Unreleased]` compare link to
     `[x.y.z]: https://github.com/j13k/yaml-lint/compare/<previous>..x.y.z`.

3. Commit these changes:

   ```bash
   git add src/yaml-lint.php CHANGELOG.md
   git commit -m "chore: release x.y.z"
   ```

### 2. Create Git Tag

```bash
git tag x.y.z
git push origin master
git push origin x.y.z
```

### 3. Build the PHAR

The PHAR must be built from the git tag to ensure the version is correct.

1. Checkout the tag:

   ```bash
   git checkout x.y.z
   ```

2. Install production dependencies:

   ```bash
   composer install --no-dev
   ```

   **Important:** This step updates `vendor/composer/installed.json` which is how the PHAR gets the correct version number. Without this, the PHAR will show "dev-master".

3. Ensure you have Box installed via PHIVE (already done in the dev container):

   ```bash
   phive install
   ```

4. Build the PHAR:

   ```bash
   ./tools/box compile
   ```

5. Verify the version is correct:

   ```bash
   build/yaml-lint.phar --version
   ```

   Should output: `yaml-lint x.y.z, symfony/yaml vX.Y.Z`

### 4. Sign the PHAR

```bash
gpg --armor --detach-sign build/yaml-lint.phar
```

This creates `build/yaml-lint.phar.asc`.

Verify the signature:

```bash
gpg --verify build/yaml-lint.phar.asc build/yaml-lint.phar
```

### 5. Create GitHub Release

1. Go to <https://github.com/j13k/yaml-lint/releases/new>

2. Select the tag `x.y.z`

3. Use the content from `CHANGELOG.md` for the release notes

   Note: Signature verification instructions are in the [README](README.md#verifying-signatures)

4. Attach both files:
   - `build/yaml-lint.phar`
   - `build/yaml-lint.phar.asc`

5. Publish the release

### 6. Return to Development

```bash
git checkout master
composer install  # Reinstall dev dependencies
```

## Troubleshooting

### PHAR shows "dev-master" instead of version number

- Make sure you ran `composer install --no-dev` from the git tag
- Verify you're building from the tag, not from a branch
- Check that `APP_VERSION` in `src/yaml-lint.php` matches the tag

### Box or PHIVE not working

- Update PHIVE: Check for latest version at <https://phar.io>
- Update Box via PHIVE: `phive update box`
- Box requires PHP 8.2+, so ensure you're using a compatible PHP version

### GPG signing fails

- Check that your GPG key hasn't expired: `gpg --list-secret-keys`
- If expired, extend the expiration or create a new key
- Current signing key fingerprint: `528E 7737 B566 750F 7C00  D32A 38A1 82AB 4130 64D7`
- The public key is published on the GitHub account (`https://github.com/j13k.gpg`) and on
  `keyserver.ubuntu.com`. If the key changes, update both and the fingerprint in the README.

## Files Related to Building

- `.phive/phars.xml` - PHIVE configuration for Box tool
- `box.json` - Box configuration for building the PHAR
- `tools/` - Symlinks to PHIVE-managed tools (gitignored, created by `phive install`)
