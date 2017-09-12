<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}
set_time_limit(0);
session_start();

$_SESSION['fsave'] = "";
if ( isset( $_FILES['uppic'] ) )
{
        $path = "backup/";
		$file = $_FILES['uppic']['name'];
		
        //$filename=$_GET['filename'];//恢复的源文件
		$filepathname = $path.$file;
		
		if (copy($_FILES['uppic']['tmp_name'], $filepathname)){
		    
        $msgstr='';    
        $fp = @fopen($filepathname, "r");    
        if ($fp) { 
        while (!feof($fp)) {    
             $mysql = fgets($fp); 
			 //echo $mysql;   
             if(strlen($mysql)>3) {    
             if(!mysql_query($mysql))    
                $msgstr.="下面语句执行错误：<br>".$mysql."<br>";    
             }    
        }    
        fclose($fp);    
        $msgstr.=$filepathname." 导入完成";    
        } else {    
        $msgstr.=$filepathname." 文件打开失败";   
        }} else {$msgstr.=$filepathname." 文件上传失败";}
		echo $msgstr;
		echo "<script>alert('".$msgstr."');window.location='index.php?action=xt_bak';</script>";
		/*$fdir = "backup/";
		$filename = $_FILES['uppic']['name'];
		$ftype = strrchr( $filename, "." );
		$newname = "tems.html";
		$fpath = "{$fdir}".$newname;
		if ( $ftype != ".rar" )
		{
				echo "<script language='javascript'>alert('格式必须是rar的备份文件!');window.location='index.php?action=xt_bak';</script>";
		}
		else if ( copy( $_FILES['uppic']['tmp_name'], $fpath ) )
		{
				$rtable = array( "ka_tan","ka_bl");
				$i = 0;
				for ( ;	$i < count( $rtable );	++$i	)
				{
						//mysql_query( "delete from {$rtable[$i]}", $conn );
				}
				include( "{$fpath}" );
				unlink( $fpath );
				echo "<script language='javascript'>alert('还原成功!');window.location='index.php?action=xt_bak';</script>";
		}*/
}




?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
}
.style2 {color: #FFFF00}
-->
</style>
 <script language="javascript">
function fs()
{
 myform.fsubmit.value="正在还原数据,请稍等..";
 myform.fsubmit.disabled=true;
  myform.submit();
}
      </script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style>

<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
</head>
 <body> <meta http-equiv="Content-Type" content="text/html; charset=gb2312">


 
<table width="100%" height="91" border="0" align="center" cellpadding="0" cellspacing="0" class="tmove">
  <tr>
    <td height="91" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr class="tbtitle">
        <td width="51%"><? require_once '2top.php';?></td>
      </tr>
      <tr >
        <td height="5"></td>
      </tr>
    </table>
	 <? if (strpos($_SESSION['flag'],'10') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}?>
    <table width="99%" height="127" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="f1f1f1" class="t17">
      <tr class="t11">
        <td height="22" bordercolor="cccccc" bgcolor="#FDF4CA">数据还原</td>
        </tr>
      <tr>
        <td bordercolor="cccccc"><table width="291" height="59" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" nowrap> <form action="index.php?action=xt_bak&act=yes" method="post" enctype="multipart/form-data" name="myform" >选择备份文件:<input name="uppic" type="file" size="30">
              <input type="submit" name="fsubmit" value=" 恢复 " onClick="fs()">
            </form>
			   </td>
          </tr>
        </table> 
          </td>
        </tr>
    </table></td>
  </tr>
</table><div id="Layer1" style="position:absolute; left:387px; top:73px; width:223px; height:50px; z-index:1;display:none">
  <table width="223" height="50" border="0" cellpadding="0" cellspacing="0" bordercolor="#999999">
    <tr>
      <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>


