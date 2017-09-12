<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$type=$_REQUEST["type"];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$sql = "select * from number_num";
$result = mysql_query($sql);
$num = mysql_fetch_array($result);
$numdate=$num['M_Date'];
if ($num['MID']<100 and $num['MID']>10){
$nummid='0'.$num['MID'];
}else if ($num['MID']<9){
$nummid='00'.$num['MID'];
}else{
$nummid=$num['MID'];
}

$id=$_REQUEST['id'];
$mid=$_REQUEST['MID'];
$m_date=$_REQUEST['M_Date'];
$num_01=$_REQUEST['Num_01'];
$num_02=$_REQUEST['Num_02'];
$num_03=$_REQUEST['Num_03'];
$num_04=$_REQUEST['Num_04'];
$num_05=$_REQUEST['Num_05'];
$num_06=$_REQUEST['Num_06'];
$num_07=$_REQUEST['Num_07'];

switch ($type){
case "NewNum":
	$mysql="insert into number_result(MID,M_Date,Num_01,Num_02,Num_03,Num_04,Num_05,Num_06,Num_07)values('$nummid','$numdate','$num_01','$num_02','$num_03','$num_04','$num_05','$num_06','$num_07')";
	mysql_query($mysql);
	break;
case "OldNum":
	$mysql="insert into number_result(MID,M_Date,Num_01,Num_02,Num_03,Num_04,Num_05,Num_06,Num_07)values('$mid','$m_date','$num_01','$num_02','$num_03','$num_04','$num_05','$num_06','$num_07')";
	mysql_query($mysql);
	break;
case "ModNum":
	$sql="update number_result set MID='$mid',M_Date='$m_date',Num_01='$num_01',Num_02='$num_02',Num_03='$num_03',Num_04='$num_04',Num_05='$num_05',Num_06='$num_06',Num_07='$num_07' where ID='$id'";
	mysql_query($sql);
	break;
	/*echo "<script languag='JavaScript'>self.location='number.php?uid=$uid&lv=$lv&langx=$langx'</script>";*/	
}
$action=$_REQUEST["action"];
if ($action=='mod'){
$sql = "select * from number_result where ID='$id'";
$result = mysql_query($sql);
$mod=mysql_fetch_array($result);
if ($mod['MID']<100 and $mod['MID']>10){
$modmid='0'.$mod['MID'];
}else if ($mod['MID']<9){
$modmid='00'.$mod['MID'];
}else{
$modmid=$mod['MID'];
}
}
if ($action=='del'){
    $sql="delete from number_result where ID='$id'";
	mysql_query($sql);	
}		
require ("../include/traditional.$langx.inc.php");

function ball($arr){
$red="01,02,07,08,12,13,18,19,23,24,29,30,34,35,40,45,46";
$green="05,06,11,16,17,21,22,27,28,32,33,38,39,43,44,49";
$blue="03,04,09,10,14,15,20,25,26,31,36,37,41,42,47,48";
if(strstr($red,$arr)){ 
   return "red";
}elseif(strstr($green,$arr)){
  return  "green";
}elseif(strstr($blue,$arr)){
  return  "blue";
}
}
 
