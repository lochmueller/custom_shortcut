<?php

use HDNET\CustomShortcut\Hooks\GetPageHook;
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

$currentVersion = VersionNumberUtility::convertVersionNumberToInteger(VersionNumberUtility::getNumericTypo3Version());

$extendedClassName = PageRepository11::class;
if($currentVersion >= VersionNumberUtility::convertVersionNumberToInteger('13.0')) {
    $extendedClassName = PageRepository13::class;
} else if($currentVersion >= VersionNumberUtility::convertVersionNumberToInteger('12.0')) {
    $extendedClassName = PageRepository12::class;
}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][PageRepository::class] = [
    'className' => $extendedClassName,
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = GetPageHook::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typolinkLinkHandler']['shortcut'] = ShortcutLinkHandler::class;
