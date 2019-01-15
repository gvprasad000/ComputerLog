<?php

		
function saveLogHardwareType($logArrayList){
	$logName=logDb();
	$JsonHardwareArrayDecode=json_decode($logArrayList,true);
	$qry_select="exec $logName.[save_update_computer_log_type]".$JsonHardwareArrayDecode[HardwareType][intpk_hardware_type_id].",'".
	$JsonHardwareArrayDecode[HardwareType][log_hardware_type_name]."'";
	$result=db_fetch_query($qry_select);
		
}
function saveLogHardwareComponent($logArrayList){
	$logName=logDb();
	$JsonHardwareArrayDecode=json_decode($logArrayList,true);
	$qry_select="exec $logName.[save_update_computer_log_component]".$JsonHardwareArrayDecode[HardwareComponentList][intpk_component_id].",'".
	$JsonHardwareArrayDecode[HardwareComponentList][log_hardware_component_name]."'";
	$result=db_fetch_query($qry_select);
}

function saveLogHardware($logArrayList){
		require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
	/*
	 intpk_hardware_id':$scope.intpk_hardware_id,'log_hardware_type':$scope.log_hardware_type_copy,
						'log_hardware_plant_id':$scope.log_hardware_plant,'log_hardware_service_tag':$scope.log_hardware_service_tag,
						'log_hardware_system_id':$scope.log_hardware_system_id,'log_hardware_active':$scope.log_hardware_active,
						'log_hardware_serial_no':$scope.log_hardware_serial_no,'log_hardware_rdp':$scope.log_hardware_rdp,
						'log_hardware_tcmp':$scope.log_hardware_tcmp 
	 */
	$logName=logDb();
	$JsonHardwareArrayDecode=json_decode($logArrayList,true);
	
 //-----------------------------------Save for Hardware ---------------------------
 
	if($JsonHardwareArrayDecode[HardwareList][log_hardware_active]=='' || $JsonHardwareArrayDecode[HardwareList][log_hardware_active]==null)
		$active=0;
	else 
		$active=$JsonHardwareArrayDecode[HardwareList][log_hardware_active];	
	if($JsonHardwareArrayDecode[HardwareList][log_hardware_rdp]=='' || $JsonHardwareArrayDecode[HardwareList][log_hardware_rdp]==null)
		$rdp=0;
	else 
		$rdp=$JsonHardwareArrayDecode[HardwareList][log_hardware_rdp];	
	if($JsonHardwareArrayDecode[HardwareList][log_hardware_tcmp]=='' || $JsonHardwareArrayDecode[HardwareList][log_hardware_tcmp]==null)
		$tcmp=0;
	else 
		$tcmp=$JsonHardwareArrayDecode[HardwareList][log_hardware_tcmp];		
	
	
	$qry_select="exec $logName.[save_update_computer_log_hardware]".$JsonHardwareArrayDecode[HardwareList][intpk_hardware_id].",".
	$JsonHardwareArrayDecode[HardwareList][log_hardware_type].",".$JsonHardwareArrayDecode[HardwareList][log_hardware_plant_id].",'".
	$JsonHardwareArrayDecode[HardwareList][log_hardware_service_tag]."','".$JsonHardwareArrayDecode[HardwareList][log_hardware_system_id]."',".
	$active.",'".$JsonHardwareArrayDecode[HardwareList][log_hardware_serial_no]."',".$rdp.",".$tcmp.",'".$JsonHardwareArrayDecode[HardwareList][log_system_name]."','".
	$JsonHardwareArrayDecode[HardwareList][log_admin_pswd]."'";
	$result=db_fetch_query($qry_select);
	
 //----------------------Save for Hardware components Address---------------------------
 
	$qry_select="select intpk_hardware_id from $logName.[tbl_hardware] where str_system_id='".$JsonHardwareArrayDecode[HardwareList][log_hardware_system_id]."'";
	$result=db_fetch_query($qry_select);
	
		$size=sizeof($JsonHardwareArrayDecode[HardwareCompAdd]);
		$firephp->log($size);
		$firephp->log($JsonHardwareArrayDecode);
		if($result[0]['intpk_hardware_id']!=NULL && $result[0]['intpk_hardware_id']!='null' && $result[0]['intpk_hardware_id']!='')
			$intfk_hardware_id=$result[0]['intpk_hardware_id'];
		else 
			$intfk_hardware_id=0;
	for($cnt=0;$cnt<$size;$cnt++){
		$qry_select="exec $logName.[save_update_computer_log_hardware_components]".$intfk_hardware_id.",".
		$JsonHardwareArrayDecode[HardwareCompAdd][$cnt][intfk_comp_id].",'".$JsonHardwareArrayDecode[HardwareCompAdd][$cnt][str_comp_desc]."'";
		$firephp->log($qry_select);
		$result=db_fetch_query($qry_select);
	}
	
 //--------------------------------------Save for Hardware Ip Address---------------------------
	
	$size=sizeof($JsonHardwareArrayDecode[HardwareIpAddress]);
	for($cnt=1;$cnt<=$size;$cnt++){
		$qry_select="exec $logName.[save_update_computer_log_hardware_ip_address]".$JsonHardwareArrayDecode[HardwareIpAddress][$cnt][intpk_ip_address].",".$intfk_hardware_id.",'".
		$JsonHardwareArrayDecode[HardwareIpAddress][$cnt][log_HW_Ip_desc]."','".$JsonHardwareArrayDecode[HardwareIpAddress][$cnt][log_HW_Ip_address]."'";
		$result=db_fetch_query($qry_select);
	}
	
//--------------------------------------Save For Software Records-------------------------------
	$size=count($JsonHardwareArrayDecode[SoftwareMapping]);
	
	for($cnt=0;$cnt<$size;$cnt++){
		if($JsonHardwareArrayDecode[SoftwareMapping][$cnt][intpk_hardware_software_id]=='' || $JsonHardwareArrayDecode[SoftwareMapping][$cnt][intpk_hardware_software_id]==null)
			$intpk_hardware_software_id=0;
		else 
			$intpk_hardware_software_id=$JsonHardwareArrayDecode[SoftwareMapping][$cnt][intpk_hardware_software_id];
		
		
		$qry_select="exec $logName.[save_update_computer_log_hardware_software]".$intpk_hardware_software_id.",".$JsonHardwareArrayDecode[SoftwareMapping][$cnt][intfk_software_record_id].",".
		$intfk_hardware_id.",'".$JsonHardwareArrayDecode[SoftwareMapping][$cnt][str_licence_no]."'";
		
		$result=db_fetch_query($qry_select);
	}
	//$qry_select="exec $logName.[save_update_computer_log_hardware_components]".$JsonHardwareArrayDecode[HardwareComp][intpk_hardware_id]
	
	/*require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		$firephp->log("Size=".$size);*/
}

