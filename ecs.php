<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);

    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    $ecsConfig->rules([
        SingleQuoteFixer::class,
    ]);

    $ecsConfig->sets([
        // run and fix, one by one
        SetList::PSR_12,
        SetList::SPACES,
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::PSR_12,
    ]);

    $ecsConfig->skip([
        NotOperatorWithSuccessorSpaceFixer::class,
    ]);
};
