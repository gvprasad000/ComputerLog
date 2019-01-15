<?php


function saveLogUser($logArrayList){

//---------------PageId Referes to All, Temp, Perm Customers in Quoting DB---------------------
	$logName=logDb();
	$JsonQuoteArrayDecode=json_decode($logArrayList,true);
		
		$qry_select="exec $logName.[save_Update_computer_log_user]
		".$JsonQuoteArrayDecode[User][log_user_id].",'".$JsonQuoteArrayDecode[User][LogFirstName].
		"','".$JsonQuoteArrayDecode[User][LogLastName]."','".$JsonQuoteArrayDecode[User][Email_id]."',
		'".$JsonQuoteArrayDecode[User][username]."','".$JsonQuoteArrayDecode[User][Domain]."',
		'".$JsonQuoteArrayDecode[User][location]."','".$JsonQuoteArrayDecode[User][log_user_phone]."','".
		$JsonQuoteArrayDecode[User][log_user_extension]."',".$JsonQuoteArrayDecode[User][log_user_internet];
		db_fetch_query($qry_select);
	
			
}

function saveLogMapDriveUser($logArrayList){
	$logName=logDb();
	$JsonQuoteArrayDecode=json_decode($logArrayList,true);
	if($JsonQuoteArrayDecode[MapDriveUser][log_mapdrive_name_id]=='')
		$MapDrive_id=0;
	else 
		$MapDrive_id=$JsonQuoteArrayDecode[MapDriveUser][log_mapdrive_name_id];
		
		if($JsonQuoteArrayDecode[MapDriveUser][log_mapdrive_new_name]!='')
			$mapDriveName=cleanUp($JsonQuoteArrayDecode[MapDriveUser][log_mapdrive_new_name]);
		else 
			$mapDriveName=$JsonQuoteArrayDecode[MapDriveUser][log_mapdrive_new_name];
	$qry_select="exec $logName.[save_Update_computer_log_UserMapDrive]".$JsonQuoteArrayDecode[MapDriveUser][log_intpk_user_map_drive_id].
		",".$MapDrive_id.",'".$mapDriveName.
		"',".$JsonQuoteArrayDecode[MapDriveUser][log_mapdrive_user_id].",".$JsonQuoteArrayDecode[MapDriveUser][log_map_drive_letter_id]."
		";
		db_fetch_query($qry_select);

}
function saveLogVpnUser($logArrayList){
	$logName=logDb();
		$JsonQuoteArrayDecode=json_decode($logArrayList,true);
	if($JsonQuoteArrayDecode[VpnUser][log_intpk_vpn_id]=='')
		$Vpn_id=0;
	else 
		$Vpn_id=$JsonQuoteArrayDecode[VpnUser][log_intpk_vpn_id];
		
		$qry_select="exec $logName.[save_Update_computer_log_UserVpn]".$Vpn_id.",".$JsonQuoteArrayDecode[VpnUser][log_vpn_user_id].",'".
		$JsonQuoteArrayDecode[VpnUser][log_user_vpn_desc]."'";

	$result=db_fetch_query($qry_select);
	
}
function getLogUsers($username){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user] where str_firstname like '%$username%'";
	$result=db_fetch_query($qry_select);

		return $result;
}
function getLogMapDrive($username){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user_map_drive] AS UMD 
	INNER JOIN $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=UMD.intfk_mapdrive_id
	INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UMD.intfk_user_id
	INNER JOIN $logName.[tbl_letter] AS L ON L.intpk_letter_id=UMD.infk_drive_letter
	where U.str_firstname like '%$username%'";
	$result=db_fetch_query($qry_select);


		
	for($cnt=0;$cnt<count($result);$cnt++){
		$result[$cnt]['str_link_desc']=cleanItem($result[$cnt]['str_link_desc']);
	}
		return $result;
}
function getLogSelectedUser($userid){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user] where intpk_user_id=".$userid;
		/*require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		$firephp->log($qry_select);*/
	if($userid==''){
		return null;
	}else{
		$result=db_fetch_query($qry_select);
		return $result;
	}
}
function deleteLogSelectedUser($userid){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_user] where intpk_user_id=".$userid;
	if($userid!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 1,$userid";
		$result=db_fetch_query($qry_select);
	}
}
function deleteLogSelectedUserMappedDrive($intpk_user_Mapped_drive_id){
$logName=logDb();
	$qry_select="delete from $logName.[tbl_user_map_drive] where intpk_user_map_drive_id=".$intpk_user_Mapped_drive_id;

	if($intpk_user_Mapped_drive_id!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 3,$intpk_user_Mapped_drive_id";
		$result=db_fetch_query($qry_select);
	}
}
function deleteLogSelectedUserVpn($vpnId){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_vpn] where intpk_vpn_id=".$vpnId;
	
	if($vpnId!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 4,$vpnId";
		$result=db_fetch_query($qry_select);
	}
	
}
function getAllUsers(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user]";
	$result=db_fetch_query($qry_select);
		return $result;
}
function  getAllMapDrives(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_map_drive]";
	$result=db_fetch_query($qry_select);
	for($cnt=0;$cnt<count($result);$cnt++){
		$result[$cnt]['str_link_desc']=cleanItem($result[$cnt]['str_link_desc']);
	}
		return $result;
}

function getAllLetters(){
		$logName=logDb();
	$qry_select="select * from $logName.[tbl_letter]";
	$result=db_fetch_query($qry_select);
		return $result;
}

function getSelectedlogMapdrive($mapdriveId){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_map_drive] where intpk_map_drive_id=".$mapdriveId;
	$result=db_fetch_query($qry_select);
		return $result;
}
function getLogSelectedUserMapDrive($usermapdriveId){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user_map_drive] where intpk_user_map_drive_id=".$usermapdriveId;
	$result=db_fetch_query($qry_select);
		return $result;
}
function userMapDriverLetters($userid){
	$logName=logDb();
	$qry_select=" select  L.* from [ComputerLog].[dbo].[tbl_letter] AS L  where L.intpk_letter_id NOT IN(
  select infk_drive_letter from [ComputerLog].[dbo].[tbl_user_map_drive] AS UMD where UMD.intfk_user_id=$userid)
 ";
	$result=db_fetch_query($qry_select);
		return $result;
}
function getVpnSearchDialoge($username){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_vpn] AS vpn 	
	INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=vpn.intfk_user_id
	where U.str_firstname like '%$username%'";
	$result=db_fetch_query($qry_select);
		return $result;
}
function getLogSelectedVpn($vpnId){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_vpn] where intpk_vpn_id=".$vpnId;
	$result=db_fetch_query($qry_select);
		return $result;
}

function test(){
	
	require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		
	$logName=logDb();
	$qry_select="SELECT *
  		FROM [test_pms].[dbo].[tbl_screen_items]";
	$result=db_fetch_query($qry_select);
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Name</th>  
                         <th>Address</th>  
                         <th>City</th>  
       <th>Postal Code</th>
       <th>Country</th>
                    </tr>
  ';
  $size=count($result);
  for($cnt=0;$cnt<$size;$cnt++)
  {
   $output .= '
    <tr>  
                         <td>'.$result[$cnt]['str_item_name'].'</td>  
                         <td>'.$result[$cnt]['str_item_name'].'</td>  
                         <td>'.$result[$cnt]['str_item_name'].'</td>  
       <td>'.$row["PostalCode"].'</td>  
       <td>'.$row["Country"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;

}
?>




