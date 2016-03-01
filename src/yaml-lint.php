<?php

namespace J13k\YamlLint;

/**
 * yaml-lint, a command line utility for checking YAML file syntax.
 *
 * Uses the parsing facility of the Symfony Yaml Component.
 *
 * For full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

define('APP_NAME', 'yaml-lint');
define('APP_VERSION', '1.0.0');

define('ANSI_RED', 1);
define('ANSI_GRN', 2);

// Init app name and args
$appStr = APP_NAME . ' ' . APP_VERSION;
$argQuiet = false;
$argPath = null;

try {

    // Composer bootstrap
    foreach (['/../../../', '/../vendor/'] as $pathToTry) {
        if (is_readable(__DIR__ . $pathToTry . 'autoload.php')) {
            /** @noinspection PhpIncludeInspection */
            require __DIR__ . $pathToTry . 'autoload.php';
            break;
        }
    }
    if (!class_exists('\Composer\Autoload\ClassLoader')) {
        throw new \Exception(_msg('composer'));
    }

    // Process and check args
    $argv = $_SERVER['argv'];
    array_shift($argv);
    foreach ($argv as $arg) {
        switch ($arg) {
            case '-h':
            case '--help':
                throw new UsageException();
            case '-q':
            case '--quiet':
                $argQuiet = true;
                break;
            default:
                $argPath = $arg;
        }
    }
    if (!$argPath) {
        throw new UsageException('No file specified', 1);
    }

    // Check input file
    if (!is_readable($argPath)) {
        throw new \Exception('File is not readable', 1);
    }

    // Output messages if allowed
    if (!$argQuiet) {
        print $appStr . ' Parsing ' . $argPath;
    }

    // Do the thing
    Yaml::parse(file_get_contents($argPath), true);

    // Success
    if (!$argQuiet) {
        printf(" [ %s ]\n", _ansify('OK', ANSI_GRN));
    }
    exit(0);

} catch (UsageException $e) {

    // Usage message
    print $appStr . "\n\n";
    if ($e->getMessage()) {
        fwrite(STDERR, sprintf("%s\n\n", _ansify($e->getMessage(), ANSI_RED)));
    }
    print _msg('usage');
    exit($e->getCode());

} catch (ParseException $e) {

    // Syntax exception
    if ($argQuiet) { // If argQuiet filtered earlier message, output it now
        fwrite(STDERR, $appStr . ' Parsing ' . $argPath);
    }
    fwrite(STDERR, sprintf(" [ %s ]\n", _ansify('ERROR', ANSI_RED)));
    fwrite(STDERR, "\n" . $e->getMessage() . "\n\n");
    exit(1);

} catch (\Exception $e) {

    // The rest
    fwrite(STDERR, $appStr);
    fwrite(STDERR, sprintf("\n\n%s\n\n", _ansify($e->getMessage(), ANSI_RED)));
    exit(1);

}

/**
 * Helper to wrap input string in ANSI colour code
 *
 * @param string $str
 * @param int    $colourCode
 *
 * @return string
 */
function _ansify($str, $colourCode)
{
    $colourCode = max(0, $colourCode);
    $colourCode = min(255, $colourCode);

    return sprintf("\033[38;5;%dm%s\033[0m", $colourCode, $str);
}

/**
 * Wrapper for heredoc messages
 *
 * @param string $str
 *
 * @return string
 */
function _msg($str)
{
    switch ($str) {
        case 'composer':
            return <<<EOD
Composer dependencies cannot be loaded; run the following commands to remedy:
 curl -sS https://getcomposer.org/installer | php
 php composer.phar install
EOD;
            break;
        case 'usage':
            return <<<EOD
usage: yaml-lint [<options>] <path>

  -q, --quiet     Restrict output to syntax errors
  -h, --help      Display this help


EOD;
            break;
        default:
    }

    return '';
}

/**
 * Runtime exception for triggering usage message
 *
 * @property int $code Exception code is passed through as script exit code
 */
class UsageException extends \RuntimeException {}
