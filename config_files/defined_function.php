<?php

/*****************************************************
functon to replace whitespace with hyphen symbol
for assigning table name in DataBase

argument	--> raja ram mohan , 20
return		--> raja_ram_mohan_20
******************************************************/
function find_indivisual_table_name($name_arg , $id_arg)
{
	for($i=0 ;$i<strlen($name_arg) ;$i++)
	{
		if($name_arg[$i] == " ")
			$name_arg[$i] = "_";
	}
	$name_string = $name_arg."_".$id_arg ;
	return strtolower($name_string);
}

/*****************************************************
functon to convert default date format into Human
Readable date format

argument	--> 2017-08-21
return		--> 21 Aug 2017
******************************************************/
function rearr_date($arg_date)
{
	$temp = date_create($arg_date);
	return date_format($temp,"d M Y");
}


/*****************************************************
functon to convert default date format into Human
Readable date format

argument	--> 2017-08-21
return		--> 21 Aug 2017
******************************************************/
function find_intermediate_year_month_array($beginning_date,$ending_date)
{
	$beginning_year  = explode('-',$beginning_date)[0];
	$beginning_month = explode('-',$beginning_date)[1];
	$ending_year  	 = explode('-',$ending_date)[0];
	$ending_month 	 = explode('-',$ending_date)[1];

	$i = 0;

	while ($ending_year-$beginning_year >=0 )
	{
		$ending_year-$beginning_year == 0 ? $month_limit=$ending_month : $month_limit=12 ;

		for($current_month=$beginning_month;$current_month<=$month_limit;$current_month++)
		{
			$arr[$i] = $beginning_year.'-'.sprintf('%02d',$current_month);
			$i++;
		}

		$beginning_year++;
		$beginning_month = 1;
	}
	return($arr);
}

?>