function saveLogHardwarePeripheral($logArrayList){
	
	$logName=logDb();
	$JsonHardwareArrayDecode=json_decode($logArrayList,true);
	$size=sizeof($JsonHardwareArrayDecode[HardwarePeripheralConnectHW]);

	for($cnt=0;$cnt<$size;$cnt++){
		$qry_select="exec $logName.[save_update_computer_log_hardware_peripheral]".$JsonHardwareArrayDecode[HardwarePeripheral][intfk_hardware_main_id].",".
		$JsonHardwareArrayDecode[HardwarePeripheralConnectHW][$cnt][intpk_hardware_id];
		$result=db_fetch_query($qry_select);
	}
}

function saveLogHardwareUser($logArrayList){
		require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
	$logName=logDb();
	$JsonHardwareArrayDecode=json_decode($logArrayList,true);
	$qry_select="exec $logName.[save_update_computer_log_hardware_user]".$JsonHardwareArrayDecode[HardwareUser][intpk_hardware_user].",".
		$JsonHardwareArrayDecode[HardwareUser][log_hardware_user_hardware].",".$JsonHardwareArrayDecode[HardwareUser][log_hardware_user_user].",'".
		$JsonHardwareArrayDecode[HardwareUser][log_hardware_user_password]."','".
		$JsonHardwareArrayDecode[HardwareUser][log_user_hardware_printer]."'";
	$result=db_fetch_query($qry_select);
	
	$size=sizeof($JsonHardwareArrayDecode[HardwareUserAll]);
	for($cnt=0;$cnt<$size;$cnt++){
		$qry_select="select * from $logName.[tbl_user_hardware] where intfk_hardware_id=".$JsonHardwareArrayDecode[HardwareUser][log_hardware_user_hardware]." AND 
						intfk_user_id=".$JsonHardwareArrayDecode[HardwareUserAll][$cnt][intpk_user_id];
		$result=db_fetch_query($qry_select);
		if($result[0]['intpk_user_hardware_id']==''){
			$qry_select="insert into $logName.[tbl_user_hardware](intfk_hardware_id,intfk_user_id) values(".$JsonHardwareArrayDecode[HardwareUser][log_hardware_user_hardware].",".$JsonHardwareArrayDecode[HardwareUserAll][$cnt][intpk_user_id].")";
			$result=db_fetch_query($qry_select);
			$qry_select="select intpk_user_hardware_id from $logName.[tbl_user_hardware] where intfk_hardware_id=".$JsonHardwareArrayDecode[HardwareUser][log_hardware_user_hardware]." AND 
						intfk_user_id=".$JsonHardwareArrayDecode[HardwareUserAll][$cnt][intpk_user_id];
			$result=db_fetch_query($qry_select);
			$intpk_user_hardware_id=$result[0]['intpk_user_hardware_id'];
			
			$qry_select="insert into $logName.[tbl_all_item](intfk_item_id,intfk_item_type_id) values(11,".$intpk_user_hardware_id.")";
			$result=db_fetch_query($qry_select);
		}
	}
	
}

