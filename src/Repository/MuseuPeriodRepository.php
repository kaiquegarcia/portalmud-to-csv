<?php

namespace Repository;

use Entity\MuseuPeriod;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class MuseuPeriodRepository extends Repository {
    public function get(int $ID): MuseuPeriod | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'web_period';
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

    protected function toEntity(array $data): MuseuPeriod {
        return new MuseuPeriod(
            ID: $data["ID"],
            status: $data["status"],
            URL: $data["URL"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}