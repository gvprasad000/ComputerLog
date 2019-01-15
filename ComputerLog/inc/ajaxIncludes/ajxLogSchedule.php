<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogSchedule.php');
$logArrayList='';

$mode='';

 $postdata = file_get_contents("php://input");
 $request = json_decode($postdata);
 foreach ( $request as $str_key=>$str_item ) {
 	//include_once "inc/incIncludeJS.php";
		eval("\$$str_key = '". addcslashes(cleanItem($str_item),"'") ."';");
		
	}

switch($mode)
{
	
	case 'SaveLogSchedule':
		ob_get_clean ();
		SaveLogSchedule($logArrayList);	
		break;
		
	case 'LogScheduleSearch':
		ob_get_clean ();
		$result=logScheduleSearch($intfk_item_id);	
		echo json_encode($result);
		break;
	
	case 'LogScheduleSearchSelectedItem':
		ob_get_clean ();
		$result=logScheduleSearchSelectedItem($intpk_schedule_id);	 
		echo json_encode($result);
		break;
		
	
		  
}

?>