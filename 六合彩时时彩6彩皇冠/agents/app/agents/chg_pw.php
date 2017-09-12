<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("./include/config.inc.php");
//print_r($_REQUEST);
//exit;
$uid=$_REQUEST['uid'];
$langx=$_REQUEST["langx"];
$active=$_REQUEST['action'];
require ("./include/traditional.$langx.inc.php");	
$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$data='web_system_data';
}else{
	$data='web_agents_data';
}
$sql = "select PassWord,EditDate from $data where Oid='$uid'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$password=$row['PassWord'];

if ($active==1){
	$passwd=strtolower($_REQUEST["passwd"]);
	$date=date("Y-m-d");
	$mysql="update $data set PassWord='$passwd',EditDate='$date' where Oid='$uid'";
	mysql_query($mysql) or die ("Error!");	
	echo "<Script language=javascript>alert('$Mem_ChangePasswordSuccess');window.open('".BROWSER_IP."','_top');</script>";
}	
?>
<html>
<head>
<title>chg_pw</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
.border {border: 1px solid #00AECD;}
.reg_tit1 {background-color: #C1DEFF;border-bottom-width: 2px;border-bottom-style: solid;border-bottom-color: #00AECD;font-family: "Arial", "新細明體";font-size: 13px;font-weight: bold;color: #4679B2;text-align: center;height: 35px;}
.ad_tit1 {background-color: #EEEEEE;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #CCCCCC;font-family: "Arial", "新細明體";color: #333333;text-align: right;border-right-width: 1px;border-right-style: solid;border-right-color: #CCCCCC;padding-right: 5px;font-size: 12px;}
.ad_tit2 {background-color: #C1DEFF;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #CCCCCC;font-family: "Arial", "新細明體";color: #333333;border-right-width: 1px;border-right-style: solid;border-right-color: #CCCCCC;font-size: 12px;text-align: center;}
.ad_even {border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #CCCCCC;font-family: "Arial", "新細明體";padding-top: 5px;padding-bottom: 1px;padding-left: 5px;color: #333333;border-right-width: 1px;border-right-style: solid;border-right-color: #CCCCCC;padding-right: 1px;font-size: 12px;}
.za_button {font-family: "Arial";font-size: 12px;padding-top: 2px;margin-top: 6px;margin-bottom: 6px;}
.za_text {font-family: "Arial";font-size: 12px;margin-bottom: 5px;}
.style1 {
	color: #FF0000;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<script language="JavaScript">
function SubChk(){
	if (document.all.passwd_old.value==''){
		document.all.passwd_old.focus();
		alert("<?=$Mem_OldPasswordPleaseKeyin?>");
		return false;
	}
	if(document.all.passwd_old.value != <?=$password?>){
	   document.all.passwd_old.focus(); alert("<?=$Mem_OldPasswordPleaseError?>"); return false;
	}
	if (document.all.passwd.value==''){
		document.all.passwd.focus();
		alert("<?=$Mem_NewPasswordPleaseKeyin?>");
		return false;
	}
	if(document.all.passwd.value.length < 6 ){
		alert('<?=$Mem_NewPassword_6_Characters?>');
		return false;
	}
	if(document.all.passwd.value.length > 12 ){
		alert('<?=$Mem_NewPassword_12_CharactersMax?>');
		return false;
	}
	var Numflag = 0;
	var Letterflag = 0;
    var pwd = document.all.passwd.value;
	for (idx = 0; idx < pwd.length; idx++) {
		//====== 密碼只可使用字母(不分大小寫)與數字
		if(!((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z') || (pwd.charAt(idx)>= '0' && pwd.charAt(idx) <= '9'))){
			alert("<?=$Mem_PasswordEnglishNumber_6_Characters_12_CharactersMax?>");
			return false;
		}
		if ((pwd.charAt(idx)>= "a" && pwd.charAt(idx) <= "z") || (pwd.charAt(idx)>= 'A' && pwd.charAt(idx) <= 'Z')){
			Letterflag++;
		}
		if ((pwd.charAt(idx)>= "0" && pwd.charAt(idx) <= "9")){
			Numflag++;
		}
	}
		var msg = "";
	if (Numflag == 0 || Letterflag == 0) { alert('<?=$Mem_PasswordEnglishNumber?>');return false;
	} else if (Letterflag >= 1 && Letterflag <= 3) {
		msg = "1";
	} else if (Letterflag >= 4 && Letterflag <= 8) {
		msg = "2";
	} else if (Letterflag >= 9 && Letterflag <= 11) {
		msg = "3";
	} else {
		return false;
	}
	if (document.all.REpasswd.value==''){
		document.all.REpasswd.focus();
		alert("<?=$Mem_CofirmpasswordPleasekeyin?>");
		return false;
	}
	if(document.all.passwd.value != document.all.REpasswd.value){
		document.all.passwd.focus(); alert("<?=$Mem_PasswordConfirmError?>"); return false;
	}
}
</script>
<table width="800" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td valign="middle">
      <table width="280"  border="0" align="center" cellpadding="0" cellspacing="2" class="border">
        <tr> 
          <td colspan="2" class="reg_tit1"><?=$Mem_Caption_date?></td>
        </tr>
        <form method=post onSubmit="return SubChk();">
          <tr> 
            <td class="ad_tit1"><?=$Mem_Old_Password?></td>
            <td width="120" class="ad_even"> 
              <input type=PASSWORD name="passwd_old" value="" size=12 maxlength=12  class="za_text"> 
            </td>
          </tr>
          <tr> 
            <td class="ad_tit1"><?=$Mem_New_Password?></td>
            <td width="120" class="ad_even"> 
              <input type=PASSWORD name="passwd" value="" size=12 maxlength=12  class="za_text"> 
            </td>
          </tr>
          <tr> 
            <td class="ad_tit1"><?=$Mem_Cofirm_Password?></td>
            <td class="ad_even"> 
              <input type=PASSWORD name="REpasswd" value="" size=12 maxlength=12 class="za_text"> 
            </td>
          </tr>
          <tr align="center"> 
            <td height="40" colspan="2" class="ad_even">◎<?=$Mem_Password_Guidelines?>：<?=$Mem_Pasread?></td>
          </tr>
          <tr> 
            <td colspan="2" class="ad_tit2">
              <input type=submit name="OK" value="<?=$Mem_Confirm?>" class="za_button"> 
              <input type="hidden" name="action" value="1"> 
              <input type="hidden" name="uid" value="<?=$uid?>"> 
              <input type="hidden" name="type" value="1"> </td>
          </tr>
        </form>
    </table> </td>
  </tr>
</table>
</body>
</html>