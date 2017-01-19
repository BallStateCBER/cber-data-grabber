<?php
namespace CBERDataGrabber\TableMaps\ACS;

class HouseholdIncomeTableMap extends TableMap
{
    /**
     * ACS Column Code => Plain English Column Name
     *
     * @var array
     */
    protected static $MAP = [
        'B19001_001E' => 'Count',
        'B19001_002E' => '<10k',
        'B19001_003E' => '10-15k',
        'B19001_004E' => '15-20k',
        'B19001_005E' => '20-25k',
        'B19001_006E' => '25-30k',
        'B19001_007E' => '30-35k',
        'B19001_008E' => '35-40k',
        'B19001_009E' => '40-45k',
        'B19001_010E' => '45-50k',
        'B19001_011E' => '50-60k',
        'B19001_012E' => '60-75k',
        'B19001_013E' => '75-100k',
        'B19001_014E' => '100-125k',
        'B19001_015E' => '125-150k',
        'B19001_016E' => '150-200k',
        'B19001_017E' => '200k+'
    ];

    /**
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     *
     * @var array
     */
    protected static $GROUPS = [
        'Number of Households' => 'Count',
        'Less than $10K' => '<10k',
        '$10K to $14,999' => '10-15k',
        '$15K to $24,999' => '15-20k,20-25k',
        '$25K to $34,999' => '25-30k,30-35k',
        '$35K to $49,999' => '35-40k,40-45k,45-50k',
        '$50K to $74,999' => '50-60k,60-75k',
        '$75K to $99,999' => '75-100k',
        '$100K to $149,999' => '100-125k,125-150k',
        '$150K to $199,999' => '150-200k',
        '$200K or more' => '200k+'
    ];
}
