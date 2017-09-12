<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
$news = null;
$db=new DB();
$text = $db->query("SELECT `g_text` FROM `g_news` WHERE `g_number_show` = 1 ORDER BY g_id DESC LIMIT 1 ", 0);
if ($text){
	$news = strip_tags($text[0][0]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
    <link type="text/css" rel="stylesheet" href="/templates/images/pagef/TopMenu.css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/templates/images/pagef/TopMenu.js"></script>
	<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="./js/sc.js"></script>
</head>
<body onselectstart="return false" oncut="return false" oncopy="return false" id="body_backdrop">
<table width="100%" height="108" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
    <td width="10%" valign="top">
<table width="100%" border="0">
  <tbody><tr>
    <td background="/templates/images/pagef/TopLogo_163.jpg" width="231" height="79" ><object width="231" height="79" id="top_c" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,22,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"><param value="transparent" name="wmode"><param value="/templates/images/pagef/lx.swf" name="movie"><param value="pageID=0" name="FlashVars"><param value="high" name="quality"><param value="false" name="menu"><embed width="231" height="79" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash" type="application/x-shockwave-flash" wmode="transparent" quality="high" name="top_c" src="/templates/images/pagef/lx.swf"></object>
	</td>
   </tr>
   <tr>
    <td><img width="231" height="29" src="/templates/images/pagef/TopMenu_Top2.jpg"></td>
  </tr>
</tbody></table>
	</td>
    <td width="90%" background="/templates/images/pagef/TopMenu_Top.jpg">
		<table width="100%" height="108" cellspacing="0" cellpadding="0" border="0">
		  <tbody><tr>
			<td height="43">
				<table width="916" cellspacing="0" cellpadding="0" border="0">
				  <tbody><tr>
					<td align="right"><a class="T_a" href="topMenu.php" target="mainFrame" title="信用資料">信用資料</a> | <a class="T_a"  href="upPwd.php" target="mainFrame" title="修改密碼">修改密碼</a> | <a class="T_a"  href="report.php" target="mainFrame" title="下注明細">下註明細</a> | <a class="T_a"  href="repore.php" target="mainFrame" title="結算報表">結算報表</a> | <a class="T_a"  href="result.php" target="mainFrame" title="歷史開獎">歷史開獎</a> | <a class="T_a"   href="/templates_r/rule.html" class="g" target="mainFrame" title="規則說明">規則</a> <!--| <a class="T_a"   href="kfzx.php" class="g" target="mainFrame" title="客服中心">客服中心</a> -->| <a style="color:#baff00"  href="quit.php" class="g" title="安全退出" target="_top">退出</a></td>
				  </tr>
				</tbody></table>
			</td>
		  </tr>
		  <tr>
			<td height="36">
<table width="1306" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
    <td width="1%" height="36"><img width="19" height="36" src="/templates/images/pagef/TopMenu_2Left.jpg"></td>
    <td width="64%"><input type="button" value="廣東快樂十分" style="cursor: hand;" onclick="SelectType(1);" name="bST_1" class="bST_1" id="bST_1"><input type="button" value="重慶時時彩" style="cursor: hand;" onclick="SelectType(2);" name="bST_2" class="bST_1" id="bST_2"><input type="button" value="北京赛车(PK10)" style="cursor: hand;" onclick="SelectType(6);" name="bST_6" class="bST_1" id="bST_6"><input type="button" value="幸运农场" style="cursor: hand;" onclick="SelectType(5);" name="bST_5" class="bST_1" id="bST_5"><input type="button" value="江苏骰寶(快3)" style="cursor: hand;" onclick="SelectType(7);" name="bST_7" class="bST_1" id="bST_7"></td>
    <td width="35%" align="right"></td>
  </tr>
</tbody></table>
			</td>
		  </tr>
		  <tr>
		  <td>
		  <table  border="0" cellspacing="0" class="kj">
		   <tr id="Type_List">

		  </tr>
		  </table>
		  
		  </td>
		  </tr>
		 
		</tbody></table>
	</td>
  </tr>
</tbody></table>
<script type="text/javascript">
SelectType(1);

</script>

</body></html>