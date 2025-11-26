<?php

declare(strict_types=1);
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$baseDir = dirname(__DIR__, 3);

require $baseDir.'/.Build/vendor/autoload.php';

$finder = (new Finder())
    ->in($baseDir.'/Classes')
    ->in($baseDir.'/Configuration/TCA')
    ->in($baseDir.'/Resources/Private/Build')
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP73Migration' => true,
        '@PHP71Migration:risky' => true,
    ])
    ->setFinder($finder)
    ->setUnsupportedPhpVersionAllowed(true)
;
