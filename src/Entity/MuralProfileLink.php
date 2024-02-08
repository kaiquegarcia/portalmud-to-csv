<?php

namespace Entity;

use Enums\MuralProfileLinkType;

use function Enums\GetMuralProfileLinkTypeBaseURL;

class MuralProfileLink implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $profileID,
        public MuralProfileLinkType $type,
        public string $URL,
        public string $link,
    ) {}

    public function fullURL(): string {
        $baseURL = GetMuralProfileLinkTypeBaseURL($this->type);
        return $baseURL.$this->link;
    }

    public function toCSVArray(): array {
        return [];
    }
}