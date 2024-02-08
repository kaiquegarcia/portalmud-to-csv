<?php

namespace Repository;

use Entity\Columnist;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class ColumnistRepository extends Repository
{
    public function get(int $ID)
    {
        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public function list(int $limit, int $offset)
    {
        return $this->all(
            cacheKey: "",
            condition: "`status`=1",
            orderBy: "`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public static function getTableName(): string
    {
        return "portal_columnist";
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

    protected function toEntity(array $data): Columnist
    {
        return new Columnist(
            ID: $data["ID"],
            status: $data["status"],
            thumb: $data["thumb"],
            CPF: $data["CPF"],
            login: $data["login"],
            encryptedPassword: $data["password"],
            name: $data["name"],
            email: $data["email"],
            phone: $data["phone"],
            bioShort: $data["bio_short"],
            bio: $data["bio"],
            URL: $data["URL"],
            isPartner: $data["is_partner"],
            facebookID: $data["facebookID"],
            accessToken: $data["access_token"],
            recoveryToken: $data["recovery_token"],
            menuState: $data["menu_state"],
            menuTip: $data["menu_tip"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}
