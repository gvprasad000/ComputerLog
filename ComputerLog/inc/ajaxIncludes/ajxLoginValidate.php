<?php

require_once ('../incIncludeJS.php');
require_once ('../incLoginValidate.php');
$user_name='';
$password='';
$email='';
$mode='';
$plant_id='';
$user_id='';


 $postdata = file_get_contents("php://input");
 $request = json_decode($postdata);
 foreach ( $request as $str_key=>$str_item ) {
 	//include_once "inc/incIncludeJS.php";
		eval("\$$str_key = '". addcslashes(cleanItem($str_item),"'") ."';");
		
	}

switch($mode)
{
	case 'ValidateLogin': 
		$connection= validate($user_name,$password);	
		ob_get_clean ();
		if($connection)
			 echo 'True';
		else 
			 echo 'False';
			//echo json_encode($arr_list);
	break;
	
	case 'UserData':
		ob_get_clean ();
			$userData= userData($user_name);
			echo json_encode($userData);
		break;
			

	case 'UpdateUserPlant':
		ob_get_clean ();
		UpdateUserPlant($plant_id,$user_id);
		
		break;
	case 'LogOut':
		ob_get_clean ();
		$_SESSION['sess']='';
		break;
		
	case 'getDatabase':
		ob_get_clean ();
		$result=logDb();
		echo json_encode($result);
		break;

	case 'logDashBoardAlertsService':
		ob_get_clean ();
		$result=logDashBoardAlertsService();
		echo json_encode($result);
		break;
		
	
}

?>