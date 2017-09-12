<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "include/address.mem.php";
require ("include/config.inc.php");
$str   = time();
$uid   = $_REQUEST['uid'];
$langx = $_REQUEST['langx'];
if ($langx==''){
	$langx="zh-cn";	
}

if($uid=='' || $userid==0){
	$sql = "SELECT * FROM `web_member_data` WHERE id=0 ";
	//echo $sql;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['Oid']=='' || empty($row['Oid']) || $row['Oid']=='logout'){
	    $str = time('s');
	    $uid=strtolower(substr(md5($str),0,10).substr(md5($username),0,10).'ra'.rand(0,9));
	    $ip_addr=get_ip();
	    $credit=$row['Credit'];
		$money=$
	    $date=date("Y-m-d");
	    $todaydate=strtotime(date("Y-m-d"));
	    $editdate=strtotime($row['EditDate']);
	    $time=($todaydate-$editdate)/86400;
		$datetime=strtotime(date("Y-m-d H:i:s"));
		$onlinetime=strtotime($row['OnlineTime']);
		if ($datetime-$onlinetime>1){
			if ($row['LoginDate']!=$date and $row['Pay_Type']==0){//判断是现金投注还是信用额度投注，若是现金不回归额度。若是信用回归额度
			   $sql="update web_member_data set Oid='$uid',LoginDate='$date', Money='$credit',LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where id=0 and Status<=1";
			}else{
			   $sql="update web_member_data set Oid='$uid',LoginDate='$date', LoginTime=now(),OnlineTime=now(),Online=1,LoginIP='$ip_addr',Language='$langx',Url='".BROWSER_IP."' where id=0 and Status<=1";
			}		
			   mysql_query($sql) or die ("error!");
		}
	}else{
		$uid=$row['Oid'];
	}
}

if($userid>0){
$sql = "select * from web_member_data where Oid='$uid' and Status<=1";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$Status=$row['Status'];

if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
	$mid=$row['ID'];
	$memname=$row['UserName'];
	
	$loginname=$row['LoginName'];
	$langx=$row['Language'];
	$logindate=date("Y-m-d");
	$datetime=date('Y-m-d h:i:s');
	if ($row['LoginDate']!=$logindate){
		$credit=$row['Credit'];
		$sql="update web_member_data set LoginTime='$datetime', Money='$credit' where UserName='$memname' and Pay_Type=0";
		mysql_query($sql) or die ("error!");
	}else{
		$credit=$row['Money'];
	}
}

}
$paysql = "select Address from web_payment_data where Switch=1";
$payresult = mysql_query($paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];
?>
<HTML>
<HEAD>
<TITLE>welcome</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<STYLE type=text/css>
BODY {
    FONT-SIZE: 12px;
    BACKGROUND: #fcfcf3;
    margin-left:10px;
    margin-top: 10px;
}
.imgBox {width:754px; height:250px;padding:9px;border:1px solid #c4c6c6;background:#d8d7d7}
</STYLE>
<script>if(self == top) parent.location='/'</script>

<script language="Javascript">
function chg_type(a,b,c){
    if(top.swShowLoveI)b=3;
    parent.body.location=a;
}
function be_login(){
	alert('您必需登陆后才能执行此操作！');
	//return false;	
}
<!--
document.oncontextmenu=new Function("event.returnValue=false");
document.onselectstart=new Function("event.returnValue=false");
-->
</script> 
</HEAD>
<BODY>
<table width="753" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="753" height="38" valign="top"><img src="/images/506x38xboy_01.jpg.pagespeed.ic.pXea3vFbH3(1).gif" width="752" height="38"></td>
  </tr>
  <tr>
    <td width="740" height="207"><span class="imgBox">
      <object  width="732" height="247" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://download.macromedia.com
/pub/shockwave/cabs/flash/swflash.cab#4,0,0,0">
        <param name="SRC" value="banner.swf">
        <param name="&lt;paramname=&quot;WMODE&quot;value=&quot;transparent&quot;&gt;" value="">
		<param name="WMODE" value="transparent">
        <embed src="./pics/boli/banner.swf" height="247" ><paramname="wmode"value="transparent">      
        ="">
      </object>
    </span></td>
  </tr>
  <tr>
    <td height="34" valign="top"><img src="/images/506x34xboy_02.jpg.pagespeed.ic.Vu2JXR4Als(3).gif" width="752" height="34"></td>
  </tr>
  <tr>
    <td height="160" colspan="2" valign="bottom">
    <table width="753" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCcCC" style="padding:5px 0px">
      <tr>
        <td><a href="http://www.hgylc.com/app/member/six/index.php?action=k_tm&league_id=undefined" target="body"><img src="/images/SMIMG_033.jpg" border=0></a></td>
		<td><a href="/app/member/FT_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3&showtype=3" target="body"><img src="/images/SMIMG_05.jpg" border=0></a></td>
		<td><a href="http://83suncity.cm/game.aspx" target="body"><img src="/images/SMIMG_07.jpg" border=0></a></td>
      </tr>
    </table></td>
  </tr>
</table><!-- Live800默认跟踪代码: 开始-->
<script language="javascript" src="http://kf1.learnsaas.com/chat/chatClient/monitor.js?jid=2822001676&companyID=154310&configID=38715&codeType=custom"></script>
<!-- Live800默认跟踪代码: 结束-->
</BODY>
</HTML>
