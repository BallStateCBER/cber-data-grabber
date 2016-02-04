CBER Data Grabber
=================

A set of classes used by the [Ball State University](http://bsu.edu) [Center for Business and Economic Research](http://cberdata.org) [County Profiles](http://profiles.cberdata.org) website for pulling data from US federal data APIs.

ACS Updater (US Census Bureau)
------------------------------

Getting processed data and saving it to a CSV file:

    ACSUpdater::setAPIKey('api key goes here');
    $year = '2013';
    $stateId = '18'; // Indiana
    $processedData = ACSUpdater::getCountyData($year, $stateId, ACSUpdater::$POPULATION_AGE);
    $fileName = date('Y-m-d').'_processed_county_'.$categoryName.'_'.$stateId.'_'.$year.'-00-00.csv';
    ACSUpdater::writeProcessedCSV($processedData, $fileName);

Getting raw data and saving it to a CSV file:

    ACSUpdater::setAPIKey('api key goes here');
    $year = '2013';
    $stateId = '18'; // Indiana
    $rawData = ACSUpdater::getRawCountyData($year, $stateId, ACSUpdater::$POPULATION_AGE);
    $fileName = date('Y-m-d').'_raw_county_'.$categoryName.'_data_'.$stateId.'_'.$year.'-00-00.csv';
    ACSUpdater::writeRawCSV($rawData, $fileName, $map);

CSV files are saved in the same directory that executes this script.

BEA Updater (Bureau of Economic Analysis)
-----------------------------------------

Example for saving data to a CSV file:

    BEAUpdater::setAPIKey('api key goes here');
    $year = '2014';
    $stateId = '18'; // Indiana
    BEAUpdater::updateAllCountyData($year, $stateId);
    BEAUpdater::updateCountyData($year, $stateID, BEAUpdater::$WAGES, true);

BLS Updater (Bureau of Labor Statistics)
----------------------------------------

Example for saving data to a CSV file:

    $endYear = '2013';
    $stateID = '18'; // Indiana
    BLSUpdater::updateAllCountyData($stateID, $endYear);
