<?php
/*
 * @Description 易宝支付B2C在线支付接口范例 
 * @V3.0
 * @Author rui.xin
 */
 
include 'charge_yeepayCommon.php';	
require ("../include/config.inc.php");
#	只有支付成功时易宝支付才会通知商户.
##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.

#	解析返回参数.
$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);

#	判断返回签名是否正确（True/False）
$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
#	以上代码和变量不需要修改.
//http://qianbao.me/admin/YeePay/callback.php?p1_MerId=10001049131&r0_Cmd=Buy&r1_Code=1&r2_TrxId=919415822326771H&r3_Amt=0.01&r4_Cur=RMB&r5_Pid=&r6_Order=yeepay_14349227&r7_Uid=&r8_MP=kka1234&r9_BType=1&ru_Trxtime=20091209210537&ro_BankOrderId=197905920&rb_BankId=BOCO-NET&rp_PayDate=20091209210532&rq_CardNo=&rq_SourceFee=0.0&rq_TargetFee=0.0&hmac=ef475752a7003855f75e19ef3f7eb8cc#	校验码正确.
if ($bRet){
	#检查返回的会员帐号
	if ($r8_MP==""){
	    echo "返回信息错误!";
	    exit;
	}else{
		$sql="select * from web_member_data where UserName = '".$r8_MP."'";
		$result=mysql_db_query($dbname,$sql);
		$row=mysql_fetch_array($result);
		$agents=$row['Agents'];
		$world=$row['World'];
		$corprator=$row['Corprator'];
		$super=$row['Super'];
		$admin=$row['Admin'];
	}
	if ($r1_Code=="1"){
		
	#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
	#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，防止对同一条交易重复发货的情况发生.      	  	
		
		    if ($r9_BType=="1"){
				$sql="select * from web_sys800_data where Order_Code = '".$r6_Order."'";
				$result = mysql_db_query($dbname,$sql);
				$cou=mysql_num_rows($result);
				if ($cou==0){
				    $date=date("Y-m-d");
					$datetime=date("Y-m-d H:i:s");
				    $sql = "insert into web_sys800_data set Checked=1,Payway='W',Gold='$r3_Amt',AddDate='$date',Type='S',UserName='$r8_MP',Agents='$agents',World='$world',Corprator='$corprator',Super='$super',Admin='$admin',CurType='RMB',Date='$datetime',Name='$r8_MP',User='$r8_MP',Waterno='".$_REQUEST['rb_BankId']."',Order_Code='$r6_Order'";
				    mysql_db_query($dbname,$sql);
				    $sql_amt = "update web_member_data set Credit=Credit+$r3_Amt,Money=Money+$r3_Amt  where UserName='$r8_MP'";
				    mysql_db_query($dbname,$sql_amt);
			        echo "<Script language=javascript>alert('交易成功');window.close();</script>";
				}
		    }else if ($r9_BType=="2"){
				
			#如果需要应答机制则必须回写流,以success开头,大小写不敏感.
				$sql="select * from web_sys800_data where Order_Code = '".$r6_Order."'";
				$result = mysql_db_query($dbname,$sql);
				$cou=mysql_num_rows($result);

				if ($cou==0){
				    $date=date("Y-m-d");
					$datetime=date("Y-m-d H:i:s");
				    $sql = "insert into web_sys800_data set Checked=1,Payway='W',Gold='$r3_Amt',AddDate='$date',Type='S',UserName='$r8_MP',Agents='$agents',World='$world',Corprator='$corprator',Super='$super',Admin='$admin',CurType='RMB',Date='$datetime',Name='$r8_MP',User='$r8_MP',Waterno='".$_REQUEST['rb_BankId']."',Order_Code='$r6_Order'";
				    mysql_db_query($dbname,$sql);
				    $sql_amt = "update web_member_data set Credit=Credit+$r3_Amt,Money=Money+$r3_Amt  where UserName='$r8_MP'";
				    mysql_db_query($dbname,$sql_amt);		
			        echo "success";
			        echo "<Script language=javascript>alert('交易成功');window.close();</script>";
				}
			}
	}
	
}else{
	echo "交易信息被篡改";
}
   
?>
<html>
<head>
<title>Return from YeePay Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
</body>
</html>
