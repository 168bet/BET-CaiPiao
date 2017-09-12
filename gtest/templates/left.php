<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';


$name = base64_decode($_COOKIE['g_user']);


$db=new DB();
$sql = "SELECT * FROM g_zhudan where g_nid='$name' ORDER BY g_id DESC LIMIT 10";
$result1 = $db->query($sql, 1);


if ((isset($_SESSION['cq']) && $_SESSION['cq'] == true))
		$li = 2;
	else{ 
			if((isset($_SESSION['gx']) && $_SESSION['gx'] == true))
				$li = 3;
			else if((isset($_SESSION['jx']) && $_SESSION['jx'] == true))
				$li = 4;
			else if((isset($_SESSION['nc']) && $_SESSION['nc'] == true))
				$li = 5;
			else if((isset($_SESSION['pk']) && $_SESSION['pk'] == true))
				$li = 6;
			else
				$li=1;
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/left.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/sc.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.linscroll.js"></script>
<style type="text/css">
body { background:url(/pagef/l_backdrop.jpg) repeat-y;
SCROLLBAR-FACE-COLOR: #FFFFFF;/*滚动条页面颜色设定*/ 
SCROLLBAR-HIGHLIGHT-COLOR: #FFFFF;/*滚动条斜面和左面颜色设*/
SCROLLBAR-SHADOW-COLOR: #FFFFFF;/*滚动条下斜面和右面颜色设*/
SCROLLBAR-3DLIGHT-COLOR: #FFFFFF;/*滚动条上边和左边的边沿颜色 */
SCROLLBAR-ARROW-COLOR: #FFFFFF;/*滚动条两端箭头颜色设定 */
SCROLLBAR-TRACK-COLOR: #FFFFFF;/*滚动条底版颜色设定 */
SCROLLBAR-DARKSHADOW-COLOR: #FFFFFF;/*滚动条下边和右边的边沿颜色设定*/
overflow:hidden;margin:0;}

</style>

<style type="text/css">
ul.topnav {
	list-style: none;
	padding: 0 20px;	
	margin: 0;
	float: left;
	width: 168px;
	background: url(/templates/images/pagef/bg.jpg);
	font-size: 1.2em;
}
ul.topnav li {
	float: left;
	margin: 0;	
	padding: 0 0 0 0;
	position: relative; /*--Declare X and Y axis base--*/
}
ul.topnav li a{
	padding-left:20px;
	display: block;
	text-decoration: none;
	float: left;
}
ul.topnav li span{
	padding-left:68px;
	display: block;
	text-decoration: none;
	float: left;
}
ul.topnav li a:hover{
}

ul.topnav li span.subhover {background-position: center bottom; cursor: pointer;} /*--Hover effect for trigger--*/
ul.topnav li ul.subnav {
	list-style: none;
	position: static; /*--Important - Keeps subnav from affecting main navigation flow--*/
	left: 0; top: 30px;
	margin: 0; padding: 0;
	display: none;
	float: left;
	width: 168px;
	position:static;
}


</style>
</head>
<script>
function getinfo()
	{
		$.ajax({
			type : "POST",
			url : '/function/Refresh.php',
			error : function(XMLHttpRequest, textStatus, errorThrown){
				if (XMLHttpRequest.readyState == 4){
					if (XMLHttpRequest.status == 500){
						getinfo();
						return false;
					}
				}
			},
			success:function(data){
				var datestr=data.split('{SPLIT}');
				$("#pls").html(datestr[0]);
				$("#xinyong").html(datestr[1]);
				$("#jine").html(datestr[2]);
				$("#tentable").html(datestr[3]);
			}
		});
	}
setInterval(getinfo, 5000);


function getinfotop()
	{
		$.ajax({
			type : "POST",
			url : '/function/RefreshTop.php',
			error : function(XMLHttpRequest, textStatus, errorThrown){
				if (XMLHttpRequest.readyState == 4){
					if (XMLHttpRequest.status == 500){
						getinfotop();
						return false;
					}
				}
			},
			success:function(data){
				$("#top").html(data);
			}
		});
	}
//setInterval(getinfotop, 5000);
getinfotop();
function changegd(type){
var t="t";
if(type==1) t="t";
if(type==2) t="s";
if(type==3) t="d";
if(type==4) t="z";
if(type==5) t="f";
$(".t_td_text1").css("display","none"); 
for(var i=0;i<10;i++){
 document.getElementById(t+"_"+i).style.display = "block"; 
}
}


function goUrl(){
	parent.location.href="/?redirect=2";
}
</script>
<script type="text/javascript">    
$(document).ready(    
function(){    
$("#scrollContent").setScroll( 
{img:"scroll_bk.gif",width:10},    
{img:"/templates/images/up.gif",height:3},    
{img:"/templates/images/down.gif",height:3},    
{img:"/templates/images/so.gif",height:50}    
);
$("ul.subnav").parent().append("<span></span>"); 
	$("ul.topnav li span").mouseover(function(){ 
	$(this).parent().find("ul.subnav").slideDown('fast').show();
	$(this).parent().hover(function() {}, function(){
	$(this).parent().find("ul.subnav").slideUp('slow');});
	}).hover(function() {
	$(this).addClass("subhover");
	 }, function(){$(this).removeClass("subhover"); });
});      
</script>

<body class="bd">
<div id="scrollContent" style="overflow:hidden;height:515px;">
  <table border="0" cellpadding="0" cellspacing="1" class="t_list" width="230" style="top:-1px;left:0px;">
    <tr>
      <td class="t_list_caption" colspan="5">請覈對您的帳戶</td>
    </tr>
    <tr>
      <td class="t_td_caption_1" width="64">會員帳戶</td>
      <td class="t_td_text" width="137" colspan="4"><?php echo $user[0]['g_name']?>（
        <label id="pls" ><?php echo strtoupper($user[0]['g_panlus'])?></label>
        盤）</td>
    </tr>
    <tr>
      <td class="t_td_caption_1">信用額度</td>
      <td id="xinyong"  class="t_td_text" colspan="4"><?php echo is_Number($user[0]['g_money'])?></td>
    </tr>
    <tr>
      <td class="t_td_caption_1">可用金額</td>
      <td id="jine" class="t_td_text" colspan="4"><?php echo is_Number($user[0]['g_money_yes'])?></td>
    </tr>
	
	<tr>
	<!--<td colspan="5" class="t_td_text" >
	<table border="0" cellpadding="0" cellspacing="1" width="100%">
                    <tr>
                        <td class="JZRCB"><a href="chongzhi.php" target="mainFrame" style="color:#FFFFFF;">在线充值</a></td>
                   
                        <td class="JZRCB"><a href="qukuan.php" target="mainFrame"  style="color:#FFFFFF;">在线取款</a></td>
                    </tr>
	</table>
	</td>-->
	</tr>
	<tr><TD class=t_list_caption colSpan=5><A style="COLOR: #4a1a04" title=切換到新版 onclick=goUrl() href="#this"><IMG src="/templates/images/o.gif"></A></TD></tr>
    <tr>
      <td  class="t_list_caption" colspan="5" >
         <a href="javascript:void(0);" onclick="window.open('http://www.egdfc.com/webvar/sohu/happy10.html','廣東快樂十分','width=687,height=464,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no');" > “廣東快樂十分”開獎网</a>
             </td>
		</tr>
		
		<tr>
      <td  class="t_list_caption" colspan="5" >
         <a href="javascript:void(0);" onclick="window.open('http://video.shishicai.cn/Assist/Test.aspx?lt=4','重慶時時彩','width=488,height=183,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no');" > “重慶時時彩”開獎网</a>
             </td>
		</tr>
		
		<tr>
      <td  class="t_list_caption" colspan="5" >
         <a href="javascript:void(0);" onclick="window.open('http://www.16cp.com/gamedraw/lucky/open.shtml','幸运农场','width=488,height=383,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no');" > “幸运农场”開獎网</a>
             </td>
		</tr>
		
		<tr>
      <td  class="t_list_caption" colspan="5" >
        <a href="javascript:void(0);" onclick="window.open('http://www.bwlc.net/buy/trax/','北京赛车','width=687,height=464,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no');"  > “北京赛车(PK10)”開獎网</a>
             </td>
		</tr>
		<tr>
      <td  class="t_list_caption" colspan="5" >
        <a href="javascript:void(0);" onclick="window.open('http://www.cailele.com/lottery/k3/','江苏骰寶','width=687,height=464,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no');"  > “江苏骰寶(快3)”開獎网</a>
             </td>
		</tr>
		
		<!--
    <TR class="t_list_caption">
      <TD colSpan=4 align="middle"><SPAN class=STYLE2>最新下註的十個單</SPAN></TD>
    </TR>
    <TR class="t_list_caption">
      <TD align="middle"><FONT color=#000000>時間</FONT></TD>
      <TD align="middle"><FONT color=#000000>内容</FONT></TD>
      <TD align="middle"><FONT color=#000000>賠率</FONT></TD>
      <TD align="middle"><FONT color=#000000>金額</FONT></TD>
    </TR>
    <?php for($i=0;$i<count($result1);$i++){

$SumNum = sumCountMoney ($user, $result1[$i], true);
        if ($result1[$i]['g_mingxi_1_str'] == null) {
        	if ($result1[$i]['g_mingxi_1'] == '總和、龍虎' || $result1[$i]['g_mingxi_1'] == '總和、龍虎和'){
        		$n = $result1[$i]['g_mingxi_2'];
        	}else {
        		$n = $result1[$i]['g_mingxi_1'].'『'.$result1[$i]['g_mingxi_2'].'』';
        	}
        	//$n = $result[$i]['g_mingxi_1'] == '總和、龍虎' ? $result[$i]['g_mingxi_2'] : $result[$i]['g_mingxi_1'].'『'.$result[$i]['g_mingxi_2'].'』';
        	$html = '<font color="#0066FF">'.$n.'</font>';
        } else {
        	$_xMoney = $result1[$i]['g_mingxi_1_str'] * $result1[$i]['g_jiner'];
        	$SumNum['Money'] = '<font color="#009933">'.$result1[$i]['g_mingxi_1_str'].'</font> x <font color="#0066FF">'.$result1[$i]['g_jiner'].'</font><br />'.$_xMoney;
        	$html = '<font color="#0066FF">'.$result1[$i]['g_mingxi_1'].'</font><br />'.
        				'<span style="line-height:23px">復式  『 '.$result1[$i]['g_mingxi_1_str'].' 組 』</span><br/><span>'.$result1[$i]['g_mingxi_2'].'</span>';
        }

?>
    <TR class="t_td_text">
      <TD align="middle"><FONT color=#000000><?php echo date('H:i:s',strtotime($result1[$i]['g_date']));?></FONT></TD>
      <TD align="middle"><FONT color=#000000><?php echo $html?></FONT></TD>
      <TD align="middle"><FONT color=#000000><font color="red"><b><?php echo $result1[$i]['g_odds']?></b></font></FONT></TD>
      <TD align="middle"><FONT color=#000000><?php echo $result1[$i]['g_jiner']?></FONT></TD>
    </TR>
    <?php

}


?>
<tr><td colspan="5"><div id="top">&nbsp;</div></td></tr>-->
</table>
</div>

</body>
</html>
