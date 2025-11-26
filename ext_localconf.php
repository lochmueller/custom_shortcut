<?php

use HDNET\CustomShortcut\Hooks\GetPageHook10;
use HDNET\CustomShortcut\Overrides\PageRepository11;
use HDNET\CustomShortcut\Overrides\PageRepository12;
use HDNET\CustomShortcut\Overrides\PageRepository13;
use HDNET\CustomShortcut\Shortcut\Content;
use HDNET\CustomShortcut\Shortcut\Page;
use HDNET\CustomShortcut\ShortcutLinkHandler;
use HDNET\CustomShortcut\Upgrade\ShortcutUpgrade;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

$GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'] = [
    'tt_content' => Content::class,
    'pages' => Page::class
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][ShortcutUpgrade::class] = ShortcutUpgrade::class;

$versionGreaterEquals12 = VersionNumberUtility::convertVersionNumberToInteger(VersionNumberUtility::getNumericTypo3Version()) >= VersionNumberUtility::convertVersionNumberToInteger('12.0');
$versionGreaterEquals13 = VersionNumberUtility::convertVersionNumberToInteger(VersionNumberUtility::getNumericTypo3Version()) >= VersionNumberUtility::convertVersionNumberToInteger('13.0');

if($versionGreaterEquals13) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][PageRepository::class] = [
        'className' => PageRepository13::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = GetPageHook10::class;
} else if($versionGreaterEquals12) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][PageRepository::class] = [
        'className' => PageRepository12::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = GetPageHook10::class;
} else {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][PageRepository::class] = [
        'className' => PageRepository11::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = GetPageHook10::class;
}


$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typolinkLinkHandler']['shortcut'] = ShortcutLinkHandler::class;
