<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

class Content implements ShortcutInterface
{
    public function getTableName(): string
    {
        return 'tt_content';
    }
}
