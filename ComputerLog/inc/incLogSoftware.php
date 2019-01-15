<?php

function saveLogSoftware($logArrayList){
	require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
	$logName=logDb();
	$JsonSoftwareArrayDecode=json_decode($logArrayList,true);
	if($JsonSoftwareArrayDecode[Software][intpk_software_id]=='' || $JsonSoftwareArrayDecode[Software][intpk_software_id]==null)
		$intpk_software_id=0;
	else 
		$intpk_software_id=$JsonSoftwareArrayDecode[Software][intpk_software_id];

	if($JsonSoftwareArrayDecode[Software][intpk_software_record_id]=='' || $JsonSoftwareArrayDecode[Software][intpk_software_record_id]==null)
		$intpk_software_record_id=0;
	else 
		$intpk_software_record_id=$JsonSoftwareArrayDecode[Software][intpk_software_record_id];
	
	$qry_select="exec $logName.[save_update_computer_log_software]".$intpk_software_id.",".$intpk_software_record_id.",'".
	$JsonSoftwareArrayDecode[Software][log_software_name]."','".$JsonSoftwareArrayDecode[Software][log_software_desc]."','".$JsonSoftwareArrayDecode[Software][log_software_licence]."'";
	
	$result=db_fetch_query($qry_select);

}

function LogSoftwarefind($log_software_name){

	$logName=logDb();
	$qry_select="select * from $logName.[tbl_software] As SW INNER JOIN
				$logName.[tbl_software_record] As SWR  ON SW.intpk_software_id=SWR.intfk_software_id  
				where SW.str_software_name like '%$log_software_name%'";
	
	$result=db_fetch_query($qry_select);
	
	return $result;
}

function LogSoftwareDeleteItem($intpk_software_record_id){

$logName=logDb();
	$qry_select="delete from $logName.[tbl_software_record] where intpk_software_record_id=".$intpk_software_record_id;
	if($intpk_software_record_id!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 13,$intpk_software_record_id";
		$result=db_fetch_query($qry_select);

	}
}

function LogSoftwareAll(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_software]";
	$result=db_fetch_query($qry_select);
	return  $result;
}

function logGetAllHardware(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_hardware] as H
	INNER JOIN $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id";
	$result=db_fetch_query($qry_select);
	return  $result;
}

function logGetAllSoftwareRecord(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_software_record]";
	$result=db_fetch_query($qry_select);
	return  $result;
}

function saveLogHarwareSoftwareMapping($logArrayList){
require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
	$logName=logDb();
	$JsonSoftwareArrayDecode=json_decode($logArrayList,true);
	$size=count($JsonSoftwareArrayDecode[SoftwareMapping]);
	
	for($cnt=0;$cnt<$size;$cnt++){
		if($JsonSoftwareArrayDecode[SoftwareMapping][$cnt][intpk_hardware_software_id]=='' || $JsonSoftwareArrayDecode[SoftwareMapping][$cnt][intpk_hardware_software_id]==null)
			$intpk_hardware_software_id=0;
		else 
			$intpk_hardware_software_id=$JsonSoftwareArrayDecode[SoftwareMapping][$cnt][intpk_hardware_software_id];
		
		
		$qry_select="exec $logName.[save_update_computer_log_hardware_software]".$intpk_hardware_software_id.",".$JsonSoftwareArrayDecode[SoftwareMapping][$cnt][intfk_software_record_id].",".
		$JsonSoftwareArrayDecode[SoftwareMapping][$cnt][intfk_hardware_id].",'".$JsonSoftwareArrayDecode[SoftwareMapping][$cnt][str_licence_no]."'";
		$firephp->log($qry_select);
		$result=db_fetch_query($qry_select);
	}	
		
}

function logMapHwSwSoftwareSearch($str_Hardware_system_id){
	$logName=logDb();
	$qry_select="select *,HWSW.str_licence_no as licence_no from $logName.[tbl_hardware_software] As HWSW 
				  INNER JOIN $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HWSW.intfk_hardware_id 
				  INNER JOIN $logName.[tbl_hardware_type] As HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
				  INNER JOIN $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=HWSW.intfk_software_record_id
				  where H.str_system_id like '%$str_Hardware_system_id%'";
	$result=db_fetch_query($qry_select);
	return  $result;
}

function logMapHwSwSoftwareSelectedItem($intfk_hardware_id){
	$logName=logDb();
	$qry_select="select *,HWSW.str_licence_no as licence_no from $logName.[tbl_hardware_software] As HWSW 
				  INNER JOIN $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HWSW.intfk_hardware_id 
				  INNER JOIN $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=HWSW.intfk_software_record_id
				  where HWSW.intfk_hardware_id =$intfk_hardware_id";
	$result=db_fetch_query($qry_select);
	return  $result;
}

function logMapHwSwSoftwareRecordDelete($intpk_hardware_software_id){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_hardware_software] where intpk_hardware_software_id=".$intpk_hardware_software_id;
	if($intpk_hardware_software_id!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 14,$intpk_hardware_software_id";
		$result=db_fetch_query($qry_select);

	}
}

?>