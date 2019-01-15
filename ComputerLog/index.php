<?php
include_once "inc/incIncludeJS.php";
//include_once "inc/incLoginValidate.php";
ini_set("max_execution_time",30);
$strMode = '';
//phpinfo();
 /*if(PHP_INT_SIZE === 4)
 	echo 'true';
 else 
 		echo 'FALSE';*/

if ( $_GET ) {
	foreach ( $_GET as $strKey=>$strItem ) {
		echo $strItem;
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
	$str_content = implode(" ",file("inc/forms/frmlogin.html"));
	return $str_content;
}

?>