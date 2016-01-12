CBER Data Grabber
=================

A set of classes used by the [Ball State University](http://bsu.edu) [Center for Business and Economic Research](http://cberdata.org) [County Profiles](http://profiles.cberdata.org) website for pulling data from US federal data APIs.

ACS Updater (US Census Bureau)
-----------

Example for saving data to multiple CSV files:

    ACSUpdater::setAPIKey('api key goes here');
    $year = '2013';
    $stateID = '18'; //Indiana
    ACSUpdater::updateAllCountyData($year, $stateID);

BEA Updater (Bureau of Economic Analysis)
-----------

Example for saving data to a CSV file:

    BEAUpdater::setAPIKey('api key goes here');
    $year = '2014';
    $stateId = '18'; // Indiana
    BEAUpdater::updateAllCountyData($year, $stateId);
    BEAUpdater::updateCountyData($year, $stateID, BEAUpdater::$WAGES, true);

BLS Updater (Bureau of Labor Statistics)
-----------

Example for saving data to a CSV file:

    $endYear = '2013';
    $stateID = '18'; // Indiana
    BLSUpdater::updateAllCountyData($stateID, $endYear);
