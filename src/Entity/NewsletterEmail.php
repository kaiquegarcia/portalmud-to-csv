<?php

namespace Entity;

class NewsletterEmail implements Entity {
    public function __construct(
        public readonly int $ID,
        public readonly int $status,
        public readonly string $value,
        public readonly string $createdAt,
    ) {}

    public function toCSVArray(): array
    {
        return [
            'ID DO POST' => $this->ID,
            'E-MAIL' => $this->value,
            'DATA' => $this->createdAt,
        ];
    }
}