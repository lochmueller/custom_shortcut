<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Page\PageRepositoryGetPageHookInterface;

$GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'] = [
    'tt_content' => \HDNET\CustomShortcut\Shortcut\Content::class,
    'pages' => \HDNET\CustomShortcut\Shortcut\Page::class
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\HDNET\CustomShortcut\Upgrade\ShortcutUpgrade::class] = \HDNET\CustomShortcut\Upgrade\ShortcutUpgrade::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Frontend\Page\PageRepository::class] = [
    'className' => \HDNET\CustomShortcut\Overrides\PageRepository::class,
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = \HDNET\CustomShortcut\Hooks\GetPageHook::class;
