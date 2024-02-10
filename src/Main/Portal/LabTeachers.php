<?php

namespace Main\Portal;

use Main\Runner;
use Utils\Globals;

class LabTeachers extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'lab_teachers',
        );

        while (true) {
            $collection = Globals::labTeacherRepository()->list($this->limit, $offset);
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