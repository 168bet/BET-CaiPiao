<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include ("../include/address.mem.php");
require ("../include/config.inc.php");
$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$type=$_REQUEST["type"];
$sql = "select * from web_system_data where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$username=$row['UserName'];
switch ($type){
case "MAX":
	$mysql="update web_system_data set R=".$_REQUEST['M1'].",OU=".$_REQUEST['M2'].",M=".$_REQUEST['M3'].",RE=".$_REQUEST['M4'].",ROU=".$_REQUEST['M5'].",PD=".$_REQUEST['M6'].",T=".$_REQUEST['M7'].",F=".$_REQUEST['M8'].",P=".$_REQUEST['M9'].",PR=".$_REQUEST['M10'].",P3=".$_REQUEST['M11'].",MAX=".$_REQUEST['M12']." where UserName='".$username."' ";
	mysql_db_query($dbname,$mysql);
	break;
case "FT":
	$mysql="update web_system_data set udp_ft_tw=".$_REQUEST['udp_ft_tw'].",udp_ft_r=".$_REQUEST['udp_ft_r'].",udp_ft_v=".$_REQUEST['udp_ft_v'].",udp_ft_re=".$_REQUEST['udp_ft_re'].",udp_ft_pd=".$_REQUEST['udp_ft_pd'].",udp_ft_t=".$_REQUEST['udp_ft_t'].",udp_ft_f=".$_REQUEST['udp_ft_f'].",udp_ft_p=".$_REQUEST['udp_ft_p'].",udp_ft_pr=".$_REQUEST['udp_ft_pr'];
	mysql_db_query($dbname,$mysql);
	break;
case "BK":
	$mysql="update web_system_data set udp_bk_tw=".$_REQUEST['udp_bk_tw'].",udp_bk_r=".$_REQUEST['udp_bk_r'].",udp_bk_rq=".$_REQUEST['udp_bk_rq'].",udp_bk_re=".$_REQUEST['udp_bk_re'].",udp_bk_pr=".$_REQUEST['udp_bk_pr'].",udp_fs_fs=".$_REQUEST['udp_fs_fs'];
	mysql_db_query($dbname,$mysql);
	break;
case "BS":
	$mysql="update web_system_data set udp_bs_tw=".$_REQUEST['udp_bs_tw'].",udp_bs_r=".$_REQUEST['udp_bs_r'].",udp_bs_v=".$_REQUEST['udp_bs_v'].",udp_bs_re=".$_REQUEST['udp_bs_re'].",udp_bs_pd=".$_REQUEST['udp_bs_pd'].",udp_bs_t=".$_REQUEST['udp_bs_t'].",udp_bs_m=".$_REQUEST['udp_bs_m'].",udp_bs_p=".$_REQUEST['udp_bs_p'].",udp_bs_pr=".$_REQUEST['udp_bs_pr'];
	mysql_db_query($dbname,$mysql);
	break;
case "TN":
	$mysql="update web_system_data set udp_tn_tw=".$_REQUEST['udp_tn_tw'].",udp_tn_r=".$_REQUEST['udp_tn_r'].",udp_tn_re=".$_REQUEST['udp_tn_re'].",udp_tn_pd=".$_REQUEST['udp_tn_pd'].",udp_tn_p=".$_REQUEST['udp_tn_p'].",udp_tn_pr=".$_REQUEST['udp_tn_pr'];
	mysql_db_query($dbname,$mysql);
	break;
case "VB":
	$mysql="update web_system_data set udp_vb_tw=".$_REQUEST['udp_vb_tw'].",udp_vb_r=".$_REQUEST['udp_vb_r'].",udp_vb_re=".$_REQUEST['udp_vb_re'].",udp_vb_pd=".$_REQUEST['udp_vb_pd'].",udp_vb_p=".$_REQUEST['udp_vb_p'].",udp_vb_pr=".$_REQUEST['udp_vb_pr'];
	mysql_db_query($dbname,$mysql);
	break;
case "OP":
	$mysql="update web_system_data set udp_op_tw=".$_REQUEST['udp_op_tw'].",udp_op_r=".$_REQUEST['udp_op_r'].",udp_op_v=".$_REQUEST['udp_op_v'].",udp_op_re=".$_REQUEST['udp_op_re'].",udp_op_pd=".$_REQUEST['udp_op_pd'].",udp_op_t=".$_REQUEST['udp_op_t'].",udp_op_f=".$_REQUEST['udp_op_f'].",udp_op_p=".$_REQUEST['udp_op_p'].",udp_op_pr=".$_REQUEST['udp_op_pr'];
	mysql_db_query($dbname,$mysql);
	break;
case "RESULT":
	$mysql="update web_system_data set udp_ft_results=".$_REQUEST['udp_ft_results'].",udp_ft_score=".$_REQUEST['udp_ft_score'].",udp_bk_results=".$_REQUEST['udp_bk_results'].",udp_bk_score=".$_REQUEST['udp_bk_score'].",udp_bs_results=".$_REQUEST['udp_bs_results'].",udp_bs_score=".$_REQUEST['udp_bs_score'].",udp_tn_results=".$_REQUEST['udp_tn_results'].",udp_tn_score=".$_REQUEST['udp_tn_score'].",udp_vb_results=".$_REQUEST['udp_vb_results'].",udp_vb_score=".$_REQUEST['udp_vb_score'].",udp_op_results=".$_REQUEST['udp_op_results'].",udp_op_score=".$_REQUEST['udp_op_score'];
	mysql_db_query($dbname,$mysql);
	break;
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_tline {  background-image:    url(/images/agents/top/top_03b.gif)}
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<script>
function sbar(st){
st.style.backgroundColor='#BFDFFF';
}
function cbar(st){
st.style.backgroundColor='';
}
function Go_Down_accounts(){
  re=window.open("/app/agents/accounts/download.php","re","width=1020,height=950,status=no");
}
function Go_Down_match(){
  Download=window.open("/app/agents/downdata_ra/download.php","download","width=1020,height=950,status=no");
}
function Go_Down_future(){
  Download_future=window.open("/app/agents/downdata_ra/download_future.php","download_future","width=1020,height=950,status=no");
}
function Go_Down_score(){
  score=window.open("/app/agents/score/download.php","score","width=1020,height=950,status=no");
}
function Go_Down_clearing(){
  clearing=window.open("/app/agents/clearing/download.php","clearing","width=1020,height=950,status=no");
}
function Go_Down_data(){
  uid=window.open("/app/agents/downdata_ra/uid/reload.php","uid","width=400,height=220,status=no");
}
function Go_Down_url(){
  uid=window.open("/app/agents/downdata_ra/uid/url.php","uid","width=800,height=600,status=no");
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp; 
	<a onClick="Go_Down_accounts(1);" style="cursor:hand">滚球确认</a> - 
	<a onClick="Go_Down_match(1);" style="cursor:hand">自动刷水</a> -- 
	<a onClick="Go_Down_future(1);" style="cursor:hand">早餐自动刷水</a> -- 
	<a onClick="Go_Down_score(1);" style="cursor:hand">自动刷比分</a> -- 
	<a onClick="Go_Down_clearing(1);" style="cursor:hand">自动结算</a> -- 
	<a onClick="Go_Down_data(1);" style="cursor:hand">更新UID</a> -- 
	<a onClick="Go_Down_url(1);" style="cursor:hand">刷水速度测试</a>
    </td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
  <TR class="m_title"> 
    <td width=115>下注设置</td>
    <td width=65> 让球</td>
    <td width=65>大小球</td>
    <td width=65>标准盘</td>
    <td width=65>滚球</td>
    <td width=65>滚球大小</td>
    <td width=65>波胆</td>
    <td width=65>入球数</td>	
    <td width=65>半全场</td>
    <td width=65>标准过关</td>
    <td width=65>让球过关</td>
    <td width=65>综合过关</td>
    <td width=65>最大单场</td>
    <td width=65></td>	
  </TR>
  <form name=FTR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)> 
      <td> 足(网/排/篮/棒)球 </td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['R']?>" name=M1></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['OU']?>" name=M2></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['M']?>" name=M3></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['RE']?>" name=M4></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['ROU']?>" name=M5></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['PD']?>" name=M6></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['T']?>" name=M7></td>
      <td><input class=za_text  maxLength=11 size=5 value="<?=$row['F']?>" name=M8></td>
      <td><input class=za_text  maxlength=11 size=5 value="<?=$row['P']?>" name=M9></td>
      <td><input class=za_text  maxlength=11 size=5 value="<?=$row['PR']?>" name=M10></td>
      <td><input class=za_text  maxlength=11 size=5 value="<?=$row['P3']?>" name=M11></td>	
      <td><input class=za_text  maxlength=11 size=5 value="<?=$row['MAX']?>" name=M12></td>	    
      <td><input class=za_button type=submit value="确定" name=ft_ch_ok1></td>
	  <input type=hidden value="MAX" name=type>
    </TR>
  </form>
</table>
<br>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
  <TR class="m_title"> 
    <td width=100>刷新设置</td>
    <td width=85>单式繁体</td>
    <td width=85>单式</td>
    <td width=85>上半场</td>
    <td width=85>走地</td>
    <td width=85>波胆</td>
    <td width=85>入球</td>
    <td width=85>半全场</td>
    <td width=85>让球过关</td>
    <td width=85>标准过关</td>
    <td width=98>&nbsp; </td>
  </TR>
    <form name=FTR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)> 
      <td>足球</td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_tw']?>" name=udp_ft_tw></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_r']?>" name=udp_ft_r></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_v']?>" name=udp_ft_v></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_re']?>" name=udp_ft_re></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_pd']?>" name=udp_ft_pd></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_t']?>" name=udp_ft_t></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_f']?>" name=udp_ft_f></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_p']?>" name=udp_ft_p></td>	  
      <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_ft_pr']?>" name=udp_ft_pr></td>    
      <td><input class=za_button type=submit value="确定" name=ft_ok></td>
	  <input type=hidden value="FT" name=type>
    </TR>
  </form>
    <form name=BSR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)>  
      <td>棒球</td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_tw']?>" name=udp_bs_tw></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_r']?>" name=udp_bs_r></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_v']?>" name=udp_bs_v></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_re']?>" name=udp_bs_re></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_pd']?>" name=udp_bs_pd></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_t']?>" name=udp_bs_t></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_m']?>" name=udp_bs_m></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_p']?>" name=udp_bs_p></td>	  
      <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_bs_pr']?>" name=udp_bs_pr></td>    
      <td><input class=za_button type=submit value="确定" name=bs_ok></td>
	  <input type=hidden value="BS" name=type>
    </TR>
  </form>
    <form name=OPR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)>  
      <td>其他</td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_tw']?>" name=udp_op_tw></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_r']?>" name=udp_op_r></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_v']?>" name=udp_op_v></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_re']?>" name=udp_op_re></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_pd']?>" name=udp_op_pd></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_t']?>" name=udp_op_t></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_f']?>" name=udp_op_f></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_op_p']?>" name=udp_op_p></td>	  
      <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_op_pr']?>" name=udp_op_pr></td>    
      <td><input class=za_button type=submit value="确定" name=op_ok></td>
	  <input type=hidden value="OP" name=type>
    </TR>
  </form>
