<?php
namespace CBERDataGrabber\TableMaps\BEA;

class EmploymentTableMap extends TableMap
{
    protected static $DATASET = 'RegionalIncome';
    protected static $TABLE = 'CA25N';

    // BEA Line Code => Plain English Column Name
    protected static $MAP = [
        '10' => 'Total Employment',
        '70' => 'Farming',
        '100' => 'Forestry, Fishing, Related',
        '200' => 'Mining',
        '300' => 'Utilities',
        '400' => 'Construction',
        '500' => 'Manufacturing',
        '600' => 'Wholesale Trade',
        '700' => 'Retail Trade',
        '800' => 'Transportation and Warehousing',
        '900' => 'Information',
        '1000' => 'Finance and Insurance',
        '1100' => 'Real Estate, Rental and Leasing',
        '1200' => 'Professional, Scientific, and Technical Services',
        '1300' => 'Management of Companies and Enterprises',
        '1400' => 'Administrative and Waste Management Services',
        '1500' => 'Educational Services',
        '1600' => 'Health Care and Social Assistance',
        '1700' => 'Arts, Entertainment, and Recreation',
        '1800' => 'Accommodation and Food Services',
        '1900' => 'Other Services, Except Public Administration',
        '2000' => 'Government and Government Enterprises'
    ];

    /*
     * Group Name => comma delimited list of column identifiers for the group
     * (an identifier is a string that matches values in $MAP that are part of the group,
     * and does not match any $MAP values outside of the group)
     *
     * "Management" includes both professional management and waste management
     */
    protected static $GROUPS = [
        'Total Employment' => 'Total Employment',
        'Farming, Agriculture, and Mining' => 'Farming,Forestry,Mining',
        'Utility, Trade, and Transportation' => 'Utilities,Trade,Transportation',
        'Manufacturing' => 'Manufacturing',
        'Construction' => 'Construction',
        'Services' => 'Information,Finance,Real Estate,Technical,Management,Health,Arts,Accommodation',
        'Government and Public Education' => 'Educational,Government',
        'Others' => 'Other'
    ];
}
