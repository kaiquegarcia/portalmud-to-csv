<?php

namespace Entity;

class City implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $stateID,
        public string $URL,
        public string $name,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public function toCSVArray(): array {
        return [];
    }
}