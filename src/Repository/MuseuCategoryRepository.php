<?php

namespace Repository;

use Entity\MuseuCategory;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class MuseuCategoryRepository extends Repository {
    public function get(int $ID): MuseuCategory | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'web_category';
    }

    public static function getDatabaseConnector(): DatabaseConnector
    {
        return Globals::app()->museuConnection;
    }

    public static function getDatabaseSchema(): string
    {
        return Env::MUSEU_DB_NAME();
    }

    protected function getQuerySelect(): string
    {
        return "*";
    }

    protected function getJoins(): string
    {
        return "";
    }

    protected function toEntity(array $data): MuseuCategory {
        return new MuseuCategory(
            ID: $data["ID"],
            status: $data["status"],
            URL: $data["URL"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}