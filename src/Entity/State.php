<?php

namespace Entity;

class State implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public string $UF,
        public string $name,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public function toCSVArray(): array {
        return [];
    }
}