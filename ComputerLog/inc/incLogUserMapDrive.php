<?php

		
function getAllUsers(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user]";
	$result=db_fetch_query($qry_select);
		return $result;
}
function  getAllMapDrives(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_user_map_drive]";
	$result=db_fetch_query($qry_select);
		return $result;
}


?>




