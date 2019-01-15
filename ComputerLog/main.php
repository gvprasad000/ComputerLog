
<?php
include_once "inc/incIncludeJS.php";
include_once "header.php";
//echo 'Welcome To Main!!!'.$Session_id;


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
		echo main1();
		break;
}

/**
* function main
* Main Display Page
**/
function main1()
{
//$_newphp = extension_loaded('sqlsrv');
	$str_content = implode(" ",file("inc/forms/frmmain.html"));
	return $str_content;
}
?>