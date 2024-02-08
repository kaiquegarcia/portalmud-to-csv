<?php

namespace Repository;

use Entity\MuralProfileLink;
use Enums\MuralProfileLinkType;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class MuralProfileLinkRepository extends Repository
{
    public function list(int $profileID, int $limit, int $offset)
    {
        return $this->all(
            cacheKey: "",
            condition: "`status`=1 AND `profileID`=$profileID",
            orderBy: "`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public static function getTableName(): string
    {
        return "mural_profilelink";
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

    protected function toEntity(array $data): MuralProfileLink
    {
        return new MuralProfileLink(
            ID: $data["ID"],
            status: $data["status"],
            profileID: $data["profileID"],
            type: MuralProfileLinkType::from($data["type"]),
            URL: $data["URL"],
            link: $data["link"],
        );
    }
}
