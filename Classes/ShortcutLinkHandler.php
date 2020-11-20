<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut;

use HDNET\CustomShortcut\Shortcut\ShortcutInterface;
use HDNET\CustomShortcut\Utility\HelperUtility;

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
        $config = HelperUtility::getTableRecordConfiguration($target);

        return HelperUtility::getShortcutHandler($config);
    }
}
