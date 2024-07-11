<?php

namespace Repository;

use Collection\EntityCollection;
use Entity\MuseuCollection;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class MuseuCollectionRepository extends Repository
{
    public function getByPostID(int $postID): MuseuCollection | null {
        $collection = $this->first("post_$postID", "(`content1` LIKE '$postID,%' OR `content1` LIKE '%,$postID' OR `content1` LIKE '%,$postID,%' OR `content1` = '$postID') AND `status` != 2");
        if ($collection == null) {
            return $collection;
        }

        $data = new EntityCollection([$collection]);
        $postIDs = explode(',', $collection->postIDs);
        foreach($postIDs as $ID) {
            $this->cache["post_$ID"] = $data;
        }

        return $collection;
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

    public static function getTableName(): string {
        return 'web_collection';
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

    protected function toEntity(array $data): MuseuCollection {
        return new MuseuCollection(
            ID: $data['ID'],
            status: $data['status'],
            categoryID: $data['categoryID'],
            countryID: $data['countryID'],
            cityID: $data['cityID'],
            postIDs: $data['content1'],
            thumb: $data['thumb'],
            foundationYear: $data['thumb_legend'],
            endingYear: $data['thumb_link'],
            birthYear: $data['content2'],
            deathYear: $data['content3'],
            URL: $data['URL'],
            title: $data['title'],
            techinicalSpecification: $data['subtitle'],
            preview: $data['preview'],
            email: $data['layout'],
            phone: $data['artist'],
            instagram: $data['instagram'],
            facebook: $data['facebook'],
            youtube: $data['youtube'],
            twitter: $data['twitter'],
            site: $data['site'],
        );
    }
}