<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Hooks;

use HDNET\CustomShortcut\Utility\HelperUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;
use TYPO3\CMS\Frontend\Page\PageRepositoryGetPageHookInterface;

class GetPageHook implements PageRepositoryGetPageHookInterface
{
    public function getPage_preProcess(&$uid, &$disableGroupAccessCheck, PageRepository $parentObject): void
    {
        if ($config = HelperUtility::getTableRecordConfiguration((string) $uid)) {
            if ($integration = HelperUtility::getShortcutHandler($config)) {
                $uid = $integration->resolvePageId($config->getId());
            }
        }
    }
}
