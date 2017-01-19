<?php
namespace CBERDataGrabber\TableMaps\BEA;

class TransferPaymentProportionTableMap extends TableMap
{
    protected static $DATASET = 'RegionalIncome';
    protected static $TABLE = 'CA4';

    // BEA Line Code => Plain English Column Name
    protected static $MAP = [
        '10' => 'Personal Income',
        '47' => 'Personal Current Transfer Receipts'
    ];

    /*
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     */
    protected static $GROUPS = [
        'Personal Income' => 'Income',
        'Personal Current Transfer Receipts' => 'Current'
    ];
}
