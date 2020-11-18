<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

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
}
