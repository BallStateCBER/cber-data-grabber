<?php
include 'BEAGenericTableMap.php';

class BEAWageMap extends BEAGenericTableMap{
	protected static $DATASET = 'RegionalIncome';
	protected static $TABLE = 'CA5N';

	protected static $MAP = array(
			#BEA Line Code => Plain English Column Name
			'35' => 'Total Wages',
			'81' => 'Farming',
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
			'2000' => 'Government and Government Enterprises');

	protected static $GROUPS = array(
			#Group Name => comma delimited list of column identifiers for the group
			#(an identifier is a string that matches values in $MAP that are part of the group,
			#and does not match any $MAP values outside of the group)
			'Total Wages' => 'Total Wages',
			'Farming, Agriculture, and Mining' => 'Farming,Forestry,Mining',
			'Utility, Trade, and Transportation' => 'Utilities,Trade,Transportation',
			'Manufacturing' => 'Manufacturing',
			'Construction' => 'Construction',
			'Services' => 'Information,Finance,Real Estate,Technical,Management,Health,Arts,Accommodation',//Management incluldes both professional management and waste management
			'Government and Public Education' => 'Educational,Government',
			'Others' => 'Other');
}


class BEAEmploymentMap extends BEAGenericTableMap{
	protected static $DATASET = 'RegionalIncome';
	protected static $TABLE = 'CA25N';

	protected static $MAP = array(
			#BEA Line Code => Plain English Column Name
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
			'2000' => 'Government and Government Enterprises');

	protected static $GROUPS = array(
			#Group Name => comma delimited list of column identifiers for the group
			#(an identifier is a string that matches values in $MAP that are part of the group,
			#and does not match any $MAP values outside of the group)
			'Total Employment' => 'Total Employment',
			'Farming, Agriculture, and Mining' => 'Farming,Forestry,Mining',
			'Utility, Trade, and Transportation' => 'Utilities,Trade,Transportation',
			'Manufacturing' => 'Manufacturing',
			'Construction' => 'Construction',
			'Services' => 'Information,Finance,Real Estate,Technical,Management,Health,Arts,Accommodation',//Management incluldes both professional management and waste management
			'Government and Public Education' => 'Educational,Government',
			'Others' => 'Other');
}


class BEATransferPaymentBreakdownMap extends BEAGenericTableMap{
	protected static $DATASET = 'RegionalIncome';
	protected static $TABLE = 'CA35';

	protected static $MAP = array(
			#BEA Line Code => Plain English Column Name
			'1000' => 'Personal Current Transfer Receipts',
			'2100' => 'Retirement and Disability Insurance Benefits',
			'2200' => 'Medical Benefits',
			'2300' => 'Income Maintenance Benefits',
			'2400' => 'Unemployment Insurance Compensation',
			'2500' => 'Veterans Benefits',
			'2600' => 'Education and Training Assistance',
			'2700' => 'Other');

	protected static $GROUPS = array(
			#Group Name => comma delimited list of column identifiers for the group
			#(an identifier is a string that matches values in $MAP that are part of the group,
			#and does not match any $MAP values outside of the group)
			'Total' => 'Personal Current Transfer Receipts',
			'Retirement and Disability Insurance' => 'Retirement',
			'Medical' => 'Medical',
			'Income Maintenance' => 'Income Maintenance',
			'Other' => 'Unemployment,Veterans,Education,Other');
}


class BEATransferPaymentProportionMap extends BEAGenericTableMap{
	protected static $DATASET = 'RegionalIncome';
	protected static $TABLE = 'CA4';

	protected static $MAP = array(
			#BEA Line Code => Plain English Column Name
			'10' => 'Personal Income',
			'47' => 'Personal Current Transfer Receipts');

	protected static $GROUPS = array(
			#Group Name => comma delimited list of column identifiers for the group
			#(an identifier is a string that matches values in $MAP that are part of the group,
			#and does not match any $MAP values outside of the group)
			'Personal Income' => 'Income',
			'Personal Current Transfer Receipts' => 'Current');
}


class BEAWorkersCompMap extends BEAGenericTableMap{
	protected static $DATASET = 'RegionalIncome';
	protected static $TABLE = 'CA35';

	protected static $MAP = array(
			#BEA Line Code => Plain English Column Name
			'2120' => 'Retirement and Disability Insurance Benefits, Excluding Social Security');

	protected static $GROUPS = array(
			#Group Name => comma delimited list of column identifiers for the group
			#(an identifier is a string that matches values in $MAP that are part of the group,
			#and does not match any $MAP values outside of the group)
			'Workers Compensation' => 'Retirement');

}


class BEASocialOrgIncomeMap extends BEAGenericTableMap{
	protected static $DATASET = 'RegionalIncome';
	protected static $TABLE = 'CA5N';

	protected static $MAP = array(
			#BEA Line Code => Plain English Column Name
			'1903' => 'Income from Membership Associations and Organizations');

	protected static $GROUPS = array(
			#Group Name => comma delimited list of column identifiers for the group
			#(an identifier is a string that matches values in $MAP that are part of the group,
			#and does not match any $MAP values outside of the group)
			'Income from Social and Fraternal Organizations' => 'Income');
}
