<?php
header('Content-Type:text/html; charset=utf-8');

require ("curl_http.php");



//江苏快三完整采集
function trimall($str)//删除空格,回车，换行，你还可以再加一些你自己要的规则
{
    $qian=array("-"," ","　","\t","\n","\r");$hou=array("","","","","","");
    return str_replace($qian,$hou,$str);    
}
$curl = &new Curl_HTTP_Client();
$html_data = $curl->fetch_url("http://www.1392c.com/jsk3/");//http://23.252.161.83:8666/jsk3/,http://www.1396cp.com/jsk3/
$html_data=trimall($html_data);
//echo $html_data; exit;
$mode="#<trclass='even'><td><pclass=\"p\">(.*?)</p><pclass=\"t\">(.*?)</p></td><tdclass=\"nums\"><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i><iclass='lotno(.*?)'></i></td>#";
preg_match_all($mode,$html_data,$str);
//print_r($str[0][0]);exit;
$ak=$str[0][0];//取出第一段代码
preg_match_all($mode,$ak,$str1);
//print_r($str1);exit;

	$qishu=$str1[1][0];//期号
	$qishu=substr($qishu,2,9);
	echo "当前期号:".$qishu;
	echo "当前号码:";
		echo $ball_1=$str1[3][0];
		echo $ball_2=$str1[4][0];
		echo $ball_3=$str1[5][0];
			
		echo "</br>";
		$time=date('Y-m-d')." ".substr($str1[2][0],-5);
		echo "当前期号开奖时间:".$time."</br>";
		echo "五合一盘口的开奖时间采集的是本身数据库里存在的时间，如果开奖开盘时间不对，请修改数据库里对应的数据库表";
		
		
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
      江苏快三(<?=$qishu?>期<?="$ball_1,$ball_2,$ball_3"?>):
	  </br>
	  <a href="apiwangye.php?type=k3&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3"?>" target="_blank">1:采集号码期数入库</a>
      </br>
	   <a href="apiwangye.php?type=k3&amp;ac=set&amp;qs=<?=$qishu?>" target="_blank">2:删除过期期数跟号码，前台显示下一期下注期数</a>
     </br>
	  <a href="apiwangye.php?type=k3&amp;ac=read&amp;qs=<?=$qishu?>" target="_blank">3:无关紧要链接</a>
     
	 </br>
	  <a href="../tools/autojiek3.php?number=<?=$qishu?>" target="_blank">4:当期结算</a>
     
	 </br>
	  <span id="timeinfo"></span>
      </td>
  </tr>
</table>
<iframe src="apiwangye.php?type=k3&amp;ac=open&amp;qs=<?=$qishu?>&amp;num=<?="$ball_1,$ball_2,$ball_3"?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=k3&amp;ac=set&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
<iframe src="apiwangye.php?type=k3&amp;ac=read&amp;qs=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>

<iframe src="../tools/autojiek3.php?number=<?=$qishu?>" frameborder="0" scrolling="no" height="0" width="0"></iframe>
</body>
</html>