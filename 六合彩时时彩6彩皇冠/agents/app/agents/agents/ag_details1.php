<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$id=$_REQUEST["id"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];

$sql = "select ID,Level,UserName,SubUser,SubName from web_agents_data where Oid='$uid' and LoginName='$loginname'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx='zh-tw';
require ("../../agents/include/traditional.$langx.inc.php");


$year=$_REQUEST['year'];
$mon=$_REQUEST['mon'];
$day=$_REQUEST['day'];
$year1=$_REQUEST['year1'];
$mon1=$_REQUEST['mon1'];
$day1=$_REQUEST['day1'];

$start_time=($year."-".$mon."-".$day);
$end_time=($year1."-".$mon1."-".$day1);

$sql="select UserName from web_agents_data where Status=0 and Oid='$uid' and level='D'";
//print_r($_REQUEST);
$tresult = mysql_query($sql);
$trow = @mysql_fetch_array($tresult);
$sql="select count(*) from web_member_data where Agents='".$trow[0]."'";
$result = mysql_query($sql);
$row = @mysql_fetch_array($result);
$countmember=$row[0];

$sql="select UserName from web_member_data where Agents='".$trow[0]."'";
$result = mysql_query($sql);
while($row = @mysql_fetch_array($result)){
$UserName.="'".$row['UserName']."',";
}
$UserName=substr($UserName,0,-1);


$sql="select sum(gold) from web_sys800_data where UserName in ($UserName) and AddDate>='".$start_time."' and AddDate<='".$end_time."' and Type='S'";
$result = mysql_query($sql);
$row = @mysql_fetch_array($result);
$inpay=empty($row[0])?0:$row[0];

$sql="select sum(gold) from web_sys800_data where UserName in ($UserName) and AddDate>='".$start_time."' and AddDate<='".$end_time."' and Type='S'";
$result = mysql_query($sql);
$row = @mysql_fetch_array($result);
$okpay=empty($row[0])?0:$row[0];



?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8 ">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_title_ag {  background-color: <?=$class?>; text-align: center; height:25px}
.m_tab_ag {  padding-top: 3px; padding-right: 2px; padding-left: 2px}
-->
</style>

<script type="text/javascript" src="/js/agents/user_search.js" ></script>
<script type="text/javascript" src="../../../js/agents/jquery.js"></script>

</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<form name="myFORM" action="ag_details1.php?uid=<?=$uid?>" method=POST>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
			<td width="160">代理商:			<?
			echo $loginname;
			?></td>
            <td>
				<SELECT 
                  style="WIDTH: 50px" id=year class=lan name=year>
                  <? for($i=date("Y")-3;$i<=date("Y");$i++){ ?>
                  	<option value="<?= $i ?>" <? if($i==date("Y")){ ?>selected<? } ?>><?= $i ?></option>
                  <? } ?>
                  </SELECT> 年 <SELECT 
                  style="WIDTH: 40px" id=select class=lan name=mon>
                   <? for($i=1;$i<=12;$i++){ ?>
                  	<option value="<?= $i ?>" <? if($i==date("m")){ ?>selected<? } ?>><?= $i ?></option>
                  <? } ?>
                  </SELECT> 月 <SELECT 
                  style="WIDTH: 40px" id=dayDdl class=lan name=day>
                  <? for($i=1;$i<=31;$i++){ ?>
                  	<option value="<?= $i ?>" <? if($i==date("d")){ ?>selected<? } ?>><?= $i ?></option>
                  <? } ?>                  
                  </SELECT> 日
            </td>
            <td>-</td>
            <td>
<SELECT style="WIDTH: 50px" 
                  id=select8 class=lan name=year1>
                  <? for($i=date("Y")-3;$i<=date("Y");$i++){ ?>
                  	<option value="<?= $i ?>" <? if($i==date("Y")){ ?>selected<? } ?>><?= $i ?></option>
                  <? } ?>                  
                  </SELECT> 年 <SELECT 
                  style="WIDTH: 40px" id=select9 class=lan name=mon1>
                                     <? for($i=1;$i<=12;$i++){ ?>
                  	<option value="<?= $i ?>" <? if($i==date("m")){ ?>selected<? } ?>><?= $i ?></option>
                  <? } ?>
                  </SELECT> 月 <SELECT 
                  style="WIDTH: 40px" id=select10 class=lan name=day1>
                  <? for($i=1;$i<=31;$i++){ ?>
                  	<option value="<?= $i ?>" <? if($i==date("d")){ ?>selected<? } ?>><?= $i ?></option>
                  <? } ?>                   
                  </SELECT> 日 
            </td>
            <td>
              <input type="submit" id="submit" name="submit" value="查詢" class="za_button">
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

<table width="900" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab">
   <tr class="m_title">
      <td width="60">&nbsp;</td>
      <td width="76">會員賬號</td>
      <td width="94">沖值金額</td>
	  	<td width="86">有效金額</td>
	  	<td width="91">代理傭金</td>
      
    </tr>
    <tr class="m_cen">
      <td>統計</td>
      <td><?=$countmember ?>    /人</td>
      <td><?=$inpay ?></td>
      <td align="center"><?=$okpay ?></td>
	  	<td align="right"><font color="#ff3300">
      <?=$okpay*0.2 ?>    </font></td>

    </tr>
	<?
}
?>
</table>
</form>
</body>
</html>
<?
mysql_close();
?>
