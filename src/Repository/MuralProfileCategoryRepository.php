<?php

namespace Repository;

use Entity\MuralProfileCategory;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class MuralProfileCategoryRepository extends Repository {
    public function get(int $ID): MuralProfileCategory | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'mural_profilecategory';
    }

    public static function getDatabaseConnector(): DatabaseConnector
    {
        return Application::application()->portalConnection;
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

    protected function toEntity(array $data): MuralProfileCategory {
        return new MuralProfileCategory(
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