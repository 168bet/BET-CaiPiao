<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$active=$_REQUEST['active'];
$uid=$_REQUEST['uid'];
$id=$_REQUEST['id'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['gtype'];
$key=$_REQUEST['key'];
$confirmed=$_REQUEST['confirmed'];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
require ("../include/traditional.$langx.inc.php");

switch($gtype){
	case 'FT':
	$table="and (Active=1 or Active=2) ";
	break;
	case 'BK':
	$table="and (Active=3 or Active=33) ";
	break;
	case 'BS':
	$table="and (Active=4 or Active=44) ";
	break;
	case 'TN':
	$table="and (Active=5 or Active=55) ";
	break;
	case 'VB':
	$table="and (Active=6 or Active=66) ";
	break;
	case 'FS':
	$table="and (Active=7)";
    break;
}
//取消注单
if ($key=='cancel'){
    $rsql = "select M_Name,Pay_Type,BetScore,M_Result from web_report_data where mid='$gid' and id='$id' and Pay_Type=1";
    $rresult = mysql_db_query($dbname, $rsql);
    while ($rrow = mysql_fetch_array($rresult)){
           $username=$rrow['M_Name'];
           $betscore=$rrow['BetScore'];
           $m_result=$rrow['M_Result'];
           if ($rrow['Pay_Type']==1){//结算之后的现金返回
               if ($m_result==''){
                   $u_sql = "update web_member_data set Money=Money+$betscore where UserName='$username' and Pay_Type=1";
                   mysql_db_query($dbname,$u_sql) or die ("操作失败11!");
               }else{
                   $u_sql = "update web_member_data set Money=Money-$m_result where UserName='$username' and Pay_Type=1";
                   mysql_db_query($dbname,$u_sql) or die ("操作失败22!");
               }
           }
    }
	$sql="update web_report_data set VGOLD=0,M_Result=0,A_Result=0,B_Result=0,C_Result=0,D_Result=0,T_Result=0,Cancel=1,Confirmed='$confirmed',Danger=0,Checked=1 where id='$id'";
	mysql_db_query($dbname, $sql) or die ("操作失败!");
	echo "<script languag='JavaScript'>self.location='parlay.php?uid=$uid&id=$id&gid=$gid&gtype=$gtype&langx=$langx'</script>";
}

//恢复注单
if ($key=='update'){
	$rsql = "select M_Name,Pay_Type,BetScore,M_Result,Checked from web_report_data where MID='$gid' and ID='$id' and Pay_Type=1";
	$rresult = mysql_db_query($dbname, $rsql);
	while ($rrow = mysql_fetch_array($rresult)){
	       $username=$rrow['M_Name'];
	       $betscore=$rrow['BetScore'];
	       $m_result=$rrow['M_Result'];
           if ($rrow['Pay_Type']==1){//结算之后的现金返回
	           if ($rrow['Checked']==1){
	               $cash=$betscore+$m_result;
	               $u_sql ="update web_member_data SET Money=Money-$cash where UserName='$username' and Pay_Type=1";
	               mysql_db_query($dbname,$u_sql) or die ("操作失败1!");
	          }
           }
	}
	$sql="update web_report_data set VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Cancel=0,Confirmed=0,Danger=0,Checked=0 where id='$id'";
	mysql_db_query($dbname, $sql);
	echo "<script languag='JavaScript'>self.location='parlay.php?uid=$uid&id=$id&gid=$gid&gtype=$gtype&langx=$langx'</script>";
}
if($key=='modify'){
	$sql="update web_report_data set MID='".$_REQUEST['mid']."' where id='$id'";
	mysql_db_query($dbname, $sql);
}

$date=date('Y-m-d');
$mysql="select ID,MID,Active,LineType,Mtype,Pay_Type,M_Date,BetTime,BetScore,CurType,$middle as Middle,$bettype as BetType,M_Place,M_Rate,M_Name,Gwin,Glost,VGOLD,M_Result,A_Result,B_Result,C_Result,D_Result,T_Result,TurnRate,OpenType,ShowType,Cancel,Confirmed,Danger from web_report_data where M_Date='$date' and LineType=8 order by BetTime";
$result = mysql_db_query($dbname,$mysql);
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<script language=javascript>
function CheckSTOP(str){
	if(confirm("确实取消本场注单吗?"))
	document.location=str;
}	
function reload(){
location.reload();
}
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
</script>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="m_tline" width="975">&nbsp;&nbsp;说明：MID修改是针对赛事提前开赛。如有提前开赛的赛事，请把相对应的MID更改为999999&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.go( -1 );">回上一頁</a>&nbsp;&nbsp;</td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td> 
  </tr> 
</table> 
  <table width="774" border="0" cellspacing="0" cellpadding="0"> 
    <tr>  
      <td width="774" height="4"></td> 
    </tr> 
    <tr> 
      <td ></td> 
    </tr> 
  </table>

    <table width="975" border="0" cellspacing="1" cellpadding="0" class="m_tab">
        <tr class="m_title"> 
          <td width="100"align="center">投注时间</td>
          <td width="70" align="center">用户名称</td>
          <td width="100" align="center">球赛种类</td>
          <td width="73" align="center">MID</td>
          <td width="247" align="center">內容</td>
          <td width="75" align="center">投注</td>
          <td width="75" align="center">会员</td>
          <td colspan="2" align="center">取消</td>
          <td width="84" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;功能</td>
        </tr>
<?
while ($row = mysql_fetch_array($result)){
?>
        <tr class="m_rig" onmouseover=sbar(this) onmouseout=cbar(this)> 
		<FORM NAME="parlayFORM" ACTION="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&key=modify&langx=<?=$langx?>" METHOD=POST>
          <td align="center"><?=$row['BetTime']?></td>
          <td align="center"><?=$row['M_Name']?><br><font color="#cc0000"><?=$row['OpenType']?>&nbsp;&nbsp;<?=$row['TurnRate']?></font></td>
          <td align="center"><?=$Title?><?=$row['BetType']?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
          <td align="center"><textarea name="mid" cols="8" rows="10" id="mid"><?=$row['MID']?></textarea></td>
          <td align="right"><?=$row['Middle']?></td>
          <td align="center"><?=$row['BetScore']?></td>
          <td width="75"><?=number_format($row['M_Result'],1)?></td>
          <td width="50" align="center">
<?
if ($row['Cancel']==1){
	echo '<a href="parlay.php?uid='.$uid.'&id='.$row['ID'].'&pay_type='.$row['Pay_Type'].'&key=update&result='.$row['M_Result'].'&user='.$row['M_Name'].'&confirmed=0&gtype='.$gtype.'&langx='.$langx.'"><font color=red><b>恢复</b></font></a>';
}else{
	echo '<font color=blue><b>正常</b></font>';
}
?>         </td>
          <td width="90" align="center"><font color=red>
<? 
switch($row['Confirmed']){
case 0:
echo $zt=$Score20;
break;
case -1:
echo $zt=$Score21;
break;
case -2:
echo $zt=$Score22;
break;
case -3:
echo $zt=$Score23;
break;
case -4:
echo $zt=$Score24;
break;
case -5:
echo $zt=$Score25;
break;
case -6:
echo $zt=$Score26;
break;
case -7:
echo $zt=$Score27;
break;
case -8:
echo $zt=$Score28;
break;
case -9:
echo $zt=$Score29;
break;
case -10:
echo $zt=$Score30;
break;
case -11:
echo $zt=$Score31;
break;
case -32:
echo $zt=$Score32;
break;
case -33:
echo $zt=$Score33;
break;
case -34:
echo $zt=$Score34;
break;
case -35:
echo $zt=$Score35;
break;
case -36:
echo $zt=$Score36;
break;
case -37:
echo $zt=$Score37;
break;
case -38:
echo $zt=$Score38;
break;
case -39:
echo $zt=$Score39;
break;
case -40:
echo $zt=$Score40;
break;
case -41:
echo $zt=$Score41;
break;
}?>
          </font></td>
          <td width="84" align="left"><input type="submit" value="MID修改" name="B1" class="za_button"><br><br>
<SELECT onchange=javascript:CheckSTOP(this.options[this.selectedIndex].value) size=1 name=select1>
  <option>注单处理</option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-1&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score21?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-2&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score22?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-3&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score23?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-4&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score24?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-5&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score25?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-6&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score26?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-7&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score27?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-8&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score28?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-9&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score29?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-10&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score30?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-11&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score31?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-32&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score32?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-33&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score33?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-34&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score34?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-35&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score35?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-36&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score36?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-37&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score37?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-38&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score38?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-39&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score39?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-40&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score40?></option>
  <option value="parlay.php?uid=<?=$uid?>&id=<?=$row['ID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-41&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score41?></option>
</SELECT>
          </td>
		 </FORM>  
        </tr>
<?
}
?>
</table>
   
</BODY>
</html>