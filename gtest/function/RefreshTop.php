<?php
/*  
  Copyright (c) 2010-02 Game
  Game All Rights Reserved. 
  作者QQ:503064228
  Author: Version:1.0
  Date:2011-12-13
*/
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/cheCookie.php';

$db = new DB();

	
	
	if ((isset($_SESSION['cq']) && $_SESSION['cq'] == true))
		$li = 2;
	else{ 
			if((isset($_SESSION['gx']) && $_SESSION['gx'] == true))
				$li = 3;
			else if((isset($_SESSION['jx']) && $_SESSION['jx'] == true))
				$li = 4;
			else if((isset($_SESSION['nc']) && $_SESSION['nc'] == true))
				$li = 5;
			else if((isset($_SESSION['pk']) && $_SESSION['pk'] == true))
				$li = 6;
			else
				$li=1;
		}
		
		
		if($li==1){
		$topre='<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
		<TR class="t_list_caption">
      <TD colSpan=4 align="middle"><SPAN class=STYLE2 id="result" >廣東快樂十分开奖结果</SPAN></td>
	  <td><a href="javascript:getinfotop();">刷新</a></TD>
    </TR>
	 <TR class="t_list_caption">
      <TD  align="middle"><a href="javascript:changegd(1);">特码</a></TD>
	  <TD  align="middle"><a href="javascript:changegd(2);">单双</a></TD>
	  <TD  align="middle"><a href="javascript:changegd(3);">大小</a></TD>
	  <TD  align="middle"><a href="javascript:changegd(4);">中发白</a></TD>
	  <TD  align="middle"><a href="javascript:changegd(5);">方位</a></TD>
    </TR>
  </table>
  <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
	<tr class="t_list_caption">
	<td>期数</td>
	<td>一</td>
	<td>二</td>
	<td>三</td>
	<td>四</td>
	<td>五</td>
	<td>六</td>
	<td>七</td>
	<td>八</td>
	</tr>';
	
	$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`, `g_ball_6`, `g_ball_7`, `g_ball_8` FROM `g_history`  WHERE g_ball_1 is not null ORDER BY g_qishu DESC limit 10 ";
	$result = $db->query($sqls, 1);

	for($i=0;$i<count($result);$i++){
	$topre=$topre.'<tr class="t_td_text1" id="t_'.$i.'" style="display:block">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.$result[$i]['g_ball_1'].'</td>
	<td align="middle">'.$result[$i]['g_ball_2'].'</td>
	<td align="middle">'.$result[$i]['g_ball_3'].'</td>
	<td align="middle">'.$result[$i]['g_ball_4'].'</td>
	<td align="middle">'.$result[$i]['g_ball_5'].'</td>
	<td align="middle">'.$result[$i]['g_ball_6'].'</td>
	<td align="middle">'.$result[$i]['g_ball_7'].'</td>
	<td align="middle">'.$result[$i]['g_ball_8'].'</td>
	</tr>	
	<tr class="t_td_text1" id="s_'.$i.'" style="display:none">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_1'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_2'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_3'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_4'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_5'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_6'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_7'],1).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_8'],1).'</td>
	</tr>	
	<tr class="t_td_text1" id="d_'.$i.'" style="display:none">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_1'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_2'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_3'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_4'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_5'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_6'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_7'],2).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_8'],2).'</td>
	</tr>	
	<tr class="t_td_text1" id="z_'.$i.'" style="display:none">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_1'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_2'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_3'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_4'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_5'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_6'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_7'],9).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_8'],9).'</td>
	</tr>
	<tr class="t_td_text1" id="f_'.$i.'" style="display:none">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_1'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_2'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_3'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_4'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_5'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_6'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_7'],8).'</td>
	<td align="middle">'.sum_ball_string_top($result[$i]['g_ball_8'],8).'</td>
	</tr>';
	}
	
	$topre=$topre.'</table>';
	}
	if($li==2){
	$topre='<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
	<TR class="t_list_caption">
      <TD colSpan=4 align="middle"><SPAN class=STYLE2 id="result" >重慶時時彩开奖结果</SPAN></TD>
	  <td><a href="javascript:getinfotop();">刷新</a></TD>
    </TR>
	 <TR class="t_list_caption">
      <TD  align="middle"><a href="javascript:changegd(1);">特码</a></TD>
	  <TD  align="middle"><a href="javascript:changegd(2);">单双</a></TD>
	  <TD  align="middle" colSpan=3><a href="javascript:changegd(3);">大小</a></TD>
    </TR>
  </table>
  <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
	<tr class="t_list_caption">
	<td>期数</td>
	<td>一</td>
	<td>二</td>
	<td>三</td>
	<td>四</td>
	<td>五</td>
	</tr>';
	
	$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5` FROM `g_history2`  WHERE g_ball_1 is not null ORDER BY g_qishu DESC limit 10 ";
	$result = $db->query($sqls, 1);
	
	for($i=0;$i<count($result);$i++){
	$topre=$topre.'<tr class="t_td_text1" id="t_'.$i.'" style="display:block">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.$result[$i]['g_ball_1'].'</td>
	<td align="middle">'.$result[$i]['g_ball_2'].'</td>
	<td align="middle">'.$result[$i]['g_ball_3'].'</td>
	<td align="middle">'.$result[$i]['g_ball_4'].'</td>
	<td align="middle">'.$result[$i]['g_ball_5'].'</td>
	</tr>	
	<tr class="t_td_text1" id="s_'.$i.'" style="display:none">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.cqNumbertop(4,$result[$i]['g_ball_1']).'</td>
	<td align="middle">'.cqNumbertop(4,$result[$i]['g_ball_2']).'</td>
	<td align="middle">'.cqNumbertop(4,$result[$i]['g_ball_3']).'</td>
	<td align="middle">'.cqNumbertop(4,$result[$i]['g_ball_4']).'</td>
	<td align="middle">'.cqNumbertop(4,$result[$i]['g_ball_5']).'</td>
	</tr>	
	<tr class="t_td_text1" id="d_'.$i.'" style="display:none">
	<td align="middle">'.substr($result[$i]['g_qishu'],8).'</td>
	<td align="middle">'.cqNumbertop(3,$result[$i]['g_ball_1']).'</td>
	<td align="middle">'.cqNumbertop(3,$result[$i]['g_ball_2']).'</td>
	<td align="middle">'.cqNumbertop(3,$result[$i]['g_ball_3']).'</td>
	<td align="middle">'.cqNumbertop(3,$result[$i]['g_ball_4']).'</td>
	<td align="middle">'.cqNumbertop(3,$result[$i]['g_ball_5']).'</td>
	</tr>';
	}
	
	$topre=$topre.'</table>';
	
	}
	
	
	if($li==6){
	$topre='<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
	<TR class="t_list_caption">
      <TD colSpan=4 align="middle"><SPAN class=STYLE2 id="result" >北京赛车开奖结果</SPAN></TD>
	  <td><a href="javascript:getinfotop();">刷新</a></TD>
    </TR>
	 <TR class="t_list_caption">
      <TD  align="middle"><a href="javascript:changegd(1);">特码</a></TD>
	  <TD  align="middle"><a href="javascript:changegd(2);">单双</a></TD>
	  <TD  align="middle" colSpan=3><a href="javascript:changegd(3);">大小</a></TD>
    </TR>
  </table>
  <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
	<tr class="t_list_caption">
	<td>期数</td>
	<td>冠</td>
	<td>亚</td>
	<td>三</td>
	<td>四</td>
	<td>五</td>
	<td>六</td>
	<td>七</td>
	<td>八</td>
	<td>九</td>
	<td>十</td>
	</tr>';
	
	$sqls="SELECT `g_id`, `g_qishu`, `g_date`, `g_game_id`, `g_ball_1`, `g_ball_2`, `g_ball_3`, `g_ball_4`, `g_ball_5`, `g_ball_6`, `g_ball_7`, `g_ball_8`, `g_ball_9`, `g_ball_10` FROM `g_history6`  WHERE g_ball_1 is not null ORDER BY g_qishu DESC limit 10 ";
	$result = $db->query($sqls, 1);
	
	for($i=0;$i<count($result);$i++){
	$topre=$topre.'<tr class="t_td_text1" id="t_'.$i.'" style="display:block">
	<td align="middle">'.$result[$i]['g_qishu'].'</td>
	<td align="middle">'.$result[$i]['g_ball_1'].'</td>
	<td align="middle">'.$result[$i]['g_ball_2'].'</td>
	<td align="middle">'.$result[$i]['g_ball_3'].'</td>
	<td align="middle">'.$result[$i]['g_ball_4'].'</td>
	<td align="middle">'.$result[$i]['g_ball_5'].'</td>
	<td align="middle">'.$result[$i]['g_ball_6'].'</td>
	<td align="middle">'.$result[$i]['g_ball_7'].'</td>
	<td align="middle">'.$result[$i]['g_ball_8'].'</td>
	<td align="middle">'.$result[$i]['g_ball_9'].'</td>
	<td align="middle">'.$result[$i]['g_ball_10'].'</td>
	</tr>	
	<tr class="t_td_text1" id="s_'.$i.'" style="display:none">
	<td align="middle">'.$result[$i]['g_qishu'].'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_1'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_2'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_3'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_4'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_5'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_6'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_7'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_8'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_9'],0).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_10'],0).'</td>
	</tr>	
	<tr class="t_td_text1" id="d_'.$i.'" style="display:none">
	<td align="middle">'.$result[$i]['g_qishu'].'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_1'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_2'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_3'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_4'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_5'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_6'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_7'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_8'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_9'],2).'</td>
	<td align="middle">'.sum_ball_string_pk_top($result[$i]['g_ball_10'],2).'</td>
	</tr>';
	}
	
	$topre=$topre.'</table>';

	}
	//echo $topre;
	
echo $topre;


?>
