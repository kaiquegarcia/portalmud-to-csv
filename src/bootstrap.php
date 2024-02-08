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
$stateRepository = new \Repository\StateRepository($application);
$cityRepository = new \Repository\CityRepository($application);
$muralProfileLinkRepository = new \Repository\MuralProfileLinkRepository($application);
$muralProfileAddressRepository = new \Repository\MuralProfileAddressRepository($application);
$muralProfileCategoryRepository = new \Repository\MuralProfileCategoryRepository($application);
$muralProfileRepository = new \Repository\MuralProfileRepository($application);

# Register commands
$application->on('export', function() {
    echo 'What do you want to export? Please add the word to the command like the examples bellow:' . PHP_EOL;
    echo '- export events' . PHP_EOL;
    echo '- export columnists' . PHP_EOL;
    echo '- export postnews' . PHP_EOL;
    echo '- export mural-profiles' . PHP_EOL;
});
$application->on('export_events', new \Main\Portal\Events(100, ["startID" => 0]));
$application->on('export_columnists', new \Main\Portal\Columnists(500));
$application->on('export_postnews', new \Main\Portal\PostNews(100));
$application->on('export_mural-profiles', new \Main\Portal\MuralProfiles(100));