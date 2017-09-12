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
$html_data = $curl->fetch_url("http://www.1392c.com/shishicai/");
$html_data=trimall($html_data);
//echo $html_data; exit;//输出代码，看情况要怎么处理！
$mode="#<trclass='even'><td><pclass=\"p\">(.*?)</p><pclass=\"t\">(.*?)</p></td><tdclass=\"nums\"><spanclass='no[0-9]'>(.*?)</span><spanclass='no[0-9]'>(.*?)</span><spanclass='no[0-9]'>(.*?)</span><spanclass='no[0-9]'>(.*?)</span><spanclass='no[0-9]'>(.*?)</span></td>#";//编写正则
preg_match_all($mode,$html_data,$arr);//匹配号码并写入数组$arr
//print_r($arr);exit;//输出数组，看情况要怎么处理！
$html_data1=$arr[0][0];//对匹配到的内容抓取第一段代码
//echo $html_data1; exit;//输出代码，看情况要怎么处理！

preg_match_all($mode,$html_data1,$arr1);//匹配号码并写入数组$arr
//print_r($arr1);exit;

echo "号码是：".$hm1=$arr1[3][0];//取出号码！
echo $hm2=$arr1[4][0];
echo $hm3=$arr1[5][0];
echo $hm4=$arr1[6][0];
echo $hm5=$arr1[7][0];


//取出期号

echo "期号是：".$arr1[1][0];
$qishu=$arr[1][0];
echo "</br>";
//取出期号
$time=date('Y-m-d')." ".$arr1[2][0];
echo "取出开奖时间：".$time;
echo "</br>";
echo "五合一盘口的开奖时间采集的是本身数据库里存在的时间，如果开奖开盘时间不对，请修改数据库里对应的数据库表";
echo "</br>";



//ak参数接入口：号码，期号！
$hm1=trim($hm1);
$hm2=trim($hm2);
$hm3=trim($hm3);
$hm4=trim($hm4);
$hm5=trim($hm5);

$qihao=trim($qishu);
//ak参数接入口：号码，期号！

if($hm1=="0"&&$hm2=="0"&&$hm3=="0"&&$hm4=="0"&&$hm5=="0")
{
	echo "</br>";
	echo "采集的参数为0,正在重新加载采集页面。。。。";
    echo "<script type='text/javascript'>setTimeout(function(){window.location.reload(true);},8000);</script>";
	exit;
}
elseif($hm1==" "||$hm2==" "||$hm3==" "||$hm4==" "||$hm5==" "||$qihao==" "||$hm1==null||$hm2==null||$hm3==null||$hm4==null||$hm5==null||$qihao==null||$hm1==""||$hm2==""||$hm3==""||$hm4==""||$hm5==""||$qihao==""||!is_numeric($hm1)||!is_numeric($hm2)||!is_numeric($hm3)||!is_numeric($hm4)||!is_numeric($hm5)||!is_numeric($qihao))
{
	echo "</br>";
	echo "采集的参数为空值,正在重新加载采集页面。。。。";
    echo "<script type='text/javascript'>setTimeout(function(){window.location.reload(true);},8000);</script>";
	exit;
}
else {
	//ak参数输出接口：号码，期号！
	    $num1=trim($hm1);
		$num2=trim($hm2);
		$num3=trim($hm3);
		$num4=trim($hm4);
		$num5=trim($hm5);
		
		$qishu=trim($qihao);
		
		

    //ak参数输出接口：号码，期号！
		echo "</br>";

}

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