<?php

function saveLogHistory($logArrayList){
	
	$logName=logDb();
	$JsonSoftwareArrayDecode=json_decode($logArrayList,true);
	if($JsonSoftwareArrayDecode[History][intpk_history_type]=='' || $JsonSoftwareArrayDecode[History][intpk_history_type]==null)
		$intpk_history_type_id=0;
	else 
		$intpk_history_type_id=$JsonSoftwareArrayDecode[History][intpk_history_type];

	$qry_select="exec $logName.[save_update_computer_log_history]".$intpk_history_type_id.",'".
	$JsonSoftwareArrayDecode[History][str_history_desc]."'";
	$result=db_fetch_query($qry_select);

}

function LogHistroyTypeSearch($log_histroy_type){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_history_type] where str_history_desc like '%$log_histroy_type%'  ORDER BY str_history_desc";
	$result=db_fetch_query($qry_select);
	return $result;
}

function LogDeleteSelectedHistroyType($intpk_history_type){
	$logName=logDb();
	$qry_select="delete from $logName.[tbl_history_type] where intpk_history_type=".$intpk_history_type;
	if($intpk_history_type!=''){
		$result=db_fetch_query($qry_select);
		$qry_select="exec $logName.[delete_computer_log_all_item] 15,$intpk_history_type";
		$result=db_fetch_query($qry_select);
	}
}

function logGetItemTable(){
		$logName=logDb();
	$qry_select="select * from $logName.[tbl_item_type]  ORDER BY str_item_type_name";
	$result=db_fetch_query($qry_select);
	return $result;
}

function logItemTypeselected($intpk_item_type_id){
	$logName=logDb();
	if($intpk_item_type_id==6){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_component] AS C ON C.intpk_component_id=AI.intfk_item_type_id  
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==7){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=AI.intfk_item_type_id  
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where intfk_item_id=$intpk_item_type_id";
		
	}elseif($intpk_item_type_id==8){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_hardware_component] AS HC ON HC.intpk_hardware_component_id=AI.intfk_item_type_id  
		INNER JOIN  $logName.[tbl_component] AS C ON C.intpk_component_id=HC.infk_component_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HC.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==14){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_hardware_software] AS HS ON HS.intpk_hardware_software_id=AI.intfk_item_type_id 
		INNER JOIN  $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=HS.intfk_software_record_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HS.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where intfk_item_id=$intpk_item_type_id";	
	}elseif($intpk_item_type_id==5){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=AI.intfk_item_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==15){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_history_type] AS HT ON HT.intpk_history_type=AI.intfk_item_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==9){
		$qry_select="select * from  $logName.[tbl_all_item] AS AI
		INNER JOIN  $logName.[tbl_ip_address] AS IP ON IP.intpk_ip_address_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=IP.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==2){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=AI.intfk_item_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==12){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_software] AS S ON S.intpk_software_id=AI.intfk_item_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==13){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=AI.intfk_item_type_id
		INNER JOIN $logName.[tbl_software] AS S ON S.intpk_software_id=SR.intfk_software_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==1){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=AI.intfk_item_type_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==11){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_user_hardware] AS UH ON UH.intpk_user_hardware_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=UH.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UH.intfk_user_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==3){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_user_map_drive] AS UMD ON UMD.intpk_user_map_drive_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=UMD.intfk_mapdrive_id  
		INNER JOIN  $logName.[tbl_letter] AS L ON L.intpk_letter_id=UMD.infk_drive_letter
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UMD.intfk_user_id
		where intfk_item_id=$intpk_item_type_id";
	}elseif($intpk_item_type_id==4){
		$qry_select="select * from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_vpn] AS VPN ON VPN.intpk_vpn_id=AI.intfk_item_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=VPN.intfk_user_id
		where intfk_item_id=$intpk_item_type_id";
	}
	$result=db_fetch_query($qry_select);
	return $result;
}

function logProblemType(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_history_type]";
	$result=db_fetch_query($qry_select);
	return $result;
}

function logAllUser(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user]";
	$result=db_fetch_query($qry_select);
	return $result;
}

function logGetAllItemId($intpk_problem_id,$intfk_all_item_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_all_item] where intfk_item_id=$intpk_problem_id AND intfk_item_type_id=$intfk_all_item_id";
	$result=db_fetch_query($qry_select);
	return $result;
}

