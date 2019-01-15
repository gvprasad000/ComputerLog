
<?php
include_once "inc/incIncludeJS.php";
include_once "header.php";


if ( $_GET ) {
	foreach ( $_GET as $strKey=>$strItem ) {
		//echo $strItem;
		switch($strKey) {
			case "mode":
				$strMode = $strItem;
				break;
		}
	}
}
switch ( $strMode ) {
	Default:
		echo user();
		break;
}

/**
* function main
* Main Display Page
**/
function user()
{
	$str_content = implode(" ",file("inc/forms/frmhardware.html"));
	
	return $str_content;
}
?>