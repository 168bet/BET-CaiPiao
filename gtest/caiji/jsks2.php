<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");


//江苏快三采集完整版

//匹配号码
$url1="http://cp.360.cn/k3js";//目标站！
$fp1=@fopen($url1,'r') or die("超时");//测试能不能打开！
$fceshi1=file_get_contents($url1);//获取网页全部内容
$ceshi1= iconv('GB2312', 'UTF-8', $fceshi1);//设置编码
$mode="#<li class=\"ico-ball3\">(.*)</li>#iUs";//编写取号码正则
preg_match_all($mode,$ceshi1,$arr);//把取号码正则匹配号码并写入数组$arr
//print_r($arr);//需要测试的时候打开！
echo $ball_1=$arr[1][0];//取出号码！
echo $ball_2=$arr[1][1];
echo $ball_3=$arr[1][2];

//匹配期号
/* $url="http://cp.360.cn/sd/";//目标站！
$fp=@fopen($url,'r') or die("超时");//测试能不能打开！
$fceshi=file_get_contents($url);//获取网页全部内容
$ceshi= iconv('GB2312', 'UTF-8', $fceshi);//设置编码 */
$modeqihao="#<h3>老快3 第 <em class=\"red\" id=\"open_issue\">([\d]*?)<\/em> 期 开奖<\/h3>#iUs";//编写取号码正则
preg_match_all($modeqihao,$ceshi1,$arrqihao);//把取号码正则匹配号码并写入数组$arr
//print_r($arrqihao);exit;//需要测试的时候打开！

 $qishu=date('y').$arrqihao[1][0];//设置期号参数
 $qishu=substr($qishu,0,6)."0".substr($qishu,-2);


//ak参数接入口：号码，期号！
$hm1=trim($ball_1);
$hm2=trim($ball_2);
$hm3=trim($ball_3);


$qihao=trim($qishu);
//ak参数接入口：号码，期号！

if($hm1=="0"&&$hm2=="0"&&$hm3=="0")
{
	echo "</br>";
	echo "采集的参数为0,正在重新加载采集页面。。。。";
    echo "<script type='text/javascript'>setTimeout(function(){window.location.reload(true);},8000);</script>";
	exit;
}
elseif($hm1==" "||$hm2==" "||$hm3==" "||$qihao==" "||$hm1==null||$hm2==null||$hm3==null||$qihao==null||$hm1==""||$hm2==""||$hm3==""||$qihao==""||!is_numeric($hm1)||!is_numeric($hm2)||!is_numeric($hm3)||!is_numeric($qihao))
{
	echo "</br>";
	echo "采集的参数为空值,正在重新加载采集页面。。。。";
    echo "<script type='text/javascript'>setTimeout(function(){window.location.reload(true);},8000);</script>";
	exit;
}
else {
	//ak参数输出接口：号码，期号！
	    $ball_1=trim($hm1);
		$ball_2=trim($hm2);
		$ball_3=trim($hm3);
		
		
		$qishu=trim($qihao);
		
		

    //ak参数输出接口：号码，期号！
		echo "</br>";

}

//江苏快三完整采集








?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<style type="text/css">
<!--
body,td,th {
    font-size: 12px;
}
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
-->
</style></head>
<body>
<script>
window.parent.is_open = 1;
</script>
<script> 
<!-- 
var limit="30" 
if (document.images){ 
	var parselimit=limit
} 
function beginrefresh(){ 
if (!document.images) 
	return 
if (parselimit==1) 
	window.location.reload() 
else{ 
	parselimit-=1 
	curmin=Math.floor(parselimit) 
	if (curmin!=0) 
		curtime=curmin+"秒后自动获取!" 
	else 
		curtime=cursec+"秒后自动获取!" 
		timeinfo.innerText=curtime 
		setTimeout("beginrefresh()",1000) 
	} 
} 
window.onload=beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left">
      <input type=button name=button value="刷新" onClick="window.location.reload()">
      江苏快三(<?=$qishu?>期<?="$ball_1,$ball_2,$ball_3"?>):
	  </br>
	  <a href="apiwangye.php?type=k3&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3"?>" target="_blank">1:采集号码期数入库</a>
      </br>
	   <a href="apiwangye.php?type=k3&amp;ac=set&amp;qs=<?=$qishu?>" target="_blank">2:删除过期期数跟号码，前台显示下一期下注期数</a>
     </br>
	  <a href="apiwangye.php?type=k3&amp;ac=read&amp;qs=<?=$qishu?>" target="_blank">3:无关紧要链接</a>
     
	 </br>
	  <span id="timeinfo"></span>
      </td>
  </tr>
</table>
<iframe src="apiwangye.php?type=k3&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3"?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=k3&amp;ac=set&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=k3&amp;ac=read&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
</body>
</html>