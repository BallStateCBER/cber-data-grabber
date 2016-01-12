<?php
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
	 */
	public function grabACSData($year, $stateID, array $fields){

		$queryURL = 'http://api.census.gov/data/';
		$queryURL .= $year;
		$queryURL .= '/acs5?get=' . implode(',',$fields);
		$queryURL .= '&for=county:*';
		$queryURL .= '&in=state:' . $stateID;
		$queryURL .= '&key=' . $this->APIKEY;

		$jsondata = file_get_contents($queryURL);
		$this -> data = json_decode($jsondata);

		ACSCountyDataGrabber::formatRawData();
		return $this -> data;
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