function getHardwareTypes($HardwareTypeDesc){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_hardware_type] where str_hardware_desc like '%$HardwareTypeDesc%'";
	$result=db_fetch_query($qry_select);
		return $result;
}
function getSelectedHardwareTypes($HardwareTypeId){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_hardware_type] where intpk_hardware_type_id=".$HardwareTypeId;
	$result=db_fetch_query($qry_select);
		return $result;
}
function getSelectedHardwareComponent($HardwareComponentId){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_component] where intpk_component_id=".$HardwareComponentId;
	$result=db_fetch_query($qry_select);
		return $result;
}
function deleteSelectedHardwareTypes($HardwareTypeId){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_hardware_type] where intpk_hardware_type_id=".$HardwareTypeId;
	if($HardwareTypeId!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 5,$HardwareTypeId";
		$result=db_fetch_query($qry_select);
	}	
}
function deleteSelectedHardwareComponent($HardwareComponentId){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_component] where intpk_component_id=".$HardwareComponentId;
	if($HardwareComponentId!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 6,$HardwareComponentId";
		$result=db_fetch_query($qry_select);
	}
}

function deleteHardwareIp($intpk_ip_address){
$logName=logDb();
	$qry_select="delete from $logName.[tbl_ip_address] where intpk_ip_address_id=".$intpk_ip_address;
	if($intpk_ip_address!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 9,$intpk_ip_address";
		$result=db_fetch_query($qry_select);
	}
}

function deleteHardwareUser($intpk_user_hardware_id){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_user_hardware] where intpk_user_hardware_id=".$intpk_user_hardware_id;
	if($intpk_user_hardware_id!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 11,$intpk_user_hardware_id";
		$result=db_fetch_query($qry_select);
	}
}

function deleteHardwareComponent($intfk_hardware_id,$intfk_component_id){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_hardware_component] where intfk_hardware_id=".$intfk_hardware_id." AND infk_component_id=".$intfk_component_id;
	if($intfk_hardware_id!='' && $intfk_component_id!=''){
		$qry_select2="select intpk_hardware_component_id from $logName.[tbl_hardware_component] where intfk_hardware_id=".$intfk_hardware_id." AND infk_component_id=".$intfk_component_id;
		$result=db_fetch_query($qry_select2);
		$intpk_hardware_component_id=$result[0]['intpk_hardware_component_id'];
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 8,$intpk_hardware_component_id";
		$result=db_fetch_query($qry_select);
	}
}

function deleteHardwareSoftwareItem($intfk_hardware_id,$intfk_software_record_id){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_hardware_software] where intfk_hardware_id=".$intfk_hardware_id." AND intfk_software_record_id=".$intfk_software_record_id;
	if($intfk_hardware_id!='' && $intfk_software_record_id!=''){
		$qry_select2="select intpk_hardware_software_id from $logName.[tbl_hardware_software] where intfk_hardware_id=".$intfk_hardware_id." AND intfk_software_record_id=".$intfk_software_record_id;
		$result=db_fetch_query($qry_select2);
		$intpk_hardware_software_id=$result[0]['intpk_hardware_software_id'];
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 14,$intpk_hardware_software_id";
		$result=db_fetch_query($qry_select);
	}
}

function deleteHardwareSelectedUser($intfk_hardware_id,$intfk_user_id){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_user_hardware] where intfk_hardware_id=".$intfk_hardware_id." AND intfk_user_id=".$intfk_user_id;
	if($intfk_hardware_id!='' && $intfk_user_id!=''){
		$qry_select2="select intpk_user_hardware_id from $logName.[tbl_user_hardware] where intfk_hardware_id=".$intfk_hardware_id." AND intfk_user_id=".$intfk_user_id;
		$result=db_fetch_query($qry_select2);
		$intpk_user_hardware_id=$result[0]['intpk_user_hardware_id'];
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 11,$intpk_user_hardware_id";
		$result=db_fetch_query($qry_select);
	}
}

