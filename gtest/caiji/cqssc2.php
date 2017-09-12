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
$html_data = $curl->fetch_url("http://www.cqcp.net/game/ssc/");
$html_data=trimall($html_data);
//echo $html_data; exit;//输出代码，看情况要怎么处理！
$mode="#<ul><listyle='width:65px;'>([0-9]*?)</li><listyle='width:80px;'>([0-9]*?)</li>#iUs";//编写正则
preg_match_all($mode,$html_data,$arr);//匹配号码并写入数组$arr
//print_r($arr);exit;//输出数组，看情况要怎么处理！
$html_data1=$arr[0][0];//对匹配到的内容抓取第一段代码
//echo $html_data1; exit;//输出代码，看情况要怎么处理！

preg_match_all($mode,$html_data1,$arr1);//匹配号码并写入数组$arr
//print_r($arr1);exit;

echo "号码是：".$hm1=substr($arr1[2][0],0,1);//取出号码！
echo $hm2=substr($arr1[2][0],1,1);
echo $hm3=substr($arr1[2][0],2,1);
echo $hm4=substr($arr1[2][0],3,1);
echo $hm5=substr($arr1[2][0],4,1);
$num1=$hm1;
$num2=$hm2;
$num3=$hm3;
$num4=$hm4;
$num5=$hm5;

//取出期号


$qishu="20".$arr[1][0];
echo "期号是：".$qishu;
//取出时间
$time=date('Y-m-d H:i:s');
echo "取出开奖时间：".$time;

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