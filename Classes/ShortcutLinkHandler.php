<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut;

use HDNET\CustomShortcut\Shortcut\ShortcutInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ShortcutLinkHandler
{
    public function main($linkText, $configuration, $linkHandlerKeyword, $linkHandlerValue, $mixedLinkParameter, $contentObjectRenderer)
    {
        $target = str_replace('shortcut://', '', $configuration['parameter']);
        $handler = $this->getShortlinkHandler($target);

        return [
            'href' => $handler->resolveUrl($target, $contentObjectRenderer),
            'target' => '',
            'class' => '',
            'title' => '',
        ];
    }

    protected function getShortlinkHandler(string $target): ShortcutInterface
    {
        $parts = GeneralUtility::revExplode('_', trim($target), 2);
        $items = (array) $GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'];
        foreach ($items as $item) {
            /** @var ShortcutInterface $object */
            $object = GeneralUtility::makeInstance($item);
            if ($object->getTableName() === $parts[0]) {
                return $object;
            }
        }

        throw new \Exception('Unsupported shotcut type: '.$target);
    }
}
