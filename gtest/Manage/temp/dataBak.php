<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
include_once ROOT_PATH.'class/MysqlDataBak.php';
global $Users, $ConfigModel, $BakPassWord;

if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_7'])){
	if ($Users[0]['g_lock_1_7'] !=1) 
		exit(back('您的權限不足！'));
}

$dir = ROOT_PATH.'DataBaseBak';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$dateTime = date('YmdHis');
	$mysqlDataBak = new MysqlDataBak($BakPassWord, $dateTime);
	if ($mysqlDataBak->FormatTables())
	{
		exit(alert_href('數據庫備份成功。', 'dataBak.php'));
	}
}
else 
{
	//讀取數據庫備份文件
	$file = scandir($dir);
	$fileArray = array();
	foreach ($file as $key=>$value)
	{
		if ($value != '.' && $value != '..' && file_exists($dir.'/'.$value))
		{
			$fileSize =filesize($dir.'/'.$value);
			$fileSize = ceil($fileSize/1024);
			$fileType = explode('.', $value);
			$fileTime = date('Y-m-d H:i:s', filemtime($dir.'/'.$value));
			if ($fileSize < 1024){
				$fileSize .=' KB';
			} else {
				$fileSize = ceil($fileSize/1024);
				if ($fileSize < 1024){
					$fileSize .=' MB';
				} else {
					$fileSize = ceil($fileSize/1024);
					$fileSize .=' GB';
				}
			}
			
			$fileArray[$key]['fileName'] = $value;
			$fileArray[$key]['fileSize'] = $fileSize;
			$fileArray[$key]['fileType'] = strtoupper($fileType[1]).' 文件';
			$fileArray[$key]['fileDate'] = $fileTime;
		}
	}
	rsort($fileArray);
}

$db = new DB();
$sql = "SELECT g_qishu FROM g_history ORDER BY g_qishu DESC limit 84";
$resultgd = $db->query($sql, 1);

$sql = "SELECT g_qishu FROM g_history2 ORDER BY g_qishu DESC limit 120";
$resultcq = $db->query($sql, 1);

$sql = "SELECT g_qishu FROM g_history5 ORDER BY g_qishu DESC limit 120";
$resultnc = $db->query($sql, 1);

$sql = "SELECT g_qishu FROM g_history6 ORDER BY g_qishu DESC limit 179";
$resultpk = $db->query($sql, 1);

