<?php

require_once './src/bootstrap.php';

$cmd = $argv[1] ?? "";
$application->run($cmd);