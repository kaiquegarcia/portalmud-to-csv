<?php

namespace Repository;

use Entity\MuralProfile;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class MuralProfileRepository extends Repository
{
    public function list(int $limit, int $offset)
    {
        return $this->all(
            cacheKey: "",
            condition: "`status`=1 AND `person_authorID`!=0",
            orderBy: "`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public static function getTableName(): string
    {
        return "mural_profile";
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

    protected function toEntity(array $data): MuralProfile
    {
        return new MuralProfile(
            ID: $data["ID"],
            status: $data["status"],
            personAuthorID: $data["person_authorID"],
            categoryID: $data["categoryID"],
            modalityID: $data["modalityID"],
            typeID: $data["typeID"],
            doc: $data["doc"],
            docType: $data["doc_type"],
            URL: $data["URL"],
            thumb: $data["thumb"],
            name: $data["name"],
            nickname: $data["nickname"],
            bio: $data["bio"],
            email: $data["email"],
            website: $data["website"],
            phone: $data["phone"],
            phoneFix: $data["phone_fix"],
            whatsapp: $data["whatsapp"],
            foundationYear: $data["foundation_year"],
            foundationDate: $data["foundation_date"],
            createdAt: $data["registry_date"],
            photoURLs: $data["photoURLs"] ? explode(";", $data["photoURLs"]) : [],
        );
    }
}
