<?
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
require ("app/agents/include/config.inc.php");
session_destroy();

$sql = "select Website,Agent_Url,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);

$agent_url=explode(";",$row['Agent_Url']);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
	$index='/app/agents/ball-manage.php';
}else if (in_array($_SERVER['SERVER_NAME'],array($agent_url[0],$agent_url[1],$agent_url[2],$agent_url[3]))){
	if ($row['Website']==0){
	    $index='/app/agents/ball-agents.php';
    }else{
	    $index='/upup/upup.php';
    }
}

?>
<html>
<head>
<title>WELCOME</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="*,0" frameborder="NO" border="0" framespacing="0"> 
<frame name="bb_mem_index" src=<?=$index?>>
<frame name="bb_func" scrolling="NO" noresize src="ok.php">
</frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
