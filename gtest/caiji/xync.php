<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");


//重庆快乐十分完整版
function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}
$curl = &new Curl_HTTP_Client();
$html_data = $curl->fetch_url("http://www.1392c.com/xync/");
$html_data=trimall($html_data);
//echo $html_data; exit;
$mode="#<trclass='even'><td><pclass=\"p\">(.*?)</p><pclass=\"t\">(.*?)</p></td><tdclass=\"nums\"><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i></td>#";
preg_match_all($mode,$html_data,$str);
//print_r($str[0][0]);exit;
$ak=$str[0][0];//取出第一段代码
preg_match_all($mode,$ak,$str1);
//print_r($str1);exit;


	


	$qishu=$str1[1][0];
	echo "当前期号:";//期号20160214078
	echo $qishu=date("Ymd")."0".substr($qishu,-2);
	echo "当前号码:";
		echo $ball_1=$str1[3][0];
		echo $ball_2=$str1[4][0];
		echo $ball_3=$str1[5][0];
		echo $ball_4=$str1[6][0];
		echo $ball_5=$str1[7][0];
		echo $ball_6=$str1[8][0];
		echo $ball_7=$str1[9][0];
		echo $ball_8=$str1[10][0];
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