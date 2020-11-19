<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

interface ShortcutInterface
{
    public function getTableName(): string;

    public function resolvePageId(int $recordId): int;

    public function resolveUrl(string $target, ContentObjectRenderer $contentObjectRenderer): string;
}
