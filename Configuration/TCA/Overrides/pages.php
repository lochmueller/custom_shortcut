<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\GeneralUtility;

$items = (array) $GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'];
$GLOBALS['TCA']['pages']['columns']['shortcut']['config']['prepend_tname'] = 1;
$GLOBALS['TCA']['pages']['columns']['shortcut']['config']['allowed'] = implode(',', array_map(
    static function (string $className): string {
        return GeneralUtility::makeInstance($className)->getTableName();
    },
    $items
));
