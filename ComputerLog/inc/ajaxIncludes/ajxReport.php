<?php
require_once ('../classes/clsPdf.php');
require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');

require_once ('../incLogReport.php');


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
 if($request!=null){ 
	 foreach ( $request as $str_key=>$str_item ) {
	 	//include_once "inc/incIncludeJS.php";
			eval("\$$str_key = '". addcslashes(cleanItem($str_item),"'") ."';");
			
		}
 }else{
  	 
	 if ( $_GET ) {
		foreach ( $_GET as $str_key=>$str_item ) {
			$str_item = addcslashes(cleanItem($str_item), "'");
			eval("\$$str_key = '$str_item';");
		}
	}
 }
switch($mode)
{
	

	case 'GetUserButton':
		ob_get_clean ();
		
		$result=GetUserButton();
		
		echo json_encode($result);	
		break;
	
	case 'getUserIp':
		//ob_get_clean ();
		require_once ('../reports/rptUserIp.php');
		getUserIp();
		break;
		
}

?>