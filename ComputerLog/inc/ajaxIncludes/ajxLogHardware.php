<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogHardware.php');
$logArrayList='';
$intpk_hardware_id='';
$HardwareTypeDesc='';
$HardwareTypeId='';
$HardwareComponentId='';
$HardwareComponentDesc='';
$str_system_id='';
$intpk_ip_address='';
$intpk_peripheral_id='';
$str_first_name='';
$intpk_user_hardware_id='';
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
	
	case 'saveLogHardwareType':
		ob_get_clean ();
		saveLogHardwareType($logArrayList);	
		break;
		
	case 'saveLogHardwareComponent':
		ob_get_clean ();
		saveLogHardwareComponent($logArrayList);	
		break;
		
	case 'saveLogHardware':
		ob_get_clean ();
		saveLogHardware($logArrayList);	
		break;
		
	case 'saveLogHardwarePeripheral':
		ob_get_clean ();
		saveLogHardwarePeripheral($logArrayList);	
		break;
		
	case 'saveLogHardwareUser':
		ob_get_clean ();
		saveLogHardwareUser($logArrayList);	
		break;
	
		
	case 'getHardwareTypes':
		ob_get_clean ();
		$result=getHardwareTypes($HardwareTypeDesc);	
		echo json_encode($result);	 
		break;

	case 'getAllHardwareComponents':
		ob_get_clean ();
		$result=getAllHardwareComponents();
		echo json_encode($result);	
		break;
	case 'getHardwareComponents':
		ob_get_clean ();
		$result=getHardwareComponents($HardwareComponentDesc);	
		echo json_encode($result);	 
		break;
		
	case 'getSelectedHardwareTypes':
		ob_get_clean ();
		$result=getSelectedHardwareTypes($HardwareTypeId);	
		echo json_encode($result);	 
		break;
		
	case 'getSelectedHardwareComponent':
		ob_get_clean ();
		$result=getSelectedHardwareComponent($HardwareComponentId);	
		echo json_encode($result);	 
		break;
	
	case 'deleteSelectedHardwareType':
		ob_get_clean ();
		deleteSelectedHardwareTypes($HardwareTypeId);	
		break;
	case 'deleteSelectedHardwareComponent':
		ob_get_clean ();
		deleteSelectedHardwareComponent($HardwareComponentId);	
		break;
	case 'getAllPlants':
		ob_get_clean ();
		$result=getAllPlants();	
		echo json_encode($result);	 
		break;
	case 'getHardwareSearch':
		ob_get_clean ();
		$result=getHardwareSearch($str_system_id,$intfk_hardware_type_id,$intfk_hardware_comp_id,$intfk_hardware_software_id,$str_system_name);		
		echo json_encode($result);	  
		break;
		
	case 'getHardware':
		ob_get_clean ();
		$result=getHardware($str_system_id);	 	
		echo json_encode($result);	  
		break;
			
	case 'getSelectedHardwareIpAddress':
		ob_get_clean ();
		$result=getSelectedHardwareIpAddress($intpk_hardware_id);	
		echo json_encode($result);	  
		break;
		
	case 'deleteHardwareIp':
		ob_get_clean ();
		$result=deleteHardwareIp($intpk_ip_address);	 
		break;
	case "getAllHardware":
		ob_get_clean ();
		$result=getAllHardware();	
		echo json_encode($result);	 
		break;
	case 'getSelectedHardwarePeripheral':
		ob_get_clean ();
		$result=getSelectedHardwarePeripheral($intpk_hardware_id);	
		echo json_encode($result);	 
		break;
	case 'getlogHardwarePeripheralDialogsearch':
		ob_get_clean ();
		$result=getlogHardwarePeripheralDialogsearch($intpk_hardware_id);	
		echo json_encode($result);	 
		break;
		
	case 'logHardwarePeripheralDelete':
		ob_get_clean ();
		$result=logHardwarePeripheralDelete($intpk_peripheral_id);	
		echo json_encode($result);	 
		break;
		
	case 'getSelectedUserHardware':
		ob_get_clean ();
		$result=getSelectedUserHardware($str_first_name,$str_system_name);	
		echo json_encode($result);	 
		break;

	case 'getLogDialogSelectedHardwareUser':
		ob_get_clean ();
		$result=getLogDialogSelectedHardwareUser($intpk_user_hardware_id);	
		echo json_encode($result);	 
		break;
		
	case 'DeleteHardwareUser':
		ob_get_clean ();
		deleteHardwareUser($intpk_user_hardware_id);
		break;
		
	case 'deleteHardwareComponent':
		ob_get_clean ();
		deleteHardwareComponent($intfk_hardware_id,$intfk_component_id);
		break;
		
	case 'deleteHardwareSoftwareItem':
		ob_get_clean ();
		deleteHardwareSoftwareItem($intfk_hardware_id,$intfk_software_record_id);
		break;	
		
	case 'deleteHardwareSelectedUser':
		ob_get_clean ();
		deleteHardwareSelectedUser($intfk_hardware_id,$intfk_user_id);
		break;
		
	case 'deleteHardwarePeripheralConnect':
		ob_get_clean ();
		deleteHardwarePeripheralConnect($intfk_hardware_main_id,$intfk_hardware_connect_id); 
		break;
		
	case 'getSelectedHardwareUsers':
		ob_get_clean ();
		$result=getSelectedHardwareUsers($intpk_hardware_id);
		echo json_encode($result);	 
		break;
	
	case 'getUserHardwareData':
		ob_get_clean ();
		$result=getUserHardwareData($intpk_hardware_id,$intpk_user_hardware_id);
		echo json_encode($result);	 
		break;
		
	
		
}

?>