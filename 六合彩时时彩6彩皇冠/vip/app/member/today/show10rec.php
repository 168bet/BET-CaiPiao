<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
require ("../include/traditional.$langx.inc.php");
$sql = "select * from web_member_data where Oid='$uid' and Status<2";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{
$row = mysql_fetch_array($result);
$memname=$row['UserName'];
?>
<html>
<head>
<title>today_wagers</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_order<?=$css?>.css" type="text/css">
<style type="text/css">
<!--
html {margin: 0px; padding: 0px;}
-->
</style>
</head>

<body id="OHIS" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<div style='visibility:visible'>
  <div class="show">
<?
$m_date=date('Y-m-d');
$sql = "select MID,Mtype,MB_MID,TG_MID,Active,ShowType,LineType,BetTime,$middle as Middle,BetScore,M_Date,Gwin,M_Place,M_Rate,Cancel,Danger,Confirmed from web_report_data where M_Name='$memname' and M_Result='' and M_Date>='$m_date' and LineType!=8 order by id desc limit 0,10";
$result = mysql_db_query($dbname,$sql);
while ($row = mysql_fetch_array($result)){
       $time=strtotime($row['BetTime']);
       $times=date("m-d H:i:s",$time);
	   $mb_mid=$row['MB_MID'];
	   $tg_mid=$row['TG_MID'];
	   $betscore=$row['BetScore'];
	   if ($row['Danger']==1){
	       $type=$Order_Pending;
	   }else{
	       $type=$Order_Confirmed;
	   }
	   if ($row['Cancel']==1){
	       $win='<s>$'.$betscore.'</s>';
	   }else{
	       $win='$'.$betscore;
	   }
       switch ($row['LineType']){
             case 1:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             if (strtoupper($row['Mtype'])=='MH'){
				 echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
             }else if (strtoupper($row['Mtype'])=='MC'){
			     echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
             }else if (strtoupper($row['Mtype'])=='MN'){
			     echo $top[0].'  '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR> <font color=#CC0000>'.$Draw.'</font>';
             }
             $bottom=explode('@',$middle[3]);
             echo ' @'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;
			 case 11:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             if (strtoupper($row['Mtype'])=='VMH'){
				 echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR> <font color=#666666>['.$Order_1st_Half.']</font> - ';
             }else if (strtoupper($row['Mtype'])=='VMC'){
			     echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR> <font color=#666666>['.$Order_1st_Half.']</font> - ';
             }else if (strtoupper($row['Mtype'])=='VMN'){
			     echo $top[0].'  '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR> <font color=#CC0000><font color=#666666>['.$Order_1st_Half.']</font> - '.$Draw.'</font>';
             }
             $bottom=explode('@',$middle[3]);
             echo ' @'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;
			 case 2:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
			 if (strtoupper($row['ShowType'])=='H'){
		         if (strtoupper($row['Mtype'])=='RH'){
					 echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }else{
			         echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }
             }else{
		         if (strtoupper($row['Mtype'])=='RC'){
			         echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }else{
			         echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }
             }
             $bottom=explode('@',$middle[3]);
             echo '@'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;
             case 12:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
			 if (strtoupper($row['ShowType'])=='H'){
		         if (strtoupper($row['Mtype'])=='VRH'){
					 echo '<font color=#666666>['.$Order_1st_Half.']</font> - <font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }else{
			         echo '<font color=#666666>['.$Order_1st_Half.']</font> - '.$top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }
             }else{
		         if (strtoupper($row['Mtype'])=='VRC'){
			         echo '<font color=#666666>['.$Order_1st_Half.']</font> - <font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }else{
			         echo '<font color=#666666>['.$Order_1st_Half.']</font> - '.$top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
		         }
             }
             $bottom=explode('@',$middle[3]);
             echo '@'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;
			 case 3:
             $middle=explode('<br>',$row['Middle']);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '  '.$top[0].'  <font color=#0000BB><b>VS.</b></font> '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
             $bottom=explode('&nbsp;',$middle[3]);
             echo $bottom[0].' '.$bottom[1].' @ '.$bottom[3].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;
			 case 13:
             $middle=explode('<br>',$row['Middle']);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '  '.$top[0].'  <font color=#0000BB><b>VS.</b></font> '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B></font><BR>';
             $bottom=explode('&nbsp;',$middle[3]);
             echo '<font color=#CC0000>'.$bottom[3].' - '.$bottom[0].' '.$bottom[1].'</font> @ '.$bottom[5].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;		 
			 case 9:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
			 if (strtoupper($row['ShowType'])=='H'){
		         if (strtoupper($row['Mtype'])=='RRH'){
					 echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }else{
			         echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }
             }else{
		         if (strtoupper($row['Mtype'])=='RRC'){
			         echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }else{
			         echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }
             }
             $bottom=explode('@',$middle[3]);
             echo '@'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;'.$win.'</b>&nbsp;&nbsp;&nbsp;<font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$type.'&nbsp;</b></font><b></b></p>';
             break;
			 case 19:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
			 if (strtoupper($row['ShowType'])=='H'){
		         if (strtoupper($row['Mtype'])=='RRH'){
					 echo '<font color=#666666>['.$Order_1st_Half.']</font> - <font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }else{
			         echo '<font color=#666666>['.$Order_1st_Half.']</font> - '.$top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }
             }else{
		         if (strtoupper($row['Mtype'])=='RRC'){
			         echo '<font color=#666666>['.$Order_1st_Half.']</font> - <font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }else{
			         echo '<font color=#666666>['.$Order_1st_Half.']</font> - '.$top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
		         }
             }
             $bottom=explode('@',$middle[3]);
             echo '@'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;'.$win.'</b>&nbsp;&nbsp;&nbsp;<font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$type.'&nbsp;</b></font><b></b></p>';
             break;
			 case 10:
             $middle=explode('<br>',$row['Middle']);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '  '.$top[0].'  <font color=#0000BB><b>VS.</b></font> '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
             $bottom=explode('&nbsp;',$middle[3]);
             echo $bottom[0].' '.$bottom[1].' @ '.$bottom[3].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b>&nbsp;&nbsp;&nbsp;<font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$type.'&nbsp;</b></font><b></b></p>';
             break;
			 case 20:
             $middle=explode('<br>',$row['Middle']);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '  '.$top[0].'  <font color=#0000BB><b>VS.</b></font> '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
             $bottom=explode('&nbsp;',$middle[3]);
             echo '<font color=#CC0000>'.$bottom[3].' - '.$bottom[0].' '.$bottom[1].'</font> @ '.$bottom[5].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b>&nbsp;&nbsp;&nbsp;<font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$type.'&nbsp;</b></font><b></b></p>';
             break;	
			 case 21:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             if (strtoupper($row['Mtype'])=='RMH'){
				 echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
             }else if (strtoupper($row['Mtype'])=='RMH'){
			     echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR>';
             }else if (strtoupper($row['Mtype'])=='RMN'){
			     echo $top[0].'  '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR> <font color=#CC0000>Draw</font>';
             }
             $bottom=explode('@',$middle[3]);
             echo ' @'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b>&nbsp;&nbsp;&nbsp;<font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$type.'&nbsp;</b></font><b></b></p>';
             break;
			 case 31:
             $middle=explode('<br>',$row['Middle']);
             $top=explode('&nbsp;&nbsp;',$middle[2]);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
             if (strtoupper($row['Mtype'])=='RVMH'){
				 echo '<font color=#CC0000>'.$top[0].' </font> '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B></B>'.$top[3].'</font><BR> <font color=#666666>['.$Order_1st_Half.']</font> - ';
             }else if (strtoupper($row['Mtype'])=='RVMH'){
			     echo $top[0].'  '.$top[1].' <font color=#CC0000>'.$top[2].' </font>&nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR> <font color=#666666>['.$Order_1st_Half.']</font> - ';
             }else if (strtoupper($row['Mtype'])=='RVMN'){
			     echo $top[0].'  '.$top[1].' '.$top[2].' &nbsp;&nbsp;<font class="td_13_c" color=#FF0000><B>'.$top[3].'</B></font><BR> <font color=#CC0000><font color=#666666>['.$Order_1st_Half.']</font> - '.$Draw.'</font>';
             }
             $bottom=explode('@',$middle[3]);
             echo ' @'.$bottom[1].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b>&nbsp;&nbsp;&nbsp;<font color=#ffffff style=background-color:#ff0000><b>&nbsp;'.$type.'&nbsp;</b></font><b></b></p>';
             break;
			 default:
             $middle=explode('<br>',$row['Middle']);
			 echo '<p><em>'.$times.'&nbsp;['.$mb_mid.']vs['.$tg_mid.']</em><br>';
			 echo $middle[2].' <BR>';
             echo $middle[3].'<b>&nbsp;&nbsp;&nbsp;$'.$betscore.'</b></p>';
             break;
}
}
?>
  </div>
</div>
</body>
</html>
<?
}
mysql_close();
?>