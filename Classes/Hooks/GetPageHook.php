<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Hooks;

use HDNET\CustomShortcut\Shortcut\ShortcutInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;
use TYPO3\CMS\Frontend\Page\PageRepositoryGetPageHookInterface;

class GetPageHook implements PageRepositoryGetPageHookInterface
{
    public function getPage_preProcess(&$uid, &$disableGroupAccessCheck, PageRepository $parentObject): void
    {
        $check = (string) $uid;
        $parts = GeneralUtility::revExplode('_', trim($check), 2);
        if (2 === \count($parts)) {
            $items = (array) $GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'];
            $integrations = array_map(
                function (string $className): ShortcutInterface {
                    return GeneralUtility::makeInstance($className);
                },
                $items
            );
            foreach ($integrations as $integration) {
                /** @var ShortcutInterface $integration */
                if ($parts[0] === $integration->getTableName()) {
                    $uid = $integration->resolvePageId((int) $parts[1]);
                }
            }
        }
    }
}
