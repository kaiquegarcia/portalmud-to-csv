<?php

namespace Repository;

use Entity\LabTeacher;
use Main\Application;
use Utils\DatabaseConnector;
use Utils\Env;

class LabTeacherRepository extends Repository {
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