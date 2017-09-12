<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
$uid   = $_REQUEST['uid'];
$gtype = $_REQUEST['gtype'];
$page  = $_REQUEST['page_no'];
$flag  = $_REQUEST['flag'];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$sql = "select * from web_agents_data where Oid='$uid' and LoginName='$loginname' and Status<=1";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
} 
$row = mysql_fetch_array($result);
require ("../include/traditional.$langx.inc.php");

if ($flag==''){
	$bdate=date('Y-m-d',time());
}else if($flag=='Y'){
	$bdate=date('Y-m-d',time()-24*60*60);

}
if ($page==''){
	$page=0;
}

switch($gtype){
case 'FT':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_foot where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_ft';
	break;
case 'BK':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_bask where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_bk';
	break;
case 'VB':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_volley where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_vb';
	break;
case 'TN':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_tennis where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_tn';
	break;
case 'BS':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_base where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_bs';
	break;
case 'OP':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_other where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_op';
	break;
case 'FS':
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball from match_crown where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_ft';
	break;
default:
    $sql="select $mb_team as MB_Team,$tg_team as TG_Team,$m_league as M_league,M_Date,M_Time,MB_MID,TG_MID,MB_Inball,TG_Inball,MB_Inball_HR,TG_Inball_HR from match_foot where M_Date='".$bdate."' and MB_Inball!='' order by M_Start,MID";
	$css='_ft';
	$gtype='FT';
	break;
}
$result1 = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result1);
$page_size=40;
$page_count=ceil($cou/$page_size);
$offset=($page)*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_db_query($dbname, $mysql);

?>
<script>
var pg='<?=$page?>';
var t_page='<?=$page_count?>';
var uid='<?=$uid?>';
var flag='<?=$flag?>';
var gtype='<?=$gtype?>';
</script>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<script language="JavaScript"> 
function show_page(){
	var temp="";
	var pg_str=""
	for(var i=0;i<t_page;i++){

		if (pg!=i)
			pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'><font color='#000099'>"+(i+1)+"</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			pg_str=pg_str+"<B><font color='#FF0000'>"+(i+1)+"</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";			
	}
	txt_bodyP= bodyP.innerHTML;			
	txt_bodyP =txt_bodyP.replace("*SHOW_P*",pg_str);    
	pg_txt.innerHTML=txt_bodyP;
}

 function onLoad()
 {
	show_page();
 }

function chg_pg(pg)
{
	self.location = './show_result.php?uid='+uid+'&page_no='+pg+'&flag='+flag+'&gtype='+gtype;
}
 
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF"   onLoad="onLoad()" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline"> 
      <table border="0" cellpadding="0" cellspacing="0" >
        <tr> 
          
          <td nowrap>&nbsp;&nbsp;
