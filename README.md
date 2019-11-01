# yaml-lint

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Total Downloads][ico-downloads]][link-downloads]
[![Scrutinizer Code Quality][ico-code-quality]][link-code-quality]

A compact command line utility for checking YAML file syntax. Uses the parsing
facility of the [Symfony Yaml Component](https://github.com/symfony/yaml).

## Usage

```text
usage: yaml-lint [options] [input source]

  input source    Path to file, or "-" to read from standard input

  -q, --quiet     Restrict output to syntax errors
  -h, --help      Display this help
  -V, --version   Display application version
```

:information_source: Note that only _single files_ or standard input are supported
in the current stable release, 1.1.3.

:loudspeaker: Experimental support for multiple files is available in `dev-master`.
 
## Install

Install as a project component with Composer (executable from the project's
 `vendor/bin` directory):

```bash
composer require j13k/yaml-lint
```

Typically a binary edition (`yaml-lint.phar`) is also available for download
with [each release](https://github.com/j13k/yaml-lint/releases). This embeds
the latest stable version of the Symfony Yaml component that is current at
the time of the release.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for information on what has
changed recently.

## Credits

- [yaml-lint contributors][link-contributors]
- [Symfony Yaml contributors](https://github.com/symfony/yaml/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENCE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/j13k/yaml-lint.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/j13k/yaml-lint/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/j13k/yaml-lint.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/j13k/yaml-lint.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/j13k/yaml-lint.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/j13k/yaml-lint
[link-travis]: https://travis-ci.org/j13k/yaml-lint
[link-scrutinizer]: https://scrutinizer-ci.com/g/j13k/yaml-lint/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/j13k/yaml-lint
[link-downloads]: https://packagist.org/packages/j13k/yaml-lint/stats
[link-dependencies]: https://www.versioneye.com/user/projects/58324238eaa74b004633a7c1
[link-author]: https://github.com/j13k
[link-contributors]: ../../contributors
