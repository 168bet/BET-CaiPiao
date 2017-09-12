<?php
header("Content-type:text/html; charset=GB2312");
include '../config.php'; 

$billno = $_GET['billno'];
$amount = $_GET['amount'];
$mydate = $_GET['date'];
$succ = $_GET['succ'];
$msg = $_GET['msg'];
$attach = $_GET['attach'];
$ipsbillno = $_GET['ipsbillno'];
$retEncodeType = $_GET['retencodetype'];
$currency_type = $_GET['Currency_type'];
$signature = $_GET['signature'];

$content = 'billno'.$billno.'currencytype'.$currency_type.'amount'.$amount.'date'.$mydate.'succ'.$succ.'ipsbillno'.$ipsbillno.'retencodetype'.$retEncodeType;
$cert = 'GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ';
$signature_1ocal = md5($content . $cert);

if ($signature_1ocal == $signature){
$conn = mysql_connect($dbhost,$conf['db']['user'],$conf['db']['password']);
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbname,$conn);
mysql_query("SET NAMES UTF8");

$chaxun = mysql_query("SELECT state FROM ssc_order WHERE order_number = '".$billno."'");
$chaxun2 = mysql_query("select actionIP from ssc_member_recharge where rechargeid= '".$billno."'");
$actionIP = mysql_result($chaxun2,0);
$chaxun3 = mysql_query("select id from ssc_member_recharge where rechargeid= '".$billno."'");
$id = mysql_result($chaxun3,0);
$chaxun4 = mysql_query("select uid from ssc_member_recharge where rechargeid= '".$billno."'");
$uid = mysql_result($chaxun4,0);
$chaxun5 = mysql_query("select coin from ssc_members where uid= '".$uid."'");
$coin = mysql_result($chaxun5,0);
$chaxun6 = mysql_query("select value from ssc_params where name='czzs'");
$czzs = mysql_result($chaxun6,0);
if($czzs){
	$amount=$amount*(1+number_format($czzs/100,2,'.',''));
}
$inserts = "insert into ssc_coin_log (uid,type,playedId,coin,userCoin,fcoin,liqType,actionUID,actionTime,actionIP,info,extfield0,extfield1) values ('".$uid."',0,0,'".$amount."','".$coin."'+'".$amount."',0,1,0,UNIX_TIMESTAMP(),'".$actionIP."','环讯充值自动到账','".$id."','".$uid."')";
$update1 = "UPDATE ssc_order SET state = 2 WHERE order_number = '".$billno."'";
$update2 = "UPDATE ssc_members SET coin = coin+'".$amount."' WHERE username = '".$attach."'";
$update3 = "update ssc_member_recharge set state=1,rechargeTime=UNIX_TIMESTAMP(),rechargeAmount='".$amount."',coin='".$coin."',info='环讯充值自动到账' where rechargeid='".$billno."'";

$jiancha = mysql_result($chaxun,0);

if($jiancha==0){
	if ($succ == 'Y')
	{
                if(mysql_query($update1,$conn)){
                mysql_query($update2,$conn);
                mysql_query($update3,$conn);
                mysql_query($inserts,$conn);
                echo "您已成功充值，请重新登陆平台界面查看,谢谢!";
				}else{
					echo "数据投递出错";
				}
	    }else{
	       echo "交易失败";
             }
}else{
    echo "您已充值，请勿反复刷新,谢谢!";
}
}else{
	echo '签名不正确！';
	exit;
     }
mysql_close($conn);
?>
