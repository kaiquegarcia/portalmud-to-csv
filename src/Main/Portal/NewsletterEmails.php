<?php

namespace Main\Portal;

use Main\Runner;
use Utils\Globals;

class NewsletterEmails extends Runner {
    public function run(): void
    {
        $offset = 0;

        $this->newCSV(
            filename: 'newsletter_emails_v1',
        );

        while (true) {
            $collection = Globals::newsletterEmailRepository()->list($this->limit, $offset);
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