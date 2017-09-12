<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}
//修改信息
if ($_GET['act']=="添加") {

if ($_POST['cs']>2000000000) {
       
  echo "<script>alert('信用额度超过可用信用额!');window.history.go(-1);</script>"; 
  exit;
    }
if (($_POST['sf']+$_POST['sj'])>100) {
       
  echo "<script>alert('对不起,请正确设置占成!');window.history.go(-1);</script>"; 
  exit;
    }

if ($_POST['tv5']=="是") {$pz=0; }else{$pz=1;  }
if ($_POST['tv6']=="是") {$stat=0;}else{$stat=1;  }

$result=mysql_query("select * from ka_guan where  id='".$_GET['id']."'  order by id desc"); 
$row=mysql_fetch_array($result);
$SoftID=$row['id'];
$cs=$row['cs'];
$ts=$row['ts'];
$sj=$row['sj'];
$sf=$row['sf'];

$sjj=$_POST['sj'];



 if ($_POST['kapassword']!=""){
  $pass = md5($_POST['kapassword']);
  $sql="update  ka_guan set kapassword='".$pass."' where id='".$_GET['id']."'  order by id desc";	
$exe=mysql_query($sql) or  die("数据库修改出错");}


$sql="update  ka_guan set xm='".$_POST['xm']."',cs='".$_POST['cs']."',ts='".$_POST['cs']."',rs='".$_POST['rs']."',sj='".$sjj."',sf='".$_POST['sf']."',pz='".$pz."',tmb='".$_POST['tmb']."',stat='".$stat."' where id='".$_GET['id']."'  order by id desc";
	
$exe=mysql_query($sql) or  die("数据库修改出错");

if ($cs>$_POST['cs']){
$exe=mysql_query("update ka_guan set cs=0,ts=0 where guanID=".$_GET['id']);
$exe=mysql_query("update ka_mem set cs=0,ts=0 where guanID=".$_GET['id']);
}

if ($_POST['sf']!=$sf || $_POST['sj']!=$sj){


$exe=mysql_query("update ka_guan set sj=".$_POST['sf'].",sf=0 where  lx=2 and  guanID=".$_GET['id']);
$exe=mysql_query("update ka_guan set sj=0,sf=0 where  lx=3 and  guanID=".$_GET['id']);
$exe=mysql_query("update ka_mem set dan_zc=0,zong_zc=0,guan_zc='".($_POST['sf']/10)."',dagu_zc='".(10-($_POST['sf']/10))."' where guanID=".$_GET['id']);


}
if ($_POST['tmb']==1){

$exe=mysql_query("update ka_guan set tmb=1 where    guanid=".$_GET['id']);
$exe=mysql_query("update ka_mem set tmb=1 where   guanid=".$_GET['id']);
}


//股东设置

//$ygid=$_POST['ygid'];
$yg=$_POST['m'];
$ygb=$_POST['ygb'];
$ygc=$_POST['ygc'];
$ygd=$_POST['ygd'];
//$xx=$_POST['mm'];
//$xxx=$_POST['mmm'];
$ds=$_POST['ds'];
$ygid=$_POST['ygid'];


$I=0;
$sql55=mysql_query("select * from ka_quota where  userid=".$_GET['id']." and flag=0  order by id"); 
 while($rs=mysql_fetch_array($sql55))
{

$ds1=$rs['ds'];
$yg1=$rs['yg'];
$xx1=$rs['xx'];
$xxx1=$rs['xxx'];


$exe=mysql_query("update ka_quota Set yg='".$yg[$I]."',ygb='".$ygb[$I]."',ygc='".$ygc[$I]."',ygd='".$ygd[$I]."',xx='".$_POST['mm'.$I]."',xxx='".$_POST['mmm'.$I]."' where  id=".$ygid[$I]);


///会员
if ($yg1>$yg[$I]){
$exe=mysql_query("update ka_quota Set yg='".$yg[$I]."'  where ds='".$ds[$I]."'  and abcd='A'  and flag=1  and guanid=".$_GET['id']." ",$conn);
$exe=mysql_query("update ka_quota Set yg='".$yg[$I]."'  where ds='".$ds[$I]."'  and yg>".$yg[$I]."   and flag=0 and  guanid=".$_GET['id']);
}
if ($yg1>$ygb[$I]){
$exe=mysql_query("update ka_quota Set yg='".$ygb[$I]."'  where ds='".$ds[$I]."'   and abcd='B'  and flag=1  and guanid=".$_GET['id']." ",$conn);
$exe=mysql_query("update ka_quota Set ygb='".$ygb[$I]."'  where ds='".$ds[$I]."'  and ygb>".$ygb[$I]."   and flag=0  and guanid=".$_GET['id']);
}
if ($yg1>$ygc[$I]){
$exe=mysql_query("update ka_quota Set yg='".$ygc[$I]."'  where ds='".$ds[$I]."'  and abcd='C'  and flag=1  and guanid=".$_GET['id']." ",$conn);
$exe=mysql_query("update ka_quota Set ygc='".$ygc[$I]."'  where ds='".$ds[$I]."'  and ygc>".$ygc[$I]."   and flag=0 and  guanid=".$_GET['id']);
}
if ($yg1>$ygd[$I]){
$exe=mysql_query("update ka_quota Set yg='".$ygd[$I]."'  where ds='".$ds[$I]."'   and abcd='D'  and flag=1 and  guanid=".$_GET['id']." ",$conn);
$exe=mysql_query("update ka_quota Set ygd='".$ygd[$I]."'  where ds='".$ds[$I]."'  and ygd>".$ygd[$I]."   and flag=0  and guanid=".$_GET['id']);
}
///代理


///单注单项
if ($xx1>$_POST['mm'.$I]){
$exe=mysql_query("update ka_quota Set xx='".$_POST['mm'.$I]."'  where ds='".$ds[$I]."'   and  guanid=".$_GET['id']." ",$conn);}
if ($xxx1>$_POST['mmm'.$I]){
$exe=mysql_query("update ka_quota Set xxx='".$_POST['mmm'.$I]."'  where ds='".$ds[$I]."'  and  guanid=".$_GET['id']." ",$conn);}

$I++;




} 
	
 

echo "<script>alert('股东修改成功!');window.location.href='index.php?action=guan_edit&id=".$_GET['id']."';</script>"; 
exit;
	

}?>




