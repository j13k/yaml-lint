# Contributing to yaml-lint

Thank you for your interest in contributing to yaml-lint! This document provides guidelines and information to help you contribute effectively.

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
- **style**: Code style changes (formatting, missing semicolons, etc.)
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

After running `vendor/bin/captainhook install`, the following hooks are active:

### Pre-commit Hook

- Runs ECS (Easy Coding Standard) on staged PHP files
- Ensures code style consistency before committing

### Commit-msg Hook

- Validates commit messages against Conventional Commits format
- Prevents commits with invalid message format

### Pre-push Hook

- Runs PHPStan static analysis
- Runs the full test suite
- Prevents pushing code that doesn't pass quality checks

### Skipping Hooks

In rare cases where you need to skip hooks, use `--no-verify`:

```bash
git commit --no-verify -m "emergency fix"
```

**Note:** Use this sparingly and only when necessary.

## Code Quality

### Running Tests

```bash
composer test
# or
./vendor/bin/phpunit
```

### Code Style Check

```bash
composer code-style
# or
./vendor/bin/ecs check .
```

### Static Analysis

```bash
composer code-analyse
# or
./vendor/bin/phpstan analyze --level 4 src
```

### Markdown Linting

```bash
composer markdown-lint
```

This uses the markdownlint-cli2 Docker image to lint markdown files. Requires Docker to be installed and running.

### Running All Checks

Before submitting a pull request, ensure all checks pass:

```bash
composer test && composer code-style && composer code-analyse && composer markdown-lint
```

## Testing

- Add tests for new features in `tests/`
- Ensure all tests pass before submitting a PR
- Consider edge cases and error conditions
- Test across multiple PHP and Symfony versions when possible

## Pull Requests

**Important**: All non-trivial changes should have an associated GitHub issue before submitting a PR. This helps with:

- Discussion of the approach before implementation
- Tracking the reasoning behind changes
- Linking commits and PRs to specific issues

### Process

1. **Create or find an issue** describing the bug or feature
2. Fork the repository
3. Create a feature branch from `master`
4. Make your changes following the guidelines above
5. Ensure all tests and quality checks pass
6. Submit a pull request that references the issue (e.g., "Closes #123")

### PR Title Format

PR titles should also follow Conventional Commits format:

```text
feat: add support for JSON output format
fix: resolve memory leak in large file processing
```

## Questions or Issues?

- Check existing [issues](https://github.com/j13k/yaml-lint/issues)
- Open a new issue if you find a bug or have a feature request
- For general questions, feel free to start a discussion

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
