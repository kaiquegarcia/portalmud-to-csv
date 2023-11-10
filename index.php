<?php

require_once './src/bootstrap.php';

$cmd = count($argv) > 1 ? join("_", array_slice($argv, 1)) : "";
$application->run($cmd);