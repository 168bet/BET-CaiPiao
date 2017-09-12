<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");


//广东快乐十分采集完整版

function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}
$curl = &new Curl_HTTP_Client();
$html_data = $curl->fetch_url("http://www.aa456.com/gdkl10/kj/");
$html_data=trimall($html_data);
///echo $html_data; exit;//输出代码，然后去正则软件去匹配！

$pattern2="#<trclass='odd'><td><pclass=\"p\">([\d]*?)</p><pclass=\"t\">([\d \:]*?)<\/p><\/td><tdclass=\"nums\"><spanclass='no1'>([\d]*?)<\/span><spanclass='no2'>([\d]*?)<\/span><spanclass='no3'>([\d]*?)<\/span><spanclass='no4'>([\d]*?)<\/span><spanclass='no5'>([\d]*?)<\/span><spanclass='no6'>([\d]*?)<\/span><spanclass='no7'>([\d]*?)<\/span><spanclass='no8'>([\d]*?)<\/span><\/td><tdclass=\"wd50\">#";

preg_match_all($pattern2,$html_data,$matches2);

	//print_r($matches2);exit;
	$matches3=$matches2[0][0];
	//print_r($matches3);exit;
	
	$html_data=$matches3;
	preg_match_all($pattern2,$html_data,$matches4);
	//print_r($matches4);exit;
$qishu		= $matches4[1][0];
$time=date('Y-m-d')." ".$matches2[2][0];
echo "当前期号"	.$qishu."</br>";
echo "当前"	.$time."</br>";
echo  $ball_1		= $matches4[3][0];
echo	$ball_2		= $matches4[4][0];
echo	$ball_3		= $matches4[5][0];
echo	$ball_4		= $matches4[6][0];
echo	$ball_5		= $matches4[7][0];
echo	$ball_6		= $matches4[8][0];
echo	$ball_7		= $matches4[9][0];
echo	$ball_8		= $matches4[10][0];
echo "</br>";


//ak参数接入口：号码，期号！
$hm1=trim($ball_1);
$hm2=trim($ball_2);
$hm3=trim($ball_3);
$hm4=trim($ball_4);
$hm5=trim($ball_5);
$hm6=trim($ball_6);
$hm7=trim($ball_7);
$hm8=trim($ball_8);



$qihao=trim($qishu);
//ak参数接入口：号码，期号！

if($hm1=="0"&&$hm2=="0"&&$hm3=="0"&&$hm4=="0"&&$hm5=="0"&&$hm6=="0"&&$hm7=="0"&&$hm8=="0")
{
	echo "</br>";
	echo "采集的参数为0,正在重新加载采集页面。。。。";
    echo "<script type='text/javascript'>setTimeout(function(){window.location.reload(true);},8000);</script>";
	exit;
}
elseif($hm1==null||$hm2==null||$hm3==null||$hm4==null||$hm5==null||$hm6==null||$hm7==null||$hm8==null||$qihao==null||$hm1==""||$hm2==""||$hm3==""||$hm4==""||$hm5==""||$hm6==""||$hm7==""||$hm8==""||$qihao==""||!is_numeric($hm1)||!is_numeric($hm2)||!is_numeric($hm3)||!is_numeric($hm4)||!is_numeric($hm5)||!is_numeric($hm6)||!is_numeric($hm7)||!is_numeric($hm8)||!is_numeric($qihao))
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
		$ball_4=trim($hm4);
		$ball_5=trim($hm5);
		$ball_6=trim($hm6);
		$ball_7=trim($hm7);
		$ball_8=trim($hm8);
		
		
		
		$qishu=trim($qihao);
		
		

    //ak参数输出接口：号码，期号！
		echo "</br>";

}
//广东快乐十分采集完整版









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
      广东快乐十分(<?=$qishu?>期<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8"?>):
	  </br>
	  <a href="apiwangye.php?type=klsf&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8"?>" target="_blank">1:采集号码期数入库</a>
      </br>
	   <a href="apiwangye.php?type=klsf&amp;ac=set&amp;qs=<?=$qishu?>" target="_blank">2:删除过期期数跟号码，前台显示下一期下注期数</a>
     </br>
	  <a href="apiwangye.php?type=klsf&amp;ac=read&amp;qs=<?=$qishu?>" target="_blank">3:无关紧要链接</a>
     
	 </br>
	  <span id="timeinfo"></span>
      </td>
  </tr>
</table>
<iframe src="apiwangye.php?type=klsf&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8"?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=klsf&amp;ac=set&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=klsf&amp;ac=read&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
</body>
</html>