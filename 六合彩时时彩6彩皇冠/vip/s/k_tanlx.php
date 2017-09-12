<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_GET['class2']==""){echo "<script>alert('非法进入!');parent.parent.mem_order.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>"; 
exit;}



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


$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='连肖' and class2='".$_GET['class2']."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_mm=$ka_guanuserkk1[0];

$drop_sort=$_GET['class2'];

switch ($_GET['class2']){
        case "二肖碰":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=40;	
$XF=23;
$rate_id=1029;
$urlurl="index.php?action=k_lx2&ids=二肖碰";


break;



 case "三肖碰":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=41;	
$XF=23;
$rate_id=1030;
$urlurl="index.php?action=k_lx3&ids=三肖碰";


break;

 case "四肖碰":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=42;	
$XF=23;
$rate_id=1031;
$urlurl="index.php?action=k_lx4&ids=四肖碰";


break;
case "五肖碰" : 
$urlurl="index.php?action=k_lx5&ids=五肖碰";
		$bmmm=0;
$cmmm=0;
$dmmm=0;
	
$R=43;	      
$XF=23;
$rate_id=1032;



break;
 case "六肖碰":
 
 $R=43;
 		$bmmm=$bsx6;
$cmmm=$csx6;
$dmmm=$dsx6;      
$XF=23;
$rate_id=688;
$urlurl="index.php?action=k_lx6&ids=六肖碰";
break;
 default:
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=19;	
$XF=23;
$rate_id=686;
$urlurl="index.php?action=k_lx4&ids=四肖碰";
break;

}



?>




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
.STYLE3 {color: #FFFFFF}
.STYLE2 {}
-->
</style></HEAD>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>

<SCRIPT language=javascript>
window.setTimeout("self.location='index.php?action=left'", 30000);
</SCRIPT>
<SCRIPT language=JAVASCRIPT>
if(self == top){location = '/';}

function ChkSubmit(){
    //设定『确定』键为反白 


		document.all.btnSubmit.disabled = true;
	
document.form1.submit();
	} 
</SCRIPT>

<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>

										  
										  
<table width="230" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
        <tr>
          <td width="80%" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
                <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#691A0D" bgcolor="#FDF4CA">
                 <?


$sum_m=$_POST['gold'];

$gold=$_POST['gold'];


if ($sum_m>ka_memuser("ts")){
echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');parent.parent.mem_order.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}

$rate1=1;

$number1=$_POST['number1'];

$pieces = explode(",", $number1);
for ($i=0; $i<count($pieces); $i++) {
	if ($pieces[$i]) {
		// get mdrop
		$result=mysql_query("Select rate from mdrop where class1='连肖' and class2='".$_GET['class2']."' and class3='".$pieces[$i]."'");
		while($image = mysql_fetch_array($result)){
		$mdrop += $image['rate'];
		$aa.=$image['rate'].",";
		}
	}
}
$array=explode(",",$aa);
$rate555=$array[1];

switch (ka_memuser("abcd")){

	case "A":
$rate5=ka_bl($rate_id,"rate")-$mdrop;
$Y=1;
break;
	case "B":
$rate5=ka_bl($rate_id,"rate")-$mdrop-$bmmm;
$Y=4;
	break;
	case "C":
	$Y=5;
$rate5=ka_bl($rate_id,"rate")-$mdrop-$cmmm;
	break;
	case "D":
	$rate5=ka_bl($rate_id,"rate")-$mdrop-$dmmm;
$Y=6;
break;
	default:
	$Y=1;
$rate5=ka_bl($rate_id,"rate")-$mdrop;
break;
}

$rate5=$_POST['min_bl'];

$num=randStr();
$text=date("Y-m-d H:i:s");
$class11=ka_bl($rate_id,"class1");
$class22=ka_bl($rate_id,"class2");
$class33=$number1;
$sum_m=$sum_m;
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

$danid=ka_memuser("danid");
$zongid=ka_memuser("zongid");
$guanid=ka_memuser("guanid");
$memid=ka_memuser("id");


//超过单项

$result2=mysql_query("Select SUM(sum_m) As sum_m from ka_tan where Kithe='".$Current_Kithe_Num."' and  class1='".$class11."' and  class2='".$class22."' and username='".$_SESSION['username']."' "); 
$rs5=mysql_fetch_array($result2);

if (($rs5['sum_m']+$sum_m)>ka_memds($R,3) ){
echo "<script Language=Javascript>alert('对不起，超过单项限额.请反回重新下注!');parent.parent.mem_order.location.href='".$urlurl."';window.location.href='index.php?action=left';</script>";
exit;
}


$sql="INSERT INTO  ka_tan set num='".$num."',username='".$_SESSION['username']."',kithe='".$Current_Kithe_Num."',adddate='".$text."',class1='".$class11."',class2='".$class22."',class3='".$class33."',rate='".$rate5."',sum_m='".$sum_m."',user_ds='".$user_ds."',dai_ds='".$dai_ds."',zong_ds='".$zong_ds."',guan_ds='".$guan_ds."',dai_zc='".$dai_zc."',zong_zc='".$zong_zc."',guan_zc='".$guan_zc."',dagu_zc='".$dagu_zc."',bm=0,dai='".$dai."',zong='".$zong."',guan='".$guan."',danid='".$danid."',zongid='".$zongid."',guanid='".$guanid."',abcd='A',lx=0";
$exe=mysql_query($sql) or  die("数据库修改出错");

//$sql="update ka_mem set ts=ts-".$sum_m." where kauser='".$_SESSION['username']."'";
$sql="update web_member_data set Money=Money-".$sum_m.",Credit=Credit-".$sum_m." where UserName='".$_SESSION['username']."'";
$exe=mysql_query($sql) or die ($sql);	
						  
	
 
 include 'ds.php';	
	?>
                  <tr>
                    <td height="22" colspan="2" align="center" bordercolor="#FDF4CA" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td>
                  </tr>
                  <tr>
                    <td height="22" colspan="2" bordercolor="#FDF4CA" bgcolor="#FFFFFF" style="LINE-HEIGHT: 23px"><font color="#ff0000"><?=$class22?>：<font color="ff6600"><?=$number1?></font></font></td>
                  </tr>
                  <tr>
                    <td width="36%" height="22" align="right" bordercolor="#FDF4CA" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">当前赔率：</span></td>
                    <td width="64%" align="left" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$rate555?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" bordercolor="#FDF4CA" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注金额：</span></td>
                    <td align="left" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" bordercolor="#FDF4CA" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">订单号码：</span></td>
                    <td align="left" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$num?></td>
                  </tr>
                  <tr>
                    <td height="22" colspan="2" align="center" bordercolor="#FDF4CA" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />
&nbsp;&nbsp;
<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="javascript:window.print();" type="button" value="打印"  name="btnSubmit" />&nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="下注成功" name="btnCancel" /></td>
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
