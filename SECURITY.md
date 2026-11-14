# Security Policy

## Supported Versions

Security fixes are released for the latest version only. Upgrade to the latest release to
receive them.

| Version | Supported |
| --- | --- |
| Latest 1.x release | Yes |
| Older releases | No |

## Reporting a Vulnerability

Please report vulnerabilities privately through GitHub's
[private vulnerability reporting](https://github.com/j13k/yaml-lint/security/advisories/new),
not in a public issue.

Include the affected version, how it's installed (Composer, PHAR or Docker), and steps to
reproduce. You can expect an initial response within a week.

## Scope

yaml-lint uses the [Symfony Yaml component](https://github.com/symfony/yaml) to parse YAML.
Report vulnerabilities in the parser itself to Symfony, following
[Symfony's security policy](https://symfony.com/doc/current/contributing/code/security.html).
If a Symfony fix affects the PHAR, which bundles symfony/yaml, a new yaml-lint release will
include it.
