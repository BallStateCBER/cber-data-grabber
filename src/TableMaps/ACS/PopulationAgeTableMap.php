<?php
namespace CBERDataGrabber\TableMaps\ACS;

class PopulationAgeTableMap extends TableMap
{
    /**
     * ACS Column Code => Plain English Column Name
     *
     * @var array
     */
    protected static $MAP = [
        'B01001_001E' => 'Total Population',
        'B01001_002E' => 'Male Total',
        'B01001_003E' => 'Male <5',
        'B01001_004E' => 'Male 5-9',
        'B01001_005E' => 'Male 10-14',
        'B01001_006E' => 'Male 15-17',
        'B01001_007E' => 'Male 18-19',
        'B01001_008E' => 'Male 20',
        'B01001_009E' => 'Male 21',
        'B01001_010E' => 'Male 22-24',
        'B01001_011E' => 'Male 25-29',
        'B01001_012E' => 'Male 30-34',
        'B01001_013E' => 'Male 35-39',
        'B01001_014E' => 'Male 40-44',
        'B01001_015E' => 'Male 45-49',
        'B01001_016E' => 'Male 50-54',
        'B01001_017E' => 'Male 55-59',
        'B01001_018E' => 'Male 60-61',
        'B01001_019E' => 'Male 62-64',
        'B01001_020E' => 'Male 65-66',
        'B01001_021E' => 'Male 67-69',
        'B01001_022E' => 'Male 70-74',
        'B01001_023E' => 'Male 75-79',
        'B01001_024E' => 'Male 80-84',
        'B01001_025E' => 'Male 85+',
        'B01001_026E' => 'Female Total',
        'B01001_027E' => 'Female <5',
        'B01001_028E' => 'Female 5-9',
        'B01001_029E' => 'Female 10-14',
        'B01001_030E' => 'Female 15-17',
        'B01001_031E' => 'Female 18-19',
        'B01001_032E' => 'Female 20',
        'B01001_033E' => 'Female 21',
        'B01001_034E' => 'Female 22-24',
        'B01001_035E' => 'Female 25-29',
        'B01001_036E' => 'Female 30-34',
        'B01001_037E' => 'Female 35-39',
        'B01001_038E' => 'Female 40-44',
        'B01001_039E' => 'Female 45-49',
        'B01001_040E' => 'Female 50-54',
        'B01001_041E' => 'Female 55-59',
        'B01001_042E' => 'Female 60-61',
        'B01001_043E' => 'Female 62-64',
        'B01001_044E' => 'Female 65-66',
        'B01001_045E' => 'Female 67-69',
        'B01001_046E' => 'Female 70-74',
        'B01001_047E' => 'Female 75-79',
        'B01001_048E' => 'Female 80-84',
        'B01001_049E' => 'Female 85+'
    ];

    /**
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     *
     * @var array
     */
    protected static $GROUPS = [
        'Total Population' => 'Total Population',
        'Under 5' => '<5',
        '5 to 9' => '5-9',
        '10 to 14' => '10-14',
        '15 to 19' => '15-17,18-19',
        '20 to 24' => '20,21,22-24',
        '25 to 34' => '25-29,30-34',
        '35 to 44' => '35-39,40-44',
        '45 to 54' => '45-49,50-54',
        '55 to 59' => '55-59',
        '60 to 64' => '60-61,62-64',
        '65 to 74' => '65-66,67-69,70-74',
        '75 to 84' => '75-79,80-84',
        '85 and over' => '85+'
    ];
}
