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
class ACSUpdater{

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
	public static function hasAPIKey(){
		return static::$APIKEY!='';
	}

	/**
	 * Must be called before data can be pulled.
	 *
	 * @param string $key
	 */
	public static function setAPIKey($key){
		static::$APIKEY=$key;
		static::$grabber = new ACSCountyDataGrabber($key);
	}


	/**
	 * Calls for the update of all County Profile Data from the ACS,
	 * for a given year and stateID (FIPS State Code).
	 *
	 * @param string $year
	 * @param string $stateID
	 */
	public static function updateAllCountyData($year, $stateID){
		$ignore = static::updateCountyData($year, $stateID, static::$POPULATION_AGE);
		$ignore = static::updateCountyData($year, $stateID, static::$HOUSEHOLD_INCOME);
		$ignore = static::updateCountyData($year, $stateID, static::$ETHNIC_MAKEUP);
		$ignore = static::updateCountyData($year, $stateID, static::$EDUCATIONAL_ATTAINMENT);
		$ignore = static::updateCountyData($year, $stateID, static::$INEQUALITY_INDEX);
	}


	/**
	 * Updates county data from the ACS,
	 * for a given year, stateID (FIPS State Code), and categoryName.
	 *
	 * @param string $year
	 * @param string $stateID
	 * @param string $categoryName
	 * @return array $processedDataArray
	 */
	public static function updateCountyData($year, $stateID, $categoryName){
		if(static::hasAPIKey()){
		    $map = static::getMap($categoryName);
			$fields = $map::getAllCodes();
			$rawData = static::$grabber -> grabACSData($year, $stateID, $fields);
			$processedDataArray = static::combineCategories($rawData, $map);
			return $processedDataArray;
		}
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
	private static function combineCategories(array $rawData, ACSGenericTableMap $map){
		$combinedData = array();
		$groups = $map::getAllGroupKeys();
		foreach($rawData as $fips => $row){
			$newRow = array();
			foreach($groups as $group){
				$columnsInGroup = $map::getColumnCodes($group);
				$newRow[$group] = 0;
				foreach($columnsInGroup as $col)
					$newRow[$group] += $row[$col];
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
	private static function writeRawCSV(array $data, $fileName, ACSGenericTableMap $map){
		#echo "writing file: ".$fileName;

		$fp = fopen($fileName, 'w');
		$startOfFile = TRUE;

		foreach ($data as $fipsID => $row) {
			if($startOfFile){
				$firstRow = array("");
				foreach(array_keys($row) as $code)
					array_push($firstRow, $map::getTextName($code));
				$secondRow = array_merge(array("FIPS Code"),array_keys($row));

				fputcsv($fp, $firstRow);
				fputcsv($fp, $secondRow);

				$startOfFile = FALSE;
			}
			$modifiedRow = array_merge(array($fipsID),$row);
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
	private static function writeProcessedCSV(array $processedData, $fileName){
		#echo "writing file: ".$fileName;

		$fp = fopen($fileName, 'w');
		$startOfFile = TRUE;

		foreach ($processedData as $fipsID => $row) {
			if($startOfFile){
				$firstRow = array_merge(array("FIPS Code"),array_keys($row));
				fputcsv($fp, $firstRow);
				$startOfFile = FALSE;
			}
			$modifiedRow = array_merge(array($fipsID),$row);
			fputcsv($fp, $modifiedRow);
		}
		fclose($fp);
	}
}
