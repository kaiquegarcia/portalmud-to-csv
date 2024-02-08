<?php

namespace Main\Portal;

use Main\Application;
use Main\Runner;

class PostNews extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'portal_portalpost_2',
        );

        $categoryIDs = [];
        $categoryCollection = Application::portalCategoryRepository()->getByURL("fique-ligado");
        if (!empty($categoryCollection)) {
            /** @var \Entity\Category $category */
            foreach($categoryCollection as $category) {
                $categoryIDs[] = $category->ID;
            }
        }

        while (true) {
            $collection = Application::portalPostRepository()->list($categoryIDs, $this->limit, $offset);
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