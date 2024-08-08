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
            filename: 'portal_portalpost_v5',
        );

        $categoryIDs = [];
        $categoryCollection = Globals::portalCategoryRepository()->getByURLs(
            "fique-ligado",
            "museu-da-danca",
            "mural-da-danca",
            "calendario-da-danca",
            "laboratorio-da-danca",
        );
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