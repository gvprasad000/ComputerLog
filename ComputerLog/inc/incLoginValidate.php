<?php
session_start();
?>
<?php
include_once "inc/incLoginValidate.php";
function alertmeLogout(){
if($_SESSION['sess']==''){
	echo "
	            <script type=\"text/javascript\">
	           window.location.href = 'index.php';
	            </script>
	        ";
	}
else
	echo $_SESSION['sess'];
}
function validate($user_name,$password){
	$str_server_ip=$_SERVER['SERVER_ADDR'];
	$connection=fnc_db_connect($user_name,$password);
	return $connection;
}
function fnc_db_connect($user_name,$password)
{
#Start buffering the output. Not required if output_buffering is set on in php.ini file

#get a firePHP variable reference
# we log today’s date as an example. you could log whatever variable you want to

	/*$dbUser = "ccerpUser";
	$dbPass = "highlander";
	$choose_db = 0;
	
	switch ( $_SERVER['SERVER_ADDR'] ) {
		case "127.0.0.1":
		case "192.168.99.160":  
		case "192.168.99.144":       #RFERG APACHE SERVER ADDRESS - TEST SYSTEM.
		case "::1":
			$strHost = "192.168.99.90";
			$strData = "test_pms";
			break;
			
		default:
			$strHost = $_SERVER['SERVER_ADDR'];
			$strData = "PMS";
			break;
			    
	}
	    $connectionInfo = array( "Database"=>$strData, "UID"=>$dbUser, "PWD"=>$dbPass, 'ReturnDatesAsStrings'=>true);
	    $conn=sqlsrv_connect($strHost, $connectionInfo) or 
		        WriteError($query, fnc_db_get_error(),$blnReconnect);	*/
		$qry_select="SELECT TOP 1 tbl_user_erp.*
  					 FROM tbl_user_erp 
  					  WHERE user_name='$user_name' AND password='$password' AND is_active=1 
  					  AND is_admin=1";
		$result=db_fetch_query($qry_select);
	    if($result[0][user_name]!=''){
	    //	while( $arrRows=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
				if($result[0][user_name]!='' && $result[0][password]!=''){	
					$session_id = substr(md5(uniqid(mt_rand(), true)) , 0, 8);					
				
					//$_SESSION['connection_string']=$conn;
					$_SESSION['sess']=$session_id;
					setcookie('LogUserList', serialize($result[0]),0,'/');
					setcookie("LogCstName",$result[0][user_name],time()+60,'/');
					setcookie("LogCstPass",$result[0][password],time()+60,'/');
					return true;				
				}else{
					return false;	
				}	
			//}
	     }else{
	     	return false;	
	     }
}

function getDbParam(){
	switch ( $_SERVER['SERVER_ADDR'] ) {
			case "127.0.0.1":
			case "192.168.99.154":  
			case "192.168.99.144":       #RFERG APACHE SERVER ADDRESS - TEST SYSTEM.
			 case "192.168.99.104":
			case "::1":
			
				//$strHost = "test.chst4gtgzv4v.us-west-2.rds.amazonaws.com";
				//$strData = "Quoting";
				$strHost = "192.168.99.90";
				$strData = "test_pms";
				break;
				
			default:
				$strHost = $_SERVER['SERVER_ADDR'];
				$strData = "PMS";
				break;	
		}
		$strData1[0] = $strHost;
		$strData1[1] = $strData;
		return $strData1;
}
function getConnectionSrtings(){
	//$dbUser = "gvprasad";
	//$dbPass = "vgovCMT123";
	//$dbUser = "sa";
	//$dbPass = "Test123#";
	$dbUser = "ccerpUser";
	$dbPass = "highlander";
	$choose_db = 0;
	$strData=getDbParam();
	    $connectionInfo = array( "Database"=>$strData[1], "UID"=>$dbUser, "PWD"=>$dbPass, 'ReturnDatesAsStrings'=>true);
	   
	return $connectionInfo;
}
function logDb(){
	if( $_SERVER['SERVER_ADDR']=='192.168.99.154' || $_SERVER['SERVER_ADDR']=='192.168.99.90')
		$dbName="[ComputerLog].[dbo]";
	else 
		$dbName="[ComputerLog].[dbo]";
	//$dbName="[Quoting].[dbo]";
	return $dbName;
}

function userData($user_name){
	
	$qry_select="SELECT *
  					 FROM tbl_user_erp 
  					 WHERE user_name='$user_name'  ";
		$result=db_fetch_query($qry_select);
		return $result;
}
function userDataByEmail($email){   
	$qry_select="SELECT *
  					 FROM tbl_user_erp 
  					  INNER JOIN
  						tbl_screen_permissions AS SP ON SP.intfk_user_id=tbl_user_erp.[user_id]
  					  INNER JOIN  
  						tbl_plant AS P ON P.intpk_plant_id=SP.intfk_plant_id
  					 WHERE  (SP.[intfk_screen_item_id]=733 OR SP.[intfk_screen_item_id]=734)
  					    AND SP.int_permission=1 AND email='$email'  ";
		$result=db_fetch_query($qry_select);
		return $result;
}
function UpdateUserPlant($plant_id,$user_id){
		$qry_select="update tbl_user_erp SET intfk_user_plant_id=".$plant_id." where user_id=".$user_id;		
		$result=db_fetch_query($qry_select);
		
		$qry_select="SELECT TOP 1 tbl_user_erp.*,SP.*
  					 FROM tbl_user_erp INNER JOIN
  						tbl_screen_permissions AS SP ON SP.intfk_user_id=tbl_user_erp.[user_id]
  					  WHERE user_id='$user_id' AND is_active=1 
  					   AND (SP.[intfk_screen_item_id]=733 OR SP.[intfk_screen_item_id]=734)
  					    AND SP.int_permission=1";
		$result=db_fetch_query($qry_select);
		 unset($_COOKIE['UserList']);
		setcookie('LogUserList', serialize($result[0]),0,'/');
}

function logDashBoardAlertsService(){
		$logName=logDb();	
	$qry_select="  select Top 10 * from $logName.[tbl_problem_history] AS PH 
  				INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=PH.intfk_all_item_id
  				INNER JOIN $logName.[tbl_item_type] AS IT ON IT.intpk_item_type_id=AI.intfk_item_id
  				INNER JOIN $logName.[tbl_history_type] AS HT ON HT.intpk_history_type=PH.intfk_history_type_id
  				LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
  				where bln_pblm=1
 				 order by dte_problem_occured desc ";
	$result=db_fetch_query($qry_select);
	return $result;
}
?>

			 