<?php
namespace CBERDataGrabber\TableMaps\ACS;

class EducationalAttainmentTableMap extends TableMap
{
    /**
     * ACS Column Code => Plain English Column Name
     *
     * @var array
     */
    protected static $MAP = [
        'B15003_001E' => 'Total',
        'B15003_002E' => 'None',
        'B15003_003E' => 'Nursery',
        'B15003_004E' => 'Kindergarten',
        'B15003_005E' => '1st',
        'B15003_006E' => '2nd',
        'B15003_007E' => '3rd',
        'B15003_008E' => '4th',
        'B15003_009E' => '5th',
        'B15003_010E' => '6th',
        'B15003_011E' => '7th',
        'B15003_012E' => '8th',
        'B15003_013E' => '9th',
        'B15003_014E' => '10th',
        'B15003_015E' => '11th',
        'B15003_016E' => '12thNoDiploma',
        'B15003_017E' => 'HSDiploma',
        'B15003_018E' => 'GED',
        'B15003_019E' => '<1yrCollege',
        'B15003_020E' => '>1yrCollegeNoDegree',
        'B15003_021E' => 'Associates',
        'B15003_022E' => 'Bachelors',
        'B15003_023E' => 'Masters',
        'B15003_024E' => 'Professional',
        'B15003_025E' => 'Doctorate'
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
        'Less than 9th grade' => 'None,Nursery,Kindergarten,1st,2nd,3rd,4th,5th,6th,7th,8th',
        '9th to 12th grade, no diploma' => '9th,10th,11th,12thNoDiploma',
        'High school graduate (incl. equivalency)' => 'HSDiploma,GED',
        'Some college, no degree' => '<1yrCollege,>1yrCollegeNoDegree',
        'Associate degree' => 'Associates',
        'Bachelor\'s degree' => 'Bachelors',
        'Graduate or professional degree' => 'Masters,Professional,Doctorate'
    ];
}
