<?php

namespace Repository;

use Entity\PortalPost;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class PortalPostRepository extends Repository
{
    public function list(int $startID, array $categoryIDs, int $limit, int $offset)
    {
        if (empty($categoryIDs)) {
            throw new \InvalidArgumentException("CategoryIDs cannot be empty");
        }

        return $this->all(
            cacheKey: "",
            condition: "`status`=1 AND `ID` >= $startID AND `categoryID` IN (" . join(", ", $categoryIDs) . ")",
            orderBy: "`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public static function getTableName(): string
    {
        return "portal_portalpost";
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

    protected function toEntity(array $data): PortalPost
    {
        return new PortalPost(
            ID: $data["ID"],
            status: $data["status"],
            categoryID: $data["categoryID"],
            columnistID: $data["columnistID"],
            URL: $data["URL"],
            thumb: $data["thumb"],
            thumbCredit: $data["credit_thumb"] ?? "",
            title: $data["title"],
            content: $data["content"],
            preview: $data["preview"],
            postDate: $data["post_date"],
            photoURLs: $data["photoURLs"] ? explode(";", $data["photoURLs"]) : [],
        );
    }
}
