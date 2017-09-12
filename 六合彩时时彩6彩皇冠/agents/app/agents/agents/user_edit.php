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
$parents_id=$_REQUEST["parents_id"];
$parents_name=$_REQUEST["parents_name"];
$name=$_REQUEST["name"];
$keys=$_REQUEST['keys'];
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
$sql = "select * from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$username=$row['UserName'];
$passw=$row['Level'];
$sql = "select * from web_agents_data where ID='$parents_id' and UserName='$name' ";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
$row = mysql_fetch_array($result);

$admin=$row['Admin'];
$super=$row['Super'];
$corprator=$row['Corprator'];
$world=$row['World'];
$alias=$row['Alias'];
$credit=$row['Credit'];
$points=$row['Points'];
$curtype=$row['CurType'];
$password=$row['PassWord'];
$wager=$row['Wager'];
$usedate=$row['UseDate'];
if ($wager==0){
	$selected="selected='selected'";
}else{
	$selected="";
}
switch ($lv){
case 'A':
    $Title=$Mem_Super;
    $level='M';
	$webdata='web_system_data';
	$data='web_agents_data';
	$user="Level='B' and Super='$name'";
	$agents="(UserName='$username' or Admin='$admin' ro Super='$username' or Corprator='$username' or World='$username') and";
	$ag="UserName='$admin'";
	$wo="Admin='$admin' and UserName!='$name'";
	break;
case 'B':
    $Title=$Mem_Corprator;
    $level='A';
	$webdata='web_agents_data';
	$data='web_agents_data';
	$user="Level='C' and Corprator='$name'";
	$agents="(UserName='$username' or Super='$username' or Corprator='$username' or World='$username') and";
	$ag="UserName='$super'";
	$wo="Super='$super' and UserName!='$name'";
	break;
case 'C':
    $Title=$Mem_World;
    $level='B';
	$webdata='web_agents_data';
	$data='web_agents_data';
	$user="Level='D' and World='$name'";
	$agents="(UserName='$username' or Super='$username' or Corprator='$username' or World='$username') and";
	$ag="UserName='$corprator'";
	$wo="Corprator='$corprator' and UserName!='$name'";
	break;
case 'D':
    $Title=$Mem_Agents;
    $level='C';
	$webdata='web_agents_data';
	$data='web_member_data';
	$user="Agents='$name'";
	$agents="(UserName='$username' or Super='$username' or Corprator='$username' or World='$username') and";
	$ag="UserName='$world'";
	$wo="World='$world' and UserName!='$name'";
	break;
case 'MEM':
    $Title=$Mem_Member;
    $level='D';
	$webdata='web_agents_data';
    $data='web_member_data';
	$user="UserName='$name' and Level='D'";
	$ag="UserName='$name'";
	$wo="UserName='$name' and UserName!='$name'";
	break;	
}
$loginfo='修改'.$Title.':'.$name.'';
$wsql = "select * from web_agents_data where UserName='$corprator'";
$result = mysql_db_query($dbname,$wsql);
$wrow = mysql_fetch_array($result);
$Point=$wrow['B_Point'];

