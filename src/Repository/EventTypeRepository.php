<?php

namespace Repository;

use Entity\EventType;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class EventTypeRepository extends Repository {
    public function get(int $ID) {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public static function getTableName(): string {
        return 'mural_eventtype';
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

    protected function toEntity(array $data): EventType {
        return new EventType(
            ID: $data["ID"],
            status: $data["status"],
            thumb: $data["thumb"],
            URL: $data["URL"],
            name: $data["name"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}