<?php

namespace Repository;

use Entity\MuseuSubcategory;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class MuseuSubcategoryRepository extends Repository {
    public function get(int $ID): MuseuSubcategory | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'web_subcategory';
    }

    public static function getDatabaseConnector(): DatabaseConnector
    {
        return Application::application()->museuConnection;
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

    protected function toEntity(array $data): MuseuSubcategory {
        return new MuseuSubcategory(
            ID: $data["ID"],
            status: $data["status"],
            URL: $data["URL"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}