function deleteHardwarePeripheralConnect($intfk_hardware_main_id,$intfk_hardware_connect_id){
$logName=logDb();
	$qry_select="delete from $logName.[tbl_hardware_peripheral] where intfk_hardware_main_id=".$intfk_hardware_main_id." AND intfk_hardware_connect_id=".$intfk_hardware_connect_id;
	if($intfk_hardware_main_id!='' && $intfk_hardware_connect_id!=''){
		$qry_select2="select intpk_hardware_peripheral_id from $logName.[[tbl_hardware_peripheral]] where intfk_hardware_main_id=".$intfk_hardware_main_id." AND intfk_hardware_connect_id=".$intfk_hardware_connect_id;
		$result=db_fetch_query($qry_select2);
		$intpk_hardware_peripheral_id=$result[0]['intpk_hardware_peripheral_id'];
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 10,$intpk_hardware_peripheral_id";
		$result=db_fetch_query($qry_select);
	}
}

function getAllHardwareComponents(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_component]";
	$result=db_fetch_query($qry_select);
		return $result;
}


function getHardwareComponents($HardwareComponentDesc){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_component] where str_component_name like '%$HardwareComponentDesc%'";
	$result=db_fetch_query($qry_select);
		return $result;
}

function getAllPlants(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_plant]";
	$result=db_fetch_query($qry_select);
		return $result;
}

function getHardwareSearch($str_system_id,$intfk_hardware_type_id,$intfk_hardware_comp_id,$intfk_hardware_software_id,$str_system_name){
	require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		
	$logName=logDb();
	$join="";
	if(($str_system_id!=null && $str_system_id!='' && $str_system_id!='null')
	|| ($intfk_hardware_type_id!=null && $intfk_hardware_type_id!='' && $intfk_hardware_type_id!='null')
	|| ($intfk_hardware_comp_id!=null && $intfk_hardware_comp_id!='' && $intfk_hardware_comp_id!='null')
	|| ($intfk_hardware_software_id!=null && $intfk_hardware_software_id!='' && $intfk_hardware_software_id!='null')
	|| ($str_system_name!=null && $str_system_name!='' && $str_system_name!='null'))
		$qry_where="where ";
	if($str_system_id!=null && $str_system_id!='' && $str_system_id!='null')
		$qry_where.="HW.str_system_id='$str_system_id' AND ";
	if($intfk_hardware_type_id!=null && $intfk_hardware_type_id!='' && $intfk_hardware_type_id!='null')
		$qry_where.="HW.intfk_hardware_type_id=$intfk_hardware_type_id AND ";
	if($intfk_hardware_comp_id!=null && $intfk_hardware_comp_id!='' && $intfk_hardware_comp_id!='null'){
		$qry_where.="HWC.infk_component_id=$intfk_hardware_comp_id AND ";
		$join="LEFT OUTER JOIN 	$logName.tbl_hardware_component AS HWC
			ON HWC.intfk_hardware_id=HW.intpk_hardware_id 
			LEFT OUTER JOIN 	$logName.tbl_component AS C 
			ON C.intpk_component_id=HWC.infk_component_id ";	
	}
	if($intfk_hardware_software_id!=null && $intfk_hardware_software_id!='' && $intfk_hardware_software_id!='null')	
		$qry_where.="HWSW.intfk_software_record_id=$intfk_hardware_software_id AND ";

	if($str_system_name!=null && $str_system_name!='' && $str_system_name!='null')
		$qry_where.="HW.str_system_name like '%$str_system_name%' AND ";
		
	$qry_where= substr($qry_where, 0, -4);
	
	$qry_select="select *,HW.str_serial_no as str_hw_serial_no from $logName.[tbl_hardware] AS HW INNER JOIN  $logName.tbl_hardware_type AS HWT
			ON HWT.intpk_hardware_type_id=HW.intfk_hardware_type_id
		$join
		INNER JOIN  $logName.tbl_plant AS P	
			ON P.intpk_plant_id=HW.intfk_plant_id
		LEFT OUTER JOIN $logName.tbl_hardware_software AS HWSW
			ON HWSW.intfk_hardware_id=HW.intpk_hardware_id
		LEFT OUTER JOIN $logName.tbl_software_record AS SWR
			ON SWR.intpk_software_record_id=HWSW.intfk_software_record_id
			$qry_where ORDER BY HW.intpk_hardware_id";
		$firephp->log($qry_select);
	$result=db_fetch_query($qry_select);
		return $result;
}

