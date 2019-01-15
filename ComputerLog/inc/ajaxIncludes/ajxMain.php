<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogMain.php');
$logArrayList='';

$mode='';
require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);

 $postdata = file_get_contents("php://input");
 $request = json_decode($postdata);
 foreach ( $request as $str_key=>$str_item ) {
 	//include_once "inc/incIncludeJS.php";
		eval("\$$str_key = '". addcslashes(cleanItem($str_item),"'") ."';");
		
	}

switch($mode)
{

	case 'LogGetAllProblems':
			ob_get_clean ();
			$result=logGetAllProblems();
			echo json_encode($result); 
		break;

	case 'LogChangeActiveStatus':
			ob_get_clean ();
			logChangeActiveStatus($intpk_problem_history_id,$bln_active_status);	
		break;	
		
	case 'LogGetScheduleDays':
		ob_get_clean ();
		$result=logGetScheduleDays();	
		echo json_encode($result); 
		break;
		
	case 'LogGetScheduleWeeks':
		ob_get_clean ();
		$result=logGetScheduleWeeks();	
		echo json_encode($result); 
		break;
	
	case 'LogGetScheduleMonths':
		ob_get_clean ();
		$result=logGetScheduleMonths();	
		echo json_encode($result); 
		break;
}

?>