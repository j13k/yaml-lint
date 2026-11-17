<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withSets([
        SetList::PSR_12,
        SetList::SPACES,
        SetList::ARRAY,
        SetList::DOCBLOCK,
    ])
    ->withConfiguredRule(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ])
    ->withRules([
        SingleQuoteFixer::class,
    ])
    ->withSkip([
        NotOperatorWithSuccessorSpaceFixer::class,
        // The short list syntax ([$a, $b] = ...) needs PHP 7.1, but the tests still run on
        // PHP 5.6. Re-enable once 1.2.0 raises the minimum PHP version (#268).
        ListSyntaxFixer::class,
        // ECS's Go engine (Blink, run automatically since ECS 13.3.16) wants a "no break"
        // comment after exit in a switch case. Remove once fixed upstream (#282):
        // https://github.com/ecsphp/ecs/issues/346
        NoBreakCommentFixer::class => [__DIR__ . '/src/yaml-lint.php'],
    ]);