function getHardware($str_system_id){
	$logName=logDb();
	$qry_select="select *,HW.str_serial_no as str_hw_serial_no from $logName.[tbl_hardware] AS HW INNER JOIN  $logName.tbl_hardware_type AS HWT
			ON HWT.intpk_hardware_type_id=HW.intfk_hardware_type_id
		LEFT OUTER JOIN 	$logName.tbl_hardware_component AS HWC
			ON HWC.intfk_hardware_id=HW.intpk_hardware_id 
		LEFT OUTER JOIN 	$logName.tbl_component AS C 
			ON C.intpk_component_id=HWC.infk_component_id
		INNER JOIN  $logName.tbl_plant AS P	
			ON P.intpk_plant_id=HW.intfk_plant_id
			where HW.str_system_id like '%$str_system_id%' ORDER BY HWT.intpk_hardware_type_id";
	$result=db_fetch_query($qry_select);
		return $result;
}
function getSelectedHardwareIpAddress($intpk_hardware_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_ip_address] where intfk_hardware_id=".$intpk_hardware_id;
	$result=db_fetch_query($qry_select);
		return $result;
}
function getAllHardware(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_hardware] AS H INNER JOIN $logName.tbl_hardware_type As HT
	ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id";
	$result=db_fetch_query($qry_select);
		return $result;
}
function getSelectedHardwarePeripheral($intfk_hardware_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_hardware_peripheral] AS HP 
	INNER JOIN $logName.[tbl_hardware] as H on H.intpk_hardware_id=intfk_hardware_connect_id
	INNER JOIN $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=intfk_hardware_type_id
	where intfk_hardware_main_id=".$intfk_hardware_id;
	$result=db_fetch_query($qry_select);
		return $result;
}
function getlogHardwarePeripheralDialogsearch($intfk_hardware_id){
	$logName=logDb();
	$qry_select="   select HP.*,H1.str_system_id AS MainHwSystemId,
					   H2.str_system_id AS ConnectHwSystemId,HT1.str_hardware_desc AS MainHwType,
					   HT2.str_hardware_desc AS ConnectHwType
					   from $logName.[tbl_hardware_peripheral] AS HP 
					   INNER JOIN $logName.[tbl_hardware] AS H1
					   ON H1.intpk_hardware_id=HP.intfk_hardware_main_id 
					   INNER JOIN $logName.[tbl_hardware] AS H2
					   ON H2.intpk_hardware_id=HP.intfk_hardware_connect_id 
					   INNER JOIN $logName.[tbl_hardware_type] AS HT1
					   ON HT1.intpk_hardware_type_id=H1.intfk_hardware_type_id
					   INNER JOIN $logName.[tbl_hardware_type] AS HT2
					   ON HT2.intpk_hardware_type_id=H2.intfk_hardware_type_id
					   where intfk_hardware_main_id=".$intfk_hardware_id;
	$result=db_fetch_query($qry_select);
		return $result;
}

function logHardwarePeripheralDelete($intpk_peripheral_id){
$logName=logDb();
	$qry_select="delete from $logName.[tbl_hardware_peripheral] where intpk_hardware_peripheral_id=".$intpk_peripheral_id;
	if($intpk_peripheral_id!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 10,$intpk_peripheral_id";
		$result=db_fetch_query($qry_select);
	}
}

function getSelectedUserHardware($str_first_name,$str_system_name){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user] AS U INNER JOIN $logName.[tbl_user_hardware] AS UH
				ON UH.intfk_user_id=U.intpk_user_id INNER JOIN $logName.[tbl_hardware] AS H
				ON H.intpk_hardware_id=UH.intfk_hardware_id  INNER JOIN $logName.[tbl_hardware_type] AS HT 
				ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
				where U.str_lastname like '%$str_first_name%'  AND H.str_system_name like '%$str_system_name%' order by H.str_system_name";
	$result=db_fetch_query($qry_select);
	return $result;
}

function getLogDialogSelectedHardwareUser($intpk_user_hardware_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user_hardware] AS UH
	INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UH.intfk_user_id
	 where intfk_hardware_id=".$intpk_user_hardware_id;
	$result=db_fetch_query($qry_select);
	return $result;
}

function getSelectedHardwareUsers($intpk_hardware_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user_hardware] AS UH
	INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UH.intfk_user_id
 	where intfk_hardware_id=".$intpk_hardware_id;
	$result=db_fetch_query($qry_select);
	return $result;
}

function getUserHardwareData($intpk_hardware_id,$intpk_user_hardware_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user_hardware]
 	where intfk_hardware_id=".$intpk_hardware_id." AND intfk_user_id=".$intpk_user_hardware_id ;
	$result=db_fetch_query($qry_select);
	return $result;
}


?>




