<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_GET['class2']==""){echo "<script>alert('非法进入!');parent.parent.mem_order.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>"; 
exit;}

$n=0;
for ($t=0;$t<=12;$t=$t+1){

if ($_POST['num'.$t]!=""){
$number1.=$_POST['num'.$t].",";
$n=$n+1;

// get mdrop
$result=mysql_query("Select rate from mdrop where class1='连肖' and class2='".$_GET['class2']."' and class3='".$_POST['num'.$t]."'");
while($image = mysql_fetch_array($result)){
$mdrop += $image['rate'];
$aa.=$image['rate'].",";
}
}
}
$aa.="0";
$array=explode(",",$aa);
$arraya=sort($array);
$rate555=$array[1];


$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='连肖' and class2='".$_GET['class2']."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_mm=$ka_guanuserkk1[0];



switch ($_GET['class2']){
        case "二肖碰":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=39;	
$XF=23;
$rate_id=1029;
$urlurl="index.php?action=k_lx2&ids=二肖碰";
if ($n!=2){echo "<script>alert('对不起，请选择二个连肖!');parent.parent.mem_order.location.href='index.php?action=k_lx2';window.location.href='index.php?action=left';</script>"; 
exit;}

break;


 case "三肖碰":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=40;	
$XF=23;
$rate_id=1030;
$urlurl="index.php?action=k_lx3&ids=三肖碰";
if ($n!=3){echo "<script>alert('对不起，请选择三个连肖!');parent.parent.mem_order.location.href='index.php?action=k_lx3';window.location.href='index.php?action=left';</script>"; 
exit;}

break;

 case "四肖碰":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=41;	
$XF=23;
$rate_id=1031;
$urlurl="index.php?action=k_lx4&ids=四肖碰";
if ($n!=4){echo "<script>alert('对不起，请选择四个连肖!');parent.parent.mem_order.location.href='index.php?action=k_lx4';window.location.href='index.php?action=left';</script>"; 
exit;}

break;
case "五肖碰" : 
		$bmmm=0;
$cmmm=0;
$dmmm=0;
	
	$R=42;	      
$XF=23;
$rate_id=1032;

$urlurl="index.php?action=k_lx5&ids=五肖碰";
if ($n!=5){echo "<script>alert('对不起，请选择五个连肖!');parent.parent.mem_order.location.href='index.php?action=k_lx5';window.location.href='index.php?action=left';</script>"; 
exit;}

break;
 case "六肖碰":
 if ($n!=6){echo "<script>alert('对不起，请选择六个连肖!');parent.parent.mem_order.location.href='index.php?action=k_lx6';window.location.href='index.php?action=left';</script>"; 
exit;}
 
 $R=21;
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



?>




<LINK rel=stylesheet type=text/css href="imgs/left.css"><LINK 
rel=stylesheet type=text/css href="imgs/ball1x.css"><LINK 
rel=stylesheet type=text/css href="imgs/loto_lb.css">
<style type="text/css">
.STYLE3{ color:#fff}
</style>
</HEAD>
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


<SCRIPT language=javascript>var count_win=false;
function CheckKey(){
if(event.keyCode == 13) return true;
if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
}

function SubChk(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert("请输入下注金额!!");
return false;
}
if(isNaN(document.all.gold.value) == true){
document.all.gold.focus();
alert("下注金额仅能输入数字!!");
return false;
}
if(eval(document.all.gold.value) < <?=ka_memuser("xy")?>){
document.all.gold.focus();
alert("下注金额不可小於最低下注金额:<?=ka_memuser("xy")?>!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("对不起,本期有下注金额最高限制 : <?=ka_memds($R,3)?>  !!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,2)?>){
document.all.gold.focus();
alert("下注金额不可大於单注限额:<?=ka_memds($R,2)?>!!");
return false;
}
if((<?=$sum_mm?>+eval(document.all.gold.value)) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("本期累计下注共: <?=$sum_mm?>\n下注金额已超过单期限额!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memuser("ts")?>){
document.all.gold.focus();
alert("下注金额不可大於信用额度:<?=ka_memuser("ts")?>!!");
return false;
}

//if(!confirm("可蠃金额:"+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+"\n\n 是否确定下注?")){return false;}
document.all.btnCancel.disabled = true;
document.all.btnSubmit.disabled = true;
document.LAYOUTFORM.submit();
}

function CountWinGold(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('未输入下注金额!!!');
}else{
document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);
//document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
function CountWinGold1(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('未输入下注金额!!!');
}else{
//document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
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

										  
<TABLE border=0 cellSpacing=0 cellPadding=0 width=225 class="Tab_backdrop">
  <TBODY>
  <TR>
    <TD class=Left_Place height=400 vAlign=top align=left>
        <TABLE>
        <TBODY>
        <TR>
          <TD height=2></TD></TR></TBODY></TABLE>  										  
<TABLE class=t_list cellSpacing=1 cellPadding=0 width=210 border=0>
<tr class="left_acc_out_top">
    <td valign="top">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" colspan="2" align="center" bgcolor="#5A79C6"><span class="STYLE3">确认下注</span></td>
          </tr>
          <tr>
            <td width="35%" height="25" align="right" bgcolor="#006600"><span class="STYLE3">账号名称</span></td>
            <td width="65%" bgcolor="#FFFFFF"><span class="STYLE2">
              <?=ka_memuser("kauser")?>
            </span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">会员类型 </span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">
              <?=ka_memuser("abcd")?>
              盘</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">总信用额</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">￥
                  <?=ka_memuser("cs")?>
              元</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">可用余额</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">￥
                  <?=ka_memuser("ts")?>
              元</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">最低限额</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">￥
                  <?=ka_memuser("xy")?>
              元</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">下注总额</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">
              <? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
              ￥<? echo $mkmk;?>元</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">当前期数</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">
              <?=$Current_Kithe_Num?>
              期</span></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3"></td>
          </tr>
        </table>
      <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#FDF4CA">
          <form action="index.php?action=k_tanlx&class2=<?=$_GET['class2']?>" method="post" name="LAYOUTFORM" id="form1"  onsubmit="return false"><input name="min_bl" id="min_bl" type="hidden" value="<?=$_POST['min_bl']?>" />
		

            <tr>
              <td width="35%" height="25" bgcolor="#ffffff" style="LINE-HEIGHT: 22px"><?=ka_bl($rate_id,"class2")?></FONT> @ <strong><font
color="#ff0000">
               <? echo $_POST['min_bl']; ?> </font></strong>
                  </div></td>
            </tr>
            <tr>
              <td bgcolor="#F9F7D7"><div align="center"><b><?=$number1?></b></div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;下注金额:
                <input
name="gold" class="input1" id="gold" onkeypress="return CheckKey()"
onkeyup="return CountWinGold()" value="<?=$_POST['Num_1']?>" size="8" maxlength="8" />
              </td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;可蠃金额:<strong><font id="pc" color="#ff0000">
               <?=$_POST['Num_1']*$rate555-$_POST['Num_1']?>
			   
			   
			    </font></strong></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff">&nbsp;单注限额: <?=ka_memds($R,2)?></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff">&nbsp;单号限额: <?=ka_memds($R,3)?></td>
            </tr>
            <tr>
              <td height="30" align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input type='hidden' name="rate_id" value='<?=$rate_id?>' />
              
                  <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';" type="button" value="放弃" name="btnCancel" />
                &nbsp;&nbsp;
                <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="确定" onclick="SubChk();" name="btnSubmit" />
              </td>
            </tr>
            <input type="hidden"
value="SP11" name="concede" />
            <input type="hidden" value='<?=ka_bl($rate_id,"rate")*1000?>' name="ioradio" />
            <input type="hidden" value='<?=$zs?>' name="ioradio1" />
            <input type="hidden" value='<?=$number1?>' name="number1" />
          </form>
        <script language="JavaScript" type="text/javascript">document.all.gold.focus();</script>
        </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3"></td>
          </tr>
      </table></td>
  </tr>
</table>
</TD>
</TR>
</tbody>
</table>

</BODY></HTML>
