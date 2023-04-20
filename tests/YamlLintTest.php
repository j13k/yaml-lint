<?php

/*
 * yaml-lint, a compact command line utility for checking YAML file syntax.
 *
 * Uses the parsing facility of the Symfony Yaml Component.
 *
 * For full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

/**
 * Unit tests.
 */
class YamlLintTest extends TestCase
{
    /**
     * Test yaml-lint command against test specs.
     *
     * @dataProvider getTestSpecs
     */
    public function testCommandOutput($options, $expectedOutput, $expectedReturnCode, $message)
    {
        // In lieu of setUp
        chmod('tests/fixtures/not_readable.yml', 0200);

        // Run the command line tool
        list($actualOutput, $actualReturnCode) = self::execYamlLint($options);

        // Check the stdout and stderr output
        if (method_exists($this, 'assertStringContainsString')) {
            $this->assertStringContainsString(
                $expectedOutput,
                $actualOutput,
                $message
            );
        } else {
            $this->assertStringContainsStringLegacy(
                $expectedOutput,
                $actualOutput,
                $message
            );
        }

        // Check the return code
        $this->assertEquals(
            $expectedReturnCode,
            $actualReturnCode,
            sprintf('Command failed with return code %s', $actualReturnCode)
        );

        // In lieu of tearDown
        chmod('tests/fixtures/not_readable.yml', 0644);
    }

    /**
     * An implementation of assertStringContainsString that works in legacy PHPUnit releases.
     *
     * @param $needle
     * @param $haystack
     * @param $message
     */
    public function assertStringContainsStringLegacy($needle, $haystack, $message = '')
    {
        $condition = strpos($haystack, $needle) !== false;
        /** @noinspection PhpParamsInspection */
        $this->assertTrue($condition, $message);
    }

    /**
     * Data provider.
     *
     * @return array[]
     */
    public static function getTestSpecs()
    {
        return [
            [
                '',
                'no input specified',
                1,
                'Should display usage exception if no options or input specified',
            ],
            [
                '-h',
                'usage: yaml-lint [options] [input source]',
                0,
                'Should display usage if help option specified',
            ],
            [
                '-V',
                'symfony/yaml',
                0,
                'Should display Symfony package name if version option specified',
            ],
            [
                'tests/fixtures/valid.yml',
                "[ \e[32mOK\e[0m ]",
                0,
                'Should display [ OK ] for valid test fixture file',
            ],
            [
                'tests/fixtures/invalid.yml',
                "[ \e[31mERROR\e[0m ]",
                1,
                'Should display [ ERROR ] message for invalid fixture file',
            ],
            [
                'tests/fixtures/non_existent_file.yml',
                'does not exist',
                1,
                'Should display error message for missing fixture file',
            ],
            [
                'tests/fixtures/not_readable.yml',
                'is not readable',
                1,
                'Should display error message for unreadable fixture file',
            ],
        ];
    }

    /**
     * Exec helper.
     *
     * @param $optionsAndInputSource
     *
     * @return array
     */
    private static function execYamlLint($optionsAndInputSource)
    {
        $output = [];
        $returnCode = null;
        $phpExe = isset($_ENV['YAML_LINT_PHP_PATH']) ? $_ENV['YAML_LINT_PHP_PATH'] : 'php';
        $command = trim(join(' ', [$phpExe, './bin/yaml-lint', $optionsAndInputSource]));
        exec("$command 2>&1", $output, $returnCode);

        return [join(' ', $output), $returnCode];
    }
}
