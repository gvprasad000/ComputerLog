<?php
require_once('fpdf\fpdf.php');


class PDF extends FPDF {
		public $orientation1;
		public $company;
		public $title1;
		public $title2;
		public $heading;
		public $left_side1;
		public $left_side2;
		public $right_side1;
		public $right_side2;
		public $header;
		public $x;
		public $y;
		public $w;
		public $h;
		public $form;
		public $lineHeight;
		public $labelFontSize;
		public $labelColumn;
		public $labelWidth;
		public $dataFontSize;
		public $dataColumn;
		public $dataWidth;
		public $rptShopStatus;

		public $javascript;
		public $n_js;

		public $databold = 'B';
		public $labelalign = 'R';
		
		public $int_page_count;
		public $int_total_doc_pages;
		var $widths;
		var $aligns;
	function IncludeJS($script) {
		$this->javascript=$script;
	}

	function setPageCount($int)
	{
		$this->int_page_count = $int;
	}
	
	function setTotalDocPages($int)
	{
		$this->int_total_doc_pages = $int;
	}
	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS '.$this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (isset($this->javascript)) {
			$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}


	function Header() {

		$heading_height = 1.00;

		switch ($this->orientation1) {
			case 'L':
				$x = 00.00;
				$y = 00.00;
				$w = 11.00;
				$h = 07.50;
				break;
			case 'P':
				$x = 00.00;
				$y = 00.00;
				$w = 08.50;
				$h = 10.00;
				break;
		}


		$this->SetMargins(00.00, 00.00, 00.00);
		$this->SetDisplayMode('fullpage', 'single');



		if ($this->form != '1') {
			$this->Rect($x, $y, $w, $heading_height, 'D');
			$this->Rect($x, $y+$heading_height+0.05, $w, $h, 'D');
			$this->SetXY($x+0,$y+0.25);
			$this->SetFont('Arial','',10);
			$this->Cell(0,.15,trim(date('m/d/Y')),0,1,'L');
			$this->SetX($x+0);
			
			$dte_current_date=time();
			$this->Cell(0,.15,trim(date('g:i a',$dte_current_date)),0,1,'L');
			$this->SetX($x+0);
			$this->SetFont('Arial','I',10);
			$this->Cell(0,.15,$this->left_side1,0,1,'L');
			$this->SetX($x+0);
			$this->Cell(0,.15,$this->left_side2,0,1,'L');

			$this->SetXY($x+0,$y+0.25);
			$this->SetFont('Arial','',10);
			$this->Cell($w,.15,'Page ' . $this->PageNo(),0,1,'R');
			$this->SetX($x+0);
			$this->SetFont('Arial','I',10);
			$this->Cell($w,.15,$this->right_side1,0,1,'R');
			$this->SetX($x+0);
			$this->Cell($w,.15,$this->right_side2,0,1,'R');

			$this->SetXY($x,$y+.08);
			$this->SetFont('Arial','BI',18);
			$this->Cell($w,.25,$this->company,0,1,'C');
			$this->SetX($x);
			$this->SetFont('Arial','BI',12);
			$this->Cell($w,.20,$this->title1,0,1,'C');
			$this->SetX($x);
			$this->Cell($w,.20,$this->title2,0,1,'C');

			$this->SetFont('Arial', '',8);
			$this->SetXY($x+0,$y+$heading_height-0.20);
			$xPos = 00.05;
			for ( $i = 0; $i < count($this->heading); $i++) {
				$this->SetXY((float)$xPos, 00.75);
				$this->Cell( $this->heading[$i][0], 00.10, $this->heading[$i][1], 0, 2, $this->heading[$i][3]);
				$this->SetXY((float)$xPos, 00.85);
				$this->Cell( $this->heading[$i][0], 00.10, $this->heading[$i][2], 0, 0, $this->heading[$i][3]);
				$xPos += $this->heading[$i][0];
			}
		}
		else {
//			$this->Rect($x, $y, $w, $h+$heading_height, 'D');
		}
		$this->SetY(01.05);

	}

	function Footer() {

		switch ($this->orientation1) {
			case 'L':
				$x = 00.00;
				$y = 00.00;
				$w = 11.00;
				$h = 07.25;
				break;
			case 'P':
				$x = 00.00;
				$y = 00.00;
				$w = 08.50;
				$h = 11.00;
				break;
		}

		if ($this->form != '1') {
			$this->SetXY($x+0,$y+$h+0.90);
			$this->SetFont('Arial','',8);
			$this->Cell($w, .15,'Page ' . $this->PageNo(), 0, 1, 'C');
			if ($this->rptShopStatus) {
				$this->Cell($w,.15,'N=New   E=Engineering   $=Pricing   @=Scheduled   C=Complete   K=Ok to Ship I=Inspection   O=Outside Vendor   S=Shipped', 0, 1,'C');
			}
		}
	}

	/*
	** RoundedRect
	** x,y: top left corner of the rectangle
	** w,h: width, height
	** r: radius of the rounded corners (.5)
	** style: F,D (default), FD, DF
	** angle: 1=top left, 2=top right, 3=bottom right, 4=bottom left
	*/

	function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
		$h = $this->h;
		$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k, $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

	function RotatedImage($file,$x,$y,$w,$h,$bln_rotate)
	{
	    //Image rotated around its upper-left corner
	   $img_size= getimagesize($file);
	   
	   $aspect_y=$h/$img_size[1];
	   $aspect_x=$w/$img_size[0];
	   
	   if ($bln_rotate==1){
		   //Check to see if the image fits better at 90 degrees
		   $aspect_y2=$w/$img_size[1];
		   $aspect_x2=$h/$img_size[0];
		   
		   if($aspect_x<$aspect_y)
		   {
		   	$aspect1=$aspect_x;
		   }
		   else {
		   	$aspect1=$aspect_y;
		   }
		   
		   if($aspect_x2<$aspect_y2)
		   {
		   	$aspect2=$aspect_x2;
		   }
		   else {
		   	$aspect2=$aspect_y2;
		   }
		   
		   if ($aspect1<$aspect2)
		   {
		   	$angle=90;
		   	$y=$y+$h;
		   	$t=$h;
		   	$h=$w;
		   	$w=$t;
		   	$aspect_y=$aspect_y2;
		   	$aspect_x=$aspect_x2;
		   }
	   }
	   
	   
	   
	   
	  	if ($aspect_x>$aspect_y){
	  		$flt_adjust=$aspect_y;
	  		$w=$flt_adjust*$img_size[0];
	  		
	  	}
	  	else{
	  		$flt_adjust=$aspect_x;
	  		$h=$flt_adjust*$img_size[1];
	  	}
	   
	  	
	  	
	    $this->Rotate($angle,$x,$y);
	    $this->Image($file,$x,$y,$w,$h,'JPG');
	    $this->Rotate(0);
	}



    function Rotate($angle,$x=-1,$y=-1) {
		if($x==-1) {
			$x=$this->x;
		}
		if($y==-1) {
			$y=$this->y;
		}
		if($this->angle!=0) {
			$this->_out('Q');
		}

		$this->angle=$angle;

		if($angle!=0) {
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}



	function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5)
	{
		$wide = $baseline;
		$narrow = $baseline / 3 ;
		$gap = $narrow;
		$barChar['0'] = 'nnnwwnwnn';
		$barChar['1'] = 'wnnwnnnnw';
		$barChar['2'] = 'nnwwnnnnw';
		$barChar['3'] = 'wnwwnnnnn';
		$barChar['4'] = 'nnnwwnnnw';
		$barChar['5'] = 'wnnwwnnnn';
		$barChar['6'] = 'nnwwwnnnn';
		$barChar['7'] = 'nnnwnnwnw';
		$barChar['8'] = 'wnnwnnwnn';
		$barChar['9'] = 'nnwwnnwnn';
		$barChar['A'] = 'wnnnnwnnw';
		$barChar['B'] = 'nnwnnwnnw';
		$barChar['C'] = 'wnwnnwnnn';
		$barChar['D'] = 'nnnnwwnnw';
		$barChar['E'] = 'wnnnwwnnn';
		$barChar['F'] = 'nnwnwwnnn';
		$barChar['G'] = 'nnnnnwwnw';
		$barChar['H'] = 'wnnnnwwnn';
		$barChar['I'] = 'nnwnnwwnn';
		$barChar['J'] = 'nnnnwwwnn';
		$barChar['K'] = 'wnnnnnnww';
		$barChar['L'] = 'nnwnnnnww';
		$barChar['M'] = 'wnwnnnnwn';
		$barChar['N'] = 'nnnnwnnww';
		$barChar['O'] = 'wnnnwnnwn';
		$barChar['P'] = 'nnwnwnnwn';
		$barChar['Q'] = 'nnnnnnwww';
		$barChar['R'] = 'wnnnnnwwn';
		$barChar['S'] = 'nnwnnnwwn';
		$barChar['T'] = 'nnnnwnwwn';
		$barChar['U'] = 'wwnnnnnnw';
		$barChar['V'] = 'nwwnnnnnw';
		$barChar['W'] = 'wwwnnnnnn';
		$barChar['X'] = 'nwnnwnnnw';
		$barChar['Y'] = 'wwnnwnnnn';
		$barChar['Z'] = 'nwwnwnnnn';
		$barChar['-'] = 'nwnnnnwnw';
		$barChar['.'] = 'wwnnnnwnn';
		$barChar[' '] = 'nwwnnnwnn';
		$barChar['*'] = 'nwnnwnwnn';
		$barChar['$'] = 'nwnwnwnnn';
		$barChar['/'] = 'nwnwnnnwn';
		$barChar['+'] = 'nwnnnwnwn';
		$barChar['%'] = 'nnnwnwnwn';
		$this->SetFont('Arial','',10);
//		$this->Text($xpos, $ypos + $height + .4, $code);
		$this->SetFillColor(0);

		$code = '*'.strtoupper($code).'*';
		for($i=0; $i<strlen($code); $i++) {
			$char = $code{$i};
			if(!isset($barChar[$char])) {
	            $this->Error('Invalid character in barcode: '.$char);
			}
			$seq = $barChar[$char];
			for($bar=0; $bar<9; $bar++) {
				if($seq{$bar} == 'n'){
					$lineWidth = $narrow;
				}else{
					$lineWidth = $wide;
				}
				if($bar % 2 == 0){
					$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
				}
				$xpos += $lineWidth;
			}
			$xpos += $gap;
		}
	}

	function ExtCode39($x, $y, $code, $ext = true, $cks = false, $w = 0.4, $h = 20, $wide = true) {

	    $this->SetFont('Arial', '', 10);
//	    $this->Text($x, $y+$h+00.15, $code);

	    if($ext)
	    {
	        //Extended encoding
	        $code = $this->encode_code39_ext($code);
	    }
	    else
	    {
	        //Convert to upper case
	        $code = strtoupper($code);
	        //Check validity
	        if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code))
	            $this->Error('Invalid barcode value: '.$code);
	    }

	    //Compute checksum
	    if ($cks)
	        $code .= $this->checksum_code39($code);

	    //Add start and stop characters
	    $code = '*'.$code.'*';

	    //Conversion tables
	    $narrow_encoding = array (
	        '0' => '101001101101', '1' => '110100101011', '2' => '101100101011',
	        '3' => '110110010101', '4' => '101001101011', '5' => '110100110101',
	        '6' => '101100110101', '7' => '101001011011', '8' => '110100101101',
	        '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011',
	        'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101',
	        'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101',
	        'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011',
	        'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011',
	        'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011',
	        'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001',
	        'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101',
	        'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101',
	        '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101',
	        '*' => '100101101101', '$' => '100100100101', '/' => '100100101001',
	        '+' => '100101001001', '%' => '101001001001' );

	    $wide_encoding = array (
	        '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111',
	        '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101',
	        '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101',
	        '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111',
	        'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101',
	        'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101',
	        'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111',
	        'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111',
	        'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111',
	        'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001',
	        'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101',
	        'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101',
	        '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101',
	        '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001',
	        '+' => '100010100010001', '%' => '101000100010001');

	    $encoding = $wide ? $wide_encoding : $narrow_encoding;

	    //Inter-character spacing
	    $gap = ($w > 0.29) ? '00' : '0';

	    //Convert to bars
	    $encode = '';
	    for ($i = 0; $i< strlen($code); $i++)
	        $encode .= $encoding[$code{$i}].$gap;

	    //Draw bars
	    $this->draw_code39($encode, $x, $y, $w, $h);
	}

	function checksum_code39($code) {

	    //Compute the modulo 43 checksum

	    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	                            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
	                            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
	                            'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
	    $sum = 0;
	    for ($i=0 ; $i<strlen($code); $i++) {
	        $a = array_keys($chars, $code{$i});
	        $sum += $a[0];
	    }
	    $r = $sum % 43;
	    return $chars[$r];
	}

	function encode_code39_ext($code) {

	    //Encode characters in extended mode

	    $encode = array(
	        chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C',
	        chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G',
	        chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '£K',
	        chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O',
	        chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S',
	        chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W',
	        chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A',
	        chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E',
	        chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C',
	        chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G',
	        chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K',
	        chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O',
	        chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3',
	        chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7',
	        chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F',
	        chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J',
	        chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C',
	        chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G',
	        chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K',
	        chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O',
	        chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S',
	        chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W',
	        chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K',
	        chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O',
	        chr(96) => '%W', chr(97) => 'A', chr(98) => 'B', chr(99) => 'C',
	        chr(100) => 'D', chr(101) => 'E', chr(102) => 'F', chr(103) => 'G',
	        chr(104) => 'H', chr(105) => 'I', chr(106) => 'J', chr(107) => 'K',
	        chr(108) => 'L', chr(109) => 'M', chr(110) => 'N', chr(111) => 'O',
	        chr(112) => 'P', chr(113) => 'Q', chr(114) => 'R', chr(115) => 'S',
	        chr(116) => 'T', chr(117) => 'U', chr(118) => 'V', chr(119) => 'W',
	        chr(120) => 'X', chr(121) => 'Y', chr(122) => 'Z', chr(123) => '%P',
	        chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

	    $code_ext = '';
	    for ($i = 0 ; $i<strlen($code); $i++) {
	        if (ord($code{$i}) > 127)
	            $this->Error('Invalid character: '.$code{$i});
	        $code_ext .= $encode[$code{$i}];
	    }
	    return $code_ext;
	}

	function draw_code39($code, $x, $y, $w, $h){

	    //Draw bars

	    for($i=0; $i<strlen($code); $i++)
	    {
	        if($code{$i} == '1')
	            $this->Rect($x+$i*$w, $y, $w, $h, 'F');
	    }
	}


	function Watermark($x, $y, $watermark) {
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(203,203,203);
		$this->Rotate(45);
		$this->Text($x, $y, $watermark);
		$this->Rotate(0);
		$this->SetTextColor(0,0,0);
	}

	function TextWithDirection( $x, $y, $txt, $direction='R' ) {
	    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
	    if ($direction=='R')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    elseif ($direction=='L')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    elseif ($direction=='U')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    elseif ($direction=='D')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    else
	        $s=sprintf('BT %.2f %.2f Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$txt);
	    if ($this->ColorFlag)
	        $s='q '.$this->TextColor.' '.$s.' Q';
	    $this->_out($s);
	}



	function PrintPatternBox( $xPos, $yPos, $boxType, $title1, $title2 ) {
		switch ($boxType) {
			case 1:
			case 2:
				$rowHeight = 00.20;
				$colWidth1 = 00.30;
				$colWidth2 = 00.50;
				$numRows = 11;
				$numCols = 6;
				break;
			default:
				$rowHeight = 00.20;
				$colWidth1 = 00.30;
				$colWidth2 = 00.50;
				$numRows = 11;
				$numCols = 6;
				break;
		}

		// Fill
		$this->SetFillColor( 200, 200, 200 );
		$this->Rect( (float)$xPos, (float)$yPos, ((float)$colWidth1*2)+((float)$colWidth2*4), (float)$rowHeight,  'F' );
		$this->Rect( (float)$xPos, (float)$yPos, (float)$colWidth1, (((float)$numRows-1)*(float)$rowHeight), 'F' );
		$this->Rect( (float)$xPos+((float)$colWidth1)+((float)$colWidth2*2), (float)$yPos, (float)$colWidth1, (((float)$numRows-1)*(float)$rowHeight), 'F' );
		$this->SetFillColor( 255, 255, 255 );



		for ($i = 0; $i < $numRows; $i++) {
			$this->Line( (float)$xPos, (float)$yPos+($i*(float)$rowHeight), (float)$xPos+((float)$colWidth1*2)+((float)$colWidth2*4), (float)$yPos+($i*(float)$rowHeight) );
		}

		for ($i = 0; $i < $numCols+1; $i++) {
			if ($i == 0) {
				(float)$colWidth += 0;
			} elseif ($i == 1 || $i == 4 ) {
				(float)$colWidth += (float)$colWidth1;
			} else {
				(float)$colWidth += (float)$colWidth2;
			}
			$this->Line( (float)$xPos+(float)$colWidth, (float)$yPos, (float)$xPos+(float)$colWidth, (float)$yPos+(((float)$numRows-1)*(float)$rowHeight) );
		}

		// Titles
		$this->SetXY( (float)$xPos, (float)$yPos-00.40);
		$this->SetFontSize(16);
		$this->Cell( ((float)$colWidth1*2)+((float)$colWidth2*4), 00.20, $title1, 0, 0, 'C');
		$this->SetXY( (float)$xPos, (float)$yPos-00.20);
		$this->SetFontSize(10);
		$this->Cell( ((float)$colWidth1*2)+((float)$colWidth2*4), 00.20, $title2, 0, 0, 'C');

		// Numbers/Labels
		if ($boxType == 1 ) {
			$this->SetFontSize(10);
			$this->SetXY( (float)$xPos+(float)$colWidth1, (float)$yPos );
			$this->Cell((float)$colWidth2, (float)$rowHeight, '1', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth1+(float)$colWidth2), (float)$yPos);
			$this->Cell((float)$colWidth2, (float)$rowHeight, '2', 0, 0, 'C');
			$this->SetXY( (float)$xPos+((float)$colWidth1*2)+((float)$colWidth2*2), (float)$yPos );
			$this->Cell((float)$colWidth2, (float)$rowHeight, '1', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth1*2)+((float)$colWidth2*3), (float)$yPos);
			$this->Cell((float)$colWidth2, (float)$rowHeight, '2', 0, 0, 'C');

			for ($i = 0;$i < 17; $i++) {
				$iPrint = $i;
				if ($i == 0) {
					$iPrint = 'S';
				}
				$xxPos = $xPos;
				$iCount = $i;
				if ($i > 8 ) {
					$xxPos = $xPos + (float)$colWidth1 + (float)$colWidth2*2;
					$iCount = (int)$i - 9;
				}

				$this->SetXY( (float)$xxPos, (float)$yPos+(($iCount+1)*(float)$rowHeight) );
				$this->Cell((float)$colWidth1, (float)$rowHeight, $iPrint, 1, 0, 'C');
			}
		}
	}


	function PrintInsideBox( $xPos, $yPos, $numCols, $numRows, $boxType, $title ) {
		switch ($boxType) {
			case 1:
				$rowHeight = 00.22;
				$colWidth = 00.85;
				break;
			case 2:
				$rowHeight = 00.22;
				$colWidth = 00.52;
				break;
			case 3:
				$rowHeight = 00.22;
				$colWidth = 00.70;
				break;
			default:
				$rowHeight = 00.22;
				$colWidth = 00.85;
				break;
		}

		for ($i = 0; $i < $numRows; $i++) {
			$this->Line( (float)$xPos, (float)$yPos+($i*(float)$rowHeight), (float)$xPos+($numCols*(float)$colWidth), (float)$yPos+($i*(float)$rowHeight) );
		}

		for ($i = 0; $i < $numCols+1; $i++) {
			if ($i > 0 && $i < $numCols )
				{ $yPosStart = (float)$yPos+(float)$rowHeight; }
			else
				{ $yPosStart = (float)$yPos; }
			$this->Line( (float)$xPos+($i*(float)$colWidth), (float)$yPosStart, (float)$xPos+($i*(float)$colWidth), (float)$yPos+(((float)$numRows-1)*(float)$rowHeight) );
		}

		$this->SetXY((float)$xPos, (float)$yPos);
		$this->SetFontSize(13);
		$this->Cell((float)$colWidth*(float)$numCols, 00.22, $title, 0, 0, 'C');

		if ($boxType == 1 ) {
			$this->SetFontSize(10);
			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Yes', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth), (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'No', 0, 0, 'C');
		}

		if ($boxType == 3 ) {
			$this->SetFontSize(10);
			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Pass/Fail', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth), (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Pass/Fail', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth)*2, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Pass/Fail', 0, 0, 'C');

			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight*2);
			$this->Cell((float)$colWidth, (float)$rowHeight, '1      3', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth), (float)$yPos+(float)$rowHeight*2);
			$this->Cell((float)$colWidth, (float)$rowHeight, '1      3', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth)*2, (float)$yPos+(float)$rowHeight*2);
			$this->Cell((float)$colWidth, (float)$rowHeight, '1      3', 0, 0, 'C');
		}
	}




	function newPrintBox ( $xPos, $yPos, &$colWidth, &$rowWidth, $boxType, $title) {
		switch ($boxType) {
			case 1:
				$fontSize = 16;
				break;
			case 2:
				$fontSize = 16;
				break;
			default:
				$fontSize = 14;
				break;
		}

		foreach ($colWidth as $value) {
			$boxWidth += $value;
		}
		foreach ($rowWidth as $value) {
			$boxHeight += $value;
		}

		// Horizontal Box Lines
		$cumRowWidth = 0;
		for ($i = 0; $i < count($rowWidth); $i++) {
			$cumRowWidth += $rowWidth[$i];
			$this->Line( (float)$xPos, (float)$yPos+(float)$cumRowWidth, (float)$xPos+(float)$boxWidth, (float)$yPos+(float)$cumRowWidth );
		}

		// Vertical Box Lines
		$cumColWidth = 0;
		for ($i = 0; $i < count($colWidth); $i++) {
			$cumColWidth += $colWidth[$i];
			$this->Line( (float)$xPos+(float)$cumColWidth, (float)$yPos, (float)$xPos+(float)$cumColWidth, (float)$yPos+(float)$boxHeight );
		}

		$this->SetFont( 'Helvetica', 'B', $fontSize );
		$this->SetXY((float)$xPos, (float)$yPos-00.30);
		$this->Cell(03.00, 00.40, $title, 0, 0, 'L');



	}

	function PrintBox( $xPos, $yPos, $numCols, $numRows, $boxType, $title ) {
		switch ($boxType) {
			case 1:
			case 2:
				$rowHeight = 00.22;
				$colWidth = 00.85;
				$fontSize = 14;
				break;
			case 3:
				$rowHeight = 00.22;
				$colWidth = 00.50;
				$fontSize = 10;
				break;
			case 4:
				$rowHeight = 00.40;
				$colWidth = 00.60;
				$fontSize = 14;
				break;
			default:
				$rowHeight = 00.22;
				$colWidth = 00.85;
				break;
		}

		for ($i = 0; $i < $numRows; $i++) {
			$this->Line( (float)$xPos, (float)$yPos+($i*(float)$rowHeight), (float)$xPos+($numCols*(float)$colWidth), (float)$yPos+($i*(float)$rowHeight) );
		}

		for ($i = 0; $i < $numCols+1; $i++) {
			$this->Line( (float)$xPos+($i*(float)$colWidth), (float)$yPos, (float)$xPos+($i*(float)$colWidth), (float)$yPos+(((float)$numRows-1)*(float)$rowHeight) );
		}

		$this->SetXY((float)$xPos, (float)$yPos-00.20);
		$this->SetFontSize($fontSize);
		$this->Cell((float)$colWidth*(float)$numCols, 00.20, $title, 0, 0, 'C');

		if ($boxType == 1 ) {
			$this->SetFontSize(10);
			$this->SetXY((float)$xPos, (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Generator', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Natural', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*2), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Ammonia', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*3), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'CP', 0, 0, 'C');
			$this->SetFontSize(6);
			$this->SetXY((float)$xPos+(float)$colWidth*3, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, '%', 0, 0, 'R');
		}

		if ($boxType == 2 ) {
			$this->SetFontSize(10);
			$this->SetXY((float)$xPos, (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, '#/Hour', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, '#/Basket', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*2), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, '#/Drop', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*3), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Tmr Setting', 0, 0, 'C');
			$this->SetFontSize(6);
			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'LBS', 0, 0, 'R');
			$this->SetXY((float)$xPos+(float)$colWidth, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'LBS', 0, 0, 'R');
			$this->SetXY((float)$xPos+(float)$colWidth*2, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'LBS', 0, 0, 'R');
			$this->SetXY((float)$xPos+(float)$colWidth*3, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Sec', 0, 0, 'R');
		}

		if ($boxType == 4) {
			$this->SetFontSize(11);
			$this->SetXY((float)$xPos, (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Heat #', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Furn #', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*2), (float)$yPos-00.06);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Time', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*2), (float)$yPos+00.06);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Loaded', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*3), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Oper #', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*4), (float)$yPos-00.06);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Time', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*4), (float)$yPos+00.06);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Out', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*5), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Oper #', 0, 0, 'C');

			$this->SetFontSize(12);
			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, '1', 0, 0, 'C');
			$this->SetXY((float)$xPos, (float)$yPos+((float)$rowHeight*3));
			$this->Cell((float)$colWidth, (float)$rowHeight, '2', 0, 0, 'C');
			$this->SetXY((float)$xPos, (float)$yPos+((float)$rowHeight*5));
			$this->Cell((float)$colWidth, (float)$rowHeight, '3', 0, 0, 'C');
			$this->SetXY((float)$xPos, (float)$yPos+((float)$rowHeight*7));
			$this->Cell((float)$colWidth, (float)$rowHeight, '4', 0, 0, 'C');
		}
	}

	function PrintStepBox( $xPos, $yPos, $numCols, $numRows, $boxType, $title ) {

		switch ($boxType) {
			case 1:
			case 2:
				$rowHeight = 00.22;
				$colWidth = 00.44;
				break;
			case 3:
			case 4:
				$rowHeight = 00.22;
				$colWidth = 00.52;
				break;
			case 5:
				$rowHeight = 00.22;
				$colWidth = 00.75;
				break;
			default:
				$rowHeight = 00.22;
				$colWidth = 00.50;
				break;
		}

		for ($i = 0; $i < $numRows; $i++) {
			if ($i == 0)
				{ $xPosStart = (float)$xPos+(float)$colWidth; }
			else
				{ $xPosStart = (float)$xPos; }
			$this->Line( (float)$xPosStart, (float)$yPos+($i*(float)$rowHeight), (float)$xPos+($numCols*(float)$colWidth), (float)$yPos+($i*(float)$rowHeight) );
		}

		for ($i = 0; $i < $numCols+1; $i++) {
			if ($i == 0)
				{ $yPosStart = (float)$yPos+(float)$rowHeight; }
			elseif ( ($boxType == 1 || $boxType == 2 ) && (is_numeric($i)&(!($i&1))) )
				{ $yPosStart = (float)$yPos+((float)$rowHeight*00.60);  }
			else
				{ $yPosStart = (float)$yPos; }

			$this->Line( (float)$xPos+($i*(float)$colWidth), (float)$yPosStart, (float)$xPos+($i*(float)$colWidth), (float)$yPos+(((float)$numRows-1)*(float)$rowHeight) );
		}

		$this->SetXY( (float)$xPos, (float)$yPos-00.20 );
		$this->SetFontSize(14);
		$this->Cell( (float)$colWidth*(float)$numCols, 00.20, $title, 0, 0, 'C');

		if ($boxType == 1 || $boxType == 2 ) {
			$this->Line( (float)$xPos+(float)$colWidth, (float)$yPos+((float)$rowHeight*00.60), (float)$xPos+($numCols*(float)$colWidth), (float)$yPos+((float)$rowHeight*00.60) );

			$this->SetFontSize(8);
			$this->SetXY((float)$xPos+(float)$colWidth, (float)$yPos);
			$this->Cell((float)$colWidth*2, (float)$rowHeight*00.60, '1st Hour', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*3), (float)$yPos);
			$this->Cell((float)$colWidth*2, (float)$rowHeight*00.60, '2nd Hour', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*5), (float)$yPos);
			$this->Cell((float)$colWidth*2, (float)$rowHeight*00.60, '3rd Hour', 0, 0, 'C');

			for ($i=1; $i<7; $i++) {
				$this->SetXY( (float)$xPos+((float)$colWidth*$i), (float)$yPos+(float)$rowHeight*00.60 );
				$this->SetFontSize(6);
				if ( (is_numeric($i)&(!($i&1))) )
					{ $heading = 'Washer'; }
				else
					{ $heading = 'Bolt'; }
				$this->Cell((float)$colWidth, (float)$rowHeight*00.40, $heading, 0, 0, 'C');
			}
		}

		if ( $boxType == 1 || $boxType == 2 || $boxType == 3 ) {
			if ($boxType == 1) {
				$iCounter = 11;
			} else {
				$iCounter = 5;
			}
			for ($i=1; $i<$iCounter; $i++) {
				$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight*$i);
				$this->SetFontSize(10);
				if ( $i<(int)$iCounter-2 )
					{ $heading = $i;}
				elseif ( $i == (int)$iCounter-2 )
					{ $heading = 'Avg'; }
				else
					{ $heading = 'Time'; }
				$this->Cell((float)$colWidth, (float)$rowHeight, $heading, 0, 0, 'C');
			}
		}

		if ( $boxType == 4 ) {
			for ($i=1; $i<6; $i++) {
				$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight*$i);
				$this->SetFontSize(10);
				$this->Cell((float)$colWidth, (float)$rowHeight, $i, 0, 0, 'C');
			}
		}

		if ( $boxType == 3 || $boxType == 4 ) {
			$this->SetFontSize(10);
			$this->SetXY((float)$xPos+(float)$colWidth, (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, '1st Hr', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*2), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, '2nd Hr', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*3), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, '3rd Hr', 0, 0, 'C');
		}

		if ( $boxType == 5 ) {
			$this->SetFontSize(10);
			$this->SetXY((float)$xPos+(float)$colWidth, (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Belt Speed', 0, 0, 'C');
			$this->SetXY((float)$xPos+((float)$colWidth*2), (float)$yPos);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Temp', 0, 0, 'C');
			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Hardener', 0, 0, 'R');
			$this->SetXY((float)$xPos, (float)$yPos+(float)$rowHeight*2);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Draw', 0, 0, 'R');

			$this->SetFontSize(6);
			$this->SetXY((float)$xPos+(float)$colWidth, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Min', 0, 0, 'R');
			$this->SetXY((float)$xPos+(float)$colWidth, (float)$yPos+(float)$rowHeight*2);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'Min', 0, 0, 'R');

			$this->SetXY((float)$xPos+(float)$colWidth*2, (float)$yPos+(float)$rowHeight);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'F', 0, 0, 'R');
			$this->SetXY((float)$xPos+(float)$colWidth*2, (float)$yPos+(float)$rowHeight*2);
			$this->Cell((float)$colWidth, (float)$rowHeight, 'F', 0, 0, 'R');
		}
	}


	function PrintLabelData( $labelText, $dataText ) {
		/*$this->SetFont('Helvetica', '', $this->labelFontSize);
		$this->SetX($this->labelColumn);
		$this->Cell($this->labelWidth, $this->lineHeight, $labelText, 0, 0, 'R');
		$this->SetFont('Helvetica', 'B', $this->dataFontSize);
		$this->SetX($this->dataColumn);
		$this->Cell($this->dataWidth, $this->lineHeight, $dataText, 0, 2, 'L');*/
		$this->SetFont('Helvetica', '', $this->labelFontSize);
		$this->SetX($this->labelColumn);
		$this->Cell($this->labelWidth, $this->lineHeight, $labelText, 0, 0, $this->labelalign);
		$this->SetFont('Helvetica', $this->databold, $this->dataFontSize);
		$this->SetX($this->dataColumn);
		$this->Cell($this->dataWidth, $this->lineHeight, $dataText, 0, 2, 'L');
	}

	function PrintLabelDataNum( $labelText, $dataText, $numWidth ) {
		$this->SetFont('Helvetica', '', $this->labelFontSize);
		$this->SetX($this->labelColumn);
		$this->Cell($this->labelWidth, $this->lineHeight, $labelText, 0, 0, 'R');
		$this->SetFont('Helvetica', 'B', $this->dataFontSize);
		$this->SetX($this->dataColumn);
		$this->Cell($numWidth, $this->lineHeight, $dataText, 0, 2, 'R');
	}

	function PrintLabelDataUom( $labelText, $dataText, $uom ) {
		$this->SetFont('Helvetica', '', $this->labelFontSize);
		$this->SetX($this->labelColumn);
		$this->Cell($this->labelWidth, $this->lineHeight, $labelText, 0, 0, 'R');
		$this->SetFont('Helvetica', 'B', $this->dataFontSize);
		$this->SetX($this->dataColumn);
		$this->Cell($this->dataWidth, $this->lineHeight, $dataText, 0, 0, 'R');
		$this->SetX($this->uomColumn);
		$this->Cell($this->dataWidth, $this->lineHeight, $uom, 0, 2, 'L');
	}

	function PrintProcessHeat( $labelText, $minValue, $maxValue, $uom ) {
		$this->SetFont('Helvetica', '', $this->labelFontSize);
		$this->SetX($this->labelColumn);
		$this->Cell($this->labelWidth, $this->lineHeight, $labelText, 0, 0, 'R');
		$this->SetFont('Helvetica', 'B', $this->dataFontSize);
		
		
			$this->SetX($this->minColumn);
			$this->Cell($this->dataWidth, $this->lineHeight, $minValue, 0, 0, 'R');
			$this->SetX($this->maxColumn);
			$this->Cell($this->dataWidth, $this->lineHeight, $maxValue, 0, 0, 'R');
			$this->SetX($this->uomColumn);
			$this->Cell($this->dataWidth, $this->lineHeight, $uom, 0, 2, 'L');
		
	}
	
	function spaceAfterComment($flt_extra_spacing, $str_comment, $flt_line_len)
	{
		/****************************************************
		 *
		 * uses the length of the comment to determine how far to space
		 * the next item
		 */
		$tot_chars =  strlen($str_comment);
		$char_len = number_format($this->FontSizePt/159, 4); 			// 160 is a conversion constant found by experiment
		$chars_on_a_line = $flt_line_len/$char_len;
		$num_of_lines =  ceil($tot_chars/$chars_on_a_line);
		
		$measured_space = number_format(floatval($num_of_lines*$this->lineHeight),3);
		
		return $flt_extra_spacing + $measured_space;
	}
	function print_pdf($int_print_type,$str_file_name,$str_printer_name,$str_trans_ip,$intfk_division_id,$intfk_email_type,$str_subject,$str_drive){
		
		
		
		if (trim($str_printer_name)==''  && $int_print_type==1){
			$int_print_type=0;
		}
		switch ($int_print_type){
			case 0://View
				$this->Output();
				break;
			case 1://Auto Print
//				if ($str_drive==''){
//					$str_drive=server_drive();
//				}
				$port_num = NULL;
				$str_full_file_name=$str_printer_name . 'AA'.date("Ymdhis") .'_' . $str_file_name;
				
				//no longer need to add javascript to the files
				/*$script = '';
				$script .= "var pp = this.getPrintParams(); "
						. "pp.interactive = pp.constants.interactionLevel.automatic; "
						. "pp.bShrinkToFit = true; "
						. "pp.bSilent = true; "
						. "pp.bUI = false; "
						. "pp.printerName = '" . $str_printer_name . "'; "
						. "this.print(pp); \n";
				$this->IncludeJS($script);*/
				
				//$this->Output('../pdfReports/' . $str_full_file_name, 'F');
				
		/*	
			if ($str_trans_ip=='')	{
				//If the Trans Ip is not filled in check that the servers ip subnet is the same
				//as the local Ip subnet
				$str_server_ip=$_SERVER['SERVER_ADDR'];
				$arr_server=explode('.', $str_server_ip);
				$str_local_ip=$_SERVER['REMOTE_ADDR'];
				$arr_local=explode('.', $str_local_ip);
				
				$port_num = NULL;
				
					if ($arr_server[2]!=$arr_local[2]){
						
						//if they dont match we ftp the file to the appropriate server
						switch ($arr_local[2]){
							case '99':
								$str_trans_ip='192.168.99.90';
								$port_num = 22;
								break;
							case '100':
								$str_trans_ip='192.168.100.90';
								$port_num = 22;
								break;
							case '101':
								$str_trans_ip='192.168.101.90';
								break;
							case '104':
								$str_trans_ip='192.168.104.90';
								break;
						}
						
						
					}
					
					
				
			}
			*/
			if ($str_trans_ip!=''){
				
				$this->Output('../pdfReports/transfer/' . $str_full_file_name, 'F');
				require_once '../../../websys/commFTP/commFtp.php';
				
				
				
				sleep(1);
				
				$serv1 = new FtpServer($str_trans_ip, 'erpApp', 'FtpThisFile!', $port_num);
				$ftp = new CommercialFTP();
				
				$ftp->addDestination($serv1);
				$ftp->sendFile('../pdfReports/transfer/'.$str_full_file_name, '/inc/pdfReports');
				
//				cc_other_servers( '../pdfReports/transfer', './inc/pdfReports', $str_full_file_name, $str_trans_ip);
				
			}else{
			
				
				if (file_exists('../pdfReports/bak/' . $str_full_file_name) || file_exists('../pdfReports/' . $str_full_file_name)){
					
					//Dont output if the file already exists
				}else{
					$this->Output('../pdfReports/bak/' . $str_full_file_name, 'F');
				
				
				
					if (file_exists('../pdfReports/bak/' . $str_full_file_name)){
						if(stripos($str_full_file_name, 'invoice') === false){
							
							
							//move the file for standards
							rename('../pdfReports/bak/' . $str_full_file_name,'../pdfReports/' . $str_full_file_name);
							
							
						}else{
							//Keep a copy if it is an invoice
							copy('../pdfReports/bak/' . $str_full_file_name,'../pdfReports/' . $str_full_file_name);
						}
		
						
					}
			}
					/*if (file_exists($str_drive.'/htdocs/ccerp/inc/pdfReports/bak/' . $str_full_file_name)){
					
						//Check the file exists before copy
						copy($str_drive.'/htdocs/ccerp/inc/pdfReports/bak/' . $str_full_file_name,$str_drive.'/htdocs/ccerp/inc/pdfReports/' . $str_full_file_name);
					}
					if (file_exists($str_drive.'/htdocs/ccerp/inc/pdfReports/bak/' . $str_full_file_name) && stripos($str_full_file_name, 'invoice') === false){
						//Check the File Exists before delete  Seperate from the copy check to avoid file missing issue
						unlink($str_drive.'/htdocs/ccerp/inc/pdfReports/bak/' . $str_full_file_name);
					}
					*/
			}
			break;
			
			case 2://Email
				if ($intfk_email_type==''){
					//Dont email if no email type
				}else{

					$this->Output('../pdfReports/pdfEmail/'.$str_file_name, 'F');
					if ($_SERVER['SERVER_ADDR']=='192.168.99.90'  || $_SERVER['SERVER_ADDR']=='192.168.100.90' 
			 		|| $_SERVER['SERVER_ADDR']=='192.168.101.90' || $_SERVER['SERVER_ADDR']=='192.168.104.90' ){
			 			
						$qryEmail=" execute sproc_send_mail_create $intfk_division_id , $intfk_email_type ,'$str_subject', '$str_file_name' ";
						$objResultEmail=fnc_db_query($qryEmail);
						fnc_db_free_result($objResultEmail);
						
			 		}else{
			 			
			 			$str_email_addr='';
			 			$qry_email="select  [dbo].[fun_get_email_address]($intfk_division_id,$intfk_division_id) as str_email";
			 			$objResultEmail=fnc_db_query($qryEmail);
			 			$arrRows = fnc_db_fetch_array($objResultEmail);
			 			$str_email_addr=$arrRows['str_email'];
			 			
			 			fnc_db_free_result($objResultEmail);
			 			if ($str_email_addr<>''){
			 				$this->pdf_email(server_company(1), $intfk_email_type, $str_subject,'../pdfReports/pdfEmail/'.$str_file_name,$str_email_addr);
			 			}
			 		}
					
				}
				break;
	}	
	}
