<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");    
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
$uid=$_REQUEST["uid"];
$id=$_REQUEST["id"];
$langx=$_REQUEST["langx"];
$loginname=$_SESSION["loginname"];
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
}

$action=$_REQUEST['action'];
$line=$_REQUEST['line'];
if ($action==1){
	if ($line==11 or $line==12 or $line==13 or $line==14 or $line==19 or $line==20 or $line==31){
	    $bottom_type="-&nbsp;<font color=#666666>[上半]</font>&nbsp;";
	    $bottom_type_tw="-&nbsp;<font color=#666666>[上半]</font>&nbsp;";
	    $bottom_type_en="-&nbsp;<font color=#666666>[1st Half]</font>&nbsp;";
	}
	if ($line==9 or $line==10 or $line==19 or $line==20 or $line==21 or $line==31){
	    $middle3='&nbsp;&nbsp;<FONT color=red><b>'.$_REQUEST['middle3'].'</b></FONT>';
	    $middle_tw3='&nbsp;&nbsp;<FONT color=red><b>'.$_REQUEST['middle_tw3'].'</b></FONT>';
	    $middle_en3='&nbsp;&nbsp;<FONT color=red><b>'.$_REQUEST['middle_en3'].'</b></FONT>';
	}
	$place=str_replace(" ","&nbsp;",$_REQUEST['place']);
	$place_tw=str_replace(" ","&nbsp;",$_REQUEST['place_tw']);
	$place_en=str_replace(" ","&nbsp;",$_REQUEST['place_en']);
	
	$middle=$_REQUEST['info0'].'<br>'.$_REQUEST['info1'].'<br>'.$_REQUEST['middle0'].'&nbsp;&nbsp;<FONT COLOR=#0000BB><b>'.$_REQUEST['middle1'].'</b></FONT>&nbsp;&nbsp;'.$_REQUEST['middle2'].$middle3.'<br><FONT color=#cc0000>'.$place.'</FONT>&nbsp;'.$bottom_type.'@&nbsp;<FONT color=#cc0000><b>'.$_REQUEST['rate'].'</b></FONT>';
	$middle_tw=$_REQUEST['info_tw0'].'<br>'.$_REQUEST['info_tw1'].'<br>'.$_REQUEST['middle_tw0'].'&nbsp;&nbsp;<FONT COLOR=#0000BB><b>'.$_REQUEST['middle_tw1'].'</b></FONT>&nbsp;&nbsp;'.$_REQUEST['middle_tw2'].$middle_tw3.'<br><FONT color=#cc0000>'.$place_tw.'</FONT>&nbsp;'.$bottom_type_tw.'@&nbsp;<FONT color=#cc0000><b>'.$_REQUEST['rate_tw'].'</b></FONT>';
	$middle_en=$_REQUEST['info_en0'].'<br>'.$_REQUEST['info_en1'].'<br>'.$_REQUEST['middle_en0'].'&nbsp;&nbsp;<FONT COLOR=#0000BB><b>'.$_REQUEST['middle_en1'].'</b></FONT>&nbsp;&nbsp;'.$_REQUEST['middle_en2'].$middle_en3.'<br><FONT color=#cc0000>'.$place_en.'</FONT>&nbsp;'.$bottom_type_en.'@&nbsp;<FONT color=#cc0000><b>'.$_REQUEST['rate_en'].'</b></FONT>';
	if ($line==2 or $line==3  or $line==12 or $line==13 or $line==9 or $line==10 or $line==19 or $line==20){
		$num=0;
	}else{
		$num=1;
	}
	$gwin=($_REQUEST['rate_tw']-$num)*$_REQUEST['betscore'];
	
	$mysql="update web_report_data set Mtype='".$_REQUEST['mtype']."',BetTime='".$_REQUEST['bettime']."',BetScore='".$_REQUEST['betscore']."',Middle='$middle',Middle_tw='$middle_tw',Middle_en='$middle_en',M_Place='".$_REQUEST['m_place']."',M_Rate='".$_REQUEST['m_rate']."',Gwin='$gwin',Edit=1 where ID=$id";
	mysql_db_query($dbname,$mysql);
	echo "<SCRIPT language='javascript'>self.location='query.php?uid=$uid&langx=$langx';</script>";
}
$mysql="select ID,LineType,Mtype,BetTime,BetScore,Middle,Middle_tw,Middle_en,BetType,BetType_tw,BetType_en,M_Place,M_Rate,M_Name,OddsType  from web_report_data where ID=$id";
$result = mysql_db_query($dbname,$mysql);
$row = mysql_fetch_array($result);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~拆分注单
$info   =explode("<br>",$row[Middle]);
$info_tw=explode("<br>",$row[Middle_tw]);
$info_en=explode("<br>",$row[Middle_en]);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~顶部
$top=$info[0].'<br>'.$info[1].'<br>';
$top_tw=$info_tw[0].'<br>'.$info_tw[1].'<br>';
$top_en=$info_en[0].'<br>'.$info_en[1].'<br>';
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~中部
$middle_team=strip_tags($info[2]);
$middle_team_tw=strip_tags($info_tw[2]);
$middle_team_en=strip_tags($info_en[2]);
$middle=explode("&nbsp;&nbsp;",$middle_team);
$middle_tw=explode("&nbsp;&nbsp;",$middle_team_tw);
$middle_en=explode("&nbsp;&nbsp;",$middle_team_en);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~底部
$bottom_team=strip_tags($info[3]);
$bottom_team_tw=strip_tags($info_tw[3]);
$bottom_team_en=strip_tags($info_en[3]);
$bottom=explode("&nbsp;",$bottom_team);
$bottom_tw=explode("&nbsp;",$bottom_team_tw);
$bottom_en=explode("&nbsp;",$bottom_team_en);

