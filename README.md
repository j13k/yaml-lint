# yaml-lint

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Total Downloads][ico-downloads]][link-downloads]
[![Scrutinizer Code Quality][ico-code-quality]][link-code-quality]

Command line utility for checking YAML file syntax. Uses the parsing facility of the [Symfony Yaml Component](https://github.com/symfony/yaml).

## Install

Via Composer:

``` bash
$ composer require j13k/yaml-lint
```

## Usage

``` bash
usage: yaml-lint [options] [input source]

  input source    Path to file, or "-" to read from standard input

  -q, --quiet     Restrict output to syntax errors
  -h, --help      Display this help
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits

- [John Fitzpatrick][link-author]
- [Symfony Yaml contributors](https://github.com/symfony/yaml/graphs/contributors)
- [yaml-lint contributors][link-contributors]

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
[link-downloads]: https://packagist.org/packages/j13k/yaml-lint
[link-author]: https://github.com/j13k
[link-contributors]: ../../contributors
