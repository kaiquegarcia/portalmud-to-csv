<?php

namespace Entity;

class EventHours implements Entity {
    public function __construct(
        public int $dayOfWeek,
        public string $init,
        public string $end,
    ) { }

    public function toCSVArray(): array {
        return [];
    }
}