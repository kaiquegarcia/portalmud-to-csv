<?php

namespace Main\Museu;

use Exception;
use InvalidArgumentException;
use Main\Runner;
use Utils\Globals;

class Posts extends Runner {
    public function run(): void
    {
        $offset = 0;
        $categoryID = $this->args["categoryID"] ?? 0;
        if ($categoryID <= 0) {
            throw new InvalidArgumentException("CategoryID cannot be lower or equal to zero!");
        }

        $category = Globals::museuCategoryRepository()->get($categoryID);
        if (!$category) {
            throw new Exception("could not find category on database");
        }

        /** @var \Entity\MuseuCategory $category */
        $this->newCSV(
            filename: 'museu_posts_v2_' . $category->URL,
        );

        while (true) {
            $collection = Globals::museuPostRepository()->list($categoryID, $this->limit, $offset);
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