<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogUser.php');
$logArrayList='';
$username='';
$userId='';
$intpk_user_Mapped_drive_id='';
$mapdriveId='';
$userMapDriveId='';
$vpnId='';
$vpn_id='';
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
	

	case 'saveLogUser':
		ob_get_clean ();
		saveLogUser($logArrayList);		
		break;
		
	case 'getDatabase':
		ob_get_clean ();
		$result=logDb();
		echo json_encode($result);
		break;
	case 'getLogUsers':
		ob_get_clean ();
		$result=getLogUsers($username);
		echo json_encode($result);
		break;
				
	case 'getLogSelectedUser':
		ob_get_clean ();
		$result=getLogSelectedUser($userId);
		echo json_encode($result);
		break;
	case 'deleteLogSelectedUser':
		ob_get_clean ();
		deleteLogSelectedUser($userId);
		
		break;
			
	case 'deleteLogSelectedUserMappedDrive':
		ob_get_clean ();
		deleteLogSelectedUserMappedDrive($intpk_user_Mapped_drive_id);
		break;	
	case 'deleteLogSelectedUserVpn':
		ob_get_clean ();
		deleteLogSelectedUserVpn($vpn_id);	
		break;
	
	case 'getLogMapDrive':
		ob_get_clean ();
		$result=getLogMapDrive($username);
		echo json_encode($result);
		break;
		
		
	case 'getAllUsers':
		ob_get_clean ();
		$result=getAllUsers();	
		echo json_encode($result);	
		break;
		
	case 'getAllMapDrives':
		ob_get_clean ();
		$result=getAllMapDrives();	
		echo json_encode($result);	
		break;
	case 'getAllLetters':
		ob_get_clean ();
		$result=getAllLetters();	
		echo json_encode($result);	
		break;
		
	case 'saveLogMapDriveUser':
		ob_get_clean ();
		saveLogMapDriveUser($logArrayList);		
		break;
		
	case 'getSelectedlogMapdrive':
		ob_get_clean ();
		$result=getSelectedlogMapdrive($mapdriveId);	
		echo json_encode($result);	
		break;
	
	case 'getLogSelectedUserMapDrive':
		ob_get_clean ();
		$result=getLogSelectedUserMapDrive($userMapDriveId);	
		echo json_encode($result);	
		break;	
	case 'userMapDriverLetters':
		ob_get_clean ();
		$result=userMapDriverLetters($userId);
		echo json_encode($result);	
		break;	
		
	case 'saveLogVpnUser':
		ob_get_clean ();
		$result=saveLogVpnUser($logArrayList);
		echo json_encode($result);	
		break;
	case 'getVpnSearchDialoge':
		ob_get_clean ();
		$result=getVpnSearchDialoge($username);
		echo json_encode($result);	
		break;	
	case 'getLogSelectedVpn':
		ob_get_clean ();
		$result=getLogSelectedVpn($vpnId);
		echo json_encode($result);	
		break;
	
	case 'test':
			ob_get_clean ();
		test();
			
		break;
		
}

?>