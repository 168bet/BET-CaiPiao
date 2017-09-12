<? if(!defined('PHPYOU')) {

	exit('非法进入');

}


if ($_GET['class2']==""){echo "<script>alert('非法进入!');parent.parent.mem_order.location.href='index.php?action=k_zx.php';window.location.href='index.php?action=left';</script>"; 

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



if ($_POST['name']=="save"){



	switch (ka_memuser("abcd")){							  



	case "A":

$Y=1;

break;

	case "B":
if($_POST['lx']=="五不中"){$rate=ka_bl('1021',"rate")-$bzx;}
if($_POST['lx']=="六不中"){$rate=ka_bl('1022',"rate")-$bzx;}
if($_POST['lx']=="七不中"){$rate=ka_bl('1023',"rate")-$bzx;}
if($_POST['lx']=="八不中"){$rate=ka_bl('1024',"rate")-$bzx;}
if($_POST['lx']=="九不中"){$rate=ka_bl('1025',"rate")-$bzx;}
if($_POST['lx']=="十不中"){$rate=ka_bl('1026',"rate")-$bzx;}
if($_POST['lx']=="十一不中"){$rate=ka_bl('1027',"rate")-$bzx;}
if($_POST['lx']=="十二不中"){$rate=ka_bl('1028',"rate")-$bzx;}
$Y=4;

	break;

	case "C":

	$Y=5;
if($_POST['lx']=="五不中"){$rate=ka_bl('1021',"rate")-$czx;}
if($_POST['lx']=="六不中"){$rate=ka_bl('1022',"rate")-$czx;}
if($_POST['lx']=="七不中"){$rate=ka_bl('1023',"rate")-$czx;}
if($_POST['lx']=="八不中"){$rate=ka_bl('1024',"rate")-$czx;}
if($_POST['lx']=="九不中"){$rate=ka_bl('1025',"rate")-$czx;}
if($_POST['lx']=="十不中"){$rate=ka_bl('1026',"rate")-$czx;}
if($_POST['lx']=="十一不中"){$rate=ka_bl('1027',"rate")-$czx;}
if($_POST['lx']=="十二不中"){$rate=ka_bl('1028',"rate")-$czx;}

	break;

	case "D":

$Y=6;
if($_POST['lx']=="五不中"){$rate=ka_bl('1021',"rate")-$dzx;}
if($_POST['lx']=="六不中"){$rate=ka_bl('1022',"rate")-$dzx;}
if($_POST['lx']=="七不中"){$rate=ka_bl('1023',"rate")-$dzx;}
if($_POST['lx']=="八不中"){$rate=ka_bl('1024',"rate")-$dzx;}
if($_POST['lx']=="九不中"){$rate=ka_bl('1025',"rate")-$dzx;}
if($_POST['lx']=="十不中"){$rate=ka_bl('1026',"rate")-$dzx;}
if($_POST['lx']=="十一不中"){$rate=ka_bl('1027',"rate")-$dzx;}
if($_POST['lx']=="十二不中"){$rate=ka_bl('1028',"rate")-$dzx;}

break;

	default:

	$Y=1;

break;

}

 

for ($t=1;$t<=49;$t++){

if ($_POST['num'.$t]!=""){

$class33.=$_POST['num'.$t].",";

}

}
if($_GET['class2']=="自选"){
$R=37;
}
if($_GET['class2']=="连肖"){
$R=36;
}

$num=randStr();

$text=date("Y-m-d H:i:s");

$class11=$_POST['class1'];

$class22=$_POST['class3'];

$class333=$class33;

$sum_m=$_POST['sum_m'];

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


$sql="INSERT INTO  ka_tan set num='".$num."',username='".$_SESSION['username']."',kithe='".$Current_Kithe_Num."',adddate='".$text."',class1='".$class11."',class2='".$class22."',class3='".$class333."',rate='".$rate."',sum_m='".$sum_m."',user_ds='".$user_ds."',dai_ds='".$dai_ds."',zong_ds='".$zong_ds."',guan_ds='".$guan_ds."',dai_zc='".$dai_zc."',zong_zc='".$zong_zc."',guan_zc='".$guan_zc."',dagu_zc='".$dagu_zc."',bm=0,dai='".$dai."',zong='".$zong."',guan='".$guan."',danid='".$danid."',zongid='".$zongid."',guanid='".$guanid."',abcd='A',lx=0";

$exe=mysql_query($sql) or  die("数据库修改出错");



//$sql="update ka_mem set ts=ts-".$sum_m." where kauser='".$_SESSION['username']."'";
$sql="update web_member_data set Money=Money-".$sum_m.",Credit=Credit-".$sum_m." where UserName='".$_SESSION['username']."'";

$exe=mysql_query($sql) or die ($sql);


}





$class3=$_POST['lx'];

$result=mysql_query("Select class3,class2,rate,id,class1 from ka_bl where class2='".$_GET['class2']."' and class3='".$class3."' order by id");

$drop_table = array();

$y=0;

while($image = mysql_fetch_array($result)){

$y++;

array_push($drop_table,$image);



}

$xc=23;



$XF=11;

switch ($drop_table[0][4]){

  case "自选":

  $bmmm=$bzx;

  $cmmm=$czx;

  $dmmm=$dzx;

  break;

  case "连肖":

  $bmmm=$blx;

  $cmmm=$clx;

  $dmmm=$dlx;

  break;

  default;

  $bmmm=0;

  $cmmm=0;

  $dmmm=0;

  break;

}

	switch (ka_memuser("abcd")){							  



	case "A":

$rate5=$drop_table[0][2];

break;

	case "B":

$rate5=$drop_table[0][2]-$bmmm;

	break;

	case "C":

$rate5=$drop_table[0][2]-$cmmm;

	break;

	case "D":

$rate5=$drop_table[0][2]-$dmmm;

break;

	default:

$rate5=$drop_table[0][2];

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

  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=FE5711><font color=ffff00>封盘中....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"离开\" name=\"btnCancel\" /></font></td>          </tr>      </table>"; 

  exit;

}





?>



										  

<?php if($_POST['name']=="save"){?>

<table width="230" border="0" align="center" cellpadding="0" cellspacing="0">

  

    <tr>

      <td align="center">&nbsp;</td>

    </tr>

    <tr>

      <td width="80%"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#691A0D" bgcolor="#cccccc">

        <tr>

          <td height="28" colspan="3" align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注成功</span></td>

          </tr>

        <tr>

          <td height="22" align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td>

          <td align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td>

          <td align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注金额</span></td>

        </tr>

        <tr>

          <td height="22" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><font color="#ff0000"><?=$class22?>：<font color=ff6600><?=$class333?></font></font></td>

          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$rate?></td>

          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$sum_m?></td>

        </tr>

	      <tr>

          <td height="22" colspan="3" align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="离开" name="btnCancel" />&nbsp;&nbsp;

<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="javascript:window.print();" type="button" value="打印"  name="btnSubmit" />&nbsp;&nbsp;<input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left'" type="button" value="下注成功" name="btnCancel" /></td>

          </tr>

      </table></td>

    </tr>


</table>

<?php
 }else{

 ?>										  

<table width="230" border="0" align="center" cellpadding="0" cellspacing="0">

 <form target="mem_order" name="form1" method="post" action="index.php?action=zx_n1&amp;class2=<?=$_GET['class2']?>">

    <input name="name" type="hidden" value="save" />

    <tr>

      <td height="30" align="center"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#691A0D" bgcolor="#cccccc">

        <tr>

          <td height="25" colspan="4" align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">确认注单</span></td>

        </tr>

        <tr>

          <td height="22" align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">内容</span></td>

          <td align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">赔率</span></td>

          <td align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">下注金额</span></td>

          <td align="center" bordercolor="#cccccc" bgcolor="#006600" style="LINE-HEIGHT: 23px"><span class="STYLE3">可赢金额</span></td>

        </tr>

        <input name="lx" type="hidden" value="<?=$_POST['lx'];?>" />

		<input name="class1" type="hidden" value="<?=$drop_table[0][4];?>" />

		<input name="class2" type="hidden" value="<?=$drop_table[0][1];?>" />

		<input name="class3" type="hidden" value="<?=$drop_table[0][0];?>" />

		<input name="rate" type="hidden" value="<?=$rate5;?>" />

		<input name="sum_m" type="hidden" value="<?=$_POST['Num_0']?>" />

        <tr>

          <td height="22" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><font color="#ff0000"><?=$drop_table[0][1];?>：<font color=ff6600><?=$drop_table[0][0];?></font></font></td>

          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$rate5;?>

         </td>

          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$_POST['Num_0']?></td>

          <td align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><?=$_POST['Num_0']*$rate5-$_POST['Num_0']?></td>

        </tr>

		<tr>

		  <td colspan="4" height="30" bgcolor="#ffffff">号码：<font color=ff6600><?php
		   for($i=1;$i<=49;$i++){ 
			if($_POST['num'.$i] <> ""){
			$num=$_POST['num'.$i];
			echo $num.",";}?><input name="num<?=$i?>" type="hidden" value="<?=$_POST['num'.$i]?>" /><? }?>

		  </font></td>

		</tr>

		<tr>

          <td height="28" colspan="4" align="center" bordercolor="#cccccc" bgcolor="ffffff" style="LINE-HEIGHT: 23px"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';parent.parent.mem_order.location.href='index.php?action=k_zx';" type="button" value="放弃" name="btnCancel" />

        &nbsp;&nbsp;

        <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="确定" onClick="return ChkSubmit();" name="btnSubmit" /></td>

          </tr>

		  

      </table>

        </td>

    </tr>

  </form>

</table>

<?php

}


?>

</BODY></HTML> 