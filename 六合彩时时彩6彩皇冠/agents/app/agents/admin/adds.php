<script>if(self == top) parent.location='/'</script>
<?
require ("../../member/include/config.inc.php");
require ("gb_big5.php");
$message=$_POST['message'];
$message_tw=gb2big5($message);
$message_en=$_POST['message_en'];
$mdate=date('Y-m-d');
$level=4;
$mshow=1;
$uid=$_REQUEST["uid"];
$ntime=date("Y-m-d Hhi" ,time()); 
$sql="insert into web_marquee_data(ndate,message,message_tw,message_en,level,ntime,mshow) values('$mdate','$message','$message_tw','$message_en','$level','$ntime','$mshow')";
	$result=mysql_db_query($dbname,$sql);
if(!$result)
{
echo "找不到该查询";
}
else
{
	//开始
	$sql2 = "select admin from  web_system_data  where sysuid='$uid'";
$result2 = mysql_db_query($dbname,$sql2);
$row2 = mysql_fetch_array($result2);
if ($row2['admin']){
	
	$agname=$row2['admin'];
	$loginfo='添加历史信息';
}	$ip_addr = get_ip();
$mysql="insert into web_mem_log_data(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','2')";
mysql_db_query($dbname,$mysql);
//结束
echo "<script language='javascript'>{alert('添加成功');location.href='system.php';}</script>";
}
?>