</table>
<br>
<table width="700" border="0" cellpadding="0" cellspacing="1" class="m_tab">
  <TR class="m_title"> 
    <td width=100>刷新设置</td>
    <td width=85>单式繁体</td>
	<td width=85>单式</td>
    <td width=85>单节</td>
    <td width=85>走地</td>
    <td width=85>让球过关</td>
	<td width=85>冠军</td>
    <td width=81>&nbsp; </td>
  </TR>
  <form name=BKR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)> 
      <td> 篮球 </td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_tw']?>" name=udp_bk_tw></td>
	  <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_r']?>" name=udp_bk_r></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_rq']?>" name=udp_bk_rq></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_re']?>" name=udp_bk_re></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_pr']?>" name=udp_bk_pr></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_fs_fs']?>" name=udp_fs_fs></td>
	  <td><input class=za_button type=submit value="确定" name=bk_ok></td>
	  <input type=hidden value="BK" name=type>
    </TR>
  </form>
  <form name=TNR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)>  
      <td>网球</td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_tw']?>" name=udp_tn_tw></td>
	  <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_r']?>" name=udp_tn_r></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_re']?>" name=udp_tn_re></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_pd']?>" name=udp_tn_pd></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_p']?>" name=udp_tn_p></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_pr']?>" name=udp_tn_pr></td>
	  <td><input class=za_button type=submit value="确定" name=tn_ok></td>
	  <input type=hidden value="TN" name=type>
    </TR>
  </form>
  <form name=VBR action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)> 
      <td>排球</td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_vb_tw']?>" name=udp_vb_tw></td>
	  <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_vb_r']?>" name=udp_vb_r></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_vb_re']?>" name=udp_vb_re></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_vb_pd']?>" name=udp_vb_pd></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_vb_p']?>" name=udp_vb_p></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_vb_pr']?>" name=udp_vb_pr></td>
	  <td><input class=za_button type=submit value="确定" name=vb_ok></td>
	  <input type=hidden value="VB" name=type>
    </TR>
  </form>
