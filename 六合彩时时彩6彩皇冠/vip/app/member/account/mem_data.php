<?
session_start();
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$mtype=$_REQUEST['mtype'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and status<2";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$memname=$row['UserName'];
$credit=$row['Money'];	
?>
<html>
<head>
<title>mem_data</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
</head>
<body id="MFT" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<script language=javascript>
function Go_Chg_pass(){
	Real_Win=window.open("chg_passwd.php?uid=<?=$uid?>","Chg_pass","width=360,height=166,status=no");
}
function getgrpdomain(){
	Real_Win=window.open("grpdomain.php?uid=<?=$uid?>","grpdomain","width=450,height=600,status=no");
}
</script>
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td id="ad">

<span class="real_msg"><marquee scrolldelay="120"><?=$mem_msg?></marquee></span>
<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>

</td>
  </tr>
  <tr>
    <td class="top">
  	  <h1><em><?=$Data?></em>
  	  	<input type="button" name="Submit323" value="<?=$Edit_Password?>" onClick="Go_Chg_pass();">
  	  	<input type="button" name="grpdomain" value="<?=$Real_news?>" onClick="getgrpdomain();">
  	  	</h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
    <table border="0" cellspacing="1" cellpadding="0" class="game">
      <tr class="b_lef"> 
        <td width="20%"><?=$Login_Name?></td>
        <td colspan="6"><?=$memname?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Credit_Line?></td>
        <td  colspan="6"><?=$credit?></td>
      </tr>
      <form method=post onSubmit="return SubChk()"></form>
      <tr> 
        <td colspan="7" class="b_hline"><?=$Single_Game_Limit?></td>
      </tr>
      <tr class="b_lef"> 
        <th>&nbsp;</th>
        <th width="14%"><?=$Mem_Soccer?></th>
        <th width="14%"><?=$Mem_Baseketball?></th>
        <th width="14%"><?=$Mem_Tennis?></th>
        <th width="14%"><?=$Mem_VolleyBall?></th>   
        <th width="14%"><?=$Mem_BaseBall?></th>
        <th width="14%"><?=$Mem_Other?></th>    
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Handicap?></td>
        <td><?=$row['FT_R_Scene']?></td>
        <td><?=$row['BK_R_Scene']?></td>
        <td><?=$row['TN_R_Scene']?></td>
        <td><?=$row['VB_R_Scene']?></td>
        <td><?=$row['BS_R_Scene']?></td>
        <td><?=$row['OP_R_Scene']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Over_Under?></td>
        <td><?=$row['FT_OU_Scene']?></td>
        <td><?=$row['BK_OU_Scene']?></td>
        <td><?=$row['TN_OU_Scene']?></td>
        <td><?=$row['VB_OU_Scene']?></td>
        <td><?=$row['BS_OU_Scene']?></td>
        <td><?=$row['OP_OU_Scene']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_1_x_2?></td>
        <td><?=$row['FT_M_Scene']?></td>
        <td>*</td>
        <td><?=$row['TN_M_Scene']?></td>
        <td><?=$row['VB_M_Scene']?></td>
        <td><?=$row['BS_M_Scene']?></td>
        <td><?=$row['OP_M_Scene']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Running_Ball?></td>
        <td><?=$row['FT_RE_Scene']?></td>
        <td><?=$row['BK_RE_Scene']?></td>
        <td><?=$row['TN_RE_Scene']?></td>
        <td><?=$row['VB_RE_Scene']?></td>
        <td><?=$row['BS_RE_Scene']?></td>
        <td><?=$row['OP_RE_Scene']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_R_B_Over_Under?></td>
        <td><?=$row['FT_ROU_Scene']?></td>
        <td><?=$row['BK_ROU_Scene']?></td>
        <td><?=$row['TN_ROU_Scene']?></td>
        <td><?=$row['VB_ROU_Scene']?></td>
        <td><?=$row['BS_ROU_Scene']?></td>
        <td><?=$row['OP_ROU_Scene']?></td>
      </tr> 
	  <tr class="b_lef">
        <td><?=$Mem_R_B_1_x_2?></td>
        <td><?=$row['FT_RM_Scene']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>       
      <tr class="b_lef"> 
        <td><?=$Mem_1_x_2_Parlay?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$row['TN_P_Scene']?></td>
        <td><?=$row['VB_P_Scene']?></td>
        <td><?=$row['BS_P_Scene']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr  class="b_lef">
        <td><?=$Mem_Handicap_Parlay?></td>
        <td></td>
        <td><?=$row['BK_PR_Scene']?></td>
        <td><?=$row['TN_PR_Scene']?></td>
        <td><?=$row['VB_PR_Scene']?></td>
        <td><?=$row['BS_PR_Scene']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr  class="b_lef">
        <td><?=$Mem_Mix_Parlay?></td>
        <td><?=$row['FT_PR_Scene'];?></td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
        <td><?=$row['FT_OP_Scene'];?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Correct_Score?></td>
        <td><?=$row['FT_PD_Scene'];?></td>
        <td>&nbsp;</td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Total_Goals?></td>
        <td><?=$row['FT_T_Scene'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$row['BS_T_Scene'];?></td>
        <td><?=$row['OP_T_Scene'];?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Odd_Even?></td>
        <td><?=$row['FT_EO_Scene']?></td>
        <td><?=$row['BK_EO_Scene']?></td>
        <td><?=$row['TN_EO_Scene']?></td>
        <td><?=$row['VB_EO_Scene']?></td>
        <td><?=$row['BS_EO_Scene']?></td>
        <td><?=$row['OP_EO_Scene']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Half_Full_Time?></td>
        <td><?=$row['FT_F_Scene']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$row['OP_F_Scene']?></td>
      </tr>
      <tr > 
        <td colspan="7" class="b_hline"><?=$Single_Bet_Limit?></td>
      </tr>
      <tr class="b_lef"> 
        <th>&nbsp;</th>
        <th width="14%"><?=$Mem_Soccer?></th>
        <th width="14%"><?=$Mem_Baseketball?></th>
        <th width="14%"><?=$Mem_Tennis?></th>
        <th width="14%"><?=$Mem_VolleyBall?></th>   
        <th width="14%"><?=$Mem_BaseBall?></th>
        <th width="14%"><?=$Mem_Other?></th>    
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Handicap?></td>
        <td><?=$row['FT_R_Bet']?></td>
        <td><?=$row['BK_R_Bet']?></td>
        <td><?=$row['TN_R_Bet']?></td>
        <td><?=$row['VB_R_Bet']?></td>
        <td><?=$row['BS_R_Bet']?></td>
        <td><?=$row['OP_R_Bet']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Over_Under?></td>
        <td><?=$row['FT_OU_Bet']?></td>
        <td><?=$row['BK_OU_Bet']?></td>
        <td><?=$row['TN_OU_Bet']?></td>
        <td><?=$row['VB_OU_Bet']?></td>
        <td><?=$row['BS_OU_Bet']?></td>
        <td><?=$row['OP_OU_Bet']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_1_x_2?></td>
        <td><?=$row['FT_M_Bet']?></td>
        <td>*</td>
        <td><?=$row['TN_M_Bet']?></td>
        <td><?=$row['VB_M_Bet']?></td>
        <td><?=$row['BS_M_Bet']?></td>
        <td><?=$row['OP_M_Bet']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Running_Ball?></td>
        <td><?=$row['FT_RE_Bet']?></td>
        <td><?=$row['BK_RE_Bet']?></td>
        <td><?=$row['TN_RE_Bet']?></td>
        <td><?=$row['VB_RE_Bet']?></td>
        <td><?=$row['BS_RE_Bet']?></td>
        <td><?=$row['OP_RE_Bet']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_R_B_Over_Under?></td>
        <td><?=$row['FT_ROU_Bet']?></td>
        <td><?=$row['BK_ROU_Bet']?></td>
        <td><?=$row['TN_ROU_Bet']?></td>
        <td><?=$row['VB_ROU_Bet']?></td>
        <td><?=$row['BS_ROU_Bet']?></td>
        <td><?=$row['OP_ROU_Bet']?></td>
      </tr> 
	  <tr class="b_lef">
        <td><?=$Mem_R_B_1_x_2?></td>
        <td><?=$row['FT_RM_Bet']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>       
      <tr class="b_lef"> 
        <td><?=$Mem_1_x_2_Parlay?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$row['TN_P_Bet']?></td>
        <td><?=$row['VB_P_Bet']?></td>
        <td><?=$row['BS_P_Bet']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr  class="b_lef">
        <td><?=$Mem_Handicap_Parlay?></td>
        <td></td>
        <td><?=$row['BK_PR_Bet']?></td>
        <td><?=$row['TN_PR_Bet']?></td>
        <td><?=$row['VB_PR_Bet']?></td>
        <td><?=$row['BS_PR_Bet']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr  class="b_lef">
        <td><?=$Mem_Mix_Parlay?></td>
        <td><?=$row['FT_PR_Bet'];?></td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
        <td><?=$row['FT_OP_Bet'];?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Correct_Score?></td>
        <td><?=$row['FT_PD_Bet'];?></td>
        <td>&nbsp;</td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
        <td>10000</td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Total_Goals?></td>
        <td><?=$row['FT_T_Bet'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$row['BS_T_Bet'];?></td>
        <td><?=$row['OP_T_Bet'];?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Odd_Even?></td>
        <td><?=$row['FT_EO_Bet']?></td>
        <td><?=$row['BK_EO_Bet']?></td>
        <td><?=$row['TN_EO_Bet']?></td>
        <td><?=$row['VB_EO_Bet']?></td>
        <td><?=$row['BS_EO_Bet']?></td>
        <td><?=$row['OP_EO_Bet']?></td>
      </tr>
      <tr class="b_lef"> 
        <td><?=$Mem_Half_Full_Time?></td>
        <td><?=$row['FT_F_Bet']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?=$row['OP_F_Bet']?></td>
      </tr>
    </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>

<div id="copyright"><?=$Copyright?></div> 
</body>
</html>