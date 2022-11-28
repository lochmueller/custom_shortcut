<?php

use HDNET\CustomShortcut\Middleware\CustomShortcutMiddleware;

return [
    'frontend' => [
        'custom-shortcut/direct-access' => [
            'target' => CustomShortcutMiddleware::class,
            'before' => [
                'typo3/cms-frontend/tsfe',
            ],
            'after' => [
                'typo3/cms-frontend/page-resolver',
            ],
        ],
    ],
];
