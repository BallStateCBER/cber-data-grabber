<?php
namespace CBERDataGrabber\TableMaps\BEA;

class WorkersCompTableMap extends TableMap
{
    protected static $DATASET = 'RegionalIncome';
    protected static $TABLE = 'CA35';

    /** @var array $MAP BEA Line Code => Plain English Column Name */
    protected static $MAP = [
        '2120' => 'Retirement and Disability Insurance Benefits, Excluding Social Security'
    ];

    /**
     * @var array $GROUPS Group Name => comma delimited list of column identifiers for the group
     *
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     */
    protected static $GROUPS = [
        'Workers Compensation' => 'Retirement'
    ];
}
