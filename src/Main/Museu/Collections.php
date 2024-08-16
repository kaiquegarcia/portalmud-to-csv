<?php

namespace Main\Museu;

use Main\Runner;
use Utils\Globals;

class Collections extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'museu_collections_v2',
        );

        while (true) {
            $collection = Globals::museuCollectionRepository()->list($this->limit, $offset);
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