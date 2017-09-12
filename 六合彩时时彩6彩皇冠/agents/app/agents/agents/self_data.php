<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];

include ("../../agents/include/online.php");
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
	$web='web_agents_data';
}
$sql = "select * from $data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$name=$row['UserName'];
$password=$row['PassWord'];
$alias=$row['Alias'];
switch ($lv){
case 'M':
    $Title=$Mem_Manager;
	$shares=100;
	break;
case 'A':
    $Title=$Mem_Super;
	$shares=100-$row['A_Point'];
	break;
case 'B':
    $Title=$Mem_Corprator;
	$shares=$row['B_Point'];
	break;
case 'C':
    $Title=$Mem_World;
	$shares=80;
	break;
case 'D':
    $Title=$Mem_Agents;
    $shares=$row['D_Point'];
	break;
}
$loginfo='查看基本资料设定'.$Title.':'.$name.'';
$action=$_REQUEST['action'];
if ($action==1){
	$pasd=strtolower($_REQUEST["passwd"]);
	$mysql="update $data set PassWord='$pasd' where Oid='$uid'";
	mysql_db_query($dbname,$mysql) or die ("操作失败!");
	$loginfo='更改密码'.$Title.':'.$name.' 密码:'.$pasd.' (更改成功)';
	echo "<Script Language=javascript>alert('$Mem_ChangePasswordSuccess');window.open('".BROWSER_IP."','_top');</script>";
}else{
?>
<html>
<head> 
<title>基本資料設定</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_ag_ed {  background-color: #bdd1de; text-align: right}
.style1 {
	color: #FF0000;
	font-size: 12px; 
	font-weight: bold;
} 
-->
</style>
<script Language="JavaScript">
function SubChk(){
	if (document.all.passwd_old.value==''){
		document.all.passwd_old.focus();
		alert("<?=$Mem_OldPasswordPleaseKeyin?>");
		return false;
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
	if(document.all.passwd_old.value !='<?=$password?>'){
		document.all.passwd_old.focus(); alert("<?=$Mem_OldPasswordPleaseError?>"); return false;
	}
	if(document.all.passwd.value != document.all.REpasswd.value){
		document.all.passwd.focus(); alert("<?=$Mem_PasswordConfirmError?>"); return false;
	}

}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;
    <?=$Title?>
    -- <?=$Mem_Details?><?=$Mem_Settings?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$Mem_Account?>:<?=$name?>
    -- <?=$Mem_Name?>:<?=$alias?>
    </td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="700"  border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
              <tr align="center"> 
                <td colspan="2" bgcolor="#004080" ><font color="#FFFFFF"><?=$Mem_Basic_data?><?=$Mem_Settings?></font></td>
              </tr>             
              <form method=post action="" onSubmit="return SubChk();"> 
              <tr bgcolor=#FFFFFF>
              <td width="163" align="right"><?=$Mem_Account?>:</td>
              <td width="534" height="25"><?=$name?></td>
              </tr>
              <tr bgcolor=#FFFFFF>
              <td align="right"><?=$Mem_Credit?>:</td>
              <td height="25"><?=$row['Credit']?></td>
              </tr>

              <tr bgcolor="#FFFFFF" > 
                  <td align="right"><?=$Mem_Old_Password?>:</td>
                  <td> 
                    <input type=PASSWORD name="passwd_old" value="" size=12 maxlength=12  class="za_text">
                  </td>
                </tr>

                <tr bgcolor="#FFFFFF" > 
                  <td align="right"><?=$Mem_New_Password?>:</td>
                  <td> 
                    <input type=PASSWORD name="passwd" value="" size=12 maxlength=12  class="za_text">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" > 
                  <td align="right"><?=$Mem_Cofirm_Password?>:</td>
                  <td > 
                    <input type=PASSWORD name="REpasswd" value="" size=12 maxlength=12 class="za_text">
                  </td>
                </tr>
                
                <tr bgcolor=#FFFFFF>
                <td align="right"><?=$Rep_Percent?>:</td><td height="25" ><?=$shares?>%</td>
                </tr>
                
                <tr  bgcolor="#FFFFFF"  align="center">
                  <td height="25" colspan="2">◎<?=$Mem_Password_Guidelines?>：<?=$Mem_Pasread?></td>
                </tr>

                <tr  bgcolor="#DDDDDD"  align="center"> 

                  <td colspan="2"> 

                    <input type=submit name="OK" value="<?=$Mem_Confirm?>" class="za_button">

                    <input type=button name="cancel" value="<?=$Mem_Cancle?>" class="za_button" onClick="javascript:window.close();">
                  </td>
                </tr>
                
               <input type="hidden" name="action" value="1">
               <input type="hidden" name="uid" value="<?=$uid?>">
              </form>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_Soccer?></td>
      <td width='57'><?=$Rep_Wtype_r?></td>
      <td width='57'><?=$Rep_Wtype_ou?></td>
      <td width='57'><?=$Rep_Wtype_rb?></td>
      <td width="57"><?=$Rep_Wtype_rou?></td>
      <td width="57"><?=$Rep_Wtype_oe?></td>
      <td width="57"><?=$Rep_Wtype_mr?></td>
      <td width="57"><?=$Rep_Wtype_mm?></td>
      <td width="57"><?=$Rep_Wtype_pd?></td>
      <td width="57"><?=$Rep_Wtype_t?></td>
      <td width="57"><?=$Rep_Wtype_f?></td>
      <td width="57"><?=$Rep_Wtype_p?></td>
      <td width="57"><?=$Rep_Wtype_pr?></td>
      <td width="57"><?=$Rep_Wtype_pc?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["FT_Turn_R_A"]?></td>
	  <td><?=$row["FT_Turn_OU_A"]?></td>
	  <td><?=$row["FT_Turn_RE_A"]?></td>	
      <td><?=$row["FT_Turn_ROU_A"]?></td>
      <td><?=$row["FT_Turn_EO_A"]?></td>
      <td rowspan="4"><?=$row['FT_Turn_RM']?></td>
      <td rowspan="4"><?=$row['FT_Turn_M']?></td>
      <td rowspan="4"><?=$row['FT_Turn_PD']?></td>
      <td rowspan="4"><?=$row['FT_Turn_T']?></td>
      <td rowspan="4"><?=$row['FT_Turn_F']?></td>
      <td rowspan="4"><?=$row['FT_Turn_P']?></td>
      <td rowspan="4"><?=$row['FT_Turn_PR']?></td>
      <td rowspan="4"><?=$row['FT_Turn_P3']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["FT_Turn_R_B"]?></td>
	  <td><?=$row["FT_Turn_OU_B"]?></td>
	  <td><?=$row["FT_Turn_RE_B"]?></td>	
      <td><?=$row["FT_Turn_ROU_B"]?></td>
      <td><?=$row["FT_Turn_EO_B"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["FT_Turn_R_C"]?></td>
	  <td><?=$row["FT_Turn_OU_C"]?></td>
	  <td><?=$row["FT_Turn_RE_C"]?></td>	
      <td><?=$row["FT_Turn_ROU_C"]?></td>
      <td><?=$row["FT_Turn_EO_C"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["FT_Turn_R_D"]?></td>
	  <td><?=$row["FT_Turn_OU_D"]?></td>
	  <td><?=$row["FT_Turn_RE_D"]?></td>	
      <td><?=$row["FT_Turn_ROU_D"]?></td>
      <td><?=$row["FT_Turn_EO_D"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['FT_R_Scene']?></td>
	  <td><?=$row['FT_OU_Scene']?></td>
	  <td><?=$row['FT_RE_Scene']?></td>	
      <td><?=$row['FT_ROU_Scene']?></td>
      <td><?=$row['FT_EO_Scene']?></td>
      <td><?=$row['FT_RM_Scene']?></td>
      <td><?=$row['FT_M_Scene']?></td>
      <td><?=$row['FT_PD_Scene']?></td>
      <td><?=$row['FT_T_Scene']?></td>
      <td><?=$row['FT_F_Scene']?></td>
      <td><?=$row['FT_P_Scene']?></td>
      <td><?=$row['FT_PR_Scene']?></td>
      <td><?=$row['FT_P3_Scene']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['FT_R_Bet']?></td>
	  <td><?=$row['FT_OU_Bet']?></td>
	  <td><?=$row['FT_RE_Bet']?></td>
      <td><?=$row['FT_ROU_Bet']?></td>
      <td><?=$row['FT_EO_Bet']?></td>
	  <td><?=$row['FT_RM_Bet']?></td>
	  <td><?=$row['FT_M_Bet']?></td>
      <td><?=$row['FT_PD_Bet']?></td>
      <td><?=$row['FT_T_Bet']?></td>
      <td><?=$row['FT_F_Bet']?></td>
      <td><?=$row['FT_P_Bet']?></td>
      <td><?=$row['FT_PR_Bet']?></td>
      <td><?=$row['FT_P3_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="13" ></td> 
  </tr> 
</table>
<br>
<table width="800" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="550" align='left'>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_Bask?></td>
      <td width='57'><?=$Rep_Wtype_r?></td>
      <td width='57'><?=$Rep_Wtype_ou?></td>
      <td width='57'><?=$Rep_Wtype_rb?></td>
      <td width="57"><?=$Rep_Wtype_rou?></td>
      <td width="57"><?=$Rep_Wtype_oe?></td>
      <td width="57"><?=$Rep_Wtype_pr?></td>
      <td width="57"><?=$Rep_Wtype_pc?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["BK_Turn_R_A"]?></td>
	  <td><?=$row["BK_Turn_OU_A"]?></td>
	  <td><?=$row["BK_Turn_RE_A"]?></td>	
      <td><?=$row["BK_Turn_ROU_A"]?></td>
      <td><?=$row["BK_Turn_EO_A"]?></td>
      <td rowspan="4"><?=$row['BK_Turn_PR']?></td>
      <td rowspan="4"><?=$row['BK_Turn_P3']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["BK_Turn_R_B"]?></td>
	  <td><?=$row["BK_Turn_OU_B"]?></td>
	  <td><?=$row["BK_Turn_RE_B"]?></td>	
      <td><?=$row["BK_Turn_ROU_B"]?></td>
      <td><?=$row["BK_Turn_EO_B"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["BK_Turn_R_C"]?></td>
	  <td><?=$row["BK_Turn_OU_C"]?></td>
	  <td><?=$row["BK_Turn_RE_C"]?></td>	
      <td><?=$row["BK_Turn_ROU_C"]?></td>
      <td><?=$row["BK_Turn_EO_C"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["BK_Turn_R_D"]?></td>
	  <td><?=$row["BK_Turn_OU_D"]?></td>
	  <td><?=$row["BK_Turn_RE_D"]?></td>	
      <td><?=$row["BK_Turn_ROU_D"]?></td>
      <td><?=$row["BK_Turn_EO_D"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['BK_R_Scene']?></td>
	  <td><?=$row['BK_OU_Scene']?></td>
	  <td><?=$row['BK_RE_Scene']?></td>
      <td><?=$row['BK_ROU_Scene']?></td>
      <td><?=$row['BK_EO_Scene']?></td>
      <td><?=$row['BK_PR_Scene']?></td>
	  <td><?=$row['BK_P3_Scene']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['BK_R_Bet']?></td>
	  <td><?=$row['BK_OU_Bet']?></td>
	  <td><?=$row['BK_RE_Bet']?></td>
      <td><?=$row['BK_ROU_Bet']?></td>
      <td><?=$row['BK_EO_Bet']?></td>
      <td><?=$row['BK_PR_Bet']?></td>
      <td><?=$row['BK_P3_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="7" >&nbsp;</td>
	</tr>
</table>
</td>
<td width="250" align='right'>
<table width="150" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td><?=$Rep_Wtype_cs?><br>赛事</td>
    <td width="68"><?=$Rep_Wtype_cs?><br>赛事</td>
  </tr>
  <tr class="m_cen">
    <td align="right" class="m_ag_ed" nowrap><?=$mem_turn_rate?> <font color="#CC0000">A</font></td>
    <td rowspan="4"><?=$row['FS_Turn_FS']?></td>
  </tr>
  <tr class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">B</font></td>
  </tr>
  <tr class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">C</font></td>
  </tr>
  <tr class="m_cen">
    <td align="right"class="m_ag_ed"><font color="#CC0000">D</font></td>
  </tr>
  <tr class="m_cen">
    <td align="right"class="m_ag_ed"><?=$mem_scence?></td>
    <td><?=$row['FS_FS_Scene']?></td>
  </tr>
  <tr class="m_cen">
    <td align="right"class="m_ag_ed"><?=$mem_bet?></td>
    <td><?=$row['FS_FS_Bet']?></td>
  </tr>
  <tr class="m_cen">
    <td align="right" class="m_ag_ed">&nbsp; </td>
    <td></td>
  </tr>
</table>
</td>
</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_Base?></td>
      <td width='57'><?=$Rep_Wtype_r?></td>
      <td width='57'><?=$Rep_Wtype_ou?></td>
      <td width='57'><?=$Rep_Wtype_rb?></td>
      <td width="57"><?=$Rep_Wtype_rou?></td>
      <td width="57"><?=$Rep_Wtype_oe?></td>
      <td width="57"><?=$Rep_Wtype_mm?></td>
      <td width="57"><?=$Rep_Wtype_pd?></td>
      <td width="57"><?=$Rep_Wtype_t?></td>
      <td width="57"><?=$Rep_Wtype_p?></td>
      <td width="57"><?=$Rep_Wtype_p?></td>
      <td width="57"><?=$Rep_Wtype_pr?></td>
      <td width="57"><?=$Rep_Wtype_pc?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["BS_Turn_R_A"]?></td>
	  <td><?=$row["BS_Turn_OU_A"]?></td>
	  <td><?=$row["BS_Turn_RE_A"]?></td>	
      <td><?=$row["BS_Turn_ROU_A"]?></td>
      <td><?=$row["BS_Turn_EO_A"]?></td>
      <td rowspan="4"><?=$row['BS_Turn_M']?></td>
      <td rowspan="4"><?=$row['BS_Turn_PD']?></td>
      <td rowspan="4"><?=$row['BS_Turn_T']?></td>
      <td rowspan="4"><?=$row['BS_Turn_P']?></td>
      <td rowspan="4"><?=$row['BS_Turn_P']?></td>
      <td rowspan="4"><?=$row['BS_Turn_PR']?></td>
      <td rowspan="4"><?=$row['BS_Turn_P3']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["BS_Turn_R_B"]?></td>
	  <td><?=$row["BS_Turn_OU_B"]?></td>
	  <td><?=$row["BS_Turn_RE_B"]?></td>	
      <td><?=$row["BS_Turn_ROU_B"]?></td>
      <td><?=$row["BS_Turn_EO_B"]?></td>
    </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["BS_Turn_R_C"]?></td>
	  <td><?=$row["BS_Turn_OU_C"]?></td>
	  <td><?=$row["BS_Turn_RE_C"]?></td>	
      <td><?=$row["BS_Turn_ROU_C"]?></td>
      <td><?=$row["BS_Turn_EO_C"]?></td>
    </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["BS_Turn_R_D"]?></td>
	  <td><?=$row["BS_Turn_OU_D"]?></td>
	  <td><?=$row["BS_Turn_RE_D"]?></td>	
      <td><?=$row["BS_Turn_ROU_D"]?></td>
      <td><?=$row["BS_Turn_EO_D"]?></td>
    </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['BS_R_Scene']?></td>
	  <td><?=$row['BS_OU_Scene']?></td>
	  <td><?=$row['BS_RE_Scene']?></td>	
      <td><?=$row['BS_ROU_Scene']?></td>
      <td><?=$row['BS_EO_Scene']?></td>
	  <td><?=$row['BS_M_Scene']?></td>
	  <td><?=$row['BS_PD_Scene']?></td>
	  <td><?=$row['BS_T_Scene']?></td>
	  <td><?=$row['BS_P_Scene']?></td>
	  <td><?=$row['BS_P_Scene']?></td>
	  <td><?=$row['BS_PR_Scene']?></td>
	  <td><?=$row['BS_P3_Scene']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['BS_R_Bet']?></td>
	  <td><?=$row['BS_OU_Bet']?></td>
	  <td><?=$row['BS_RE_Bet']?></td>	
      <td><?=$row['BS_ROU_Bet']?></td>
      <td><?=$row['BS_EO_Bet']?></td>
	  <td><?=$row['BS_M_Bet']?></td>
	  <td><?=$row['BS_PD_Bet']?></td>
	  <td><?=$row['BS_T_Bet']?></td>
	  <td><?=$row['BS_P_Bet']?></td>
	  <td><?=$row['BS_P_Bet']?></td>
	  <td><?=$row['BS_PR_Bet']?></td>
	  <td><?=$row['BS_P3_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="12" >&nbsp;</td>
	</tr> 
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_Tennis?></td>
      <td width='57'><?=$Rep_Wtype_r?></td>
      <td width='57'><?=$Rep_Wtype_ou?></td>
      <td width='57'><?=$Rep_Wtype_rb?></td>
      <td width="57"><?=$Rep_Wtype_rou?></td>
      <td width="57"><?=$Rep_Wtype_oe?></td>
      <td width="57"><?=$Rep_Wtype_mm?></td>
      <td width="57"><?=$Rep_Wtype_pd?></td>
      <td width="57"><?=$Rep_Wtype_p?></td>
      <td width="57"><?=$Rep_Wtype_pr?></td>
      <td width="57"><?=$Rep_Wtype_pc?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["TN_Turn_R_A"]?></td>
	  <td><?=$row["TN_Turn_OU_A"]?></td>
	  <td><?=$row["TN_Turn_RE_A"]?></td>	
      <td><?=$row["TN_Turn_ROU_A"]?></td>	
      <td><?=$row["TN_Turn_EO_A"]?></td>	
      <td rowspan="4"><?=$row['TN_Turn_M']?></td>
      <td rowspan="4"><?=$row['TN_Turn_PD']?></td>
      <td rowspan="4"><?=$row['TN_Turn_P']?></td>
      <td rowspan="4"><?=$row['TN_Turn_PR']?></td>
      <td rowspan="4"><?=$row['TN_Turn_P3']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["TN_Turn_R_B"]?></td>
	  <td><?=$row["TN_Turn_OU_B"]?></td>
	  <td><?=$row["TN_Turn_RE_B"]?></td>	
      <td><?=$row["TN_Turn_ROU_B"]?></td>	
      <td><?=$row["TN_Turn_EO_B"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["TN_Turn_R_C"]?></td>
	  <td><?=$row["TN_Turn_OU_C"]?></td>
	  <td><?=$row["TN_Turn_RE_C"]?></td>	
      <td><?=$row["TN_Turn_ROU_C"]?></td>	
      <td><?=$row["TN_Turn_EO_C"]?></td>	
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["TN_Turn_R_D"]?></td>
	  <td><?=$row["TN_Turn_OU_D"]?></td>
	  <td><?=$row["TN_Turn_RE_D"]?></td>	
      <td><?=$row["TN_Turn_ROU_D"]?></td>	
      <td><?=$row["TN_Turn_EO_D"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['TN_R_Scene']?></td>
	  <td><?=$row['TN_OU_Scene']?></td>
	  <td><?=$row['TN_RE_Scene']?></td>
	  <td><?=$row['TN_ROU_Scene']?></td>
	  <td><?=$row['TN_EO_Scene']?></td>
	  <td><?=$row['TN_M_Scene']?></td>
	  <td><?=$row['TN_PD_Scene']?></td>
	  <td><?=$row['TN_P_Scene']?></td>
	  <td><?=$row['TN_PR_Scene']?></td>
	  <td><?=$row['TN_P3_Scene']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['TN_R_Bet']?></td>
	  <td><?=$row['TN_OU_Bet']?></td>
	  <td><?=$row['TN_RE_Bet']?></td>
	  <td><?=$row['TN_ROU_Bet']?></td>
	  <td><?=$row['TN_EO_Bet']?></td>
	  <td><?=$row['TN_M_Bet']?></td>
	  <td><?=$row['TN_PD_Bet']?></td>
	  <td><?=$row['TN_P_Bet']?></td>
	  <td><?=$row['TN_PR_Bet']?></td>
	  <td><?=$row['TN_P3_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="10" >&nbsp;</td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_Voll?></td>
      <td width='57'><?=$Rep_Wtype_r?></td>
      <td width='57'><?=$Rep_Wtype_ou?></td>
      <td width='57'><?=$Rep_Wtype_rb?></td>
      <td width="57"><?=$Rep_Wtype_rou?></td>
      <td width="57"><?=$Rep_Wtype_oe?></td>
      <td width="57"><?=$Rep_Wtype_mm?></td>
      <td width="57"><?=$Rep_Wtype_pd?></td>
      <td width="57"><?=$Rep_Wtype_p?></td>
      <td width="57"><?=$Rep_Wtype_pr?></td>
      <td width="57"><?=$Rep_Wtype_pc?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["VB_Turn_R_A"]?></td>
	  <td><?=$row["VB_Turn_OU_A"]?></td>
	  <td><?=$row["VB_Turn_RE_A"]?></td>	
      <td><?=$row["VB_Turn_ROU_A"]?></td>	
      <td><?=$row["VB_Turn_EO_A"]?></td>
      <td rowspan="4"><?=$row['VB_Turn_M']?></td>
      <td rowspan="4"><?=$row['VB_Turn_PD']?></td>
      <td rowspan="4"><?=$row['VB_Turn_P']?></td>
      <td rowspan="4"><?=$row['VB_Turn_PR']?></td>
      <td rowspan="4"><?=$row['VB_Turn_P3']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["VB_Turn_R_A"]?></td>
	  <td><?=$row["VB_Turn_OU_A"]?></td>
	  <td><?=$row["VB_Turn_RE_A"]?></td>	
      <td><?=$row["VB_Turn_ROU_A"]?></td>	
      <td><?=$row["VB_Turn_EO_A"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["VB_Turn_R_A"]?></td>
	  <td><?=$row["VB_Turn_OU_A"]?></td>
	  <td><?=$row["VB_Turn_RE_A"]?></td>	
      <td><?=$row["VB_Turn_ROU_A"]?></td>	
      <td><?=$row["VB_Turn_EO_A"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["VB_Turn_R_A"]?></td>
	  <td><?=$row["VB_Turn_OU_A"]?></td>
	  <td><?=$row["VB_Turn_RE_A"]?></td>	
      <td><?=$row["VB_Turn_ROU_A"]?></td>	
      <td><?=$row["VB_Turn_EO_A"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['VB_R_Scene']?></td>
	  <td><?=$row['VB_OU_Scene']?></td>
	  <td><?=$row['VB_RE_Scene']?></td>
	  <td><?=$row['VB_ROU_Scene']?></td>
	  <td><?=$row['VB_EO_Scene']?></td>
	  <td><?=$row['VB_M_Scene']?></td>
	  <td><?=$row['VB_PD_Scene']?></td>
	  <td><?=$row['VB_P_Scene']?></td>
	  <td><?=$row['VB_PR_Scene']?></td>
	  <td><?=$row['VB_P3_Scene']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['VB_R_Bet']?></td>
	  <td><?=$row['VB_OU_Bet']?></td>
	  <td><?=$row['VB_RE_Bet']?></td>
	  <td><?=$row['VB_ROU_Bet']?></td>
	  <td><?=$row['VB_EO_Bet']?></td>
	  <td><?=$row['VB_M_Bet']?></td>
	  <td><?=$row['VB_PD_Bet']?></td>
	  <td><?=$row['VB_P_Bet']?></td>
	  <td><?=$row['VB_PR_Bet']?></td>
	  <td><?=$row['VB_P3_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="10" >&nbsp;</td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_Other?></td>
      <td width='57'><?=$Rep_Wtype_r?></td>
      <td width='57'><?=$Rep_Wtype_ou?></td>
      <td width='57'><?=$Rep_Wtype_rb?></td>
      <td width="57"><?=$Rep_Wtype_rou?></td>
      <td width="57"><?=$Rep_Wtype_oe?></td>
      <td width="57"><?=$Rep_Wtype_mm?></td>
      <td width="57"><?=$Rep_Wtype_pd?></td>
      <td width="57"><?=$Rep_Wtype_t?></td>
      <td width="57"><?=$Rep_Wtype_f?></td>
      <td width="57"><?=$Rep_Wtype_p?></td>
      <td width="57"><?=$Rep_Wtype_pr?></td>
      <td width="57"><?=$Rep_Wtype_pc?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["OP_Turn_R_A"]?></td>
	  <td><?=$row["OP_Turn_OU_A"]?></td>
	  <td><?=$row["OP_Turn_RE_A"]?></td>	
      <td><?=$row["OP_Turn_ROU_A"]?></td>
      <td><?=$row["OP_Turn_EO_A"]?></td>
      <td rowspan="4"><?=$row['OP_Turn_M']?></td>
      <td rowspan="4"><?=$row['OP_Turn_PD']?></td>
      <td rowspan="4"><?=$row['OP_Turn_T']?></td>
      <td rowspan="4"><?=$row['OP_Turn_F']?></td>
      <td rowspan="4"><?=$row['OP_Turn_P']?></td>
      <td rowspan="4"><?=$row['OP_Turn_PR']?></td>
      <td rowspan="4"><?=$row['OP_Turn_P3']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["OP_Turn_R_B"]?></td>
	  <td><?=$row["OP_Turn_OU_B"]?></td>
	  <td><?=$row["OP_Turn_RE_B"]?></td>	
      <td><?=$row["OP_Turn_ROU_B"]?></td>
      <td><?=$row["OP_Turn_EO_B"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["OP_Turn_R_C"]?></td>
	  <td><?=$row["OP_Turn_OU_C"]?></td>
	  <td><?=$row["OP_Turn_RE_C"]?></td>	
      <td><?=$row["OP_Turn_ROU_C"]?></td>
      <td><?=$row["OP_Turn_EO_C"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["OP_Turn_R_D"]?></td>
	  <td><?=$row["OP_Turn_OU_D"]?></td>
	  <td><?=$row["OP_Turn_RE_D"]?></td>	
      <td><?=$row["OP_Turn_ROU_D"]?></td>
      <td><?=$row["OP_Turn_EO_D"]?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['OP_R_Scene']?></td>
	  <td><?=$row['OP_OU_Scene']?></td>
	  <td><?=$row['OP_RE_Scene']?></td>	
      <td><?=$row['OP_ROU_Scene']?></td>
      <td><?=$row['OP_EO_Scene']?></td>
      <td><?=$row['OP_M_Scene']?></td>
      <td><?=$row['OP_PD_Scene']?></td>
      <td><?=$row['OP_T_Scene']?></td>
      <td><?=$row['OP_F_Scene']?></td>
      <td><?=$row['OP_P_Scene']?></td>
      <td><?=$row['OP_PR_Scene']?></td>
      <td><?=$row['OP_P3_Scene']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['OP_R_Bet']?></td>
	  <td><?=$row['OP_OU_Bet']?></td>
	  <td><?=$row['OP_RE_Bet']?></td>
      <td><?=$row['OP_ROU_Bet']?></td>
      <td><?=$row['OP_EO_Bet']?></td>
	  <td><?=$row['OP_M_Bet']?></td>
      <td><?=$row['OP_PD_Bet']?></td>
      <td><?=$row['OP_T_Bet']?></td>
      <td><?=$row['OP_F_Bet']?></td>
      <td><?=$row['OP_P_Bet']?></td>
      <td><?=$row['OP_PR_Bet']?></td>
      <td><?=$row['OP_P3_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="12" >&nbsp;</td>
	</tr> 
</table>
<br>
<table border="0" cellpadding="0" cellspacing="1" class="m_tab_ed">
    <tr class="m_title_edit" >
      <td width="70"><?=$Rep_MarkSix?></td>
      <td width='57'><?=$Rel_SpecialCodeA?></td>
      <td width='57'><?=$Rel_SpecialCodeB?></td>
      <td width='57'><?=$Rel_Spy?><br><?=$Rel_Odd_Even?><?=$Rel_Over_Under?></td>
      <td width='57'><?=$Rel_Shelf?><br><?=$Rel_Odd_Even?><?=$Rel_Over_Under?></td>
      <td width='57'><?=$Rel_SpecialCode_ColorWave?></td>
      <td width="57"><?=$Rel_AreCode?></td>
      <td width="57"><?=$Rel_AreCode?><?=$Rel_Head?><br><?=$Rel_Odd_Even?></td>
      <td width="57"><?=$Rel_AreCode1_6?><br><?=$Rel_Odd_Even?><?=$Rel_Over_Under?></td>
      <td width="57"><?=$Rel_AreCode1_6?><br><?=$Rel_Shelf?><?=$Rel_Odd_Even?><?=$Rel_Over_Under?></td>
      <td width="57"><?=$Rel_AreCode1_6?><br><?=$Rel_ColorWave?></td>
      <td width="57"><?=$Rel_Played?></td>
      <td width="57"><?=$Rel_HalfWave?></td>
      <td width="57"><?=$Rel_Mantissa?></td>
      <td width="57"><?=$Rel_More?></td>
      <td width="57"><?=$Rel_EvenCode?></td>
    </tr>
	<tr class="m_cen">
      <td align="right" class="m_ag_ed">A</td>
	  <td><?=$row["SIX_Turn_SCA_A"]?></td>
	  <td><?=$row["SIX_Turn_SCB_A"]?></td>
	  <td><?=$row["SIX_Turn_SCA_AOUEO_A"]?></td>
	  <td><?=$row["SIX_Turn_SCA_BOUEO_A"]?></td>
	  <td><?=$row["SIX_Turn_SCA_RBG_A"]?></td>	
      <td><?=$row["SIX_Turn_AC_A"]?></td>
      <td><?=$row["SIX_Turn_AC_TOUEO_A"]?></td>
      <td><?=$row["SIX_Turn_AC6_AOUEO_A"]?></td>
      <td><?=$row["SIX_Turn_AC6_BOUEO_A"]?></td>
      <td><?=$row['SIX_Turn_AC6_RBG_A']?></td>
      <td><?=$row['SIX_Turn_SX_A']?></td>
      <td><?=$row['SIX_Turn_HW_A']?></td>
      <td><?=$row['SIX_Turn_MT_A']?></td>
      <td><?=$row['SIX_Turn_M_A']?></td>
      <td><?=$row['SIX_Turn_EC_A']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">B</td>
	  <td><?=$row["SIX_Turn_SCA_B"]?></td>
	  <td><?=$row["SIX_Turn_SCB_B"]?></td>
	  <td><?=$row["SIX_Turn_SCA_AOUEO_B"]?></td>
	  <td><?=$row["SIX_Turn_SCA_BOUEO_B"]?></td>
	  <td><?=$row["SIX_Turn_SCA_RBG_B"]?></td>	
      <td><?=$row["SIX_Turn_AC_B"]?></td>
      <td><?=$row["SIX_Turn_AC_TOUEO_B"]?></td>
      <td><?=$row["SIX_Turn_AC6_AOUEO_B"]?></td>
      <td><?=$row["SIX_Turn_AC6_BOUEO_B"]?></td>
      <td><?=$row['SIX_Turn_AC6_RBG_B']?></td>
      <td><?=$row['SIX_Turn_SX_B']?></td>
      <td><?=$row['SIX_Turn_HW_B']?></td>
      <td><?=$row['SIX_Turn_MT_B']?></td>
      <td><?=$row['SIX_Turn_M_B']?></td>
      <td><?=$row['SIX_Turn_EC_B']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">C</td>
	  <td><?=$row["SIX_Turn_SCA_C"]?></td>
	  <td><?=$row["SIX_Turn_SCB_C"]?></td>
	  <td><?=$row["SIX_Turn_SCA_AOUEO_C"]?></td>
	  <td><?=$row["SIX_Turn_SCA_BOUEO_C"]?></td>
	  <td><?=$row["SIX_Turn_SCA_RBG_C"]?></td>	
      <td><?=$row["SIX_Turn_AC_C"]?></td>
      <td><?=$row["SIX_Turn_AC_TOUEO_C"]?></td>
      <td><?=$row["SIX_Turn_AC6_AOUEO_C"]?></td>
      <td><?=$row["SIX_Turn_AC6_BOUEO_C"]?></td>
      <td><?=$row['SIX_Turn_AC6_RBG_C']?></td>
      <td><?=$row['SIX_Turn_SX_C']?></td>
      <td><?=$row['SIX_Turn_HW_C']?></td>
      <td><?=$row['SIX_Turn_MT_C']?></td>
      <td><?=$row['SIX_Turn_M_C']?></td>
      <td><?=$row['SIX_Turn_EC_C']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">D</td>
	  <td><?=$row["SIX_Turn_SCA_D"]?></td>
	  <td><?=$row["SIX_Turn_SCB_D"]?></td>
	  <td><?=$row["SIX_Turn_SCA_AOUEO_D"]?></td>
	  <td><?=$row["SIX_Turn_SCA_BOUEO_D"]?></td>
	  <td><?=$row["SIX_Turn_SCA_RBG_D"]?></td>	
      <td><?=$row["SIX_Turn_AC_D"]?></td>
      <td><?=$row["SIX_Turn_AC_TOUEO_D"]?></td>
      <td><?=$row["SIX_Turn_AC6_AOUEO_D"]?></td>
      <td><?=$row["SIX_Turn_AC6_BOUEO_D"]?></td>
      <td><?=$row['SIX_Turn_AC6_RBG_D']?></td>
      <td><?=$row['SIX_Turn_SX_D']?></td>
      <td><?=$row['SIX_Turn_HW_D']?></td>
      <td><?=$row['SIX_Turn_MT_D']?></td>
      <td><?=$row['SIX_Turn_M_D']?></td>
      <td><?=$row['SIX_Turn_EC_D']?></td>
	</tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_scence?></td>
	  <td><?=$row['SIX_SCA_Scene']?></td>
	  <td><?=$row['SIX_SCB_Scene']?></td>
	  <td><?=$row['SIX_SCA_AOUEO_Scene']?></td>
	  <td><?=$row['SIX_SCA_BOUEO_Scene']?></td>
	  <td><?=$row['SIX_SCA_RBG_Scene']?></td>	
      <td><?=$row['SIX_AC_Scene']?></td>
      <td><?=$row['SIX_AC_TOUEO_Scene']?></td>
      <td><?=$row['SIX_AC6_AOUEO_Scene']?></td>
      <td><?=$row['SIX_AC6_BOUEO_Scene']?></td>
      <td><?=$row['SIX_AC6_RBG_Scene']?></td>
      <td><?=$row['SIX_SX_Scene']?></td>
      <td><?=$row['SIX_HW_Scene']?></td>
      <td><?=$row['SIX_MT_Scene']?></td>
      <td><?=$row['SIX_M_Scene']?></td>
      <td><?=$row['SIX_EC_Scene']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed"><?=$mem_bet?></td>
	  <td><?=$row['SIX_SCA_Bet']?></td>
	  <td><?=$row['SIX_SCB_Bet']?></td>
	  <td><?=$row['SIX_SCA_AOUEO_Bet']?></td>
	  <td><?=$row['SIX_SCA_BOUEO_Bet']?></td>
	  <td><?=$row['SIX_SCA_RBG_Bet']?></td>
      <td><?=$row['SIX_AC_Bet']?></td>
      <td><?=$row['SIX_AC_TOUEO_Bet']?></td>
      <td><?=$row['SIX_AC6_AOUEO_Bet']?></td>
      <td><?=$row['SIX_AC6_BOUEO_Bet']?></td>
	  <td><?=$row['SIX_AC6_BOUEO_Bet']?></td>
      <td><?=$row['SIX_SX_Bet']?></td>
      <td><?=$row['SIX_HW_Bet']?></td>
      <td><?=$row['SIX_MT_Bet']?></td>
      <td><?=$row['SIX_M_Bet']?></td>
      <td><?=$row['SIX_EC_Bet']?></td>
  </tr>
	<tr class="m_cen" >
      <td align="right" class="m_ag_ed">&nbsp;</td>
	  <td colspan="15" >&nbsp;</td>
	</tr> 
</table>
</body>
</html>
<?
}
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$name',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>