
<?php
function getUserIp(){

	$str_where='';
	$str_order='';
	$str_select='';
	
	$pdf = new PDF('P', 'in', 'Letter');
	$pdf->form=1;
	$pdf->SetAutoPageBreak(0);
	$pdf->SetFillColor(220, 220, 220);
	$logName=logDb();
	$query_select="select * from $logName.[tbl_user_hardware] AS UH 
				INNER JOIN 	$logName.[tbl_hardware] AS H ON H.intpk_hardware_id=UH.intfk_hardware_id
				INNER JOIN $logName.[tbl_user] AS U ON U.intpk_user_id=UH.intfk_user_id
				INNER JOIN $logName.[tbl_ip_address] AS IP ON IP.intfk_hardware_id=H.[intpk_hardware_id]
				order by U.str_firstname  ";
	$result=db_fetch_query($query_select);	
require_once('lib/FirePHPCore/FirePHP.class.php');
		$firephp = FirePHP::getInstance(true);
		
	
	$flt_ypos = 11.0;
	$flt_xpos = 0.30;


	
	
	$str_col[1]='User Name';
	$flt_width[1]=2.80;
	
	$str_col[2]='System ID';
	$flt_width[2]=.85;
	
	$str_col[3]='System Name';
	$flt_width[3]=.9;
	
	$str_col[4]='IP Desc #';
	$flt_width[4]=1.35;
	
	$str_col[5]='Ip Address #';
	$flt_width[5]=1.5;
	

	
	
	$int_fill=0;
	
	$flt_start=0.15;
	for ( $int_i = 0; $int_i < count($flt_width); $int_i++ ) {
		$flt_col[$int_i+1] = $flt_start;
		$flt_start +=$flt_width[$int_i+1];
	}
	
	
	$fill = 1;
	$flt_ypos=drawlistheadings($pdf, $flt_xpos, $flt_ypos, $flt_col, $flt_width, $str_col, $obj_company->str_company_name, $pagetitle);
			
	$firephp->log($flt_ypos);
	for($count=0;$count<count($result);$count++){
		if ($int_fill==1)
				{
					$int_fill=0;
				}else{
					$pdf->SetFillColor(216,216,216);
					$int_fill=1;
				}
		$pdf->SetXY($flt_col[1], $flt_ypos);
			$pdf->MultiCell($flt_width[1], .2,$result[$count]['str_firstname'].' '.$result[$count]['str_lastname'] , '','C', $int_fill);
			$pdf->SetXY($flt_col[2], $flt_ypos);
			$pdf->MultiCell($flt_width[2], .2, $result[$count]['str_system_id'] , '','C', $int_fill);
			$pdf->SetXY($flt_col[3], $flt_ypos);
			$pdf->MultiCell($flt_width[3], .2,$result[$count]['str_system_name'] , '','C', $int_fill);
			$pdf->SetXY($flt_col[4], $flt_ypos);
			$pdf->MultiCell($flt_width[4], .2, $result[$count]['str_ip_desc'], '','C', $int_fill );
			$pdf->SetXY($flt_col[5], $flt_ypos);
			$pdf->MultiCell($flt_width[4], .2, $result[$count]['str_ip_address'], '','C', $int_fill );
			$flt_ypos += .2;
	}
ob_end_clean();
ob_clean();
$pdf->Output('example_006.pdf', 'I');

}
function drawlistheadings($pdf, $flt_xpos, $flt_ypos, $flt_col, $flt_width,$str_col, $str_company, $pagetitle)
{
	$pdf->AddPage();
	$flt_ypos = .2;
	$flt_xpos = .3;
	
	if($pdf->CurOrientation == 'P')
	{
		$head_width = 7.9;
	}
	else 
	{
		$head_width = 13.20;
	}
	$pdf->SetXY($flt_xpos, $flt_ypos);
	$pdf->SetFont('Times','B',14);
	$pdf->MultiCell($head_width, .20, trim($str_company),'','C' );
	$pdf->SetFont('','',11);
	$pdf->MultiCell($head_width, .20, "User Ip Address \n", '', 'C');
	$flt_ypos += .50;
	$pdf->SetFont('','',9);
	$pdf->SetXY($flt_xpos, $flt_ypos);
	$pdf->MultiCell($head_width, .17,  $pagetitle);
	
	
	$flt_ypos = 1.2;
	$pdf->SetFont('Times','', 10);
	for ( $int_j = 0; $int_j < count($str_col); $int_j++ ) {
		
		if ($str_col[$int_j+1]!=''){
			$flt_xpos = $flt_col[$int_j+1];
			$pdf->SetXY($flt_xpos, $flt_ypos);
			$pdf->MultiCell($flt_width[$int_j+1], 0.20, $str_col[$int_j+1], 1,  'C');
		}
	}
	
	$flt_ypos += .2;
	return $flt_ypos;	
}