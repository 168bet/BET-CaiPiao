<?php
include '../config.php';
header("Content-type:text/html; charset=gb2312"); 

//提交地址
$form_url = 'https://pay.ips.net.cn/ipayment.aspx'; //测试

//$form_url = 'https://pay.ips.com.cn/ipayment.aspx'; //正式

//商户号
$Mer_code = "000015";

//商户证书：登陆http://merchant.ips.com.cn/商户后台下载的商户证书内容
$Mer_key = "GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ";


$Billno = intval($_POST['Billno']);


$Amount = number_format($_POST['Amount'], 2, '.', '');


$Date = date('Ymd');


$Currency_Type = "RMB";


$Gateway_Type = "01";


$Lang = "GB";

//支付结果成功返回的商户URL
$Merchanturl = "http://msgyc.com/ipsss/OrderReturn.php";


$FailUrl = "";


$ErrorUrl = "";


$Attach = $_POST['Attach'];


$DispAmount = number_format($_POST['Amount'], 2, '.', '');


$OrderEncodeType = "5";


$RetEncodeType = "17";


$Rettype = "1";

$time = date("Y-m-d H:i:s",time()+28800-date("Z",time()));

$conn = mysql_connect($dbhost,$conf['db']['user'],$conf['db']['password']);
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbname,$conn);

$Attach = mysql_escape_string($Attach);
$Billno = mysql_escape_string($Billno);
$Amount = mysql_escape_string($Amount);

$info = "INSERT INTO ssc_order(order_number, username, recharge_amount, state, time)
VALUES('".$Billno."', '".$Attach."', '".$Amount."', '0', '".$time."')";

mysql_query($info);

mysql_close($conn);

$ServerUrl = "http://msgyc.com/ipsss/OrderReturn.php";

$orge = 'billno'.$Billno.'currencytype'.$Currency_Type.'amount'.$Amount.'date'.$Date.'orderencodetype'.$OrderEncodeType.$Mer_key ;

$SignMD5 = md5($orge) ;

?>
<html>
  <head>
    <title>跳转......</title>
    <meta http-equiv="content-Type" content="text/html; charset=gb2312" />
  </head>
  <body>
    <form action="<?php echo $form_url ?>" method="post" id="frm1">
      <input type="hidden" name="Mer_code" value="<?php echo $Mer_code ?>">
      <input type="hidden" name="Billno" value="<?php echo $Billno ?>">
      <input type="hidden" name="Amount" value="<?php echo $Amount ?>" >
      <input type="hidden" name="Date" value="<?php echo $Date ?>">
      <input type="hidden" name="Currency_Type" value="<?php echo $Currency_Type ?>">
      <input type="hidden" name="Gateway_Type" value="<?php echo $Gateway_Type ?>">
      <input type="hidden" name="Lang" value="<?php echo $Lang ?>">
      <input type="hidden" name="Merchanturl" value="<?php echo $Merchanturl ?>">
      <input type="hidden" name="FailUrl" value="<?php echo $FailUrl ?>">
      <input type="hidden" name="ErrorUrl" value="<?php echo $ErrorUrl ?>">
      <input type="hidden" name="Attach" value="<?php echo $Attach ?>">
      <input type="hidden" name="DispAmount" value="<?php echo $DispAmount ?>">
      <input type="hidden" name="OrderEncodeType" value="<?php echo $OrderEncodeType ?>">
      <input type="hidden" name="RetEncodeType" value="<?php echo $RetEncodeType ?>">
      <input type="hidden" name="Rettype" value="<?php echo $Rettype ?>">
      <input type="hidden" name="ServerUrl" value="<?php echo $ServerUrl ?>">
      <input type="hidden" name="SignMD5" value="<?php echo $SignMD5 ?>">
    </form>
    <script language="javascript">
      document.getElementById("frm1").submit();
    </script>
  </body>
</html>
