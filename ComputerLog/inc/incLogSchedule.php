<?php



function SaveLogSchedule($logArrayList){

		
	$logName=logDb();
	$JsonHardwareArrayDecode=json_decode($logArrayList,true);
	
	if($JsonHardwareArrayDecode['Schedule']['intpk_schedule_id']=='' || $JsonHardwareArrayDecode['Schedule']['intpk_schedule_id']==null)
		$intpk_schedule_id=0;
	else 
		$intpk_schedule_id=$JsonHardwareArrayDecode['Schedule']['intpk_schedule_id'];
	$intfk_item_id=$JsonHardwareArrayDecode['Schedule']['intfk_schedule_for_id'];
	$intfk_item_type_id=$JsonHardwareArrayDecode['Schedule']['intfk_schedule_item_id'];
	$qry_select="select intpk_all_item_id from $logName.[tbl_all_item] where intfk_item_id=$intfk_item_id
      AND intfk_item_type_id=$intfk_item_type_id";	
	$result=db_fetch_query($qry_select);
	$intpk_all_item_id=$result[0]['intpk_all_item_id'];
	
	$qry_select="exec $logName.[save_update_computer_log_schedule]".$intpk_schedule_id.",".$intpk_all_item_id.",".
				$JsonHardwareArrayDecode['Schedule']['intfk_schedule_histry_type'].",".$JsonHardwareArrayDecode['Schedule']['intfk_schedule_user_id'].",".
				$JsonHardwareArrayDecode['Schedule']['intfk_schedule_type'].",".$JsonHardwareArrayDecode['Schedule']['int_pick_day'].",'".
				$JsonHardwareArrayDecode['Schedule']['str_schedule_desc']."'";
	
	$result=db_fetch_query($qry_select);
}

function logScheduleSearch($intfk_item_id){
	$logName=logDb();
		require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		
	if($intfk_item_id==6){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_component] AS C ON C.intpk_component_id=AI.intfk_item_type_id  
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==7){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=AI.intfk_item_type_id  
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id";
		
	}elseif($intfk_item_id==8){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON S.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_hardware_component] AS HC ON HC.intpk_hardware_component_id=AI.intfk_item_type_id  
		INNER JOIN  $logName.[tbl_component] AS C ON C.intpk_component_id=HC.infk_component_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HC.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==14){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_hardware_software] AS HS ON HS.intpk_hardware_software_id=AI.intfk_item_type_id 
		INNER JOIN  $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=HS.intfk_software_record_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HS.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id";	
	}elseif($intfk_item_id==5){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==15){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_history_type] AS HT ON HT.intpk_history_type=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==9){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN  $logName.[tbl_ip_address] AS IP ON IP.intpk_ip_address_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=IP.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==2){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==12){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_software] AS S ON S.intpk_software_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==13){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=AI.intfk_item_type_id
		INNER JOIN $logName.[tbl_software] AS S ON S.intpk_software_id=SR.intfk_software_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==1){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==11){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_user_hardware] AS UH ON UH.intpk_user_hardware_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=UH.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UH.intfk_user_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==3){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_user_map_drive] AS UMD ON UMD.intpk_user_map_drive_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=UMD.intfk_mapdrive_id  
		INNER JOIN  $logName.[tbl_letter] AS L ON L.intpk_letter_id=UMD.infk_drive_letter
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UMD.intfk_user_id
		where AI.intfk_item_id=$intfk_item_id";
	}elseif($intfk_item_id==4){
		$qry_select="select *,His_Type.str_history_desc AS sched_his_type,Sch_Us.str_firstname As schd_first_name,Sch_Us.str_lastname As schd_last_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_schedule] AS Sch ON Sch.intfk_all_item_id=AI.intpk_all_item_id
		INNER JOIN $logName.[tbl_history_type] AS His_Type ON His_Type.intpk_history_type=Sch.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS Sch_Us ON Sch_Us.intpk_user_id=Sch.intfk_user_id
		INNER JOIN $logName.[tbl_vpn] AS VPN ON VPN.intpk_vpn_id=AI.intfk_item_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=VPN.intfk_user_id
		where AI.intfk_item_id=$intfk_item_id";
	}
	$result=db_fetch_query($qry_select);
	return $result;				
	
}

function logScheduleSearchSelectedItem($intpk_schedule_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_schedule] AS S 
				INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=S.intfk_all_item_id
				INNER JOIN $logName.[tbl_history_type] AS HT ON HT.intpk_history_type=S.intfk_history_type_id
				INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=S.intfk_user_id where S.intpk_schedule_id=$intpk_schedule_id";
	$result=db_fetch_query($qry_select);
	return $result;		
}

?>




