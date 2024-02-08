<?php

namespace Entity;

class MuralProfileCategory implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $topID,
        public string $thumb,
        public string $URL,
        public string $name,
        public string $searchURI,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public function toCSVArray(): array {
        return [];
    }
}