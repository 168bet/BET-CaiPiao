<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");


//北京赛车完整采集
function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}
$curl = &new Curl_HTTP_Client();
$html_data = $curl->fetch_url("http://www.1392c.com/pk10/");
$html_data=trimall($html_data);
//echo $html_data; exit;
$mode="#<trclass='even'><td><pclass=\"p\">(.*?)</p><pclass=\"t\">(.*?)</p></td><tdclass=\"nums\"><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i><iclass='pkno(.*?)'></i></td>#";
preg_match_all($mode,$html_data,$str);
//print_r($str[0][0]);exit;
$ak=$str[0][0];//取出第一段代码
preg_match_all($mode,$ak,$str1);
//print_r($str1);exit;

	echo "当前期号:".$qishu=$str1[1][0];//期号
	echo "当前号码:";
		echo $ball_1=$str1[3][0];
		echo $ball_2=$str1[4][0];
		echo $ball_3=$str1[5][0];
		echo $ball_4=$str1[6][0];
		echo $ball_5=$str1[7][0];
		echo $ball_6=$str1[8][0];
		echo $ball_7=$str1[9][0];
		echo $ball_8=$str1[10][0];
		echo $ball_9=$str1[11][0];
		echo $ball_10=$str1[12][0];		
		echo "</br>";
		$time=date('Y-m-d')." ".substr($str1[2][0],-5);
		echo "当前期号开奖时间:".$time."</br>";
		echo "五合一盘口的开奖时间采集的是本身数据库里存在的时间，如果开奖开盘时间不对，请修改数据库里对应的数据库表";
		

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