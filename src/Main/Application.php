<?php

namespace Main;

use Utils\DatabaseConnector;
use Utils\Env;

class Application
{
    public readonly DatabaseConnector $portalConnection;
    public readonly DatabaseConnector $muralConnection;
    private array $runners = [];

    public function __construct()
    {
        Env::load();
        $this->portalConnection = new DatabaseConnector(
            Env::PORTAL_DB_HOST(),
            Env::PORTAL_DB_USER(),
            Env::PORTAL_DB_PASS(),
            Env::PORTAL_DB_NAME(),
            Env::PORTAL_DB_PORT(),
        );

        $this->muralConnection = new DatabaseConnector(
            Env::MURAL_DB_HOST(),
            Env::MURAL_DB_USER(),
            Env::MURAL_DB_PASS(),
            Env::MURAL_DB_NAME(),
            Env::MURAL_DB_PORT(),
        );
    }

    public function on(string $command, Runner $runner) {
        $this->runners[$command] = $runner;
    }

    public function run(string $command) {
        if ($command === "") {
            echo 'Please run add one of the following words to run a useful command:' . PHP_EOL;
            foreach($this->runners as $cmd => $runner) {
                echo "- $cmd" . PHP_EOL;
            }
            return;
        }

        if (!isset($this->runners[$command])) {
            throw new \InvalidArgumentException("Command not found");
        }

        $this->runners[$command]->run();
        $this->runners[$command]->stop();
    }
}
