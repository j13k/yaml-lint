# Contributing to yaml-lint

## Development Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/j13k/yaml-lint.git
   cd yaml-lint
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Install git hooks (automated quality checks):

   ```bash
   vendor/bin/captainhook install
   ```

### Using the Dev Container

As an alternative to installing PHP and Composer locally, the repository includes a
[dev container](https://containers.dev/) configuration in `.devcontainer/`. Any tool
that supports the Dev Container specification can use it (see
[supporting tools](https://containers.dev/supporting)), including the reference
[`devcontainer` CLI](https://github.com/devcontainers/cli):

```bash
devcontainer up --workspace-folder .
devcontainer exec --workspace-folder . composer test
```

Dependencies, git hooks and Box (for building the PHAR, through PHIVE) are installed
automatically when the container is created.

The git hooks run PHP, and they live in the repository's `.git/hooks` directory,
which is shared with your host. Run git commands (commit, push, checkout) from a
shell inside the container. On a host without PHP the hooks fail and block commits.

Some tools copy your host git configuration into the container and others don't.
If `git config user.name` is empty inside the container, set your name and email
there before committing.

## Commit Message Convention

This project follows the [Conventional Commits](https://www.conventionalcommits.org/) specification. Commit messages are automatically validated via git hooks.

### Format

```text
<type>(<scope>): <description>

[optional body]

[optional footer]
```

### Types

- **feat**: A new feature
- **fix**: A bug fix
- **docs**: Documentation only changes
- **style**: Code style or formatting changes
- **refactor**: Code changes that neither fix a bug nor add a feature
- **perf**: Performance improvements
- **test**: Adding or updating tests
- **build**: Changes to build system or dependencies
- **ci**: Changes to CI configuration files and scripts
- **chore**: Other changes that don't modify src or test files
- **revert**: Reverts a previous commit

### Examples

```bash
feat: add support for custom YAML tags
fix: handle directory paths gracefully in multi-file mode
docs: update installation instructions in README
ci: add PHP 8.5 to test matrix
refactor: simplify argument parsing logic
test: add test cases for invalid YAML syntax
```

### Scope (Optional)

You can optionally specify a scope to provide additional context:

```bash
feat(cli): add --parse-tags option
fix(parser): handle nested YAML structures correctly
```

## Git Hooks

After running `vendor/bin/captainhook install` (done automatically in the dev container), these
hooks are active:

| Hook | What it does |
| --- | --- |
| pre-commit | Runs ECS (`composer code-style`) on the project when PHP files are staged |
| commit-msg | Rejects commit messages that don't follow Conventional Commits |
| pre-push | Runs PHPStan (`composer code-analyse`) and the tests (`composer test`) |

In rare cases, `git commit --no-verify` or `git push --no-verify` skips the hooks.

## Code Quality

| Check | Command |
| --- | --- |
| Tests | `composer test` |
| Code style (ECS) | `composer code-style` |
| Static analysis (PHPStan) | `composer code-analyse` |
| Markdown | `composer markdown-lint` (runs [markdownlint-cli2](https://github.com/DavidAnson/markdownlint-cli2) through `npx`, so it needs Node.js, which the dev container has) |

To run them all before opening a pull request:

```bash
composer test && composer code-style && composer code-analyse && composer markdown-lint
```

CI runs these too, plus `composer validate --strict`, `composer audit`, yaml-lint on the
repository's own YAML files, a smoke test of the distribution archive, and the tests against
every supported combination of PHP and symfony/yaml.

## Testing

The tests in `tests/YamlLintTest.php` run the CLI against fixtures in `tests/fixtures/` and check
its output and exit code. Add a case there for any change in behaviour, including error cases.

CI reports line coverage in the quality job's summary. The tests run the CLI in subprocesses, so
coverage is collected by `tests/coverage/prepend.php` rather than by PHPUnit.

### PHP Platform Version for Development

`composer.json` sets `config.platform.php` to `8.3.0`. Composer resolves `composer.lock`
as if it were running on PHP 8.3, whatever PHP version is actually installed.

- **Why:** the package supports PHP 5.6+, but the dev tools (PHPUnit, PHPStan, ECS) need
  PHP 8.x. Without the pin, Composer and Dependabot try to find dev tools that also run on
  PHP 5.6, and fail to resolve.
- **Effect:** the lockfile works on PHP 8.3 and later. Projects that install yaml-lint
  don't use this lockfile or the pin.
- **Older PHP and Symfony versions:** these are tested by the CI matrix, which installs
  each combination separately.
- **Dependabot:** it can't propose updates that need a newer PHP than the pin (for
  example symfony/yaml 8.x, which needs PHP 8.4.1). A security PR targets the lowest
  fixed version. If a newer advisory then affects that version, Composer refuses to
  install it, and Dependabot closes the PR as "no longer updatable" without trying the
  versions in between (as with #236). Update those by hand with `composer update`.
- **When to change:** raise the pin when the dev tools need a newer PHP (PHPUnit 12
  set it to 8.3).

## Pull Requests

Open or find an issue before starting on a non-trivial change, so the approach can be agreed
first.

1. Fork the repository and create a branch from `master`.
2. Make your changes, and check that the checks above pass.
3. Open a pull request that references the issue (for example "Closes #123").

When a pull request is squash-merged, its title becomes the commit message, so it needs to
follow Conventional Commits too, for example:

```text
fix: report a clear error when a path is a directory
ci: pin GitHub Actions to commit SHAs
```

## Questions

Check the [existing issues](https://github.com/j13k/yaml-lint/issues), or open a new one for a
bug, a feature request or a question. To report a security vulnerability, see the
[security policy](SECURITY.md).

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
