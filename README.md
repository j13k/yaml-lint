# yaml-lint

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Docker Image Version][ico-docker]][link-docker]
[![CI][ico-github-ci]][link-github-ci]
[![Coverage][ico-coverage]][link-github-ci]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE)

A compact command line tool for checking YAML file syntax, using the parsing facility of the
[Symfony Yaml component](https://github.com/symfony/yaml).

- Works with PHP 5.6 and later, and symfony/yaml 2 to 8.
- Also available as a signed, standalone PHAR.
- Reports errors with exit codes, for use in scripts and CI.

## Requirements

- **With Composer:** PHP 5.6 or later, and symfony/yaml 2 to 8. Composer installs the version of
  symfony/yaml that suits your project.
- **As a PHAR:** PHP 8.2 or later, with the `json` and `zlib` extensions. The PHAR bundles
  symfony/yaml 7.4.
- **As a Docker image:** Docker only. The image includes PHP 8.6 and symfony/yaml 7.4.

> [!NOTE]
> Version 1.2.0 will drop support for symfony/yaml 2 to 4, which no longer receive security fixes,
> and require PHP 7.2.5 or later ([#268](https://github.com/j13k/yaml-lint/issues/268)). Projects
> on older versions will keep receiving 1.1.x.

## Installation

### Composer

Install yaml-lint as a development dependency of your project:

```bash
composer require --dev j13k/yaml-lint
```

Then run it as `vendor/bin/yaml-lint`.

To install it globally instead:

```bash
composer global require j13k/yaml-lint
```

Make sure Composer's global `bin` directory (`composer global config bin-dir --absolute`) is on
your `PATH`.

If Composer reports a binary name conflict during installation, see
[Troubleshooting](#troubleshooting).

### PHAR

A standalone `yaml-lint.phar` is attached to each [release](https://github.com/j13k/yaml-lint/releases).

- Install it with [PHIVE](https://phar.io/), which also checks its signature: `phive install yaml-lint`
- Or download it from the release, and [verify its signature](#verifying-the-phar-signature).

### Docker

The [`j13k/yaml-lint` image](https://hub.docker.com/r/j13k/yaml-lint) is published with each
release, and needs no PHP or Composer. Mount the files to check at `/workdir`:

```bash
docker run --rm -v "$PWD:/workdir:ro" j13k/yaml-lint config.yml
cat config.yml | docker run --rm -i j13k/yaml-lint -
```

Tags follow the release versions: `x.y.z` for a specific release, `x.y` and `x` for the newest
release in that minor or major version, and `latest` for the newest release.

The [phpqa Docker image](https://hub.docker.com/r/jakzal/phpqa/) includes yaml-lint
alongside other PHP static analysis tools. See the
[phpqa instructions](https://github.com/jakzal/phpqa#running-tools) for how to run it.

## Usage

```text
usage: yaml-lint [options] [input source]

  input source      Path to file(s), or "-" to read from standard input

  -q, --quiet       Restrict output to syntax errors
  -t, --parse-tags  Enable parsing of custom YAML tags (symfony/yaml 3+ only)
  -h, --help        Display this help
  -V, --version     Display application version
```

Check one or more files:

```bash
yaml-lint config.yml
yaml-lint config.yml services.yml
```

Check YAML from standard input:

```bash
cat config.yml | yaml-lint -
```

Check every non-vendor YAML file in a project, for example in CI:

```bash
find . -path ./vendor -prune -o \( -name '*.yml' -o -name '*.yaml' \) -print0 \
  | xargs -0 -n 1 vendor/bin/yaml-lint --quiet
```

`-n 1` runs yaml-lint once per file, so every error is reported rather than only the first (see
[Exit codes](#exit-codes)). If any file fails, `xargs` exits with code 123.

### Exit codes

| Code | Meaning |
| --- | --- |
| `0` | All input is valid YAML (or `--help` or `--version` was used) |
| `1` | A syntax error, a missing or unreadable file, a directory, or invalid options |

Checking stops at the first file with an error.

## Verifying the PHAR signature

Release PHARs are signed with GPG, using the key with this fingerprint:

```text
528E 7737 B566 750F 7C00  D32A 38A1 82AB 4130 64D7
```

<details>
<summary>How to verify the signature</summary>

1. Download `yaml-lint.phar` and `yaml-lint.phar.asc` from the
   [releases page](https://github.com/j13k/yaml-lint/releases).

2. Import the public key, either from the maintainer's GitHub account:

   ```bash
   curl -fsSL https://github.com/j13k.gpg | gpg --import
   ```

   Or from a keyserver:

   ```bash
   gpg --keyserver hkps://keyserver.ubuntu.com --recv-keys 528E7737B566750F7C00D32A38A182AB413064D7
   ```

3. Verify the signature:

   ```bash
   gpg --verify yaml-lint.phar.asc yaml-lint.phar
   ```

   Check that the output says `Good signature` and shows the fingerprint above. A warning that
   the key isn't certified with a trusted signature is normal unless you've signed the key
   yourself.

</details>

## Troubleshooting

<details>
<summary>Composer reports a binary name conflict</summary>

symfony/yaml has its own `yaml-lint` binary. If it's installed first, Composer skips this
package's binary and shows:

```text
Skipped installation of bin bin/yaml-lint for package j13k/yaml-lint:
name conflicts with an existing file
```

`vendor/bin/yaml-lint` then runs symfony/yaml's linter. To run this package's yaml-lint, call it
directly:

```bash
vendor/j13k/yaml-lint/bin/yaml-lint
```

Or replace symfony/yaml's link in `vendor/bin` with one to this package. `-f` overwrites the
existing link:

```bash
ln -sf ../j13k/yaml-lint/bin/yaml-lint vendor/bin/yaml-lint
```

Composer may restore symfony/yaml's link on a later install or update, so this may need
repeating.

See [#181](https://github.com/j13k/yaml-lint/issues/181) for background.

</details>

## Contributing

Contributions are welcome.

- The [contributing guide](CONTRIBUTING.md) covers the development setup and conventions.
- To report a security vulnerability, see the [security policy](SECURITY.md).

## Versioning and changelog

Releases follow [semantic versioning](https://semver.org/).

- The [release process](RELEASE.md#versioning) sets out which changes go into patch, minor and
  major releases.
- The [changelog](CHANGELOG.md) lists what has changed in each release.

## Credits

[![yaml-lint contributors][ico-contributors]][link-contributors]

Thanks also to the [Symfony Yaml contributors](https://github.com/symfony/yaml/graphs/contributors?all=1).

## License

Released under the [MIT License](LICENSE).

[ico-version]: https://img.shields.io/packagist/v/j13k/yaml-lint.svg?style=flat-square
[ico-docker]: https://img.shields.io/docker/v/j13k/yaml-lint?sort=semver&label=docker&style=flat-square
[ico-github-ci]: https://img.shields.io/github/actions/workflow/status/j13k/yaml-lint/ci.yml?branch=master&label=CI&style=flat-square
[ico-coverage]: https://img.shields.io/endpoint?url=https%3A%2F%2Fraw.githubusercontent.com%2Fj13k%2Fyaml-lint%2Fbadges%2Fcoverage.json&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/j13k/yaml-lint.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-contributors]: https://contrib.rocks/image?repo=j13k/yaml-lint
[link-packagist]: https://packagist.org/packages/j13k/yaml-lint
[link-docker]: https://hub.docker.com/r/j13k/yaml-lint
[link-github-ci]: https://github.com/j13k/yaml-lint/actions/workflows/ci.yml
[link-downloads]: https://packagist.org/packages/j13k/yaml-lint/stats
[link-contributors]: https://github.com/j13k/yaml-lint/graphs/contributors?all=1
