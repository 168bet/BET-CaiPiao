<?
function show_voucher($line,$id){
	//$id=$id+793986776;
	switch($line){
	case 4:
		$show_voucher='DT'.($id+848986776);
		break;	
	case 5:
		$show_voucher='DT'.($id+848986746);
		break;
	case 15:
		$show_voucher='DT'.($id+848996576);
		break;
	case 25:
		$show_voucher='DT'.($id+848996376);
		break;
	case 6:
		$show_voucher='DT'.($id+848909676);
		break;
	case 7:
		$show_voucher='P'.($id+8489096176);
		break;
	case 8:
		$show_voucher='PR'.($id+848096976);
		break;				
	case 14:
		$show_voucher='DT'.($id+848995776);
	case 16:
		$show_voucher='DT'.($id+848995646);
		break;
	default:
		$show_voucher='OU'.($id+848996577);
		break;
	}
	return $show_voucher;
}
function wterror($msg){
	$test="<html>";
	$test=$test."<head>";
	$test=$test."<title>error</title>";
	$test=$test."<meta http-equiv=Content-Type content=text/html; charset=gb2312>";
	$test=$test."<STYLE> A:visit { color=#6633cc; text-decoration: none ;}";
	$test=$test."tr {  font-family: Arial; font-size: 12px; color: #CC0000}";
	$test=$test.".b_13set {  font-size: 15px; font-family: Arial; color: #FFFFFF; padding-top: 2px; padding-left: 5px}";
	$test=$test.".b_tab {  border: 1px #000000 solid; background-color: #D2D2D2}";
	$test=$test.".b_back {  height: 20px; padding-top: 5px; color: #FFFFFF; cursor: hand; padding-left: 50px}";
	$test=$test."a:link {  color: #0000FF}";
	$test=$test."a:hover {  color: #CC0000}";
	$test=$test."a:visited {  color: #0000FF}";
	$test=$test."</STYLE>";
	$test=$test."</head>";
	$test=$test."<body text=#000000 leftmargin=0 topmargin=10 bgcolor=535E63 vlink=#0000FF alink=#0000FF>";
	$test=$test."<table width=600 border=0 cellspacing=0 cellpadding=0 align=center>";
	$test=$test."  <tr>";
	$test=$test."    <td width=36><img src=/images/agents/control/error_p11.gif width=36 height=63></td>";
	$test=$test."    <td background=/images/agents/control/error_p12b.gif>&nbsp;</td>";
	$test=$test."    <td width=160><img src=/images/agents/control/error_p13.gif width=160 height=63></td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."<table width=598 border=0 cellspacing=0 cellpadding=0 align=center class=b_tab>";
	$test=$test."  <tr bgcolor=#000000> ";
	$test=$test."    <td ><img src=/images/agents/control/error_dot.gif width=23 height=22></td>";
	$test=$test."    <td class=b_13set width=573>�?nbsp;�?nbsp;�?nbsp;息</td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2 align=center><br>";
	$test=$test."      $msg<BR><br>";
	$test=$test."      &nbsp; </td>";
	$test=$test."  </tr>";
	$test=$test."  <tr> ";
	$test=$test."    <td colspan=2>";
	$test=$test."      <table width=598 border=0 cellspacing=0 cellpadding=0 bgcolor=A0A0A0>";
	$test=$test."        <tr>";
	$test=$test."          <td>&nbsp;</td>";
	$test=$test."          <td background=/images/agents/control/error_p3.gif width=120><a href=javascript:history.go(-1)><span class=b_back>回上一�?/span></a></td>";
	$test=$test."        </tr>";
	$test=$test."      </table>";
	$test=$test."    </td>";
	$test=$test."  </tr>";
	$test=$test."</table>";
	$test=$test."</body>";
	$test=$test."</html>";
	return $test;
}
function odds_dime($mbin1,$tgin1,$dime,$mtype){
	$dime=str_replace('��','',$dime);
	$dime=str_replace('С','',$dime);
	$dime=str_replace('O','',$dime);
	$dime=str_replace('U','',$dime);
	$total_inball=$mbin1+$tgin1;
	$dime_odds=explode("/",$dime);
	switch (sizeof($dime_odds)){
	case 1:
		$odds_inball=$total_inball-$dime_odds[0];
		if (strlen($dime_odds[0])>2){
				
			switch ($mtype){
			case 'OUH':
				if ($odds_inball>0){
					$grape=-1;
				}else if ($odds_inball<0){
					$grape=1;
				}
				
				break;
			case 'OUC':
				if ($odds_inball>0){
					$grape=1;
				}else if ($odds_inball<0){
					$grape=-1;
				}
				break;
			}
			
		}else{
			
			switch ($mtype){
			case 'OUH':
				
				if ($odds_inball>0){
					$grape=-1;
				}else if ($odds_inball<0){
					$grape=1;
				}else if ($odds_inball==0){
					$grape=0;
				}
				
				break;
			case 'OUC':
				
				if ($odds_inball>0){
					$grape=1;
			
					
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0;
				}
				break;
				
				
			}
		}
		break;
	case 2:
		
		if (strlen($dime_odds[1])>2){
			$odds_inball=$total_inball-$dime_odds[0];
			
			
			

			switch ($mtype){
			case "OUC":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			case "OUH":
				if ($odds_inball>0){
					$grape=-1;
				}else if($odds_inball<0){
					$grape=1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			}
		}else{
			$odds_inball=$total_inball-$dime_odds[1];
			switch ($mtype){
			case "OUC":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			case "OUH":
				if ($odds_inball>0){
					$grape=-1;
				}else if($odds_inball<0){
					$grape=1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			}
		}
		break;
	}
	$odds_dime=$grape;
	return $odds_dime;
}
//让球计算:
function odds_letb($mbin,$tgin,$showtype,$dime,$mtype){
/*
if(eregi("[+]",$dime))
{echo $dime."1";
exit;}
elseif(eregi("[-]",$dime)){echo $dime."2";}else{echo "3";exit;}*/
 //echo $mbin.$tgin.$showtype.$dime.$mtype."1";
	// exit;
   if(eregi("[+]",$dime)){
	$letb_odds=explode("+",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				}
				break;
			}
		}else{
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			}
			
			
		}
		break;	
	case 2:
		if (strlen($letb_odds[1])>2){
		//半球在后1/1.5
		
			switch ($showtype){
			
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						//$grade=-1*$letb_odds[1]/100;
						if($letb_odds[1]==100){$grade=1;}else{$grade=-1*$letb_odds[1]/100;}
					}
					break;
				case 'RC':
				
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
					  if($letb_odds[1]==100){$grade=-1;}else{$grade=1*$letb_odds[1]/100;}
						
						
					}
					
					//echo $showtype.$mtype.$grade."=".$mbin."=".$tgin."=".$abcd."<".$letb_odds[0]."-".$letb_odds[1];
		//exit;
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin;
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						//$grade=1*$letb_odds[1]/100;
						if($letb_odds[1]==100){$grade=-1;}else{$grade=1*$letb_odds[1]/100;}
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						//$grade=-1*$letb_odds[1]/100;
						if($letb_odds[1]==100){$grade=1;}else{$grade=-1*$letb_odds[1]/100;}
					}
					break;
				}
				break;
			}
		}else{
			
			switch ($showtype){

			case "H"://让球方是主队0.5/1
				
				$abcd=$mbin-$tgin;
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				//$abcd=$tgin-$mbin-$letb_odds[1];
				$abcd=$tgin-$mbin;
				//echo $abcd;
				//echo $letb_odds[1];
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
						//echo $grade;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
						//echo $grade;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
						//echo $grade;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
						//echo $grade*1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
						//echo $letb_odds[0];
					}
					break;
				}
				break;
			}
		}
		break;
	} 
   
  }
   elseif(eregi("[-]",$dime)){
   	$letb_odds=explode("-",$dime);
	//echo $letb_odds[0]."<>".$letb_odds[1];
	//exit;
	
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				}
				break;
			}
		}else{
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			}
			
			
		}
		break;	
	case 2:
	//echo strlen($letb_odds[1]);
	//exit;
		if (strlen($letb_odds[1])>2){
		//半球在后1/1.5
		//echo $showtype;
		//	exit;
			switch ($showtype){
			
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				//echo $abcd;
				//exit;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin;
				//echo $abcd;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			}
		}else{
			//echo strlen($letb_odds[1]);
	//exit;
	//echo $showtype;
	//exit;
	
			switch ($showtype){
                
				
			case "H"://让球方是主队0.5/1
				
				$abcd=$mbin-$tgin;
				//echo $mtype;
			//	exit;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					//echo $grade;
		//	exit;
					
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				//$abcd=$tgin-$mbin-$letb_odds[1];
				$abcd=$tgin-$mbin;
				//echo $abcd;
				//echo $letb_odds[1];
				//echo strlen($letb_odds[1]);

	
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
						//echo $grade;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
						//echo $grade;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					//echo $grade;
					//echo $showtype;
//	echo $mtype;
	//exit;
					
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
						//echo $grade;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
						//echo $grade*1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
						//echo $letb_odds[0];
					}
					break;
				}
				break;
			}
		}
		break;
	} 
   
   
   }
   else{//这里指的是另外的。注意这�?
   $letb_odds=explode("/",$dime);
	switch (sizeof($letb_odds)){
    case 1:
		if (strlen($letb_odds[0])>2){
		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				}
				break;
			}
		}else{
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RC':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			}
			
			
		}
		break;	
   
   }
   
   }
   
	
	$odds_letb=$grade;
	return $odds_letb;
}
function odds_win($mbin,$tgin,$showtype,$dime,$mtype){
	$letb_odds=explode("/",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				}
				break;
			}
		}else{
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			}
			
			
		}
		break;	
	case 2:
		if (strlen($letb_odds[1])>2){
		//半球在后1/1.5
		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				}
				break;
			}
		}else{
			
			switch ($showtype){

			case "H"://让球方是主队0.5/1
				
				$abcd=$mbin-$tgin-$letb_odds[1];
				
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[1];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				}
				break;
			}
		}
		break;
	}
	
	$odds_win=$grade;
	return $odds_win;
}
function odds_pd($mb_in_score,$tg_in_score,$m_place){
    $mb_score=$mb_in_score-$tg_in_score;
	$tg_score=$tg_in_score-$mb_in_score;
	$betplace='PDH'.$mb_score.'C'.$tg_score;
	//echo $betplace;
	if ($m_place==$betplace){
		$grade=1;
	}else{
		$grade=-1;
	}	
	$odds_pd=$grade;
	return $odds_pd;
}	

