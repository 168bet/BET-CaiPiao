<?
function show_voucher($line,$id){
switch($line){
	case 1:
		$show_voucher='OU'.($id+29027142);
		break;
	case 2:
		$show_voucher='OU'.($id+29027142);
		break;
	case 3:
		$show_voucher='OU'.($id+29027142);
		break;
	case 4:
		$show_voucher='DT'.($id+29027142);
		break;	
	case 5:
		$show_voucher='DT'.($id+29027142);
		break;
	case 6:
		$show_voucher='DT'.($id+29027142);
		break;
	case 7:
		$show_voucher='P'.($id+29027142);
		break;
	case 8:
		$show_voucher='PR'.($id+29657821);
		break;				
	case 9:
		$show_voucher='OU'.($id+29027142);
		break;
	case 10:
		$show_voucher='OU'.($id+29027142);
		break;
	case 11:
		$show_voucher='OU'.($id+29027142);
		break;
	case 12:
		$show_voucher='OU'.($id+29027142);
		break;
	case 13:
		$show_voucher='OU'.($id+29027142);
		break;
	case 14:
		$show_voucher='DT'.($id-29127142);
		break;
	case 15:
		$show_voucher='OU'.($id+29027142);
		break;
	case 19:
		$show_voucher='OU'.($id+29027142);
		break;
	case 20:
		$show_voucher='OU'.($id+29027142);
		break;
	
	}
	return $show_voucher;
}
//大小球计算：
function odds_dime($mbin1,$tgin1,$dime,$mtype){
	$dime=str_replace('大','',$dime);
	$dime=str_replace('小','',$dime);
	$dime=str_replace('O','',$dime);
	$dime=str_replace('U','',$dime);	
	$total_inball=$mbin1+$tgin1;	
	$dime_odds=explode("/",$dime);
	switch (sizeof($dime_odds)){
	case 1:
		$odds_inball=$total_inball-$dime_odds[0];
		switch ($mtype){//下大
		case 'OUH':
			if ($odds_inball>0){
				$grape=1;
			}else if ($odds_inball<0){
				$grape=-1;
			}else{
				$grape=0;
			}
			break;
		case 'OUC'://下小
			if ($odds_inball>0){
				$grape=-1;
			}else if ($odds_inball<0){
				$grape=1;
			}else{
				$grape=0;
			}
			break;
		}
		break;
	case 2:
		if (ceil($dime_odds[0])==$dime_odds[0]){
			$odds_inball=$total_inball-$dime_odds[0];
			switch ($mtype){
			case "OUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			case "OUC":
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
			case "OUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			case "OUC":
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
	case 2:
		if (strlen($letb_odds[1])>2){//半球在后1/1.5
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
						if ($letb_odds[1]==100){
						    $grade=1;
						}else{
						    $grade=-1*$letb_odds[1]/100;
						}
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
					    if ($letb_odds[1]==100){
						    $grade=-1;
						}else{
						    $grade=1*$letb_odds[1]/100;
						}
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						if($letb_odds[1]==100){$grade=-1;}else{$grade=1*$letb_odds[1]/100;}
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
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
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'RH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'RC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			}
		}
		break;
	} 
    }else if(eregi("[-]",$dime)){
   	$letb_odds=explode("-",$dime);
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
	case 2:
		if (strlen($letb_odds[1])>2){
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
			switch ($showtype){
			case "H"://让球方是主队0.5/1
				$abcd=$mbin-$tgin;
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
		}
		break;
	} 
    }else{//这里指的是另外的。注意这里
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
	case 2:
		if (strlen($letb_odds[1])>2){		
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
						$grade=-0.5;
					}
					break;
				case 'RC':
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
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'RC':
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
				case 'RH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'RC':
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
				case 'RH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'RC':
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
	}	
	$odds_letb=$grade;
	return $odds_letb;
}
//上半大小球计算：
function odds_dime_v($mbin1,$tgin1,$dime,$mtype){
	$dime=str_replace('大','',$dime);
	$dime=str_replace('小','',$dime);
	$dime=str_replace('O','',$dime);
	$dime=str_replace('U','',$dime);	
	$total_inball=$mbin1+$tgin1;	
	$dime_odds=explode("/",$dime);
	switch (sizeof($dime_odds)){
	case 1:
		$odds_inball=$total_inball-$dime_odds[0];
		switch ($mtype){//下大
		case 'VOUH':
			if ($odds_inball>0){
				$grape=1;
			}else if ($odds_inball<0){
				$grape=-1;
			}else{
				$grape=0;
			}
			break;
		case 'VOUC'://下小
			if ($odds_inball>0){
				$grape=-1;
			}else if ($odds_inball<0){
				$grape=1;
			}else{
				$grape=0;
			}
			break;
		}
		break;
	case 2:
		if (ceil($dime_odds[0])==$dime_odds[0]){
			$odds_inball=$total_inball-$dime_odds[0];
			switch ($mtype){
			case "VOUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			case "VOUC":
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
			case "VOUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			case "VOUC":
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
//上半让球计算:
function odds_letb_v($mbin,$tgin,$showtype,$dime,$mtype){
    if(eregi("[+]",$dime)){
	$letb_odds=explode("+",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRC':
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
		if (strlen($letb_odds[1])>2){//半球在后1/1.5
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						if ($letb_odds[1]==100){
						    $grade=1;
						}else{
						    $grade=-1*$letb_odds[1]/100;
						}
					}
					break;
				case 'VRC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
					    if ($letb_odds[1]==100){
						    $grade=-1;
						}else{
						    $grade=1*$letb_odds[1]/100;
						}
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						if($letb_odds[1]==100){$grade=-1;}else{$grade=1*$letb_odds[1]/100;}
					}
					break;
				case 'VRC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
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
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'VRC':
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
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'VRC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			}
		}
		break;
	} 
    }else if(eregi("[-]",$dime)){
   	$letb_odds=explode("-",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRC':
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
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'VRC':
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
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'VRC':
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
			switch ($showtype){
			case "H"://让球方是主队0.5/1
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'VRC':
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
				switch ($mtype){
				case 'VRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}					
					break;
				case 'VRC':
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
		}
		break;
	} 
    }else{//这里指的是另外的。注意这里
	$letb_odds=explode("/",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRC':
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
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'VRC':
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
				case 'VRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'VRC':
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
	}	
	$odds_letb=$grade;
	return $odds_letb;
}
//滚球大小球计算：
function odds_dime_rb($mbin1,$tgin1,$dime,$mtype){
	$dime=str_replace('大','',$dime);
	$dime=str_replace('小','',$dime);
	$dime=str_replace('O','',$dime);
	$dime=str_replace('U','',$dime);	
	$total_inball=$mbin1+$tgin1;	
	$dime_odds=explode("/",$dime);
	switch (sizeof($dime_odds)){
	case 1:
		$odds_inball=$total_inball-$dime_odds[0];
		switch ($mtype){//下大
		case 'ROUH':
			if ($odds_inball>0){
				$grape=1;
			}else if ($odds_inball<0){
				$grape=-1;
			}else{
				$grape=0;
			}
			break;
		case 'ROUC'://下小
			if ($odds_inball>0){
				$grape=-1;
			}else if ($odds_inball<0){
				$grape=1;
			}else{
				$grape=0;
			}
			break;
		}
		break;
	case 2:
		if (ceil($dime_odds[0])==$dime_odds[0]){
			$odds_inball=$total_inball-$dime_odds[0];
			switch ($mtype){
			case "ROUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			case "ROUC":
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
			case "ROUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			case "ROUC":
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
//滚球让球计算:
function odds_letb_rb($mbin,$tgin,$showtype,$dime,$mtype){
    if(eregi("[+]",$dime)){
	$letb_odds=explode("+",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RRC':
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
		if (strlen($letb_odds[1])>2){//半球在后1/1.5
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						if ($letb_odds[1]==100){
						    $grade=1;
						}else{
						    $grade=-1*$letb_odds[1]/100;
						}
					}
					break;
				case 'RRC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
					    if ($letb_odds[1]==100){
						    $grade=-1;
						}else{
						    $grade=1*$letb_odds[1]/100;
						}
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						if($letb_odds[1]==100){$grade=-1;}else{$grade=1*$letb_odds[1]/100;}
					}
					break;
				case 'RRC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
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
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'RRC':
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
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'RRC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			}
		}
		break;
	} 
    }else if(eregi("[-]",$dime)){
   	$letb_odds=explode("-",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RRC':
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
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'RRC':
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
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'RRC':
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
			switch ($showtype){
			case "H"://让球方是主队0.5/1
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'RRC':
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
				switch ($mtype){
				case 'RRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}					
					break;
				case 'RRC':
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
		}
		break;
	} 
    }else{//这里指的是另外的。注意这里
	$letb_odds=explode("/",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'RRC':
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
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'RRC':
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
				case 'RRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'RRC':
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
	}	
	$odds_letb=$grade;
	return $odds_letb;
}
//滚球上半大小球计算：
function odds_dime_vrb($mbin1,$tgin1,$dime,$mtype){
	$dime=str_replace('大','',$dime);
	$dime=str_replace('小','',$dime);
	$dime=str_replace('O','',$dime);
	$dime=str_replace('U','',$dime);	
	$total_inball=$mbin1+$tgin1;	
	$dime_odds=explode("/",$dime);
	switch (sizeof($dime_odds)){
	case 1:
		$odds_inball=$total_inball-$dime_odds[0];
		switch ($mtype){//下大
		case 'VROUH':
			if ($odds_inball>0){
				$grape=1;
			}else if ($odds_inball<0){
				$grape=-1;
			}else{
				$grape=0;
			}
			break;
		case 'VROUC'://下小
			if ($odds_inball>0){
				$grape=-1;
			}else if ($odds_inball<0){
				$grape=1;
			}else{
				$grape=0;
			}
			break;
		}
		break;
	case 2:
		if (ceil($dime_odds[0])==$dime_odds[0]){
			$odds_inball=$total_inball-$dime_odds[0];
			switch ($mtype){
			case "VROUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			case "VROUC":
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
			case "VROUH":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			case "VROUC":
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
//滚球上半让球计算:
function odds_letb_vrb($mbin,$tgin,$showtype,$dime,$mtype){
    if(eregi("[+]",$dime)){
	$letb_odds=explode("+",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRRC':
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
		if (strlen($letb_odds[1])>2){//半球在后1/1.5
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						if ($letb_odds[1]==100){
						    $grade=1;
						}else{
						    $grade=-1*$letb_odds[1]/100;
						}
					}
					break;
				case 'VRRC':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
					    if ($letb_odds[1]==100){
						    $grade=-1;
						}else{
						    $grade=1*$letb_odds[1]/100;
						}
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						if($letb_odds[1]==100){$grade=-1;}else{$grade=1*$letb_odds[1]/100;}
					}
					break;
				case 'VRRC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
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
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'VRRC':
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
				$abcd=$tgin-$mbin;
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'VRRC':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				}
				break;
			}
		}
		break;
	} 
    }else if(eregi("[-]",$dime)){
   	$letb_odds=explode("-",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRRC':
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
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'VRRC':
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
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}
					break;
				case 'VRRC':
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
			switch ($showtype){
			case "H"://让球方是主队0.5/1
				$abcd=$mbin-$tgin;
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=-1;
					}else if($abcd>$letb_odds[0]){
						$grade=1;
					}else if($abcd==$letb_odds[0]){
						$grade=-1*$letb_odds[1]/100;
					}
					break;
				case 'VRRC':
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
				switch ($mtype){
				case 'VRRH':
					if ($abcd<$letb_odds[0]){
						$grade=1;
					}else if($abcd>$letb_odds[0]){
						$grade=-1;
					}else if($abcd==$letb_odds[0]){
						$grade=1*$letb_odds[1]/100;
					}					
					break;
				case 'VRRC':
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
		}
		break;
	} 
    }else{//这里指的是另外的。注意这里
	$letb_odds=explode("/",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){		
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'VRRC':
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
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'VRRC':
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
				case 'VRRH':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'VRRC':
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
	}	
	$odds_letb=$grade;
	return $odds_letb;
}
//波胆计算：
function odds_pd($mb_in_score,$tg_in_score,$m_place){

	$betplace='MB'.$mb_in_score.'TG'.$tg_in_score;
	if ($m_place=='OVMB' and $mb_in_score>4){
		$grade=1;
	}elseif ($m_place=='OVMB' and $tg_in_score>4){
		$grade=1;
	}elseif ($m_place==$betplace){
		$grade=1;
	}else{
		$grade=-1;
	}

	$odds_pd=$grade;
	return $odds_pd;
}
//上半波胆计算：
function odds_pd_v($mb_in_score_v,$tg_in_score_v,$m_place){

	$betplace='MB'.$mb_in_score_v.'TG'.$tg_in_score_v;
	if ($m_place=='OVMB' and $mb_in_score_v>4){
		$grade=1;
	}elseif ($m_place=='OVMB' and $tg_in_score_v>4){
		$grade=1;
	}elseif ($m_place==$betplace){
		$grade=1;
	}else{
		$grade=-1;
	}

	$odds_pd_v=$grade;
	return $odds_pd_v;
}
//单双计算:
function odds_eo($mb_in_score,$tg_in_score,$m_place){
    $inball=($mb_in_score+$tg_in_score);
	switch ($inball%2){
		case 1:
			if ($m_place=='ODD'){
				$grade=1;
			}else{
				$grade=-1;
			}
			break;
		case 0:
			if ($m_place=='EVEN'){
				$grade=1;
			}else{
				$grade=-1;
			}
			break;
		}
	$odds_eo=$grade;
	return $odds_eo;
}
//入球数计算:
function odds_t($mb_in_score,$tg_in_score,$m_place){
	$inball=$mb_in_score+$tg_in_score;
	if ($inball>=0 and $inball<=1){
		$goin_place="0~1";
	}else if ($inball>=2 and $inball<=3){
		$goin_place="2~3";
	}else if ($inball>=4 and $inball<=6){
		$goin_place="4~6";
	}else if ($inball>=7){
		$goin_place="OVER";
	} 
	if ($m_place==$goin_place){
		$grade=1;
	}else{
		$grade=-1;
	}
	$odds_t=$grade;
	return $odds_t;
}
//入球数计算:
function odds_bst($mb_in_score,$tg_in_score,$m_place){
	$inball=$mb_in_score+$tg_in_score;
	if ($inball>=1 and $inball<=2){
		$goin_place="1~2";
	}else if ($inball>=3 and $inball<=4){
		$goin_place="3~4";
	}else if ($inball>=5 and $inball<=6){
		$goin_place="5~6";
	}else if ($inball>=5 and $inball<=6){
		$goin_place="5~6";
	}else if ($inball>=7 and $inball<=8){
		$goin_place="7~8";
	}else if ($inball>=9 and $inball<=10){
		$goin_place="9~10";
	}else if ($inball>=11 and $inball<=12){
		$goin_place="11~12";
	}else if ($inball>=13 and $inball<=14){
		$goin_place="13~14";
	}else if ($inball>=15 and $inball<=16){
		$goin_place="15~16";
	}else if ($inball>=17 and $inball<=18){
		$goin_place="17~18";	
	}else if ($inball>=19){
		$goin_place="19UP";
	} 
	if ($m_place==$goin_place){
		$grade=1;
	}else{
		$grade=-1;
	}
	$odds_bst=$grade;
	return $odds_bst;
}	
//半全计算：
function odds_half($mb_in_score_v,$tg_in_score_v,$mb_in_score,$tg_in_score,$m_place){
	$grade=0;
	if ($mb_in_score_v>$tg_in_score_v){
		$m_w1="H";
	}elseif ($mb_in_score_v==$tg_in_score_v){
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
//独赢计算：
function win_chk($mbin,$tgin,$m_type){
	$grade=0;
	switch ($m_type){
	case 'MH':
		if ($mbin>$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'MC':
		if ($mbin<$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'MN':
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
//上半独赢计算：
function win_chk_v($mbin,$tgin,$m_type){
	$grade=0;
	switch ($m_type){
	case 'VMH':
		if ($mbin>$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'VMC':
		if ($mbin<$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'VMN':
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
//独赢计算：
function win_chk_rb($mbin,$tgin,$m_type){
	$grade=0;
	switch ($m_type){
	case 'RMH':
		if ($mbin>$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'RMC':
		if ($mbin<$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'RMN':
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
//上半独赢计算：
function win_chk_vrb($mbin,$tgin,$m_type){
	$grade=0;
	switch ($m_type){
	case 'VRMH':
		if ($mbin>$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'VRMC':
		if ($mbin<$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'VRMN':
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
//标准过关计算：
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
//让球过关计算：
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
?>