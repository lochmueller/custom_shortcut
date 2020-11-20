<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Domain\Model\Dto;

class TableRecordConfiguration
{
    protected $tableName = '';
    protected $id = 0;

    public function __construct(string $tableName, int $id)
    {
        $this->tableName = $tableName;
        $this->id = $id;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