function odds_half($mb_in_score_hr,$tg_in_score_hr,$mb_in_score,$tg_in_score,$m_place){
	$grade=0;
	if ($mb_in_score_hr>$tg_in_score_hr){
		$m_w1="H";
	}elseif ($mb_in_score_hr==$tg_in_score_hr){
		$m_w1="N";
	}else{
		$m_w1="C";
	}

	if ($mb_in_score>$tg_in_score){
		$m_w2="H";
	}elseif ($mb_in_score==$tg_in_score){
		$m_w2="N";
	}else{
		$m_w2="C";
	}
	$m_w="F$m_w1$m_w2";
	if ($m_place==$m_w){
		$grade=1;
	}else{
		$grade=-1;
	}
	$odds_half=$grade;
	return $odds_half;
}

function win_chk($mbin,$tgin,$m_type){
	$grade=0;
	switch ($m_type){
	case 'H':
		if ($mbin>$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'C':
		if ($mbin<$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'N':
		if ($mbin==$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	}
	$win_chk=$grade;
	return $win_chk;
}

function odds_p($mid,$mtype,$mrate){
		$winrate=1;
		$mid=explode(',',$mid);
		$mtype=explode(',',$mtype);
		$rate1=explode(',',$mrate);
		for($i=0;$i<sizeof($mid);$i++){
			$sql="select MB_Inball,TG_Inball from foot_match where ID=".$mid[$i];
			$result1 = mysql_db_query($dbname, $sql);
			$rowr = mysql_fetch_array($result1);
			$mb_in=$rowr['MB_Inball'];
			$tg_in=$rowr['TG_Inball'];
			if ($mb_in<>'' and $tg_in<>''){
				$graded=win_chk($mb_in,$tg_in,$mtype[$i]);
				switch ($graded){
				case "1":
					$winrate=$winrate*($rate1[$i]);
					break;
				case "-1":
					$winrate=0;
					break;
				case "0":
					$winrate=0;
					break;
				}		
			}else{
					$winrate=0;			
			}	

		}
		$odd_p=$winrate;
		return $odd_p;
}

function odd_pr($mid,$mtype,$mrate,$mplace,$showtype){
		$winrate=1;
		$mid=explode(',',$mid);
		$mtype=explode(',',$mtype);
		$rate=explode(',',$mrate);
		$letb=explode(',',$mplace);
		$show=explode(',',$showtype);
		$cou=sizeof($mid);
		$count=0;
		for($i=0;$i<$cou;$i++){
			$sql="select MB_Inball,TG_Inball from foot_match where ID=".$mid[$i];
			$result1 = mysql_db_query($dbname, $sql);
			$rowr = mysql_fetch_array($result1);
			$mb_in=$rowr['MB_Inball'];
			$tg_in=$rowr['TG_Inball'];
			$graded=letb_chk($mb_in,$tg_in,$show[$i],$letb[$i],$mtype[$i]);
			switch ($graded){
			case "1":
				$winrate=$winrate*(1+$rate[i]);
				break;
			case "-1":
				$winrate=0;
				break;
			case "0":
				$winrate=$winrate;
				break;
			case "0.5":
				$winrate=$winrate*(1+$rate[i]/2);
				break;
			case "-0.5":
				if ($count>1){
					$winrate=0;
				}else{
					$winrate=$winrate*(1/2);
				}

				$count=$count+1;
				break;
			}
		}
		$odd_pr=$winrate;
		return $odd_pr;
}
function change_rate($c_type,$c_rate){
	switch($c_type){
	case 'A':
		$t_rate='0.03';
		break;
	case 'B':
		$t_rate='0.01';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='-0.015';
		break;
	}
	if ($c_rate!=''){
	$change_rate=number_format($c_rate-$t_rate,3);
	if ($change_rate<=0){
		$change_rate='';
	}
	}else{
	$change_rate='';
	}
	return $change_rate;
}

function change_current($c_type){
	switch(trim($c_type)){
	case 'HKD':
		$change_current='$mem_radio_HKD';
		break;
	case 'USD':
		$change_current=$mem_radio_USD;
		break;
	case 'MYR':
		$change_current=$mem_radio_MYR;
		break;
	case 'SGD':
		$change_current=$mem_radio_SGD;
		break;
	case 'THB':
		$change_current=$mem_radio_THB;
		break;
	case 'GBP':
		$change_current=$mem_radio_GBP;
		break;
	case 'JPY':
		$change_current=$mem_radio_JPY;
		break;
	case 'EUR':
		$change_current=$mem_radio_EUR;
		break;
	case 'RMB':
		$change_current='$mem_current';
		break;
	case '':
		$change_current='$mem_current';
		break;
	}
	return $change_current;
}

?>