<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
?>
<script language="javascript"> 
<!-- 
/*屏蔽所有的js??*/ 
function killerrors() { 
return true; 
} 
window.onerror = killerrors; 
//--> 
</script> 
<script>//if(self == top) parent.location='/'
</script>
<?
if($_GET['act']=='delall') {
	unset($_SESSION['notice_idstic']);
	echo "<script>history.go(-1);</script>";
	exit();
}

require ("../../agents/include/config.inc.php");
require ("../../agents/include/define_function_list.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];

$sql = "select ID,Level,UserName,SubUser,SubName from web_system_data where Oid='$uid' and LoginName='$loginname'";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agid=$row['ID'];


if($_POST['submit']) {
	if(!strlen($_POST['title']) || !strlen($_POST['content'])) {
		echo "<script>alert('請填寫標題和內容');</script>";
	}else {
		$mysql="insert into web_notices(title,content,addtime,type,addpople,reply_id) values ('".$_POST['title']."','".$_POST['content']."','".time()."','".$_POST['type']."','".$agid."',0)";
		mysql_query($mysql) or die ("數據庫錯誤!");
		
		
		if($_POST['type'] == 2 && !empty($_POST['ids'])) {
			$re = mysql_query("select last_insert_id()");
			$re1= mysql_fetch_array($re);
			
			foreach ($_POST['ids'] as $v) {
				$mysql="insert into web_notices_to(notice_id,notice_to) values ('".$re1[0]."','".$v."')";
				$re = mysql_query($mysql);
				unset($_SESSION['notice_idstic']);
			}
		}
		$msg = "<script>alert('操作成功');</script>";

	}
}

?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<script language="javascript"  src="../../../js/agents/jquery.js"></script>
<style type="text/css">
<!--
.m_mem_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<?=$msg?>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="">
<div id="Layer1" style="position:absolute; width:780px; height:26px; z-index:1; left: 0px; top: 268px; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000"></div>
 <FORM NAME="myFORM" ACTION="notice_send.php?uid=<?=$uid?>&mtype=<?=$mtype?>&langx=<?=$langx?>" METHOD=POST >

  <input type="hidden" name="uid" value="<?=$uid?>">

  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
                
            <td>
              
              <?
              if(!empty($_SESSION['notice_idstic'])) {
              	
              	$str = '<h3>發送會員名單</h3><input name=\'type\' value=\'2\' type=\'hidden\'/><table  width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed"><tr bgcolor="#6FB5DF"><td style="border-bottom:1px ">會員名稱</td><td >會員帳號</td><td></td></tr>';
              	
              	
              	$whe =  "  in (".implode(',',$_SESSION['notice_idstic']).") ";
              	$sql = "select ID,UserName,PassWord,Alias,Money,ratio,date_format(AddDate,'%m-%d / %H:%i') as AddDate,pay_type,Agents,OpenType from web_member_data where ID $whe";
              	$result = mysql_query( $sql);
              	//$cou=mysql_num_rows($result);
              	//echo $cou;
              	while ($row = mysql_fetch_array($result)){
              		$str .="<tr><td style='border-bottom:1px dashed #CCCCCC'>".$row['Alias']."&nbsp;</td><td  style='border-bottom:1px dashed #CCCCCC'>".$row['UserName']."</td><td style='border-bottom:1px dashed #CCCCCC;text-align:center'><input name='ids[]' id='del_".$row['ID']."' type='hidden' value='".$row['ID']."'/><input name='d' type='button' onclick=\"$(this).parent().parent().remove();\" value='刪除'/></td></tr>";
              	}
              	$str .= "</table>";
              	echo $str;
             // }else {
             //   echo "<h3>發送公告</h3><input name='type' value='1' type='hidden'/>";
              }
              ?>
              
             
	       </td>
      
</tr>
<?
include("fckeditor/fckeditor.php") ;
?>
<tr><td height="30">標題 <input name="title" type="text" value="<?=$_POST['title']?>" size="50"/></td></tr>
<tr><td align="left" valign="top" height="150">內容 
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$sBasePath = $_SERVER['PHP_SELF'] ;

$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "notice_send.php" ) ).'fckeditor/' ;

$oFCKeditor = new FCKeditor('content') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Value		= $_POST['content'] ;
$oFCKeditor->Create() ;
?>
</td></tr>
<tr><td><br><input name="submit" value="發送" type="submit"/></td></tr>

  </table>
</form>

</body>
</html>
<?

mysql_close();
?>
