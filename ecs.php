<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
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
    ]);
