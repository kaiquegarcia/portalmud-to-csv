<?php

namespace Main\Portal;

use Main\Runner;
use Utils\Globals;

class Events extends Runner {
    public function run(): void {
        $startID = $this->args["startID"] ?? 0;
        $offset = 0;

        $this->newCSV(
            filename: 'mural_event_v4',
        );

        while (true) {
            $collection = Globals::eventRepository()->list($startID, $offset, $this->limit);
            if (empty($collection)) {
                break;
            }

            $this->logRoundInit(count($collection), $offset);
            foreach($collection as $entity) {
                $this->csv->append($entity->toCSVArray());
            }

            $offset += $this->limit;
        }
    }
}