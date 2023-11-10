<?php

namespace Repository;

use Entity\Category;
use Utils\DatabaseConnector;
use Utils\Env;

class CategoryRepository extends Repository {
    public function get(int $ID): Category | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'basic_category';
    }

    public static function getDatabaseConnector(): DatabaseConnector
    {
        return $GLOBALS["application"]->portalConnection;
    }

    public static function getDatabaseSchema(): string
    {
        return Env::PORTAL_DB_NAME();
    }

    protected function getQuerySelect(): string
    {
        return "*";
    }

    protected function getJoins(): string
    {
        return "";
    }

    protected function toEntity(array $data): Category {
        return new Category(
            ID: $data["ID"],
            status: $data["status"],
            topID: $data["topID"],
            thumb: $data["thumb"],
            URL: $data["URL"],
            name: $data["name"],
            searchURI: $data["searchURI"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}