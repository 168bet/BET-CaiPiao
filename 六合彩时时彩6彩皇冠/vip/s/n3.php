<? if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}

if ($_GET['class2']==""){echo "<script>alert('�Ƿ�����!');parent.parent.mem_order.location.href='index.php?action=k_tm';window.location.href='index.php?action=left';</script>"; 
exit;}

$n=0;
for ($t=0;$t<=12;$t=$t+1){

if ($_POST['num'.$t]!=""){
$number1.=$_POST['num'.$t].",";
$n=$n+1;

// get mdrop
$result=mysql_query("Select rate from mdrop where class1='��Ф' and class2='".$_GET['class2']."' and class3='".$_POST['num'.$t]."'");
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


$result=mysql_query("select sum(sum_m) as sum_mm from ka_tan where kithe='".$Current_Kithe_Num."' and  username='".$_SESSION['kauser']."' and class1='��Ф' and class2='".$_GET['class2']."'  order by id desc"); 
$ka_guanuserkk1=mysql_fetch_array($result); 
$sum_mm=$ka_guanuserkk1[0];



switch ($_GET['class2']){
        case "��Ф��":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=39;	
$XF=23;
$rate_id=1029;
$urlurl="index.php?action=k_lx2&ids=��Ф��";
if ($n!=2){echo "<script>alert('�Բ�����ѡ�������Ф!');parent.parent.mem_order.location.href='index.php?action=k_lx2';window.location.href='index.php?action=left';</script>"; 
exit;}

break;


 case "��Ф��":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=40;	
$XF=23;
$rate_id=1030;
$urlurl="index.php?action=k_lx3&ids=��Ф��";
if ($n!=3){echo "<script>alert('�Բ�����ѡ��������Ф!');parent.parent.mem_order.location.href='index.php?action=k_lx3';window.location.href='index.php?action=left';</script>"; 
exit;}

break;

 case "��Ф��":
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=41;	
$XF=23;
$rate_id=1031;
$urlurl="index.php?action=k_lx4&ids=��Ф��";
if ($n!=4){echo "<script>alert('�Բ�����ѡ���ĸ���Ф!');parent.parent.mem_order.location.href='index.php?action=k_lx4';window.location.href='index.php?action=left';</script>"; 
exit;}

break;
case "��Ф��" : 
		$bmmm=0;
$cmmm=0;
$dmmm=0;
	
	$R=42;	      
$XF=23;
$rate_id=1032;

$urlurl="index.php?action=k_lx5&ids=��Ф��";
if ($n!=5){echo "<script>alert('�Բ�����ѡ�������Ф!');parent.parent.mem_order.location.href='index.php?action=k_lx5';window.location.href='index.php?action=left';</script>"; 
exit;}

break;
 case "��Ф��":
 if ($n!=6){echo "<script>alert('�Բ�����ѡ��������Ф!');parent.parent.mem_order.location.href='index.php?action=k_lx6';window.location.href='index.php?action=left';</script>"; 
exit;}
 
 $R=21;
 		$bmmm=$bsx6;
$cmmm=$csx6;
$dmmm=$dsx6;      
$XF=23;
$rate_id=688;
$urlurl="index.php?action=k_lx6&ids=��Ф��";
break;
 default:
$bmmm=0;
$cmmm=0;
$dmmm=0;
$R=19;	
$XF=23;
$rate_id=686;
$urlurl="index.php?action=k_lx4&ids=��Ф��";
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
    //�趨��ȷ������Ϊ���� 


		document.all.btnSubmit.disabled = true;
	
document.form1.submit();
	} 
</SCRIPT>


<SCRIPT language=javascript>var count_win=false;
function CheckKey(){
if(event.keyCode == 13) return true;
if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("��ע��������������!!"); return false;}
}

function SubChk(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert("��������ע���!!");
return false;
}
if(isNaN(document.all.gold.value) == true){
document.all.gold.focus();
alert("��ע��������������!!");
return false;
}
if(eval(document.all.gold.value) < <?=ka_memuser("xy")?>){
document.all.gold.focus();
alert("��ע����С������ע���:<?=ka_memuser("xy")?>!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("�Բ���,��������ע���������� : <?=ka_memds($R,3)?>  !!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memds($R,2)?>){
document.all.gold.focus();
alert("��ע���ɴ�춵�ע�޶�:<?=ka_memds($R,2)?>!!");
return false;
}
if((<?=$sum_mm?>+eval(document.all.gold.value)) > <?=ka_memds($R,3)?>){
document.all.gold.focus();
alert("�����ۼ���ע��: <?=$sum_mm?>\n��ע����ѳ��������޶�!!");
return false;
}
if(eval(document.all.gold.value) > <?=ka_memuser("ts")?>){
document.all.gold.focus();
alert("��ע���ɴ�����ö��:<?=ka_memuser("ts")?>!!");
return false;
}

//if(!confirm("�������:"+Math.round(document.all.gold.value * document.all.ioradio.value / 1000 - document.all.gold.value)+"\n\n �Ƿ�ȷ����ע?")){return false;}
document.all.btnCancel.disabled = true;
document.all.btnSubmit.disabled = true;
document.LAYOUTFORM.submit();
}

function CountWinGold(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('δ������ע���!!!');
}else{
document.all.pc.innerHTML=Math.round(document.all.gold.value * document.all.ioradio.value /1000 - document.all.gold.value);
//document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
function CountWinGold1(){
if(document.all.gold.value==''){
document.all.gold.focus();
alert('δ������ע���!!!');
}else{
//document.all.pc1.innerHTML=Math.round(document.all.gold.value * document.all.ioradio1.value);
count_win=true;
}
}
</SCRIPT>
<noscript>
<iframe scr=��*.htm��></iframe>
</noscript>

<?
if ($Current_KitheTable[29]==0 or $Current_KitheTable[$XF]==0) {       
  echo "<table width=98% border=0 align=center cellpadding=4 cellspacing=1 bordercolor=#cccccc bgcolor=#cccccc>          <tr>            <td height=28 align=center bgcolor=cb4619><font color=ffff00>������....<input class=button_a onClick=\"self.location='index.php?action=left'\" type=\"button\" value=\"�뿪\" name=\"btnCancel11\" /></font></td>          </tr>      </table>"; 
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
            <td height="25" colspan="2" align="center" bgcolor="#5A79C6"><span class="STYLE3">ȷ����ע</span></td>
          </tr>
          <tr>
            <td width="35%" height="25" align="right" bgcolor="#006600"><span class="STYLE3">�˺�����</span></td>
            <td width="65%" bgcolor="#FFFFFF"><span class="STYLE2">
              <?=ka_memuser("kauser")?>
            </span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">��Ա���� </span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">
              <?=ka_memuser("abcd")?>
              ��</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">�����ö�</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">��
                  <?=ka_memuser("cs")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">�������</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">��
                  <?=ka_memuser("ts")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">����޶�</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">��
                  <?=ka_memuser("xy")?>
              Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">��ע�ܶ�</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">
              <? 
	    $result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$Current_Kithe_Num."  and   username='".$_SESSION['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	
	?>
              ��<? echo $mkmk;?>Ԫ</span></td>
          </tr>
          <tr>
            <td height="25" align="right" bgcolor="#006600"><span class="STYLE3">��ǰ����</span></td>
            <td bgcolor="#FFFFFF"><span class="STYLE2">
              <?=$Current_Kithe_Num?>
              ��</span></td>
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
              <td height="25" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;��ע���:
                <input
name="gold" class="input1" id="gold" onkeypress="return CheckKey()"
onkeyup="return CountWinGold()" value="<?=$_POST['Num_1']?>" size="8" maxlength="8" />
              </td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff" style="LINE-HEIGHT: 23px">&nbsp;�������:<strong><font id="pc" color="#ff0000">
               <?=$_POST['Num_1']*$rate555-$_POST['Num_1']?>
			   
			   
			    </font></strong></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff">&nbsp;��ע�޶�: <?=ka_memds($R,2)?></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#ffffff">&nbsp;�����޶�: <?=ka_memds($R,3)?></td>
            </tr>
            <tr>
              <td height="30" align="center" bgcolor="#ffffff" style="LINE-HEIGHT: 23px"><input type='hidden' name="rate_id" value='<?=$rate_id?>' />
              
                  <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" onClick="self.location='index.php?action=left';" type="button" value="����" name="btnCancel" />
                &nbsp;&nbsp;
                <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="ȷ��" onclick="SubChk();" name="btnSubmit" />
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
