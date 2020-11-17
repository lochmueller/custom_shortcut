<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Shortcut;

interface ShortcutInterface
{
    public function getTableName(): string;
}
