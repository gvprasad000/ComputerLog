<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogHistoryProblem.php');
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

	case 'saveLogHistory':
			ob_get_clean ();
			saveLogHistory($logArrayList);	
		break;
		

	case 'LogHistroyTypeSearch':
			ob_get_clean ();
			$result=LogHistroyTypeSearch($log_histroy_type);
			echo json_encode($result); 
		break;
		
	case 'LogDeleteSelectedHistroyType':
			ob_get_clean ();
			$result=LogDeleteSelectedHistroyType($intpk_history_type);
			echo json_encode($result); 
		break;
	
	case 'logGetItemTable':
			ob_get_clean ();
			$result=logGetItemTable();
			echo json_encode($result); 
		break;
		
	case 'LogItemTypeselected':
			ob_get_clean ();
			$result=logItemTypeselected($intpk_item_type_id);
			echo json_encode($result); 
		break;
		
	case 'LogProblemType':
			ob_get_clean ();
			$result=logProblemType();
			echo json_encode($result); 
		break;
		
	case 'LogAllUser':
			ob_get_clean ();
			$result=logAllUser();
			echo json_encode($result); 
		break;
		
	case 'LogGetAllItemId':
			ob_get_clean ();
			$result=logGetAllItemId($intpk_problem_id,$intfk_problem_item_id);
			echo json_encode($result); 
		break;
		
	case 'saveLogProblems':
			ob_get_clean ();
			saveLogProblems($logArrayList);	
		break;
		
	case 'LogGetAllProblemsSearch':
			ob_get_clean ();
			$result=logGetAllProblemsSearch($intfk_item_id,$dte_start,$dte_end,$intfk_fixed_user);
			echo json_encode($result); 	
		break;
	case 'LogProblemSelectedItem': 
		ob_get_clean ();
		$result=logProblemSelectedItem($intpk_problem_history_id);
		echo json_encode($result); 
		break;
		
}

?>