<? 
if(!defined('PHPYOU')) {
	exit('非法进入');
}




function ka_memdaids($i,$b){
$dai=ka_memuser("dan");
$result=mysql_query("Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$dai."' order by id");
$drop_guands = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_guands,$image);
}
return $drop_guands[$i][$b];
}

function ka_memzongds($i,$b){
$zong=ka_memuser("zong");
$result=mysql_query("Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$zong."' order by id");
$drop_guands = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_guands,$image);
}
return $drop_guands[$i][$b];
}
function ka_memguands($i,$b){
$guan=ka_memuser("guan");
$result=mysql_query("Select ds,yg,xx,xxx,ygb,ygc,ygd from ka_quota where username='".$guan."' order by id");
$drop_guands = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_guands,$image);
}
return $drop_guands[$i][$b];
}



$XF=21;
?>
<HTML>
<HEAD>


<link rel="stylesheet" href="images/xp.css" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #11BEF5;
	background-image: url(images/z1.gif);
	background-repeat: repeat-x;
}
body,td,th {
font-size: 9pt;
}
.STYLE1 {color: #FFFFFF}
.STYLE2 {}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=gb2312"></HEAD>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';}
if(window.location.host!=top.location.host){top.location=window.location;}
window.setTimeout("self.location='index.php?action=left'", 60000);
</SCRIPT>


<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=006600><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>
<table width="230" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <td width="80%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
                <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#691A0D" bgcolor="#FDF4CA">
                  <tr>
                    <td height="22" colspan="3" align="center" bordercolor="#FDF4CA" bgcolor="#6fba2c" style="LINE-HEIGHT: 23px"><span class="STYLE1">下注成功</span></td>
                  </tr>
                  <tr>
                    <td height="22" align="center" bordercolor="#FDF4CA" bgcolor="#6fba2c" style="LINE-HEIGHT: 23px"><span class="STYLE1">内容</span></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#6fba2c" style="LINE-HEIGHT: 23px"><span class="STYLE1">赔率</span></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#6fba2c" style="LINE-HEIGHT: 23px"><span class="STYLE1">下注金额</span></td>
                  </tr>
                  <?
$rate_id=$_POST['rate_id'];

$gold=$_POST['gold'];


switch (ka_bl($rate_id,"class2")){



case "五不中":
$R=37;
$ratess2=0;
break;

case "七不中":
$R=38;
$ratess2=0;
break;

}



$sum_sum=$_POST['gold']*$_POST['icradio1'];

if ($sum_sum>ka_memuser("ts")){
echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.parent.mem_order.location.href='index.php?action=k_lm';window.location.href='index.php?action=left';</script>";
exit;
}







$number1=$_POST['number1'];


$mu=explode("/",$number1);

$ioradio1=1;
$t==3;
for ($t=2;$t<count($mu)-1;$t=$t+1){



switch (ka_memuser("abcd")){							  
	case "A":
$Y=1;
break;
	case "B":

$Y=4;
	break;
	case "C":
	$Y=5;

	break;
	case "D":

$Y=6;
break;
	default:
	$Y=1;

break;
}


$num=randStr();
$text=date("Y-m-d H:i:s");
$class11="全不中";
$class22=ka_bl($rate_id,"class2");
$class33=$mu[$t];
$sum_m=$_POST['gold'];
$user_ds=ka_memds($R,1);
$dai_ds=ka_memdaids($R,$Y);
$zong_ds=ka_memzongds($R,$Y);
$guan_ds=ka_memguands($R,$Y);
$dai_zc=ka_memuser("dan_zc");
$zong_zc=ka_memuser("zong_zc");
$guan_zc=ka_memuser("guan_zc");
$dagu_zc=ka_memuser("dagu_zc");
$dai=ka_memuser("dan");
$zong=ka_memuser("zong");
$guan=ka_memuser("guan");



$rnum=explode(",",$class33);


$r1=ka_bl($rnum[0]+1150,"rate");
$r2=ka_bl($rnum[1]+1150,"rate");
$r3=ka_bl($rnum[2]+1150,"rate");
$r4=ka_bl($rnum[3]+1150,"rate");
$r5=ka_bl($rnum[4]+1150,"rate");
$r6=ka_bl($rnum[5]+1150,"rate");


$rate5=$r1;
if ($r2<$rate5){
$rate5=$r2;
}
if ($r3<$rate5){
$rate5=$r3;
}
if ($r4<$rate5){
$rate5=$r4;
}
if ($r5<$rate5){
$rate5=$r5;
}
if ($r6<$rate5){
$rate5=$r6;
}
switch (ka_memuser("abcd")){							  
	case "B":
$rate5=$rate5-$bzx;
	break;
	case "C":
$rate5=$rate5-$czx;
	break;
	case "D":
$rate5=$rate5-$dzx;
break;
	default:
	$Y=1;
break;
}




$danid=ka_memuser("danid");
$zongid=ka_memuser("zongid");
$guanid=ka_memuser("guanid");
$memid=ka_memuser("id");
$abcd=ka_memuser("abcd");

$sql="INSERT INTO  ka_tan set num='".$num."',username='".$_SESSION['username']."',kithe='".$Current_Kithe_Num."',adddate='".$text."',class1='".$class11."',class2='".$class22."',class3='".$class33."',rate='".$rate5."',sum_m='".$sum_m."',user_ds='".$user_ds."',dai_ds='".$dai_ds."',zong_ds='".$zong_ds."',guan_ds='".$guan_ds."',dai_zc='".$dai_zc."',zong_zc='".$zong_zc."',guan_zc='".$guan_zc."',dagu_zc='".$dagu_zc."',bm=0,dai='".$dai."',zong='".$zong."',guan='".$guan."',danid='".$danid."',zongid='".$zongid."',guanid='".$guanid."',abcd='".$abcd."',lx=0,rate2='".$ratess2."'";
$exe=mysql_query($sql) or  die("数据库修改出错");

//$sql="update ka_mem set ts=ts-".$sum_m." where kauser='".$_SESSION['username']."'";
$sql="update web_member_data set Money=Money-".$sum_m.",Credit=Credit-".$sum_m." where UserName='".$_SESSION['username']."'";
$exe=mysql_query($sql) or die ($sql);	
						  
	



?>
                  <tr>
                    <td height="22" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><font color="#ff0000"><?=$class22?>：<font color=ff6600><?=$mu[$t]?></font></font></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$rate5?></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m?></td>
                  </tr>
                  <? }?>
                  <tr>
                    <td height="22" colspan="3" align="center" bordercolor="#FDF4CA" bgcolor="#6fba2c" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />
                      &nbsp;&nbsp;
                      <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="javascript:window.print();" type="button" value="打印"  name="btnSubmit" /></td>
                  </tr>
              </table></td>
        </tr>
        <tr>
          <td height="30" align="center">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
</table>
</BODY></HTML>
