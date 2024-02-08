<?php

namespace Main\Portal;

use Main\Application;
use Main\Runner;

class MuralProfiles extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'mural_profiles',
        );

        while (true) {
            $collection = Application::muralProfileRepository()->list($this->limit, $offset);
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