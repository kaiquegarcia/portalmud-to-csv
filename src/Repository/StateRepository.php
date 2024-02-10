<?php

namespace Repository;

use Entity\State;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class StateRepository extends Repository {
    public function get(int $ID): State | null {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'cep_state';
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

    protected function toEntity(array $data): State {
        return new State(
            ID: $data["ID"],
            status: $data["status"],
            UF: $data["UF"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}