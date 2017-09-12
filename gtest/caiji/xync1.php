<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");


//重庆快乐十分完整版
//
function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}

//匹配期号号码
$url1="http://www.cp908.com/xync/getXyncAwardData.do?ajaxhandler=GetXyncAwardData";//目标站！
$fp1=@fopen($url1,'r') or die("超时ddd");//测试能不能打开！
$fceshi1=file_get_contents($url1);//获取网页全部内容
//echo $fceshi1;exit;
//$ceshi1= iconv('GB2312', 'UTF-8', $fceshi1);//设置编码

//$fceshi1=trimall($fceshi1);


$mode="#awardTime\":\"([\d \-\:\ ]*?)\",\"periodNumber\":([\d]*?),\"fullPeriodNumber\":([\d]*?),\"periodNumberStr\":\"([\d \-]*?)\",\"awardTimeInterval\":[\d]*?,\"awardNumbers\":\"([\d]*?),([\d]*?),([\d]*?),([\d]*?),([\d]*?),([\d]*?),([\d]*?),([\d]*?)\",#";//编写取期号正则
preg_match_all($mode,$fceshi1,$arr);//把取号码正则匹配期号并写入数组$arr

//print_r($arr);



 $qishu="20".$arr[3][0];//取出期号！ 
echo "当前期号:".$qishu;//期号
//echo "ok1221";exit;

echo "当前号码:";

echo $ball_1=$arr[5][0];
echo $ball_2=$arr[6][0];
echo $ball_3=$arr[7][0];
echo $ball_4=$arr[8][0];
echo $ball_5=$arr[9][0];
echo $ball_6=$arr[10][0];
echo $ball_7=$arr[11][0];
echo $ball_8=$arr[12][0];


echo "</br>";
		$time=date('Y-m-d');
		$time=$time." ".substr($arr1[3][0],-8);
		echo "当前期号开奖时间:".$time."</br>";
		echo "五合一盘口的开奖时间采集的是本身数据库里存在的时间，如果开奖开盘时间不对，请修改数据库里对应的数据库表";
//

	//exit;
		//重庆快乐十分完整版







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
      幸运农场(<?=$qishu?>期<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8"?>):
	  </br>
	  <a href="apiwangye.php?type=k8&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8"?>" target="_blank">1:采集号码期数入库</a>
      </br>
	   <a href="apiwangye.php?type=k8&amp;ac=set&amp;qs=<?=$qishu?>" target="_blank">2:删除过期期数跟号码，前台显示下一期下注期数</a>
     </br>
	  <a href="apiwangye.php?type=k8&amp;ac=read&amp;qs=<?=$qishu?>" target="_blank">3:无关紧要链接</a>
     
	 </br>
	 <a href="../tools/autojienc.php?number=<?=$qishu?>" target="_blank">4:当期结算</a>
     
	 </br>
	  <span id="timeinfo"></span>
      </td>
  </tr>
</table>
<iframe src="apiwangye.php?type=k8&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3,$ball_4,$ball_5,$ball_6,$ball_7,$ball_8"?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=k8&amp;ac=set&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=k8&amp;ac=read&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="../tools/autojienc.php?number=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>

</body>
</html>