<?php

namespace Entity;

class MuralProfileAddress implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $profileID,
        public int $stateID,
        public int $cityID,
        public int $districtID,
        public string $zipcode,
        public string $street,
        public string $number,
        public string $complement,
        public string $reference,
        public string $latitude,
        public string $longitude,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public function toCSVArray(): array {
        return [];
    }
}