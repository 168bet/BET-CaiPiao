<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "./include/address.mem.php";
require ("./include/config.inc.php");
include "./include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
$showtype=$_REQUEST['showtype'];
require ("include/traditional.$langx.inc.php");
$sql = "select UserName as uname,Pay_Type from web_member_data where oid='$uid' and status=0";
$result = mysql_db_query($dbname,$sql);
$row=mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$username=$row["uname"];
switch ($showtype){
case "future":
	$style='HBU';
	break;
default:
	$style='HBK';
	break;
}
$showtime = date("Y/m/d H:i:s");
$paysql = "select Address from web_payment_data where Switch=1";
$payresult = mysql_db_query($dbname,$paysql);
$payrow=mysql_fetch_array($payresult);
$address=$payrow['Address'];
?>
<html>
<head>
<title>welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_header<?=$css?>.css" type="text/css">
<SCRIPT language="JavaScript" src="/js/header.js"></SCRIPT>
</head>

<body id="<?=$style?>" onLoad="SetRB('BK','<?=$uid?>');onloaded();" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">

<div id="container">
	<input type="hidden" id="uid" name="uid" value="<?=$uid?>">
	<input type="hidden" id="langx" name="langx" value="<?=$langx?>">
	<div id="header"><span><h1></h1></span></div>
	<div id="nav">
		<ul class="level1">
	       <li class="early"><a href="#"><?=$Account_History?></a>
			  <ul class="level2">
			    <li class="tu"><a href="/app/member/history/history_data.php?uid=<?=$uid?>&langx=<?=$langx?>" target="body">足球帐户历史</a></li>
				<li class="bu"><a href="/app/member/six/index.php?action=l" target="body">六合帐户历史</a></li>
			    <!--li class="box1"><a class="bbox1"></a></li-->
		      </ul>
			 </li>  
	       <li class="early"><a href="#"><?=$Transaction_Record?></a>
			  <ul class="level2">
			    <li class="tu"><a href="/app/member/today/today_wagers.php?uid=<?=$uid?>&langx=<?=$langx?>" target="body">足球交易状况</a></li>
				<li class="bu"><a href="/app/member/six/index.php?action=h" target="body">六合交易状况</a></li>
			    <!--li class="box1"><a class="bbox1"></a></li-->
		      </ul>
			 </li>          
			<li class="ft"><a href="javascript:void(0);" onClick="chg_index('/app/member/FT_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.FT_lid_type,'SI2');"><?=$Soccer?></a></li>
			<li class="fu"><a href="javascript:void(0);" onClick="chg_index('/app/member/FT_index.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=3',parent.FU_lid_type,'SI2');"><?=$Soccer_Early?></a></li>
			<li class="op"><a href="javascript:void(0);" onClick="chg_index('/app/member/OP_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.OP_lid_type,'SI2');"><?=$Other?></a></li>
			<li class="om"><a href="javascript:void(0);" onClick="chg_index('/app/member/OP_index.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=3',parent.OM_lid_type,'SI2');"><?=$Other_Early?></a></li>
			<li class="tn"><a href="/app/member/TN_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3" target="SI2_mem_index"><?=$Tennis?></a></li>
			<li class="vb"><a href="/app/member/VB_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3" target="SI2_mem_index"><?=$VolleyBall?></a></li>
			<li class="bs"><a href="javascript:void(0);" onClick="chg_index('/app/member/BS_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BS_lid_type,'SI2');"><?=$BS?></a></li>
			<li class="bk"><a href="javascript:void(0);" onClick="chg_index('/app/member/BK_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BK_lid_type,'SI2');"><?=$BK_NFL?></a></li>
			<li class="early"><a href="#"><?=$Early?></a>
			  <ul class="level2">
			    <li class="tu"><a href="/app/member/TN_index.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=3" target="SI2_mem_index"><?=$TN_Early?></a></li>
			    <li class="vu"><a href="/app/member/VB_index.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=3" target="SI2_mem_index"><?=$VB_Early?></a></li>
			    <li class="be"><a href="javascript:void(0);" onClick="chg_index('/app/member/BS_index.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=3',parent.BSFU_lid_type,'SI2');"><?=$BS_Early?></a></li>
				<li class="bu"><a href="javascript:void(0);" onClick="chg_index('/app/member/BK_index.php?uid=<?=$uid?>&showtype=future&langx=<?=$langx?>&mtype=3',parent.BU_lid_type,'SI2');"><?=$BK_NFL_Early?></a></li>
			    <li class="box1"><a class="bbox1"></a></li>
		      </ul>
			</li>
	    <!--<li class="fs"><a href="/app/member/FT_index.php?uid=<?=$uid?>&showtype=fs&langx=<?=$langx?>&mtype=3" target="SI2_mem_index">冠军</a></li>-->
			<li class="fs"><a href="/app/member/FT_index.php?uid=<?=$uid?>&showtype=nfs&langx=<?=$langx?>&mtype=3" onClick="parent.sel_league='';parent.sel_area='';"target="SI2_mem_index"><?=$Outright?></a></li>
            <li class="six"><a href="/app/member/SIX_index.php?uid=<?=$uid?>&langx=<?=$langx?>" target="SI2_mem_index"><b>六合彩</b></a></li>
			<? if ($row['Pay_Type']==1){ ?>
	       <li class="his"><a href="javascript:void(0);" onClick="chg_type('<?=$address?>/register.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$username?>');">在线充值</a></li>
	       <li class="his"><a href="javascript:void(0);" onClick="chg_type('/app/member/YeePay/withdrawal.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$username?>');">在线提款</a></li>
	       <li class="his"><a href="javascript:void(0);" onClick="chg_type('/app/member/YeePay/record.php?uid=<?=$uid?>&langx=<?=$langx?>&username=<?=$username?>');">存款取款记录</a></li>
	       <? } ?>
		</ul>
	</div>

	<div id="type">
		<ul>
