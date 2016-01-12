<?php
include 'BLSDataGrabber.php';

/**
 * A class that controls the collection of data from the Bureau of Labor Statistics
 * for the purpose of keeping CBER's County Profile Pages up to date.
 *
 * All Data collected can be saved to a CSV for later processing and integration into the live Database.
 *
 * @author Brandon Patterson
 * @version 0.1
 */
class BLSUpdater{

	/**
	 * Calls for the update of all (supported County Profile Data from the BLS,
	 * for a given year and stateID (FIPS State Code).
	 *
	 * @param string $year
	 * @param string $stateID
	 */
	public static function updateAllCountyData($stateID, $endYear){
		$ignore = static::updateCountyUnemployment($stateID, $endYear, true);
	}


	/**
	 * requests a 10 year window of county unemployment data from the BLS,
	 * for a given stateID (FIPS State Code) and ending year.
	 * Saves  data to CSV if the saveToCSVs flag is TRUE
	 *
	 * @param string $stateID
	 * @param string $year
	 * @param boolean $saveToCSV
	 *
	 * @return array $data
	 */
	public static function updateCountyUnemployment($stateID, $endYear, $saveToCSV){

		$data = BLSCountyDataGrabber::grabUnadjUnemploymentData($stateID, $endYear);

		if($saveToCSV){
			$processedFileName = date('Y-m-d').'_processed_county_unadj_unemployment_'.$stateID.'_'.$endYear.'-00-00.csv';
			static::writeProcessedCSV($data, $processedFileName);
		}

		return $data;
	}

	/**
	 * Given an array of BLS data,
	 * writes the processed data to file for later use updating the Database.
	 * (Some naming convention has unnecessarily been kept to preserve similarity between different API updaters.)
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
