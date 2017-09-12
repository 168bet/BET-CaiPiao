<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
?>
<html>
<head>
<title>History</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
<style>
<!--
#MFT #box { width:480px;}
#MFT .news { white-space: normal!important; color:#300; text-align:left; padding:2px 4px;}
.STYLE1 {color: #FF0000}
-->
</style>
<script language="JAVAScript">
<!--
//去掉空格
function check_null(string) { 
var i=string.length;
var j = 0; 
var k = 0; 
var flag = true;
while (k<i){ 
if (string.charAt(k)!= " ") 
j = j+1; 
k = k+1; 
} 
if (j==0){ 
flag = false;
} 
return flag; 
}
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("僅能輸入數字!!"); return false;}
}
if (document.main.Address.value =="")
		  {
			alert("请输入提款密码！")
			document.main.Address.focus();
			return false;
		  }
if (document.main.Bank_Address.value == "") {
			alert("请输入开户银行地址！")
			document.main.Bank_Address.focus();
			return false;
}
if (document.main.Bank_Account.value == "") {
			alert("请输入银行账号！")
			document.main.Bank_Account.focus();
			return false;
}
if (document.main.Notes.value == "") {
			alert("请输入银行账户名称！")
			document.main.Notes.focus();
			return false;
}
if (document.main.Money.value == "") {
			alert("请输入提款金额！")
			document.main.Money.focus();
			return false;
}
if (document.main.Money.value !="") {
		  if(document.main.Money.value ><?=$row['Money']?> )
		  {
			alert("提款金额不能大于账号金额:<?=$row['Money']?>！")
			document.main.Money.focus();
			return false;
		  }
}
if (document.main.Money.value !="") {
		  if(document.main.Money.value <500 )
		  {
			alert("提款金额不能小于500元！")
			document.main.Money.focus();
			return false;
		  }
}
}
-->
</script>
</HEAD>
<BODY id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<form method="post" name="main" action="take.php?uid=<?=$uid?>&langx=<?=$langx?>" onSubmit="return VerifyData()">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td class="top">
  	  <h1><em>在线提款</em></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
      <table border="0" cellspacing="1" cellpadding="0" class="game">
		<tr class="b_rig">
		  <td width="15%" height="30"><div align="right">阁下姓名：</div></td>
		  <td width="87%"><div align="left"><?=$row['Alias']?></div></td>
		</tr>
		<tr class="b_rig">
		  <td width="15%" height="30"><div align="right">会员帐号：</div></td>
		  <td width="87%"><div align="left"><?=$row['UserName']?></div></td>
		</tr>
		<tr class="b_rig">
		  <td height="30"><div align="right">目前额度：</div></td>
		  <td width="87%"><div align="left"><?=$row['Money']?></div></td>
		</tr>
        <tr class="b_rig" style="display:none">
		  <td align="right" height="30"><div align="right">联系电话：</div></td>
		  <td width="87%"><div align="left"><input id="Phone" name="Phone" value="" size="25" maxLength="15" onKeyPress="return CheckKey()">
		  *</div></td>
		</tr>
		<tr class="b_rig">
		  <td width="15%" height="30"><div align="right">提款密码：</div></td>
		  <td width="87%"><div align="left"><input id="Address" name="Contact" value="" size="25" maxLength="20"> *<span class="style1">请填写正确否则无法提款！</span></div></td>
		</tr>
        <tr class="b_rig">
		  <td height="30"><div align="right">开户银行：</div></td>
		  <td width="87%"><div align="left"><input id="Bank_Address"  name="Bank_Address" size="25" maxLength="20"> * <span class="style1">注:开户银行地址！</span></div></td>
		</tr>
        <tr class="b_rig">
		  <td height="30"><div align="right">银行账号：</div></td>
		  <td width="87%"><div align="left"><input id="Bank_Account" name="Bank_Account" size="25" maxLength="20" onKeyPress="return CheckKey()"> *</div></td>
		</tr>
		<tr class="b_rig">
		  <td height="30"><div align="right">账户姓名：</div></td>
		  <td width="87%"><div align="left"><input id="Notes" name="Notes" size="20" maxLength="10">
*</div></td>
		</tr>
		<tr class="b_rig">
		  <td height="30"><div align="right">提款金额：</div></td>
		  <td width="87%"><div align="left"><input id="Money" name="Money" value="" size="20" maxLength="10" onKeyPress="return CheckKey()"> * <span class="style1">注:最低值500元 单位:元</span></div></td>
		</tr>
        
        
		<tr class="b_rig">
		  <td height="30"><div align="right">选择银行：</div></td>
		  <td width="87%"><div align="left">
		     <table width="100%" border="0" cellpadding="0" cellspacing="0" style="left:0;">
               <tr class="b_rig">
                 <td><input name="Bank" type="radio" value="工商银行" checked>工商银行</td>
                 <td><input name="Bank" type="radio" value="建设银行">建设银行</td>
                 <td><input name="Bank" type="radio" value="农业银行">农业银行</td>
                 <td><input name="Bank" type="radio" value="招商银行">招商银行</td>
               </tr>
               <tr class="b_rig"> 
                 <td><input name="Bank" type="radio" value="交通银行">交通银行</td>
                 <td><input name="Bank" type="radio" value="民生银行">民生银行</td>
                 <td><input name="Bank" type="radio" value="兴业银行">兴业银行</td>
                 <td><input name="Bank" type="radio" value="中国银行">中国银行</td>
               </tr>
		     </table>
          </div>
		  </td>
		</tr>
		<tr class="b_rig">
		  <td height="30" colspan="2" align="center"><span class="STYLE1">注意：提款成功后请联系客服查收您的订单信息。</span></td>
		  </tr>
		<tr class="b_rig">
		  <td colSpan="2" height="30"><div align="center"> 
          <input type="hidden" name="Key" id="Key" value="Y" />
		  <input class="input" type="submit" value="立即提款" name="submit">
		  <input class="input" type="reset" value="重新填写" name="submit2"></div></td>
		</tr>
      </table>
    </td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
</form>
</BODY>
</HTML>
