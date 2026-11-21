<!-- The overview on Docker Hub. The Docker workflow fills in the {{...}} values and publishes it with the newest release. -->
# yaml-lint

A compact command line utility for checking YAML file syntax, using the
[symfony/yaml](https://symfony.com/doc/current/components/yaml.html) parser.
The image includes PHP {{PHP_VERSION}} and symfony/yaml {{SYMFONY_YAML_VERSION}}, so you don't
need PHP or Composer installed.

## Usage

Mount the files to check at `/workdir`:

```bash
# Check one file in the current directory
docker run --rm -v "$PWD:/workdir:ro" j13k/yaml-lint config.yml

# Check several files
docker run --rm -v "$PWD:/workdir:ro" j13k/yaml-lint config.yml services.yml
```

Or read from standard input:

```bash
cat config.yml | docker run --rm -i j13k/yaml-lint -
```

Options:

```text
  -q, --quiet       Restrict output to syntax errors
  -t, --parse-tags  Enable parsing of custom YAML tags
  -h, --help        Display this help
  -V, --version     Display application version
```

The exit code is `0` if all input is valid, and `1` for a syntax error, a missing or
unreadable file, or invalid options.

## Tags

Each release is tagged with its version, such as `{{VERSION}}`. These tags move with each release:

- `{{MINOR}}`: the newest {{MINOR}}.x release
- `{{MAJOR}}`: the newest {{MAJOR}}.x release
- `latest`: the newest release, currently {{VERSION}}

Images are built for `linux/amd64` and `linux/arm64`, and the newest release's image is rebuilt
monthly to pick up security fixes.

## More information

- [Source, issues and other ways to install](https://github.com/j13k/yaml-lint)
- [Changelog](https://github.com/j13k/yaml-lint/blob/master/CHANGELOG.md)
- [Security policy](https://github.com/j13k/yaml-lint/security/policy)
