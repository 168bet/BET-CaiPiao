<?php

$return = getCallBackValue($args[0]['r0_Cmd'],$args[0]['$r1_Code'],$args[0]['$r2_TrxId'],$args[0]['$r3_Amt'],$args[0]['$r4_Cur'],$args[0]['$r5_Pid'],$args[0]['$r6_Order'],$args[0]['$r7_Uid'],$args[0]['$r8_MP'],$args[0]['$r9_BType'],$args[0]['$hmac']);
$bRet = CheckHmac($args[0]['r0_Cmd'],$args[0]['$r1_Code'],$args[0]['$r2_TrxId'],$args[0]['$r3_Amt'],$args[0]['$r4_Cur'],$args[0]['$r5_Pid'],$args[0]['$r6_Order'],$args[0]['$r7_Uid'],$args[0]['$r8_MP'],$args[0]['$r9_BType'],$args[0]['$hmac']);

if($bRet){
$chaxun = "SELECT state FROM ssc_order WHERE order_number =?";
$jiancha = $this->getvalue($chaxun,$args[0]['$r6_Order']);
$chaxun2 = "select actionIP from ssc_member_recharge where rechargeid=?";
$actionIP = $this->getvalue($chaxun2,$args[0]['$r6_Order']);
$chaxun3 = "select id from ssc_member_recharge where rechargeid=?";
$id = $this->getvalue($chaxun3,$args[0]['$r6_Order']);
$chaxun4 = "select uid from ssc_member_recharge where rechargeid=?");
$uid = $this->getvalue($chaxun4,$args[0]['$r6_Order']);
$chaxun5 = "select coin from ssc_members where uid=?";
$coin = $this->getvalue($chaxun5,$uid);
$inserts = "insert into ssc_coin_log (uid,type,playedId,coin,userCoin,fcoin,liqType,actionUID,actionTime,actionIP,info,extfield0,extfield1) values ('".$uid."',0,0,'".$args[0]['$r3_Amt']."','".$coin."'+'".$args[0]['$r3_Amt']."',0,1,0,UNIX_TIMESTAMP(),'".$actionIP."','易宝充值自动到账','".$id."','".$uid."')";
$update1 = "UPDATE ssc_order SET state = 1 WHERE order_number =?";
$update2 = "UPDATE ssc_members SET coin = coin+'".$args[0]['$r3_Amt']."' WHERE username =?";
$update3 = "update ssc_member_recharge set state=1,rechargeTime=UNIX_TIMESTAMP(),rechargeAmount='".$args[0]['$r3_Amt']."',coin='".$coin."', info='易宝充值自动到账' where rechargeid=?";

if($jiancha==0){
	   if($r1_Code==1){
                if($this->update($update1,$args[0]['$r6_Order'])){
                $this->update($update2,$args[0]['$r8_MP']);
                $this->update($update3,$args[0]['$r6_Order'];
                $this->insert($inserts);
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
?>
