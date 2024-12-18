<?php

namespace Repository;

use Entity\NewsletterEmail;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class NewsletterEmailRepository extends Repository {
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
        return 'newsletter_emails';
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

    protected function toEntity(array $data): NewsletterEmail {
        return new NewsletterEmail(
            ID: $data["ID"],
            status: $data["status"],
            value: $data["value"],
            createdAt: $data["registry_date"],
        );
    }
}