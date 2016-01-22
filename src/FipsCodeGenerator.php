<?php
namespace CBERDataGrabber;

/**
 * Mostly unfinished class, intended to make extension of these utilities beyond Indiana easy, if we ever pursue additional states
 * Currently supports only Indiana FIPS codes
 * Will return only the FIPS code for the full state (ex ['19000']) if an unsupported state is queries)
 */
class FipsCodeGenerator{

	/**
     * Can be used only for states with a perfect county sequence (all odd suffixes from '001' to the listed high value)
     */
	private static $highestFipsByStateCode = array('18' => 183); // stateId => highest FIPS suffix; fill out as needed


	/**
	 * Generates a listing of FIPS codes for the selected state ID.
	 * Returns an array including the whole-state FIPS code, as well as individual county codes.
	 * Currently only supports Indiana (state '18')
	 *
	 * @param string $stateID
	 *
	 * @return string[] fipsList
	 */
	public static function getFipsList($stateID){
		$fipsList = array();
		array_push($fipsList,$stateID.'000');
		if (array_key_exists($stateID, FipsCodeGenerator::$highestFipsByStateCode)){
			$seq = range(1,FipsCodeGenerator::$highestFipsByStateCode[$stateID],2);
			foreach($seq as $suffix){
				array_push($fipsList,$stateID.str_pad($suffix, 3, '0', STR_PAD_LEFT));
			}
		}
		return $fipsList;
	}
}
