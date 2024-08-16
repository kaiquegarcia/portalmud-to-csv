<?php

namespace Repository;

use Entity\MuseuPost;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class MuseuPostRepository extends Repository
{
    public function list(int $categoryID, int $limit, int $offset)
    {
        if ($categoryID <= 0) {
            throw new \InvalidArgumentException("CategoryID cannot be lower or equal than zero");
        }

        return $this->all(
            cacheKey: "",
            condition: "`status`=1 AND `categoryID` = $categoryID",
            orderBy: "`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public function getListByID(array $IDs)
    {
        $IDs = join(",", $IDs);
        if ($IDs === '') {
            return null;
        }

        return $this->all(
            cacheKey: "",
            condition: "`status`=1 AND `ID` IN ($IDs)",
            orderBy: "`ID` ASC",
            limit: 500,
            offset: 0,
        );
    }

    public static function getTableName(): string
    {
        return "web_post";
    }

    public static function getDatabaseConnector(): DatabaseConnector
    {
        return Globals::app()->museuConnection;
    }

    public static function getDatabaseSchema(): string
    {
        return Env::MUSEU_DB_NAME();
    }

    protected function getQuerySelect(): string
    {
        return "*";
    }

    protected function getJoins(): string
    {
        return "";
    }

    protected function toEntity(array $data): MuseuPost
    {
        return new MuseuPost(
            ID: $data["ID"],
            status: $data["status"],
            categoryID: $data["categoryID"],
            periodID: $data["periodID"],
            cityID: $data["cityID"],
            countryID: $data["countryID"],
            danceStyleID: $data["dancestyleID"],
            colllectionID: $data["collectionID"],
            subcategoryID: $data["layout"],
            order: $data["order"],
            thumb: $data["thumb"],
            thumbLegend: $data["thumb_legend"],
            link: $data["thumb_link"],
            URL: $data["URL"],
            title: $data["title"],
            PDF: $data["subtitle"],
            preview: $data["preview"],
            content1: $data["content1"],
            content2: $data["content2"],
            content3: $data["content3"],
            artist: $data["artist"],
            local: $data["local"],
            ISBN: $data["ISBN"],
            ISSN: $data["ISSN"],
            DOI: $data["DOI"],
            postedAt: $data["post_date"],
            searchURI: $data["searchURI"],
            tags: $data["tags"],
            visibilityStartDate: $data["init_date"],
            visibilityEndDate: $data["end_date"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
            photoURLs: $data["photoURLs"] ? explode(";", $data["photoURLs"]) : [],
        );
    }
}
