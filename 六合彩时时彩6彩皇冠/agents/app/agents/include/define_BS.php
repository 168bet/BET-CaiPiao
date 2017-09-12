<?
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
						if ($letb_odds[1]==100){
						    $grade=-1;
						}else{
						    $grade=1*$letb_odds[1]/100;
						}
					}
					break;
				case 'RC':
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
   
  }
   elseif(eregi("[-]",$dime)){
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
   }
   }
	$odds_letb=$grade;
	return $odds_letb;
}
?>