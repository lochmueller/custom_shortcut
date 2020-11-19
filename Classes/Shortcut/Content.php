<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Content implements ShortcutInterface
{
    public function getTableName(): string
    {
        return 'tt_content';
    }

    public function resolvePageId(int $recordId): int
    {
        $record = BackendUtility::getRecord('tt_content', $recordId);

        return (int) $record['pid'];
    }

    public function resolveUrl(string $target, ContentObjectRenderer $contentObjectRenderer): string
    {
        $id = (int) str_replace($this->getTableName().'_', '', $target);

        $record = BackendUtility::getRecord($this->getTableName(), $id);

        return $contentObjectRenderer->getTypoLink_URL($record['pid']).'#c'.$id;
    }
}
