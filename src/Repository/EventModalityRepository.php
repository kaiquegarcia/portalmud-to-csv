<?php

namespace Repository;

use Entity\EventModality;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class EventModalityRepository extends Repository {
    public function getByEventID(int $eventID) {
        return $this->all("", "`{$this::getTableName()}`.`eventID` = $eventID AND `{$this::getTableName()}`.`status` != 2");
    }

    public static function getTableName(): string {
        return 'mural_eventmodality';
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
        return "`cat`.*";
    }

    protected function getJoins(): string
    {
        $db = CategoryRepository::getTableName();
        $schema = Env::PORTAL_DB_NAME();
        return "INNER JOIN `$schema`.`$db` AS `cat` ON `{$this::getTableName()}`.`categoryID`=`cat`.`ID`";
    }

    protected function toEntity(array $data): EventModality {
        return new EventModality(
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