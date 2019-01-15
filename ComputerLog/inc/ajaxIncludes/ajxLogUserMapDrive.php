<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
require_once ('../incLogUserMapDrive.php');
$logArrayList='';
$username='';
$userId='';
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

	
}

?>