<?php

namespace Repository;

use Entity\MuseuCountry;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class MuseuCountryRepository extends Repository {
    public function get(int $ID): MuseuCountry | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'web_country';
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

    protected function toEntity(array $data): MuseuCountry {
        return new MuseuCountry(
            ID: $data["ID"],
            status: $data["status"],
            URL: $data["URL"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}