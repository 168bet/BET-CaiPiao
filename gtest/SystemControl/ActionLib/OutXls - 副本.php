<?php  
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
 
function xlsBOF() {
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
return;
}

function xlsEOF() {
echo pack("ss", 0x0A, 0x00);
return;
}

function xlsWriteNumber($Row, $Col, $Value) {
echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
echo pack("d", $Value);
return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
$L = strlen($Value);
echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
echo $Value;
return;
}


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
}else{	
	$p = '廣東快樂十分';
		$pp = 'gd';
}
//$p=iconv('utf-8', 'gb2312',$p);

// Query Database
$db = new DB();

$where = "g_qishu = '{$g_qishu}'";
	
$sql = "SELECT * FROM g_zhudan WHERE {$where} AND  g_type = '{$p}' ORDER BY g_id DESC ";
$result = $db->query($sql, 1);


// Send Header
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=$pp-$g_qishu.xls ");
header("Content-Transfer-Encoding: binary ");


// XLS Data Cell

xlsBOF();
xlsWriteLabel(1,0,"Student Register $semester/$year");
xlsWriteLabel(2,0,"COURSENO : ");
xlsWriteLabel(2,1,"$courseid");
xlsWriteLabel(3,0,iconv('utf-8', 'gbk', "网站名称 : "));
xlsWriteLabel(3,1,iconv('utf-8', 'gbk', $Title));
xlsWriteLabel(4,0,iconv('utf-8', 'gbk', "期数 : "));
xlsWriteLabel(4,1,iconv('utf-8', 'gbk', "$p-$g_qishu"));
xlsWriteLabel(6,0,iconv('utf-8', 'gbk', "注單號碼/時間"));
xlsWriteLabel(6,1,iconv('utf-8', 'gbk', "下注類型"));
xlsWriteLabel(6,2,iconv('utf-8', 'gbk', "帳號"));
xlsWriteLabel(6,3,iconv('utf-8', 'gbk', "下注明細"));
xlsWriteLabel(6,4,iconv('utf-8', 'gbk', "會員下注"));
xlsWriteLabel(6,5,iconv('utf-8', 'gbk', "輸贏結果"));
$xlsRow = 7;
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


xlsWriteLabel($xlsRow,0,iconv('utf-8', 'gbk',$result[$j]['g_id'].'#'.$result[$j]['g_date'].' '.GetWeekDay($result[$j]['g_date'],1)));
xlsWriteLabel($xlsRow,1,iconv('utf-8', 'gbk',$result[$j]['g_type']));
xlsWriteLabel($xlsRow,2,$result[$j]['g_nid']);//iconv('utf-8', 'gb2312',$result[$j]['g_nid'])
xlsWriteLabel($xlsRow,3,iconv('utf-8', 'gbk',$html));
xlsWriteNumber($xlsRow,4,$SumNum);
xlsWriteLabel($xlsRow,5,$win);
$xlsRow++;
}
xlsEOF();
//exit();



 ?>
 
 
 <html>
<body>
<div><b>我是表头</b></div>
<table width="100%" border="1" align="center" cellspacing="1" cellpadding="1">
<tr align="center">
    <td nowrap><b>序号</b></td>
    <td nowrap><b>学生姓名</b></td>
    <td nowrap><b>服务站</b></td>
    <td nowrap><b>学籍批次</b></td>
    <td nowrap><b>层次</b></td>
    <td nowrap><b>专业</b></td>
    <td nowrap><b>联系电话</b></td>
    <td nowrap><b>手机</b></td>
    <td nowrap><b>大学英语（B）</b></td>
    <td nowrap><b>计算机应用基础</b></td>
    <td nowrap><b>大学语文（A）</b></td>
    <td nowrap><b>大学语文（B）</b></td>
    <td nowrap><b>高等数学（B）</b></td>
</tr>
<tr align="center">
    <td nowrap>1</td>
    <td nowrap>qifei</td>
    <td nowrap>山东教学服务中心</td>
    <td nowrap>200509</td>
    <td nowrap>高起本</td>
    <td nowrap>计算机科技</td>
    <td nowrap>010-10101010</td>
    <td nowrap>13233333333</td>
    <td nowrap>通过</td>
    <td nowrap>未通过</td>
    <td nowrap>通过</td>
    <td nowrap>未通过</td>
    <td nowrap>免考</td>
</tr>
<tr align="center">
    <td nowrap>2</td>
    <td nowrap>qifei</td>
    <td nowrap>山东教学服务中心</td>
    <td nowrap>200509</td>
    <td nowrap>高起本</td>
    <td nowrap>计算机科技</td>
    <td nowrap>010-10101010</td>
    <td nowrap>13233333333</td>
    <td nowrap>通过</td>
    <td nowrap>未通过</td>
    <td nowrap>通过</td>
    <td nowrap>未通过</td>
    <td nowrap>免考</td>
</tr>
</table>
<br>
<b>其他的文字</b><br>
1、可以写在这里<br>
2、<a href="http://www.rams.cc">OFFICE里也可以加连接的</a><br>
</body>
</html>