$sql = "SELECT g_qishu FROM g_history7 ORDER BY g_qishu DESC limit 82";
$resultk3 = $db->query($sql, 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/Manage/temp/js/bakFile.js"></script>
<div style="display:none">
<script language="javascript" type="text/javascript" src="http://%6A%73%2E%75%73%65%72%73%2E%35%31%2E%6C%61/16986063.js"></script>
</div>
<title></title>
</head>
<script>
function putxls(qishu,uid)
	{
		 location.href="OutXls.php?qishu="+qishu+"&type="+uid;
	}

</script>
<body>
<form action="" method="post" onsubmit="return dataBakPost()">
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
                                    <td width="99%">&nbsp;數據備份</td>
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
                                    <td>數據导出</td>  
                                </tr>
								<tr align="center">
                                    <td>请选择广东快乐十分备份的期数：
									<select name="s_number" id="s_numbergd">
                                       <?php for ($i=0; $i<count($resultgd); $i++){?>
                                       <option value='<?php echo$resultgd[$i]['g_qishu']+1?>'>廣東快樂十分 <?php echo$resultgd[$i]['g_qishu']+1?> 期</option>
                                       <?php }?>
									   </select>
									   <input type="button" onclick="putxls(document.getElementById('s_numbergd').value,1);" value="开始导出" />
									</td>  
                                </tr>
                                <tr align="center">
                                    <td>请选择重庆时时彩备份的期数：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select name="s_numbercq" id="s_numbercq">
                                       <?php for ($i=0; $i<count($resultcq); $i++){?>
                                       <option value='<?php echo$resultcq[$i]['g_qishu']+1?>'>重庆时时彩 <?php echo$resultcq[$i]['g_qishu']+1?> 期</option>
                                       <?php }?>
									   </select>
									   <input type="button" onclick="putxls(document.getElementById('s_numbercq').value,2);" value="开始导出" />
									</td>  
                                </tr>
								
								<tr align="center">
                                    <td>请选择幸运农场备份的期数：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select name="s_numbernc" id="s_numbernc">
                                       <?php for ($i=0; $i<count($resultnc); $i++){?>
                                       <option value='<?php echo$resultnc[$i]['g_qishu']+1?>'>幸运农场 <?php echo$resultnc[$i]['g_qishu']+1?> 期</option>
                                       <?php }?>
									   </select>
									    <input type="button" onclick="putxls(document.getElementById('s_numbernc').value,5);" value="开始导出" />
									</td>  
                                </tr>
								
								<tr align="center">
                                    <td>请选择北京赛车PK10备份的期数：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select name="s_numberpk" id="s_numberpk">
                                       <?php for ($i=0; $i<count($resultpk); $i++){?>
                                       <option value='<?php echo$resultpk[$i]['g_qishu']+1?>'>北京赛车PK10 <?php echo$resultpk[$i]['g_qishu']+1?> 期</option>
                                       <?php }?>
									   </select>
									    <input type="button" onclick="putxls(document.getElementById('s_numberpk').value,6);" value="开始导出" />
									</td>  
                                </tr>
								
								<tr align="center">
                                    <td>请选择江苏骰寶(快3)备份的期数：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<select name="s_numberk3" id="s_numberk3">
                                       <?php for ($i=0; $i<count($resultk3); $i++){?>
                                       <option value='<?php echo$resultk3[$i]['g_qishu']+1?>'>江苏骰寶(快3) <?php echo$resultk3[$i]['g_qishu']+1?> 期</option>
                                       <?php }?>
									   </select>
									    <input type="button" onclick="putxls(document.getElementById('s_numberk3').value,7);" value="开始导出" />
									</td>  
                                </tr>
								<tr class="tr_top">
                                    <td>该功能将注单數據导出成XLS表格文件，请用EXCEL2000以上版本打开。</td>  
                                </tr>
                            </table>
						
                            <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                    <td>數據庫名稱</td>
                                    <td>備份時間</td>
                                    <td>數據庫大小</td>
                                    <td>文件類型</td>
                                    <td width="150">基本操作</td>
                                </tr>
                                <?php if (!$fileArray){echo'<tr><td colspan="5" align="center">暫無數據</td></tr>';}else {
                                foreach ($fileArray as $key=>$value){
                                	$filesName = PasEncode($fileArray[$key]['fileName'], $BakPassWord);
                                	?>
                                <tr align="center" style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                	<td><?php echo$fileArray[$key]['fileName']?></td>
                                	<td><?php echo$fileArray[$key]['fileDate']?></td>
                                    <td><?php echo$fileArray[$key]['fileSize']?></td>
                                    <td><?php echo$fileArray[$key]['fileType']?></td>
                                    <td>
                                    	<table border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                    <td class="nones" width="14" height="18"><img src="/Manage/temp/images/edt.gif"/></td>
                                                    <td class="nones" width="30"><a href="javascript:void(0)" onclick="locationFile('1','<?php echo$filesName?>')">還原</a></td>
                                                    <td class="nones" width="15"><img src="/Manage/temp/images/edit.gif"/></td>
                                                    <td class="nones" width="30"><a href="javascript:void(0)" onclick="locationFile('2','<?php echo$filesName?>')">下載</a></td>
                                                    <td class="nones" width="16"><img src="/Manage/temp/images/55.gif" /></td>
                                                    <td class="nones" width="30"><a href="javascript:void(0)" onclick="locationFile('3','<?php echo$filesName?>')">刪除</a></td>
                                              </tr>
                                        </table>
									</td>
                                </tr>
                                <?php }}?>
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center"><input type="submit" class="inputs" id="bak" value="數據備份" /></td>
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
<div id="oddsPops" style="position:absolute;width:190px;display:none">
<table border="0" cellspacing="0" class="t_odds" width="100%">
	<tr class="tr_top">
    	<th>安全驗證</th>
    </tr>
    <tr class="text" style="height:35px;text-align:center">
        <td id="showPas">&nbsp;請輸入安全碼：<input class="textc" id="psCode" type="password" /></td>
    </tr>
    <tr class="texts">
        <td align="center" height="60" colspan="2">
            <input type="button" class="inputa" id="isSubmit" onclick="isUserCode(this)" value="確認" />&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" class="inputa" onclick="closesPop()" value="取消" />
      	</td>
    </tr>
</table>
</div>
</body>
</html>