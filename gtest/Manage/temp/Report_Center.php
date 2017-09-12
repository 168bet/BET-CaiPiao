<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $LoginId,$Users;
if ($LoginId == 89)
	$Users[0]['g_Lnid'][0] = $Users[0]['g_Lnid'][1];
$db = new DB();

markPos("后台-进入报表");

//$sql="SELECT `g_id`, `g_s_nid`, `g_mumber_type`, `g_nid`, `g_date`, `g_type`, `g_qishu`, `g_mingxi_1`, `g_mingxi_1_str`, `g_mingxi_2`, `g_mingxi_2_str`, `g_odds`, `g_jiner`, `g_tueishui`, `g_tueishui_1`, `g_tueishui_2`, `g_tueishui_3`, `g_tueishui_4`, `g_distribution`, `g_distribution_1`, `g_distribution_2`, `g_distribution_3`, `g_win`, `g_t_id` FROM `g_zhudan` WHERE g_s_nid LIKE '67552ea64c6dce1646a263bae714e788aaec6ec3adcb5a2276ee39615b846fa1%' AND g_date > '2012-07-01 02:00:00' AND g_date < '2012-08-01 02:00:00' AND g_win is not null order by g_id desc ";

//print_r($db->query($sql, 1).'--');exit;


$result = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultcq = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history2` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultgx = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history3` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultjx = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history4` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultnc = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history5` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultpk = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history6` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultk3 = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history7` ORDER BY g_qishu DESC LIMIT 30 ", 1);

$week = week ();
$sDate = array(
	0=>date("Y-m-d", mktime(0,0,0,date('m'),date('d')-1,date('Y'))), 
	1=>date('Y-m-d', mktime(0,0,0,date('n'),1,date('Y'))),
	2=>date('Y-m-d', mktime(0,0,0,date('n'),date('t'),date('Y'))),
	3=>date('Y-m-01', strtotime('last month')),
	4=>date('Y-m-t', strtotime('last month')),
	5=>$week['weekend'][0],
	6=>$week['weekend'][6],
	7=>$week['weekstart'][0],
	8=>$week['weekstart'][6],
	9=>date("Y-m-d", mktime(0,0,0,date('m')-1,date('d')-4,date('Y'))));



