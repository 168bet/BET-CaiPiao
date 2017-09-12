<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-13
*/
if (!defined('Copyright') && Copyright != '作者QQ:503064228')
exit('作者QQ:503064228');
if (!defined('ROOT_PATH'))
exit('invalid request');

function cqNumber($num, $ball, $p=0)
{
	switch ($num)
	{
		case 0 :
			if ($ball >= 23)
				return $p==0 ? '<font color="red">大</font>' : '總和大';
			else
				return $p==0 ? '<font color="black">小</font>' : '總和小';
		case 1 :
			if ($ball % 2 == 0)
				return $p==0 ? '<font color="red">雙</font>' : '總和雙';
			else 
				return $p==0 ? '<font color="black">單</font>' : '總和單';
		case 2 :
			if ($ball[0] == $ball[1])
				return $p==0 ? '<font color="seagreen"><b>和<b/></font>' : '和';
			else if ($ball[0] > $ball[1])
				return $p==0 ? '<font color="red">龍</font>' : '龍';
			else 
				return $p==0 ? '<font color="black">虎</font>' : '虎';
		case 3 :
			if ($ball >= 5)
				return $p==0 ? '<font color="red">大</font>' : '大';
			else
				return $p==0 ? '<font color="black">小</font>' : '小';
		case 4 :
			if ($ball % 2 == 0)
				return $p==0 ? '<font color="red">雙</font>' : '雙';
			else 
				return $p==0 ? '<font color="black">單</font>' : '單';
		case 5 :
			if ($ball >= 23)
				return $p==0 ? '<font color="red">大</font>' : '大';
			else
				return $p==0 ? '<font color="black">小</font>' : '小';
		case 6 :
			if ($ball % 2 == 0)
				return $p==0 ? '<font color="red">雙</font>' : '雙';
			else 
				return $p==0 ? '<font color="black">單</font>' : '單';
	}
}

function cqNumberString($arr)
{
	sort($arr);
	if ($arr[0] == $arr[1] && $arr[0] == $arr[2])
		return '豹子';
		
	if ($arr[0] == $arr[1] || $arr[0] == $arr[2] || $arr[1] == $arr[0] || $arr[1] == $arr[2])
		return '對子';
		
	$a = join('', $arr);
	if ($a == '019' || $a == '091'|| $a == '098'|| $a == '089'|| $a == '109' || $a == '190' || $a == '901'|| $a == '910'|| $a == '809' || $a == '890' || sorts($arr, 3))
		return '順子';
		
	$match = '/.09|0.9/';
	if (preg_match($match, $a) || sorts($arr, 2))
		return '半順';
	
	return '雜六';
		
}

function sorts($a, $p)
{
	$i = 0; $tmp=0; 
	foreach ($a as $k=>$v)
	{
	    if($v == $a[$k-1]+1 || $v == $a[$k+1]-1)
	    {
	        $tmp = $v;
	        if (isset($date[$i]) && end($date[$i])+1 == $tmp) 
	        {
	            $date[$i][] = $tmp;
	        } else {
	            $date[++$i][] = $tmp;
	        }
	    }
	}
	if (count($date[1]) == $p || count($date[2]) == $p)
		$a = true;
	else 
		$a = false;
	return $a;
}