function animal($arr){
	
$n1='03,15,27,39';
$n2="02,14,26,38";
$n3="01,13,25,37,49";
$n4='12,24,36,48';
$n5='11,23,35,47';
$n6='10,22,34,46';
$n7='09,21,33,45';
$n8='08,20,32,44';
$n9='07,19,31,43';
$n10='06,18,30,42';
$n11='05,17,29,41';
$n12='04,16,28,40';

if(strstr($n1,$arr)){ 
   return "鼠";
}elseif(strstr($n2,$arr)){
   return  "牛";
}elseif(strstr($n3,$arr)){
   return  "虎";
}elseif(strstr($n4,$arr)){
   return  "兔";
}elseif(strstr($n5,$arr)){
   return  "龙";
}elseif(strstr($n6,$arr)){
   return  "蛇";
}elseif(strstr($n7,$arr)){
   return  "马";
}elseif(strstr($n8,$arr)){
   return  "羊";
}elseif(strstr($n9,$arr)){
   return  "猴";
}elseif(strstr($n10,$arr)){
   return  "鸡";
}elseif(strstr($n11,$arr)){
   return  "狗";
}elseif(strstr($n12,$arr)){
   return  "猪";
}
} 
$page=$_REQUEST['page'];
if ($page==''){
	$page=0;
} 
$sql = "select * from number_result where MID!='' order by MID desc";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$page_size=10;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_query($mysql);
$cou=mysql_num_rows($result);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>开奖结果</title>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
function check(form){
  if(form.M_Date.value==""){
   alert('日期不能为空');
   return false;
   form.M_Date.focus();
  }
  if(form.MID.value==""){
   alert('期数不能为空');
   return false;
   form.MID.focus();
  }
  if(form.Num_01.value==""){
   alert('号码一不能为空');
   return false;
   form.Num_01.focus();
  }
  if(form.Num_01.value>49){
  alert('号码一不能不能大于49');
   return false;
   form.Num_01.focus();
  }
  if(form.Num_02.value==""){
   alert('号码二不能为空');
   return false;
   form.Num_02.focus();
  }
  if(form.Num_02.value>49){
  alert('号码二不能不能大于49');
   return false;
   form.Num_02.focus();
  }
  if(form.Num_03.value==""){
   alert('号码三不能为空');
   return false;
   form.Num_03.focus();
  } 
  if(form.Num_03.value>49){
  alert('号码三不能不能大于49');
   return false;
   form.Num_03.focus();
  }
  if(form.Num_04.value==""){
   alert('号码四不能为空');
   return false;
   form.Num_04.focus();
  }
  if(form.Num_04.value>49){
  alert('号码四不能不能大于49');
   return false;
   form.Num_04.focus();
  } 
  if(form.Num_05.value==""){
   alert('号码五不能为空');
   return false;
   form.Num_05.focus();
  } 
  if(form.Num_05.value>49){
  alert('号码五不能不能大于49');
   return false;
   form.Num_05.focus();
  }
  if(form.Num_06.value==""){
   alert('号码六不能为空');
   return false;
   form.Num_06.focus();
  }   
  if(form.Num_06.value>49){
  alert('号码六不能不能大于49');
   return false;
   form.Num_06.focus();
  }
  if(form.Num_07.value==""){
   alert('特别号码不能为空');
   return false;
   form.Num_07.focus();
  }
  if(form.Num_07.value>49){
  alert('特别号码不能不能大于49');
   return false;
   form.Num_07.focus();
  }
}
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("只能输入数字!!"); return false;}
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="myFORM" action="" method=POST>
    <tr>
      <td class="m_tline" width="743">&nbsp;六合彩开奖结果－结算</td>               
      <td class="m_tline" width="204">
      <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
<?
if ($page_count==0){
    $page_count=1;
	}
	for($i=0;$i<$page_count;$i++){
		if ($i==$page){
			echo "<option selected value='$i'>".($i+1)."</option>";
		}else{
			echo "<option value='$i'>".($i+1)."</option>";
		}
	}
?> 
      </select> / <?=$page_count?>  <?=$Mem_Page?>	  
	  </td>
      <td width="31"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
    </tr> 
</form>	
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="100%" height="4"></td> 
    </tr> 
    <tr> 
      <td ></td> 
    </tr> 
</table>
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
	<form name="NewNum" action="" method=post onSubmit="return check(this);">
    <tr class="m_title">
       <td width="70" >开奖结算</td>
       <td width="118">日期&nbsp;
      <input class=za_text maxlength=10 size=8 value="<?=$numdate?>" name=M_Date  disabled></td>
       <td width="75">期数&nbsp;
      <input class=za_text maxlength=3 size=1 onKeyPress="return CheckKey()" value="<?=$nummid?>" name=MID  disabled></td>
       <td width="85">正码一&nbsp;<input class=za_text maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_01></td>
       <td width="85">正码二&nbsp;<input class=za_text maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_02></td>
       <td width="85">正码三&nbsp;<input class=za_text maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_03></td>
       <td width="85">正码四&nbsp;<input class=za_text maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_04></td>
       <td width="85">正码五&nbsp;<input class=za_text maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_05></td>
       <td width="85">正码六&nbsp;<input class=za_text maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_06></td>
       <td width="80">特码&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_07></td>
       <td width="110">
		<input name="Submit" type="submit" class=za_button
		<? 
		if($num['Open']==1){ 
		   echo "value='封盘' disabled"; 
		}else{
		   echo "value='提交'";
		}
		?>
		>
	  </td>
		<input type=hidden value="NewNum" name=type>				
    </tr>
	</form>
