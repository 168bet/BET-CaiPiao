<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../../agents/include/address.mem.php");
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");
include ("../../agents/include/online.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
//print_r($_REQUEST);
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lever"];
require ("../../agents/include/traditional.$langx.inc.php");
$sql = "select Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$web='web_system_data';
}else{
    $web='web_agents_data';
}
$sql = "select ID,UserName,SubUser,SubName from $web  where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')<\/script>";
	exit;
}
$id=$row['ID'];
if ($row['SubUser']==0){
	$username=$row['UserName'];
}else{
	$username=$row['SubName'];
}
switch ($lv){
case 'M':
    $lever='A';
	break;
case 'A':
    $lever='B';
	break;
case 'B':
    $lever='C';
	break;
case 'C':
    $lever='D';
	break;
case 'D':
    $lever='MEM';
	break;
}
$period=pdate();
$date_s=$_REQUEST['date_start'];
$date_e=$_REQUEST['date_end'];
if ($date_s==''){
	$date_s=date('Y-m-d');
	$date_e=date('Y-m-d');
}
if (date(w,time())==0){
    $num=6;
}else{
    $num=date(w,time()-60*60*24);
}
?>
<html>
<head>
<title>reports</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }
.m_cal {  padding-top: 2px}

.show_ok {background-color: gold; color: blue}
.show_no {background-color: yellow; color: red}
.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}
.small {
	font-size: 11px;
	background-color: #7DD5D2;
	text-align: center;
}
.small_top {
	font-size: 11px;
	color: #FFFFFF;
	background-color: #669999;
	text-align: center;
}
-->
</style>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/agents/control_calendar.css">
<SCRIPT>
var langx='<?=$langx?>';
<!--
function sel_type(){
 	kind_obj = document.getElementById("report_kind");
 	form_obj = document.getElementById("myFORM");
 	var date_start = document.getElementById("date_start").value;
        var date_end = document.getElementById("date_end").value;
        var date_ba ="2010-01-25";
        if(date_end >= date_ba){
                if(date_start < date_ba ){
                        alert("日期区间不可跨7~8期");
                        return false;
                }
        }
	if(kind_obj.value == 'C')
 		form_obj.action = "report_class.php";
 	else if(kind_obj.value == 'D')
 		form_obj.action = "report_top.php?cancel=1";
	else if(kind_obj.value == 'E')
 		form_obj.action = "report_top.php?confirmed=-17";
 	else if(kind_obj.value == 'A')
 		form_obj.action = "report_top.php";
}
function onChangeOption(){
	var obj_select=document.getElementsByTagName('select');
	var reload_str='report.php?uid=<?=$uid?>&langx=<?=$langx?>&';
	for(var i=0;i<obj_select.length;i++){
		reload_str+=obj_select[i].name+'='+obj_select[i].value+'&';
	}
	var reloadStringObj=new String(reload_str);
	reload_str=reloadStringObj.substr(0,reloadStringObj.length-1);
	location.replace(reload_str);
}
function chg_date(range,num1,num2){
	//alert(num1+'-'+num2);
	if(range=='t' || range=='w' || range=='lw' || range=='r'){
		FrmData.date_start.value ='<?=date('Y-m-d')?>';
		FrmData.date_end.value =FrmData.date_start.value;
	}

	if(range!='t'){
		if(FrmData.date_start.value!=FrmData.date_end.value){
			FrmData.date_start.value ='<?=date('Y-m-d')?>';
			FrmData.date_end.value =FrmData.date_start.value;
		}
		var aStartDate = FrmData.date_start.value.split('-');
		var newStartDate = new Date(parseInt(aStartDate[0], 10),parseInt(aStartDate[1], 10) - 1,parseInt(aStartDate[2], 10) + num1);
		FrmData.date_start.value = newStartDate.getFullYear()+ '-' + padZero(newStartDate.getMonth() + 1)+ '-' + padZero(newStartDate.getDate());
		var aEndDate = FrmData.date_end.value.split('-');
		var newEndDate = new Date(parseInt(aEndDate[0], 10),parseInt(aEndDate[1], 10) - 1,parseInt(aEndDate[2], 10) + num2);
		FrmData.date_end.value = newEndDate.getFullYear()+ '-' + padZero(newEndDate.getMonth() + 1)+ '-' + padZero(newEndDate.getDate());
	}
}
function report_bg(){
	//document.getElementById(date_num).className="report_c";
}
-->
</SCRIPT>
<!--只有BB,KK,BB2要放-->
<!--顯示隱藏FLASH廣告的js-->
<SCRIPT language=javascript>
function ExpandIO(flg,DivName){
	if(!(document.all || document.getElementById)){return false;}
	if(flg == null){var flg = "close";}
	if(flg == "small"){
		document.getElementById("expandOpen").style.visibility = "hidden"; 
		document.getElementById("expandClose").style.visibility = "visible";
	}else if (flg=="open"){
		document.getElementById("expandOpen").style.right = "0px"; 
		document.getElementById("expandOpen").style.visibility = "visible"; 
		document.getElementById("expandClose").style.visibility = "hidden";
	}else{
		document.getElementById("expandOpen").style.visibility = "hidden"; 
		document.getElementById("expandClose").style.visibility = "hidden";
	}
}
<!-- 新開廣告視窗 -->
function window_open() {
win = window.open('https://rp.kc080.com/tpl/images/commercial/banner.html','','height=430, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
}
</SCRIPT>
<script language="JavaScript" src="/js/agents/simplecalendar.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<FORM id="myFORM" ACTION="report_top.php" METHOD=GET name="FrmData" onSubmit="sel_type();">
  <input type=HIDDEN name="uid" value="<?=$uid?>">
  <input type=HIDDEN name="langx" value="<?=$langx?>">
  <input type=HIDDEN name="lever" value="<?=$lever?>">
  <input type=HIDDEN name="next_id" value="<?=$id?>">
  <input type=HIDDEN name="next_name" value="<?=$username?>">  
  <input type=HIDDEN name="first" value="Y">    
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="948" class="m_tline"> 
        <table border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td>&nbsp;&nbsp;<?=$Rep_Manager?></td>
            <td>
              <select name="gtype" class="za_select" >
          		   <OPTION VALUE=""><?=$Rep_All?></OPTION>
          		   <OPTION VALUE="FT" ><?=$Rep_Soccer?></OPTION>
          		   <OPTION VALUE="BK" ><?=$Rep_Bask?></OPTION>
          		   <OPTION VALUE="TN" ><?=$Rep_Tennis?></OPTION>
				   <OPTION VALUE="VB" ><?=$Rep_Voll?></OPTION>
          		   <OPTION VALUE="BS" ><?=$Rep_Base?></OPTION>
          		   <OPTION VALUE="OP" ><?=$Rep_Other?></OPTION>
          		   <OPTION VALUE="FU" ><?=$Rep_Stock?></OPTION>
				   <OPTION VALUE="FS" ><?=$Rep_Guan?></OPTION>
          		   <OPTION VALUE="SIX" ><?=$Rep_MarkSix?></OPTION>
              </select>
            </td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="Button" class="za_button" onClick="chg_date('l',-1,-1)" value="<?=$Rep_Yestoday?>">
		<input type="Button" class="za_button" onClick="chg_date('t',0,0)" value="<?=$Rep_Today?>">
		<input type="Button" class="za_button" onClick="chg_date('n',1,1)" value="<?=$Rep_Tommrow?>">
        <input type="Button" class="za_button" onClick="chg_date('w',-<?=$num?>,6-<?=$num?>)" value="<?=$Rep_One_week?>">
		<input type="Button" class="za_button" onClick="chg_date('lw',-<?=$num?>-7,6-<?=$num?>-7)" value="<?=$Rep_Last_week?>">
		<input type="Button" class="za_button" onClick="FrmData.date_start.value='<?=$period[1]?>';FrmData.date_end.value='<?=$period[2]?>'" value="<?=$Rep_One_Period?>">
		<input type="Button" class="za_button" onClick="FrmData.date_start.value='<?=$period[3]?>';FrmData.date_end.value='<?=$period[4]?>'" value="<?=$Rep_Last_Issue?>">		
		</td>		
          </tr>
        </table>
      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>   
  </table>
<table>
  <tr>
	<td>
  <table width="500" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_bc"> 
      <td width="100" class="m_title_re"><?=$Rep_Report_Period?></td>
      <td> 
        <table border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td> 
              <input type=TEXT name="date_start" value="<?=$date_s?>" size=15 maxlength=11 class="za_text">&nbsp;
            </td>
            <td>&nbsp;&nbsp;<a href="javascript: void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;"><img src="/images/agents/top/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td width="20" align="center">&nbsp; ~ &nbsp;</td>
            <td> 
              <input type=TEXT name="date_end" value="<?=$date_e?>" size=15 maxlength=10 class="za_text">&nbsp;
            </td>
            <td>&nbsp;&nbsp;<a href="javascript: void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;"><img src="/images/agents/top/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="m_bc"> 
      <td class="m_title_re"><?=$Rep_Kind?></td>
      <td > 
        <select name="report_kind" class="za_select">
          <option value="A" SELECT><?=$Rep_Kind_a?></option>
          <option value="C" ><?=$Rep_Kind_c?></option>
          <option value="D" ><?=$Rep_Kind_d?></option>
          <option value="E" ><?=$Rep_Kind_e?></option>
        </select>
      </td>
    </tr>
    <tr class="m_bc"> 
      <td class="m_title_re"><?=$Rep_Pay_Type?></td>
      <td > 
        <select name="pay_type" class="za_select">
          <option value="" SELECTED><?=$Rep_All?></option>
          <option value="0"><?=$Rep_Credit?></option>
          <option value="1"><?=$Rep_Cash?></option>
        </select>
      </td>
    </tr>
    <tr class="m_bc"> 
      <td class="m_title_re"><?=$Rep_Wtype?></td>
      <td > 
        <select name="type" class="za_select">
          <option value="" SELECTED><?=$Rep_All?></option>
		  <option value="M"><?=$Rep_Wtype_m?></option>
		  <option value="R"><?=$Rep_Wtype_r?></option>
		  <option value="OU"><?=$Rep_Wtype_ou?></option>
		  <option value="EO"><?=$Rep_Wtype_eo?></option>
		  <option value="VM"><?=$Rep_Wtype_vm?></option>
		  <option value="VR"><?=$Rep_Wtype_vr?></option>
		  <option value="VOU"><?=$Rel_Wtype_vou?></option>		  
		  <option value="VEO"><?=$Rep_Wtype_veo?></option>
		  <option value="UR"><?=$Rep_Wtype_ur?></option>
		  <option value="UOU"><?=$Rep_Wtype_uou?></option>
		  <option value="UEO"><?=$Rep_Wtype_ueo?></option>	
		  <option value="QR"><?=$Rep_Wtype_qr?></option>
		  <option value="QOU"><?=$Rep_Wtype_qou?></option>
		  <option value="QEO"><?=$Rep_Wtype_qeo?></option>
		  <option value="RM"><?=$Rep_Wtype_rm?></option>
		  <option value="RB"><?=$Rep_Wtype_rb?></option>
		  <option value="ROU"><?=$Rep_Wtype_rou?></option>
		  <option value="VRM"><?=$Rep_Wtype_vrm?></option>
		  <option value="VRB"><?=$Rep_Wtype_vrb?></option>
		  <option value="VROU"><?=$Rep_Wtype_vrou?></option>
		  <option value="URB"><?=$Rep_Wtype_urb?></option>
		  <option value="UROU"><?=$Rep_Wtype_urou?></option>
		  <option value="PD"><?=$Rep_Wtype_pd?></option>
		  <option value="VPD"><?=$Rep_Wtype_vpd?></option>
		  <option value="T"><?=$Rep_Wtype_t?></option>
		  <option value="F"><?=$Rep_Wtype_f?></option>
		  <option value="PC"><?=$Rep_Wtype_pc?></option>
		  <option value="CS"><?=$Rep_Wtype_cs?></option>
        </select>
      </td>
    </tr>
    <tr class="m_bc"> 
      <td class="m_title_re"><?=$Rep_Bet_State?></td>
      <td>
	   <select name="result_type" class="za_select">
	    <option value=""><?=$Rel_All?></option>		
        <option value="Y"><?=$Rep_Results?></option>
        <option value="N"><?=$Rep_No_Results?></option> 
       </select>
      </td>
    </tr>
    <tr align="center" bgcolor="#FFFFFF"> 
      <td height="30" colspan="2" > &nbsp; 
        <input type=SUBMIT name="SUBMIT" value="<?=$Rep_Query?>" class="za_button">
        &nbsp;&nbsp;&nbsp; 
        <input type=BUTTON name="CANCEL" value="<?=$Rep_Cancel?>" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
<?
	$mdate_t=date('Y-m-d');
	$mdate_y=date('Y-m-d',time()-24*60*60);
	$mysql="select * from match_sports where Type='FT' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='FT' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$ft_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$ft_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$ft_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='FT' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='FT' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$ft_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$ft_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$ft_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>        
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Soccer?><?=$ft_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Soccer?><?=$ft_caption1?></div></td>
        </tr>
      </table>
    </td>
    </tr>	    
<?
	$mysql="select * from match_sports where Type='BK' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);

	$mysql="select * from match_sports where Type='BK' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$bk_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$bk_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$bk_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='BK' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='BK' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$bk_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$bk_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$bk_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>          
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
	  <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Bask?><?=$bk_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Bask?><?=$bk_caption1?></div></td>
        </tr>
      </table>
	</td>
	</tr>
<?
	$mysql="select * from match_sports where Type='BS' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='BS' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$be_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$be_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$be_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='BS' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='BS' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$be_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$be_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$be_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Base?><?=$be_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Base?><?=$be_caption1?></div></td>
        </tr>
      </table>
	</td>
    </tr>
<?
	$mysql="select * from match_sports where Type='TN' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);

	$mysql="select * from match_sports where Type='TN' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$tn_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$tn_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$tn_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='TN' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='TN' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$tn_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$tn_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$tn_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Tennis?><?=$tn_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Tennis?><?=$tn_caption1?></div></td>
        </tr>
      </table>	
	</td>
    </tr>
<?
	$mysql="select * from match_sports where Type='VB' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='VB' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$vb_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$vb_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$vb_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='VB' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='VB' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$vb_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$vb_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$vb_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Voll?><?=$vb_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Voll?><?=$vb_caption1?></div></td>
        </tr>
      </table>	
	</td>
    </tr>
<?
	$mysql="select * from match_sports where Type='OP' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='OP' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$vb_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$vb_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$vb_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='OP' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='OP' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$vb_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$vb_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$vb_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Other?><?=$vb_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Other?><?=$vb_caption1?></div></td>
        </tr>
      </table>	
	</td>
    </tr>
<?
	$mysql="select * from match_sports where Type='SK' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='SK' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$fs_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$fs_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$fs_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='SK' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='SK' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$fs_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$fs_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$fs_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Stock?><?=$fs_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Stock?><?=$fs_caption1?></div></td>
        </tr>
      </table>	
	</td>
    </tr>
<?
	$mysql="select * from match_sports where Type='FS' and M_Date='$mdate_t' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='FS' and M_Date='$mdate_t'";
	$result = mysql_db_query($dbname,$mysql);
	$cou1=mysql_num_rows($result);
	if ($cou1==0){
		$fs_caption=$Rep_readme2;//今日没有比赛
	}else if ($cou1-$cou==0){			
		$fs_caption=$Rep_readme1;//今日输入完毕
	}else{			
		$fs_caption=str_replace('{}',$cou1-$cou,$Rep_readme0);//今日尚有多少场未输入完毕
	}	
	$mysql="select * from match_sports where Type='FS' and M_Date='$mdate_y' and MB_Inball!=''";
	$result = mysql_db_query($dbname,$mysql);
	$cou2=mysql_num_rows($result);
	$mysql="select * from match_sports where Type='FS' and M_Date='$mdate_y'";
	$result = mysql_db_query($dbname,$mysql);
	$cou3=mysql_num_rows($result);
	if ($cou3==0){		
		$fs_caption1=$Rep_readme2;//昨日没有比赛
	}else if ($cou3-$cou2==0){		
		$fs_caption1=$Rep_readme1;//昨日输入完毕
	}else{	
		$fs_caption1=str_replace('{}',$cou3-$cou2,$Rep_readme0);//昨日尚有多少场未输入完毕
	}
?>
    <tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="3" >
      <table width="487" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="242"><div align="left"><font color='red'><?=date('Y-m-d')?>&nbsp;<?=$Rep_Guan?><?=$fs_caption?></font></div></td>
          <td width="242"><div align="left"><?=date('Y-m-d',time()-24*60*60)?>&nbsp;<?=$Rep_Guan?><?=$fs_caption1?></div></td>
        </tr>
      </table>	
	</td>
    </tr>   	
  </table>
	  </td>
			<td valign="top">
				<table width=246 border=0 cellpadding=0 cellspacing=1 class="m_tab_ed">
				  <tr>
				    <td height="9" colspan=2 class="small_top" align="center"><div >2010<?=$Rep_Clear_Period?></div></td>
				  </tr>
				  <tr>
				    <td width="70" height="10" class="small"><?=$Rep_Article?>1<?=$Rep_Period?></td>
				    <td width="174" class="m_cen_top"  id="2010_1">2009/12/28 ~ 2010/01/24</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>2<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_2">2010/01/25 ~ 2010/02/21</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>3<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_3">2010/02/22 ~ 2010/03/21</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>4<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_4">2010/03/22 ~ 2010/04/18</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>5<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_5">2010/04/19 ~ 2010/05/16</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>6<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_6">2010/05/17 ~ 2010/06/13</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>7<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_7">2010/06/14 ~ 2010/07/11</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>8<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_8">2010/07/12 ~ 2010/08/08</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>9<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_9">2010/08/09 ~ 2010/09/05</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>10<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_10">2010/09/06 ~ 2010/10/03</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>11<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_11">2010/10/04 ~ 2010/10/31</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>12<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2010_12">2010/11/01 ~ 2010/11/28</td>
				  </tr>
				  <tr>
				    <td height="10" class="small"><?=$Rep_Article?>13<?=$Rep_Period?></td>
				    <td class="m_cen_top" id="2011_1">2010/11/29 ~ 2010/12/26</td>
				  </tr>
				</table>
	  </td>
	</tr>
  </table>
</form>

<!--只有BB,KK,BB2要放-->
<!--FLASH廣告開的視窗-->
<!--div id='expandOpen' style='position:absolute;right: 0px; top:0px;width:100%;'>
	<span style="float:right;width:115px;">
		<TABLE cellSpacing=0 cellPadding=0 border=0  style="margin:0px;padding=0px" align="center" width="115">
		<TR><TD align="right" background="/images/agents/top/bady.gif">
	  
			<A onClick="ExpandIO('small');return false;"  href="#">
			<IMG  src="/images/agents/top/S.gif" border=0 align="top">
			</A>
			<A onClick="ExpandIO('close');return false;"  href="#">
			<IMG  src="/images/agents/top/C.gif" border=0 align="top">
			</A>	
		</TD>
		</TR>
		<TR><TD>
			<a href=# onClick="window_open();" ><img border="0" src="/images/agents/top/banner01.gif"></a>
		</TD></TR>
		</TABLE>
	</span>
</div-->
<!--FLASH廣告關的視窗-->
<!--div id='expandClose' style='position:absolute;visibility:hidden;right: 0px; top:0px;width:100%;'>
	<span style="float:right;width:115px;">
		<TABLE cellSpacing=0 cellPadding=0 border=0  style="margin:0px;padding=0px" align="center" width="115">
		<TR><TD align="right" background="/images/agents/top/bady.gif">
	  
			<A onClick="ExpandIO('open');return false;"  href="#">
			<IMG  src="/images/agents/top/B.gif" border=0 align="top">
			</A>
			<A onClick="ExpandIO('close');return false;"  href="#">
			<IMG  src="/images/agents/top/C.gif" border=0 align="top">
			</A>
		</TD>
		</TR>
		</TABLE>
	</span>
</div-->

</body>
</html>
<script>
var date_num='<?=$period[0]?>';
report_bg();
</script>
<?
$loginfo='查询期间报表';
$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(UserName,Loginip,LoginTime,ConText,Url) values('$username','$ip_addr',now(),'$loginfo','".BROWSER_IP."')";
mysql_db_query($dbname,$mysql);
?>