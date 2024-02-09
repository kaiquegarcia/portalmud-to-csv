<?php

namespace Main\Museu;

use Exception;
use InvalidArgumentException;
use Main\Application;
use Main\Runner;

class Posts extends Runner {
    public function run(): void
    {
        $offset = 0;
        $categoryID = $this->args["categoryID"] ?? 0;
        if ($categoryID <= 0) {
            throw new InvalidArgumentException("CategoryID cannot be lower or equal to zero!");
        }

        $category = Application::museuCategoryRepository()->get($categoryID);
        if (!$category) {
            throw new Exception("could not find category on database");
        }

        /** @var \Entity\MuseuCategory $category */
        $this->newCSV(
            filename: 'museu_posts_' . $category->URL,
        );

        while (true) {
            $collection = Application::museuPostRepository()->list($categoryID, $this->limit, $offset);
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