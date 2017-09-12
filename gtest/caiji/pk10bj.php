<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");



//北京赛车完整采集 akui备注:  g_kaipan6:bj开奖预设   g_history6:bj开奖数据
//
function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}

//匹配期号号码
$curl = &new Curl_HTTP_Client();
$html_data = $curl->fetch_url("http://caipiao580.com//Index!getLotteryData.do?code=bjpk10");
$fceshi1=$html_data;
//echo $fceshi1;exit;
//$ceshi1= iconv('GB2312', 'UTF-8', $fceshi1);//设置编码

//$fceshi1=trimall($fceshi1);


//$mode="#\"open_phase\":\"([0-9]*?)\",\"open_time\":\"([0-9 \-\:\ ]*?)\",\"next_time\":\"[0-9 \-\:\ ]*?\",\"result1\":[\"([0-9]?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\"]#";//编写取期号正则
$mode="#\"open_phase\":\"([0-9]*?)\",\"open_time\":\"([0-9 \-\:\ ]*?)\",\"next_time\":\"[0-9 \-\:\ ]*?\",\"result1\":\[\"([0-9]?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\",\"([0-9]*?)\"\]#";//编写取期号正则


preg_match_all($mode,$fceshi1,$arr1);//把取号码正则匹配期号并写入数组$arr
//$fceshi1=$arr[0][0];
//print_r($arr1);exit;//需要测试的时候打开！


//preg_match_all($mode,$fceshi1,$arr1);//把取号码正则匹配期号并写入数组$arr1

//print_r($arr1);exit;//需要测试的时候打开！

 $qishu=$arr1[1][0];//取出期号！ 
echo "当前期号:".$qishu;//期号
//echo "ok1221";exit;

echo "当前号码:";
//$ball=$arr1[2][0];
echo $ball_1=$arr1[3][0];
echo $ball_2=$arr1[4][0];
echo $ball_3=$arr1[5][0];
echo $ball_4=$arr1[6][0];
echo $ball_5=$arr1[7][0];
echo $ball_6=$arr1[8][0];
echo $ball_7=$arr1[9][0];
echo $ball_8=$arr1[10][0];
echo $ball_9=$arr1[11][0];
echo $ball_10=$arr1[12][0];

echo "</br>";
		$time=$arr1[2][0];
		echo "当前期号开奖时间:".$time."</br>";
		echo "五合一盘口的开奖时间采集的是本身数据库里存在的时间，如果开奖开盘时间不对，请修改数据库里对应的数据库表";
//
//ak参数接入口：号码，期号！
$hm1=trim($ball_1);
$hm2=trim($ball_2);
$hm3=trim($ball_3);
$hm4=trim($ball_4);
$hm5=trim($ball_5);
$hm6=trim($ball_6);
$hm7=trim($ball_7);
$hm8=trim($ball_8);
$hm9=trim($ball_9);
$hm10=trim($ball_10);


$qihao=trim($qishu);
//ak参数接入口：号码，期号！

if($hm1=="0"&&$hm2=="0"&&$hm3=="0"&&$hm4=="0"&&$hm5=="0"&&$hm6=="0"&&$hm7=="0"&&$hm8=="0"&&$hm9=="0"&&$hm10=="0")
{
	echo "</br>";
	echo "采集的参数为0,正在重新加载采集页面。。。。";
    echo "<script type='text/javascript'>setTimeout(function(){window.location.reload(true);},8000);</script>";
	exit;
}
elseif($hm1==null||$hm2==null||$hm3==null||$hm4==null||$hm5==null||$hm6==null||$hm7==null||$hm8==null||$hm9==null||$hm10==null||$qihao==null||$hm1==""||$hm2==""||$hm3==""||$hm4==""||$hm5==""||$hm6==""||$hm7==""||$hm8==""||$hm9==""||$hm10==""||$qihao==""||!is_numeric($hm1)||!is_numeric($hm2)||!is_numeric($hm3)||!is_numeric($hm4)||!is_numeric($hm5)||!is_numeric($hm6)||!is_numeric($hm7)||!is_numeric($hm8)||!is_numeric($hm9)||!is_numeric($hm10)||!is_numeric($qihao))
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
		$ball_9=trim($hm9);
		$ball_10=trim($hm10);
		
		
		$qishu=trim($qihao);
		
		

    //ak参数输出接口：号码，期号！
		echo "</br>";

}

	
	
	
	
	
		

//北京赛车完整采集










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
      北京赛车(<?=$qishu?>期<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8,$ball_9,$ball_10"?>):
	  </br>
	  <a href="apiwangye.php?type=pk&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8,$ball_9,$ball_10"?>" target="_blank">1:采集号码期数入库</a>
      </br>
	   <a href="apiwangye.php?type=pk&amp;ac=set&amp;qs=<?=$qishu?>" target="_blank">2:删除过期期数跟号码，前台显示下一期下注期数</a>
     </br>
	  <a href="apiwangye.php?type=pk&amp;ac=read&amp;qs=<?=$qishu?>" target="_blank">3:无关紧要链接</a>
     
	 </br>
	  <span id="timeinfo"></span>
      </td>
  </tr>
</table>
<iframe src="apiwangye.php?type=pk&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8,$ball_9,$ball_10"?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=pk&amp;ac=set&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=pk&amp;ac=read&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
</body>
</html>