//print_r($bottom);
switch($row['OddsType']){
	case "H":
		$odds='香港盘';
		break;
	case "M":
		$odds='马来盘';
		break;
	case "I":
		$odds='印尼盘';
		break;
	case "E":
		$odds='欧洲盘';
		break;
}
switch($row['LineType']){
	case "1":
		$line='全场独赢';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;
	case "2":
		$line='全场让球';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];		
		break;
	case "3":
		$line='全场大小';
		$place=$bottom[0].'&nbsp;'.$bottom[1];
		$place_tw=$bottom_tw[0].'&nbsp;'.$bottom_tw[1];
		$place_en=$bottom_en[0].'&nbsp;'.$bottom_en[1];
		$rate=$bottom[3];
		$rate_tw=$bottom_tw[3];
		$rate_en=$bottom_en[3];
		break;
	case "4":
		$line='全场波单';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;
	case "5":
		$line='全场单双';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;		
	case "6":
		$line='入球数';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;		
	case "7":
		$line='半全场';
		$place=$bottom[0].'&nbsp;/&nbsp;'.$bottom[2];
		$place_tw=$bottom_tw[0].'&nbsp;/&nbsp;'.$bottom_tw[2];
		$place_en=$bottom_en[0].'&nbsp;/&nbsp;'.$bottom_en[2];
		$rate=$bottom[4];
		$rate_tw=$bottom_tw[4];
		$rate_en=$bottom_en[4];
		break;		
	case "8":
		$line='过关';
		break;		
	case "9":
		$line='全场滚球让球';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;
	case "10":
		$line='全场滚球大小';
		$place=$bottom[0].'&nbsp;'.$bottom[1];
		$place_tw=$bottom_tw[0].'&nbsp;'.$bottom_tw[1];
		$place_en=$bottom_en[0].'&nbsp;'.$bottom_en[1];
		$rate=$bottom[3];
		$rate_tw=$bottom_tw[3];
		$rate_en=$bottom_en[3];
		break;
	case "11":
		$line='半场独赢';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[4];
		$rate_tw=$bottom_tw[4];
		$rate_en=$bottom_en[4];
		break;
	case "12":
		$line='半场让球';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[4];
		$rate_tw=$bottom_tw[4];
		$rate_en=$bottom_en[4];
		break;
	case "13":
		$line='半场大小';
		$place=$bottom[0].'&nbsp;'.$bottom[1];
		$place_tw=$bottom_tw[0].'&nbsp;'.$bottom_tw[1];
		$place_en=$bottom_en[0].'&nbsp;'.$bottom_en[1];
		$rate=$bottom[5];
		$rate_tw=$bottom_tw[5];
		$rate_en=$bottom_en[5];
		break;
	case "14":
		$line='半场波胆';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;
	case "19":
		$line='滚球半场让球';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[4];
		$rate_tw=$bottom_tw[4];
		$rate_en=$bottom_en[4];
		break;
	case "20":
		$line='滚球半场大小';
		$place=$bottom[0].'&nbsp;'.$bottom[1];
		$place_tw=$bottom_tw[0].'&nbsp;'.$bottom_tw[1];
		$place_en=$bottom_en[0].'&nbsp;'.$bottom_en[1];
		$rate=$bottom[5];
		$rate_tw=$bottom_tw[5];
		$rate_en=$bottom_en[5];
		break;
	case "21":
		$line='滚球全场独赢';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[2];
		$rate_tw=$bottom_tw[2];
		$rate_en=$bottom_en[2];
		break;
	case "31":
		$line='滚球半场独赢';
		$place=$bottom[0];
		$place_tw=$bottom_tw[0];
		$place_en=$bottom_en[0];
		$rate=$bottom[4];
		$rate_tw=$bottom_tw[4];
		$rate_en=$bottom_en[4];
		break;
}
?>
<html>
<head>
<title>reports_member</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title {  background-color: #687780; text-align: center; color: #FFFFFF}
.m_title_2 { background-color: #CC0000; text-align: center; color: #FFFFFF}
-->
</style>
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="JavaScript">
function SubChk()
{
  if (document.all.m_date.value==''){
    document.all.m_date.focus();
    alert("请输入比赛日期!!");
    return false;
  }
  if (document.all.m_time.value==''){
    document.all.m_time.focus();
    alert("请输入比赛时间!!");
    return false;
  } 
  if(!confirm("日期更改为："+document.all.m_date.value+"\n时间更改为："+document.all.m_time.value+"\n\n请确定输入是否正确?")){return false;}
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="LAYOUTFORM" onSubmit="return SubChk();" ACTION="query_edit.php?uid=<?=$uid?>&id=<?=$id?>&langx=<?=$langx?>&action=1&line=<?=$row['LineType']?>" METHOD=POST> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="m_tline" width="965">&nbsp;线上修改注单 -- 下注管道:网路下注 -- <a href="javascript:history.go( -1 );">回上一頁</a>      </td>
      <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
    </tr>
    <tr> 
      <td colspan="2" height="4"></td>
    </tr>
  </table>
<table width="800" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td width="550">
<table width="550" border="0" cellspacing="1" cellpadding="0" class="m_tab">
  <tr class="m_title" > 
      <td width="100">&nbsp;</td>
    <td width="447"><font color="#FFFF00"><b><?=$odds?>---<?=$line?></b></font></td>
    </tr>
  <tr class="m_rig_re">
    <td>时间:</td>
    <td align="left"><input name="bettime" type="text" size="18" class="za_text" value="<?=$row["BetTime"]?>">(说明:下注时间为均为<font color="#CC0000">美东</font>时间)</td>
    </tr>
  <tr class="m_rig_re">
    <td>简体注单内容:</td>
    <td align="left"><input name="info0" type="text" size="30" class="za_text" value="<?=$info[0]?>"><br><input name="info1" type="text" size="20" class="za_text" value="<?=$info[1]?>"><br><input name="middle0" type="text" size="25" class="za_text" value="<?=$middle[0]?>">&nbsp;<input name="middle1" type="text" size="5" class="za_text" value="<?=$middle[1]?>">&nbsp;<input name="middle2" type="text" size="25" class="za_text" value="<?=$middle[2]?>">&nbsp;<input name="middle3" type="text" size="5" class="za_text" value="<?=$middle[3]?>"><br><input name="place" type="text" size="30" class="za_text" value="<?=$place?>">&nbsp;@&nbsp;<input name="rate" type="text" size="10" class="za_text" value="<?=$rate?>"></td>
    </tr>
  <tr class="m_rig_re">
    <td>繁体注单内容:</td>
    <td align="left"><input name="info_tw0" type="text" size="30" class="za_text" value="<?=$info_tw[0]?>"><br><input name="info_tw1" type="text" size="20" class="za_text" value="<?=$info_tw[1]?>"><br><input name="middle_tw0" type="text" size="25" class="za_text" value="<?=$middle_tw[0]?>">&nbsp;<input name="middle_tw1" type="text" size="5" class="za_text" value="<?=$middle_tw[1]?>">&nbsp;<input name="middle_tw2" type="text" size="25" class="za_text" value="<?=$middle_tw[2]?>">&nbsp;<input name="middle_tw3" type="text" size="5" class="za_text" value="<?=$middle_tw[3]?>"><br><input name="place_tw" type="text" size="30" class="za_text" value="<?=$place_tw?>">&nbsp;@&nbsp;<input name="rate_tw" type="text" size="10" class="za_text" value="<?=$rate_tw?>"></td>
    </tr>
  <tr class="m_rig_re">
    <td>英文注单内容:</td>
    <td align="left"><input name="info_en0" type="text" size="30" class="za_text" value="<?=$info_en[0]?>"><br><input name="info_en1" type="text" size="20" class="za_text" value="<?=$info_en[1]?>"><br><input name="middle_en0" type="text" size="25" class="za_text" value="<?=$middle_en[0]?>">&nbsp;<input name="middle_en1" type="text" size="5" class="za_text" value="<?=$middle_en[1]?>">&nbsp;<input name="middle_en2" type="text" size="25" class="za_text" value="<?=$middle_en[2]?>">&nbsp;<input name="middle_en3" type="text" size="5" class="za_text" value="<?=$middle_en[3]?>"><br><input name="place_en" type="text" size="30" class="za_text" value="<?=$place_en?>">&nbsp;@&nbsp;<input name="rate_en" type="text" size="10" class="za_text" value="<?=$rate_en?>"></td>
    </tr>
  <tr class="m_rig_re">
    <td>注单类型:</td>
    <td align="left"><input name="mtype" type="text" size="10" class="za_text" value="<?=$row['Mtype']?>">(如有修改上下盘,请把&nbsp;<font color="#CC0000">H</font>&nbsp;换成&nbsp;<font color="#CC0000">C</font>,或者&nbsp;<font color="#CC0000">C</font>&nbsp;换成&nbsp;<font color="#CC0000">H</font>.否则结算出错.)</td>
    </tr>
  <tr class="m_rig_re">
    <td>水位:</td>
    <td align="left"><input name="m_rate" type="text" size="10" class="za_text" value="<?=$row['M_Rate']?>">(修改水位需要把上面三个语言的水位一起修改)</td>
  </tr>
  <tr class="m_rig_re"> 
    <td>盘口:</td>
    <td align="left"><input name="m_place" type="text" size="10" class="za_text" value="<?=$row['M_Place']?>">(修改盘口需要把上面三个语言的盘口一起修改)</td>
    </tr>
  <tr class="m_rig_re"> 
    <td>下注金额:</td>
    <td align="left"><input name="betscore" type="text" size="10" class="za_text" value="<?=$row['BetScore']?>"></td>
    </tr>
  <tr class="m_rig_re"> 
    <td colspan="2" align="center"><input type="submit" value=" 提 交 " name="B1" class="za_button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
      <input type="reset" value=" 清 除 " name="B2" class="za_button"></td>
    </tr>
  </table>
  </td>
  <td width="247"><table width="100%" border="0" cellpadding="0" cellspacing="1" class="m_tab">
    <tr class="m_rig_re">
      <td align="center">修改注单注意事项</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><font color="#CC0000">时间</font>：下注时间都是按美东时间。</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><font color="#CC0000">注单内容</font>：修改上下盘必须要手动修改三种语言的上下盘。</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><font color="#CC0000">注单类</font>型：修改上下盘必须修改相对的上下盘标志。以免结算出错。</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><font color="#CC0000">水位</font>：修改水位必须要修改三种语言的水位。</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><font color="#CC0000">盘口</font>：修改盘口必须要修改三种语言的盘口。</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><font color="#CC0000">金额</font>：修改金额不要带有小数点。</td>
    </tr>
    <tr class="m_rig_re">
      <td align="left"><p><font color="#CC0000">对应的注单类型</font>：</p>
        <p>单(ODD) 双(EVEN) (0~1) (2~3) (4~6) (7up)</p>
<p>()()</p></td>
    </tr>
  </table></td>
  </tr>
</table>
</form>
</body>
</html>