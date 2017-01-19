<?php
namespace CBERDataGrabber\TableMaps\BEA;

/**
 * A utility that provides a set of default functions for interacting with a Map of a BEA Table.
*
* @author Brandon Patterson
* @version 0.1
*/

class TableMap
{
    /*
     * $MAP is an array of BEA LineCode -> Plain English Column Name, defined in each specific ACS Map
     *
     * $GROUPS is an array of GroupName => comma delimited list of column names in group,
     * defined in each specific ACS Map
     */

    /**
     * Returns an array containing all of the BEA Line Codes in a requested group, named groupKey
     *
     * @param string $groupKey
     * @return string[] codes
     */
    public static function getLineCodes($groupKey)
    {
        $colIndices = [];
        $searches = explode(',', static::$GROUPS[$groupKey]);
        foreach ($searches as $search) {
            $colIndices = array_merge($colIndices, static::search($search));
        }

        return $colIndices;
    }

    /**
     * returns an array containing all individual BEA Line Codes in the table whose English names contain the
     * specified searchString
     *
     * @param string $searchString
     *
     * @return string[] codes
     */
    private static function search($searchString)
    {
        $list = [];
        foreach (static::$MAP as $code => $name) {
            if (strpos($name, $searchString) !== false) {
                array_push($list, $code);
            }
        }

        return $list;
    }

    /**
     * Returns an array all BEA Line Codes in the MAP
     *
     * @return string[] lineCodes
     */
    public static function getAllLineCodes()
    {
        $indices = [];
        foreach (static::$MAP as $tableCode => $name) {
            array_push($indices, $tableCode);
        }

        return $indices;
    }

    /**
     * Returns an array of all the keys in GROUPS
     *
     * @return string[] keys
     */
    public static function getAllGroupKeys()
    {
        return array_keys(static::$GROUPS);
    }

    /**
     * Returns the Table Name as a String
     *
     * @return string tableName
     */
    public static function getTableName()
    {
        return static::$TABLE;
    }

    /**
     * Returns the Table Name as a String
     *
     * @return string dataSetName
     */
    public static function getDataSet()
    {
        return static::$DATASET;
    }

    /**
     * Returns the English text name associated with a specific BEA Line Code in the MAP
     *
     * @param string $code
     * @return string textName
     */
    public static function getTextName($code)
    {
        if (array_key_exists($code, static::$MAP)) {
            return static::$MAP[$code];
        }

        return "";
    }
}
