<?php
namespace CBERDataGrabber\TableMaps\BEA;

class TransferPaymentBreakdownTableMap extends TableMap
{
    protected static $DATASET = 'RegionalIncome';
    protected static $TABLE = 'CA35';

    // BEA Line Code => Plain English Column Name
    protected static $MAP = [
        '1000' => 'Personal Current Transfer Receipts',
        '2100' => 'Retirement and Disability Insurance Benefits',
        '2200' => 'Medical Benefits',
        '2300' => 'Income Maintenance Benefits',
        '2400' => 'Unemployment Insurance Compensation',
        '2500' => 'Veterans Benefits',
        '2600' => 'Education and Training Assistance',
        '2700' => 'Other'
    ];

    /*
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     */
    protected static $GROUPS = [
        'Total' => 'Personal Current Transfer Receipts',
        'Retirement and Disability Insurance' => 'Retirement',
        'Medical' => 'Medical',
        'Income Maintenance' => 'Income Maintenance',
        'Other' => 'Unemployment,Veterans,Education,Other'
    ];
}
