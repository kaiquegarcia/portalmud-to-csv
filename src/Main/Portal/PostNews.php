<?php

namespace Main\Portal;

use Main\Runner;
use Utils\Globals;

class PostNews extends Runner {
    public function run(): void
    {
        $startID = $this->args["startID"] ?? 0;
        $offset = 0;

        $this->newCSV(
            filename: 'portal_portalpost_2',
        );

        $categoryIDs = [];
        $categoryCollection = Globals::portalCategoryRepository()->getByURL("fique-ligado");
        if (!empty($categoryCollection)) {
            /** @var \Entity\Category $category */
            foreach($categoryCollection as $category) {
                $categoryIDs[] = $category->ID;
            }
        }

        while (true) {
            $collection = Globals::portalPostRepository()->list($startID, $categoryIDs, $this->limit, $offset);
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