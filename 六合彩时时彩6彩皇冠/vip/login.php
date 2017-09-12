<?
session_start();
header ("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
require ("app/member/include/config.inc.php");
$sql = "select website,systime from web_system_data";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
if ($row['website']==1){
?>
<html>
<head>
<title>網站更新啟示</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
html, body {	text-align: center;	margin: 0px;	padding: 0px;	background-image: url(images/bg.gif);}
#info {	color: #30200A;	width: 466px;	text-align: left;	margin: 32px auto;	background: url(images/center.jpg) repeat-y 0 0;font: 0.75em Verdana, Arial, Helvetica, sans-serif;}
span {	background: url(images/top.gif) no-repeat 0 0;	width: 466px;	height:69px;	display: block;	margin: 0px;	padding: 0px;}
#main {	background: url(images/head.jpg) no-repeat 0 0;	padding-top: 25px;}
ul { margin:13px 45px 10px 60px; padding:0;}
li {	margin:10px 0px;	padding: 0;	list-style-image: url(images/icon.gif);}
#show {background: transparent url(images/foot.gif) no-repeat 0 bottom; display:block; color: #30200A; padding-bottom:1px;}
#help {margin: 0 45px;	padding: 0;}
p {	margin: 0px;	padding: 0px;}
#help a {margin: 35px 0 0 0 ;	padding: 10px 45px;background: url(images/help.jpg) no-repeat 0 0;	text-decoration: none;	display: block;}
a:link, a:visited {color: #C00;	}
a:hover {	color: #C60;	text-decoration: underline;}
marquee {	margin: 15px 45px 10px;	border: 1px solid #694719;	display: block;	background-color: #BDBDAC;	padding: 4px 2px 2px 2px;}
.ps {	font-size: 10px;	text-align: right; margin-bottom:35px; margin-right:45px;}
/*Mac fix*/
html>body #show {margin-top: 25px; padding-bottom:40px;}
html>body #help { margin:10px 45px;}
html>body marquee {
	margin: 15px 45px 5px;
	background-position: center;
}
html>body .ps {margin:10px 45px 0px 45px;}
/*~~~~~~~~~~~~~~~~~~~~~~~~~~ Baccarat AD~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
#ad { clear:both; margin:5px auto; height:42px; text-align:center; background: url(images/order_ad_ba.gif) no-repeat 50% 0;}
#ad a { display:block; width:220px; height:42px;}

-->
</style>
</head>

<body>
<div id="info">
  <span></span>
  <div id="main">
    <ul>
      <li>System is being renovated. Please forgive us if this make problems to you.</li>
      <li>本網站進行系統更新中，如有不便之處，敬請見諒 ！</li>
      <li>本网站进行系统更新中，如有不便之处，敬请见谅 ！</li>
    </ul>
    <div id="show">
	  <p id="help"><a href="http://639178056049.com">Cust.Service 服務中心</a></p>
	 

	  <marquee><?=$row[systime]?></marquee>
	  <div class="ps">System is being renovated</div>
	</div>
  </div>
</div>

</body>
</html>
<?
}else{
?>
<html>
<head>
<!--<title>Welcome</title>-->
<title>Welcome </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<script>
top.casino = 'SI2';
top.game_alert = '';
</script>
<frameset rows="*,0,0" frameborder="NO" border="0" framespacing="0"> 
<frame name="SI2_mem_index" src="app/member/login.php?username=<?=$_REQUEST['username'] ?>&password=<?=$_REQUEST['password'] ?>&langx=<?=$_REQUEST['langx'] ?>">
<frame name="SI2_func" scrolling="NO" noresize src="./ok.html">
<frame src="UntitledFrame-5"></frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
<?
}
mysql_close();
?>
