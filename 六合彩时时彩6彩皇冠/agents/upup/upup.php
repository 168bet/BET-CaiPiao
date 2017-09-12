<?
require ("../app/agents/include/config.inc.php");
$sql = "select website,systime from web_system_data";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
if ($row['website']==0){
	echo "<script>window.open('/ok.php','_top')</script>";
}

?>
<html>
<head>
<title>網站更新啟示</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="note.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
<tr>
<td align="center"> 
<table width="466" border="0" cellpadding="0" cellspacing="0" background="up_images/top02.jpg">
    <tr>
      <td width="13"><img src="up_images/top01.gif"></td>
      <td class="title">網站更新啟示</td>
      <td width="16" align="right"><img src="up_images/top03.gif"></td>
    </tr>
  </table>
  <table width="466" border="0" cellpadding="0" cellspacing="0" class="tab">
    <tr>
      <td align="center"><table width="90%"  border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td><ul>
            <li>System is being renovated. Please forgive us if this make problems to you.</li>
            <li>本網站進行系統更新中，如有不便之處，敬請見諒 ！</li>
            <li>本网站进行系统更新中，如有不便之处，敬请见谅 ！</li>
            </ul></td>
        </tr>
      </table>
        </td>
      </tr>
  </table>
  <table width="466" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="125"><img src="up_images/logo_01.jpg"></td>
      <td align="center" background="up_images/tab_bg.jpg">System is being renovated
        <!--<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="51" height="12">
<param name=movie value="images/02.swf">
<param name=quality value=high>
<embed src="up_images/02.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="51" height="12">
</embed> 
</object>--></td>
      <td width="6"><img src="up_images/tab_01.jpg" width="6" height="41"></td>
    </tr>
  </table>
  
  <table width="466" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="446" height="33" align="center" valign="top" background="up_images/logo_02.gif">
	  <!--跑馬登table-->
	  <table width="420" height="26" border="0" class="ad">
        <tr>
          <td><marquee scrolldelay="200" onMouseOver='this.stop()' onMouseOut='this.start()'><?=$row['systime']?></marquee></td>
        </tr>
      </table>
	  <!--跑馬登table-->
	  </td>
    </tr>
  </table>
  </td>
</tr>
</table>
</body>
</html>
