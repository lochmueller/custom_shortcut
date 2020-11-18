<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Upgrade;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class ShortcutUpgrade implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return self::class;
    }

    public function getTitle(): string
    {
        return 'Shortcut upgrade';
    }

    public function getDescription(): string
    {
        return 'Change the db value of the shortcut field. E.g. from "189" to "pages_189" to support multiple types.';
    }

    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('pages');
        foreach ($this->getMigrationRecords() as $page) {
            $value = [
                'shortcut' => ((int) $page['shortcut']) ? 'pages_'.$page['shortcut'] : '',
            ];
            if ((int) $connection->update('pages', $value, ['uid' => $page['uid']]) <= 0) {
                return false;
            }
        }

        return true;
    }

    public function updateNecessary(): bool
    {
        return !empty($this->getMigrationRecords());
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    protected function getMigrationRecords(): iterable
    {
        /** @todo Finish migration */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $where = [
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->neq('shortcut', $queryBuilder->quote('')),
                $queryBuilder->expr()->eq('shortcut', 0)
            ),
        ];
        $query = $queryBuilder->select('uid', 'shortcut')
            ->from('pages')
            ->where(...$where)
            ->execute()
        ;

        while ($page = $query->fetch()) {
            if (MathUtility::canBeInterpretedAsInteger($page['shortcut'])) {
                yield $page;
            }
        }
    }
}
