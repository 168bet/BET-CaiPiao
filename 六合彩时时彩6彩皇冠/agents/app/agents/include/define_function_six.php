<?
function show_voucher($line,$id){
switch($line){
	case 1:
		$show_voucher='SIX'.($id+100000);
		break;
	case 2:
		$show_voucher='SIX'.($id+100000);
		break;
	case 3:
		$show_voucher='SIX'.($id+100000);
		break;
	case 4:
		$show_voucher='SIX'.($id+100000);
		break;	
	case 5:
		$show_voucher='SIX'.($id+100000);
		break;
	case 6:
		$show_voucher='SIX'.($id+100000);
		break;
	case 7:
		$show_voucher='SIX'.($id+100000);
		break;
	case 8:
		$show_voucher='SIX'.($id+100000);
		break;				
	case 9:
		$show_voucher='SIX'.($id+100000);
		break;
	case 10:
		$show_voucher='SIX'.($id+100000);
		break;
	case 11:
		$show_voucher='SIX'.($id+100000);
		break;
	case 12:
		$show_voucher='SIX'.($id+100000);
		break;
	case 13:
		$show_voucher='SIX'.($id+100000);
		break;
	case 14:
		$show_voucher='SIX'.($id-100000);
		break;
	case 15:
		$show_voucher='SIX'.($id+100000);
		break;
	case 19:
		$show_voucher='SIX'.($id+100000);
		break;
	case 20:
		$show_voucher='SIX'.($id+100000);
		break;
	
	}
	return $show_voucher;
}

