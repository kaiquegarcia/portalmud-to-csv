<?php

namespace Repository;

use Collection\EntityCollection;
use Entity\Category;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class PortalCategoryRepository extends Repository {
    public function get(int $ID) {
        if ($ID <= 0) {
            return null;
        }

        return $this->first("$ID", "`ID` = $ID AND `status` != 2");
    }

    public function getByURLs(string ...$URLs) {
        $urlQuery = join("', '", $URLs);
        $result = $this->all("", "`URL` IN ('$urlQuery') AND `status` != 2");
        /** @var \Entity\Category $category */
        foreach($result as $category) {
            $this->cache["{$category->ID}"] = new EntityCollection([$category]);
            // cache parent
            $this->get($category->topID);
        }
        
        return $result;
    }

    public static function getTableName(): string {
        return 'portal_portalcategory';
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

    protected function toEntity(array $data): Category {
        return new Category(
            ID: $data["ID"],
            status: $data["status"],
            topID: $data["topID"],
            thumb: $data["thumb"] ?? "",
            URL: $data["URL"],
            name: $data["name"],
            searchURI: $data["searchURI"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}