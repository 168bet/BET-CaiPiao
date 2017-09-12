<?php

$sql="select * from ssc_pay where sortname=? limit 1";
$row=$this->getrow($sql,'yeepay');

$p0_Cmd                     = "Buy";

$p1_MerId	                =$row['number'];

$merchantKey                =$row['meky'];

$p2_Order					=$args[0]['p2_Order'];

$p3_Amt						=$args[0]['p3_Amt'];

$pa_MP						=$args[0]['pa_MP'];

$time = date("Y-m-d H:i:s",time()+28800-date("Z",time()));

$p4_Cur						= "CNY";

$p5_Pid						= "recharge";

$p6_Pcat					= "order";

$p7_Pdesc					= "";

$p8_Url						= "http://".$_SERVER['HTTP_HOST']."/index.php/pays/yeepaycallback";	

$p9_SAF = "0";
														
$pd_FrpId					= "";

$pr_NeedResponse	= "1";

#签名函数生成签名串
function getReqHmacString($p0_Cmd,$p1_MerId,$merchantKey,$p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$p9_SAF,$pa_MP,$pd_FrpId,$pr_NeedResponse)
{
	
  #进行签名处理，一定按照文档中标明的签名顺序进行
  $sbOld = "";
  #加入业务类型
  $sbOld = $sbOld.$p0_Cmd;
  #加入商户编号
  $sbOld = $sbOld.$p1_MerId;
  #加入商户订单号
  $sbOld = $sbOld.$p2_Order;     
  #加入支付金额
  $sbOld = $sbOld.$p3_Amt;
  #加入交易币种
  $sbOld = $sbOld.$p4_Cur;
  #加入商品名称
  $sbOld = $sbOld.$p5_Pid;
  #加入商品分类
  $sbOld = $sbOld.$p6_Pcat;
  #加入商品描述
  $sbOld = $sbOld.$p7_Pdesc;
  #加入商户接收支付成功数据的地址
  $sbOld = $sbOld.$p8_Url;
  #加入送货地址标识
  $sbOld = $sbOld.$p9_SAF;
  #加入商户扩展信息
  $sbOld = $sbOld.$pa_MP;
  #加入支付通道编码
  $sbOld = $sbOld.$pd_FrpId;
  #加入是否需要应答机制
  $sbOld = $sbOld.$pr_NeedResponse;
	logstr($p2_Order,$sbOld,HmacMd5($sbOld,$merchantKey));
  return HmacMd5($sbOld,$merchantKey);
  
}

function HmacMd5($data,$key)
{

//需要配置环境支持iconv，否则中文参数不能正常处理
$key = iconv("GB2312","UTF-8",$key);
$data = iconv("GB2312","UTF-8",$data);

$b = 64; // byte length for md5
if (strlen($key) > $b) {
$key = pack("H*",md5($key));
}
$key = str_pad($key, $b, chr(0x00));
$ipad = str_pad('', $b, chr(0x36));
$opad = str_pad('', $b, chr(0x5c));
$k_ipad = $key ^ $ipad ;
$k_opad = $key ^ $opad;

return md5($k_opad . pack("H*",md5($k_ipad . $data)));
}

function logstr($orderid,$str,$hmac)
{
$logName	= "YeePay_HTML.log";
$james=fopen($logName,"a+");
fwrite($james,"\r\n".date("Y-m-d H:i:s")."|orderid[".$orderid."]|str[".$str."]|hmac[".$hmac."]");
fclose($james);
}

$hmac = getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);

$update['order_number']=$p2_Order;
$update['username']=$pa_MP;
$update['recharge_amount']=$p3_Amt;
$update['state']=0;
$update['time']=$time;

if($this->insertRow($this->prename .'order', $update)){?> 
<html>
<head>
<title>To YeePay Page</title>
</head>
<body onLoad="document.yeepay.submit();">
<form name='yeepay' action='https://www.yeepay.com/app-merchant-proxy/node' method='post'>
<input type='hidden' name='p0_Cmd'					value='<?php echo $p0_Cmd; ?>'>
<input type='hidden' name='p1_MerId'				value='<?php echo $p1_MerId; ?>'>
<input type='hidden' name='p2_Order'				value='<?php echo $p2_Order; ?>'>
<input type='hidden' name='p3_Amt'					value='<?php echo $p3_Amt; ?>'>
<input type='hidden' name='p4_Cur'					value='<?php echo $p4_Cur; ?>'>
<input type='hidden' name='p5_Pid'					value='<?php echo $p5_Pid; ?>'>
<input type='hidden' name='p6_Pcat'					value='<?php echo $p6_Pcat; ?>'>
<input type='hidden' name='p7_Pdesc'				value='<?php echo $p7_Pdesc; ?>'>
<input type='hidden' name='p8_Url'					value='<?php echo $p8_Url; ?>'>
<input type='hidden' name='p9_SAF'					value='<?php echo $p9_SAF; ?>'>
<input type='hidden' name='pa_MP'				    value='<?php echo $pa_MP; ?>'>
<input type='hidden' name='pd_FrpId'				value='<?php echo $pd_FrpId; ?>'>
<input type='hidden' name='pr_NeedResponse'	        value='<?php echo $pr_NeedResponse; ?>'>
<input type='hidden' name='hmac'				    value='<?php echo $hmac; ?>'>
</form>
</body>
</html>
<?
}else{
   throw new Exception('充值出错，请重新操作');
 }
?>