function pdf_email($str_Company,$str_email_type,$str_subject,$str_file_name='',$str_email='',$str_body='',$quote_no='',$str_from=''){

	//NOTE:----------$str_file_name has login employee's email address------------------------
	//NOTE:----------$str_email has all Customer email address------------------------
	
	require_once ('../node_modules/mail/PHPMailerAutoload.php');
require_once ('../node_modules/mail/class.phpmailer.php');
require_once ('../node_modules/mail/class.smtp.php');
	
		//include_once('class.phpmailer.php');
		//require_once ('../node_modules/mail/class.phpmailer.php');
		$str_disclaimer="</br> </br> "."This is an automated email, please do not reply to this email address."   ."</br> </br> ".
		"This message, including any attachments, may contain confidential information intended only for a specific individual and purpose. The information is considered private and legally protected by law. If you are not the intended recipient, please destroy all copies. You are hereby notified that any dissemination, distribution, copying or use of the content of this transmission is strictly prohibited.";
		
		//$smtp=new SMTP();
		
		
		$mail = new PHPMailer();
		
		if ($str_email!=''){
			
			if ($str_Company==1){
				$mail->From      = $str_from;
			}elseif ($str_Company==4){
				$mail->From      = 'no-reply@curtisthermal.com';
			}else {
				$mail->From      = 'no-reply@curtismetal.com';
			}
			$mail->FromName  = $str_email_type;
			$mail->Subject   = $str_subject;
			
			
				$arr_email=explode(';', $str_email);
				$int_email_count=count($arr_email);
				for ( $intCounter = 0; $intCounter < $int_email_count; $intCounter++ ) {
					//$mail->AddAddress( 'jason.joye@curtismetal.com' );
					$mail->AddAddress( $arr_email[$intCounter] );
				}

					$mail->AddAddress( $str_file_name );

				//Test by veera
				
				
				//
			//if ($str_file_name!=''){
				
				$mail->addAttachment('C:/htdocs/Quote_System/inc/PDF/Quote'.$quote_no.'.pdf');         // Add attachments
				$mail->isHTML(true);
			//}
			$mail->Body      =  $str_body . "</br> " .$str_disclaimer;
			
			
			//$mail->AddAttachment( $file_to_attach , 'ChangeRequest.xlsx' );
			
		if(!$mail->send()) {
			return 'Failed to send eamil';
		} else {
			return 'Email sent';
		}
		}
	
}
	
//-------------Added By Veera----------------


function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}


function NbLinesSplit($w,$txt,$lineno)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    $cnt=0;
    while($i<$nb)
    {
        $c=$s[$i];
         $cnt+=1;
    		$a[$cnt]= $nl;
    if($nl==$lineno){
            	$Stringposition=$i;
            	break;
            }
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
    	 
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
           
        }
        else{
            $i++;
     
        }
    /* if($nl=='12'){
            	$Stringposition=$i;
            	break;
            }*/
    }
    return $Stringposition;
}

}

?>
