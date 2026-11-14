<?php

/**
 * Records line coverage of src/yaml-lint.php in each PHP process.
 *
 * The tests run the CLI in subprocesses, which PHPUnit's own coverage can't see. This file
 * is loaded into every process with `auto_prepend_file` (see the CI quality job), and
 * writes that process's coverage to YAML_LINT_COVERAGE_DIR when the process exits.
 * Requires the PCOV extension.
 */

$yamlLintCoverageDir = getenv('YAML_LINT_COVERAGE_DIR');

if ($yamlLintCoverageDir !== false && extension_loaded('pcov')) {
    \pcov\start();
    register_shutdown_function(function () use ($yamlLintCoverageDir) {
        \pcov\stop();
        $source = realpath(__DIR__ . '/../../src/yaml-lint.php');
        $data = \pcov\collect(\pcov\inclusive, [$source]);
        if (isset($data[$source])) {
            file_put_contents(
                $yamlLintCoverageDir . '/' . uniqid('', true) . '.json',
                json_encode($data[$source])
            );
        }
    });
}
