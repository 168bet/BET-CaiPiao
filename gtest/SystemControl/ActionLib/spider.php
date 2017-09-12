<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
	include_once ROOT_PATH.'Manage/ExistUser.php';
	global $Users;
	$db=new DB();
	$mid = 1;
	
	if ($mid == 1)
	{
		//加載賠率
		$h=null;
		for ($i=1; $i<=15; $i++){$h .="h{$i},";}
		$h = mb_substr($h, 0, mb_strlen($h)-1);
		$sql = "SELECT1  {$h} FROM g_odds7_default WHERE g_type = 'Ball_l_p' OR g_type = 'Ball_d_p' ORDER BY g_id ASC  ";
		$result = $db->query($sql, 1);
		$arr = showList($db, $result);
		$arr = json_encode($arr);
		echo <<<JSON
					{
						"oddsList" : $arr
					}
JSON;
	}
	
	function showList($db, $result)
{
	$a = array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'e',5=>'f',6=>'g',7=>'h');
	$arr = array();
	for ($s=0; $s<15; $s++){
		for ($i=0; $i<count($result); $i++){
			$n=$s+1;
			$arr[$s][$a[$i].'h'.$n] = $result[$i]['h'.($s+1)];
		}
	}
	return $arr;
}
?>