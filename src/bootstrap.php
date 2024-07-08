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
$labTeacherRepository = new \Repository\LabTeacherRepository($application);
$museuCategoryRepository = new \Repository\MuseuCategoryRepository($application);
$museuSubcategoryRepository = new \Repository\MuseuSubcategoryRepository($application);
$museuCityRepository = new \Repository\MuseuCityRepository($application);
$museuCountryRepository = new \Repository\MuseuCountryRepository($application);
$museuDanceStyleRepository = new \Repository\MuseuDanceStyleRepository($application);
$museuPeriodRepository = new \Repository\MuseuPeriodRepository($application);
$museuPostRepository = new \Repository\MuseuPostRepository($application);
$labPackRepository = new \Repository\LabPackRepository($application);
$museuCollectionRepository = new \Repository\MuseuCollectionRepository($application);

# Register commands
$application->on('export', function() use ($application) {
    $application->help('What do you want to export? Please add the word to the command like the examples bellow:', 'export');
});

$application->on('export events', new \Main\Portal\Events(100, ["startID" => 2444]));
$application->on('export columnists', new \Main\Portal\Columnists(500));
$application->on('export postnews', new \Main\Portal\PostNews(100, ["startID" => 0]));
$application->on('export mural-profiles', new \Main\Portal\MuralProfiles(100));
$application->on('export lab-teachers', new \Main\Portal\LabTeachers(100));
$application->on('export acervo-clipping', new \Main\Museu\Posts(100, ["categoryID" => 19]));
$application->on('export acervo-documents', new \Main\Museu\Posts(100, ["categoryID" => 21]));
$application->on('export acervo-photographies', new \Main\Museu\Posts(100, ["categoryID" => 22]));
$application->on('export acervo-graphic-materials', new \Main\Museu\Posts(100, ["categoryID" => 23]));
$application->on('export acervo-videos', new \Main\Museu\Posts(100, ["categoryID" => 24]));
$application->on('export lab-packs', new \Main\Portal\LabPacks(100));