</table>
<br>
<?
if($action=='mod'){
?>
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
	<form name="ModNum" action="" method=post onSubmit="return check(this);">
	<tr class="m_title">
       <td width="70" >修改旧期</td>
       <td width="118" >日期&nbsp;<input class=za_text  maxlength=10 size=8 value="<?=$mod["M_Date"]?>" name=M_Date></td>     
       <td width="75">期数&nbsp;<input class=za_text  maxlength=3 size=1 onKeyPress="return CheckKey()" value="<?=$modmid?>" name=MID></td>
       <td width="85">正码一&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_01"]?>" name=Num_01></td>
       <td width="85">正码二&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_02"]?>" name=Num_02></td>
       <td width="85">正码三&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_03"]?>" name=Num_03></td>
       <td width="85">正码四&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_04"]?>" name=Num_04></td>
	   <td width="85">正码五&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_05"]?>" name=Num_05></td>
	   <td width="85">正码六&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_06"]?>" name=Num_06></td>
	   <td width="80">特码&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="<?=$mod["Num_07"]?>" name=Num_07></td>
       <td width="110"><input name="Submit" type="submit" class=za_button value="修改"></td>
	   <input type=hidden value="ModNum" name=type>
    </tr>
	</form>
</table>
<?
}else{
?>
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
	<form name="OldNum" action="" method=post onSubmit="return check(this);">
	<tr class="m_title">
       <td width="70" >添加旧期</td>
       <td width="118" >日期&nbsp;<input class=za_text  maxlength=10 size=8 value="" name=M_Date></td>     
       <td width="75">期数&nbsp;<input class=za_text  maxlength=3 size=1 onKeyPress="return CheckKey()" value="" name=MID></td>
       <td width="85">正码一&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_01></td>
       <td width="85">正码二&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_02></td>
       <td width="85">正码三&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_03></td>
       <td width="85">正码四&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_04></td>
	   <td width="85">正码五&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_05></td>
	   <td width="85">正码六&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_06></td>
	   <td width="80">特码&nbsp;<input class=za_text  maxlength=2 size=1 onKeyPress="return CheckKey()" value="" name=Num_07></td>
       <td width="110"><input name="Submit" type="submit" class=za_button value="提交"></td>
	   <input type=hidden value="OldNum" name=type>
    </tr>
	</form>
</table>
<?
}
?>
<br>
<table border="0" cellspacing="1" cellpadding="0" class="m_tab" width="975">
    <tr class="m_title">
          <td width="40" rowspan="2">期数</td>
          <td width="40" rowspan="2">星期</td>
          <td width="70" rowspan="2" nowrap>时间</td>
          <td height="17" colspan="7">彩球号码</td>
          <td width="36" rowspan="2">特<br>
      单双</td>
          <td width="36" rowspan="2">特<br>
      大小</td>
	      <td width="36" rowspan="2">合<br>
      单双</td>
	      <td width="36" rowspan="2">合<br>
      大小</td>
          <td width="36" rowspan="2">总分</td>
          <td width="36" rowspan="2">总<br>
      单双</td>
          <td width="36" rowspan="2">总<br>
      大小</td>
          <td width="36" rowspan="2">生肖</td>
          <td width="36" rowspan="2">波段</td>
          <td width="96" rowspan="2">功能</td>
          <td width="65" rowspan="2">状态</td>
          <td width="65" rowspan="2">结算</td>
  </tr>
        <tr class="m_title">
          <td width="36">一</td>
          <td width="36">二</td>
          <td width="36">三</td>
          <td width="36">四</td>
          <td width="36">五</td>
          <td width="36">六</td>
          <td width="36">特</td>
        </tr>
<?
$i=1; 
while($row=mysql_fetch_array($result)){ 
$num=$row['MID'];
$i++
?>
        <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)>
          <td height="26" nowrap>
		  <?
		  if ($num<100 and $num>9){		 
		  echo "0$num";
		  }else if($num<10){
		  echo "00$num";
		  }else{
		  echo "$num";
		  }
		  ?></td>
          <td nowrap><?
