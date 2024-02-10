<?php

namespace Repository;

use Entity\MuralProfileAddress;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class MuralProfileAddressRepository extends Repository {
    public function get(int $profileID): MuralProfileAddress | null {
        return $this->first("", "`profileID` = $profileID AND `status` = 1");
    }

    public static function getTableName(): string {
        return 'mural_profileaddress';
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

    protected function toEntity(array $data): MuralProfileAddress {
        return new MuralProfileAddress(
            ID: $data["ID"],
            status: $data["status"],
            profileID: $data["profileID"],
            stateID: $data["stateID"],
            cityID: $data["cityID"],
            districtID: $data["districtID"],
            zipcode: $data["zipcode"],
            street: $data["street"],
            number: $data["number"],
            complement: $data["complement"],
            reference: $data["reference"],
            latitude: $data["latitude"],
            longitude: $data["longitude"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}