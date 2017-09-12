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
$sumall=0;
$rsumall=0;
$sql = "select ID,UserName from web_member_data where Oid='$uid' and status<2";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}else{

	$row = mysql_fetch_array($result);
	$memname=$row['UserName'];
	$mid=$row['ID'];
	$gtype=strtoupper($_REQUEST['gtype']);
	
	if ($gtype=='' or $gtype=='ALL'){
		$gtype='ALL';
		$style='_fu';
		$active='';
	}else if($gtype=='FT'){
		$style='';
		$active=' and (Active=1 or Active=11)';	
	}else{
		$style='_'.strtolower($gtype);
		switch($gtype){
		case 'BK':
			$active=' and (active=2 or active=22)';	
			break;
		case 'BS':
			$active=' and (active=3 or active=33)';	
			break;			
		case 'TN':
			$active=' and (active=4 or active=44)';	
			break;
		case 'VB':
			$active=' and (active=5 or active=55)';	
			break;
		case 'FS':
			$active=' and active=6';	
			break;		}
	}
	
	$gdate=$_REQUEST['gdate'];
	$gdate1=$_REQUEST['gdate1'];
	if ($gdate=='' or $gdate==''){
		$gdate1=date('Y-m-d');
		$gdate=date('Y-m-d',time()-24*60*60);
	}

	$xq = array("$His_Week_Sun","$His_Week_Mon","$His_Week_Tue","$His_Week_Wed","$His_Week_Thu","$His_Week_Fri","$His_Week_Sat");
	
?>
<html>
<head>
<title>history_data</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/member/mem_body<?=$css?>.css" type="text/css">

<script>
function onLoad(){
 var select_object = document.getElementById("gtype");
 select_object.value = '<?=$gtype?>';
 var gdate_object = document.getElementById("gdate");
 gdate_object.value = '<?=$gdate?>';
 var gdate1_object = document.getElementById("gdate1");
 gdate1_object.value = '<?=$gdate1?>';
}
</script>
</head>

<body id="M<?=$gtype?>" onLoad="onLoad()" onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">

<table border="0" cellpadding="0" cellspacing="0" id="box">
  <tr>
    <td id="ad">

<span class="real_msg"><marquee scrolldelay="120"><?=$mem_msg?></marquee></span>
<p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid=<?=$uid?>&langx=<?=$langx?>','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>

</td>
  </tr>
  <tr>
    <td class="top">
  	  <h1><em><?=$Account_History?></em>
	    <form method="post" style="display:inline;">
	      <select name="gtype">
	        <option value="ALL"><?=$His_All?></option>
	        <option value="FT"><?=$His_Soccer?></option>
	        <option value="BK"><?=$His_Baseketball?></option>
	        <option value="TN"><?=$His_Tennis?></option>
	        <option value="VB"><?=$His_VolleyBall?></option>
	        <option value="BS"><?=$His_BaseBall?></option>
			<option value="FS"><?=$His_Outright?></option>
	        <option value="OP"><?=$His_Other?></option>
	      </select>
          <select name="gdate">
	        <?
			$dd = 24*60*60;
			$t = time();
			for($i=7;$i>=0;$i--)
			{
				$today=date('Y-m-d',$t-$i*$dd);
				echo "<option value='$today'>".$today."</option>";	
			}
			?>
	      </select>
          --
	      <select id="gdate1" name="gdate1">
	        <?
			$dd = 24*60*60;
			$t = time();
			for($i=7;$i>=0;$i--)
			{
				$today=date('Y-m-d',$t-$i*$dd);
				echo "<option value='$today'>".$today."</option>";	
			}
			?>
	      </select>
	      <input type=submit value="<?=$His_Search?>">
	    </form>
        <span class="rig"><input type="button" value="六合帐户历史" class="" onClick="location.href='/app/member/six/index.php?action=l';"></span>
  	  </h1>
	  
	</td>
  </tr>
  <tr>
    <td class="mem">
    <table border="0" cellspacing="1" cellpadding="0" class="game">
      <tr> 
        <th width="106"><?=$His_Date?></th>
        <th width="106"><?=$His_Bet_Amount?></th>
        <th width="106"><?=$His_Landing?></th>
        <th width="106"><?=$His_Valid_Amount?></th>
      </tr>
<?
	if ($gdate>$gdate1){
		$t      = $gdate;
		$gdate  = $gdate1;
		$gdate1  = $t;
	}
	$Date_List_1=explode("-",$gdate1);
	$Date_List_2=explode("-",$gdate);
	$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
	$d2=mktime(0,0,0,$Date_List_2[1],$Date_List_2[2],$Date_List_2[0]);
	$days=round(($d1-$d2)/3600/24);
	for($i=$days;$i>=0;$i--)
	{
		$t=$d2+$i*$dd;
		$today=date('m-d ',$t).$week.$xq[date("w",$t)];
		$sql="select sum(vgold) as vgold,sum(betscore) as betscore,sum(m_result) as m_result from web_report_data where m_result!='' and m_date='".date('Y-m-d',$d2+$i*$dd)."' and m_name='$memname'".$active;
		$result = mysql_db_query($dbname,$sql);
		$row = mysql_fetch_array($result);
		$sum=$row['betscore']+0;
		$rsum=number_format($row['m_result']+0,2);

		$aa=$aa+$row['betscore'];
		$bb=$bb+$row['m_result'];
		$vgold=$vgold+$row['vgold'];

		if($sum>0){
            $link='<a href="'."history_view.php?uid=$uid&member_id=$mid&tmp_flag=N&today_gmt=".date('Y-m-d',$d2+$i*$dd)."&gtype=$gtype&gdate=$gdate&gdate1=$gdate1&langx=$langx".'">'.$today.'</a>';
        }else{
		    $link=$today;
		}
		echo '<tr class="b_rig" > 
		    <td><span class="b_fwn"><font color=#CC0000>'.$link.'</font></span></td>
	    	<td>'.$sum.'</td>
		    <td>'.$rsum.'</td>
	    	<td>'.number_format($row['vgold']).'</td>
		  </tr>';
	}
?>

      <tr class="b_rig">
        <td class="b_fwn"><?=$His_Week_Total?></td>
        <td><?=$aa?></td>
        <td><?=number_format($bb,2)?></td>
        <td><?=number_format($vgold)?></td>
      </tr>
    </table> 
	</td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>


<div id="copyright"><?=$Copyright?></div>

</body>
</html>
<?
}
mysql_close();
?>