<?

$result1 = mysql_query("Select SUM(rs) As memnum2 From ka_guan Where  lx=2 and guanid=".$_GET['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$rs1=$rsw[0];}else{$rs1=0;}
	
	
$maxnum=2000000000;

 $istar=0;

$iend=100;

  
  ?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>

<style type="text/css">
<!--
.style1 {
	color: #666666;
	font-weight: bold;
}
.style2 {color: #FF0000}
.STYLE3 {color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script src="inc/forms.js"></script>
<script language="JavaScript" type="text/JavaScript">
function SelectAllPub() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
function SelectAllAdm() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
</script>
<SCRIPT>
function LoadBody(){

}
function SubChk()
{
	
 	
		
		if(document.all.xm.value=='')
 		{ document.all.xm.focus(); alert("姓名请务必输入!!"); return false; }
  	
 	
 	
		
		
  	if(document.all.cs.value=='' )
		{ document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }
 	
	if(!confirm("是否确定写入代理商?")){
  		return false;
 	}
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.ag_count.innerHTML
	if (s!=''){
		switch(w){
			//case 0:document.all.ag_count.innerHTML = s+org_str.substr(1,4);break;
			case 1:document.all.ag_count.innerHTML = org_str.substr(0,0)+s+org_str.substr(1,7);break;
			case 2:document.all.ag_count.innerHTML = org_str.substr(0,1)+s+org_str.substr(2,7);break;
			case 3:document.all.ag_count.innerHTML = org_str.substr(0,2)+s+org_str.substr(3,7);break;
			case 4:document.all.ag_count.innerHTML = org_str.substr(0,3)+s+org_str.substr(4,7);break; 
			case 5:document.all.ag_count.innerHTML = org_str.substr(0,4)+s+org_str.substr(5,7);break;
			case 6:document.all.ag_count.innerHTML = org_str.substr(0,5)+s+org_str.substr(6,7);break;
			case 7:document.all.ag_count.innerHTML = org_str.substr(0,6)+s+org_str.substr(7,7);break; }
	}
}
function changelocation(locationid,result)
{
var onecount;
subcat = new Array();
   
    document.testFrm.zc.length = 1; 
	    var locationid=locationid;
    var i;
		var k
	   for (j=10;j.toFixed(3)<=(result-locationid).toFixed(3);j=j+10)
   {
   		document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
	}
    
}
function changep(pid)
{
	var pp=pid.split(",");
	document.testFrm.pagentid.value = pp[0];
	document.testFrm.kyx.value = pp[2];
	t=parseInt(pp[1]);
    document.testFrm.zc.length = 1; 
	for (j=10;j.toFixed(3)<=(t).toFixed(3);j=j+10)
   {
   		document.testFrm.zc.options[document.testFrm.zc.length] = new Option((j).toFixed(0)+"%");
	}
    document.testFrm.fei_max.length = 1; 
	for (j=10;j.toFixed(3)<=(t).toFixed(3);j=j+10)
   {
   		document.testFrm.fei_max.options[document.testFrm.fei_max.length] = new Option((j).toFixed(0)+"%");
	}
}

function changep1(pid)
{
var pp=pid.split(",");

	document.testFrm.winloss.value = pp[0];
	document.testFrm.bank.value = pp[1];
document.all.ag_count.innerHTML =pp[1];
}



function CountGold(gold,type,rtype){

goldvalue = gold.value;

if (goldvalue=='') goldvalue=0;

if (rtype=='SP' && (eval(goldvalue) > <?=$maxnum?>)) {gold.focus(); alert("对不起,股东总信用额度最高限制 : <?=$maxnum?>!!"); return false;}
}


function CountGold2(gold,type,rtype){
goldvalue = gold.value;
str1="rs1";
zmzm=document.all[str1].value;


if (goldvalue=='') goldvalue=0;
if (rtype=='SP' && (eval(goldvalue) < eval(zmzm))) {gold.focus(); alert("对不起,股东人数最少限制 : "+eval(zmzm)+"!!"); return false;}
}


function CountGold1(gold,type,rtype,bb,nmnm){

goldvalue = gold.value;


if (goldvalue=='') goldvalue=0;






for(i=0; i<28 ;i++)
	{
	if (nmnm==i){
var str1="mm"+i;
var str2="mmm"+i;
var t_big2 = new Number(document.all[str2].value);

 if (rtype=='MP' && (eval(goldvalue) > eval(t_big2))) {gold.focus(); alert("对不起,单注限额不能大于单项限额: "+eval(t_big2)+"!!"); 
return false;}

var t_big = new Number(document.all[str1].value);

if (rtype=='XP' && (eval(goldvalue) < eval(t_big))) {gold.focus(); alert("对不起,单项限额不能低于单注限额: "+eval(t_big)+"!!"); 
return false;
}
}
}
}
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="29%"><span class="STYLE3">股东资料修改</span></td>
    <td width="34%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<div align="left">
  <? $result=mysql_query("select * from ka_guan where id=".$_GET['id']."  order by id"); 
$row=mysql_fetch_array($result);

?>
  <table width="99%"  border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
    <form action="index.php?action=guan_edit&amp;act=添加&amp;id=<?=$_GET['id']?>" method="post" name="testFrm" id="testFrm" onsubmit="return SubChk()">
      <tr>
        <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">账号：</td>
        <td width="32%" bordercolor="#CCCCCC"><font color="ff6600">
          <?=$row['kauser']?>
        </font></td>
        <td width="8%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">姓名：</td>
        <td width="49%" bordercolor="#CCCCCC"><input name="xm" type="text" class="input1"  id="xm" value="<?=$row['xm']?>" />
            <span class="STYLE2">*</span>
            <?  $result1 = mysql_query("Select SUM(cs) As sum_m  From ka_guan Where lx=2 and   guanid=".$row['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mumu=$rsw[0];}
	
	 $result1 = mysql_query("Select SUM(sum_m) As sum_m   From ka_tan Where kithe=".$Current_Kithe_Num." and   username='".$row['kauser']."' order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}?>
          分配余额：
          <input name="kylllx2" type="text" class="input1" id="kylllx2" value="<?=$row['cs']-$mumu-$mkmk?>"  readonly="readonly" /></td>
      </tr>
      <tr>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">密码：</td>
        <td nowrap="nowrap" bordercolor="#CCCCCC"><input name="kapassword" type="password" class="input1"  id="kapassword" />
            <span class="STYLE2">(不修改请留空)</span></td>
        <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总信用额：</td>
        <td bordercolor="#CCCCCC"><input
					   onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
						
                      
						
					   name="cs" type="text" class="input1"  id="cs" value="<?=$row['cs']?>" />
          可用信用额度：
          <input type="text" name="kyx" class="input1"  readonly="readonly" value="<?=$maxnum?>" />
            <span class="STYLE2">*<br />
              (如果修改总信用额比原来的值小那么下级所有用户总信用额将变成0)</span></td>
      </tr>
      <tr>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">走飞：</td>
        <td bordercolor="#CCCCCC"><input type="hidden" name="tv5" value="<? if ($row['pz']==0) {?>是<? }else{?>否<? }?>" />
            <img src="images/<? if ($row['pz']==0) {?>icon_21x21_selectboxon.gif<? }else{?>icon_21x21_selectboxoff.gif<? }?>" name="tv5_b" align="absmiddle" class="cursor" id="tv5_b" onclick="javascript:ra_select('tv5')" /> (充许走飞/禁止走飞)<span class="STYLE2">*</span></td>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">状态：</td>
        <td bordercolor="#CCCCCC"><input type="hidden" name="tv6" value="<? if ($row['stat']==0) {?>是<? }else{?>否<? }?>" />
            <img src="images/<? if ($row['stat']==0) {?>icon_21x21_selectboxon.gif<? }else{?>icon_21x21_selectboxoff.gif<? }?>" name="tv6_b" align="absmiddle" class="cursor" id="tv6_b" onclick="javascript:ra_select('tv6')" />(开启/禁止)<span class="STYLE2">* </span></td>
      </tr>
      <tr>
        <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">公司占成：</td>
        <td bordercolor="#CCCCCC"><select class="za_select_02" name="sj"  id="zc">
            <? for ($bb=$istar; $bb<=$iend; $bb=$bb+10)
{
?>
            <option value="<?   echo $bb; ?>"  <?   if ($row["sj"]==$bb)
  {
?> selected="selected"<?   } ?>>
            <?   switch ($bb)
  {
    case 0:
      print "不占成";
      break;
    default:

      print $bb."%";
      break;
  } 

?>
            </option>
            <? 
} ?>
          </select>
            <span class="STYLE2 style2">*(如果修改占成下级所有用户占成将变成0)</span></td>
        <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">股东占成：</td>
        <td bordercolor="#CCCCCC"><select class="za_select_02" name="sf"  id="zc">
            <? for ($bb=$istar; $bb<=$iend; $bb=$bb+10)
{
?>
            <option value="<?   echo $bb; ?>"  <?   if ($row["sf"]==$bb)
  {
?> selected="selected"<?   } ?>>
            <?   switch ($bb)
  {
    case 0:
      print "不占成";
      break;
    default:

      print $bb."%";
      break;
  } 

?>
            </option>
            <? 
} ?>
          </select>
            <span class="STYLE2 style2">*(如果修改占成下级所有用户占成将变成0)</span></td>
      </tr>
      <tr>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">登录时间：</td>
        <td bordercolor="#CCCCCC"><?=$row['zlogin']?></td>
        <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">登录IP：</td>
        <td bordercolor="#CCCCCC"><?=$row['zip']?></td>
      </tr>
      <tr>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">注册时间：</td>
        <td bordercolor="#CCCCCC"><?=$row['adddate']?></td>
        <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">登录次数：</td>
        <td bordercolor="#CCCCCC"><?=$row['look']?>
          次</td>
      </tr>
      <tr>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自否允许特B：</td>
        <td height="30" bordercolor="#CCCCCC"><select name="tmb" id="tmb">
            <option value="0" <? if ($row['tmb']=="0"){?>selected="selected"<? }?>>允许</option>
            <option value="1" <? if ($row['tmb']=="1"){?>selected="selected"<? }?>>不允许</option>
          </select>        </td>
        <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">会员人数：</td>
        <td bordercolor="#CCCCCC"><input onblur="return CountGold2(this,'blur','SP');"
					    
					    onkeyup="return CountGold2(this,'keyup');" 
						name="rs" type="text" class="input1"  id="rs" value="<?=$row['rs']?>" size="10" />
          <span class="STYLE2">
          <input name="rs1" type="hidden" id="rs1" value="<?=$rs1?>" />
          
最少：
<?=$rs1?>
          </span></td>
      </tr>
      <tr>
        <td height="30" colspan="4" bordercolor="#CCCCCC"><table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
          <tr>
            <td width="90" height="25" align="center" bgcolor="#FDF4CA"><span class="STYLE2">类型</span> </td>
            <td align="center" bgcolor="#FDF4CA">佣金%A</td>
            <td align="center" bgcolor="#FDF4CA" >佣金%B</td>
            <td align="center" bgcolor="#FDF4CA" >佣金%C</td>
            <td align="center" bgcolor="#FDF4CA" >佣金%D</td>
            <td align="center" bgcolor="#FDF4CA" >单注限额</td>
            <td align="center" bgcolor="#FDF4CA" >单项(号)限额</td>
          </tr>
          <? $result = mysql_query("select * from  ka_quota where lx=0 and userid=".$_GET['id']." and flag=0 order by id ");   
					  $t=0;
while($image = mysql_fetch_array($result)){
    //if ($image['ds'] == "五行") continue;


?>
          <tr>
            <td height="20" align="center" bgcolor="#FDF4CA"><?=$image['ds']?>
                  <input name="ds[]" type="hidden" id="ds[]" value="<?=$image['ds']?>" />
                  <input name="ygid[]" type="hidden" id="ygid[]" value="<?=$image['id']?>" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="m[]" class="input1" id="m[]" value='<?=$image['yg']?>' size="10" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="ygb[]" class="input1" id="mm[]" value='<?=$image['ygb']?>' size="10" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="ygc[]" class="input1" id="ygc[]" value='<?=$image['ygc']?>' size="10" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="ygd[]" class="input1" id="ygd[]" value='<?=$image['ygd']?>' size="10" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="mm<?=$t?>" 
						   onblur="return CountGold1(this,'blur','MP','<?=$image['xx']?>','<?=$t?>');" onkeyup="return CountGold1(this,'keyup');"
						  class="input1" id="mm<?=$t?>" value='<?=$image['xx']?>' size="10" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="mmm<?=$t?>" 
						   
						   onblur="return CountGold1(this,'blur','XP','<?=$image['xxx']?>','<?=$t?>');" onkeyup="return CountGold1(this,'keyup');"
						 
						  class="input1" id="mmm<?=$t?>" value='<?=$image['xxx']?>' size="10" /></td>
          </tr>
          <? $t++;
					  //if($t==35){echo "<tr><td>福彩</td></tr>";}
					  //if($t==54){echo "<tr><td>体彩</td></tr>";}		
						 }?>
          <tr >
            <td height="25" colspan="7" align="center" bgcolor="#FDF4CA"><span class="STYLE2">(如果修改<font color="#0000FF">佣金,单注限额,单项(号)限额</font>比原来的值小那么下级所有用户相应的将变成0)</span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td>
        <td colspan="3" bordercolor="#CCCCCC"><br />
            <table width="100" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="6"></td>
              </tr>
            </table>
          <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存股东" />
            <br />
            <table width="100" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
          </table></td>
      </tr>
    </form>
  </table>
</div>
</div>
