<?
require ("./include/config.inc.php");
$gtype=$_REQUEST['gtype'];
$uid=$_REQUEST['uid'];
$m_date=date('Y-m-d');
$sql="select RB_Show from match_sports where Type='".$gtype."' and `M_Start` < now( ) and `M_Date` ='".$m_date."' and RB_Show=1";
$result=mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<script>
parent.showLayer(<?=$cou?>);
</script>