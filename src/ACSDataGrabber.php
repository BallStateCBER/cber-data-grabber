<?php
namespace CBERDataGrabber;

/**
 * A utility for querying the American Comunity Survey API
 *
 * @author Brandon Patterson
 * @version 0.2
 */
class ACSCountyDataGrabber{

    protected $APIKEY = '';
    private $data = array();

    function __construct($key){
        $this->APIKEY = $key;
    }

    /**
     * Given a year, stateID (FIPS code), and an array of ACS Field names (as strings),
     * constructs an API query, requests the data from the ACS.
     *
     * Returns the raw data as an array of strings,
     * with rows labeled by County FIPS Code,
     * and columns labeled by ACS field codes
     *
     * @param string $year
     * @param string $stateID
     * @param string[] $fields
     * @return string[] $data
     * @throws \Exception
     */
    public function grabACSData($year, $stateID, array $fields){

        $queryURL = 'http://api.census.gov/data/';
        $queryURL .= $year;
        $queryURL .= '/acs5?get=' . implode(',',$fields);
        $queryURL .= '&for=county:*';
        $queryURL .= '&in=state:' . $stateID;
        $queryURL .= '&key=' . $this->APIKEY;

        $jsondata = @file_get_contents($queryURL);
        if ($jsondata === false) {
            throw new \Exception('No response from api.census.gov');
        }

        $this -> data = json_decode($jsondata);
        $this->checkForJsonError();

        ACSCountyDataGrabber::formatRawData();
        return $this -> data;
    }

    private function checkForJsonError()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return;
            case JSON_ERROR_DEPTH:
                throw new \Exception('JSON error: Maximum stack depth exceeded', 500);
            case JSON_ERROR_STATE_MISMATCH:
                throw new \Exception('JSON error: Underflow or the modes mismatch', 500);
            case JSON_ERROR_CTRL_CHAR:
                throw new \Exception('JSON error: Unexpected control character found', 500);
            case JSON_ERROR_SYNTAX:
                throw new \Exception('JSON error: Syntax error, malformed JSON', 500);
            case JSON_ERROR_UTF8:
                throw new \Exception('JSON error: Malformed UTF-8 characters, possibly incorrectly encoded', 500);
            default:
                throw new \Exception('JSON error: Unknown error', 500);
        }
    }

    /**
     * Processes the raw array to contain the correct index names.
     * Removes unneeded data
     */
    private function formatRawData(){
        $headers = array_shift($this -> data);
        $stateIndex = array_search("state", $this -> data);
        $countyIndex = array_search("county", $this -> data);

        #index columns by first row
        foreach($this -> data as $row => $entry){
            for($i = count($headers)-1; $i>=0; $i--){

                $entry[$headers[$i]] = $entry[$i];
                unset($entry[$i]);
            }

            #index rows by FIPS code, and add a FIPS column
            $fipsCode = $entry['state'] . $entry['county'];
            unset($entry['state']);
            unset($entry['county']);
            $entry['FIPS'] = $fipsCode;
            $this -> data[$fipsCode] = $entry;
            unset($this -> data[$row]);
        }
    }
}
