<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
global $LoginId,$Users;
if ($LoginId == 89)
	$Users[0]['g_Lnid'][0] = $Users[0]['g_Lnid'][1];
$db = new DB();
$result = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history` ORDER BY g_qishu DESC LIMIT 30 ", 1);
$resultcq = $db->query("SELECT `g_id`, `g_qishu` FROM `g_history2` ORDER BY g_qishu DESC LIMIT 30 ", 1);
 
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



if ($_SERVER["REQUEST_METHOD"] == "POST"){
 	$startDate = $_POST['startDate']; //日期查詢
	$endDate = $_POST['endDate']; //日期查詢
	$s_Balance = $_POST['Balance']; //結算狀態
	$pageNum = 50;
	$end = dayMorning($endDate, 60*60*24);
	$n = " a.g_date > '{$startDate} 02:00:00' AND a.g_date < '{$end} 02:00:00' ";
	
	$str="AND (a.g_mingxi_1!=b.g_mingxi_1 or a.g_mingxi_2!=b.g_mingxi_2 or a.g_type!=b.g_type or a.g_jiner!=b.g_jiner or a.g_tueishui!=b.g_tueishui or a.g_tueishui_1!=b.g_tueishui_1 or a.g_tueishui_2!=b.g_tueishui_2 or a.g_tueishui_3!=b.g_tueishui_3 or a.g_tueishui_4!=b.g_tueishui_4 or a.g_distribution!=b.g_distribution or a.g_distribution_1!=b.g_distribution_1 or a.g_distribution_2!=b.g_distribution_2 or a.g_distribution_3!=b.g_distribution_3 or a.g_distribution_4!=b.g_distribution_4)";
	
	$win = $s_Balance == 1 ? "AND a.g_win is not null " : " AND a.g_win is null ";	//結算狀態
	
	
	$sql="SELECT a.g_mingxi_1_str as amingxistr,a.g_mingxi_1 as amingxi1,a.g_mingxi_2 as amingxi2,a.g_odds as aodds,a.g_jiner as ajiner,a.g_win as awin,a.g_id as aid,a.g_date as adate,a.g_type as atype,a.g_qishu as aqishu,a.g_nid as anid,a.g_tueishui as atueishui,b.g_type as btype,b.g_mingxi_1_str as bmingxistr,b.g_mingxi_1 as bmingxi1,b.g_mingxi_2 as bmingxi2,b.g_jiner as bjiner,b.g_tueishui as btueishui,b.g_odds as bodds FROM `g_zhudan` a left join g_zhudan_copy b on a.g_id=b.g_id WHERE  {$n} {$win} {$str} ";
	$total = $db->query($sql, 3);
	$page = new Page($total, $pageNum);
	$result1 = $db->query($sql, 1);
	
	
}

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
				startDate.val("<?php echo date('Y-m-d')?>");
				endDate.val("<?php echo date('Y-m-d')?>");
				break;
			case 2 : 
				startDate.val("<?php echo $sDate[0]?>");
				endDate.val("<?php echo $sDate[0]?>");
				break;
			case 3 : 
				startDate.val("<?php echo $sDate[5]?>");
				endDate.val("<?php echo $sDate[6]?>");
				break;
			case 4 : 
				startDate.val("<?php echo $sDate[7]?>");
				endDate.val("<?php echo $sDate[8]?>");
				break;
			case 5 : 
				startDate.val("<?php echo $sDate[1]?>");
				endDate.val("<?php echo $sDate[2]?>");
				break;
			case 6 : 
				startDate.val("<?php echo $sDate[3]?>");
				endDate.val("<?php echo $sDate[4]?>");
				break;
		}
	}
//-->
</script>
<title></title>
</head>
<body>
<form action="" method="post">
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
                                    <td width="99%">注单校验</td>
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
                                	<th colspan="4">查詢設定</th>
                                </tr>
                                <tr>
                                	<td class="bj1"><input name="t_N" type="radio" value="1" checked="checked" />按日期</td>
                                    <td class="left_p6" colspan="3">
                                        <span id="td_Find">
	                                        <input class='Wdate' id="startDate" name="startDate" value='<?php echo date('Y-m-d')?>' size='11' onfocus="WdatePicker({el:'startDate'})" />&nbsp;—&nbsp;
	                                        <input class='Wdate' id="endDate" name='endDate' onfocus="WdatePicker({el:'endDate'})" value='<?php echo date('Y-m-d')?>' size='11' />
                                        </span>&nbsp;&nbsp;
                                        <input type="button" class="odds" onclick="AutoSet_Date(1)" value="今天" />
					                    <input type="button" onclick="AutoSet_Date(2)" value="昨天" />
					                    <input type="button" onclick="AutoSet_Date(3)" value="本星期" />
					                    <input type="button" onclick="AutoSet_Date(4)" value="上星期" />
					                    <input type="button" onclick="AutoSet_Date(5)" value="本月" />
					                    <input type="button" onclick="AutoSet_Date(6)" value="上月" />                					</td>
                                </tr>
                                <tr>
                                	<td class="bj1">歷史報表範圍</td>
                                	<td class="left_p6"><?php echo $sDate[9]?> — <?php echo date('Y-m-d')?></td>
									<td class="bj1">結算狀態</td>
                                    <td class="left_p6">
                                    <input name="Balance" type="radio" value="1" checked="checked" />已 結 算&nbsp;&nbsp;&nbsp;
                                    <input name="Balance" type="radio" value="0" /><font color="blue">未 結 算</font>                                    </td>
                                </tr>
                               	<tr>
                    				
                       					<td colspan="4" align="center"><input type="submit" class="inputs"  value="確定" /></td>
                        				
                  				  </tr>
                            </table>
							
							
							
						<?php	if ($_SERVER["REQUEST_METHOD"] == "POST"){ ?>
							<table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<th colspan="8">检验结果</th>
                                </tr>
								<tr class="tr_top">
                                	<td width="180">注單號碼/時間</td>
                                    <td width="120">下注類型</td>
                                    <td width="80">帳號</td>
                                    <td>下注明細</td>
                                    <td>會員下注</td>
									<td>輸贏結果</td>
                                    <td>退水</td>
                                    <td width="130">注单状态</td>
                                </tr>
								<?php 
								if($result1){
								 for ($i=0; $i<count($result1); $i++){
								 
								 
								 if ($result1[$i]['amingxistr'] == null) {
                               				if ($result1[$i]['amingxi1'] == '總和、龍虎' || $result1[$i]['amingxi1'] == '總和、龍虎和'){
                               					$n = $result1[$i]['amingxi2'];
												$n2 = $result1[$i]['bmingxi2'];
                               				} else {
                               					$n = $result1[$i]['amingxi1'].'『'.$result1[$i]['amingxi2'].'』';
												$n2 = $result1[$i]['bmingxi1'].'『'.$result1[$i]['bmingxi2'].'』';
                               				}
                                		 	//$n = $result[$i]['g_mingxi_1'] == '總和、龍虎' ? $result[$i]['g_mingxi_2'] : $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
                                		 	$html = '<font color="#0066FF">'.$n.'</font>@ <font color="red"><b>'.$result1[$i]['aodds'].'</b></font>';
											$html2 = '<font color="#0066FF">'.$n2.'</font>@ <font color="red"><b>'.$result1[$i]['bodds'].'</b></font>';
                                		 	$SumNum = $result1[$i]['ajiner'];
											$SumNum2 = $result1[$i]['bjiner'];
                                		 } else {
                                		 	$_xMoney = $result1[$i]['amingxistr'] * $result1[$i]['ajiner'];
											$_xMoney2 = $result1[$i]['bmingxistr'] * $result1[$i]['bjiner'];
                                		 	$SumNum = '<font color="#009933">'.$result1[$i]['amingxistr'].'</font> x <font color="#0066FF">'.$result1[$i]['ajiner'].'</font><br />'.$_xMoney;
											$SumNum2 = '<font color="#009933">'.$result1[$i]['bmingxistr'].'</font> x <font color="#0066FF">'.$result1[$i]['bjiner'].'</font><br />'.$_xMoney2;
											$html = '<font color="#0066FF">'.$result1[$i]['amingxi1'].'</font>@ <font color="red"><b>'.$result1[$i]['aodds'].'</b></font><br />'.
						        				'<span style="line-height:23px">復式  『 '.$result1[$i]['amingxistr'].' 組 』</span><br/><span>'.$result1[$i]['amingxi2'].'</span>';
												
											$html2 = '<font color="#0066FF">'.$result1[$i]['bmingxi1'].'</font>@ <font color="red"><b>'.$result1[$i]['bodds'].'</b></font><br />'.
						        				'<span style="line-height:23px">復式  『 '.$result1[$i]['bmingxistr'].' 組 』</span><br/><span>'.$result1[$i]['bmingxi2'].'</span>';
                                		 }
                                $win = $result1[$i]['awin'] != null ? $result1[$i]['awin'] : '<span style="color:#0000FF">『 未結算 』</span>';
								 
								 
								 
								 
								 
								?>
								<tr>	
                       				<td  align="center"><?php echo$result1[$i]['aid']?>#<br /><?php echo$result1[$i]['adate'].'&nbsp;'.GetWeekDay($result1[$i]['adate'],1)?></td>       
									<td  align="center"><?php echo$result1[$i]['atype']?><br /><font color="#009933"><?php echo$result1[$i]['aqishu']?>期</font></td>       
									<td  align="center"><?php echo$result1[$i]['anid']?></td>       
									<td  align="center"><?php echo$html?><br/>(<?php echo $html2?>)</td>       
									<td  align="center"><?php echo $SumNum?><br/>(<?php echo $SumNum2?>)</td>       
									<td  align="center"><?php echo$win?></td> 
									<td  align="center"><?php echo$result1[$i]['atueishui']?>(<?php echo$result1[$i]['btueishui']?>)</td>      
									<td  align="center">异常注单，请仔细检查！</td>                        				
                  				  </tr>
								  
								 
								<?php
								}
								}else{
								?>
								<tr>	
                       				<td colspan="8" align="center">无校验异常记录</td>                        				
                  				  </tr>
								
							<? }
							?>
							</table>
							<?php
							}?>
							
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
					<?php	if ($_SERVER["REQUEST_METHOD"] == "POST"){ ?>
					
					<tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="right"><?php echo $page->fpage(array(0,1, 3,4,5,6,7))?></td>
                        <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
                    </tr>
					
					<?php }else{?>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center"></td>
                        <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
                    </tr>
					<?php }?>
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