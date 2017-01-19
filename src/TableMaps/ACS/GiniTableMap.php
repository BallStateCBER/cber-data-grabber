<?php
namespace CBERDataGrabber\TableMaps\ACS;

class GiniTableMap extends TableMap
{
    /**
     * ACS Column Code => Plain English Column Name
     *
     * @var array
     */
    protected static $MAP = [
        'B19083_001E' => 'GINIIndex'
    ];

    /**
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     *
     * @var array
     */
    protected static $GROUPS = [
        'GINI Index' => 'GINIIndex'
    ];
}
