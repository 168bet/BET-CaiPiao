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
require ("../include/define_function_list.inc.php");
include "../include/login_session.php";
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$gtype=$_REQUEST['gtype'];
$gdate=$_REQUEST['gdate'];
$gdate1=$_REQUEST['gdate1'];
$mDate=$_REQUEST['today_gmt'];
require ("../include/traditional.$langx.inc.php");

$sql = "select ID,UserName from web_member_data where Oid='$uid' and status<2";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}

$username=$row['UserName'];
$view_date=explode('-',$mDate);
$abc=date('d')-$view_date[2];
$t = time()-$abc*24*60*60;
$xq = array("$His_Week_Sun","$His_Week_Mon","$His_Week_Tue","$His_Week_Wed","$His_Week_Thu","$His_Week_Fri","$His_Week_Sat");
if ($gtype=='ALL'){
	$gtype='FT';
}
?>
<html>
<head>
<title>history_view</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">
<? if ($langx=='en-us' or $langx=='th-tis'){?>
<style type="text/css">
<!--
#MFT #box { width:730px;}
#MFT .explain { white-space: normal!important;}
-->
</style>
<? } ?>
</head>

<body id="M<?=$gtype?>" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td id="ad">
<span class="real_msg"><marquee scrolldelay="120"><?=$mem_msg?></marquee></span>
<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>
    </td>
  </tr>
  <tr>
    <td class="top">
  	  <h1><em><?=$His_Game_account_history?></em><span class="rig"><a href="./history_data.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=ALL&gdate=<?=$gdate?>&gdate1=<?=$gdate1?>"><?=$His_Account_history?></a></span></h1>
	</td>
  </tr>
  <tr>
    <td class="mem">
	  <h2><?=$His_Date?>：<?=$view_date[0]?><?=$His_year?><?=$view_date[1]?><?=$His_month?><?=$view_date[2]?><?=$His_date?> <?=$week?><?=$xq[date("w",$t)]?></h2>
       <table border="0" cellspacing="1" cellpadding="0" class="game">
         <tr> 
          <th width="13%"><?=$His_Betting_Time?></th>
          <th width="12%"><?=$His_Wager_No?></th>
          <th width="51%"><?=$His_Explain?></th>
          <th width="12%"><?=$His_Quinella?></th>
          <th width="12%"><?=$His_Result?></th>
         </tr>
