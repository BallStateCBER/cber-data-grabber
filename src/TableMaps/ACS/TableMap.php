<?php
namespace CBERDataGrabber\TableMaps\ACS;

/**
 * A utility that provides a set of default functions for interacting with a Map of ACS table codes.
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

    /**
     * Returns an array containing all of the ACS Column Codes in a requested group, named groupKey
     *
     * @param string $groupKey
     * @return string[]
     */
    public static function getColumnCodes($groupKey)
    {
        $colIndices = [];
        $searches = explode(',', static::$GROUPS[$groupKey]);
        foreach ($searches as $search) {
            $colIndices = array_merge($colIndices, static::search($search));
        }

        return $colIndices;
    }

    /**
     * Returns an array containing all individual ACS Column Codes in the table whose English names contain the
     * specified searchString
     *
     * @param string $searchString
     * @return string[]
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
     * Returns an array all ACS Column Codes in the MAP
     *
     * @return string[]
     */
    public static function getAllCodes()
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
     * @return string[]
     */
    public static function getAllGroupKeys()
    {
        return array_keys(static::$GROUPS);
    }

    /**
     * Returns the English text name associated with a specific ACS Column Code in the MAP
     *
     * @param string $code
     * @return string
     */
    public static function getTextName($code)
    {
        if (array_key_exists($code, static::$MAP)) {
            return static::$MAP[$code];
        } else {
            return "";
        }
    }
}
