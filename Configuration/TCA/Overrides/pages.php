<?php

use HDNET\CustomShortcut\Shortcut\ShortcutInterface;

$GLOBALS['TCA']['pages']['columns']['shortcut']['config']['prepend_tname'] = 1;
$GLOBALS['TCA']['pages']['columns']['shortcut']['config']['allowed'] = implode(',', array_map(
    function (ShortcutInterface $integration) {
        return $integration->getTableName();
    },
    (array) $GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut']));
