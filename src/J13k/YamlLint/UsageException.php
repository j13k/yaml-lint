<?php

declare(strict_types=1);

namespace J13k\YamlLint;

use RuntimeException;

/**
 * Runtime exception for triggering usage message.
 *
 * @property int $code Exception code is passed through as script exit code
 */
class UsageException extends RuntimeException
{
}