function numberList($gameType, $id=false)
{
	$db = new DB();
	$pageNum = 15;
	$numberList = array();
	$from = $id == true ? "" : "WHERE g_ball_1 is not null";
	if ($gameType == 1)
	{
		$total = $db->query("SELECT `g_id` FROM `g_history` WHERE g_game_id = 1 ", 3);
		$page = new Page($total, $pageNum);
		$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`, `g_ball_6`, `g_ball_7`, `g_ball_8` FROM `g_history`  {$from} ORDER BY g_qishu DESC {$page->limit} ";
		$result = $db->query($sqls, 1);
		if ($result)
		{
		
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
				$ball_1 ='<td width="27" class="No_gd'.$value['g_ball_1'].'"></td>' ;
				$ball_2 ='<td width="27" class="No_gd'.$value['g_ball_2'].'"></td>' ;
				$ball_3 ='<td width="27" class="No_gd'.$value['g_ball_3'].'"></td>' ;
				$ball_4 ='<td width="27" class="No_gd'.$value['g_ball_4'].'"></td>' ;
				$ball_5 ='<td width="27" class="No_gd'.$value['g_ball_5'].'"></td>' ;
				$ball_6 ='<td width="27" class="No_gd'.$value['g_ball_6'].'"></td>' ;
				$ball_7 ='<td width="27" class="No_gd'.$value['g_ball_7'].'"></td>' ;
				$ball_8 ='<td width="27" class="No_gd'.$value['g_ball_8'].'"></td>' ;
	            
				$ball_count = $value['g_ball_1'] + $value['g_ball_2'] + $value['g_ball_3'] + $value['g_ball_4'] + $value['g_ball_5'] + 
				$value['g_ball_6'] + $value['g_ball_7'] + $value['g_ball_8'];
				$Ball = $ball_1.$ball_2.$ball_3.$ball_4.$ball_5.$ball_6.$ball_7.$ball_8;
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = SubBall(0, $ball_count);
				$numberList[$key][6] = SubBall(1, $ball_count);
				$numberList[$key][7] = SubBall(2, mb_substr($ball_count, -1));
				$numberList[$key][8] = SubBall(3, array($value['g_ball_1'],$value['g_ball_8']));
			}
		}
	}
	else if($gameType == 3){
	$total = $db->query("SELECT `g_id` FROM `g_history3` WHERE g_game_id = 3 ", 3);
		$page = new Page($total, $pageNum);
		$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5` FROM `g_history3`  {$from} ORDER BY g_qishu DESC {$page->limit} ";
		$result = $db->query($sqls, 1);
		if ($result)
		{
		
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
				$ball_1 ='<td width="27" class="No_gx'.$value['g_ball_1'].'"></td>' ;
				$ball_2 ='<td width="27" class="No_gx'.$value['g_ball_2'].'"></td>' ;
				$ball_3 ='<td width="27" class="No_gx'.$value['g_ball_3'].'"></td>' ;
				$ball_4 ='<td width="27" class="No_gx'.$value['g_ball_4'].'"></td>' ;
				$ball_5 ='<td width="27" class="No_gx'.$value['g_ball_5'].'"></td>' ;
				
				
				$ball_count = $value['g_ball_1'] + $value['g_ball_2'] + $value['g_ball_3'] + $value['g_ball_4'] + $value['g_ball_5'];
				$Ball = $ball_1.$ball_2.$ball_3.$ball_4.$ball_5;
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = SubBall_gx(0, $ball_count);
				$numberList[$key][6] = SubBall_gx(1, $ball_count);
				$numberList[$key][7] = SubBall_gx(2, mb_substr($ball_count, -1));
				$numberList[$key][8] = SubBall_gx(3, array($value['g_ball_1'],$value['g_ball_5']));
				
				$numberList[$key][9] = SubBall_Tema(0, $value['g_ball_5']);	
				$numberList[$key][10] = SubBall_Tema(1, $value['g_ball_5']);				
				$numberList[$key][11] = SubBall_Tema(2, $value['g_ball_5']);
				$numberList[$key][12] = SubBall_Tema(3, $value['g_ball_5']);
				$numberList[$key][13] = SubBall_Tema(4, $value['g_ball_5']);
				$numberList[$key][14] = SubBall_Tema(5, $value['g_ball_5']);
			}
		}
	}
	else if($gameType == 4){
	
	$total = $db->query("SELECT `g_id` FROM `g_history4` WHERE g_game_id = 4 ", 3);
		$page = new Page($total, $pageNum);
		$result = $db->query("SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5` FROM `g_history4` {$from}  ORDER BY g_qishu DESC {$page->limit} ", 1);
		if ($result)
		{
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
	           		
				$ball_1 ='<td width="27" class="No_cq'.$value['g_ball_1'].'"></td>' ;
				$ball_2 ='<td width="27" class="No_cq'.$value['g_ball_2'].'"></td>' ;
				$ball_3 ='<td width="27" class="No_cq'.$value['g_ball_3'].'"></td>' ;
				$ball_4 ='<td width="27" class="No_cq'.$value['g_ball_4'].'"></td>' ;
				$ball_5 ='<td width="27" class="No_cq'.$value['g_ball_5'].'"></td>' ;
				
				
				$Ball = $ball_1.$ball_2.$ball_3.$ball_4.$ball_5;
				$ball_count = $value['g_ball_1'] + $value['g_ball_2'] + $value['g_ball_3'] + $value['g_ball_4'] + $value['g_ball_5'];
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = cqNumber(0, $ball_count);
				$numberList[$key][6] = cqNumber(1, $ball_count);
				$numberList[$key][7] = cqNumber(2, array($value['g_ball_1'],$value['g_ball_5']));
				$numberList[$key][8] = cqNumberString(array($value['g_ball_1'],$value['g_ball_2'],$value['g_ball_3']));
				$numberList[$key][9] = cqNumberString(array($value['g_ball_2'],$value['g_ball_3'],$value['g_ball_4']));
				$numberList[$key][10] = cqNumberString(array($value['g_ball_3'],$value['g_ball_4'],$value['g_ball_5']));
			}
		}
	}else if($gameType == 5){
	
	$total = $db->query("SELECT `g_id` FROM `g_history5` WHERE g_game_id = 5 ", 3);
		$page = new Page($total, $pageNum);
		$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`, `g_ball_6`, `g_ball_7`, `g_ball_8` FROM `g_history5`  {$from} ORDER BY g_qishu DESC {$page->limit} ";
		$result = $db->query($sqls, 1);
		if ($result)
		{
		
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
	            $ball_1 ='<div class="nc'.$value['g_ball_1'].'">'.$value['g_ball_1'].'</div>' ;
				$ball_2 ='<div class="nc'.$value['g_ball_2'].'">'.$value['g_ball_2'].'</div>' ;
				$ball_3 ='<div class="nc'.$value['g_ball_3'].'">'.$value['g_ball_3'].'</div>' ;
				$ball_4 ='<div class="nc'.$value['g_ball_4'].'">'.$value['g_ball_4'].'</div>' ;
				$ball_5 ='<div class="nc'.$value['g_ball_5'].'">'.$value['g_ball_5'].'</div>' ;
				$ball_6 ='<div class="nc'.$value['g_ball_6'].'">'.$value['g_ball_6'].'</div>' ;
				$ball_7 ='<div class="nc'.$value['g_ball_7'].'">'.$value['g_ball_7'].'</div>' ;
				$ball_8 ='<div class="nc'.$value['g_ball_8'].'">'.$value['g_ball_8'].'</div>' ;
				$ball_count = $value['g_ball_1'] + $value['g_ball_2'] + $value['g_ball_3'] + $value['g_ball_4'] + $value['g_ball_5'] + 
				$value['g_ball_6'] + $value['g_ball_7'] + $value['g_ball_8'];
				$Ball = $ball_1.$ball_2.$ball_3.$ball_4.$ball_5.$ball_6.$ball_7.$ball_8;
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = SubBallnc(0, $ball_count);
				$numberList[$key][6] = SubBallnc(1, $ball_count);
				$numberList[$key][7] = SubBallnc(2, mb_substr($ball_count, -1));
				$numberList[$key][8] = SubBallnc(3, array($value['g_ball_1'],$value['g_ball_8']));
			}
		}
	
	}
	else if($gameType == 6){

	$total = $db->query("SELECT count(g_id) as a FROM `g_history6` WHERE g_game_id = 6 ", 1);
		$page = new Page($total[0]['a'], $pageNum);
		$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`, `g_ball_6`, `g_ball_7`, `g_ball_8`, `g_ball_9`, `g_ball_10` FROM `g_history6`  {$from} ORDER BY g_qishu DESC {$page->limit} ";
		$result = $db->query($sqls, 1);
		if ($result)
		{
		
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
	            $ball_1 ='<td width="27" class="No_'.$value['g_ball_1'].'"></td>' ;
				$ball_2 ='<td width="27" class="No_'.$value['g_ball_2'].'"></td>' ;
				$ball_3 ='<td width="27" class="No_'.$value['g_ball_3'].'"></td>' ;
				$ball_4 ='<td width="27" class="No_'.$value['g_ball_4'].'"></td>' ;
				$ball_5 ='<td width="27" class="No_'.$value['g_ball_5'].'"></td>' ;
				$ball_6 ='<td width="27" class="No_'.$value['g_ball_6'].'"></td>' ;
				$ball_7 ='<td width="27" class="No_'.$value['g_ball_7'].'"></td>' ;
				$ball_8 ='<td width="27" class="No_'.$value['g_ball_8'].'"></td>' ;
				$ball_9 ='<td width="27" class="No_'.$value['g_ball_9'].'"></td>' ;
				$ball_10 ='<td width="27" class="No_'.$value['g_ball_10'].'"></td>' ;
				$ball_count = $value['g_ball_1'] + $value['g_ball_2'] ;
				$Ball = $ball_1.$ball_2.$ball_3.$ball_4.$ball_5.$ball_6.$ball_7.$ball_8.$ball_9.$ball_10;
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = SubBallpk(0, $ball_count);
				$numberList[$key][6] = SubBallpk(1, $ball_count);
				
				$numberList[$key][7] = SubBallpk(2, array($value['g_ball_1'],$value['g_ball_10']));
				$numberList[$key][8] = SubBallpk(2, array($value['g_ball_2'],$value['g_ball_9']));
				$numberList[$key][9] = SubBallpk(2, array($value['g_ball_3'],$value['g_ball_8']));
				$numberList[$key][10] = SubBallpk(2, array($value['g_ball_4'],$value['g_ball_7']));
				$numberList[$key][11] = SubBallpk(2, array($value['g_ball_5'],$value['g_ball_6']));
			}
		}
	
	}
	else  if($gameType == 7){
	
	$total = $db->query("SELECT count(g_id) as a FROM `g_history7` WHERE g_game_id = 7 ", 1);
		$page = new Page($total[0]['a'], $pageNum);
		$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`  FROM `g_history7`  {$from} ORDER BY g_qishu DESC {$page->limit} ";
		$result = $db->query($sqls, 1);
		if ($result)
		{
		
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
	            $ball_1 ='<td width="27" class="No_k3'.$value['g_ball_1'].'"></td>' ;
				$ball_2 ='<td width="27" class="No_k3'.$value['g_ball_2'].'"></td>' ;
				$ball_3 ='<td width="27" class="No_k3'.$value['g_ball_3'].'"></td>' ;
				
				$ball_count = $value['g_ball_1'] + $value['g_ball_2']+ $value['g_ball_3'] ;
				$Ball = $ball_1.$ball_2.$ball_3;
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = SubBallk3(0, $value['g_ball_1'] , $value['g_ball_2'], $value['g_ball_3']);
				
			}
		}
	
	}
	else{
		$total = $db->query("SELECT `g_id` FROM `g_history2` WHERE g_game_id = 2 ", 3);
		$page = new Page($total, $pageNum);
		$result = $db->query("SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5` FROM `g_history2` {$from}  ORDER BY g_qishu DESC {$page->limit} ", 1);
		if ($result)
		{
			foreach ($result as $key=>$value) {
				$week = GetWeekDay($value['g_date'],0);
				
				
				$ball_1 ='<td width="27" class="No_cq'.$value['g_ball_1'].'"></td>' ;
				$ball_2 ='<td width="27" class="No_cq'.$value['g_ball_2'].'"></td>' ;
				$ball_3 ='<td width="27" class="No_cq'.$value['g_ball_3'].'"></td>' ;
				$ball_4 ='<td width="27" class="No_cq'.$value['g_ball_4'].'"></td>' ;
				$ball_5 ='<td width="27" class="No_cq'.$value['g_ball_5'].'"></td>' ;
				
				
	            
				$Ball = $ball_1.$ball_2.$ball_3.$ball_4.$ball_5;
				$ball_count = $value['g_ball_1'] + $value['g_ball_2'] + $value['g_ball_3'] + $value['g_ball_4'] + $value['g_ball_5'];
				$numberList[$key][0] = $value['g_id'];
				$numberList[$key][1] = $value['g_qishu'];
				$a = explode('-', $value['g_date']);
				$b = explode(' ', $a[2]);
				$c = explode(':', $b[1]);
				$numberList[$key][2] = $a[1].'-'.$b[0].'&nbsp;&nbsp;'.$week.'&nbsp;&nbsp;'.$c[0].':'.$c[1];
				$numberList[$key][3] = $Ball;
				$numberList[$key][4] = $ball_count;
				$numberList[$key][5] = cqNumber(0, $ball_count);
				$numberList[$key][6] = cqNumber(1, $ball_count);
				$numberList[$key][7] = cqNumber(2, array($value['g_ball_1'],$value['g_ball_5']));
				$numberList[$key][8] = cqNumberString(array($value['g_ball_1'],$value['g_ball_2'],$value['g_ball_3']));
				$numberList[$key][9] = cqNumberString(array($value['g_ball_2'],$value['g_ball_3'],$value['g_ball_4']));
				$numberList[$key][10] = cqNumberString(array($value['g_ball_3'],$value['g_ball_4'],$value['g_ball_5']));
			}
		}
	}
	$numberList['page'] = $page;
	return $numberList;
}
?>