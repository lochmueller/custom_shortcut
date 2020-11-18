<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

use TYPO3\CMS\Backend\Utility\BackendUtility;

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
}
