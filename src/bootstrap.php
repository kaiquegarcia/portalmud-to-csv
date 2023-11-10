<?php

require_once "autoload.php";

# Initialize application and repositories
$application = new \Main\Application();
$eventRepository = new \Repository\EventRepository($application);
$eventModalityRepository = new \Repository\EventModalityRepository($application);
$categoryRepository = new \Repository\CategoryRepository($application);
$eventHoursRepository = new \Repository\EventHoursRepository($application);
$columnistRepository = new \Repository\ColumnistRepository($application);
$portalCategoryRepository = new \Repository\PortalCategoryRepository($application);
$portalPostRepository = new \Repository\PortalPostRepository($application);

# Register commands
$application->on('export', function() {
    echo 'What do you want to export? Please add the word to the command like the examples bellow:' . PHP_EOL;
    echo '- export events' . PHP_EOL;
    echo '- export columnists' . PHP_EOL;
    echo '- export postnews' . PHP_EOL;
});
$application->on('export_events', new \Main\Portal\Events(100, ["startID" => 0]));
$application->on('export_columnists', new \Main\Portal\Columnists(500));
$application->on('export_postnews', new \Main\Portal\PostNews(100));