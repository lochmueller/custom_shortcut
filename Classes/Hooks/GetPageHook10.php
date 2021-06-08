<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Hooks;

use HDNET\CustomShortcut\Utility\HelperUtility;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Domain\Repository\PageRepositoryGetPageHookInterface;

class GetPageHook10 implements PageRepositoryGetPageHookInterface
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
