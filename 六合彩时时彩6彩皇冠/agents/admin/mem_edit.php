<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}
//修改信息
if ($_GET['act']=="添加") {


if (empty($_POST['xy'])) {
       
  echo "<script>alert('最低限额不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
	if ($_POST['cs']>$_POST['kyx']) {
       
  echo "<script>alert('信用额度超过可用信用额!');window.history.go(-1);</script>"; 
  exit;
    }
	
	if ($_POST['tv6']=="是") {$stat=0;}else{$stat=1;  }
	
	$result=mysql_query("select * from ka_mem where id=".$_GET['id']."  order by id"); 
$row=mysql_fetch_array($result);

$cs=$row['cs'];
$ts=$row['ts'];
$abcd=$row['abcd'];
$danid=$row['danid'];
if ($_POST['kapassword']!=""){
  $pass = md5($_POST['kapassword']);
  $sql="update  ka_mem set kapassword='".$pass."' where id='".$_GET['id']."'  order by id desc";	
$exe=mysql_query($sql) or  die("数据库修改出错");}

if ($_POST['cs']>$cs) {
$vff=$ts+($_POST['cs']-$cs);
$sql="update  ka_mem set ts='".$vff."' where id='".$_GET['id']."'  order by id desc";	
$exe=mysql_query($sql) or  die("数据库修改出错");

}

if ($_POST['cs']<$cs){
$vff=$ts-($cs-$_POST['cs']);
$sql="update  ka_mem set ts='".$vff."' where id='".$_GET['id']."'  order by id desc";	
$exe=mysql_query($sql) or  die("数据库修改出错");

}
	

$sql="update  ka_mem set xm='".$_POST['xm']."',cs='".$_POST['cs']."',tmb='".$_POST['tmb']."',stat='".$stat."',xy='".$_POST['xy']."',abcd='".$_POST['abcd']."',ops='".$_POST['ops']."',opd='".$_POST['opd']."',opp='".$_POST['opp']."' where id='".$_GET['id']."' order by id desc";	
$exe=mysql_query($sql) or  die("数据库修改出错");




if ($abcd==$_POST['abcd']){
$yg=$_POST['m'];
$ds=$_POST['ds'];
$ygid=$_POST['ygid'];
for ($I=0; $I<count($yg); $I=$I+1)
{
$_POST['mmm'.$I];
$exe=mysql_query("update ka_quota Set yg='".$yg[$I]."',xx='".$_POST['mm'.$I]."',xxx='".$_POST['mmm'.$I]."',abcd='".$_POST['abcd']."' where  id=".$ygid[$I]);
} }else{



$result = mysql_query("select * from  ka_quota where lx=0 and userid=".$danid." and flag=0 order by id ");   
$t=0;
while($image = mysql_fetch_array($result)){
if ($_POST['abcd']=="A"){$yg=$image['yg'];}
if ($_POST['abcd']=="B"){$yg=$image['ygb'];}
if ($_POST['abcd']=="C"){$yg=$image['ygc'];}
if ($_POST['abcd']=="D"){$yg=$image['ygd'];}

$exe=mysql_query("update ka_quota Set yg='".$yg."',xx='".$image['xx']."',xxx='".$image['xxx']."',ds='".$image['ds']."',abcd='".$_POST['abcd']."' where userid='".$_GET['id']."' and ds='".$image['ds']."' and flag=1 ");
}


}




echo "<script>alert('会员修改成功!');window.location.href='index.php?action=mem_edit&id=".$_GET['id']."';</script>"; 
exit;
	
	
	}
	
	
	
	
	$result2=mysql_query("select *  from ka_mem where  id=".$_GET['id']." order by id"); 
$row2=mysql_fetch_array($result2);

if ($row2!=""){


$result=mysql_query("select id,kauser,sf,cs,tmb   from ka_guan where  id=".$row2['danid']." and lx=3"); 
$row=mysql_fetch_array($result);
if ($row!=""){


$result1 = mysql_query("Select SUM(cs) As sum_m  From ka_mem Where   danid=".$row['id']." order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mumu=$rsw[0];}else{$mumu=0;}
	
	 $result1 = mysql_query("Select SUM(sum_m) As sum_m   From ka_tan Where kithe=".$Current_Kithe_Num." and   username='".$row['kauser']."' order by id desc");
	$rsw = mysql_fetch_array($result1);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
	

$tmb=$row['tmb'];

$danid=$row['id'];
$maxnum=$row['cs']-$mumu-$mkmk+$row2['cs'];
$istar=0;
$iend=$row['sf'];


}else{
$maxnum=2000000000;
$istar=0;
$iend=100;
$tmb=0;

}
}

	
	
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
.STYLE3 {	color: #FFFFFF;
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
  	
 	
 	
			if(document.all.xy.value=='')
 		{ document.all.xy.focus(); alert("请输入最低限额!!"); return false; }
		
		
  	if(document.all.cs.value=='' )
		{ document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; }
 	
	if(!confirm("是否确定写入会员?")){
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

if (rtype=='SP' && (eval(goldvalue) > <?=$maxnum?>)) {gold.focus(); alert("对不起,上级总信用额度最高可使用 : <?=$maxnum?>!!"); return false;}
}

function CountGold1(gold,type,rtype,bb,nmnm){

goldvalue = gold.value;


if (goldvalue=='') goldvalue=0;

if (rtype=='SP' && (eval(goldvalue) > eval(bb))) {gold.focus(); alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!"); 
return false;
}


if (rtype=='XP' && (eval(goldvalue) > eval(bb))) {gold.focus(); alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!"); 
return false;
}

if (rtype=='MP' && (eval(goldvalue) > eval(bb))) {gold.focus(); alert("对不起,止项最高不能超过上级限额: "+eval(bb)+"!!"); 
return false;
}

for(i=1; i<28 ;i++)
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
    <td width="29%"><span class="STYLE3">修改会员</span></td>
    <td width="34%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table width="99%"  border="1" cellpadding="2" cellspacing="1" bordercolor="f1f1f1">
 <form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=mem_edit&act=添加&id=<?=$_GET['id']?>"> <tr>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">上级：</td>
    <td bordercolor="#CCCCCC"><font color="ff6600">
      <?=$row2['guan']?>
      (股)---
      <?=$row2['zong']?>
      (总)---
      <?=$row2['dan']?>
      (代)
      <input name="danid" type="hidden" value="<?=$row2['danid']?>" />
    </font></td>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">会员盘口：</td>
    <td bordercolor="#CCCCCC"><select name="abcd" id="abcd">
      <option value="A" <? if ($row2['abcd']=="A") {?> selected="selected"<? }?>>A盘</option>
      <option value="B"  <? if ($row2['abcd']=="B") {?> selected="selected"<? }?>>B盘</option>
      <option value="C"  <? if ($row2['abcd']=="C") {?> selected="selected"<? }?>>C盘</option>
      <option value="D" <? if ($row2['abcd']=="D"){ ?> selected="selected"<? }?>>D盘</option>
    </select>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">账号：</td>
    <td width="32%" bordercolor="#CCCCCC"><font color="ff6600">
      <?=$row2['kauser']?>
    </font></td>
    <td width="8%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">姓名：</td>
    <td width="49%" bordercolor="#CCCCCC"><input name="xm" type="text" class="input1"  id="xm" value="<?=$row2['xm']?>" />
        <span class="STYLE2">*</span> 下注余额：<font color="ff6600">
          <?=$row2['ts']?>
        </font></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">密码：</td>
    <td nowrap="nowrap" bordercolor="#CCCCCC"><input name="kapassword" type="password" class="input1"  id="kapassword" />
        <span class="STYLE2">(不修改请留空)</span></td>
    <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总信用额：</td>
    <td bordercolor="#CCCCCC"><input
					   onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
						
                      
						
					   name="cs" type="text" class="input1"  id="cs" value="<?=$row2['cs']?>" />
      可用信用额度：
      <input type="text" name="kyx" class="input1"  readonly="readonly" value="<?=$maxnum?>" />
        <span class="STYLE2">*<br />
          (如果修改总信用额比原来的值小那么下级所有用户总信用额将变成0)</span></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">最低限额：</td>
    <td bordercolor="#CCCCCC"><span class="STYLE2">
      <input name="xy" type="text" class="input1"  id="xy" value="<?=$row2['xy']?>" size="8" />
      *(下注最低限额)</span></td>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">状态：</td>
    <td bordercolor="#CCCCCC"><input type="hidden" name="tv6" value="<? if ($row2['stat']==0) {?>是<? }else{?>否<? }?>" />
        <img src="images/<? if ($row2['stat']==0) {?>icon_21x21_selectboxon.gif<? }else{?>icon_21x21_selectboxoff.gif<? }?>" name="tv6_b" align="absmiddle" class="cursor" id="tv6_b" onclick="javascript:ra_select('tv6')" />(开启/禁止)<span class="STYLE2">* </span></td>
  </tr>
  <tr>
    <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自否允许特B：</td>
    <td height="30" bordercolor="#CCCCCC"><select name="tmb" id="tmb">
        <? if ($tmb!=1){?>
        <option value="0" <? if ($row2['tmb']=="0"){?>selected="selected"<? }?>>允许</option>
        <? }?>
        <option value="1" <? if ($row2['tmb']=="1"){?>selected="selected"<? }?>>不允许</option>
      </select>
    </td>
    <td height="30" bordercolor="#CCCCCC">&nbsp;</td>
    <td height="30" bordercolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="4" bordercolor="#CCCCCC"><table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
          <tr>
            <td width="90" height="25" align="center" bgcolor="#FDF4CA"><span class="STYLE2">类型</span> </td>
            <td align="center" bgcolor="#FDF4CA">佣金%</td>
            <td align="center" bgcolor="#FDF4CA" >单注限额</td>
            <td align="center" bgcolor="#FDF4CA" >单项(号)限额</td>
          </tr>
          <? $result = mysql_query("select * from  ka_quota where lx=0 and userid=".$_GET['id']." and flag=1 order by id ");   
					  $t=0;
while($image = mysql_fetch_array($result)){
    //if ($image['ds'] == "五行") continue;

$result1 = mysql_query("select * from ka_quota where ds='".$image['ds']."' and lx=".$image['lx']."  and  userid=".$image['zongid']."  and flag=0  order by id");   
$row = mysql_fetch_array($result1);
					  
?>
          <tr>
            <td height="20" align="center" bgcolor="#FDF4CA"><?=$image['ds']?>
                <input name="ds[]" type="hidden" id="ds[]" value="<?=$image['ds']?>" />
                <input name="ygid[]" type="hidden" id="ygid[]" value="<?=$image['id']?>" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="m[]" class="input1" id="m[]" 
						
						onblur="return CountGold1(this,'blur','SP','<?=$row['yg']?>');" 
                        
						onkeyup="return CountGold1(this,'keyup');" 
						
						value='<?=$image['yg']?>' size="10" /></td>

            <td align="center" bgcolor="#FEFBE9"><input name="mm<?=$t?>" 
						   onblur="return CountGold1(this,'blur','MP','<?=$row['xx']?>','<?=$t?>');" onkeyup="return CountGold1(this,'keyup');"
						  class="input1" id="mm<?=$t?>" value='<?=$image['xx']?>' size="10" /></td>
            <td align="center" bgcolor="#FEFBE9"><input name="mmm<?=$t?>" 
						   
						   onblur="return CountGold1(this,'blur','XP','<?=$row['xxx']?>','<?=$t?>');" onkeyup="return CountGold1(this,'keyup');"
						 
						  class="input1" id="mmm<?=$t?>" value='<?=$image['xxx']?>' size="10" /></td>
          </tr>
          <? $t++;
						  //if($t==35){echo "<tr><td>福彩</td></tr>";}
						  //if($t==54){echo "<tr><td>体彩</td></tr>";}	
						 }?>
          <tr >
            <td height="25" colspan="7" align="center" bgcolor="#FDF4CA">&nbsp;</td>
          </tr>
      </table><!--<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="f1f1f1">
      <tr >
        <td width="90" height="25" align="center" bgcolor="#FDF4CA"><span class="STYLE2">六合彩</span> </td>
        <td align="center" bgcolor="#FDF4CA">佣金%</td>
        <td align="center" bgcolor="#FDF4CA" >单注限额</td>
        <td align="center" bgcolor="#FDF4CA" >单项(号)限额</td>
        <td align="center" bgcolor="#FDF4CA" ><span class="STYLE2">六合彩</span> </td>
        <td align="center" bgcolor="#FDF4CA" >佣金</td>
        <td align="center" bgcolor="#FDF4CA" >单注限额</td>
        <td align="center" bgcolor="#FDF4CA" >单项(号)限额</td>
      </tr>
      <? $result = mysql_query("select * from  ka_quota where lx=0 and userid=".$_GET['id']." and flag=1 order by id ");   
					  $t=0;
while($image = mysql_fetch_array($result)){


$result1 = mysql_query("select * from ka_quota where ds='".$image['ds']."' and lx=".$image['lx']."  and  userid=".$danid."  and flag=0  order by id");   
$row = mysql_fetch_array($result1);
					  
?>
      <tr>
        <td height="20" align="center" bgcolor="#FDF4CA"><?=$image['ds']?>
              <input name="ds[]" type="hidden" id="ds[]" value="<?=$image['ds']?>" />
              <input name="ygid[]" type="hidden" id="ygid[]" value="<?=$image['id']?>" /></td>
        <td align="center" bgcolor="#FEFBE9"><input
						   onblur="return CountGold1(this,'blur','SP','<? if ( $row2['abcd']=="A"){echo $row['yg'];}?><? if ( $row2['abcd']=="B"){echo $row['ygb'];}?><? if ( $row2['abcd']=="C"){echo $row['ygc'];}?><? if ( $row2['abcd']=="D"){echo $row['ygd'];}?>');" 
                    onkeyup="return CountGold1(this,'keyup');" 
						   name="m[]" class="input1" id="m[]" value='<?=$image['yg']?>' size="10" /></td>
        <td align="center" bgcolor="#FEFBE9"><input
						  onblur="return CountGold1(this,'blur','MP','<?=$row['xx']?>','<?=$t?>');" onkeyup="return CountGold1(this,'keyup');" 
						   name="mm<?=$t?>" class="input1" id="mm<?=$t?>" value='<?=$image['xx']?>' size="10" /></td>
        <td align="center" bgcolor="#FEFBE9"><input
						  onblur="return CountGold1(this,'blur','XP','<?=$row['xxx']?>','<?=$t?>');" 
                    onkeyup="return CountGold1(this,'keyup');" 
						   name="mmm<?=$t?>" class="input1" id="mmm<?=$t?>" value='<?=$image['xxx']?>' size="10" /></td>
        <?
						 $t++;

						 if ($image = mysql_fetch_array($result)){
						
						$result1 = mysql_query("select * from ka_quota where ds='".$image['ds']."' and lx=".$image['lx']."  and  userid=".$danid."  and flag=0  order by id");   
$row = mysql_fetch_array($result1);
						 
						 ?>
						 
        <td height="20" align="center" bgcolor="#FDF4CA"><?=$image['ds']?>
              <input name="ds[]" type="hidden" id="ds[]" value="<?=$image['ds']?>" />
              <input name="ygid[]" type="hidden" id="ygid[]" value="<?=$image['id']?>" /></td>
        <td align="center" bgcolor="#FEFBE9"><input name="m[]"
						  onblur="return CountGold1(this,'blur','SP','<? if ( $row2['abcd']=="A"){echo $row['yg'];}?><? if ( $row2['abcd']=="B"){echo $row['ygb'];}?><? if ( $row2['abcd']=="C"){echo $row['ygc'];}?><? if ( $row2['abcd']=="D"){echo $row['ygd'];}?>');" 
                    onkeyup="return CountGold1(this,'keyup');" 
						   class="input1" id="m[]" value='<?=$image['yg']?>' size="10" /></td>
        <td align="center" bgcolor="#FEFBE9"><input
						  onblur="return CountGold1(this,'blur','MP','<?=$row['xx']?>','<?=$t?>');" onkeyup="return CountGold1(this,'keyup');" 
						   name="mm<?=$t?>" class="input1" id="mm<?=$t?>" value='<?=$image['xx']?>' size="10" /></td>
        <td align="center" bgcolor="#FEFBE9"><input
						  onblur="return CountGold1(this,'blur','XP','<?=$row['xxx']?>','<?=$t?>');" 
                    onkeyup="return CountGold1(this,'keyup');" 
						   name="mmm<?=$t?>" class="input1" id="mmm<?=$t?>" value='<?=$image['xxx']?>' size="10" /></td>

        <? $t++;
						  }
						  
						   }?>
      </tr>
    </table> --></td>
  </tr>
  <tr>
    <td height="30" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td>
    <td colspan="3" bordercolor="#CCCCCC"><br />
        <table width="100" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="6"></td>
          </tr>
        </table>
      <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存会员" />
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
