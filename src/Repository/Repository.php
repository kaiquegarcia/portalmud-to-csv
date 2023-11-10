<?php

namespace Repository;

use Collection\EntityCollection;
use Entity\Entity;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

abstract class Repository
{
    protected array $cache = [];
    abstract public static function getTableName(): string;
    abstract public static function getDatabaseConnector(): DatabaseConnector;
    abstract public static function getDatabaseSchema(): string;
    abstract protected function getQuerySelect(): string;
    abstract protected function getJoins(): string | array;
    abstract protected function toEntity(array $entityData): Entity;

    public function __construct(
        protected Application $app,
    ) { }

    protected function all(
        string $cacheKey,
        string $condition = "",
        string $orderBy = "",
        int $limit = 100,
        int $offset = 0,
    ): EntityCollection | null {
        if ($cacheKey != "" && isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $joins = $this->getJoins();
        $joinStatement = "";
        if (is_array($joins) && !empty($joins)) {
            $joinStatement = join("\n", $joins);
        } elseif (is_string($joins) && $joins !== "") {
            $joinStatement = $joins;
        }

        $whereStatement = $condition != "" ? "WHERE $condition" : "";
        $orderByStatement = $orderBy != "" ? "ORDER BY $orderBy" : "";
        $limitStatement = $limit > 0 ? "LIMIT $offset, $limit" : "";

        $contents = $this::getDatabaseConnector()->query(
            "SELECT {$this->getQuerySelect()}
            FROM `{$this::getDatabaseSchema()}`.`{$this::getTableName()}`
            $joinStatement
            $whereStatement
            $orderByStatement
            $limitStatement"
        );
        if (!$contents?->num_rows) {
            $contents->close();
            return null;
        }

        $collection = new EntityCollection();
        foreach ($contents as $row) {
            $entityData = [];
            foreach ($row as $key => $value) {
                $entityData[$key] = $value;
            }

            $collection[] = $this->toEntity($entityData);
        }

        $contents->close();

        if ($cacheKey != "") {
            $this->cache[$cacheKey] = $collection;
        }
        return $collection;
    }

    protected function first(
        string $cacheKey,
        string $condition = "",
    ): Entity | null
    {
        $result = $this->all(
            $cacheKey,
            $condition,
            1,
        );
        if ($result !== null && count($result)) {
            return $result[0];
        }

        return null;
    }
}
