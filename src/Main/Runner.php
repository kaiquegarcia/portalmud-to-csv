<?php

namespace Main;

use Utils\CSV;

abstract class Runner {
    abstract public function run(): void;
    protected CSV | null $csv = null;

    public function __construct(
        protected int $limit,
        protected array $args = [],
    ) {}

    protected function newCSV(string $filename, bool $extractHeaders = true, bool $append = false) {
        $this->csv = new CSV(__DIR__ . "/../../csvs/{$filename}.csv", $extractHeaders, $append);
    }

    public function stop(): void {
        if ($this->csv) {
            $this->csv->close();
        }

        $app = $GLOBALS['application'];
        if ($app->portalConnection) {
            $app->portalConnection->close();
        }
        if ($app->muralConnection) {
            $app->muralConnection->close();
        }
        $this->log('finished');
    }

    protected function log(string $message): void {
        echo $message . PHP_EOL;
    }

    protected function logRoundInit(int $count, int $offset): void {
        $this->log("processing $count row(s), offset $offset");
    }
}