//特码A计算：
function sc_win($num07,$mtype){
$red  = array("01","02","07","08","12","13","18","19","23","24","29","30","34","45","40","45","46");
$blue = array("03","04","09","10","14","15","20","25","26","31","36","37","41","42","47","48");
$green= array("05","06","11","16","17","21","22","27","28","32","33","38","39","43","44","49");
if ($mtype==$num07){
    $grade=1;
}else{
    $grade=-1;	
}
switch ($mtype){
	case 'Red'://红波
		if (in_array($num07,$red)){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'Blue'://蓝波
		if (in_array($num07,$blue)){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'Green'://绿波
		if (in_array($num07,$green)){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'AOdd'://特单
		if ($num07%2==1 and $num07<49){
			$grade=1;
		}else if ($num07==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'AEven'://特双
		if ($num07%2==0){
			$grade=1;
		}else if ($num07==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
	case 'AOver'://特大
		if ($num07>25 and $num07<49){
			$grade=1;
		}else if ($num07==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'AUnder'://特小
		if ($num07<25){
			$grade=1;
		}else if ($num07==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
	case 'BOdd'://合单
		if ((substr($num07,0,1)+substr($num07,1,1))%2==1 and $num07<49){
			$grade=1;
		}else if ($num07==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'BEven'://合双
		if ((substr($num07,0,1)+substr($num07,1,1))%2==0){
			$grade=1;
		}else if ($num07==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
	case 'BOver'://合大
		if ((substr($num07,0,1)+substr($num07,1,1))>6 and $num07<49){
			$grade=1;
		}else if ($num07==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'BUnder'://合小
		if ((substr($num07,0,1)+substr($num07,1,1))<7){
			$grade=1;
		}else if ($num07==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
}
	$sc_win=$grade;
	return $sc_win;
}
//正码计算：
function ac_win($num01,$num02,$num03,$num04,$num05,$num06,$num07,$mtype){
$num=array($num01,$num02,$num03,$num04,$num05,$num06);
if (in_array($mtype,$num)){
    $grade=1;
}else{
    $grade=-1;
}
switch ($mtype){
	case 'TOdd'://总合单
		if (($num01+$num02+$num03+$num04+$num05+$num06+$num07)%2==1){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'TEven'://总合双
		if (($num01+$num02+$num03+$num04+$num05+$num06+$num07)%2==0){
			$grade=1;	
		}else{
			$grade=-1;
		}
		break;
	case 'TOver'://总合大
		if (($num01+$num02+$num03+$num04+$num05+$num06+$num07)>=175){
			$grade=1;		
		}else{
			$grade=-1;
		}
		break;
	case 'TUnder'://总合小
		if (($num01+$num02+$num03+$num04+$num05+$num06+$num07)<=174){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
}
	$ac_win=$grade;
	return $ac_win;
}
//正码计算：
function ac_6_win($num01,$num02,$num03,$num04,$num05,$num06,$mtype){
//echo $mtype;
$red  = array("01","02","07","08","12","13","18","19","23","24","29","30","34","45","40","45","46");
$blue = array("03","04","09","10","14","15","20","25","26","31","36","37","41","42","47","48");
$green= array("05","06","11","16","17","21","22","27","28","32","33","38","39","43","44","49");
$type=substr($mtype,2,1);
$number='num0'.$type;
//echo $number;
switch ($mtype){
	case 'AC'.$type.'_Red'://正码红波
		if (in_array($$number,$red)){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_Blue'://正码蓝波
		if (in_array($$number,$blue)){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_Green'://正码绿波
		if (in_array($$number,$green)){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_AOdd'://正码特单
		if ($$number%2==1 and $$number<49){
			$grade=1;
		}else if ($$number==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_AEven'://正码特双
		if ($$number%2==0){
			$grade=1;
		}else if ($$number==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_AOver'://正码特大
		if ($$number>25 and $$number<49){
			$grade=1;
		}else if ($$number==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_AUnder'://正码特小
		if ($$number<25){
			$grade=1;
		}else if ($$number==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_BOdd'://正码合单
		if ((substr($$number,0,1)+substr($$number,1,1))%2==1 and $num01<49){
			$grade=1;
		}else if ($$number==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_BEven'://正码合双
		if ((substr($$number,0,1)+substr($$number,1,1))%2==0){
			$grade=1;
		}else if ($$number==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_BOver'://正码合大
		if ((substr($$number,0,1)+substr($$number,1,1))>6 and $$number<49){
			$grade=1;
		}else if ($$number==49){
			$grade=0;		
		}else{
			$grade=-1;
		}
		break;
	case 'AC'.$type.'_BUnder'://正码合小
		if ((substr($$number,0,1)+substr($$number,1,1))<7){
			$grade=1;
		}else if ($$number==49){
			$grade=0;	
		}else{
			$grade=-1;
		}
		break;
}
	$ac_6_win=$grade;
	return $ac_6_win;
}
function sx_win($num07,$mtype){
$rat=array(03,15,27,39);//猪	
$cow=array(02,14,26,38);//鼠
$tiger=array(01,13,25,37,49);//牛
$rabbit=array(12,24,36,48);//虎
$liuzhou=array(11,23,35,47);//兔
$snake=array(10,22,34,46);//龙
$horse=array(09,21,33,45);//蛇
$sheep=array(08,20,32,44);//马
$monkey=array(07,19,31,43);//羊
$chicken=array(06,18,30,42);//猴
$dog=array(05,17,29,41);//鸡
$pig=array(04,16,28,40);//狗
switch ($mtype){
	case 'Rat'://鼠
        if (in_array($num07,$rat)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Cow'://牛
        if (in_array($num07,$cow)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Tiger'://虎
        if (in_array($num07,$tiger)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Rabbit'://兔
        if (in_array($num07,$rabbit)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Liuzhou'://龙
        if (in_array($num07,$liuzhou)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Snake'://蛇
        if (in_array($num07,$snake)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Horse'://马
        if (in_array($num07,$horse)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Sheep'://羊
        if (in_array($num07,$sheep)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Monkey'://猴
        if (in_array($num07,$monkey)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Chicken'://鸡
        if (in_array($num07,$chicken)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Dog'://狗
        if (in_array($num07,$dog)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Pig'://猪
        if (in_array($num07,$pig)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
																				
}
	$sx_win=$grade;
	return $sx_win;
}
function hw_win($num07,$mtype){
$red_odd=array(01,07,13,19,23,29,35,45);//红单
$red_even=array(02,08,12,18,24,30,34,40,46);//红双
$red_over=array(29,30,34,35,40,45,46);//红大
$red_under=array(01,02,07,08,12,13,18,19,23,24);//红小
$blue_odd=array(03,09,15,25,31,37,41,47);//蓝单
$blue_even=array(04,10,14,20,26,36,42,48);//蓝双
$blue_over=array(25,26,31,36,37,41,42,47,48);//蓝大
$blue_under=array(03,04,09,10,14,15,20);//蓝小
$green_odd=array(05,11,17,21,27,33,39,43);//绿单
$green_even=array(06,16,22,28,32,38,44);//绿双
$green_over=array(27,28,32,33,38,39,43,44);//绿大
$green_under=array(05,06,11,16,17,21,22);//绿小
switch ($mtype){
	case 'Red_Odd'://红单
        if (in_array($num07,$red_odd)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Red_Even'://红双
        if (in_array($num07,$red_even)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Red_Over'://红大
        if (in_array($num07,$red_over)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Red_Under'://红小
        if (in_array($num07,$red_under)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Blue_Odd'://蓝单
        if (in_array($num07,$blue_odd)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Blue_Even'://蓝双
        if (in_array($num07,$blue_even)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Blue_Over'://蓝大
        if (in_array($num07,$blue_over)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Blue_Under'://蓝小
        if (in_array($num07,$blue_under)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Green_Odd'://绿单
        if (in_array($num07,$green_odd)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Green_Even'://绿双
        if (in_array($num07,$green_even)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Green_Over'://绿大
        if (in_array($num07,$green_over)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Green_Under'://绿小
        if (in_array($num07,$green_under)){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;													
}
	$hw_win=$grade;
	return $hw_win;
}
function mt_win($num01,$num02,$num03,$num04,$num05,$num06,$num07,$mtype){
$rat=array("03","15","27","39");//猪
$cow=array("02","14","26","38");//鼠
$tiger=array("01","13","25","37","49");//牛
$rabbit=array("12","24","36","48");//虎
$liuzhou=array("11","23","35","47");//兔
$snake=array("10","22","34","46");//龙
$horse=array("09","21","33","45");//蛇
$sheep=array("08","20","32","44");//马
$monkey=array("07","19","31","43");//羊
$chicken=array("06","18","30","42");//猴
$dog=array("05","17","29","41");//鸡
$pig=array("04","16","28","40");//狗

$last00=array("10","20","30","40");//0尾
$last01=array("01","11","21","31","41");//1尾
$last02=array("02","12","22","32","42");//2尾
$last03=array("03","13","23","33","43");//3尾
$last04=array("04","14","24","34","44");//4尾
$last05=array("05","15","25","35","45");//5尾
$last06=array("06","16","26","36","46");//6尾
$last07=array("07","17","27","37","47");//7尾
$last08=array("08","18","28","38","48");//8尾
$last09=array("09","19","29","39","49");//9尾
$num=array($num01,$num02,$num03,$num04,$num05,$num06,$num07);
//print_r($num);
switch ($mtype){
	case 'Last_Rat'://鼠
	$a=array_intersect($num,$rat);
	$last_rat=count($a);
        if ($last_rat>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Cow'://牛
	$a=array_intersect($num,$cow);
	$last_cow=count($a);	
        if ($last_cow>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Tiger'://虎
	$a=array_intersect($num,$tiger);
	$last_tiger=count($a);	
        if ($last_tiger>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Rabbit'://兔
	$a=array_intersect($num,$rabbit);
	$last_rabbit=count($a);	
        if ($last_rabbit>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Liuzhou'://龙
	$a=array_intersect($num,$liuzhou);
	$last_liuzhou=count($a);	
        if ($last_liuzhou>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Snake'://蛇
	$a=array_intersect($num,$snake);
	$last_snake=count($a);	
        if ($last_snake>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Horse'://马
	$a=array_intersect($num,$horse);
	$last_horse=count($a);	
        if ($last_horse>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Sheep'://羊
	$a=array_intersect($num,$sheep);
	$last_sheep=count($a);	
        if ($last_sheep>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Monkey'://猴
	$a=array_intersect($num,$monkey);
	$last_monkey=count($a);	
        if ($last_monkey>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Chicken'://鸡
	$a=array_intersect($num,$chicken);
	$last_chicken=count($a);	
        if ($last_chicken>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Dog'://狗
	$a=array_intersect($num,$dog);
	$last_dog=count($a);	
        if ($last_dog>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_Pig'://猪
	$a=array_intersect($num,$pig);
	$last_pig=count($a);	
        if ($last_pig>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_00'://0尾
	$a=array_intersect($num,$last00);
	$last_00=count($a);	
        if ($last_00>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_01'://1尾
	$a=array_intersect($num,$last01);
	$last_01=count($a);	
        if ($last_01>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_02'://2尾
	$a=array_intersect($num,$last02);
	$last_02=count($a);	
        if ($last_02>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_03'://3尾
	$a=array_intersect($num,$last03);
	$last_03=count($a);	
        if ($last_03>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_04'://4尾
	$a=array_intersect($num,$last04);
	$last_04=count($a);	
        if ($last_04>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_05'://5尾
	$a=array_intersect($num,$last05);
	$last_05=count($a);	
        if ($last_05>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_06'://6尾
	$a=array_intersect($num,$last06);
	$last_06=count($a);	
        if ($last_06>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_07'://7尾
	$a=array_intersect($num,$last07);
	$last_07=count($a);	
        if ($last_07>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_08'://8尾
	$a=array_intersect($num,$last08);
	$last_08=count($a);	
        if ($last_08>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
	case 'Last_09'://9尾
	$a=array_intersect($num,$last09);
	$last_09=count($a);	
        if ($last_09>0){
            $grade=1;
	    }else{
            $grade=-1;
	    }
		break;
}
	$mt_win=$grade;
	return $mt_win;
}
function m_win($num07,$m_place){
$Rat=array("03","15","27","39");//猪	
$Cow=array("02","14","26","38");//鼠
$Tiger=array("01","13","25","37","49");//牛
$Rabbit=array("12","24","36","48");//虎
$Liuzhou=array("11","23","35","47");//兔
$Snake=array("10","22","34","46");//龙
$Horse=array("09","21","33","45");//蛇
$Sheep=array("08","20","32","44");//马
$Monkey=array("07","19","31","43");//羊
$Chicken=array("06","18","30","42");//猴
$Dog=array("05","17","29","41");//鸡
$Pig=array("04","16","28","40");//狗
$show_type=explode(",",$m_place);
$num=count($show_type);
if ($num==3){
    $place=array_merge($$show_type[0],$$show_type[1],$$show_type[2]);
}else if($num==4){
    $place=array_merge($$show_type[0],$$show_type[1],$$show_type[2],$$show_type[3]);
}else if($num==5){
    $place=array_merge($$show_type[0],$$show_type[1],$$show_type[2],$$show_type[3],$$show_type[4]);
}else if($num==6){
    $place=array_merge($$show_type[0],$$show_type[1],$$show_type[2],$$show_type[3],$$show_type[4],$$show_type[5]);
}
    $show_win=in_array($num07,$place);
    if ($show_win>0){
        $grade=1;
    }else{
        $grade=-1;
    }
    $m_win=$grade;
    return $m_win;
}
function ec_win($num01,$num02,$num03,$num04,$num05,$num06,$num07,$mtype,$m_place){
$num6=array($num01,$num02,$num03,$num04,$num05,$num06);
$num7=array($num01,$num02,$num03,$num04,$num05,$num06,$num07);
$place=explode(",",$m_place);
switch($mtype){
	case 'N1'://正特码串
	$aa=array_intersect($num6,$place);
	$a=count($aa);
	$b=in_array($num07,$place);
    if ($a+$b>1){
        $grade=1;
	}else{
        $grade=-1;
	}
	break;
	case 'N2'://二码全中
	$aa=array_intersect($num6,$place);
	$a=count($aa);	
    if ($a>1){
        $grade=1;
	}else{
        $grade=-1;
	}
	break;
	case 'N21'://二码中特或中二
	$aa=array_intersect($num6,$place);
	$a=count($aa);
	$b=in_array($num07,$place);
	if ($a>1){
        $grade=1;
	}else if ($a+$b>1 and $b==1){
        $grade=1;
	}else{
        $grade=-1;
	}
	break;
	case 'N3'://三码全中
	$aa=array_intersect($num6,$place);
	$a=count($aa);	
    if ($a>2){
        $grade=1;
	}else{
        $grade=-1;
	}
	break;
	case 'N32'://三码中二或中三
	$aa=array_intersect($num6,$place);
	$a=count($aa);
	if ($a>2){//中三
        $grade=1;
	}else if ($a>1){//中二
        $grade=1;
	}else{
        $grade=-1;
	}
	break;
}
	$ec_win=$grade;
	return $ec_win;
}
?>