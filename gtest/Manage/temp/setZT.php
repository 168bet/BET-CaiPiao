<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';



function upDateRankLock($db, $result, $l, $lock, $p=0){
	if ($p==1){
		$from = "g_user";
		//$l = "g_look";
	} else if($p==2){
		$from = "g_rank";
		//$l = "g_lock";
	}else{
		$from = "g_relation_user";
	}
	for ($i=0; $i<count($result); $i++){
		if($p==0){
		$db->query("UPDATE `{$from}` SET `{$l}` = '{$lock}' WHERE g_s_name = '{$result[$i]['g_s_name']}' ",2);
		}else{
		$db->query("UPDATE `{$from}` SET `{$l}` = '{$lock}' WHERE g_name = '{$result[$i]['g_name']}' ",2);
		}
	}
}



	$uid=$_POST['uid'];
	$type=$_POST['type'];
	$utype=$_POST['utype'];
	$isre=0;
	$db=new DB();
	if($utype=='1'){
	$utname='g_rank';
	$uziduan='g_lock';
	$g_name='g_name';
	}
	else if($utype=='2'){
	$utname='g_user';
	$uziduan='g_look';
	$g_name='g_name';
	$isre=2;
	}
	else{
	$utname='g_relation_user';
	$uziduan='g_lock';
	$g_name='g_s_name';
	$isre=1;
	}
	
	$sql = "update {$utname} set {$uziduan}={$type} where {$g_name}='{$uid}'";
	$db->query($sql, 2);
	
	if($isre==0){
	$sql="SELECT g_name, g_nid FROM g_rank WHERE  g_name = '{$uid}' ";
	$userResult = $db->query($sql, 1);
	
	$sql="SELECT g_name, g_lock FROM g_rank WHERE g_nid LIKE '{$userResult[0]['g_nid']}%' AND g_name <> '{$userResult[0]['g_name']}' ";
	$result = $db->query($sql, 1);
	upDateRankLock($db, $result,'g_lock', $type, 2);
	$sql="SELECT g_name, g_look FROM g_user WHERE g_nid LIKE '{$userResult[0]['g_nid']}%' ";
	$results = $db->query($sql, 1);
	upDateRankLock($db, $results, 'g_look',$type, 1);
	
	
	$sql="SELECT g_s_name, g_lock FROM g_relation_user WHERE g_s_nid LIKE '{$userResult[0]['g_nid']}%'  ";
	$result = $db->query($sql, 1);
	upDateRankLock($db, $result,'g_lock', $type, 0);
	}
	
	
	if($type==1) 
	echo '啟用';
	if($type==2)
	echo '凍結';
	if($type==3)
	echo '停用';
?>