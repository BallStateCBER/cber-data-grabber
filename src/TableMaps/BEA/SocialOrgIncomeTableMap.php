<?php
namespace CBERDataGrabber\TableMaps\BEA;

class SocialOrgIncomeTableMap extends TableMap
{
    protected static $DATASET = 'RegionalIncome';
    protected static $TABLE = 'CA5N';

    // BEA Line Code => Plain English Column Name
    protected static $MAP = [
        '1903' => 'Income from Membership Associations and Organizations'
    ];

    /*
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     */
    protected static $GROUPS = [
        'Income from Social and Fraternal Organizations' => 'Income'
    ];
}
