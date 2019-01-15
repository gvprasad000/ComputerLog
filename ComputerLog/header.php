
<?php

if ( $_GET ) {
	foreach ( $_GET as $strKey=>$strItem ) {
	//	echo $strItem;
		switch($strKey) {
			case "mode":
				$strMode = $strItem;
				break;
		}
	}
}
switch ( $strMode ) {
	Default:
		echo main();
		break;
}

/**
* function main
* Main Display Page
**/
function main()
{

//$_newphp = extension_loaded('sqlsrv');
	$str_content = implode(" ",file("inc/forms/frmheader.html"));
	//$user=$_COOKIE['CstName'];
	$data = unserialize($_COOKIE['LogUserList']);
	$str_content = str_replace('@first_name@', $data['first_name'], $str_content);
	$str_content = str_replace('@last_name@', $data['last_name'], $str_content);
	$str_content = str_replace('@user_email@', $data['email'], $str_content);
	$str_content = str_replace('@comp_id@', $data['intfk_user_plant_id'], $str_content);
	$str_content = str_replace('@UserName@', $data['first_name'], $str_content);
	return $str_content;
}

?>