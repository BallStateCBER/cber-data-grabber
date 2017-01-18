<?php
namespace CBERDataGrabber;

include 'BEADataGrabber.php';
include 'BEATableMaps.php';

/**
 * A class that controls the collection of data from the BEA
 * for the purpose of keeping CBER's County Profile Pages up to date.
 *
 * All Data collected can be saved to a CSV for later processing and integration into the live Database.
 *
 * @author Brandon Patterson
 * @version 0.3
 */
class BEAUpdater
{
    private static $grabber;
    private static $APIKEY = '';
    public static $WAGES = 'wages';
    public static $EMPLOYMENT = 'employment';
    public static $TRANSFER_PAYMENT_BREAKDOWN = 'transfer_payment_breakdown';
    public static $TRANSFER_PAYMENT_PROPORTION = 'transfer_payments_as_portion_of_income';
    public static $WORKERS_COMP = 'workers_comp';
    public static $SOCIAL_ORG_INCOME = 'social_organization_income';

    /**
     * Returns TRUE or FALSE depending on if the API key has been set
     *
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
     * @return void
     */
    public static function setAPIKey($key)
    {
        static::$APIKEY = $key;
        static::$grabber = new BEACountyDataGrabber($key);
    }

    /**
     * Calls for the update of all County Profile Data from the BEA,
     * for a given year and stateID (FIPS State Code).
     *
     * @param string $year
     * @param string $stateID
     * @return void
     */
    public static function updateAllCountyData($year, $stateID)
    {
        static::updateCountyData($year, $stateID, static::$WAGES, true);
        static::updateCountyData($year, $stateID, static::$EMPLOYMENT, true);
        static::updateCountyData($year, $stateID, static::$TRANSFER_PAYMENT_BREAKDOWN, true);
        static::updateCountyData($year, $stateID, static::$TRANSFER_PAYMENT_PROPORTION, true);
        static::updateCountyData($year, $stateID, static::$WORKERS_COMP, true);
        static::updateCountyData($year, $stateID, static::$SOCIAL_ORG_INCOME, true);
    }


    /**
     * Updates county data from the BEA,
     * for a given year, stateID (FIPS State Code), and categoryName.
     * Saves raw and processed data to CSV if the saveToCSVs flag is TRUE
     *
     * @param string $year
     * @param string $stateID
     * @param string $categoryName
     * @param boolean $saveToCSV
     * @return string[] $processedDataArray
     */
    public static function updateCountyData($year, $stateID, $categoryName, $saveToCSV)
    {
        if (static::hasAPIKey()) {
            switch ($categoryName) {
                case static::$WAGES:
                    $map = new BEAWageMap();
                    break;
                case static::$EMPLOYMENT:
                    $map = new BEAEmploymentMap();
                    break;
                case static::$TRANSFER_PAYMENT_BREAKDOWN:
                    $map = new BEATransferPaymentBreakdownMap();
                    break;
                case static::$TRANSFER_PAYMENT_PROPORTION:
                    $map = new BEATransferPaymentProportionMap();
                    break;
                case static::$WORKERS_COMP:
                    $map = new BEAWorkersCompMap();
                    break;
                case static::$SOCIAL_ORG_INCOME:
                    $map = new BEASocialOrgIncomeMap();
                    break;
            }

            $dataSetName = $map::getDataSet();
            $tableName = $map::getTableName();
            $lineCodes = $map::getAllLineCodes();

            $rawData = static::$grabber->grabBEAData($year, $stateID, $dataSetName, $tableName, $lineCodes);
            $processedDataArray = static::combineCategories($rawData, $map);

            if ($saveToCSV) {
                $rawFileName = date('Y-m-d') . '_raw_county_' . $categoryName . '_data_' . $stateID . '_' . $year .
                    '-00-00.csv';
                $processedFileName = date('Y-m-d') . '_processed_county_' . $categoryName . '_' . $stateID . '_' .
                    $year . '-00-00.csv';
                static::writeRawCSV($rawData, $rawFileName, $map);
                static::writeProcessedCSV($processedDataArray, $processedFileName);
            }

            return $processedDataArray;
        }
    }

    /**
     * Takes raw data from the BEA, and the associated map of table entries,
     * formats headings, combines data into proper groups.
     * Returns the formatted data.
     *
     * @param string[] $rawData
     * @param BEAGenericTableMap $map
     * @return int[] $combinedData
     */
    private static function combineCategories(array $rawData, BEAGenericTableMap $map)
    {
        $combinedData = [];
        $groups = $map::getAllGroupKeys();
        foreach ($rawData as $fips => $row) {
            $newRow = [];
            $countyTotal = 0;
            foreach ($groups as $group) {
                $columnsInGroup = $map::getLineCodes($group);
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
     * Given raw BEA data and an associated map, writes the raw data to a file.
     * First Row of output is the text name associated with the column of data
     * Second Row of output is the BEA Line Code for the data (used mostly for verification purposes)
     * Remaining Rows are county Data
     *
     * @param string[] $data
     * @param string $fileName
     * @param BEAGenericTableMap $map
     * @return void
     */
    private static function writeRawCSV(array $data, $fileName, BEAGenericTableMap $map)
    {
        $fp = fopen($fileName, 'w');
        $startOfFile = true;

        foreach ($data as $fipsID => $row) {
            if ($startOfFile) {
                $firstRow = [''];
                foreach (array_keys($row) as $code) {
                    array_push($firstRow, $map::getTextName($code));
                }
                $secondRow = array_merge(['FIPS Code'], array_keys($row));

                fputcsv($fp, $firstRow);
                fputcsv($fp, $secondRow);

                $startOfFile = false;
            }
            $modifiedRow = array_merge([$fipsID], $row);
            fputcsv($fp, $modifiedRow);
        }
        fclose($fp);
    }

    /**
     * Given a processed array of BEA data,
     * writes the processed data to file for later use updating the Database.
     *
     * @param int[] $processedData
     * @param string $fileName
     * @return void
     */
    private static function writeProcessedCSV(array $processedData, $fileName)
    {
        $fp = fopen($fileName, 'w');
        $startOfFile = true;

        foreach ($processedData as $fipsID => $row) {
            if ($startOfFile) {
                $firstRow = array_merge(['FIPS Code'], array_keys($row));
                fputcsv($fp, $firstRow);
                $startOfFile = false;
            }
            $modifiedRow = array_merge([$fipsID], $row);
            fputcsv($fp, $modifiedRow);
        }
        fclose($fp);
    }
}
