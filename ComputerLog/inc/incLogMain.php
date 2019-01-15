<?php

		
function logGetAllProblems(){
	$logName=logDb();	
	$qry_select="  select Top 100 * from $logName.[tbl_problem_history] AS PH 
  				INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=PH.intfk_all_item_id
  				INNER JOIN $logName.[tbl_item_type] AS IT ON IT.intpk_item_type_id=AI.intfk_item_id
  				INNER JOIN $logName.[tbl_history_type] AS HT ON HT.intpk_history_type=PH.intfk_history_type_id
  				LEFT OUTER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=PH.int_fixed_user_id
 				 order by bln_pblm desc,dte_problem_occured desc";
	$result=db_fetch_query($qry_select);
	return $result;
		
}

function logChangeActiveStatus($intpk_problem_history_id,$bln_active_status){
	$logName=logDb();	
	if($intpk_problem_history_id!='' && $intpk_problem_history_id!=null){
		if($bln_active_status==0)
			$bln_active_status=1;
		elseif($bln_active_status==1)
			$bln_active_status=0;
		$qry_select="update $logName.[tbl_problem_history] set bln_pblm=$bln_active_status where intpk_problem_history_id=$intpk_problem_history_id";
		$result=db_fetch_query($qry_select);
	}
}

function logGetScheduleDays(){
	$logName=logDb();	
	$qry_select="select * from $logName.[tbl_schedule] AS S
				INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=S.intfk_all_item_id
				INNER JOIN $logName.[tbl_item_type] AS IT ON IT.intpk_item_type_id=AI.intfk_item_id
				where int_day is not null";
	$result=db_fetch_query($qry_select);
	return $result;
}

function logGetScheduleWeeks(){
	$logName=logDb();	
	$qry_select="select * from $logName.[tbl_schedule] AS S
				INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=S.intfk_all_item_id
				INNER JOIN $logName.[tbl_item_type] AS IT ON IT.intpk_item_type_id=AI.intfk_item_id where int_week is not null
				ORDER BY S.int_week";
	$result=db_fetch_query($qry_select);
	return $result;
}

function logGetScheduleMonths(){
	$logName=logDb();	
	$qry_select="select * from $logName.[tbl_schedule] AS S
				INNER JOIN $logName.[tbl_all_item] AS AI ON AI.intpk_all_item_id=S.intfk_all_item_id
				INNER JOIN $logName.[tbl_item_type] AS IT ON IT.intpk_item_type_id=AI.intfk_item_id where int_month is not null
				ORDER BY S.int_month";
	$result=db_fetch_query($qry_select);
	return $result;
}

?>




