<?php
namespace CBERDataGrabber;

include 'FipsCodeGenerator.php';

/**
 * A utility for querying the BEA API
 *
 * @author Brandon Patterson
 * @version 0.2
 */
class BEACountyDataGrabber
{
    protected $APIKEY = '';
    private $data = [];

    public function __construct($key)
    {
        $this->APIKEY = $key;
    }

    /**
     * Given a year, stateID (FIPS code), tableName, and array of lineCodes names (as strings),
     * constructs an API query, requests the data from the BEA.
     *
     * Processes the raw data and returns the simplified output as an array of strings,
     * with rows labeled by County FIPS Code,
     * and columns labeled by BEA Code field codes
     *
     * @param string $year
     * @param string $stateID
     * @param string $dataSetName
     * @param string $tableName
     * @param string[] $lineCodes
     * @return string[] $data
     */
    public function grabBEAData($year, $stateID, $dataSetName, $tableName, $lineCodes)
    {
        ini_set('max_execution_time', 0);

        $this->data = array();
        $fipsStr = $this::getFipsString($stateID);

        foreach ($lineCodes as $code) {
            $queryURL = 'https://bea.gov/api/data/';
            $queryURL .= '?UserID='.$this->APIKEY;
            $queryURL .= '&method=GetData';
            $queryURL .= '&datasetname='.$dataSetName;
            $queryURL .= '&tablename='.$tableName;
            $queryURL .= '&LineCode='.$code;
            $queryURL .= '&Year='.$year;
            $queryURL .= '&GeoFips='.$fipsStr;
            $jsondata = file_get_contents($queryURL);
            $rawData = json_decode($jsondata);

            BEACountyDataGrabber::processRawData($rawData, $code);
        }

        return $this->data;
    }

    /**
     * Returns a comma-delimited string
     *
     * @param string $stateID State ID
     * @return string
     */
    private function getFipsString($stateID)
    {
        return implode(',', FipsCodeGenerator::getFipsList($stateID));
    }

    /**
     * Processes a single API query result into a useful format, and adds it to $this->$data
     * Removes unneeded details
     *
     * @param \stdClass $rawData Data returned from an API call
     * @param string[] $lineCode BEA Line Codes
     * @return void
     */
    private function processRawData($rawData, $lineCode)
    {
        $tempData = $rawData->BEAAPI->Results->Data;
        $col = $lineCode;

        if (count($tempData) > 1) {
            foreach ($tempData as $entry) {
                $row = $entry->GeoFips;
                $this->data[$row][$col] = $entry->DataValue;
            }
        } else {
            $row = $tempData->GeoFips;
            $this->data[$row][$col] = $tempData->DataValue;
        }
    }
}
