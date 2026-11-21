# Changelog

## [Unreleased]

### Updated

* Publish the Docker Hub overview from the Docker workflow, with the current release and the PHP and symfony/yaml versions in the image filled in (#286)
* Support PHP 8.6: test it with every supported symfony/yaml version, and move the Docker image and the dev container to it. The Docker image now also installs Alpine package updates when it is built, and the newest release's image is rebuilt monthly (#267)
* Update ECS to 13.3.19, which fixes a false "no break" error after `exit` in a `switch` case. ECS 13.3.16 and 13.3.17 needed a temporary skip in `ecs.php` (#282, #284)

## [1.1.9] - 2026-11-14

### Added

* Docker image, published to Docker Hub as `j13k/yaml-lint` with each release (#56)

### Updated

* Install PHIVE and Box in the dev container, so the PHAR can be built there, and update Box to 4.7.1 (#258)
* Sign release tags, starting with 1.1.8 (#261)
* Add a security policy, with reporting through GitHub's private vulnerability reporting (#263)
* Pin GitHub Actions to commit SHAs, and update the artifact actions to their current versions (#265)
* Restructure the README (requirements, installation, usage examples and exit codes, troubleshooting), and bring CONTRIBUTING.md and RELEASE.md up to date (#269)
* Add issue forms (bug report, feature request), a pull request template, and a link to the security policy on the new-issue page. Dependabot updates dev dependencies again, with minor and patch updates grouped into one pull request (#270)
* Adjust the ECS configuration for ECS 13.3: skip the short list syntax rule until the minimum PHP version allows it (#276)
* Move `ecs.php` to the `ECSConfig::configure()` format (#278)
* Update symfony/deprecation-contracts to 3.8.1 in the PHAR and the Docker image

## [1.1.8] - 2026-11-14

### Fixed

* Update bundled symfony/yaml and symfony/filesystem to 7.4.23 for security advisories, including CVE-2026-109413 (#239)
* Document the `yaml-lint` binary name conflict with symfony/yaml (#181)
* Strengthen the PHAR signature verification steps: full key fingerprint, and the key from GitHub or keyserver.ubuntu.com instead of a copy in the repository (#255)
* Report a clear error when a path is a directory, instead of a PHP notice and "Input has no content" (#33)

### Added

* Support for symfony/yaml 8 (#184)
* Versioning policy and release process documentation in `RELEASE.md` (#183, #246)
* PHIVE configuration for building the PHAR
* Dev container configuration (#213)
* Git hooks via CaptainHook that enforce Conventional Commits and run quality checks (#187)
* markdownlint configuration (#194)

### Updated

* Raise PHPStan to level 4 (#192) and apply ECS code style fixes (#193)
* Fix Dependabot updates and extend them to GitHub Actions and the dev container (#189)
* Allow legacy symfony/yaml versions with security advisories in the CI matrix (#233, #237)
* Use 2-space indentation for JSON files (#242)
* Remove the stale bot (#244)
* Upgrade to PHPUnit 12, covered in CI on PHP 8.3 and later (#179)
* Cover PHP 8.5 and 8.6 in the CI job matrix (#184)
* Add a CI quality job (Composer validation and audit, ECS, PHPStan, markdownlint, YAML lint), run CI on pull requests and weekly, and cancel superseded runs (#186)
* Report code coverage in CI, with a coverage badge (#250)
* Distribution archives now contain only `bin/`, `src/`, `composer.json`, `LICENSE`, `README.md` and `CHANGELOG.md`, with a CI smoke test (#190)

## [1.1.7] - 2025-10-24

### Added

* Add `--parse-tags` / `-t` option to enable custom YAML tag support (#166)
* Add helpful error hint when custom tags are encountered without the flag
* Add test fixture and comprehensive tests for custom tags functionality

### Fixed

* Fix CI compatibility with PHP 5.6-7.1 by removing `composer-runtime-api` dependency
* Fix dev dependencies interference in CI by removing them before composer update
* Fix test suite Symfony version detection to work reliably on PHP 5.6 (use installed.json)

### Updated

* Bump symfony/yaml from 7.0.3 to 7.3.3 (via Dependabot)
* Covered PHP 8.4 in CI job matrix
* Documentation updates for `--parse-tags` option
* Note: Custom tags feature requires Symfony YAML 3+, gracefully handles v2

## [1.1.6] - 2024-04-18

### Added

* Add tests covering quiet mode (<https://github.com/j13k/yaml-lint/issues/51>)

### Updated

* Add and test Symfony 7 support (<https://github.com/j13k/yaml-lint/issues/99>)
* Covered PHP 8.3 and PHPUnit 11 in CI job matrix (<https://github.com/j13k/yaml-lint/issues/98>)
* Documentation updates, including PHIVE and Docker installation methods

## [1.1.5] - 2023-04-20

### Added

* Symfony 6 support (<https://github.com/j13k/yaml-lint/issues/45>) via [@wow-apps](https://github.com/wow-apps)
* Unit tests (<https://github.com/j13k/yaml-lint/issues/5>)

### Updated

* Bump symfony/yaml from 5.2.5 to v6.2.7

### Refactor

* Updated .gitattributes

### Fixed

* Switched to using Composer\InstalledVersions for yaml component version (<https://github.com/j13k/yaml-lint/issues/47>)

## [1.1.4] - 2021-03-11

### Added

* Support for multiple files (resolves #3, via [@staabm](https://github.com/staabm))
* Support for Symfony 5 YAML component (via [@OndraM](https://github.com/OndraM))
* Branch alias for 1.1.x-dev
* Dependabot config

### Updated

* `composer.lock` tracks `symfony/yaml` v5.2.5
* Add compare links to changelog (resolves #14)
* Updated box.json to support changes in upstream requirements

### Fixed

* Stopped notice when Composer manifest name key is undefined (via [@SimonMacIntyre](https://github.com/SimonMacIntyre))

## [1.1.3] - 2018-03-27

### Updated

* `composer.lock` tracks `symfony/yaml` v4.0.6

### Fixed

* Added input args validation to check for multiple files and updated README
  (fixes #7)
* Improved syntax in README docs (resolves #4)

## [1.1.2] - 2017-12-07

### Added

* Added support for Symfony 4 YAML component
* New CLI option for displaying application version
* README documentation now includes 'dependencies' badge

### Updated

* Refactored custom 'UsageException' class into standalone file
* Updated application descriptions to emphasise 'compact' design of the application
* composer update now tracks latest Symfony 4 YAML in local sandbox (composer.lock)

### Fixed

* Fix to accommodate changes in the Yaml::parse method introduced in v3

## [1.1.1] - 2016-11-11

### Added

* Switched to full array notation, allowing legacy PHP support (via [neilime](https://github.com/neilime))
* composer update tracks latest Symfony 3 YAML in local sandbox (composer.lock)

## [1.1.0] - 2016-09-12

### Added

* Support for reading from stdin
* box.json manifest for building PHAR binaries
* Enabled support for Symfony 3 YAML component

## [1.0.0] - 2016-03-02

### Added

* Initial release

[1.0.0]: https://github.com/j13k/yaml-lint/compare/e2142c1..1.0.0

[1.1.0]: https://github.com/j13k/yaml-lint/compare/1.0.0..1.1.0

[1.1.1]: https://github.com/j13k/yaml-lint/compare/1.1.0..1.1.1

[1.1.2]: https://github.com/j13k/yaml-lint/compare/1.1.1..1.1.2

[1.1.3]: https://github.com/j13k/yaml-lint/compare/1.1.2..1.1.3

[1.1.4]: https://github.com/j13k/yaml-lint/compare/1.1.3..1.1.4

[1.1.5]: https://github.com/j13k/yaml-lint/compare/1.1.4..1.1.5

[1.1.6]: https://github.com/j13k/yaml-lint/compare/1.1.5..1.1.6

[1.1.7]: https://github.com/j13k/yaml-lint/compare/1.1.6..1.1.7

[1.1.8]: https://github.com/j13k/yaml-lint/compare/1.1.7..1.1.8

[1.1.9]: https://github.com/j13k/yaml-lint/compare/1.1.8..1.1.9

[Unreleased]: https://github.com/j13k/yaml-lint/compare/1.1.9..HEAD
