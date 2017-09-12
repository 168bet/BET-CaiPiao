<?php 
define('Copyright', '作者QQ:1250691127');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'SystemControl/ExistUser.php';
include_once ROOT_PATH.'SystemControl/config/config.php';
global $ConfigModel,$Users;
$db=new DB();
if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_1'])){
	if ($Users[0]['g_lock_1_1'] !=1) 
		exit(back('您的權限不足！'));
}

if ($_SERVER["REQUEST_METHOD"] == "POST")

{	

$sql="update g_send_back_default Set g_a_limit='".$_POST['g_a_limit']."',g_b_limit='".$_POST['g_b_limit']."',g_c_limit='".$_POST['g_c_limit']."',g_d_limit='".$_POST['g_d_limit']."',g_e_limit='".$_POST['g_e_limit']."'  where g_game_id=1 ";
$exe=mysql_query($sql) or  die("数据库修改出错");

$sql="update g_send_back_default Set g_a_limit='".$_POST['g_a_limitc']."',g_b_limit='".$_POST['g_b_limitc']."',g_c_limit='".$_POST['g_c_limitc']."',g_d_limit='".$_POST['g_d_limitc']."',g_e_limit='".$_POST['g_e_limitc']."'  where g_game_id=2 ";
$exe=mysql_query($sql) or  die("数据库修改出错");
 if($ConfigModel['g_gx_game_lock']==1){
$sql="update g_send_back_default Set g_a_limit='".$_POST['g_a_limitg']."',g_b_limit='".$_POST['g_b_limitg']."',g_c_limit='".$_POST['g_c_limitg']."',g_d_limit='".$_POST['g_d_limitg']."',g_e_limit='".$_POST['g_e_limitg']."'  where g_game_id=5 ";
$exe=mysql_query($sql) or  die("数据库修改出错");
}
$sql="update g_send_back_default Set g_a_limit='".$_POST['g_a_limitb']."',g_b_limit='".$_POST['g_b_limitb']."',g_c_limit='".$_POST['g_c_limitb']."',g_d_limit='".$_POST['g_d_limitb']."',g_e_limit='".$_POST['g_e_limitb']."'  where g_game_id=6 ";
$exe=mysql_query($sql) or  die("数据库修改出错");

$sql="update g_send_back_default Set g_a_limit='".$_POST['g_a_limitj']."',g_b_limit='".$_POST['g_b_limitj']."',g_c_limit='".$_POST['g_c_limitj']."',g_d_limit='".$_POST['g_d_limitj']."',g_e_limit='".$_POST['g_e_limitj']."'  where g_game_id=7 ";
$exe=mysql_query($sql) or  die("数据库修改出错");
	
 

echo "<script>alert('修改成功!');window.location.href='mrp.php';</script>"; 
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<title></title>
<script type="text/javascript">
<!--
	function isForm(){
		if (confirm("確認更變嗎？"))
				return true;
		return false;
	}
-->
</script>
</head>
<body>
<form action="" method="post" onsubmit="return isForm()">
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
             
              <tr>
                    	<td></td>
                        <td width="800" class="c">
                        <!-- strat -->
                      <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<th colspan="7">默认退水设置</th>
                                </tr>
                                <tr style="height:28px">
                                	<td colspan="6" class="bj"><div align="center"><strong>广东快乐十分</strong></div></td>
                              </tr>
                                        <tr style="height:28px">
                                	<td width="35" class="bj">交易類型</td>
                                  <td width="70" class="left_p6">A盤</td>
                                  <td width="70" class="left_p6">B盤</td>
                                  <td width="70" class="left_p6">C盤</td>
                                  <td width="73" class="left_p6">單註限額</td>
                                  <td width="371" class="left_p6">單期限額</td>
                        </tr>
                              <? $result = mysql_query("select * from  g_send_back_default where g_game_id=1 and g_id=1 ");   
$row=mysql_fetch_array($result);

					  
?>
                                       <tr style="height:28px">
                                	<td width="35" class="bj">所有</td>
                                  <td width="70" class="left_p6"><input name="g_a_limit" class="input1" id="g_a_limit" value='<?=$row['g_a_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_b_limit" class="input1" id="g_a_limit" value='<?=$row['g_b_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_c_limit" class="input1" id="g_a_limit" value='<?=$row['g_c_limit']?>' size="10" /></td>
                                  <td width="73" class="left_p6"><input name="g_d_limit" class="input1" id="g_a_limit" value='<?=$row['g_d_limit']?>' size="10" /></td>
                                  <td width="371" class="left_p6"><input name="g_e_limit" class="input1" id="g_a_limit" value='<?=$row['g_e_limit']?>' size="10" /></td>
                        </tr>
                              <tr style="height:28px">
                                	<td colspan="6" class="bj"><div align="center"><strong>重庆时时彩</strong></div></td>
                              </tr>
                                        <tr style="height:28px">
                                	<td width="35" class="bj">交易類型</td>
                                  <td width="70" class="left_p6">A盤</td>
                                  <td width="70" class="left_p6">B盤</td>
                                  <td width="70" class="left_p6">C盤</td>
                                  <td width="73" class="left_p6">單註限額</td>
                                  <td width="371" class="left_p6">單期限額</td>
                        </tr>
                              <? $result1 = mysql_query("select * from  g_send_back_default where g_game_id=2 and g_id=32 ");   
$row1=mysql_fetch_array($result1);

					  
?>
                                       <tr style="height:28px">
                                	<td width="35" class="bj">所有</td>
                                  <td width="70" class="left_p6"><input name="g_a_limitc" class="input1" id="g_a_limitc" value='<?=$row1['g_a_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_b_limitc" class="input1" id="g_a_limitc" value='<?=$row1['g_b_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_c_limitc" class="input1" id="g_a_limitc" value='<?=$row1['g_c_limit']?>' size="10" /></td>
                                  <td width="73" class="left_p6"><input name="g_d_limitc" class="input1" id="g_a_limitc" value='<?=$row1['g_d_limit']?>' size="10" /></td>
                                  <td width="371" class="left_p6"><input name="g_e_limitc" class="input1" id="g_a_limitc" value='<?=$row1['g_e_limit']?>' size="10" /></td>
                        </tr>   
                          <tr style="height:28px">
                                	<td colspan="6" class="bj"><div align="center"><strong>幸运农场</strong></div></td>
                        </tr>
                                        <tr style="height:28px">
                                	<td width="35" class="bj">交易類型</td>
                                  <td width="70" class="left_p6">A盤</td>
                                  <td width="70" class="left_p6">B盤</td>
                                  <td width="70" class="left_p6">C盤</td>
                                  <td width="73" class="left_p6">單註限額</td>
                                  <td width="371" class="left_p6">單期限額</td>
                        </tr>
                              <? $result1 = mysql_query("select * from  g_send_back_default where g_game_id=5 and g_id=79 ");   
$row1=mysql_fetch_array($result1);

					  
?>
                                       <tr style="height:28px">
                                	<td width="35" class="bj">所有</td>
                                  <td width="70" class="left_p6"><input name="g_a_limitg" class="input1" id="g_a_limitg" value='<?=$row1['g_a_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_b_limitg" class="input1" id="g_a_limitg" value='<?=$row1['g_b_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_c_limitg" class="input1" id="g_a_limitg" value='<?=$row1['g_c_limit']?>' size="10" /></td>
                                  <td width="73" class="left_p6"><input name="g_d_limitg" class="input1" id="g_a_limitg" value='<?=$row1['g_d_limit']?>' size="10" /></td>
                                  <td width="371" class="left_p6"><input name="g_e_limitg" class="input1" id="g_a_limitg" value='<?=$row1['g_e_limit']?>' size="10" /></td>
                        </tr>   
                            <tr style="height:28px">
                                	<td colspan="6" class="bj"><div align="center"><strong>北京赛车（PK10）</strong></div></td>
                        </tr>
                                        <tr style="height:28px">
                                	<td width="35" class="bj">交易類型</td>
                                  <td width="70" class="left_p6">A盤</td>
                                  <td width="70" class="left_p6">B盤</td>
                                  <td width="70" class="left_p6">C盤</td>
                                  <td width="73" class="left_p6">單註限額</td>
                                  <td width="371" class="left_p6">單期限額</td>
                        </tr>
                              <? $result2 = mysql_query("select * from  g_send_back_default where g_game_id=6 and g_id=110 ");   
$row2=mysql_fetch_array($result2);

					  
?>
                                       <tr style="height:28px">
                                	<td width="35" class="bj">所有</td>
                                  <td width="70" class="left_p6"><input name="g_a_limitb" class="input1" id="g_a_limitb" value='<?=$row2['g_a_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_b_limitb" class="input1" id="g_a_limitb" value='<?=$row2['g_b_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_c_limitb" class="input1" id="g_a_limitb" value='<?=$row2['g_c_limit']?>' size="10" /></td>
                                  <td width="73" class="left_p6"><input name="g_d_limitb" class="input1" id="g_a_limitb" value='<?=$row2['g_d_limit']?>' size="10" /></td>
                                  <td width="371" class="left_p6"><input name="g_e_limitb" class="input1" id="g_a_limitb" value='<?=$row2['g_e_limit']?>' size="10" /></td>
                        </tr>    
                          <tr style="height:28px">
                                	<td colspan="6" class="bj"><div align="center"><strong>江苏骰宝（快3）</strong></div></td>
                        </tr>
                                        <tr style="height:28px">
                                	<td width="35" class="bj">交易類型</td>
                                  <td width="70" class="left_p6">A盤</td>
                                  <td width="70" class="left_p6">B盤</td>
                                  <td width="70" class="left_p6">C盤</td>
                                  <td width="73" class="left_p6">單註限額</td>
                                  <td width="371" class="left_p6">單期限額</td>
                        </tr>
                              <? $result3 = mysql_query("select * from  g_send_back_default where g_game_id=7 and g_id=126 ");   
$row3=mysql_fetch_array($result3);

					  
?>
                                       <tr style="height:28px">
                                	<td width="35" class="bj">所有</td>
                                  <td width="70" class="left_p6"><input name="g_a_limitj" class="input1" id="g_a_limitj" value='<?=$row3['g_a_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_b_limitj" class="input1" id="g_a_limitj" value='<?=$row3['g_b_limit']?>' size="10" /></td>
                                  <td width="70" class="left_p6"><input name="g_c_limitj" class="input1" id="g_a_limitj" value='<?=$row3['g_c_limit']?>' size="10" /></td>
                                  <td width="73" class="left_p6"><input name="g_d_limitj" class="input1" id="g_a_limitj" value='<?=$row3['g_d_limit']?>' size="10" /></td>
                                  <td width="371" class="left_p6"><input name="g_e_limitj" class="input1" id="g_a_limitj" value='<?=$row3['g_e_limit']?>' size="10" /></td>
                        </tr>    
                          </table>
                        <!-- end -->
                        </td>
                <td></td>
                    </tr>
                    <tr>
                    	<td width="32">&nbsp;</td>
                      <td class="f" align="center"><input type="submit" class="inputs" value="確認更變" /></td>
                        <td width="222">&nbsp;</td>
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
</form>
</body>
</html>