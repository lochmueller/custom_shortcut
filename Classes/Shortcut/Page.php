<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Page implements ShortcutInterface
{
    public function getTableName(): string
    {
        return 'pages';
    }

    public function resolvePageId(int $recordId): int
    {
        return $recordId;
    }

    public function resolveUrl(string $target, ContentObjectRenderer $contentObjectRenderer): string
    {
        $id = (int) str_replace($this->getTableName().'_', '', $target);

        return $contentObjectRenderer->getTypoLink_URL($id);
    }
}
