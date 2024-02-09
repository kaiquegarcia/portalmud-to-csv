<?php

namespace Main;

use Utils\DatabaseConnector;
use Utils\Env;

class Application
{
    public readonly DatabaseConnector $portalConnection;
    public readonly DatabaseConnector $museuConnection;
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

        if (Env::MUSEU_DB_ENABLED() === "1") {
            $this->museuConnection = new DatabaseConnector(
                Env::MUSEU_DB_HOST(),
                Env::MUSEU_DB_USER(),
                Env::MUSEU_DB_PASS(),
                Env::MUSEU_DB_NAME(),
                Env::MUSEU_DB_PORT(),
            );
        }
    }

    public function on(string $command, Runner | callable $runner) {
        $command = str_replace(' ', '_', $command);
        $this->runners[$command] = $runner;
    }

    public function run(string $command) {
        if ($command === "") {
            $this->help();
            return;
        }

        if (!isset($this->runners[$command])) {
            $this->help('Invalid command! Please run add one of the following words to run a useful command:');
            return;
        }

        $runner = $this->runners[$command];
        if ($runner instanceof Runner) {
            $this->runners[$command]->run();
            $this->runners[$command]->stop();
        } else {
            $runner();
        }

        if (isset($this->portalConnection)) {
            $this->portalConnection->close();
        }

        if (isset($this->museuConnection)) {
            $this->museuConnection->close();
        }
    }

    public function help(
        string $hint = '',
        string $commandPrefix = '',
    ) {
        if ($hint == '') {
            echo 'Please send one of the following arguments to properly run this application:' . PHP_EOL;
        } else {
            echo $hint . PHP_EOL;
        }

        foreach($this->runners as $command => $runner) {
            if (!$runner instanceof Runner) {
                continue;
            }

            if ($commandPrefix != '' && !str_starts_with($command, $commandPrefix)) {
                continue;
            }

            echo '- ' . str_replace('_', ' ', $command) . PHP_EOL;
        }
    }

    public static function __callStatic($name, $arguments)
    {
        if (isset($GLOBALS[$name])) {
            return $GLOBALS[$name];
        }

        return null;
    }
}
