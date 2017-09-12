<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';

markPos("前台-结算报表-us");

if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{
$week = week ();
function setHtml ($week, $str, $user,$type=0)
{
	$date1 = GetWeekDay(date("Y-m-d"), 1);
	$a = 0; $b = 0; $ac = 0; $e = 0; $g = 0;
	foreach ($week as $value) 
	{
		
        $date = GetWeekDay($value, 1);
        $result = GetForms($value.' 02:00', dayMorning($value, (60*60*24)).' 02:00', $user[0]['g_name'],$type);
		//alert(count($result));
        $count_bishu = 0; //筆數
        $count_jiner = 0; //下注金額
        $count_win = 0; //輸贏結果
        $count_tueishui = 0; //退水
        $count_win_n = 0; //退水后結果
        for ($i=0; $i<count($result); $i++)
        {
        	$countMoney = sumCountMoney ($user, $result[$i]);
        	$count_bishu += $countMoney['Num'];
        	$count_jiner += $countMoney['Money'];
        	$count_tueishui += $countMoney['TuiShui'];
        	$count_win_n += $countMoney['Win'];
        	$count_win += $result[$i]['g_win'] - $countMoney['TuiShui'];
        }
        if ($count_win_n == 0 && $count_jiner ==0){
        	$count_win_n = '0.0';
        } else {
			if($count_win_n<0)
			$count_win_n = '<span style="color:red">'.is_Number($count_win_n,1).'</span>';
			else
        	$count_win_n = '<span>'.is_Number($count_win_n,1).'</span>';
        }
        $a += $count_bishu; 
        $b += $count_jiner; 
        $ac += $count_win; 
        $e += $count_tueishui; 
        $g += ($count_win + $count_tueishui);
		
		$date2 = GetWeekDay($value, 1);
		$c = explode('-', $value);
		$f = date('H:i:s')<='02:00' ? dayMorning(date("Y-m-d"), (60*60*24), true) : date("Y-m-d");
		if ($f == $value){
		if($count_bishu>0){
			$html = '<td align="center" style="color:blue;font-weight:bold"><a href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].'/userlib/?skin=#this" rel="repore1.php?loadhtml=1&gid='.base64_encode($value).'&dateId='.base64_encode($value).'&type='.$type.'" style="color: blue;"><span style="font-size:104%">'.$c[0].'-'.$c[1].'-'.$c[2].'</span>&nbsp;&nbsp;&nbsp;'.$date2.'</a></td>';
			}else{
			$html = '<td align="center" style="color:blue;font-weight:bold"><span style="font-size:104%">'.$c[0].'-'.$c[1].'-'.$c[2].'</span>&nbsp;&nbsp;&nbsp;'.$date2.'</td>';
			}
		}
		else {
		if($count_bishu>0){
			$html ='<td align="center"><a href="http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].'/userlib/?skin=#this" rel="repore1.php?loadhtml=1&gid='.base64_encode($value).'&dateId='.base64_encode($value).'&type='.$type.'" style="color: #373737;"><span style="font-size:104%">'.$c[0].'-'.$c[1].'-'.$c[2].'</span>&nbsp;&nbsp;&nbsp;'.$date2.'</a></td>';
			}else{
			$html ='<td align="center"><span style="font-size:104%">'.$c[0].'-'.$c[1].'-'.$c[2].'</span>&nbsp;&nbsp;&nbsp;'.$date2.'</td>';
			}
		}
		
        echo '<tr class="t_td_text" align="right">
			            '.$html.'
			            <td align="center">'.$count_bishu.'</td>
			            <td style="letter-spacing:1px; font-size:104%;">'.is_Number($count_jiner).'&nbsp;</td>
			            <td style="letter-spacing:1px; font-size:104%;">'.number_format($count_win, 1).'&nbsp;</td>
			            <td style="letter-spacing:1px; font-size:104%;">'.number_format($count_tueishui,1).'&nbsp;</td>
			            <td style="letter-spacing:1px; font-size:104%;">'.$count_win_n.'&nbsp;</td>
        			  </tr>';
	}
	echo '
	<tfoot class="bg_g1">
	<tr class="alltotal">
        	<td><b>'.$str.'</b></td>
            <td>'.$a.'</td>
            <td align="right" style="letter-spacing:1px; font-size:104%;">'.is_Number($b).'&nbsp;</td>
            <td align="right" style="letter-spacing:1px; font-size:104%;">'.number_format($ac, 1).'&nbsp;</td>
            <td align="right" style="letter-spacing:1px; font-size:104%;">'.number_format($e, 1).'&nbsp;</td>
            <td align="right" style="letter-spacing:1px; font-size:104%;"><b>'.number_format($g, 1).'</b>&nbsp;</td>
        </tr></TFOOT>';
}
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=history class="history struct_table_center" tmp="history">
<DIV style="MARGIN-TOP: 0px" class="title h_title"><SPAN class=sub_title_color>账户历史</SPAN>&nbsp;&nbsp;<SPAN id=date 

class=hidden post_date="cdate="></SPAN>&nbsp;&nbsp;&nbsp;&nbsp;<A id=reback class="btn_m elem_btn hidden" 

href="javascript:void(0)" bdata="reback,click,reback">返回</A></DIV>
<DIV style="CLEAR: both"></DIV><!--账户历史总明细 result-->
<DIV id=history_result class="history_tb ">
<TABLE id=lastweek_tb class="struct_table_five t1 dataArea " width="100%">
<COLGROUP>
<COL width="20%">
<COL width="20%">
<COL width="20%">
<COL width="20%"></COLGROUP>
<THEAD>
<TR>
<TH>日期</TH>
<TH>注數</TH>
<TH>下注金額</TH>
<th>輸贏結果</th>
<TH>佣金</TH>
<TH>盈虧</TH></TR></THEAD>
<TBODY>
        <?php
		if(!isset($_GET['type']))
		 echo setHtml($week['weekstart'], '上周', $user);
		 else
		 echo setHtml($week['weekstart'], '上周', $user,$_GET['type']);
		 ?>
</table>
<TABLE style="MARGIN-TOP: 19px" id=thisweek_tb class="struct_table_five t1 dataArea">
<COLGROUP>
<COL width="20%">
<COL width="20%">
<COL width="20%">
<COL width="20%"></COLGROUP>
<THEAD>
<TR>
<TH>日期</TH>
<TH>注數</TH>
<TH>下注金額</TH>
<th>輸贏結果</th>
<TH>佣金</TH>
<TH>盈虧</TH></TR></THEAD>
<TBODY>
        <?php 

		if(!isset($_GET['type']))
		echo setHtml($week['weekend'], '本周', $user);
		else
		echo setHtml($week['weekend'], '本周', $user,$_GET['type']);
		?>
</table>

<?php

}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"   >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script language="javascript">
var win = window.parent.document;   
$('#thisweek_tb,#lastweek_tb',win).find('tbody').find('tr').bind({ 
 'mouseenter':function(){$(this).addClass('bc');},  'mouseleave':function(){$(this).removeClass('bc');} }) 
 $('#thisweek_tb,#lastweek_tb',win).find('a').bind('click',function(){ 
  parent.loadMainHtml( $(this).attr('rel')+'&rnd='+new Date(),'Repore1' );  
  return false; })
  </script>
</head>
<body>
</body>
</html>
<?php }?>
