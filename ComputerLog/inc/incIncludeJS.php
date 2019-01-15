<?php
session_start();
?>
<?php
/*

File contains all Javascript includes

*/
#Include the FirePHP class

if(( $_SESSION['sess']!='')  || basename($_SERVER['PHP_SELF'])=='index.php'){
	
  //STYLESHEETS
  
  //Bootstrap core CSS
  
				
 echo '<link href="inc/node_modules/support/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">';
  // Custom fonts for this template 
 echo ' <link href="inc/node_modules/support/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">';
  // Custom styles for this template
  echo '<link href="inc/node_modules/support/css/sb-admin.css" rel="stylesheet">';
 //echo '<link href="inc/node_modules/angular-ui-bootstrap/dist/ui-bootstrap-csp.css" rel="stylesheet">';
  //SCRIPTS
  
    echo '<script src="inc/node_modules/support/vendor/jquery/jquery.min.js"></script>';
    echo ' <script src="inc/node_modules/support/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>';
  //Core plugin JavaScript
    echo '<script src="inc/node_modules/support/vendor/jquery-easing/jquery.easing.min.js"></script>';
				
 // echo '<script type="text/javascript" src="inc/node_modules/jquery/dist/jquery.js"></script>';
	echo '<script type="text/javascript" src="inc/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>';
	//echo '<link rel="stylesheet" type="text/css" href="inc/node_modules/bootstrap/dist/css/bootstrap.min.css">';
	echo '<link rel="stylesheet" href="inc/node_modules/font-awesome-4.7.0/css/font-awesome.min.css">';

					//echo '<script type="text/javascript" src="inc/node_modules/jquery/dist/jquery.js"></script>';
					echo '<script type="text/javascript" src="inc/node_modules/jquery/dist/jquery-ui.js"></script>';
					echo '<link rel="stylesheet" type="text/css" href="inc/node_modules/jquery/dist/jquery-ui.css"></script>';
					
					echo '<script type="text/javascript" src="inc/node_modules/angular/angular.min.js"></script>';		
					echo '<script type="text/javascript" src="inc/jsHeader.js"></script>';
					echo '<script type="text/javascript" src="inc/node_modules/bootstrap/dist/js/notify.js"></script>';
					echo '<script type="text/javascript" src="inc/node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>';
					echo '<script type="text/javascript" src="inc/node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>';
				

					$strFormName1=basename($_SERVER['PHP_SELF']);
	
	switch ( strtolower($strFormName1) ) {
	
			case  "main.php":
				echo '<script type="text/javascript" src="inc/jsMain.js"></script>';
				echo '<script type="text/javascript" src="inc/jsProblemHistory.js"></script>';
				break;
			case  "index.php":
				
				echo '<script type="text/javascript" src="inc/jsLogin.js"></script>';
					//echo '<script type="text/javascript" src="'.DIR_INC.'jsSaltSprayInq.js"></script>';
					//echo '<script type="text/javascript" src="'.DIR_INC.'notify.js"></script>';
				break;
				
			case  "user.php":
				echo '<script type="text/javascript" src="inc/jsuser.js"></script>';

				break;
			case  "hardware.php":
				echo '<script type="text/javascript" src="inc/jsHardware.js"></script>';

				break;

			case "usermapdrive.php":
				echo '<script type="text/javascript" src="inc/jsusermapdrive.js"></script>';
				break;
			
			case "software.php":
				echo '<script type="text/javascript" src="inc/jsSoftware.js"></script>';
				break;
				
			case "problemhistory.php":
				echo '<script type="text/javascript" src="inc/jsProblemHistory.js"></script>';
				break;
			case "schedule.php":
				echo '<script type="text/javascript" src="inc/jsSchedule.js"></script>';
				break;
			case "report.php":
				echo '<script type="text/javascript" src="inc/jsReport.js"></script>';
				break;
			
		}
}else{
	require_once ('incLoginValidate.php');
	alertmeLogout();
}

