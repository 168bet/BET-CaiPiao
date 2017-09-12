<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
if ($user[0]['g_look'] == 2) exit(back($UserOut));
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$aPwd = sha1($_POST['VIP_PWD_old']);
	$bPwd = sha1($_POST['VIP_PWD']);
	$cPwd = $_POST['VIP_PWD1'];
	$db = new DB();
	$sql = "SELECT `g_name` FROM `g_user` WHERE `g_password` = '{$aPwd}' LIMIT 1 ";
	if (!$db->query($sql, 0)) exit(alert_href("此帳號不存在!!!", "uppwd.php"));
	$sql = "UPDATE `g_user` SET `g_password` = '{$bPwd}' WHERE `g_name` = '{$user[0]['g_name']}' ";
	if ($db->query($sql, 2))
	{
		alert_href("密碼更變成功，請從新登陸!!!", "quit.php");
		exit;
	}
}

if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=change_password class=dataArea>
<table width="100%">
<tr><td width="60%">
<form action="" method="post" onSubmit="return SubChk()">
<table border="0" cellpadding="0" cellspacing="1" class="t1" width="650">
        <tr>
            <th colspan="3">在線充值</th>
        </tr>
		<tr style="height:28px">
            <td style="text-align:center" class="inner_text" width="87">支付方式</td>
            <td colspan="2" class="t_td_caption_1" style="text-align:center">收款账号</td>
        </tr>
		<!--
        <tr style="height:28px">
            <td style="text-align:center" class="inner_text" width="87">網上銀行</td>
            <td colspan="2" class="t_td_text">
			<table width="100%">
			<tr align="center">
			<td width="190"><img src="images/gongshang.gif" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			
			<tr align="center">
			<td width="190"><img src="images/BOC-NET.png" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			
			<tr align="center">
			<td width="190"><img src="images/jianshe.gif" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			
			<tr align="center">
			<td width="190"><img src="images/POST-NET.png" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			
			<tr align="center">
			<td width="190"><img src="images/ABC-NET.png" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			
			<tr align="center">
			<td width="190"><img src="images/CIB-NET.png" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			</table>			</td>
        </tr>
        <tr style="height:28px">
            <td style="text-align:center" class="inner_text" width="87">支付寶</td>
            <td colspan="2" class="t_td_text">
			<table width="100%">
			<tr align="center">
			<td width="190"><img src="images/zhifubao.jpg" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			</table>			</td>
        </tr>
        <tr style="height:28px">
            <td  style="text-align:center" class="inner_text" width="87">財付通</td>
            <td colspan="2" class="t_td_text">
			<table width="100%">
			<tr align="center">
			<td width="190"><img src="images/caifutong.JPG" width="154" height="33" /></td>
			<td width="244">账号：12345678901111111111</td>
			<td width="79">姓名：张三</td>
			</tr>
			</table>			</td>
        </tr>
		
		 <tr style="height:28px">
            <td  style="text-align:center" class="inner_text" width="87">说明</td>
            <td colspan="2" class="t_td_text">
			充值时，请在”备注“或者"留言"处填上自己的用户名，以便核对数据，不填或填错者，充值延迟处理。<br />
			付款后，请联系客服QQ：123456，处理充值业务。			</td>
        </tr>
		-->
		
		 <tr style="height:28px">
            <td  style="text-align:center" class="inner_text" width="87">財付通</td>
            <td colspan="2" class="t_td_text">
			<table width="100%">
			<tr align="center">
			<td width="190"><img src="images/caifutong.JPG" width="154" height="33" /></td>
			<td width="244">账号：1272913866</td>
			<td width="79">姓名：陈万秀</td>
			</tr>
			</table>
			</td>
        </tr>
		<tr style="height:28px">
            <td  style="text-align:center" class="inner_text" width="87">说明</td>
            <td colspan="2" class="t_td_text">
			充值时，请在”备注“或者"留言"处填上自己的用户名，以便自动到账，不填或填错者，充值延迟处理。<br />
			付款后，不到账的，请联系客服QQ：494169634，处理充值业务。			</td>
        </tr>
		<tr style="height:28px">
            <td  style="text-align:center" class="inner_text" width="87">充值演示</td>
            <td colspan="2" class="t_td_text" align="center">
			<img src="images/yans.jpg" height="370" /></td>
        </tr>
</table>
</form>
</td>
<td width="40%" valign="top" align="left">
<table border="0" cellpadding="0" cellspacing="1" class="t1"  width="362">
 <tr c>
            <th colspan="4">最近10条充值明细</th>
        </tr>
		<tr>
			    <td class="inner_text" align="center">充值账户</td>
			    <td class="inner_text" align="center">充值金额</td>  
				<td class="inner_text" align="center">充值日期</td>
				<td class="inner_text" align="center" >状态</td>
        </tr>
		<?php
		$sql = "SELECT * FROM `g_qdetail` WHERE `g_name` = '{$name}' and g_type<>1  ORDER BY g_id DESC LIMIT 10";
		if($resultqdt=$db->query($sql, 1)){
		for($i=0;$i<count($resultqdt);$i++){
		?>
		<tr>
			    <td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_name'];?></td>
			    <td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_money'];?></td>  
				<td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_date'];?></td>
				<td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_state'];?></td>
        </tr>
		<?php
		}
		}
		 ?>
</table>
</tr></table>
</DIV>
</DIV>
</DIV>
<?php
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src=".js/sc.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="./js/Pwd_Safety.js"></script>
<title></title>
<script type="text/javascript">
function SubChk(){
    if(document.all.VIP_PWD_old.value.length == ""){
	    alert("請輸入原密碼！");
	    document.all.VIP_PWD_old.focus();
	    return false;
    }
    if(document.all.VIP_PWD.value.length < 8 || document.all.VIP_PWD.value.length > 20){
	    alert("新密碼 請填寫 8 位或以上（最長20位）！");
	    document.all.VIP_PWD.focus();
	    return false;
    }
    if(document.all.VIP_PWD.value != document.all.VIP_PWD1.value){
	    alert("新密碼 和 新密碼確認 不一樣！(確認大小寫是否相同)");
	    document.all.VIP_PWD.focus();
	    return false;
    }
    if(document.all.VIP_PWD.value == document.all.VIP_PWD_old.value){
	    alert("新密碼 不能使用 原密碼 請脩改");
	    document.all.VIP_PWD.focus();
	    return false;
    }
    if(Pwd_Safety(document.all.VIP_PWD.value)!=true) return false;
}
</script>
</head>
<body>

</body>
</html>
<?php }?>