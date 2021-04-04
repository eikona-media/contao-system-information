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

    $skips                                          = [];
    $skips[MethodChainingIndentationFixer::class]   = ['*/DependencyInjection/Configuration.php'];
    $skips[DisallowArrayTypeHintSyntaxSniff::class] = ['*Model.php'];

    if (defined(Option::class . '::EXCLUDE_PATHS')) {
        $parameters->set(Option::EXCLUDE_PATHS, ['*/templates/*.html5']);
    } else {
        $skips[] = '*/templates/*.html5';
    }

    $parameters->set(Option::SKIP, $skips);

    $services = $containerConfigurator->services();
    $services
        ->set(HeaderCommentFixer::class)
        ->call(
            'configure',
            [
                [
                    'header' => "This file is part of System Information Bundle for Contao Open Source CMS.\n\n(c) eikona-media.de\n\n@license MIT",
                ]
            ]
        );
};
