<?php

/**
 * Merges the coverage files written by prepend.php and produces:
 * - a Markdown report (coverage summary and uncovered lines), and
 * - a shields.io endpoint JSON file for the coverage badge.
 *
 * Usage: php tests/coverage/report.php <coverage-dir> <report.md> <badge.json>
 */

if ($argc !== 4) {
    fwrite(STDERR, "Usage: php tests/coverage/report.php <coverage-dir> <report.md> <badge.json>\n");
    exit(1);
}

[, $coverageDir, $reportPath, $badgePath] = $argv;

$sourcePath = 'src/yaml-lint.php';
$source = file(__DIR__ . '/../../' . $sourcePath);
$files = glob($coverageDir . '/*.json');

if ($files === [] || $files === false) {
    fwrite(STDERR, "No coverage data found in {$coverageDir}\n");
    exit(1);
}

// A line counts as covered if any process executed it. PCOV marks executable lines it
// didn't execute with -1, and can report a line past the end of the file, which is skipped.
$lines = [];
foreach ($files as $file) {
    foreach (json_decode(file_get_contents($file), true) as $number => $hits) {
        if ($number <= count($source)) {
            $lines[$number] = max($lines[$number] ?? -1, $hits);
        }
    }
}
ksort($lines);

$total = count($lines);
$covered = count(array_filter($lines, fn ($hits) => $hits > 0));
$percent = $total > 0 ? 100 * $covered / $total : 0;

$report = "## Code coverage\n\n";
$report .= sprintf(
    "**%.1f%%** of executable lines in `%s` (%d of %d), from %d CLI processes.\n\n",
    $percent,
    $sourcePath,
    $covered,
    $total,
    count($files)
);

$uncovered = array_keys(array_filter($lines, fn ($hits) => $hits <= 0));
if ($uncovered !== []) {
    $report .= "| Uncovered line | Code |\n| ---: | --- |\n";
    foreach ($uncovered as $number) {
        $code = str_replace('|', '\|', trim($source[$number - 1]));
        $report .= sprintf("| %d | `%s` |\n", $number, $code);
    }
}

file_put_contents($reportPath, $report);

$colour = match (true) {
    $percent >= 90 => 'brightgreen',
    $percent >= 80 => 'green',
    $percent >= 70 => 'yellowgreen',
    $percent >= 60 => 'yellow',
    default => 'red',
};

file_put_contents($badgePath, json_encode([
    'schemaVersion' => 1,
    'label' => 'coverage',
    'message' => sprintf('%d%%', floor($percent)),
    'color' => $colour,
]) . "\n");

echo $report;