function cleanItem($strItem)
{

	if ( trim($strItem) == 'undefined' ) {
		/* If JavaScript errors, or encounters a "NULL" it outputs an "undefined", which we can't let get on to the DB. */
		$strItem = '';
	} else {
		/* Replaces the POST safe ampersand. */
		$strItem = str_replace("{amp}","&",$strItem);
		$strItem = str_replace("{AMP}","&",$strItem);
		/* Replaces the POST safe tilda. */
		$strItem = str_replace("{tld}","`",$strItem);
		$strItem = str_replace("{TLD}","`",$strItem);
		/* Replaces the POST safe equal sign. */
		$strItem = str_replace("{eq}","=",$strItem);
		$strItem = str_replace("{EQ}","=",$strItem);
		/* Replaces the POST safe slash. */
		$strItem = str_replace("{sl}","/",$strItem);
		$strItem = str_replace("{SL}","/",$strItem);
		/* Replaces the POST safe backslash. */
		$strItem = str_replace("{bsl}","\\",$strItem);
		$strItem = str_replace("{BSL}","\\",$strItem);
		/* Replaces the POST safe new line. */
		$strItem = str_replace("{nl}","\n",$strItem);
		$strItem = str_replace("{NL}","\n",$strItem);
		/* Replaces the POST safe colon. */
		$strItem = str_replace("{col}",":",$strItem);
		$strItem = str_replace("{COL}",":",$strItem);
		/* Replaces the POST safe question mark. */
		$strItem = str_replace("{que}","?",$strItem);
		$strItem = str_replace("{QUE}","?",$strItem);
		/* Replaces the POST safe plus sign. */
		$strItem = str_replace("{pls}","+",$strItem);
		$strItem = str_replace("{PLS}","+",$strItem);
		/* Replaces the POST safe ampersand. */
		$strItem = str_replace("{sqte}","'",$strItem);
		$strItem = str_replace("{SQTE}","'",$strItem);
		/* Replaces the POST safe ampersand. */
		$strItem = str_replace("{dqte}",'"',$strItem);
		$strItem = str_replace("{DQTE}",'"',$strItem);
		$strItem = str_replace("_q_",'"',$strItem);
		$strItem = str_replace("_Q_",'"',$strItem);
		/* Replaces the POST safe ampersand. */
		$strItem = str_replace("{nmbr}","#",$strItem);
		$strItem = str_replace("{NMBR}","#",$strItem);
		$strItem = str_replace("{qote}","'",$strItem);
		$strItem = str_replace("{col}",":",$strItem);
	}

	return $strItem;
}
function cleanUp($strOld)
{
	$newStr = '';

	if ( $strOld != '' && strlen($strOld) > 0 ) {
		for ( $intCounter = 0; $intCounter < strlen($strOld); $intCounter++) {
			switch ( substr($strOld,$intCounter,1) ) {
				case "`":
					$newStr .= '{tld}';
					break;
				case "=":
					$newStr .= '{eq}';
					break; 
				case "&":
					$newStr .= '{amp}';
					break;
				case "/":
					$newStr .= '{sl}';
					break;
				case "\\":
					$newStr .= '{bsl}{bsl}';
					break;
				case ":":
					$newStr .= '{col}';
					break;
				case "?":
					$newStr .= '{que}';
					break;
				case "+":
					$newStr .= '{pls}';
					break;
				case "'":
					$newStr .= '{qote}';
					break;
				default:
					$newStr .= substr($strOld,$intCounter,1);
					break;
			}
		} /* End for ( var i = 0; i < str.length; i++) */
	}

	return $newStr;
} 


function db_fetch_query($qry_select)
{
	$connectionInfo=getConnectionSrtings();
	 $strHost=getDbParam();
	$conn=sqlsrv_connect($strHost[0], $connectionInfo) or 
		        WriteError($query, fnc_db_get_error(),$blnReconnect);
	$result = sqlsrv_query($conn, $qry_select);

	  $cnt=0;
	if (sqlsrv_has_rows($result)) {
	  while ($row = sqlsrv_fetch_array($result)) {
	  	  	$arrList[$cnt]= $row;
	  	    $cnt++;
	  }
	}else{
		$arrList=null;
	}

	   
	if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            $error[ 'SQLSTATE'];
          $error[ 'code'];
            $error[ 'message'];
        }
        $strFileName = '/htdocs/ComputerLog/logs/' . date("Ymd") . '_ErrorLog.html';
	    	$strContent = '<div style="border-bottom: 1px solid #000; margin-bottom: 10px;">' . "\n\t" .
						'<strong><em style="font-size: 1.2em;">' . date("Y-m-d H:i:s") . '</em></strong><br />' . "\n\t" .
						'<strong style="width: 75px;">Query:</strong> ' . $qry_select . '<br />' . "\n\t" .
						'<strong style="width: 75px;">Error:</strong> ' . $error[ 'message'] . '<br />' . "\n\t" .
						'<strong style="width: 75px;">Page:</strong> '. basename($_SERVER['HTTP_REFERER']) ."-->". basename($_SERVER['PHP_SELF']) . '<br />' . "\n\t" .
						'<strong style="width: 75px;">User:</strong> ' .$objUser->first_name .' '. $objUser->last_name  . '<br />' . "\n\t" .
						/*'<strong style="width: 75px;">Error:</strong> ' . $strValue . "\n" .*/
						'</div><br />' . "\n\n";
	    $objHandle = fopen($strFileName,'a');
				fwrite($objHandle, $strContent);
				fclose($objHandle);
 	}
    	return $arrList;
}

?>