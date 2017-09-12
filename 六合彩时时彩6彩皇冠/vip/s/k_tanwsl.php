<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_GET['class2']==""){echo "<script>alert('非法进入!');window.location.href='index.php?action=left';</script>"; 
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


$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='尾数连' and class2='".$_GET['class2']."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_mm=$ka_guanuserkk1[0];

$drop_sort=$_GET['class2'];

switch ($_GET['class2']){

 case "二尾连中":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=56;	
$XF=23;
break;

 case "三尾连中":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=57;	
$XF=23;
break;
 case "四尾连中":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=58;	
$XF=23;
break;

 case "二尾连不中":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=59;	
$XF=23;
break;
 case "三尾连不中":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=60;	
$XF=23;
break;
 case "四尾连不中":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=61;	
$XF=23;
break;

}



?>




<LINK rel=stylesheet type=text/css href="imgs/left.css"><LINK 
rel=stylesheet type=text/css href="imgs/ball1x.css"><LINK 
rel=stylesheet type=text/css href="imgs/loto_lb.css">
<style type="text/css">
<!--
body,td,th {
	font-size: 9pt;
}
.STYLE3 {color: #FFFFFF}
.STYLE4 {color: #000}
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
		document.all.btnSubmit.disabled = true;
document.form1.submit();
	} 
</SCRIPT>

<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=006600><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
  exit;
}


?>

										  
										  
<TABLE class=Tab_backdrop cellSpacing=0 cellPadding=0 width=230 border=0>
<tr>
    <td valign="top" class="Left_Place">
        <TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
        <tr>
          <td height="28" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#5A79C6" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td>
          </tr>
        <tr>
          <td height="22" align="center"class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td>
          <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td>
          <td align="center" class=left_acc_out_top style="LINE-HEIGHT: 23px"><span class="STYLE3">下注金额</span></td>
        </tr>
				      <?


$sum_m=$_POST['gold']*$_POST['ioradio1'];

$gold=$_POST['gold'];


if ($sum_m>ka_memuser("ts")){
echo "<script Language=Javascript>alert('对不起，下注总额不能大于可用信用额');window.location.href='index.php?action=left';</script>";
exit;
}

$rate1=1;

$number1=$_POST['number1'];


$mu=explode("/",$number1);

$ioradio1=1;
$t==3;
for ($t=0;$t<count($mu);$t=$t+1){


$muname=explode(",",$mu[$t]);

switch ($_GET['class2']){

 case "二尾连中":

switch ($muname[0]){							  

case "1":
$r1=1301;
break;
case "2":
$r1=1302;
break;
case "3":
$r1=1303;
break;
case "4":
$r1=1304;
break;
case "5":
$r1=1305;
break;
case "6":
$r1=1306;
break;
case "7":
$r1=1307;
break;
case "8":
$r1=1308;
break;
case "9":
$r1=1309;
break;
case "0":
$r1=1310;
break;

}
switch ($muname[1]){							  

case "1":
$r2=1301;
break;
case "2":
$r2=1302;
break;
case "3":
$r2=1303;
break;
case "4":
$r2=1304;
break;
case "5":
$r2=1305;
break;
case "6":
$r2=1306;
break;
case "7":
$r2=1307;
break;
case "8":
$r2=1308;
break;
case "9":
$r2=1309;
break;
case "0":
$r2=1310;
break;
}
$rate1=ka_bl($r1,"rate");
$rate2=ka_bl($r2,"rate");
if ($rate2<$rate1) $rate1=$rate2;
break;


 case "二尾连不中":

switch ($muname[0]){							  

case "1":
$r1=1331;
break;
case "2":
$r1=1332;
break;
case "3":
$r1=1333;
break;
case "4":
$r1=1334;
break;
case "5":
$r1=1335;
break;
case "6":
$r1=1336;
break;
case "7":
$r1=1337;
break;
case "8":
$r1=1338;
break;
case "9":
$r1=1339;
break;
case "0":
$r1=1340;
break;
}
switch ($muname[1]){							  

case "1":
$r2=1331;
break;
case "2":
$r2=1332;
break;
case "3":
$r2=1333;
break;
case "4":
$r2=1334;
break;
case "5":
$r2=1335;
break;
case "6":
$r2=1336;
break;
case "7":
$r2=1337;
break;
case "8":
$r2=1338;
break;
case "9":
$r2=1339;
break;
case "0":
$r2=1340;
break;
}
$rate1=ka_bl($r1,"rate");
$rate2=ka_bl($r2,"rate");
if ($rate2<$rate1) $rate1=$rate2;
break;





 case "三尾连中":

switch ($muname[0]){							  

case "1":
$r1=1311;
break;
case "2":
$r1=1312;
break;
case "3":
$r1=1313;
break;
case "4":
$r1=1314;
break;
case "5":
$r1=1315;
break;
case "6":
$r1=1316;
break;
case "7":
$r1=1317;
break;
case "8":
$r1=1318;
break;
case "9":
$r1=1319;
break;
case "0":
$r1=1320;
break;

}
switch ($muname[1]){							  
case "1":
$r2=1311;
break;
case "2":
$r2=1312;
break;
case "3":
$r2=1313;
break;
case "4":
$r2=1314;
break;
case "5":
$r2=1315;
break;
case "6":
$r2=1316;
break;
case "7":
$r2=1317;
break;
case "8":
$r2=1318;
break;
case "9":
$r2=1319;
break;
case "0":
$r2=1320;
break;
}
switch ($muname[2]){							  
case "1":
$r3=1311;
break;
case "2":
$r3=1312;
break;
case "3":
$r3=1313;
break;
case "4":
$r3=1314;
break;
case "5":
$r3=1315;
break;
case "6":
$r3=1316;
break;
case "7":
$r3=1317;
break;
case "8":
$r3=1318;
break;
case "9":
$r3=1319;
break;
case "0":
$r3=1320;
break;
}
$rate1=ka_bl($r1,"rate");
$rate2=ka_bl($r2,"rate");
$rate3=ka_bl($r3,"rate");
if ($rate2<$rate1) $rate1=$rate2;
if ($rate3<$rate1) $rate1=$rate3;
break;


 case "三尾连不中":

switch ($muname[0]){							  

case "1":
$r1=1341;
break;
case "2":
$r1=1342;
break;
case "3":
$r1=1343;
break;
case "4":
$r1=1344;
break;
case "5":
$r1=1345;
break;
case "6":
$r1=1346;
break;
case "7":
$r1=1347;
break;
case "8":
$r1=1348;
break;
case "9":
$r1=1349;
break;
case "0":
$r1=1350;
break;

}
switch ($muname[1]){							  
case "1":
$r2=1341;
break;
case "2":
$r2=1342;
break;
case "3":
$r2=1343;
break;
case "4":
$r2=1344;
break;
case "5":
$r2=1345;
break;
case "6":
$r2=1346;
break;
case "7":
$r2=1347;
break;
case "8":
$r2=1348;
break;
case "9":
$r2=1349;
break;
case "0":
$r2=1350;
break;
}
switch ($muname[2]){							  
case "1":
$r3=1341;
break;
case "2":
$r3=1342;
break;
case "3":
$r3=1343;
break;
case "4":
$r3=1344;
break;
case "5":
$r3=1345;
break;
case "6":
$r3=1346;
break;
case "7":
$r3=1347;
break;
case "8":
$r3=1348;
break;
case "9":
$r3=1349;
break;
case "0":
$r3=1350;
break;
}
$rate1=ka_bl($r1,"rate");
$rate2=ka_bl($r2,"rate");
$rate3=ka_bl($r3,"rate");
if ($rate2<$rate1) $rate1=$rate2;
if ($rate3<$rate1) $rate1=$rate3;
break;


 case "四尾连中":

switch ($muname[0]){							  

case "1":
$r1=1321;
break;
case "2":
$r1=1322;
break;
case "3":
$r1=1323;
break;
case "4":
$r1=1324;
break;
case "5":
$r1=1325;
break;
case "6":
$r1=1326;
break;
case "7":
$r1=1327;
break;
case "8":
$r1=1328;
break;
case "9":
$r1=1329;
break;
case "0":
$r1=1330;
break;

}
switch ($muname[1]){							  
case "1":
$r2=1321;
break;
case "2":
$r2=1322;
break;
case "3":
$r2=1323;
break;
case "4":
$r2=1324;
break;
case "5":
$r2=1325;
break;
case "6":
$r2=1326;
break;
case "7":
$r2=1327;
break;
case "8":
$r2=1328;
break;
case "9":
$r2=1329;
break;
case "0":
$r2=1330;
break;
}
switch ($muname[2]){							  
case "1":
$r3=1321;
break;
case "2":
$r3=1322;
break;
case "3":
$r3=1323;
break;
case "4":
$r3=1324;
break;
case "5":
$r3=1325;
break;
case "6":
$r3=1326;
break;
case "7":
$r3=1327;
break;
case "8":
$r3=1328;
break;
case "9":
$r3=1329;
break;
case "0":
$r3=1330;
break;
}
switch ($muname[3]){							  
case "1":
$r4=1321;
break;
case "2":
$r4=1322;
break;
case "3":
$r4=1323;
break;
case "4":
$r4=1324;
break;
case "5":
$r4=1325;
break;
case "6":
$r4=1326;
break;
case "7":
$r4=1327;
break;
case "8":
$r4=1328;
break;
case "9":
$r4=1329;
break;
case "0":
$r4=1330;
break;
}

$rate1=ka_bl($r1,"rate");
$rate2=ka_bl($r2,"rate");
$rate3=ka_bl($r3,"rate");
$rate4=ka_bl($r4,"rate");
if ($rate2<$rate1) $rate1=$rate2;
if ($rate3<$rate1) $rate1=$rate3;
if ($rate4<$rate1) $rate1=$rate4;
break;

 case "四尾连不中":

switch ($muname[0]){							  

case "1":
$r1=1351;
break;
case "2":
$r1=1352;
break;
case "3":
$r1=1353;
break;
case "4":
$r1=1354;
break;
case "5":
$r1=1355;
break;
case "6":
$r1=1356;
break;
case "7":
$r1=1357;
break;
case "8":
$r1=1358;
break;
case "9":
$r1=1359;
break;
case "0":
$r1=1360;
break;

}
switch ($muname[1]){							  
case "1":
$r2=1351;
break;
case "2":
$r2=1352;
break;
case "3":
$r2=1353;
break;
case "4":
$r2=1354;
break;
case "5":
$r2=1355;
break;
case "6":
$r2=1356;
break;
case "7":
$r2=1357;
break;
case "8":
$r2=1358;
break;
case "9":
$r2=1359;
break;
case "0":
$r2=1360;
break;
}
switch ($muname[2]){							  
case "1":
$r3=1351;
break;
case "2":
$r3=1352;
break;
case "3":
$r3=1353;
break;
case "4":
$r3=1354;
break;
case "5":
$r3=1355;
break;
case "6":
$r3=1356;
break;
case "7":
$r3=1357;
break;
case "8":
$r3=1358;
break;
case "9":
$r3=1359;
break;
case "0":
$r3=1360;
break;
}
switch ($muname[3]){							  
case "1":
$r4=1351;
break;
case "2":
$r4=1352;
break;
case "3":
$r4=1353;
break;
case "4":
$r4=1354;
break;
case "5":
$r4=1355;
break;
case "6":
$r4=1356;
break;
case "7":
$r4=1357;
break;
case "8":
$r4=1358;
break;
case "9":
$r4=1359;
break;
case "0":
$r4=1360;
break;
}

$rate1=ka_bl($r1,"rate");
$rate2=ka_bl($r2,"rate");
$rate3=ka_bl($r3,"rate");
$rate4=ka_bl($r4,"rate");
if ($rate2<$rate1) $rate1=$rate2;
if ($rate3<$rate1) $rate1=$rate3;
if ($rate4<$rate1) $rate1=$rate4;
break;

}

switch (ka_memuser("abcd")){							  

	case "A":
$rate5=$rate1;
$Y=1;
break;
	case "B":
$rate5=$rate1-$bmmm;
$Y=4;
	break;
	case "C":
	$Y=5;
$rate5=$rate1-$cmmm;
	break;
	case "D":
	$rate5=$rate1-$dmmm;
$Y=6;
break;
	default:
	$Y=1;
$rate5=$rate1;
break;
}







$num=randStr();
$text=date("Y-m-d H:i:s");
$class11=ka_bl($rate_id,"class1");
$class22=ka_bl($rate_id,"class2");
$class33=$mu[$t];
//$gold=$gold;
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
$abcd=ka_memuser("abcd");




$sql="INSERT INTO  ka_tan set num='".$num."',username='".$_SESSION['username']."',kithe='".$Current_Kithe_Num."',adddate='".$text."',class1='".$class11."',class2='".$class22."',class3='".$class33."',rate='".$rate5."',sum_m='".$gold."',user_ds='".$user_ds."',dai_ds='".$dai_ds."',zong_ds='".$zong_ds."',guan_ds='".$guan_ds."',dai_zc='".$dai_zc."',zong_zc='".$zong_zc."',guan_zc='".$guan_zc."',dagu_zc='".$dagu_zc."',bm=0,dai='".$dai."',zong='".$zong."',guan='".$guan."',danid='".$danid."',zongid='".$zongid."',guanid='".$guanid."',abcd='".$abcd."',lx=0";
$exe=mysql_query($sql) or  die("数据库修改出错");

//$sql="update ka_mem set ts=ts-".$gold." where kauser='".$_SESSION['username']."'";
$sql="update web_member_data set Money=Money-".$gold.",Credit=Credit-".$gold." where UserName='".$_SESSION['username']."'";
$exe=mysql_query($sql) or die ($sql);	
 
 include 'ds.php';	
	?>
                
				  
   <tr>
                    <td height="22" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><font color="#ff0000"><?=$class22?>：<font color=ff6600><?=$mu[$t]?></font></font></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$rate5?></td>
                    <td align="center" bordercolor="#FDF4CA" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><?=$gold?></td>
                  </tr>
                  <? }?>				  
				  
                  <tr>
                    <td height="22" colspan="3" align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />
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
