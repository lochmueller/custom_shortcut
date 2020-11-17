<?php

$GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'] = [
    'tt_content' => \HDNET\CustomShortcut\Shortcut\Content::class,
    'pages' => \HDNET\CustomShortcut\Shortcut\Page::class
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\HDNET\CustomShortcut\Upgrade\ShortcutUpgrade::class] = \HDNET\CustomShortcut\Upgrade\ShortcutUpgrade::class;
