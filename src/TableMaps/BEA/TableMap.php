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
    /** @var array $MAP Array of ACSCode -> Plain English Column Names */
    protected static $MAP = [];

    /** @var array $GROUPS Array of GroupName => comma delimited list of column names in group */
    protected static $GROUPS = [];

    /** @var string $TABLE Table name*/
    protected static $TABLE;

    /** @var string $DATASET Data set name*/
    protected static $DATASET;

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
     * Returns an array containing all individual BEA Line Codes in the table whose English names contain the
     * specified searchString
     *
     * @param string $searchString
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
     * Returns the table name
     *
     * @return string tableName
     */
    public static function getTableName()
    {
        return static::$TABLE;
    }

    /**
     * Returns the data set name
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
