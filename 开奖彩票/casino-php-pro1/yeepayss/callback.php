<?php

include '../config.php';
include 'yeepayCommon.php';

$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);

if($bRet){
$conn = mysql_connect($dbhost,$conf['db']['user'],$conf['db']['password']);
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbname,$conn);
mysql_query("SET NAMES UTF8");

$chaxun = mysql_query("SELECT state FROM ssc_order WHERE order_number = '".$r6_Order."'");
$jiancha = mysql_result($chaxun,0);
$chaxun2 = mysql_query("select actionIP from ssc_member_recharge where rechargeid= '".$r6_Order."'");
$actionIP = mysql_result($chaxun2,0);
$chaxun3 = mysql_query("select id from ssc_member_recharge where rechargeid= '".$r6_Order."'");
$id = mysql_result($chaxun3,0);
$chaxun4 = mysql_query("select uid from ssc_member_recharge where rechargeid= '".$r6_Order."'");
$uid = mysql_result($chaxun4,0);
$chaxun5 = mysql_query("select coin from ssc_members where uid= '".$uid."'");
$coin = mysql_result($chaxun5,0);
$chaxun6 = mysql_query("select value from ssc_params where name='czzs'");
$czzs = mysql_result($chaxun6,0);
if($czzs){
	$r3_Amt=$r3_Amt*(1+number_format($czzs/100,2,'.',''));
}
$inserts = "insert into ssc_coin_log (uid,type,playedId,coin,userCoin,fcoin,liqType,actionUID,actionTime,actionIP,info,extfield0,extfield1) values ('".$uid."',0,0,'".$r3_Amt."','".$coin."'+'".$r3_Amt."',0,1,0,UNIX_TIMESTAMP(),'".$actionIP."','在线支付自动到账','".$id."','".$uid."')";
$update1 = "UPDATE ssc_order SET state = 2 WHERE order_number = '".$r6_Order."'";
$update2 = "UPDATE ssc_members SET coin = coin+'".$r3_Amt."' WHERE username = '".$r8_MP."'";
$update3 = "update ssc_member_recharge set state=2,rechargeTime=UNIX_TIMESTAMP(),rechargeAmount='".$r3_Amt."',coin='".$coin."', info='在线支付自动到账' where rechargeid='".$r6_Order."'";

if($jiancha==0){
	   if($r1_Code==1){
                if(mysql_query($update1,$conn)){
                mysql_query($update2,$conn);
                mysql_query($update3,$conn);
                mysql_query($inserts,$conn);
				echo 'success';
                echo "您已成功充值，请重新登陆平台界面查看,谢谢!";
				}else{
					echo "数据投递出错";
				}
	    }else{
	       echo "交易信息被篡改";
        }
}else{
    echo "您已充值，请勿反复刷新,谢谢!";
	exit;
}
}
mysql_close($conn);
?>
