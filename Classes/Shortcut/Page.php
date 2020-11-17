<?php
/**
 *
 */

namespace HDNET\CustomShortcut\Shortcut;

class Page implements ShortcutInterface
{

    public function getTableName(): string
    {
        return 'pages';
    }
}
