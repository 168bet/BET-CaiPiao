<html><head>
<meta content="text/html; charset=gb2312" http-equiv="Content-Type"/>
    <link href="imgs/top_menu.css" rel="stylesheet" type="text/css">
	<SCRIPT type="text/javascript" src="imgs/activeX_Embed.js"></SCRIPT>
	<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
.Menu_ANa {
font-family: "宋体 "; 
font-size:   14px; 
	color:  #FFFF00;
	cursor: default;
	font-weight: bold;
}
.Menu_AN1 {
	color: #FF0000;
	cursor: hand;
}
.STYLE2 {color: #FFFF00}
a{text-decoration:none;color:#0f64aa;}
a:hover, .a1{
	text-decoration:none;
	color:red;
	font-weight: bold;
}

.t_left{	
	background-repeat: no-repeat;
	color:#FFFFFF;
}
-->
</style>
</head>
<body id="body_backdrop" class="backdrop_1" oncopy="return false" oncut="return false" onselectstart="return false"> 
 <?php
$result2=mysql_query("select ops,opd,opp  from ka_mem where  id=".ka_memuser("id")." order by id"); 
$row2=mysql_fetch_array($result2);
?>
 <table width="100%" height="85" border="0" cellpadding="0" cellspacing="0" class="t_left" style="background-image: url(imgs/top-11.jpg);">
 <tr><td width="318">
<script language="javascript">
Make_FlashPlay('imgs/sg.swf','top_c','231','80');
</script>
 </td>
 <td>
 <table width="540"><tr><td width="100%" height="40" valign="middle" >
 &nbsp;&nbsp;&nbsp;&nbsp;
 <a href="index.php?action=sm" target="k_memr" class="Menu_ANa">规则</a> &nbsp;&nbsp;
 <font color="#FFFFFF">|</font>&nbsp;&nbsp;
 <a href="index.php?action=edit" target="k_memr" class="Menu_ANa">会员资料</a>&nbsp;&nbsp;
 <font color="#FFFFFF">|</font>&nbsp;&nbsp;
 <a href="index.php?action=h" target="k_memr" class="Menu_ANa">下注明细</a>&nbsp;&nbsp;
 <font color="#FFFFFF">|</font>&nbsp;&nbsp;
 <a href="index.php?action=l" target="k_memr" class="Menu_ANa">帐号历史</a> &nbsp;&nbsp;
 <font color="#FFFFFF">|</font>&nbsp;&nbsp;
 <a href="index.php?action=kakithe" target="k_memr" class="Menu_ANa">开奖结果</a>&nbsp;&nbsp;
 <font color="#FFFFFF">|</font>&nbsp;&nbsp;
 <a href="index.php?action=logout" target="_top" class="Menu_ANa">登出</a>&nbsp;&nbsp;</td></tr>
	   <tr><td height="2"></td></tr>
	   <tr><td height="25"><marquee onMouseOut="this.start()" onMouseOver="this.stop()" scrollamount="4" scrolldelay="100"><font id="Affiche"  style="position: relative; top: 5px" color="#2F5F83"><?=ka_config(10)?></font></marquee></td></tr>
	    <tr><td  height="13"> </td></tr>
	  </table>
 </td>
 </tr>

 </table>
 <table  width="100%" height="22" border="0" cellpadding="0" cellspacing="0"   style="background-image: url(imgs/top-5.jpg);"><tr><td width="230" align="center">欢迎光临『 <?=ka_config(1)?> 』
            </td> <td height="22" id="TypeBackdrop" class="Type_1" valign="middle">&nbsp;&nbsp;<span id="Type_List">
            <a href='javascript:void(0)' onClick="javascript:parent.parent.mem_order.location.href='index.php?action=k_tm';parent.mem_order.setGZ(1);" id='MC1'><img src='imgs/tri.gif'>&nbsp;特码</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onClick="javascript:parent.parent.mem_order.location.href='index.php?action=k_zm';parent.mem_order.setGZ(3);" id='MC3'><img src='imgs/tri.gif'>&nbsp;正码</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_zt';parent.mem_order.setGZ(2);" id='MC4'><img src='imgs/tri.gif'>&nbsp;正码特</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_zm6';parent.mem_order.setGZ(4);" id='MC10'><img src='imgs/tri.gif'>&nbsp;正码1-6</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_gg';parent.mem_order.setGZ(5);" id='MC11'><img src='imgs/tri.gif'>&nbsp;过关</a>&nbsp;|&nbsp;
            <a  href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_lm';parent.mem_order.setGZ(6);" id='MC12'><img src='imgs/tri.gif'>&nbsp;连码</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_bb';parent.mem_order.setGZ(7);" id='MC13'><img src='imgs/tri.gif'>&nbsp;半波</a>&nbsp;|&nbsp;
            <a  href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_sxp';parent.mem_order.setGZ(10);" id='MC14'><img src='imgs/tri.gif'>&nbsp;一肖/尾数</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_sx';parent.mem_order.setGZ(13);" id='MC15'><img src='imgs/tri.gif'>&nbsp;特码生肖</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_sx6';parent.mem_order.setGZ(13);" id='MC15'><img src='imgs/tri.gif'>&nbsp;合肖</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_sxt2';parent.mem_order.setGZ(14);" id='MC15'><img src='imgs/tri.gif'>&nbsp;生肖连</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_wsl';parent.mem_order.setGZ(16);" id='MC15'><img src='imgs/tri.gif'>&nbsp;尾数连</a>&nbsp;|&nbsp;
            <a href='javascript:void(0)' onclick="javascript:parent.parent.mem_order.location.href='index.php?action=k_wbz';parent.mem_order.setGZ(15);" id='MC16'><img src='imgs/tri.gif'>&nbsp;全不中</a>
            </span></td></tr></table>
<script language="javascript">
if(self == top) {location = '/';}
if(window.location.host!=top.location.host){top.location=window.location;}
</script>
</body>
</html>
<img src="T1.swf" width="0" height="0" />
<img src="T2.swf" width="0" height="0" />
<img src="RF.swf" width="0" height="0" />
<img src="SB.swf" width="0" height="0" />