</table>
<br>
<table width="975" border="0" cellpadding="0" cellspacing="1" class="m_tab">
  <TR class="m_title"> 
    <td width=115>刷新设置</td>
    <td width=65>足球比分</td>
    <td width=65>足球结算</td>
    <td width=65>篮球比分</td>
    <td width=65>篮球结算</td>
    <td width=65>棒球比分</td>
    <td width=65>棒球结算</td>
    <td width=65>网球比分</td>
    <td width=65>网球结算</td>
    <td width=65>排球比分</td>
    <td width=65>排球结算</td>
    <td width=65>其他比分</td>
    <td width=65>其他结算</td>
	<td width=65></td>
  </TR>
    <form name=RESULTS action="" method=post>
    <TR class=m_cen onmouseover=sbar(this) onmouseout=cbar(this)>  
      <td>结果</td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_results']?>" name=udp_ft_results></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_ft_score']?>" name=udp_ft_score></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_results']?>" name=udp_bk_results></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bk_score']?>" name=udp_bk_score></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_results']?>" name=udp_bs_results></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_bs_score']?>" name=udp_bs_score></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_results']?>" name=udp_tn_results></td>
      <td><input class=za_text maxLength=11 size=5 value="<?=$row['udp_tn_score']?>" name=udp_tn_score></td>	  
      <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_vb_results']?>" name=udp_vb_results></td>
	  <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_vb_score']?>" name=udp_vb_score></td>
	  <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_op_results']?>" name=udp_op_results></td>
	  <td><input class=za_text maxlength=11 size=5 value="<?=$row['udp_op_score']?>" name=udp_op_score></td>       
      <td><input class=za_button type=submit value="确定" name=sc_ok></td>
	  <input type=hidden value="RESULT" name=type>
    </TR>
  </form>
</table>
</body>
</html>
