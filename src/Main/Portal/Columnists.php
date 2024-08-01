<?php

namespace Main\Portal;

use Main\Runner;
use Utils\Globals;

class Columnists extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'portal_columnist_v3',
        );

        while (true) {
            $collection = Globals::columnistRepository()->list($this->limit, $offset);
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