<?php

$GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'] = [
    'tt_content' => \HDNET\CustomShortcut\Shortcut\Content::class,
    'pages' => \HDNET\CustomShortcut\Shortcut\Page::class
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\HDNET\CustomShortcut\Upgrade\ShortcutUpgrade::class] = \HDNET\CustomShortcut\Upgrade\ShortcutUpgrade::class;

$versionGreaterEquals11 = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger('11.0');
$versionGreaterEquals12 = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger('12.0');
$versionGreaterEquals13 = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger('13.0');

if($versionGreaterEquals13) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::class] = [
        'className' => \HDNET\CustomShortcut\Overrides\PageRepository13::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = \HDNET\CustomShortcut\Hooks\GetPageHook10::class;
} else if($versionGreaterEquals12) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::class] = [
        'className' => \HDNET\CustomShortcut\Overrides\PageRepository12::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = \HDNET\CustomShortcut\Hooks\GetPageHook10::class;
} else if($versionGreaterEquals11) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::class] = [
        'className' => \HDNET\CustomShortcut\Overrides\PageRepository11::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = \HDNET\CustomShortcut\Hooks\GetPageHook10::class;
} else {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::class] = [
        'className' => \HDNET\CustomShortcut\Overrides\PageRepository::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['getPage'][] = \HDNET\CustomShortcut\Hooks\GetPageHook::class;
}



$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typolinkLinkHandler']['shortcut'] = \HDNET\CustomShortcut\ShortcutLinkHandler::class;
