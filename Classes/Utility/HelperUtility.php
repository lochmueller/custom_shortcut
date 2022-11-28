<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Utility;

use HDNET\CustomShortcut\Domain\Model\Dto\TableRecordConfiguration;
use HDNET\CustomShortcut\Shortcut\ShortcutInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

class HelperUtility
{
    public static function getTableRecordConfiguration(string $fieldValue): ?TableRecordConfiguration
    {
        $parts = GeneralUtility::revExplode('_', trim($fieldValue), 2);
        if (2 !== \count($parts) || !MathUtility::canBeInterpretedAsInteger($parts[1])) {
            return null;
        }

        return new TableRecordConfiguration((string) $parts[0], (int) $parts[1]);
    }

    public static function getShortcutHandler(TableRecordConfiguration $config): ?ShortcutInterface
    {
        $items = (array) $GLOBALS['TYPO3_CONF_VARS']['EXT']['custom_shortcut']['shortcut'];
        foreach ($items as $className) {
            $integration = GeneralUtility::makeInstance($className);

            /** @var ShortcutInterface $integration */
            if ($config->getTableName() === $integration->getTableName()) {
                return $integration;
            }
        }

        return null;
    }
}
