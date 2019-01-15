<?php

function GetUserButton(){
	$logName=logDb();
	$qry_select="select * from $logName.[tbl_report] where intfk_item_type_id=1";
	$result=db_fetch_query($qry_select);	
	return $result;
}
?>