<?
$num=0;
$quinella=0;
$m_result=0;
$sql = "select ID,MID,Active,LineType,Mtype,M_Date,BetTime,$bettype as BetType,$middle as Middle,BetScore,ShowType,M_Place,M_Rate,OddsType,M_Result,betid,Cancel,Confirmed from web_report_data where M_Name='$username' and M_Date='$mDate' and M_Result!='' order by orderby,bettime desc";
$result=mysql_db_query($dbname,$sql);
while($row=mysql_fetch_array($result)){;
$time=strtotime($row['BetTime']);
$times=date("Y-m-d",$time).'<br>'.date("H:i:s",$time);

switch($row['Active']){
case 1:
	$Title=$His_Soccer;
	$data='match_foot';
	break;
case 11:
	$Title=$His_Soccer;
	$data='match_foot';
	break;
case 2:
	$Title=$His_Baseketball;
	$data='match_bask';
	break;
case 22:
	$Title=$His_Baseketball;
	$data='match_bask';
	break;
case 3:
	$Title=$His_BaseBall;
	$data='match_base';
	break;
case 33:
	$Title=$His_BaseBall;
	$data='match_base';
	break;
case 4:
	$Title=$His_Tennis;
	$data='match_tennis';
	break;
case 44:
	$Title=$His_Tennis;
	$data='match_tennis';
	break;
case 5:
	$Title=$His_VolleyBall;
	$data='match_volley';
	break;
case 55:
	$Title=$His_VolleyBall;
	$data='match_volley';
	break;
case 6:
	$Title=$His_Other;
	$data='match_other';
	break;
case 66:
	$Title=$His_Other;
	$data='match_other';
	break;
case 7:
	$Title=$His_Outright;
	$data='match_crown';
	break;
}

switch ($row['OddsType']){
case 'H':
    $Odds='<BR><font color =green>'.$Tod_HK.'</font>';
	break;
case 'M':
    $Odds='<BR><font color =green>'.$Tod_Malay.'</font>';
	break;
case 'I':
    $Odds='<BR><font color =green>'.$Tod_Indo.'</font>';
	break;
case 'E':
    $Odds='<BR><font color =green>'.$Tod_Euro.'</font>';
	break;
default:
    $Odds='';
	break;
}

if ($row['Cancel']==1 or $row['LineType']==9 or $row['LineType']==19 or $row['LineType']==10 or $row['LineType']==20 or $row['LineType']==21 or $row['LineType']==31){
	$datetime="<font color='#FFFFFF'><span style='background-color: #FF0000'>".$times."</span></font>";
}else{
	$datetime=$times;	   
}
if ($row['Cancel']==1) {
    $betscore='<S>'.$row['BetScore'].'</S>';
}else{
    $betscore=$row['BetScore'];
}
?>
        <tr class="b_rig">
          <td align="center"><?=$datetime?></td>
          <td align="center" nowrap><?=$Title?><?=$row['BetType']?><?=$Odds?><br><font color="#0000CC"><?=show_voucher($row['LineType'],$row['ID'])?></font>
          <BR><font color="#CC0000"><B> </B></font></td>
          <td class="explain">		  
<?
	if ($row['LineType']==8){
		$midd=explode('<br>',$row['Middle']);
		$mid=explode(',',$row['MID']);
		$show=explode(',',$row['ShowType']);
		$mtype=explode(',',$row['Mtype']);
		for($t=0;$t<(sizeof($midd)-1)/3;$t++){
			echo $midd[3*$t].'<br>';
			$mysql="select MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where MID=".$mid[$t];
			$result1 = mysql_db_query($dbname,$mysql);
			$row1 = mysql_fetch_array($result1);
		    if ($row1["MB_Inball"]=='-1'){
	            $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-2'){     
	            $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-3'){      
	            $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-4'){     
	            $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-5'){     
	            $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-6'){     
	            $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-7'){     
	            $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-8'){     
	            $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-9'){     
	            $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-10'){     
	            $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-11'){
	            $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-12'){     
	            $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-13'){      
	            $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';	
		    }else if ($row1["MB_Inball"]=='-14'){     
	            $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-15'){     
	            $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-16'){     
	            $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-17'){     
	            $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-18'){     
	            $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-19'){     
	            $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	            $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';	  	 	  
		    }else{
		    	$font_a3='<font color="#009900"><b>'.$row1["TG_Inball"].':'.$row1["MB_Inball"].'</b></font>&nbsp;';
		    	$font_a4='<font color="#009900"><b>'.$row1["MB_Inball"].':'.$row1["TG_Inball"].'</b></font>&nbsp;';
		    }
			echo $midd[3*$t+1].'<br>';
		    if ($show[$t]=='C' and ($mtype[$t]=='RH' or $mtype[$t]=='RC') and $row['LineType']==8){
			    echo $font_a3;
		    }else{
			    echo $font_a4;
		    }
			echo $midd[3*$t+2].'<br>';
		}
	}else if ($row['LineType']==16){
		$midd=explode('<br>',$row['Middle']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
			$mysql="select MB_Inball from match_sports where ID=".$row['MID'];
			$result1 = mysql_db_query($dbname,$mysql);
			$row1 = mysql_fetch_array($result1);
		    if ($row1["MB_Inball"]=='-1'){
	            $lnball='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-2'){     
	            $lnball='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-3'){      
	            $lnball='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-4'){     
	            $lnball='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-5'){     
	            $lnball='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-6'){     
	            $lnball='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-7'){     
	            $lnball='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-8'){     
	            $lnball='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-9'){     
	            $lnball='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-10'){     
	            $lnball='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-11'){
	            $lnball='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-12'){     
	            $lnball='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-13'){      
	            $lnball='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-14'){     
	            $lnball='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-15'){     
	            $lnball='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-16'){     
	            $lnball='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
		    }else if ($row1["MB_Inball"]=='-17'){     
	            $lnball='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-18'){     
	            $lnball='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';	  
		    }else if ($row1["MB_Inball"]=='-19'){     
	            $lnball='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';	  	 	  
		    }else{
		    	$lnball='<font color="#009900"><b>'.$row1["MB_Inball"].'</b></font>&nbsp;';
		    }
		    if ($row1["MB_Inball"]==1){
			    echo '<font color="#009900"><b>冠军&nbsp;</b></font>';
			}else if ($row1["MB_Inball"]==0){
			    echo '<font color="#009900"><b>失败&nbsp;</b></font>';
		    }else if ($row1["MB_Inball"]<0){
			    echo $lnball;
		    }
			echo $midd[sizeof($midd)-1];
	}else{
		$midd=explode('<br>',$row['Middle']);
		for($t=0;$t<sizeof($midd)-1;$t++){
			echo $midd[$t].'<br>';
		}
		$mysql="select MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_sports where MID=".$row['MID'];
		$result1 = mysql_db_query($dbname,$mysql);
		$row1 = mysql_fetch_array($result1);
		
        if ($row1["MB_Inball"]=='-1'){
            if($row1["MB_Inball_HR"]=='-1' and $row1["MB_Inball"]=='-1'){
	           $font_a1='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score1.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-2'){
            if($row1["MB_Inball_HR"]=='-2' and $row1["MB_Inball"]=='-2'){
	           $font_a1='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score2.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-3'){
            if($row1["MB_Inball_HR"]=='-3' and $row1["MB_Inball"]=='-3'){
	           $font_a1='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score3.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-4'){
            if($row1["MB_Inball_HR"]=='-4' and $row1["MB_Inball"]=='-4'){
	           $font_a1='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score4.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-5'){
            if($row1["MB_Inball_HR"]=='-5' and $row1["MB_Inball"]=='-5'){
	           $font_a1='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score5.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-6'){
            if($row1["MB_Inball_HR"]=='-6' and $row1["MB_Inball"]=='-6'){
	           $font_a1='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score6.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-7'){
            if($row1["MB_Inball_HR"]=='-7' and $row1["MB_Inball"]=='-7'){
	           $font_a1='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score7.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-8'){
            if($row1["MB_Inball_HR"]=='-8' and $row1["MB_Inball"]=='-8'){
	           $font_a1='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score8.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-9'){
            if($row1["MB_Inball_HR"]=='-9' and $row1["MB_Inball"]=='-9'){
	           $font_a1='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score9.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-10'){
            if($row1["MB_Inball_HR"]=='-10' and $row1["MB_Inball"]=='-10'){
	           $font_a1='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score10.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-11'){
            if($row1["MB_Inball_HR"]=='-11' and $row1["MB_Inball"]=='-11'){
	           $font_a1='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score11.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-12'){
            if($row1["MB_Inball_HR"]=='-12' and $row1["MB_Inball"]=='-12'){
	           $font_a1='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score12.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-13'){
            if($row1["MB_Inball_HR"]=='-13' and $row1["MB_Inball"]=='-13'){
	           $font_a1='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score13.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-14'){
            if($row1["MB_Inball_HR"]=='-14' and $row1["MB_Inball"]=='-14'){
	           $font_a1='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score14.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-15'){
            if($row1["MB_Inball_HR"]=='-15' and $row1["MB_Inball"]=='-15'){
	           $font_a1='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score15.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-16'){
            if($row1["MB_Inball_HR"]=='-16' and $row1["MB_Inball"]=='-16'){
	           $font_a1='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score16.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-17'){
            if($row1["MB_Inball_HR"]=='-17' and $row1["MB_Inball"]=='-17'){
	           $font_a1='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score17.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-18'){
            if($row1["MB_Inball_HR"]=='-18' and $row1["MB_Inball"]=='-18'){
	           $font_a1='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score18.'</b></font>&nbsp;';
            }
        }else if ($row1["MB_Inball"]=='-19'){
            if($row1["MB_Inball_HR"]=='-19' and $row1["MB_Inball"]=='-19'){
	           $font_a1='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a2='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
            }else{
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp;';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp;';
	           $font_a3='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
	           $font_a4='<font color="#009900"><b>'.$Score19.'</b></font>&nbsp;';
            }  
        }else{
	           $font_a3='<font color="#009900"><b>'.$row1["TG_Inball"].':'.$row1["MB_Inball"].'</b></font> &nbsp;';
	           $font_a4='<font color="#009900"><b>'.$row1["MB_Inball"].':'.$row1["TG_Inball"].'</b></font>&nbsp; ';
	           $font_a1='<font color="#009900"><b>'.$row1["TG_Inball_HR"].':'.$row1["MB_Inball_HR"].'</b></font>&nbsp; ';
	           $font_a2='<font color="#009900"><b>'.$row1["MB_Inball_HR"].':'.$row1["TG_Inball_HR"].'</b></font>&nbsp; ';
        }
		
		if ($row['LineType']==11 or $row['LineType']==12 or $row['LineType']==13 or $row['LineType']==14 or $row['LineType']==19 or $row['LineType']==20 or $row['LineType']==31){
			if ($row['ShowType']=='C' and ($row['LineType']==12 or $row['LineType']==19)){
				echo $font_a1;
			}else{
				echo $font_a2;
			}
		}else{
			if ($row['ShowType']=='C' and ($row['LineType']==2 or $row['LineType']==9)){
				echo $font_a3;
		    }else{
			    echo $font_a4;
		    }
		}
	    echo $midd[sizeof($midd)-1];
    }

?>
          </td>
          <td>
<?
if ($row['Cancel']!=1){
    echo "$row[BetScore]";
}else{
    echo  "<S>$row[BetScore]</S>";
}
?>
        </td>
        <td>
<?
if ($row['Cancel']==1){
switch($row['Confirmed']){
case -1:
$zt=$Score21;
break;
case -2:
$zt=$Score22;
break;
case -3:
$zt=$Score23;
break;
case -4:
$zt=$Score24;
break;
case -5:
$zt=$Score25;
break;
case -6:
$zt=$Score26;
break;
case -7:
$zt=$Score27;
break;
case -8:
$zt=$Score28;
break;
case -9:
$zt=$Score29;
break;
case -10:
$zt=$Score30;
break;
case -11:
$zt=$Score31;
break;
case -12:
$zt=$Score32;
break;
case -13:
$zt=$Score33;
break;
case -14:
$zt=$Score34;
break;
case -15:
$zt=$Score35;
break;
case -16:
$zt=$Score36;
break;
case -17:
$zt=$Score37;
break;
case -18:
$zt=$Score38;
break;
case -19:
$zt=$Score39;
break;
case -20:
$zt=$Score40;
break;
case -21:
$zt=$Score41;
break;
}
	 echo "<font color=#cc0000><b>".$zt."</b></font>";
}else{
	 echo number_format($row['M_Result'],2);
}
?>
          </td>
        </tr>
<?
$num++;
$quinella+=$row['BetScore'];
$m_result+=$row['M_Result'];
}
?>
         <tr class="b_rig">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="td_rig_01"><?=$num?></td>
          <td bgcolor="#CCCCCC"><?=$quinella?></td>
          <td bgcolor="#990000"><font color="#FFFFFF"><?=$m_result?></font></td>
        </tr>
      </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>

<div id="copyright"><?=$Copyright?></div>
</body>
</html>
