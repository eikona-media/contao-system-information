<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowArrayTypeHintSyntaxSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $vendorDir = __DIR__ . '/vendor';

    if (!is_dir($vendorDir)) {
        $vendorDir = __DIR__ . '/../../vendor';
    }

    $containerConfigurator->import($vendorDir . '/contao/easy-coding-standard/config/self.php');

    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::SKIP,
        [
            '*/templates/*.html5',
            MethodChainingIndentationFixer::class   => [
                '*/DependencyInjection/Configuration.php',
            ],
            DisallowArrayTypeHintSyntaxSniff::class => [
                '*Model.php',
            ],
        ]
    );

    $services = $containerConfigurator->services();
    $services
        ->set(HeaderCommentFixer::class)
        ->call(
            'configure',
            [
                [
                    'header' => "This file is part of System Information Bundle for Contao Open Source CMS.\n\n(c) eikona-media.de\n\n@license MIT",
                ],
            ]
        );
};
