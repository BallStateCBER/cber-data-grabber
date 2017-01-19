<?php
namespace CBERDataGrabber\TableMaps\ACS;

class EthnicMakeupTableMap extends TableMap
{
    /**
     * ACS Column Code => Plain English Column Name
     *
     * @var array
     */
    protected static $MAP = [
        'B02001_001E' => 'Total',
        'B02001_002E' => 'White',
        'B02001_003E' => 'Black',
        'B02001_004E' => 'Native American',
        'B02001_005E' => 'Asian',
        'B02001_006E' => 'Pacific Islander',
        'B02001_007E' => 'Other',
        'B02001_008E' => 'Two or more'
    ];

    /**
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     *
     * @var array
     */
    protected static $GROUPS = [
        'Total' => 'Total',
        'White' => 'White',
        'Black' => 'Black',
        'Native American' => 'Native American',
        'Asian' => 'Asian',
        'Pacific Islander' => 'Pacific Islander',
        'Other' => 'Other',
        'Two or more' => 'Two or more'
    ];
}
