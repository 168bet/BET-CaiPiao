<?php

include 'conf.php';
include 'fmSign.php';
writeLog('notify');
$command = isset($GLOBALS['HTTP_RAW_POST_DATA']) ?$GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
$map = json_decode($command,TRUE);
writeLog($command);
foreach(@$map as $k=>$v){
$abcss .= "&{$k}={$v}";
}
writeLog($abcss);
$sign_fields = array("merchantCode","instructCode","transType","outOrderId","transTime","totalAmount");
$s = new Sign();
$sign = $s->sign_mac($sign_fields,$map,$md5Key);
$sign = strtoupper($sign);
$reqSign = $map["sign"];
if($sign === $reqSign) {
writeLog('ok');
$rechargeid = $map['outOrderId'];
$Amount = $map['totalAmount']/100;
if ($rechargeid>0){
$conn = mysql_connect($dbHost,$conf['db']['user'],$conf['db']['password']);
if (!$conn){
die('Could not connect: '.mysql_error());
}
mysql_select_db($baseName,$conn);
mysql_query("SET names '".$conf['db']['charset']."'");
$query = mysql_query("select * from ssc_member_recharge where rechargeid= '".$rechargeid."'");
$recharge = mysql_fetch_assoc($query);
if($recharge['state']<1){
mysql_query("UPDATE ssc_member_recharge SET state=1,rechargeTime=UNIX_TIMESTAMP(),rechargeAmount='".$Amount."',coin='".$user['coin']."', info='在线自动充值' where rechargeid='".$rechargeid."'");
$query = mysql_query("select * from ssc_members where uid= '".$recharge['uid']."'");
$user  = mysql_fetch_assoc($query);
if ($user){
$query = mysql_query("select * from ssc_coin_log where uid=".$recharge['uid']." AND extfield0='".$recharge['id']."' AND extfield1='".$rechargeid."'");
if (!mysql_fetch_assoc($query)){
$sql = "INSERT INTO ssc_coin_log (uid,type,playedId,coin,userCoin,fcoin,liqType,actionUID,actionTime,actionIP,info,extfield0,extfield1) VALUES ('".$recharge['uid']."',0,0,'".$Amount."','".$user['coin']."'+'".$Amount."',0,1,0,UNIX_TIMESTAMP(),'".$recharge['actionIP']."','在线自动充值','".$recharge['id']."','".$rechargeid."')";
mysql_query($sql);
mysql_query("UPDATE ssc_members SET coin = coin+'".$Amount."' WHERE uid = '".$recharge['uid']."'");
}
}
}
@mysql_close($conn);
}
echo "{'code':'00'}";
}else {
writeLog('err');
echo "{'code':'01'}";
}
function writeLog($str){
$fp = fopen("log.txt","a");
flock($fp,LOCK_EX);
fwrite($fp,$str ." Time: ".date("Y-m-d h:i:s")."\r\n==============================\r\n");
flock($fp,LOCK_UN);
fclose($fp);
}
?>