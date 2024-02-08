<?php

namespace Repository;

use Entity\EventHours;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class EventHoursRepository extends Repository {
    public function getByEventID(int $eventID) {
        return $this->all(
            cacheKey: "",
            condition: "`eventID` = $eventID AND `status` != 2",
            orderBy: '`day_of_week` ASC, `init` ASC',
        );
    }

    public static function getTableName(): string {
        return 'mural_eventtime';
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
        return "`day_of_week`, `init`, `end`";
    }

    protected function getJoins(): string
    {
        return "";
    }

    protected function toEntity(array $data): EventHours {
        return new EventHours(
            dayOfWeek: $data['day_of_week'],
            init: $data['init'],
            end: $data['end'],
        );
    }

}