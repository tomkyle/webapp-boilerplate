<?php

/**
 * tomkyle/render
 *
 * Render CSV data with Twig templates.
 */

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withRootFiles()
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        naming: true,
        codingStyle: true,
        codeQuality: true,
    );