if ($keys=='edit'){
	$id=$_REQUEST["id"];
	$gold=$_REQUEST["maxcredit"];
	$pasd=$_REQUEST["password"];
	$alias=$_REQUEST["alias"];
	$wager=$_REQUEST["real"];
	$sports=$_REQUEST['sports'];//体育点
	$lottery=$_REQUEST['lottery'];//彩票点
	$maxpoints=$_REQUEST['maxpoints'];//储蓄点数
	$usedate=$_REQUEST['usedate'];
	$Winloss_C=$_REQUEST['winloss_c'];
	$Winloss_D=$_REQUEST['winloss_d'];
	$Winloss_B=$Point-$Winloss_C-$Winloss_D;
			
    $asql = "select Credit,Points from $webdata where $ag and Level='$level'";
	
	$aresult = mysql_db_query($dbname,$asql);
	$arow = mysql_fetch_array($aresult);	
	$acredit=$arow['Credit'];
	$apoints=$arow['Points'];

	$bsql="select sum(Credit) as Credit,sum(Points) as Points from $data where $user";
	$bresult = mysql_db_query($dbname,$bsql);
	$brow = mysql_fetch_array($bresult);
	$bcredit=$brow['Credit'];
	$bpoints=$brow['Points'];

	$csql="select sum(Credit) as Credit,sum(Points) as Points from web_agents_data where $wo and Level='$lv'";
	$cresult = mysql_db_query($dbname,$csql);
	$crow = mysql_fetch_array($cresult);
	$ccredit=$crow['Credit'];
	$cpoints=$crow['Points'];

	$money1=$acredit-$gold-$ccredit;
	$money=$gold-$bcredit;

	if ($ccredit+$gold>$acredit){
		echo wterror("此代理商的信用额度为".number_format($gold,0)."<br>目前总代理商 最大信用额度为".number_format($acredit,0)."<br>,所属代理商累计信用额度为".number_format($bcredit,0)."<br>已超过代理商信用额度".number_format($money1,0)."<br>请回上一面重新输入");
		exit();
	}else if ($gold<$bcredit){
		echo wterror("此代理商的信用额度为".number_format($gold,0)."<br>目前总代理商 最大信用额度为".number_format($acredit,0)."<br>,所属代理商累计信用额度为".number_format($bcredit,0)."<br>已少过代理商信用额度".number_format($money,0)."<br>请回上一面重新输入");
		exit();
	}else{
	
	if (date('w')==1 and date('h')<5 and date('h')>0){
		$mysql="update web_agents_data set Credit='$gold',PassWord='$pasd',Alias='$alias',Wager='$wager',UseDate='$usedate',B_Point='$Winloss_B',C_Point='$Winloss_C',D_Point='$Winloss_D' where ID='$id'";
		mysql_db_query($dbname,$mysql) or die ("操作失败!");
		$loginfo='修改'.$Title.':'.$name.' 密码:'.$pasd.' 名称:'.$alias.' 信用额度:'.$gold.' 股东成数:'.$Winloss_B.' 总代理成数:'.$Winloss_C.' 代理商成数:'.$Winloss_D.' (修改成功)';
	}else{	
		$mysql="update web_agents_data set Credit='$gold',PassWord='$pasd',Alias='$alias',Wager='$wager',UseDate='$usedate' where ID='$id'";
		mysql_db_query($dbname,$mysql) or die ("操作失败!");	
		
	}
		echo "<Script Language=javascript>self.location='user_browse.php?uid=$uid&lv=$lv&langx=$langx';</script>";
	}
    }else{
	$ssql="select sum(credit) as credit,sum(points) as points from $data where $user and Status=0";
	$sresult = mysql_db_query($dbname,$ssql);
	$srow = mysql_fetch_array($sresult);
	
	$esql="select sum(credit) as credit,sum(points) as points from $data where $user and (Status=1 or Status=2)";
	$eresult = mysql_db_query($dbname,$esql);
	$erow = mysql_fetch_array($eresult);
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8 ">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_co_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<link rel="stylesheet" href="/tpl/style/agents/autocomplete.css" type="text/css">
<script src="/js/lib/prototype.js" type="text/javascript"></script>
<script src="/js/lib/scriptaculous.js" type="text/javascript"></script>
<SCRIPT>
<!--
function SubChk(){
	var Numflag = 0;
	var Letterflag = 0;
    var pwd = document.all.password.value;
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
	if(document.all.password.value.length < 6 ){alert('<?=$Mem_NewPassword_6_Characters?>');return false;}
	if(document.all.password.value.length > 12 ){alert('<?=$Mem_NewPassword_12_CharactersMax?>');return false;}
	if(document.all.password.value != document.all.passwd.value)
	{ document.all.password.focus(); alert("<?=$Mem_PasswordConfirmError?>"); return false; }
	if(document.all.alias.value=='')
	{ document.all.alias.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Mame?> !!"); return false; }
	if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
	{ document.all.maxcredit.focus(); alert("<?=$Mem_Input?> :<?=$Mem_Credit_Amount?> !!"); return false; }

<?
if (date('w')==1 and date('h')<5 and date('h')>0){
?>
    var winloss_c,winloss_d;
    winloss_c=eval(document.all.winloss_c.value);
    winloss_d=eval(document.all.winloss_d.value);
    if ((winloss_c+winloss_d)>80){ alert("<?=$mem_alert14?>");
       document.all.winloss_c.focus(); return false; }
    if ((winloss_c+winloss_d)<50){ alert("<?=$mem_alert14?>");
       document.all.winloss_d.focus(); return false; }
<?
}
?>
	document.all.OK.disabled = true;
	document.all.FormsButton2.disabled = true;
	//document.myFORM.submit();
	if(!confirm("<?=$Mem_Whether_Edit?> <?=$Title?> ?"))
	{
		document.all.OK.disabled = false;
		document.all.FormsButton2.disabled = false;
		return false;
	}
}

function CheckKey(){
	if(event.keyCode < 48 || event.keyCode > 57){alert("<?=$Mem_Enter_Numbers?>"); return false;}
}

function get_name(selectvalue)
{
	}

function parents_reload(parents_id)
{
	}
function sync2username(text,li) {
	document.myFORM.parents_id.value = li.id;
	parents_reload(li.id);
}
function onload() {
	}
//建議帳號用
function chg_username(newname) {
	document.myFORM.username.value=newname;
}
function selchg(s1,s2) {
    if (s1.selectedIndex==(s1.length-1)) {
        s2.selectedIndex = s2.length-1;
    }
}

//佔成制下拉霸更換時頁面更新
function winloss_type_change() {
//不做動作
}

// -->
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onload();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<FORM NAME="myFORM" ACTION="user_edit.php?uid=<?=$uid?>&lv=<?=$lv?>&parents_id=<?=$parents_id?>&name=<?=$name?>&langx=<?=$langx?> " METHOD=POST onSubmit="return SubChk()">
  <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$parents_id?>">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="edit">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <INPUT TYPE=HIDDEN NAME="winloss_no" VALUE="Y">
  <input type="hidden" name="s_low_order_gold" value="">
  <input type="hidden" name="s_low_order_gold_pc" value="">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline">&nbsp;&nbsp;<?=$Title?><?=$Mem_Manager?> <span style="display:none">-- <?=$Mem_Edit?>
        <select name="parents_name" class="za_select" onChange="parents_reload(this.options[this.selectedIndex].value)">
        <option label="" value="" selected="selected"></option>
		<?
	    $mysql = "select UserName,Alias from web_agents_data where $agents subuser=0 and Status=0 and Level='$level'";
		$aresult = mysql_db_query($dbname,$mysql);
		while ($arow = mysql_fetch_array($aresult)){
					if ($parents_name==$arow['UserName']){
						echo "<option value=".$arow['UserName']." selected>".$arow['UserName']."==".$arow['Alias']."</option>";				
						$sel_agents=$arow['UserName'];
					}else{
						echo "<option value=".$arow['UserName'].">".$arow['UserName']."==".$arow['Alias']."</option>";
					}
		}
		?>
        </select>
	    <INPUT TYPE=HIDDEN NAME='line' VALUE='ND'>
		<INPUT TYPE=HIDDEN NAME='cha' VALUE='N'>
		<INPUT TYPE=HIDDEN NAME='rent' VALUE='Y'>
		<input type="hidden" name="sp_upper" value="on">
        &nbsp;&nbsp;
        
        <b style="color:blue">佔成制: </b>
        <select name="winloss_type" onChange="winloss_type_change();" class="za_select">
          <option label="91佔成制" value="91">91佔成制</option>
	    </select>
	    </span>
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$Mem_Basic_data?><?=$Mem_Settings?></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Title?> <?=$Mem_Account?> :</td>
      <td><?=$name?><input type=hidden name="username" value="<?=$name?>" size=10 maxlength=10 class="za_text"></td>
    </tr>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Password?> :</td>
      <td><input type=PASSWORD name="password" value="<?=$password?>" size=12 maxlength=12 class="za_text">
         ◎<?=$Mem_Password_Guidelines?>：<?=$Mem_Pasread?>
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Cofirm_Password?> :</td>
      <td><input type=PASSWORD name="passwd" value="<?=$password?>" size=12 maxlength=12 class="za_text">
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Title?> <?=$Mem_Name?> :</td>
      <td><input type=TEXT name="alias" value="<?=$alias?>" size=10 maxlength=10 class="za_text">
      </td>
    </tr>
  </table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$Mem_Betting_data?><?=$Mem_Settings?></td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Credit_Amount?> :</td>
      <td>
        <input type=TEXT name="maxcredit" value="<?=$credit?>" size=10 maxlength=15 class="za_text" onKeyPress="return CheckKey();">
        <?=$Mem_Credits_Status?> / <?=$Mem_Enable?> : <?=number_format($srow['credit'],0)?>&nbsp;&nbsp;&nbsp; <?=$Mem_Disable?> : <?=number_format($erow['credit'],0)?>&nbsp;&nbsp;&nbsp; <?=$Mem_Available?> : <?=number_format($credit-$erow['credit']-$srow['credit'],0)?>	  </td>
    </tr>
    <!--tr class="m_bc_ed">
      <td class="m_co_ed"><?=$Mem_Currency_Setup?> :</td>
      <td><?=$curtype?></td>
    </tr-->	
        <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Instant_order?> :</td>
      <td>
        <select name="real" class="za_select">
        <option label="<?=$Mem_Enable?>" value="1"><?=$Mem_Enable?></option>
        <option label="<?=$Mem_Disable?>" value="0" <?=$selected?>><?=$Mem_Disable?></option>
	    </select>
      </td>
    </tr>
<?
if($lv=='B'){
?>		
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Corprator?> <?=$Mem_Percent?> :</td>
      <td><?=$row['B_Point']?>%</td>
    </tr>
<?
}else if($lv=='D'){
?>	
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_World?> <?=$Mem_Percent?> :</td>
      <td>
	  <?
		if (date('w')==1 and date('h')<5 and date('h')>0){
			echo "<select class=za_select name=winloss_c>";
			$abcde=$row['C_Point'];
			$abcd=$row['D_Point']+$row['C_Point'];
			for($i=$abcd;$i>=0;$i=$i-5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
				}else{
					echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
				}
			}
			echo "</select>";
		}else{
			echo $row['C_Point'].'%';
		}
		?>      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140"><?=$Mem_Agents?> <?=$Mem_Percent?> :</td>
      <td>
	  <?
		if (date('w')==1 and date('h')<5 and date('h')>0){
			echo "<select class=za_select name=winloss_d>";
			$abcde=$row['D_Point'];
			$abcd=$row['D_Point']+$row['C_Point'];
			for($i=$abcd;$i>=0;$i=$i-5){
				$abc=$i;
				if ($i==$abcde){
					echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
				}else{
					echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
				}
			}
			echo "</select>";
		}else{
			echo $row['D_Point'].'%';
		}
		?>      </td>
    </tr>
<?
}
?>
<?
if ($lv=='A'){
?>
    <tr class="m_bc_ed">
      <td class="m_co_ed" width="140">使用天数 :</td>
      <td><input type=TEXT name="usedate" value="<?=$usedate?>" size=10 maxlength=15 class="za_text" onKeyPress="return CheckKey();"> （0为不限制，1为一天。）</td>
    </tr>
<?
}
?>    
          <input type=hidden name="location" value="9999" size=10 maxlength=10 class="za_text">
        <tr class="m_bc_ed" align="center">
      <td colspan="2">
        <input type=SUBMIT name="OK" value="<?=$Mem_Confirm?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$Mem_Cancle?>" id="FormsButton2" onClick="window.location.replace('user_browse.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&enable=Y');" class="za_button">      </td>
    </tr>
  </table>

</form>
<iframe name="check_frame" src="" width="0" height="0" style="display:none"></iframe>
</body>
</html>
<?
}
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Logintime,ConText,Loginip,Url) values('$username',now(),'$loginfo','$ip_addr','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>