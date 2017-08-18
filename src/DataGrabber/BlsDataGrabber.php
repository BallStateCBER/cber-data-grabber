<?php
namespace CBERDataGrabber\DataGrabber;

use CBERDataGrabber\FipsCodeGenerator;

/**
 * A utility for querying the Bureau of Labor Statistics API
 * (Currently only supports Unemployment data)
 *
 * Currently uses the BLS Public API
 *         Note: the BLS Public API only allows 25 queries per day by default, with up to 25 series per query.
 *         An upgraded key allows for 500 queries per day, with up to 50 series per query.
 *
 * @author Brandon Patterson
 * @version 0.1
 */
class BlsDataGrabber
{
    static private $data = [];
    static private $tablePrefixes = [
        'stateUnadjUnemployRate' => 'LAUST',
        'countyUnadjUnemployRate' => 'LAUCN'
    ];

    static private $tableSuffixes = [
        'stateUnadjUnemployRate' => '0000000003',
        'countyUnadjUnemployRate' => '0000000003'
    ];

    /**
     * Given a State FIPS code and an ending year, returns the (unadjusted) county-level unemployment levels for the
     * previous 10 year period.
     * Seasonally adjusted data does not appear to be available at the county level.
     *
     * @param string stateId
     * @param string endYear
     * @return string[] $data
     */
    public static function grabUnadjUnemploymentData($stateId, $endYear)
    {
        ini_set('max_execution_time', 0);

        static::$data = [];

        $codes = FipsCodeGenerator::getFipsList($stateId);
        $index = 0;
        $tableList = [];

        foreach ($codes as $code) {
            if (count($tableList) >= 25) {
                $results = static::queryAPI($tableList, $endYear);
                static::addToData($results);
                $tableList = [];
            }

            $entry = '';
            // If the code is a state code
            if (substr($code, -3) == '000') {
                $entry .= static::$tablePrefixes['stateUnadjUnemployRate'];
                $entry .= $code;
                $entry .= static::$tableSuffixes['stateUnadjUnemployRate'];
            } else {
                $entry .= static::$tablePrefixes['countyUnadjUnemployRate'];
                $entry .= $code;
                $entry .= static::$tableSuffixes['countyUnadjUnemployRate'];
            }

            // Append the entry to the indexed list
            array_push($tableList, $entry);
        }

        $results = static::queryAPI($tableList, $endYear);
        static::addToData($results);

        ksort(static::$data);
        return static::$data;
    }

    /**
     * Given a list of (up to 25) table entries, and an ending year,
     * queries the past 10 years of data for each entry,
     * and returns the decoded query result as a (complex) generic php object
     *
     * @param array $tableList
     * @param string $endYear
     * @return object $results json_decoded API query result
     */
    private static function queryAPI($tableList, $endYear)
    {
        $url = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
        $method = 'POST';
        $query = [
            'seriesid'  => $tableList,
            'startyear' => $endYear - 9,
            'endyear'   => $endYear
        ];

        $pd = json_encode($query);
        $contentType = 'Content-Type: application/json';
        $contentLength = 'Content-Length: ' . strlen($pd);

        /*
         * Trainwreck code that queries the API and decodes the json results
         * (pulled straight from the BLS PHP API example)
         */
        $results = json_decode(
            file_get_contents(
                $url,
                null,
                stream_context_create([
                   'http' => [
                        'method' => $method,
                        'header' => $contentType . "\r\n" . $contentLength . "\r\n",
                        'content' => $pd
                   ],
                ])
            )
        );

        return $results;
    }

    /**
     * Processes raw json_docoded BLS data object, and adds its entries to the data array
     *
     * @param $blsResults
     * @return void
     */
    private static function addToData($blsResults)
    {
        foreach ($blsResults->Results->series as $table) {
            // Extracts the FIPS code from the series ID
            $rowName = substr($table->seriesID, 5, 5);
            foreach ($table->data as $entry) {
                $columnName = $entry->year;
                $columnName .= $entry->period;
                $dataEntry = $entry->value;

                static::$data[$rowName][$columnName] = $dataEntry;
            }
        }
    }
}