<?php
switch ($showtype){
case "":
?>
			<li class="all"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_browse/index.php?rtype=all&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BK_lid_type,'SI2');"><?=$Straight_All?></a></li>
			<li class="re"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_browse/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BK_lid_type,'SI2');"><?=$Straight?></a></li>
			<li class="qt"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_browse/index.php?rtype=rq4&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BK_lid_type,'SI2');"><?=$Quarter?></a></li>
			<li class="re"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BK_lid_type,'SI2');"><?=$Running_Ball?></a></li>
			<li class="hpa"><a href="/app/member/BK_browse/index.php?rtype=pr&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3" target="body"><?=$Handicap_Parlay?></a></li>
			<li><a href="/app/member/result/result.php?game_type=BK&uid=<?=$uid?>&langx=<?=$langx?>" target="body"><?=$Results?></a></li>
<?
break;
case "future":
?>	
			<li class="ertitle"><a><?=$BK_NFL_Early?> :</a></li>
			<li class="all"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_future/index.php?rtype=all&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BU_lid_type,'SI2');"><?=$Straight_All?></a></li>
			<li class="re"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_future/index.php?rtype=r&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BU_lid_type,'SI2');"><?=$Straight?></a></li>
			<li class="qt"><a href="javascript:void(0);" onClick="chg_type('/app/member/BK_future/index.php?rtype=rq4&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3',parent.BU_lid_type,'SI2');"><?=$Quarter?></a></li>
			<li class="hpa"><a href="/app/member/BK_future/index.php?rtype=pr&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3" target="body"><?=$Handicap_Parlay?></a></li>
<?	
break;
}
?>			
		</ul>
	</div>
</div>

<ul id="back">
	<li class="mem" onClick="OnMouseOverEvent();"><a href="#"><?=$Information?></a><span></span></li>
  <li class="home" onMouseOver="OnMouseOutEvent()"><a href="/app/member/logout.php?uid=<?=$uid?>&langx=<?=$langx?>" target="_top"><?=$LogOut?></a><span></span></li>
  <li class="est" onMouseOver="OnMouseOutEvent()"><div class="est2"><?=$Est?></div>
     <div class="time"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="55" height="15" id="ESTime">
<param name="movie" value="../../images/member/ESTime.swf"param name="quality" value="high">
        <embed src="../../images/member/ESTime.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="55" height="15"></embed>
    </object></div>
  </li>