$time=strtotime($row['M_Date']);
$date=date("N",$time);
switch ($date){ 
case 1: 
$week="星期一"; 
break; 
case 2: 
$week="星期二"; 
break; 
case 3: 
$week="星期三"; 
break; 
case 4: 
$week="星期四"; 
break; 
case 5: 
$week="星期五"; 
break; 
case 6: 
$week="星期六"; 
break; 
default: 
$week="星期天"; 
}
echo "<font color=red>$week</font>";
?></td>
          <td nowrap><?=$row["M_Date"]?></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_01'])?>.jpg"><font color=White><b><?=$row['Num_01']?></b></font></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_02'])?>.jpg"><font color=White><b><?=$row['Num_02']?></b></font></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_03'])?>.jpg"><font color=White><b><?=$row['Num_03']?></b></font></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_04'])?>.jpg"><font color=White><b><?=$row['Num_04']?></b></font></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_05'])?>.jpg"><font color=White><b><?=$row['Num_05']?></b></font></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_06'])?>.jpg"><font color=White><b><?=$row['Num_06']?></b></font></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_07'])?>.jpg"><font color=White><b><?=$row['Num_07']?></b></font></td>
          <td nowrap>
		  <?
		  if($row["Num_07"]!=49){
		     if((abs($row["Num_07"])+2)%2==1):
                echo "<font color='blue'>单</font>";   
             else:   
                echo "<font color='green'>双</font>";   
             endif;
		  }else{
		     echo "<font color='red'>和</font>";
		  }
		  ?></td>
          <td nowrap>
		  <? 
		  if($row["Num_07"]>=25&&$row["Num_07"]<49){
		     echo "<font color='blue'>大</font>";
		  }elseif($row["Num_07"]<25){
		     echo "<font color='green'>小</font>";
		  }elseif($row["Num_07"]==49){
		     echo "<font color='red'>和</font>";
		  }
		  ?></td>
		  <td nowrap>
		  <?
		  if($row["Num_07"]==49){ 
		     echo "<font color='red'>和</font>";
		  }else{
		     $ad=substr($row["Num_07"],0,1)+substr($row["Num_07"],1,1);
		     if((abs($ad)+2)%2==1):
                echo "<font color='blue'>单</font>";  
             else:   
                echo "<font color='green'>双</font>"; 
             endif;
		  }
		  ?></td>
		  <td nowrap>
		  <?
		  $ad=substr($row["Num_07"],0,1)+substr($row["Num_07"],1,1);
		  if($ad==13){
             echo "<font color='red'>和</font>";
          }else if($ad<7){ 
             echo "<font color='green'>小</font>";   
		  }elseif($ad>6){
		     echo "<font color='blue'>大</font>";   
		  }
		  ?></td>
          <td nowrap>
		  <? 
		  $as=$row["Num_01"]+$row["Num_02"]+$row["Num_03"]+$row["Num_04"]+$row["Num_05"]+$row["Num_06"]+$row["Num_07"];
		  echo "<font color='red'><b>$as</b></font>";
		  ?></td>
          <td nowrap>
		  <? 
		  if((abs($as)+2)%2==1):
             echo "<font color='blue'>单</font>";   
          else:   
             echo "<font color='green'>双</font>";   
          endif;
		  ?></td>
          <td nowrap>
		  <?  
		  if($as>174):
             echo "<font color='blue'>大</font>";   
          else:   
             echo "<font color='green'>小</font>";   
          endif;
		  ?></td>
          <td nowrap><?=animal($row['Num_07'])?></td>
          <td nowrap background="/images/agents/top/<?=ball($row['Num_07'])?>.jpg"></td>
          <td nowrap ><a href="number.php?uid=<?=$uid?>&action=mod&id=<?=$row["ID"]?>&langx=<?=$langx?>">修改</a>&nbsp;&nbsp;<a href="number.php?uid=<?=$uid?>&action=del&id=<?=$row["ID"]?>&langx=<?=$langx?>">删除</a></div></td>
          <td nowrap ><a href="../clearing/result_checkp.php?uid=<?=$uid?>&gid=<?=$row["MID"]?>&langx=<?=$langx?>" target="_blank" title="点击查看结果,但不会被结算">查看</a></td>
          <td nowrap ><a href="../clearing/clearingSIX.php?uid=<?=$uid?>&gid=<?=$row["MID"]?>&langx=<?=$langx?>" target="_blank" title="点击结算,并写入报表">结算</a></td>
        </tr> 
		<?
		}
		?>
</table>
</body>
</html>
