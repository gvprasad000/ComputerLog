<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogSoftware.php');
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

	case 'saveLogSoftware':
			ob_get_clean ();
			saveLogSoftware($logArrayList);	
		break;
		
	case 'LogSoftwarefind':
			ob_get_clean ();
			$result=LogSoftwarefind($log_software_name);
			echo json_encode($result); 
		break;
		
	case 'LogSoftwareRecordDeleteItem':
			ob_get_clean ();
			LogSoftwareDeleteItem($intpk_software_record_id);
		break;	
	
	case 'LogSoftwareAll':
			ob_get_clean ();
			$result=LogSoftwareAll();
			echo json_encode($result);
		break;	
		
	case 'LogGetAllHardware':
			ob_get_clean ();
			$result=logGetAllHardware();
			echo json_encode($result);
		break;
		
	case 'LogGetAllSoftwareRecord':
		ob_get_clean ();
		$result=logGetAllSoftwareRecord();
		echo json_encode($result);
		break;
		
	case 'saveLogHarwareSoftwareMapping':
		ob_get_clean ();
		$result=saveLogHarwareSoftwareMapping($logArrayList);
		echo json_encode($result);
		break;
		
	case 'logMapHwSwSoftwareSearch':
		ob_get_clean ();
		$result=logMapHwSwSoftwareSearch($str_Hardware_system_id);
		echo json_encode($result);
		break;
		
		
	case 'logMapHwSwSoftwareSelectedItem':
		ob_get_clean ();
		$result=logMapHwSwSoftwareSelectedItem($intfk_hardware_id);
		echo json_encode($result);
		break;
				
	case 'logMapHwSwSoftwareRecordDelete':
		ob_get_clean ();
		$result=logMapHwSwSoftwareRecordDelete($intpk_hardware_software_id);
		echo json_encode($result);
		break;
		
		
}

?>