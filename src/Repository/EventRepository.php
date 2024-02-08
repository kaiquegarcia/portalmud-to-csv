<?php

namespace Repository;

use Entity\Event;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class EventRepository extends Repository {
    public function list(int $startID, int $offset, int $limit) {
        return $this->all(
            cacheKey: "",
            condition: "`{$this::getTableName()}`.`status`=1 AND `{$this::getTableName()}`.`ID` > $startID",
            orderBy: "`{$this::getTableName()}`.`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public static function getTableName(): string {
        return 'mural_event';
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
        return "
        `{$this::getTableName()}`.ID,
        `{$this::getTableName()}`.`categoryID`,
        `{$this::getTableName()}`.thumb,
        `{$this::getTableName()}`.URL,
        `eventtype`.`name` AS `type`,
        `{$this::getTableName()}`.title,
        `{$this::getTableName()}`.content,
        `{$this::getTableName()}`.period_init,
        `{$this::getTableName()}`.period_end,
        `{$this::getTableName()}`.photoURLs,
        `{$this::getTableName()}`.price,
        `{$this::getTableName()}`.max_price,
        `{$this::getTableName()}`.website,
        `{$this::getTableName()}`.age,
        (CASE
            WHEN `{$this::getTableName()}`.`localID` > 0 THEN `local`.`accessibility`
            ELSE `address`.`accessibility`
        END) AS accessibility,
        `{$this::getTableName()}`.phone,
        `{$this::getTableName()}`.email,
        (CASE WHEN `owner`.nickname IS NULL THEN `{$this::getTableName()}`.profile_name ELSE `owner`.nickname END) AS author,
        `state`.`UF` AS `state_UF`,
        `city`.`name` AS `city_name`,
        `district`.`name` AS `district_name`,
        (CASE WHEN `{$this::getTableName()}`.`localID` > 0 THEN `local_address`.`street` ELSE `address`.`street` END) AS `street`,
        (CASE WHEN `{$this::getTableName()}`.`localID` > 0 THEN `local_address`.`number` ELSE `address`.`number` END) AS `number`,
        (CASE WHEN `{$this::getTableName()}`.`localID` > 0 THEN `local`.`nickname` ELSE `address`.`name` END) AS `local`,
        (CASE WHEN `{$this::getTableName()}`.`localID` > 0 THEN `local`.`capacity` ELSE `address`.`capacity` END) AS `capacity`";
    }

    protected function getJoins(): string
    {
        $schema = Env::PORTAL_DB_NAME();
        return "LEFT JOIN `$schema`.`mural_profile` AS `owner` ON `{$this::getTableName()}`.profileID = `owner`.ID
        LEFT JOIN `$schema`.`mural_eventtype` AS `eventtype` ON `{$this::getTableName()}`.`typeID` = `eventtype`.`ID`
        LEFT JOIN `$schema`.`mural_eventaddress` AS `address` ON `{$this::getTableName()}`.ID=`address`.eventID
        LEFT JOIN `$schema`.`mural_profile` AS `local` ON `{$this::getTableName()}`.`localID`=`local`.`ID`
        LEFT JOIN `$schema`.`mural_profileaddress` AS `local_address` ON `local`.`ID`=`local_address`.`profileID`
        LEFT JOIN `$schema`.`cep_state` AS `state` ON (`local_address`.`stateID`=`state`.`ID` OR `address`.`stateID`=`state`.`ID`)
        LEFT JOIN `$schema`.`cep_city` AS `city` ON (`local_address`.`cityID`=`city`.`ID` OR `address`.`cityID`=`city`.`ID`)
        LEFT JOIN `$schema`.`cep_district` AS `district` ON (`local_address`.`districtID`=`district`.`ID` OR `address`.`districtID`=`district`.`ID`)";
    }

    protected function toEntity(array $data): Event {
        return new Event(
            ID: $data["ID"],
            categoryID: $data["categoryID"],
            thumb: $data["thumb"],
            URL: $data["URL"],
            typeName: $data["type"],
            title: $data["title"],
            content: $data["content"],
            periodInit: $data["period_init"],
            periodEnd: $data["period_end"],
            photoURLs: $data["photoURLs"] ? explode(";", $data["photoURLs"]) : [],
            price: $data["price"],
            maxPrice: $data["max_price"],
            website: $data["website"],
            ageGroup: $data["age"],
            hasAccessibility: $data["accessibility"] == 1,
            phone: $data["phone"],
            email: $data["email"],
            authorName: $data["author"],
            stateUF: $data["state_UF"],
            cityName: $data["city_name"],
            districtName: $data["district_name"],
            addressStreet: $data["street"],
            addressNumber: $data["number"],
            addressName: $data["local"],
            capacity: $data["capacity"] ?? 0,
        );
    }
}