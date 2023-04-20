# yaml-lint

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Total Downloads][ico-downloads]][link-downloads]
[![Monthly Downloads][ico-downloads-monthly]][link-downloads]
[![CI][ico-github-ci]][link-github-ci]

A compact command line utility for checking YAML file syntax. Uses the parsing facility of
the [Symfony Yaml Component](https://github.com/symfony/yaml).

## Usage

```text
usage: yaml-lint [options] [input source]

  input source    Path to file(s), or "-" to read from standard input

  -q, --quiet     Restrict output to syntax errors
  -h, --help      Display this help
  -V, --version   Display application version
```

## Install

Install as a project component with Composer (executable from the project's `vendor/bin` directory):

```bash
composer require j13k/yaml-lint
```

Typically, a binary edition (`yaml-lint.phar`) is also available for download
with [each release](https://github.com/j13k/yaml-lint/releases). This embeds the latest stable version of the Symfony
Yaml component that is current at the time of the release.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for information on what has changed recently.

## Credits

- [yaml-lint contributors][link-contributors]
- [Symfony Yaml contributors](https://github.com/symfony/yaml/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENCE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/j13k/yaml-lint.svg?style=flat-square

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/j13k/yaml-lint.svg?style=flat-square

[ico-downloads-monthly]: https://poser.pugx.org/j13k/yaml-lint/d/monthly

[ico-github-ci]: https://github.com/j13k/yaml-lint/actions/workflows/ci.yml/badge.svg

[link-packagist]: https://packagist.org/packages/j13k/yaml-lint

[link-downloads]: https://packagist.org/packages/j13k/yaml-lint/stats

[link-contributors]: https://github.com/j13k/yaml-lint/contributors

[link-github-ci]: https://github.com/j13k/yaml-lint/actions/workflows/ci.yml
