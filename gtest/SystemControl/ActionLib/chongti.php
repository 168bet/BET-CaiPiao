<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
global $Users, $ConfigModel;

if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_6'])){
	if ($Users[0]['g_lock_1_6'] !=1) 
		exit(back('您的權限不足！'));
}

$db=new DB();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
$texta=$_POST['texta'];
$xe=$_POST['xe'];
$xc=$_POST['xc'];
$qs=$_POST['qs'];
$qe=$_POST['qe'];

$sql="update g_qc set g_text='{$texta}',g_limit={$xe},g_count={$xc},g_start={$qs},g_end={$qe}";
$db->query($sql, 2);
} 


$sql = "SELECT * FROM `g_qc` ";
$result=$db->query($sql, 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<title></title>
</head>
<script>
function zhifu(param,name,cao){
$.ajax({
			type : "POST",
			data : {gid:param,name:name,cao:cao},
			url : "zhifuajax.php",
			error : function(XMLHttpRequest, textStatus, errorThrown){
				if (XMLHttpRequest.readyState == 4){
					if (XMLHttpRequest.status == 500){
						zhifu(param,name,cao);
						return false;
					}
				}
			},
			success:function(data){
				if(data==1){
				alert("操作完成!");
				window.location.reload();
				}else{
				alert("取款已拒绝!");
				window.location.reload();
				}
			}
		});
}

</script>
<body>
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
                        <td background="/SystemControl/ActionLib/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/SystemControl/ActionLib/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;充提設置</td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
						<form action="" method="post" onsubmit=""> 
                            <table border="0" cellspacing="0" class="conter">
                                <tr align="center" style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
								<td width="9%" rowspan="4" align="right" class="bj">取款说明：</td>
                                <td width="33%" rowspan="4" align="left" height="100%"><textarea style="height:100px; width:100%" name="texta" id="texta"><?php echo $result[0]['g_text']?></textarea></td>
                                  
                                <td width="19%" align="right"  class="bj">每次取款限额：</td>
                                <td width="39%" align="left">&nbsp;<input type="text" value="<?php echo $result[0]['g_limit']?>" name="xe" id="xe"/> 
                                  元 </td>
                                </tr>
                                <tr align="center" style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                  <td align="right" class="bj">每天取款次数：</td>
                                  <td width="39%" align="left">&nbsp;<input type="text" value="<?php echo $result[0]['g_count']?>" name="xc" id="xc"/>
                                    次</td>
                                </tr>
                                <tr align="center" style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                  <td align="right" class="bj">取款时间：</td>
                                  <td width="39%" align="left">&nbsp;<input type="text" size="8" value="<?php echo $result[0]['g_start']?>" name="qs" id="qs"/>
                                    点--
                                      <input type="text" size="8" value="<?php echo $result[0]['g_end']?>" name="qe" id="qe"/>
                                      点</td>
                                </tr>
                                <tr align="center" style="height:28px" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                  <td align="right" class="bj">&nbsp;</td>
                                  <td width="39%" align="left"><input type="submit"  value="提   交"/></td>
                                </tr>
                            </table>
							</form>
                        <!-- end -->
						
						  <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<td colspan="7">充提记录</th>
									<td><a href="tongjic.php" target="_blank"><font color="#FF0000">充值统计</font></a></td>
									<td><a href="tongjiq.php" target="_blank"><font color="#FF0000">取款统计</font></a></td>
                                </tr>
								<tr class="tr_top">
                                	<td >会员账号</td>
									<td >操作金额</td>
									<td >操作时间</td>
									<td >银行</td>
									<td >银行账号</td>
									<td >账号姓名</td>
									<td >状态</td>
									<td >类型</td>
									<td >操作</td>
                                </tr>
								<?php 
								
								$sql = "SELECT * FROM `g_qdetail`  order by g_id desc";
								$total=$db->query($sql, 3);
								
								$pageNum = 20;
								$page = new Page($total, $pageNum);
 								$sql = "SELECT q.g_id,q.g_name,q.g_money,q.g_date,q.g_type,q.g_state,z.g_yinhang,z.g_zhanghao,z.g_xingming FROM `g_qdetail` q left join g_ziliao z on q.g_name=z.g_name  order by q.g_id desc {$page->limit}";
								if($resultqd=$db->query($sql, 1)){
								for($i=0;$i<count($resultqd);$i++){
								$caozuo="<a href='javascript:viod(0);' onclick=\"zhifu({$resultqd[$i]['g_id']},'{$resultqd[$i]['g_name']}',1)\" />支付取款</a>&nbsp;|&nbsp;<a href='javascript:viod(0);' onclick=\"zhifu({$resultqd[$i]['g_id']},'{$resultqd[$i]['g_name']}',0)\" />拒绝</a>";
								?>
								<tr>
								 <td class="left_p6" align="center"><?php echo$resultqd[$i]['g_name']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_money']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_date']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_yinhang']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_zhanghao']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_xingming']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_state']?></td>
								<td class="left_p6" align="center"><?php echo$resultqd[$i]['g_type']==1? '账户取款':'充值'?></td>
								<td class="left_p6" align="center"><?php 
								
								if($resultqd[$i]['g_state']=='处理中')
								
								echo $caozuo;
								else if($resultqd[$i]['g_state']=='等待充值中')
								echo  '等待用户充值';
								else
								echo '操作已完成';
								
								
								
								
								?></td>
								</tr>
								<?php 
								
								}
								}
								?>
						</table>
						
                        </td>
                        <td class="r"></td>
                    </tr>
					<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="right"><?php echo $page->fpage(array(0,1, 3,4,5,6,7))?></td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"></td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"></td>
        </tr>
    </table>
</body>
</html>