function saveLogProblems($logArrayList){
		require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
	$logName=logDb();
	$JsonSoftwareArrayDecode=json_decode($logArrayList,true);
	if($JsonSoftwareArrayDecode['Problem']['intpk_problem_id']=='' || $JsonSoftwareArrayDecode['Problem']['intpk_problem_id']==null)
		$intpk_problem_history_id=0;
	else 
		$intpk_problem_history_id=$JsonSoftwareArrayDecode['Problem']['intpk_problem_id'];
		
	if($JsonSoftwareArrayDecode['Problem']['int_fixed_user_id']=='' || $JsonSoftwareArrayDecode['Problem']['int_fixed_user_id']==null)
		$int_fixed_user_id="''";
	else 
		$int_fixed_user_id=$JsonSoftwareArrayDecode['Problem']['int_fixed_user_id'];

	$dateString = $JsonSoftwareArrayDecode['Problem']['dte_problem_occured'];
	$date = strtotime($dateString);
	$date= date('Y-m-d H:i', $date);	
	
	if($JsonSoftwareArrayDecode['Problem']['dte_resolution']=='' || $JsonSoftwareArrayDecode['Problem']['dte_resolution']==null)
		$dte_problem_resolution="";
	else{
		$dte_problem_resolution=$JsonSoftwareArrayDecode['Problem']['dte_resolution'];	
		$firephp->log($dte_problem_resolution);
		$dte_problem_resolution = strtotime($dte_problem_resolution);
		$dte_problem_resolution= date('Y-m-d H:i', $dte_problem_resolution);		
	}	
	$qry_select="exec $logName.[save_update_computer_log_problem] $intpk_problem_history_id".",".$JsonSoftwareArrayDecode['Problem']['intfk_all_item_id'].",".
					$JsonSoftwareArrayDecode['Problem']['intfk_history_type_id'].",".$int_fixed_user_id.",".$JsonSoftwareArrayDecode['Problem']['bln_pblm'].",'".
					$date."','".$JsonSoftwareArrayDecode['Problem']['str_pblm_desc']."','".$dte_problem_resolution."','".$JsonSoftwareArrayDecode['Problem']['str_resolution_desc']."'";
	$firephp->log($qry_select);
	$result=db_fetch_query($qry_select);				
				
}

function logGetAllProblemsSearch($intfk_item_id,$dte_start,$dte_end,$intfk_fixed_user){
		require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		if($intfk_fixed_user!=null)
			$query_add=" AND PH.int_fixed_user_id=$intfk_fixed_user";
		else 
			$query_add="";
		$firephp->log($query_add);
	$logName=logDb();
	if($intfk_item_id==6){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_component] AS C ON C.intpk_component_id=AI.intfk_item_type_id  
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==7){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=AI.intfk_item_type_id  
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==8){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_hardware_component] AS HC ON HC.intpk_hardware_component_id=AI.intfk_item_type_id  
		INNER JOIN  $logName.[tbl_component] AS C ON C.intpk_component_id=HC.infk_component_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HC.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==14){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_hardware_software] AS HS ON HS.intpk_hardware_software_id=AI.intfk_item_type_id 
		INNER JOIN  $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=HS.intfk_software_record_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=HS.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";	
	}elseif($intfk_item_id==5){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==15){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_history_type] AS HT ON HT.intpk_history_type=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==9){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from  $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN  $logName.[tbl_ip_address] AS IP ON IP.intpk_ip_address_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=IP.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==2){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==12){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_software] AS S ON S.intpk_software_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==13){
		$qry_select="select *,U.str_firstname As str_fixed_user_f_name,U.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_software_record] AS SR ON SR.intpk_software_record_id=AI.intfk_item_type_id
		INNER JOIN $logName.[tbl_software] AS S ON S.intpk_software_id=SR.intfk_software_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==1){
		$qry_select="select *,US.str_firstname As str_fixed_user_f_name,US.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS US ON US.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=AI.intfk_item_type_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==11){
		$qry_select="select *,US.str_firstname As str_fixed_user_f_name,US.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS US ON US.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_user_hardware] AS UH ON UH.intpk_user_hardware_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_hardware] AS H ON H.intpk_hardware_id=UH.intfk_hardware_id 
		INNER JOIN  $logName.[tbl_hardware_type] AS HT ON HT.intpk_hardware_type_id=H.intfk_hardware_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UH.intfk_user_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==3){
		$qry_select="select *,US.str_firstname As str_fixed_user_f_name,US.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS US ON US.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_user_map_drive] AS UMD ON UMD.intpk_user_map_drive_id=AI.intfk_item_type_id
		INNER JOIN  $logName.[tbl_map_drive] AS MD ON MD.intpk_map_drive_id=UMD.intfk_mapdrive_id  
		INNER JOIN  $logName.[tbl_letter] AS L ON L.intpk_letter_id=UMD.infk_drive_letter
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UMD.intfk_user_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}elseif($intfk_item_id==4){
		$qry_select="select *,US.str_firstname As str_fixed_user_f_name,US.str_lastname As str_fixed_user_l_name from $logName.[tbl_all_item] AS AI
		INNER JOIN $logName.[tbl_problem_history] AS PH ON PH.intfk_all_item_id=AI.intpk_all_item_id
		LEFT OUTER JOIN $logName.[tbl_user] AS US ON US.intpk_user_id=PH.int_fixed_user_id
		INNER JOIN $logName.[tbl_history_type] AS HIT ON  HIT.intpk_history_type=PH.intfk_history_type_id
		INNER JOIN $logName.[tbl_vpn] AS VPN ON VPN.intpk_vpn_id=AI.intfk_item_type_id
		INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=VPN.intfk_user_id
		where AI.intfk_item_id=$intfk_item_id AND 
		(dte_problem_occured>=CONVERT(DATETIME, '$dte_start 00:00', 102) AND dte_problem_occured<=CONVERT(DATETIME, '$dte_end 23:59', 102)) $query_add";
	}
	$firephp->log($qry_select);
	$result=db_fetch_query($qry_select);
	return $result;
	
	
}

function logProblemSelectedItem($intpk_problem_history_id){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_problem_history] AS PH 
	INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=PH.intfk_all_item_id
	LEFT OUTER JOIN $logName.[tbl_problem] AS Pblm ON Pblm.intpk_problem_history_id=PH.intpk_problem_history_id
	where PH.intpk_problem_history_id=$intpk_problem_history_id";
	$result=db_fetch_query($qry_select);
	return $result;
}

?>