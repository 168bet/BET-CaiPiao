<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>中联支付</title>
</head>
<body>
这商户的取货页面.<br>
商户号:<?php echo($_POST["merchantCode"]) ?><br />
交易类型:<?php echo($_POST["transType"]) ?><br />
中联订单号:<?php echo($_POST["instructCode"]) ?><br />
商户订单号:<?php echo($_POST["outOrderId"]) ?><br />
交易时间:<?php echo($_POST["transTime"]) ?><br />
交易金额(单位:分):<?php echo($_POST["totalAmount"])  ?>分<br />
</body>
</html>