<?
if ($flag==''){
?><A HREF="./show_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>&langx=<?=$langx?>&flag=Y" target="_self"><?=$Rep_Yestoday?></A>
<?
}else{
?>
<A HREF="./show_result.php?uid=<?=$uid?>&gtype=<?=$gtype?>&langx=<?=$langx?>" target="_self"><?=$Rep_Today?></A>
<?
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;<?=$Rep_Leg?>:&nbsp;&nbsp;</td>
          
        <td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=FT" target="_self">[<?=$Mnu_Soccer?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BK" target="_self">[<?=$Mnu_Bask?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=TN" target="_self">[<?=$Mnu_Tennis?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=VB" target="_self">[<?=$Mnu_Voll?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=BS" target="_self">[<?=$Mnu_Base?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=OP" target="_self">[<?=$Mnu_Other?>]</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./show_result.php?uid=<?=$uid?>&langx=<?=$langx?>&gtype=FS" target="_self">[<?=$Mnu_Guan?>]</A></td>
        <td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;<span id="pg_txt"></span></td>
        </tr>
      </table>
    </td>
    
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab<?=$css?>" width="650">
  <tr  class="m_title<?=$css?>"> 
    <td  width="40" ><?=$Rel_Body_time?></td>
    <td  width="110"><?=$Rel_Body_league?></td>
    <td  width="50"><?=$Rel_Mid?></td>
    <td  width="263"><?=$Rel_Shometeam?></td>
    <td  width="90"><?=$Res_Half?></td>
    <td  width="90"><?=$Res_Final?></td>
  </tr>
<?
while ($row = mysql_fetch_array($result1)){
$time=strtotime($row['M_Date']);
$times=date("m-d",$time);
?>
  <tr  bgcolor='#FFFFFF'> 
    <td align='center'><?=$times?><BR><?=$row["M_Time"]?></td>

    <td align='center'>
	<?=$row['M_league']?>
	</td>
    <td align='center'><?=$row['MB_MID']?><br><?=$row['TG_MID']?></td>
    <td ><?=$row['MB_Team']?><br><?=$row['TG_Team']?></td>
    <!--td ></td-->	<?
	
	if ($row["MB_Inball"]=='-1'){
      if($row["MB_Inball_HR"]=='-1' and $row["MB_Inball"]=='-1')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec1.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec1.'</b></font>&nbsp;';
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec1.'</b></font>&nbsp;';
	  }
	}
else  if ($row["MB_Inball"]=='-2'){
      if($row["MB_Inball_HR"]=='-2' and $row["MB_Inball"]=='-2')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec2.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec2.'</b></font>&nbsp;';
	
	   }
	else{
	   $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec2.'</b></font>&nbsp;';
	  }
	}
	
else  if ($row["MB_Inball"]=='-3'){
      if($row["MB_Inball_HR"]=='-3' and $row["MB_Inball"]=='-3')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec3.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec3.'</b></font>&nbsp;';
	 
	   }
	else{
	  $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec3.'</b></font>&nbsp;';
	  }
	}
else  if ($row["MB_Inball"]=='-4'){
      if($row["MB_Inball_HR"]=='-4' and $row["MB_Inball"]=='-4')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec4.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec4.'</b></font>&nbsp;';
	 
	   }
	else{
	  $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec4.'</b></font>&nbsp;';
	  }
	}
else  if ($row["MB_Inball"]=='-5'){
      if($row["MB_Inball_HR"]=='-5' and $row["MB_Inball"]=='-5')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec5.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec5.'</b></font>&nbsp;';
	  	
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec5.'</b></font>&nbsp;';
    
	  }
	}
else  if ($row["MB_Inball"]=='-6'){
      if($row["MB_Inball_HR"]=='-6' and $row["MB_Inball"]=='-6')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec6.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec6.'</b></font>&nbsp;';
	  	
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec6.'</b></font>&nbsp;';
    
	  }
	}
else  if ($row["MB_Inball"]=='-7'){
      if($row["MB_Inball_HR"]=='-7' and $row["MB_Inball"]=='-7')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec7.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec7.'</b></font>&nbsp;';
	  	
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec7.'</b></font>&nbsp;';
    
	  }
	}
else  if ($row["MB_Inball"]=='-8'){
      if($row["MB_Inball_HR"]=='-8' and $row["MB_Inball"]=='-8')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec8.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec8.'</b></font>&nbsp;';
	  	
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec8.'</b></font>&nbsp;';
    
	  }
	}
else  if ($row["MB_Inball"]=='-9'){
      if($row["MB_Inball_HR"]=='-9' and $row["MB_Inball"]=='-9')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec9.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec9.'</b></font>&nbsp;';
	  	
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec9.'</b></font>&nbsp;';
    
	  }
	}
else  if ($row["MB_Inball"]=='-10'){
      if($row["MB_Inball_HR"]=='-10' and $row["MB_Inball"]=='-10')
	  {
	    $font_a1='<font color="#009900"><b>'.$sourec10.'</b></font>&nbsp;';
        $font_a2='<font color="#009900"><b>'.$sourec10.'</b></font>&nbsp;';
	  	
	   }
	else{
	    $font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
     
	     $font_a2='<font color="#009900"><b>'.$sourec10.'</b></font>&nbsp;';
    
	  }
	}	
	
else{
$font_a1=$row['MB_Inball_HR'].'<br>'.$row['TG_Inball_HR'];
$font_a2=$row['MB_Inball'].'<br>'.$row['TG_Inball'];
}
	
	?>
   <td align='center'><?=$font_a1?></td>
    <td align='center'><?=$font_a2?></td>
  </tr> 
<?
}
?>

</table>
<span id="bodyP" style="position:absolute; display: none">&nbsp;<?=$Rel_Page?>:&nbsp;&nbsp;*SHOW_P*
</span>
</body>
</html>