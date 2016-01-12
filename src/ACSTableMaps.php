<?php
namespace CBERDataGrabber;

include 'ACSGenericTableMap.php';

/**
 * A mapping of ACS Table Codes for data related to the various charts in the CBER County Profiles.
 *
 * @author Brandon Patterson
 * @version 0.2
 */
class ACSPopulationAgeTableMap extends ACSGenericTableMap{

	protected static $MAP = array(
		#ACS Column Code => Plain English Column Name
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
		'B01001_049E' => 'Female 85+');

	protected static $GROUPS = array(
		#Group Name => comma delimited list of column identifiers for the group
		#(an identifier is a string that matches values in $MAP that are part of the group,
		#and does not match any $MAP values outside of the group)
		'Total Population' => 'Total Population',
		'Under 5' => '<5',
		'5 to 9' => '5-9',
		'10 to 14' => '10-14',
		'15 to 19' => '15-17,18-19',
		'20 to 24' => '20,21,22-24',
		'25 to 34' => '25-29,30-34',
		'35 to 44' => '35-39,40-44',
		'45 to 54' => '45-49,50-54',
		'55 to 659' => '55-59',
		'60 to 64' => '60-61,62-64',
		'65 to 74' => '65-66,67-69,70-74',
		'75 to 84' => '75-79,80-84',
		'85 and over' => '85+');
}

class ACSHouseholdIncomeTableMap extends ACSGenericTableMap{

	protected static $MAP = array(
		#ACS Column Code => Plain English Column Name
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
		'B19001_017E' => '200k+');

	protected static $GROUPS = array(
		#Group Name => comma delimited list of column identifiers for the group
		#(an identifier is a string that matches values in $MAP that are part of the group,
		#and does not match any $MAP values outside of the group)
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
		'$200K or more' => '200k+');
}

class ACSEthnicMakeupTableMap extends ACSGenericTableMap{

	protected static $MAP = array(
		#ACS Column Code => Plain English Column Name
		'B02001_001E' => 'Total',
		'B02001_002E' => 'White',
		'B02001_003E' => 'Black',
		'B02001_004E' => 'Native American',
		'B02001_005E' => 'Asian',
		'B02001_006E' => 'Pacific Islander',
		'B02001_007E' => 'Other',
		'B02001_008E' => 'Two or more');

	protected static $GROUPS = array(
		#Group Name => comma delimited list of column identifiers for the group
		#(an identifier is a string that matches values in $MAP that are part of the group,
		#and does not match any $MAP values outside of the group)
		'Total' => 'Total',
		'White' => 'White',
		'Black' => 'Black',
		'Native American' => 'Native American',
		'Asian' => 'Asian',
		'Pacific Islander' => 'Pacific Islander',
		'Other' => 'Other',
		'Two or more' => 'Two or more');
}

class ACSEducationalAttainmentMap extends ACSGenericTableMap{

	protected static $MAP = array(
		#ACS Column Code => Plain English Column Name
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
		'B15003_025E' => 'Doctorate');

	protected static $GROUPS = array(
		#Group Name => comma delimited list of column identifiers for the group
		#(an identifier is a string that matches values in $MAP that are part of the group,
		#and does not match any $MAP values outside of the group)
		'Total' => 'Total',
		'Less than 9th grade' => 'None,Nursery,Kindergarten,1st,2nd,3rd,4th,5th,6th,7th,8th',
		'9th to 12th grade, no diploma' => '9th,10th,11th,12thNoDiploma',
		'High school graduate (incl. equivalency)' => 'HSDiploma,GED',
		'Some college, no degree' => '<1yrCollege,>1yrCollegeNoDegree',
		'Associate degree' => 'Associates',
		'Bachelor\'s degree' => 'Bachelors',
		'Graduate or professional degree' => 'Masters,Professional,Doctorate');
}

class ACSGINIMap extends ACSGenericTableMap{

	protected static $MAP = array(
		#ACS Column Code => Plain English Column Name
		'B19083_001E' => 'GINIIndex');

	protected static $GROUPS = array(
		#Group Name => comma delimited list of column identifiers for the group
		#(an identifier is a string that matches values in $MAP that are part of the group,
		#and does not match any $MAP values outside of the group)
		'GINI Index' => 'GINIIndex');
}
