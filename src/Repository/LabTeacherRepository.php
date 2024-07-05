<?php

namespace Repository;

use Entity\LabTeacher;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class LabTeacherRepository extends Repository {
    public function get(int $ID): LabTeacher | null {
        return $this->first("$ID", "`ID` = $ID AND `status` = 1");
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
        return 'teacher_teacher';
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

    protected function toEntity(array $data): LabTeacher {
        return new LabTeacher(
            ID: $data["ID"],
            status: $data["status"],
            categoryID: $data["categoryID"],
            thumb: $data["thumb"],
            thumb2: $data["thumb2"],
            URL: $data["URL"],
            name: $data["name"],
            fullName: $data["fullname"],
            curriculum: $data["curriculum"],
            email: $data["email"],
            testimonial: $data["testimonial"],
            twitter: $data["twitter"],
            facebook: $data["facebook"],
            googlePlus: $data["google_plus"],
            createdAt: $data["registry_date"],
            updatedAt: $data["status_date"],
        );
    }
}