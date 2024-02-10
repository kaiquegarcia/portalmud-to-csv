<?php

namespace Repository;

use Entity\City;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class CityRepository extends Repository {
    public function get(int $ID): City | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'cep_city';
    }

    public static function getDatabaseConnector(): DatabaseConnector
    {
        return Globals::app()->portalConnection;
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

    protected function toEntity(array $data): City {
        return new City(
            ID: $data["ID"],
            status: $data["status"],
            stateID: $data["stateID"],
            URL: $data["URL"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}