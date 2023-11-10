<?php

namespace Main\Portal;

use Main\Runner;

class Columnists extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'portal_columnist_2',
        );

        while (true) {
            $collection = $GLOBALS['columnistRepository']->list($this->limit, $offset);
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