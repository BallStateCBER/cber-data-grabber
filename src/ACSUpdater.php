<?php
namespace CBERDataGrabber;

include 'ACSDataGrabber.php';
include 'ACSTableMaps.php';

/**
 * A class that controls the collection of data from the American Community Survey
 * for the purpose of keeping CBER's County Profile Pages up to date.
 *
 * All Data collected can be saved to a CSV for later processing and integration into the live Database.
 *
 * @author Brandon Patterson
 * @version 0.3
 */
class ACSUpdater
{

    private static $grabber;
    private static $APIKEY = '';
    public static $POPULATION_AGE = "population_age";
    public static $HOUSEHOLD_INCOME = "household_income";
    public static $ETHNIC_MAKEUP = "ethnic_makeup";
    public static $EDUCATIONAL_ATTAINMENT = "educational_attainment";
    public static $INEQUALITY_INDEX = "gini_index";

    /**
     * @return boolean
     */
    public static function hasAPIKey()
    {
        return static::$APIKEY != '';
    }

    /**
     * Must be called before data can be pulled.
     *
     * @param string $key
     */
    public static function setAPIKey($key)
    {
        static::$APIKEY = $key;
        static::$grabber = new ACSCountyDataGrabber($key);
    }


    /**
     * Calls for the update of all County Profile Data from the ACS,
     * for a given year and stateID (FIPS State Code).
     *
     * @param string $year
     * @param string $stateID
     */
    public static function updateAllCountyData($year, $stateID)
    {
        $ignore = static::updateCountyData($year, $stateID, static::$POPULATION_AGE);
        $ignore = static::updateCountyData($year, $stateID, static::$HOUSEHOLD_INCOME);
        $ignore = static::updateCountyData($year, $stateID, static::$ETHNIC_MAKEUP);
        $ignore = static::updateCountyData($year, $stateID, static::$EDUCATIONAL_ATTAINMENT);
        $ignore = static::updateCountyData($year, $stateID, static::$INEQUALITY_INDEX);
    }


    /**
     * Retrieves raw county data from the ACS
     *
     * @param string $year
     * @param string $stateID
     * @param string $categoryName
     * @return array $processedDataArray
     * @throws Exception
     */
    public static function getRawCountyData($year, $stateID, $categoryName)
    {
        if (static::hasAPIKey()) {
            $map = static::getMap($categoryName);
            $fields = $map::getAllCodes();
            return static::$grabber->grabACSData($year, $stateID, $fields, 'counties');
        }
        throw new Exception('API key not set', 500);
    }

    /**
     * Retrieves raw state-level data from the ACS
     *
     * @param string $year
     * @param string $stateID
     * @param string $categoryName
     * @return array $processedDataArray
     * @throws Exception
     */
    public static function getRawStateData($year, $stateID, $categoryName)
    {
        if (static::hasAPIKey()) {
            $map = static::getMap($categoryName);
            $fields = $map::getAllCodes();
            return static::$grabber->grabACSData($year, $stateID, $fields, 'state');
        }
        throw new Exception('API key not set', 500);
    }

    /**
     * Returns county data from the ACS formatted into groups and readable headings
     *
     * @param string $year
     * @param string $stateID
     * @param string $categoryName
     * @return array $processedDataArray
     * @throws Exception
     */
    public static function getCountyData($year, $stateID, $categoryName)
    {
        $rawData = static::getRawCountyData($year, $stateID, $categoryName);
        $map = static::getMap($categoryName);
        return static::combineCategories($rawData, $map);
    }

    /**
     * Returns state-level data from the ACS formatted into groups and readable headings
     *
     * @param string $year
     * @param string $stateID
     * @param string $categoryName
     * @return array $processedDataArray
     * @throws Exception
     */
    public static function getStateData($year, $stateID, $categoryName)
    {
        $rawData = static::getRawStateData($year, $stateID, $categoryName);
        $map = static::getMap($categoryName);
        return static::combineCategories($rawData, $map);
    }



    /**
     * Returns a map object for the specified category
     *
     * @param string $categoryName
     * @return ACSPopulationAgeTableMap|ACSHouseholdIncomeTableMap|ACSEthnicMakeupTableMap|ACSEducationalAttainmentMap|ACSGINIMap
     * @throws Exception
     */
    private static function getMap($categoryName)
    {
        switch ($categoryName) {
            case static::$POPULATION_AGE:
                return new ACSPopulationAgeTableMap();
            case static::$HOUSEHOLD_INCOME;
                return new ACSHouseholdIncomeTableMap();
            case static::$ETHNIC_MAKEUP;
                return new ACSEthnicMakeupTableMap();
            case static::$EDUCATIONAL_ATTAINMENT;
                return new ACSEducationalAttainmentMap();
            case static::$INEQUALITY_INDEX;
                return new ACSGINIMap();
        }

        throw new \Exception('Unrecognized category name: '.$categoryName, 500);
    }


    /**
     * Takes raw data from the ACS, and the associated map of table entries,
     * formats headings, combines data into proper groups.
     * Returns the formatted data.
     *
     * @param array $rawData
     * @param ACSGenericTableMap $map
     * @return array $combinedData
     */
    private static function combineCategories(array $rawData, ACSGenericTableMap $map)
    {
        $combinedData = [];
        $groups = $map::getAllGroupKeys();
        foreach ($rawData as $fips => $row) {
            $newRow = [];
            foreach ($groups as $group){
                $columnsInGroup = $map::getColumnCodes($group);
                $newRow[$group] = 0;
                foreach ($columnsInGroup as $col) {
                    $newRow[$group] += $row[$col];
                }
            }
            $combinedData[$fips] = $newRow;
        }
        return $combinedData;
    }


    /**
     * Typically used immediately after data collection.
     * Given raw ACS data and an associated map, writes the raw data to a file.
     * First Row of output is the text name associated with the column of data
     * Second Row of output is the ACS Column Code for the data (used mostly for verification purposes)
     * Remaining Rows are county Data
     *
     * @param array $data
     * @param string $fileName
     * @param ACSGenericTableMap $map
     */
    private static function writeRawCSV(array $data, $fileName, ACSGenericTableMap $map)
    {
        $fp = fopen($fileName, 'w');
        $startOfFile = TRUE;

        foreach ($data as $fipsID => $row) {
            if ($startOfFile) {
                $firstRow = [""];
                foreach (array_keys($row) as $code) {
                    array_push($firstRow, $map::getTextName($code));
                }
                $secondRow = array_merge(["FIPS Code"], array_keys($row));

                fputcsv($fp, $firstRow);
                fputcsv($fp, $secondRow);

                $startOfFile = FALSE;
            }
            $modifiedRow = array_merge([$fipsID], $row);
            fputcsv($fp, $modifiedRow);
        }
        fclose($fp);
    }


    /**
     * Given a processed array of ACS data,
     * writes the processed data to file for later use updating the Database.
     *
     * @param array $processedData
     * @param $fileName
     */
    private static function writeProcessedCSV(array $processedData, $fileName)
    {
        $fp = fopen($fileName, 'w');
        $startOfFile = TRUE;

        foreach ($processedData as $fipsID => $row) {
            if ($startOfFile) {
                $firstRow = array_merge(["FIPS Code"], array_keys($row));
                fputcsv($fp, $firstRow);
                $startOfFile = FALSE;
            }
            $modifiedRow = array_merge([$fipsID], $row);
            fputcsv($fp, $modifiedRow);
        }
        fclose($fp);
    }
}
