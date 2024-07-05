<?php

namespace Repository;

use Entity\LabPack;
use Entity\LabTeacher;
use Enums\LabPackType;
use Utils\DatabaseConnector;
use Utils\Env;
use Utils\Globals;

class LabPackRepository extends Repository {
    public function list(int $limit, int $offset)
    {
        return $this->all(
            cacheKey: "",
            condition: "`deleted_at` IS NULL AND `status`=1",
            orderBy: "`ID` ASC",
            limit: $limit,
            offset: $offset,
        );
    }

    public static function getTableName(): string {
        return 'packs';
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

    protected function toEntity(array $data): LabPack {
        return new LabPack(
            ID: $data['ID'],
            teacherID: $data['teacher_id'],
            categoryID: $data['department_id'],
            type: LabPackType::from($data['type']),
            name: $data['name'],
            resume: $data['resume'] ?? '',
            description: $data['description'] ?? '',
            video: $data['video'] ?? '',
            language: $data['language'] ?? '',
            learning: $data['larning'] ?? '',
            requirements: $data['requirements'] ?? '',
            duration: $data['duration'] ?? '',
            thumb: $data['thumb'],
            banner: $data['banner'],
            createdAt: $data['created_at'],
        );
    }
}