</ul>
	<div class="info" id="informaction" onMouseOver="OnMouseOverEvent()">
		<table border="0" cellpadding="0" cellspacing="0" id="mose" onMouseOut="OnMouseOutEvent();">
			<tr>
				<td><a href="#"><font id="chg_pwd" onClick="Go_Chg_pass();" style="cursor:hand">&bull;&nbsp; <?=$Edit_Password?></font></a></td>
				<td ><a href="/tpl/member/<?=$langx?>/roul_new/roul.html" target="_blank">&bull;&nbsp; <?=$Rules?></a></td>
                <td><a href="/tpl/member/<?=$langx?>/virus_site01.html" target="_blank">&bull;&nbsp; <?=$Antivirus?></a></td>
			</tr>
			<tr>
				<td><a href="/app/member/account/mem_data.php?uid=<?=$uid?>&langx=<?=$langx?>" target="body">&bull;&nbsp; <?=$Data?></a></td> <td><a href="/tpl/member/<?=$langx?>/roul_mp.html" target="_blank">&bull;&nbsp; <?=$Wap?></a></td>
                <td><a href="javascript://" onClick="javascript: window.open('/tpl/member/<?=$langx?>/way.html','','menubar=no,status=yes,scrollbars=no,top=150,left=200,toolbar=no,width=540,height=510')">&bull;&nbsp; <?=$Odds_Conversion?></a></td>
			</tr>
			<tr id="QA_row">
				<td><a href="http://122.146.29.39" target="_blank">&bull;&nbsp; <?=$Saft_internet?></a></td>
				<td><a href="http://639178056049.com" target="_blank">&bull;&nbsp; <?=$Cust_Service?></a></td>
                 <td>&nbsp;</td>
			</tr>
		</table>
	</div>


</noscript><div id="extra1" style="display: none"><span><a href="/app/member/BK_browse/index.php?rtype=re&uid=<?=$uid?>&langx=<?=$langx?>&mtype=3" target="body"><?=$Running_Ball?></a></span></div>
<div id="download" ><span><a href="#"><font style="cursor:hand">Vworld安装</font></a></span></div>
<div id="live"><span><a href="#"><font onClick="OpenLive();" style="cursor:hand"><?=$Live_TV?></font></a></span></div>
<div id="extra2"><a href="http://ba566_mem.cvssp.com/app/member/mem_add.php?langx=<?=$langx?>" target="_blank"></a></div>
<!--favorite----->
<div id="LIKE">
<table  border="0" cellspacing="0" cellpadding="0">
<tr>
	<td onMouseOver="mouseEnter_pointer('imp_FT');" onMouseOut="mouseOut_pointer('imp_FT');">
		<div class="Xbut"><img id='imp_FT' src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('FT');" style="cursor:hand;display: none"></div>
		<img id="img_FT" onClick="chkLookGtypeShowLoveI('/app/member/FT_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3','FT');" style="cursor:hand">
	</td>
	<td onMouseOver="mouseEnter_pointer('imp_BK');" onMouseOut="mouseOut_pointer('imp_BK');">
		<div class="Xbut"><img id='imp_BK' src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('BK');" style="cursor:hand;display: none"></div>
		<img id="img_BK" onClick="chkLookGtypeShowLoveI('/app/member/BK_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3','BK');" style="cursor:hand">
	</td>
	<td onMouseOver="mouseEnter_pointer('imp_BS');" onMouseOut="mouseOut_pointer('imp_BS');">
		<div class="Xbut"><img id='imp_BS' src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('BS');" style="cursor:hand;display: none"></div>
		<img id="img_BS" onClick="chkLookGtypeShowLoveI('/app/member/BS_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3','BS');" style="cursor:hand">
	</td>
	<td onMouseOver="mouseEnter_pointer('imp_TN');" onMouseOut="mouseOut_pointer('imp_TN');">
		<div class="Xbut"><img id='imp_TN' src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('TN');" style="cursor:hand;display: none"></div>
		<img id="img_TN" onClick="chkLookGtypeShowLoveI('/app/member/TN_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3','TN');" style="cursor:hand">
	</td>
	<td onMouseOver="mouseEnter_pointer('imp_VB');" onMouseOut="mouseOut_pointer('imp_VB');">
		<div class="Xbut"><img id='imp_VB' src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('VB');" style="cursor:hand;display: none"></div>
		<img id="img_VB" onClick="chkLookGtypeShowLoveI('/app/member/VB_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3','VB');" style="cursor:hand">
	</td>
	<td onMouseOver="mouseEnter_pointer('imp_OP');" onMouseOut="mouseOut_pointer('imp_OP');">
		<div class="Xbut"><img id='imp_OP' src="../../../images/member/icon_X.gif" onClick="chkDelAllShowLoveI('OP');" style="cursor:hand;display: none"></div>
		<img id="img_OP" onClick="chkLookGtypeShowLoveI('/app/member/OP_index.php?uid=<?=$uid?>&langx=<?=$langx?>&mtype=3','OP');" style="cursor:hand">
	</td>
</tr>
</table>
</div>
<iframe id=reloadPHP name=reloadPHP  width=0 height=0></iframe>
</body>
</html>
