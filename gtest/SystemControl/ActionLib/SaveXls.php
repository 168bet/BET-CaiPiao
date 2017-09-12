<?php   
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
header("Content-Type: text/html; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['xls'])
{
	
	$cPwd = $_POST['contents'];
	$cPwd=str_replace('\\','',$cPwd);
	$db = new DB();
	$sql = $cPwd;
	$db->query($sql, 1);
	$db->query($sql, 2);
}
else{
$tt=$_GET['type']==1? 'G':'U';
function downfile($fileurl)
{
$filename=$fileurl;
$tt=$_GET['type']==1? 'G':'U';
while(!file_exists($fileurl)){sleep(1000);}
$file   =   fopen($filename, "rb"); 
Header( "Content-type:   application/octet-stream "); 
Header( "Accept-Ranges:   bytes "); 

Header( "Content-Disposition:   attachment;   filename= ".$tt.time().".xls"); 


$contents = "";
while (!feof($file)) {
  $contents .= fread($file, 8192);
}
echo $contents;
fclose($file); 
@unlink($fileurl);  
}

$url=ROOT_PATH."xls/".$tt.".xls";
downfile($url);
}

 ?>