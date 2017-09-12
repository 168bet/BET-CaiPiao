<?
include ("../include/address.mem.php");
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_REQUEST["langx"];
$active=$_REQUEST['active'];
$uid=$_REQUEST['uid'];
$id=$_REQUEST['id'];
$gid=$_REQUEST['gid'];
$gtype=$_REQUEST['gtype'];
$key=$_REQUEST['key'];
$confirmed=$_REQUEST['confirmed'];
$sql = "select * from web_system_data where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
require ("../include/traditional.$langx.inc.php");

switch($gtype){
	case 'FT':
	$table="and (Active=1 or Active=11) ";
	break;
	case 'BK':
	$table="and (Active=2 or Active=22) ";
	break;
	case 'BS':
	$table="and (Active=3 or Active=33) ";
	break;
	case 'TN':
	$table="and (Active=4 or Active=44) ";
	break;
	case 'VB':
	$table="and (Active=5 or Active=55) ";
	break;
	case 'OP':
	$table="and (Active=6 or Active=66) ";
	break;
	case 'FU':
	$table="and (Active=7 or Active=77) ";
	break;
	case 'FS':
	$table="and (Active=8)";
    break;
}
//取消注单
if ($key=='cancel'){
    $rsql = "select M_Name,Pay_Type,BetScore,M_Result from web_report_data where mid='$gid' and id='$id' and Pay_Type=1";
    $rresult = mysql_query( $rsql);
    while ($rrow = mysql_fetch_array($rresult)){
           $username=$rrow['M_Name'];
           $betscore=$rrow['BetScore'];
           $m_result=$rrow['M_Result'];
           if ($rrow['Pay_Type']==1){//结算之后的现金返回
               if ($m_result==''){
                   $u_sql = "update web_member_data set Money=Money+$betscore where UserName='$username' and Pay_Type=1";
                   mysql_query($u_sql) or die ("操作失败11!");
               }else{
                   $u_sql = "update web_member_data set Money=Money-$m_result where UserName='$username' and Pay_Type=1";
                   mysql_query($u_sql) or die ("操作失败22!");
               }
           }
    }
	$sql="update web_report_data set VGOLD=0,M_Result=0,A_Result=0,B_Result=0,C_Result=0,D_Result=0,T_Result=0,Cancel=1,Confirmed='$confirmed',Danger=0,Checked=1 where id='$id'";
	mysql_query( $sql) or die ("操作失败!");
	echo "<script languag='JavaScript'>self.location='showdata.php?uid=$uid&id=$id&gid=$gid&gtype=$gtype&langx=$langx'</script>";
}

//恢复注单
if ($key=='resume'){
	$rsql = "select M_Name,Pay_Type,BetScore,M_Result,Checked from web_report_data where MID='$gid' and ID='$id' and Pay_Type=1";
	$rresult = mysql_query( $rsql);
	while ($rrow = mysql_fetch_array($rresult)){
	       $username=$rrow['M_Name'];
	       $betscore=$rrow['BetScore'];
	       $m_result=$rrow['M_Result'];
           if ($rrow['Pay_Type']==1){//结算之后的现金返回
	           if ($rrow['Checked']==1){
	               $cash=$betscore+$m_result;
	               $u_sql ="update web_member_data SET Money=Money-$cash where UserName='$username' and Pay_Type=1";
	               mysql_query($u_sql) or die ("操作失败1!");
	          }
           }
	}
	$sql="update web_report_data set VGOLD='',M_Result='',A_Result='',B_Result='',C_Result='',D_Result='',T_Result='',Cancel=0,Confirmed=0,Danger=0,Checked=0 where id='$id'";
	mysql_query( $sql);
	echo "<script languag='JavaScript'>self.location='showdata.php?uid=$uid&id=$id&gid=$gid&gtype=$gtype&langx=$langx'</script>";
}
$mysql="select * from match_sports where Type='".$gtype."' and MID='".$gid."'";
$result1 = mysql_query( $mysql);
$mrow = mysql_fetch_array($result1);
$mysql="select ID,MID,Active,LineType,Mtype,Pay_Type,M_Date,BetTime,BetScore,CurType,$middle as Middle,$bettype as BetType,M_Place,M_Rate,M_Name,Gwin,Glost,VGOLD,M_Result,A_Result,B_Result,C_Result,D_Result,T_Result,TurnRate,OpenType,OddsType,ShowType,Cancel,Confirmed,Danger from web_report_data where FIND_IN_SET($gid,MID)>0 $table  order by bettime,linetype,mtype";
$result = mysql_query( $mysql);
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
     <td class="m_tline" width="965">注单核查 --主队：<?=$mrow['MB_Team']?>&nbsp;&nbsp;&nbsp;&nbsp;上半场：<font color=red>(&nbsp;<?=$mrow['MB_Inball_HR']?>&nbsp;)</font>&nbsp;&nbsp;全场：<font color=red>(&nbsp;<?=$mrow['MB_Inball']?>&nbsp;)</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客队：<?=$mrow['TG_Team']?>&nbsp;&nbsp;&nbsp;&nbsp;上半场：<font color=red>(&nbsp;<?=$mrow['TG_Inball_HR']?>&nbsp;)</font>&nbsp;&nbsp;全场：<font color=red>(&nbsp;<?=$mrow['TG_Inball']?>&nbsp;)
