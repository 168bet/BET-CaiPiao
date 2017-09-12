<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");


//重庆时时彩采集完整版
function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}
$curl = &new Curl_HTTP_Client();
$html_data = $curl->fetch_url("http://www.woying.com/kaijiang/cqsscls/10.html");
$html_data=trimall($html_data);
//echo $html_data;exit;
$mode="#<tr><tdheight=\"30\"bgcolor=\"\#ffffff\"align=\"center\">(.*?)</td><tdbgcolor=\"\#ffffff\"align=\"center\">(.*?)</td><tdbgcolor=\"\#ffffff\"align=\"center\"class=\"ftred\"><tablecellspacing=\"0\"cellpadding=\"0\"border=\"0\"align=\"center\"><tbody><tr><td><divclass=\"ball_yellow\">(.*?)</div></td><td><divclass=\"ball_yellow\">(.*?)</div></td><td><divclass=\"ball_yellow\">(.*?)</div></td><td><divclass=\"ball_yellow\">(.*?)</div></td><td><divclass=\"ball_yellow\">(.*?)</div></td></tr></tbody></table></td></tr>#";//编写正则

//$html_data= iconv('GB2312', 'UTF-8', $html_data);//设置编码


preg_match_all($mode,$html_data,$arr);//匹配号码并写入数组$arr
//print_r($arr[0][0]);exit;
$html_data=$arr[0][0];
preg_match_all($mode,$html_data,$arr1);//匹配号码并写入数组$arr
//print_r($arr1);exit;
echo "取出号码:";
echo $hm1=$arr1[3][0];//取出号码！
echo $hm2=$arr1[4][0];
echo $hm3=$arr1[5][0];
echo $hm4=$arr1[6][0];
echo $hm5=$arr1[7][0];
if($hm1=="0"&&$hm2=="0"&&$hm3=="0"&&$hm4=="0"&&$hm5=="0")
{
	echo "正在读取下一期号码。。。。";
    echo "<script type='text/javascript'>location.href='cqssc1.php';</script>";
}
elseif($hm1==" "||$hm2==" "||$hm3==" "||$hm4==" "||$hm5==" ")
{
	echo "正在读取下一期号码。。。。";
    echo "<script type='text/javascript'>location.href='cqssc1.php';</script>";
}
else {
	
	 $num1=$hm1;
		$num2=$hm2;
		$num3=$hm3;
		$num4=$hm4;
		$num5=$hm5;
		echo "</br>";

}
       

//取出期号

$qishu="20".$arr1[1][0];
echo "取出期号:";
echo $qishu;//$qishu="20150907002";

$time1=date('Y-m-d');
$time=$time1." ".substr($arr1[2][0],8);
echo "取出时间:".$time;
echo "</br>";
//取出期号
//重庆时时彩采集完整版









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

var limit="50" 
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
		curtime=curmin+"秒后自动获取1!" 
	else 
		curtime=cursec+"秒后自动获取2!" 
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
      重庆时时彩(<?=$qishu?>期<?="$num1,$num2,$num3,$num4,$num5"?>):
	  </br>
	 <a href="apiwangye.php?type=ssc&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$num1,$num2,$num3,$num4,$num5"?>" target="_blank">1:采集号码期数入库</a>
      </br>
	   <a href="apiwangye.php?type=ssc&amp;ac=set&amp;qs=<?=$qishu?>" target="_blank">2:删除过期期数跟号码，前台显示下一期下注期数</a>
     </br>
	  <a href="apiwangye.php?type=ssc&amp;ac=read&amp;qs=<?=$qishu?>" target="_blank">3:无关紧要链接</a>
     
	 </br>
	  <span id="timeinfo"></span>
      </td>
  </tr>
</table>
<iframe src="apiwangye.php?type=ssc&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$num1,$num2,$num3,$num4,$num5"?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=ssc&amp;ac=set&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=ssc&amp;ac=read&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>

<!--<iframe src="../tools/autojiecq.php?number=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>-->
</body>
</html>