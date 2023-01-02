<?php

use HDNET\CustomShortcut\Middleware\CustomShortcutMiddleware;

return [
    'frontend' => [
        'custom-shortcut/direct-access' => [
            'target' => CustomShortcutMiddleware::class,
            'before' => [
                'typo3/cms-frontend/tsfe',
                'typo3/cms-adminpanel/sql-logging',
                'typo3/cms-frontend/preview-simulator',
            ],
            'after' => [
                'typo3/cms-frontend/page-resolver',
            ],
        ],
    ],
];
