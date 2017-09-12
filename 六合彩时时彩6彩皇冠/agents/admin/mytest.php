<?php
require_once dirname(__FILE__).'/conjunction.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
</head>

<body>
<?
$mynav=array();

$d=4;
echo "".$_SESSION['flag']."";
$arr=explode(",",$_SESSION['flag']);

foreach($arr as $it){
  echo "".$it."<br>";
  switch ($it)
{
case "01":
echo "盘口管理";
  break;
  case "02":
  echo "赔率设置";
  break;
  case "03":
  echo "即时注单";
  break;
  case "04":
  echo "走非";
  break;
  case "05":
  echo "股东";
  break;
  case "06":
  echo "总代理";
  break;
  case "07":
  echo "代理";
  break;
  case "08":
  echo "会员";
  break;
  case "09":
  echo "报表";
  break;
  case "10":
  echo "系统维护";
  break;
  case "11":
  echo "注单查询";
  break;
  case "12":
  echo "修改密码";
  break;
  case "13":
  echo "在线统计";
  break;
  default:
  echo "空";
}
  //$mynav[]=$it;
}
echo "".count($mynav)."";
		?>
</body>
</html>