<font color="#cc0000">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.go( -1 );">回上一頁</a>&nbsp;&nbsp;</font></font></td>
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
          <td width="85">投注时间</td>
          <td width="85">用户名称</td>
          <td width="110">球赛种类</td>
          <td width="325">內容</td>
          <td width="95">投注金额</td>
          <td width="95">会员结果</td>
          <td width="50">操作</td>
          <td width="121">功能</td>
        </tr>
<?
while ($row = mysql_fetch_array($result)){
switch($row['Active']){
case 1:
	$Title=$Mnu_Soccer;
	break;
case 11:
	$Title=$Mnu_Soccer;
	break;
case 2:
	$Title=$Mnu_BasketBall;
	break;
case 22:
	$Title=$Mnu_BasketBall;
	break;
case 3:
	$Title=$Mnu_Base;
	break;
case 33:
	$Title=$Mnu_Base;
	break;
case 4:
	$Title=$Mnu_Tennis;
	break;
case 44:
	$Title=$Mnu_Tennis;
	break;
case 5:
	$Title=$Mnu_Voll;
	break;
case 55:
	$Title=$Mnu_Voll;
	break;
case 6:
	$Title=$Mnu_Other;
	break;
case 66:
	$Title=$Mnu_Other;
	break;
case 7:
	$Title=$Mnu_Stock;
	break;
case 77:
	$Title=$Mnu_Stock;
	break;
case 8:
	$Title=$Mnu_Guan;
	break;
}
switch ($row['OddsType']){
case 'H':
    $Odds='<BR><font color =green>'.$Rep_HK.'</font>';
	break;
case 'M':
    $Odds='<BR><font color =green>'.$Rep_Malay.'</font>';
	break;
case 'I':
    $Odds='<BR><font color =green>'.$Rep_Indo.'</font>';
	break;
case 'E':
    $Odds='<BR><font color =green>'.$Rep_Euro.'</font>';
	break;
case '':
    $Odds='';
	break;
}
$time=strtotime($row['BetTime']);
$times=date("Y-m-d",$time).'<br>'.date("H:i:s",$time);

if ($row['Danger']==1 or $row['Cancel']==1) {
	$bettimes='<font color="#FFFFFF"><span style="background-color: #FF0000">'.$times.'</span></font>';
	$betscore='<S><font color=#cc0000>'.number_format($row['BetScore']).'</font></S>';
}else{
	$bettimes=$times;
	$betscore=number_format($row['BetScore']);
}
?>
        <tr class="m_cen" onmouseover=sbar(this) onmouseout=cbar(this)> 
          <td><?=$bettimes?></td>
          <td><?=$row['M_Name']?><br>
          <font color="#cc0000"><?=$row['OpenType']?>&nbsp;&nbsp;<?=$row['TurnRate']?></font></td>
          <td><?=$Title?><?=$row['BetType']?><?=$Odds?><br>
          <font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font></td>
          <td align="right"><?=$row['Middle']?></td>
          <td align="right"><?=$betscore?></td>
          <td align="right">
<? 	
if($row['Cancel']==0){
?>	  
<?=number_format($row['M_Result'],1)?>
<?
}else{
?>
<font color=red>
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
case -12:
echo $zt=$Score32;
break;
case -13:
echo $zt=$Score33;
break;
case -14:
echo $zt=$Score34;
break;
case -15:
echo $zt=$Score35;
break;
case -16:
echo $zt=$Score36;
break;
case -17:
echo $zt=$Score37;
break;
case -18:
echo $zt=$Score38;
break;
case -19:
echo $zt=$Score39;
break;
case -20:
echo $zt=$Score40;
break;
case -21:
echo $zt=$Score41;
break;
}
?>
</font>
<?
}
?>		  </td>
          <td><font color=red>
<?
if ($row['Cancel']==1){
	echo '<a href="showdata.php?uid='.$uid.'&id='.$row['ID'].'&gid='.$row['MID'].'&pay_type='.$row['Pay_Type'].'&key=resume&result='.$row['M_Result'].'&user='.$row['M_Name'].'&confirmed=0&gtype='.$gtype.'&langx='.$langx.'"><font color=red><b>恢复</b></font></a>';
}else{
	echo '<font color=blue><b>正常</b></font>';
}
?>
          </font></td>
          <td width="121">
<SELECT onchange=javascript:CheckSTOP(this.options[this.selectedIndex].value) size=1 name=select1>
  <option>注单处理</option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-1&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score21?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-2&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score22?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-3&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score23?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-4&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score24?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-5&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score25?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-6&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score26?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-7&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score27?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-8&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score28?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-9&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score29?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-10&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score30?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-11&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score31?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-12&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score32?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-13&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score33?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-14&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score34?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-15&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score35?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-16&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score36?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-17&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score37?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-18&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score38?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-19&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score39?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-20&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score40?></option>
  <option value="showdata.php?uid=<?=$uid?>&id=<?=$row['ID']?>&gid=<?=$row['MID']?>&pay_type=<?=$row['Pay_Type']?>&key=cancel&result=<?=$row['M_Result']?>&user=<?=$row['M_Name']?>&confirmed=-21&gtype=<?=$gtype?>&langx=<?=$langx?>"><?=$Score41?></option>
</SELECT>          </td>
        </tr>
<?
}
?>
</table>    
</BODY>
</html>
