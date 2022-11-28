<?php

declare(strict_types=1);

$baseDir = dirname(__DIR__, 3);

require $baseDir.'/.Build/vendor/autoload.php';

$finder = (new PhpCsFixer\Finder())
    ->in($baseDir.'/Classes')
    ->in($baseDir.'/Configuration/TCA')
    ->in($baseDir.'/Resources/Private/Build')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP73Migration' => true,
        '@PHP71Migration:risky' => true,
    ])
    ->setFinder($finder)
;
