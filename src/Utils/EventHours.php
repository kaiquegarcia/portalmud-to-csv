<?php

namespace Utils;

class EventHours {
    public function __construct(
        public array $days = [],
        public array $startTimes = [],
        public array $endTimes = [],
    ) {}
}