if (date('H:i:s')<='02:30') {
	$f= dayMorning(date("Y-m-d"), (60*60*24), true);
	$ff = 2;
} else {
	$f = date("Y-m-d");
	$ff= 1;
}
$z = date("Y-m-d", mktime(0,0,0,date('m'),date('d')-$ff,date('Y')));
$ty = GetWeekDay(date('Y-m-d'), 0) == '一' ? dayMorning(date("Y-m-d"), (60*60*24), true) : date('Y-m-d');
$awary = aweek($ty, 1);
$aday = GetTheMonth(date('Y-m-d'));
$month = GetPurMonth(date('Y-m-d'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script  type="text/javascript" src="/js/jquery.js"></script>
<script  type="text/javascript" src="/Manage/temp/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
<!--
	function AutoSet_Date(str) {
		var startDate = $("#startDate");
		var endDate = $("#endDate");
		switch (str) {
			case 1 : 
				startDate.val("<?php echo $f?>");
				endDate.val("<?php echo $f?>");
				break;
			case 2 : 
				startDate.val("<?php echo $z?>");
				endDate.val("<?php echo $z?>");
				break;
			case 3 : 
				startDate.val("<?php echo $awary[0]?>");
				endDate.val("<?php echo $awary[1]?>");
				break;
			case 4 : 
				startDate.val("<?php echo $awary[2]?>");
				endDate.val("<?php echo $awary[3]?>");
				break;
			case 5 : 
				startDate.val("<?php echo $aday[0]?>");
				endDate.val("<?php echo $aday[1]?>");
				break;
			case 6 : 
				startDate.val("<?php echo $month[0]?>");
				endDate.val("<?php echo $month[1]?>");
				break;
		}
	}
//-->
</script>
<title></title>
</head>
<body>
<form action="Report_Crystals.php" method="get">
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
                        <td background="/Manage/temp/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/Manage/temp/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;<?php echo$Users[0]['g_Lnid'][0]?>報表查詢</td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<th colspan="2">查詢設定</th>
                                </tr>
                                <tr>
                                	<td class="bj1">彩票種類</td>
                                    <td class="left_p6">
                                        <select name="s_types">
                                            <option value="" style="color:red">--- 所有彩種 ---</option>
                                            <option value="1" style="color:red">廣東快樂十分</option>
                                            <option value="2" style="color:red">重慶時時彩</option>
											
											  <option value="6" style="color:red">北京赛车PK10</option>
											  <option value="7" style="color:red">江苏骰寶(快3)</option>
                                        </select>
                					</td>
                                </tr>
                                <tr>
                                	<td class="bj1">下註類型</td>
                                    <td class="left_p6">
                                        <select name="s_type" >
                                        <option value="">--- 所有類型 ---</option>
                                        <option value='1'>廣東快樂十分 - 第一球</option>
                                        <option value='2'>廣東快樂十分 - 第二球</option>
                                        <option value='3'>廣東快樂十分 - 第三球</option>
                                        <option value='4'>廣東快樂十分 - 第四球</option>
                                        <option value='5'>廣東快樂十分 - 第五球</option>
                                        <option value='6'>廣東快樂十分 - 第六球</option>
                                        <option value='7'>廣東快樂十分 - 第七球</option>
                                        <option value='8'>廣東快樂十分 - 第八球</option>
                                        <option value='9'>廣東快樂十分 - 1-8大小</option>
                                        <option value='10'>廣東快樂十分 - 1-8單雙</option>
                                        <option value='11'>廣東快樂十分 - 1-8尾數大小</option>
                                        <option value='12'>廣東快樂十分 - 1-8合數單雙</option>
                                        <option value='13'>廣東快樂十分 - 1-8方位</option>
                                        <option value='14'>廣東快樂十分 - 1-8中發白</option>
                                        <option value='15'>廣東快樂十分 - 總和大小</option>
                                        <option value='16'>廣東快樂十分 - 總和單雙</option>
                                        <option value='17'>廣東快樂十分 - 總和尾數大小</option>
                                        <option value='18'>廣東快樂十分 - 龍虎</option>
                                        <option value='19'>廣東快樂十分 - 任選二</option>
                                        <option value='20'>廣東快樂十分 - 選二連直</option>
                                        <option value='21'>廣東快樂十分 - 選二連組</option>
                                        <option value='22'>廣東快樂十分 - 任選三</option>
                                        <option value='23'>廣東快樂十分 - 選三前直</option>
                                        <option value='24'>廣東快樂十分 - 選三前組</option>
                                        <option value='25'>廣東快樂十分 - 任選四</option>
                                        <option value='26'>廣東快樂十分 - 任選五</option>
                                        <option value='27'>重慶時時彩 - 第一球</option>
                                        <option value='28'>重慶時時彩 - 第二球</option>
                                        <option value='29'>重慶時時彩 - 第三球</option>
                                        <option value='30'>重慶時時彩 - 第四球</option>
                                        <option value='31'>重慶時時彩 - 第五球</option>
                                        <option value='32'>重慶時時彩 - 1-5大小</option>
                                        <option value='33'>重慶時時彩 - 1-5單雙</option>
                                        <option value='34'>重慶時時彩 - 總和大小</option>
                                        <option value='35'>重慶時時彩 - 總和單雙</option>
                                 		<option value='36'>重慶時時彩 - 龍虎和</option>
                                 		<option value='37'>重慶時時彩 - 前三</option>
                                 		<option value='38'>重慶時時彩 - 中三</option>
                                 		<option value='39'>重慶時時彩 - 后三</option>
										
									
										<option value='100'>北京赛车 - 冠军</option>
                                        <option value='101'>北京赛车 - 亚军</option>
                                        <option value='102'>北京赛车 - 第三名</option>
                                        <option value='103'>北京赛车 - 第四名</option>
                                        <option value='104'>北京赛车 - 第五名</option>
                                        <option value='105'>北京赛车 - 第六名</option>
                                        <option value='106'>北京赛车 - 第七名</option>
                                        <option value='107'>北京赛车 - 第八名</option>
										<option value='108'>北京赛车 - 第九名</option>
										<option value='109'>北京赛车 - 第十名</option>
                                        <option value='110'>北京赛车 - 1-10大小</option>
                                        <option value='111'>北京赛车 - 1-10單雙</option>
                                        <option value='112'>北京赛车 - 1-10龍虎</option>
                                        <option value='113'>北京赛车 - 冠、亞軍和</option>
                                        <option value='114'>北京赛车 - 冠亞和大小</option>
                                        <option value='115'>北京赛车 - 冠亞和單雙</option>
                                       
									   
									    <option value='116'>江苏骰寶(快3) - 三軍</option>
                                        <option value='117'>江苏骰寶(快3) - 三軍大小</option>
                                        <option value='118'>江苏骰寶(快3) - 圍骰</option>
										<option value='119'>江苏骰寶(快3) - 全骰</option>
                                        <option value='120'>江苏骰寶(快3) - 點數</option>
                                        <option value='121'>江苏骰寶(快3) - 長牌</option>
                                        <option value='122'>江苏骰寶(快3) - 短牌</option>
                                       
                                        </select>
                					</td>
                                </tr>
                                <tr>
                                	<td class="bj1"><input name="t_N" type="radio" value="0" />按期數</td>
                                    <td class="left_p6">
                                        <select name="s_number">
                                       <?php for ($i=0; $i<count($result); $i++){?>
                                       <option value='<?php echo$result[$i]['g_qishu']?>'>廣東快樂十分 <?php echo$result[$i]['g_qishu']?> 期</option>
                                       <?php }?>
                                       <?php for ($i=0; $i<count($resultcq); $i++){?>
                                       <option value='<?php echo$resultcq[$i]['g_qishu']?>'>重慶時時彩 <?php echo$resultcq[$i]['g_qishu']?> 期</option>
                                     <?php }?>
									     
									    <?php for ($i=0; $i<count($resultpk); $i++){?>
                                       <option value='<?php echo$resultpk[$i]['g_qishu']?>'>北京赛车PK10 <?php echo$resultpk[$i]['g_qishu']?> 期</option>
                                       <?php }?>
									     <?php for ($i=0; $i<count($resultk3); $i++){?>
                                       <option value='<?php echo$resultk3[$i]['g_qishu']?>'>江苏骰寶(快3) <?php echo$resultk3[$i]['g_qishu']?> 期</option>
                                       <?php }?>
                                        </select>
                					</td>
                                </tr>
                                <tr>
                                	<td class="bj1"><input name="t_N" type="radio" value="1" checked="checked" />按日期</td>
                                    <td class="left_p6">
                                        <span id="td_Find">
	                                        <input class='Wdate' id="startDate" name="startDate" value='<?php echo $f?>' size='11' onfocus="WdatePicker({el:'startDate'})" />&nbsp;—&nbsp;
	                                        <input class='Wdate' id="endDate" name='endDate' onfocus="WdatePicker({el:'endDate'})" value='<?php echo $f?>' size='11' />
                                        </span>&nbsp;&nbsp;
                                        <input type="button" class="odds" onclick="AutoSet_Date(1)" value="今天" />
					                    <input type="button" onclick="AutoSet_Date(2)" value="昨天" />
					                    <input type="button" onclick="AutoSet_Date(3)" value="本星期" />
					                    <input type="button" onclick="AutoSet_Date(4)" value="上星期" />
					                    <input type="button" onclick="AutoSet_Date(5)" value="本月" />
					                    <input type="button" onclick="AutoSet_Date(6)" value="上月" />
                					</td>
                                </tr>
                                <tr>
                                	<td class="bj1">歷史報表範圍</td>
                                	<td class="left_p6"><?php echo $sDate[9]?> — <?php echo date('Y-m-d')?></td>
                                </tr>
                                <tr>
                                	<td class="bj1">帳務說明</td>
                                	<td class="left_p6" style="height:55px; color:green">
                                	“當天報表” 將在次日淩晨2點半后与 “歷史報表” 合併
                                	<br /><br />
                                	“重慶時時彩” 淩晨兩點前註單算當天帳
                                	</td>
                                </tr>
                                <tr>
                                	<td class="bj1"><?php echo$Users[0]['g_Lnid'][0]?>報錶類型</td>
                                    <td class="left_p6">
                                    <input name="ReportType" type="radio" value="1" checked="checked" />交收報錶&nbsp;&nbsp;&nbsp;
                                    <input name="ReportType" type="radio"  value="0" />分類報錶
                                    </td>
                                </tr>
                                <tr>
                                	<td class="bj1">結算狀態</td>
                                    <td class="left_p6">
                                    <input name="Balance" type="radio" value="1" checked="checked" />已 結 算&nbsp;&nbsp;&nbsp;
                                    <input name="Balance" type="radio" value="0" /><font color="blue">未 結 算</font>
                                    </td>
                                </tr>
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center"><input type="submit" class="inputs" value="確定" /></td>
                        <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"> </td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"> </td>
        </tr>
    </table>
</form>
</body>
</html>