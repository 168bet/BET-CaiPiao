<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';



$g_qishu=$_GET['qishu'];

$g_type=$_GET['type'];

if (isset($g_type) && $g_type == 2){
	$p = '重慶時時彩';
	$pp = 'cq';
} else if (isset($g_type) && $g_type == 3){
	$p = '廣西快樂十分';	
		$pp = 'gx';
}else if(isset($g_type) && $g_type == 4){
		$p = '江西時時彩';
			$pp = 'jx';
}else if(isset($g_type) && $g_type == 5){	
	$p = '幸运农场';
		$pp = 'nc';
}else if(isset($g_type) && $g_type == 6){	
	$p = '北京赛车PK10';
		$pp = 'pk10';
}else if(isset($g_type) && $g_type == 7){	
	$p = '江苏骰寶(快3)';
		$pp = 'k3';
}else{	
	$p = '廣東快樂十分';
		$pp = 'gd';
}

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: filename='.$pp.'-'.$g_qishu.'.xls');//起作用的就是这行代码

//$p=iconv('utf-8', 'gb2312',$p);

// Query Database
$db = new DB();

$where = "g_qishu = '{$g_qishu}'";
	
$sql = "SELECT * FROM g_zhudan WHERE {$where} AND  g_type = '{$p}' ORDER BY g_id DESC ";
$result = $db->query($sql, 1);
?>
<html>
<body>
<div><b>网站名称 :<?php echo $Title?>&nbsp;&nbsp;&nbsp;期数 :<?php echo $p.'-'.$g_qishu?></b></div>
<table width="100%" border="1" align="center" cellspacing="1" cellpadding="1">
  <tr align="center">
    <td nowrap><b>编号</b></td>
    <td nowrap><b>用户</b></td>
    <td nowrap><b>期数</b></td>
    <td nowrap><b>下注时间</b></td>
    <td nowrap><b>类型1</b></td>
    <td nowrap><b>类型2</b></td>
    <td nowrap><b>类型3（下注明細）</b></td>
    <td nowrap><b>金额</b></td>
    <td nowrap><b>赔率</b></td>
    <td nowrap><b>会员盘</b></td>
    <td nowrap><b>会员退水</b></td>
    <td nowrap><b>代理退水</b></td>
    <td nowrap><b>总代退水</b></td>
    <td nowrap><b>股东退水</b></td>
    <td nowrap><b>分公司退水</b></td>
    <td nowrap><b>代理占成</b></td>
    <td nowrap><b>总代占成</b></td>
    <td nowrap><b>股东占成</b></td>
    <td nowrap><b>分公司占成</b></td>
    <td nowrap><b>庄家占成</b></td>
    <td nowrap><b>代理</b></td>
    <td nowrap><b>总代理</b></td>
    <td nowrap><b>股东</b></td>
    <td nowrap><b>分公司</b></td>
  </tr>
  <?php 
for($j=0;$j<count($result);$j++){
if ($result[$j]['g_mingxi_1_str'] == null) {
                               				if ($result[$j]['g_mingxi_1'] == '總和、龍虎' || $result[$j]['g_mingxi_1'] == '總和、龍虎和'){
                               					$n = $result[$j]['g_mingxi_2'];
                               				} else {
                               					$n = $result[$j]['g_mingxi_1'].'『'.$result[$j]['g_mingxi_2'].'』';
											}
                                		 	//$n = $result[$i]['g_mingxi_1'] == '總和、龍虎' ? $result[$i]['g_mingxi_2'] : $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
                                		 	$html = $n.'@ '.$result[$j]['g_odds'];
                                		 	$SumNum = $result[$j]['g_jiner'];
                                		 } else {
                                		 	$_xMoney = $result[$j]['g_mingxi_1_str'] * $result[$j]['g_jiner'];
                                		 	$SumNum = $result[$j]['g_mingxi_1_str'].$result[$j]['g_jiner'].$_xMoney;
											$html = $result[$j]['g_mingxi_1'].'@ '.$result[$j]['g_odds'].
						        				'復式  『 '.$result[$j]['g_mingxi_1_str'].' 組 』'.$result[$j]['g_mingxi_2'];
                                		 }
                                $win = $result[$j]['g_win'] != null ? $result[$j]['g_win'] : '『 未結算 』';

$g_nid=$result[$j]['g_s_nid'];
$sqldl = "SELECT * FROM g_rank WHERE g_nid='$g_nid'  ";
$dl = $db->query($sqldl, 1);
$g_nid=substr($g_nid,0,128);
$sqlzd = "SELECT * FROM g_rank WHERE g_nid='$g_nid'  ";
$zd = $db->query($sqlzd, 1);
$g_nid=substr($g_nid,0,96);
$sqlgd = "SELECT * FROM g_rank WHERE g_nid='$g_nid'  ";
$gd = $db->query($sqlgd, 1);
$g_nid=substr($g_nid,0,64);
$sqlgs = "SELECT * FROM g_rank WHERE g_nid='$g_nid'  ";
$gs = $db->query($sqlgs, 1);
?>
  <tr align="center">
    <td nowrap><?php echo $result[$j]['g_id']?></td>
    <td nowrap><?php echo $result[$j]['g_nid']?></td>
    <td nowrap><?php echo $result[$j]['g_qishu']?></td>
    <td nowrap><?php echo $result[$j]['g_date']?></td>
    <td nowrap><?php echo $result[$j]['g_mingxi_1']?></td>
    <td nowrap><?php echo $result[$j]['g_mingxi_1_str']==""? $result[$j]['g_mingxi_1']:'復式'.$result[$j]['g_mingxi_1_str'].'组'?></td>
    <td nowrap><?php echo $result[$j]['g_mingxi_2']?></td>
    <td nowrap><?php echo $result[$j]['g_jiner']?></td>
    <td nowrap><?php echo $result[$j]['g_odds']?></td>
    <td nowrap><?php echo $result[$j]['g_pan']?></td>
    <td nowrap><?php echo $result[$j]['g_tueishui']?></td>
    <td nowrap><?php echo $result[$j]['g_tueishui_1']?></td>
    <td nowrap><?php echo $result[$j]['g_tueishui_2']?></td>
    <td nowrap><?php echo $result[$j]['g_tueishui_3']?></td>
    <td nowrap><?php echo $result[$j]['g_tueishui_4']?></td>
    <td nowrap><?php echo $result[$j]['g_distribution']?></td>
    <td nowrap><?php echo $result[$j]['g_distribution_1']?></td>
    <td nowrap><?php echo $result[$j]['g_distribution_2']?></td>
    <td nowrap><?php echo $result[$j]['g_distribution_3']?></td>
    <td nowrap><?php echo $result[$j]['g_distribution_4']?></td>
    <td nowrap><?php echo $dl[0]['g_name']?></td>
    <td nowrap><?php echo $zd[0]['g_name']?></td>
    <td nowrap><?php echo $gd[0]['g_name']?></td>
    <td nowrap><?php echo $gs[0]['g_name']?></td>
  </tr>
  <?php }?>
</table>
<br>
<b>导出日期：<?php echo date('Y-m-d H:i:s',time());?></b><br>
<br>
<?php echo $p.'-'.$g_qishu?>期注单报表<br>
</body>
</html>
