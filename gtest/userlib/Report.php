<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
global $user;
$ConfigModel = configModel("`g_mix_money`");
if($_SESSION['gameType']!=$_GET['gameType'])
$gameType=$_GET['gameType'];
else
$gameType=$_SESSION['gameType'];

markPos("前台-{$gameType}下注明细-us");

if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{
$db = new DB();
//$sql = "SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` WHERE `g_nid` = '{$user[0]['g_name']}' AND `g_win` is null  ORDER BY g_date DESC  ";
$sql = "SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` WHERE `g_nid` = '{$user[0]['g_name']}'   ORDER BY g_date DESC  ";
$result = $db->query($sql, 1);
//$sql1 = "SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` WHERE `g_nid` = '{$user[0]['g_name']}' AND `g_win` is null   ";
$sql1 = "SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` WHERE `g_nid` = '{$user[0]['g_name']}'    ";
$results = $db->query($sql1, 1);
$countBNum = 0;
$countTNum = 0;
$countSNum = 0;
if ($results)
{
	for ($i=0; $i<count($results); $i++)
	{
		$countMoney = sumCountMoney ($user, $results[$i], true);
		$countBNum += $countMoney['Num'];
		$countTNum += $countMoney['Money'];
		$countSNum += $countMoney['Win'];
	}
}
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=status class="page status status-module" tmp="status">
<DIV id=status class="page status status-module" tmp="status">
<DIV style="HEIGHT: 4px; VISIBILITY: hidden; FONT-SIZE: 0px"></DIV>
<DIV class=status-xg></DIV>
<DIV class=fLeft>
<DIV id=radio_se class=elem_detailTabs><INPUT id=su value=1 CHECKED type=radio name=sl > <LABEL class=label for=su>

成功明细</LABEL> <INPUT id=lo value=1 type=radio name=sl> <LABEL class=label for=lo>失败明细</LABEL> </DIV></DIV>
<DIV class=clear></DIV>
<DIV class=dataArea>
<TABLE id=result_su class="t1 tc h1 status report" width="100%">
<THEAD>
<TR>
<TH>注单号</TH>
<TH>时间</TH>
<TH>类型</TH>
<TH>玩法</TH>
<TH>下注金额</TH>
<TH>退水(%)</TH>
<TH>可赢金额</TH>
<TH>状态</TH></TR></THEAD>
<TBODY>
<?php 
        if (count($result) <1) {echo '<tr class="t_td_text" align="center"><td colspan="8">暂无数据!</td></tr>';} 
        else {for ($i=0; $i<count($result); $i++) {
        $SumNum = sumCountMoney ($user, $result[$i], true);
        if ($result[$i]['g_mingxi_1_str'] == null) {
        	if ($result[$i]['g_mingxi_1'] == '總和、龍虎' || $result[$i]['g_mingxi_1'] == '總和、龍虎和'){
        		$n = $result[$i]['g_mingxi_2'];
        	}else {
        		$n = $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
        	}
        	//$n = $result[$i]['g_mingxi_1'] == '總和、龍虎' ? $result[$i]['g_mingxi_2'] : $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
        	$html = '<SPAN class=bluer>'.$n.'</span>@ <font color="red"><b>'.$result[$i]['g_odds'].'</b></font>';
        } else {
        	$_xMoney = $result[$i]['g_mingxi_1_str'] * $result[$i]['g_jiner'];
        	$SumNum['Money'] = '<font color="#009933">'.$result[$i]['g_mingxi_1_str'].'</font> x <font color="#0066FF">'.$result[$i]['g_jiner'].'</font><br />'.$_xMoney;
        	$html = '<SPAN class=bluer>'.$result[$i]['g_mingxi_1'].'</SPAN>@ <font color="red"><b>'.$result[$i]['g_odds'].'</b></font><br />'.
        				'<span style="line-height:23px">復式  『 '.$result[$i]['g_mingxi_1_str'].' 組 』</span><br/><span>'.$result[$i]['g_mingxi_2'].'</span>';
        }
        ?>
		<TR>
<TD class=greener><?php echo$result[$i]['g_id']?></TD>
<TD><?php 
        	$a = explode('-', $result[$i]['g_date']);
        	echo $a[1].'-'.$a[2].' '.$a[3].' '.GetWeekDay($result[$i]['g_date'], 0)
        	?><BR></TD>
<TD><?php echo$result[$i]['g_type']?><BR><?php echo$result[$i]['g_qishu']?>期</TD>
<TD class=td_autoline><?php echo$html?></TD>
<TD><?php echo $SumNum['Money']?></TD>
<TD><?php echo number_format((100-floatval($result[$i]['g_tueishui'])),2) ?>%</TD>
<TD><?php echo is_Number($SumNum['Win'], 1)?></TD>
<TD>成功</TD></TR>
<TR>

<?php }}?>
<TFOOT class=bg_g1>
<TR id=s_alltotal class="alltotal bold">
<TD></TD>
<TD></TD>
<TD></TD>
<TD name="title"><STRONG class=blue>总计</STRONG></TD>
<TD name="t1"><b><?php echo number_format($countTNum, 1)?></b></TD>
<TD></TD>
<TD name="t2"><b><?php echo number_format($countSNum, 1)?></b></TD>
<TD name="t3"></TD></TR></TFOOT></TABLE>
<TABLE id=result_lo class="t1 tc h1 status  report" width="100%">
<THEAD>
<TR>
<TH>注单号</TH>
<TH>时间</TH>
<TH>类型</TH>
<TH>玩法</TH>
<TH>下注金额</TH>
<TH>退水(%)</TH>
<TH>可赢金额</TH>
<TH>状态</TH></TR></THEAD>
<TBODY>
<TR>
<TD colSpan=8>暂无数据!</TD></TR></TBODY>
<TFOOT class=bg_g1>
<TR id=s_alltotal class="alltotal bold">
<TD></TD>
<TD></TD>
<TD></TD>
<TD name="title"><STRONG class=blue>总计</STRONG></TD>
<TD name="t1">0.0</TD>
<TD></TD>
<TD name="t2">0.0</TD>
<TD name="t3"></TD></TR></TFOOT></TABLE></DIV></DIV></DIV></DIV></DIV>
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
$('input[name=sl]',win).bind('click',function(){  
$('.report',win).hide();  
$('#result_'+$(this).attr('id'),win).show();
 })  
 $('.report',win).find('tbody').find('tr').bind({  
 'mouseenter':function(){$(this).addClass('bc');},  
 'mouseleave':function(){$(this).removeClass('bc');},
  })
   $('.td_pages',win).find('a').bind('click',function(){ 
    parent.loadMainHtml( $(this).attr('href'),'Report' );  
	return false; 
	})
	</script>
</head>
<body>
</body>
</html>
<?php }?>
