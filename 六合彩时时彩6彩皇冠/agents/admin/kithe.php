<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}

 if (strpos($_SESSION['flag'],'01') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}

//修改信息
if ($_GET['act']=="添加") {

if (empty($_POST['nn'])) {
       
  echo "<script>alert('期数不能为空!');window.history.go(-1);</script>"; 
  exit;
    }
if (empty($_POST['nd'])){
  echo "<script>alert('开奖时间不能为了空!');window.history.go(-1);</script>"; 
  exit;
    }
if (empty($_POST['zfbdate'])){
  echo "<script>alert('总封盘时间不能为了空!');window.history.go(-1);</script>"; 
  exit;
    }
	
	if (empty($_POST['zfbdate1'])){
  echo "<script>alert('自动开盘时间不能为了空!');window.history.go(-1);</script>"; 
  exit;
    }
	

	$resultf = mysql_query("select * from ya_kithe order by nn");  
	$ii=1; 
while($imagef = mysql_fetch_array($resultf)){
$nnd1=$_POST['nn']+$ii;
	$sqlbbb="update ya_kithe set nn='".$nnd1."' where id=".$imagef['id']."";
	$exef=mysql_query($sqlbbb) or  die("数据库修改出错");
	$ii++; 
	}
	
	
	$sql="update ka_kithe set nn='".$_POST['nn']."',nd='".$_POST['nd']."',kitm='".$_POST['kitm']."',kizt='".$_POST['kizt']."',kizm='".$_POST['kizm']."',kizm6='".$_POST['kizm6']."',kigg='".$_POST['kigg']."',kilm='".$_POST['kilm']."',kisx='".$_POST['kisx']."',kibb='".$_POST['kibb']."',kiws='".$_POST['kiws']."',zfbdate='".$_POST['zfbdate']."',kitm1='".$_POST['kitm1']."',kizt1='".$_POST['kizt1']."',kizm1='".$_POST['kizm1']."',kizm61='".$_POST['kizm61']."',kigg1='".$_POST['kigg1']."',kilm1='".$_POST['kilm1']."',kisx1='".$_POST['kisx1']."',kibb1='".$_POST['kibb1']."',kiws1='".$_POST['kiws1']."',zfbdate1='".$_POST['zfbdate1']."' where id=".$_GET['id'];
	
$exe=mysql_query($sql) or  die("数据库修改出错");


	echo "<script>alert('盘口修改成功!');window.location.href='index.php?action=kithe';</script>"; 
exit;
}
///自动开盘


if ($_GET['t0']=="是") {
$sql="update ka_kithe set best=1 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("数据库修改出错");
echo "<script>alert('充许自动开盘!');window.location.href='index.php?action=kithe';</script>"; 
exit;

}
if ($_GET['t0']=="否") {
$sql="update ka_kithe set best=0 where id=".$_GET['newsid'];
$exe=mysql_query($sql) or  die("数据库修改出错");
echo "<script>alert('不充许自动开盘!');window.location.href='index.php?action=kithe';</script>"; 
exit;

}
///总封盘开奖

if ($_GET['t1']=="是" ) {
$sql="update ka_kithe set zfb='".$_GET['zfb']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");


if ($_GET['zfb']==1){
$sql="update ka_kithe set kitm=1,kizt=1,kizm=1,kizm6=1,kigg=1,kilm=1,kisx=1,kibb=1,kiws=1,zfb=1 where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");

echo "<script>alert('开盘成功!');window.location.href='index.php?action=kithe';</script>"; 
exit;}else{
$sql="update ka_kithe set kitm=0,kizt=0,kizm=0,kizm6=0,kigg=0,kilm=0,kisx=0,kibb=0,kiws=0,zfb=0 where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");

echo "<script>alert('封盘成功!');window.location.href='index.php?action=kithe';</script>"; 
exit;

}

}



	
//开奖

if ($_GET['svave']=="svave" ) {


if (!empty($_POST['na']) and $_POST['na']!=0){
$fa=$_POST['na'];
$fb=(int)$fa;

if ($fb<10) {
				  $vv="0".$fb;
				  }else{
				  $vv=$fb;
				  }
$sx=Get_sx_Color($vv);



$xn1=$_POST['n1'];
$xb1=(int)$xn1;

if ($xb1<10) {
				  $vv="0".$xb1;
				  }else{
				  $vv=$xb1;
				  }
$x1=Get_sx_Color($vv);


$xn1=$_POST['n2'];
$xb1=(int)$xn1;

if ($xb1<10) {
				  $vv="0".$xb1;
				  }else{
				  $vv=$xb1;
				  }
$x2=Get_sx_Color($vv);

$xn1=$_POST['n3'];
$xb1=(int)$xn1;

if ($xb1<10) {
				  $vv="0".$xb1;
				  }else{
				  $vv=$xb1;
				  }
$x3=Get_sx_Color($vv);

$xn1=$_POST['n4'];
$xb1=(int)$xn1;

if ($xb1<10) {
				  $vv="0".$xb1;
				  }else{
				  $vv=$xb1;
				  }
$x4=Get_sx_Color($vv);

$xn1=$_POST['n5'];
$xb1=(int)$xn1;

if ($xb1<10) {
				  $vv="0".$xb1;
				  }else{
				  $vv=$xb1;
				  }
$x5=Get_sx_Color($vv);

$xn1=$_POST['n6'];
$xb1=(int)$xn1;

if ($xb1<10) {
				  $vv="0".$xb1;
				  }else{
				  $vv=$xb1;
				  }
$x6=Get_sx_Color($vv);

$sql="update ka_kithe set na='".$_POST['na']."',x1='".$x1."',x2='".$x2."',x3='".$x3."',x4='".$x4."',x5='".$x5."',x6='".$x6."',sx='".$sx."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");

$sql22="update ka_bl set gold=0";
$exe=mysql_query($sql22) or  die("数据库修改出错1");

$resultf = mysql_query("select * from ya_kithe order by nn LIMIT 1");   
while($imagef = mysql_fetch_array($resultf)){
//添加新
$ykaid=$imagef['id'];
$nn=$imagef['nn']+3;

$sqlrr="INSERT INTO  ka_kithe set best='".$imagef['best']."',nn='".$imagef['nn']."',nd='".$imagef['nd']."',kitm='".$imagef['kitm']."',kizt='".$imagef['kizt']."',kizm='".$imagef['kizm']."',kizm6='".$imagef['kizm6']."',kigg='".$imagef['kigg']."',kilm='".$imagef['kilm']."',kisx='".$imagef['kisx']."',kibb='".$imagef['kibb']."',kiws='".$imagef['kiws']."',zfbdate='".$imagef['zfbdate']."',kitm1='".$imagef['kitm1']."',kizt1='".$imagef['kizt1']."',kizm1='".$imagef['kizm1']."',kizm61='".$imagef['kizm61']."',kigg1='".$imagef['kigg1']."',kilm1='".$imagef['kilm1']."',kisx1='".$imagef['kisx1']."',kibb1='".$imagef['kibb1']."',kiws1='".$imagef['kiws1']."',zfbdate1='".$imagef['zfbdate1']."',n1=0,n2=0,n3=0,n4=0,n5=0,n6=0,na=0,lx=0 ";
$exe=mysql_query($sqlrr) or  die("数据库修改出错");


$sqlzz="update ya_kithe set nn='".$nn."' where id=".$ykaid;
//echo $sqlzz;
//exit;
$exe=mysql_query($sqlzz) or  die("数据库修改出错1");

}




}

if (!empty($_POST['n1']) and $_POST['n1']!=0){
$sql="update ka_kithe set n1='".$_POST['n1']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");
}
if (!empty($_POST['n2']) and $_POST['n2']!=0){
$sql="update ka_kithe set n2='".$_POST['n2']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");
}
if (!empty($_POST['n3']) and $_POST['n3']!=0){
$sql="update ka_kithe set n3='".$_POST['n3']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");
}

if (!empty($_POST['n4']) and $_POST['n4']!=0){
$sql="update ka_kithe set n4='".$_POST['n4']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");
}
if (!empty($_POST['n5']) and $_POST['n5']!=0){
$sql="update ka_kithe set n5='".$_POST['n5']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");
}

if (!empty($_POST['n6']) and $_POST['n6']!=0){
$sql="update ka_kithe set n6='".$_POST['n6']."' where id=".$_GET['id'];
$exe=mysql_query($sql) or  die("数据库修改出错1");



}


if (!empty($_POST['na']) and $_POST['na']!=0){
echo "<script>alert('开奖成功,请验证没有开错后在结算！!');window.location.href='index.php?action=kakithe';</script>"; 
exit;
}

}


?>


	<?
	$nana=1;
	$result=mysql_query("select * from ka_kithe where na=0 order by nn desc LIMIT 1"); 
$row=mysql_fetch_array($result);
$id=$row['id'];
$nn=$row['nn'];
$nd=$row['nd'];
$zfbdate=$row['zfbdate'];
$zfbdate1=$row['zfbdate1'];
$kitm1=$row['kitm1'];
$kizt1=$row['kizt1'];
$kizm1=$row['kizm1'];
$kizm61=$row['kizm61'];
$kigg1=$row['kigg1'];
$kilm1=$row['kilm1'];
$kisx1=$row['kisx1'];
$kibb1=$row['kibb1'];
$kiws1=$row['kiws1'];


$nana=$row['na'];


  
	
	




	


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
.style2 {color: #ffffff}
.STYLE4 {color: #FF0000}
-->
</style><script language="JavaScript" type="text/JavaScript">
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
	
 		if(document.all.nn.value=='')
 		{ document.all.nn.focus(); alert("期数请务必输入!!"); return false; }
		
		if(document.all.nd.value=='')
 		{ document.all.nd.focus(); alert("开奖时间请务必输入!!"); return false; }
  	
 	
 	if(document.all.zfbdate.value=='')
 		{ document.all.zfbdate.focus(); alert("总封盘时间请务必输入!!"); return false; }
 	
	if(!confirm("是否确定修改盘口?")){
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

if (rtype=='SP' && (eval(goldvalue) > 49)) {gold.focus(); alert("对不起,请输入49以内的球号!!"); return false;}
}
</SCRIPT>
<table border="0" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="100%">
  <tr>
    <td class="tbtitle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25"><? require_once '1top.php';?></td>
		<td colspan="2" valign="middle" width="50%" align="center" nowrap="nowrap">&nbsp;</td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="left">
      <? if ($nana<>0) { ?>
      <table width="100%" height="100" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><button onclick="javascript:location.href='index.php?action=kithe_add'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:200;height:25" ;><font color="ff0000">添加新盘口......</font></button></td>
        </tr>
      </table>
      <?
				 }else{
				 ?>
      <table width="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
	   
        <tr bordercolor="#ECE9D8">
          <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">开奖球号：</td>
          <td width="89%" height="30" colspan="3" bordercolor="#CCCCCC"><?	if ($row['kizt']==0  && $row['kizm']==0  && $row['kibb']==0  && $row['kiws']==0  && $row['kizm6']==0  && $row['kisx']==0  && $row['kigg']==0  && $row['kilm']==0) {	?>
                <table border="1" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
                  <form action="index.php?action=kithe&amp;svave=svave&amp;id=<?=$id?>"  method="post" name="testFrm" id="testFrm">
                    <tr class="tbtitle">
                      <td height="25" align="center" class="STYLE2">平1</td>
                      <? if ($row['n1']<>"0" and $row['n1']<>"") { ?>
                      <td height="25" align="center" class="STYLE2">平2</td>
                      <? }?>
                      <? if ($row['n2']<>"0" and $row['n2']<>"") { ?>
                      <td height="25" align="center" class="STYLE2">平3</td>
                      <? }?>
                      <? if ($row['n3']<>"0" and $row['n3']<>"") { ?>
                      <td height="25" align="center" class="STYLE2">平4</td>
                      <? }?>
                      <? if ($row['n4']<>"0" and $row['n4']<>"" ){ ?>
                      <td height="25" align="center" class="STYLE2">平5</td>
                      <? }?>
                      <? if ($row['n5']<>"0" and $row['n5']<>"") { ?>
                      <td height="25" align="center" class="STYLE2">平6</td>
                      <? }?>
                      <? if ($row['n6']<>"0" and $row['n6']<>"") { ?>
                      <td height="25" align="center" class="STYLE2">特码</td>
                      <? }?>
                      <td align="center" class="STYLE2">操作</td>
                    </tr>
                    <tr>
                      <td height="25" align="center"><input 
							
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
						
							name="n1" type="text" class="input1"  id="n1" value="<?=$row['n1']?>" size="8" /></td>
                      <? if ($row['n1']<>"0" and $row['n1']<>"") { ?>
                      <td height="25" align="center"><input name="n2"
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
						
							 type="text" class="input1"  id="n2" value="<?=$row['n2']?>" size="8" /></td>
                      <? }?>
                      <? if ($row['n2']<>"0" and $row['n2']<>"") { ?>
                      <td height="25" align="center"><input
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
							 name="n3" type="text" class="input1"  id="n3" value="<?=$row['n3']?>" size="8" /></td>
                      <? }?>
                      <? if ($row['n3']<>"0" and $row['n3']<>"") { ?>
                      <td height="25" align="center"><input
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
							 name="n4" type="text" class="input1"  id="n4" value="<?=$row['n4']?>" size="8" /></td>
                      <? }?>
					  
					 
					  
					  
                      <? if ($row['n4']<>"0" and $row['n4']<>"") { ?>
                      <td height="25" align="center">
					   <? if ($row['zfb']!=0){?>
					   请先封盘
					   
					   <? }else{?>
					  <input
							
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
						
						 name="n5" type="text" class="input1"  id="n5" value="<?=$row['n5']?>" size="8" />
						 
						 <? }?>
					  </td>
                      <? }?>
                      <? if ($row['n5']<>"0" and $row['n5']<>"") { ?>
                      <td height="25" align="center"><input
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');"  name="n6" type="text" class="input1"  id="n6" value="<?=$row['n6']?>" size="8" /></td>
                      <? }?>
                      <? if ($row['n6']<>"0" and $row['n6']<>"") { ?>
                      <td height="25" align="center"><input 
							onblur="return CountGold(this,'blur','SP');"
					    
					    onkeyup="return CountGold(this,'keyup');" 
						name="na" type="text" class="input1"  id="na" value="<?=$row['na']?>" size="8" /></td>
                      <? } ?>
                      <td align="center"><input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit2" value="开奖" /></td>
                    </tr>
                    <tr>
                      <td height="25" colspan="8" align="center"><span class="STYLE4">如果还未到开奖，这里数据请保持为0！</span></td>
                    </tr>
                  </form>
                </table>
            <?  }else{ ?>
                <font color="ff000">请先封盘在开奖！</font>
                <? } ?>
          </td>
        </tr>
      </table>
      <table width="100%"  border="1" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
        <form action="index.php?action=kithe&amp;act=添加&amp;id=<?=$id?>" method="post" name="testFrm" id="testFrm" onsubmit="return SubChk()">
          <tr>
            <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">期数：</td>
            <td width="31%" bordercolor="#CCCCCC"><input  <? if ($row['zfb']==1) {?>  readonly="readonly" <? }?>   name="nn" type="text" class="input1"  id="nn" value="<?=$nn?>" size="8" />
                  <span class="STYLE2">*（正在开盘时不能修改！）</span></td>
            <td width="13%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">开奖时间：</td>
            <td width="45%" bordercolor="#CCCCCC"><input name="nd" type="text" class="input1"  id="nd" value="<?=$nd?>" size="35" />
                  <span class="STYLE2">*</span> </td>
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总封盘：</td>
            <td bordercolor="#CCCCCC"><button onclick="javascript:location.href='index.php?action=kithe&amp;t1=是&amp;id=<?=$id?>&amp;zfb=<? if ($row['zfb']==0) {?>1<? }else{ ?>0<? }?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:150;height:22" ;>
              <? if ($row['zfb']==0 ){ ?>
              <font color="#0000FF">正在封盘中...</font>
              <? }else{ ?>
              <font color="ff0000">正在开盘中...</font>
              <? }?>
            </button></td>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="zfbdate" type="text" class="input1"  id="zfbdate" value="<?=$zfbdate?>" size="35" />
                  <span class="STYLE2">*</span> </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自动开盘时间：</td>
            <td height="30" colspan="3" valign="middle" bordercolor="#CCCCCC"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input name="zfbdate1" type="text" class="input1"  id="zfbdate1" value="<?=$zfbdate1?>" size="35" /></td>
                <td width="25"><a href="index.php?action=kithe&amp;newsid=<?=$id?>&amp;t0=<? if ($row['best']==1 ){?>否<? }else{ ?>是<? }?>"><img src="images/<? if ($row['best']==1 ){?>icon_21x21_selectboxon.gif<? }else{ ?>icon_21x21_selectboxoff.gif<? }?>" name="test_b<?=$row['id']?>" width="21" height="21" border="0" id="test_b<?=$row['id']?>"  value="<? if ($row['best']==1 ){?>True<? }else{ ?>False<? }?>" /></a></td>
                <td>(是否充许自动开盘)<span class="STYLE4">*(如果开始设成了自动开盘，那自动开盘后这勾会自动变成不打勾！)</span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">特码：</td>
            <td bordercolor="#CCCCCC"><input name="kitm" type="radio" value="0" <? if ($row['kitm']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kitm']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kitm" type="radio" value="1" <? if ($row['kitm']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kitm']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td>
            <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">特码自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kitm1" type="text" class="input1"  id="kitm1" value="<?=$kitm1?>" size="35" /></td>
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正特：</td>
            <td bordercolor="#CCCCCC"><input name="kizt" type="radio" value="0" <? if ($row['kizt']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kizt']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kizt" type="radio" value="1" <? if ($row['kizt']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kizt']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kizt1" type="hidden" class="input1"  id="kizt1" value="<?=$kizt1?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正特自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kizt1" type="text" class="input1"  id="kizt1" value="<?=$kizt1?>" size="35" /></td> -->
            <td rowspan="8" height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码自动封盘时间：</td>
            <td rowspan="8" bordercolor="#CCCCCC"><input name="kizm1" type="text" class="input1"  id="kizm1" value="<?=$kizm1?>" size="35" onchange="javascript: document.getElementById('kizt1').value=this.value; document.getElementById('kizm61').value=this.value; document.getElementById('kigg1').value=this.value; document.getElementById('kilm1').value=this.value; document.getElementById('kisx1').value=this.value; document.getElementById('kibb1').value=this.value; document.getElementById('kiws1').value=this.value;" /></td>
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码：</td>
            <td bordercolor="#CCCCCC"><input name="kizm" type="radio" value="0" <? if ($row['kizm']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kizm']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kizm" type="radio" value="1" <? if ($row['kizm']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kizm']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td>
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kizm1" type="text" class="input1"  id="kizm1" value="<?=$kizm1?>" size="35" /></td> -->
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">五行：</td>
            <td bordercolor="#CCCCCC"><input name="kizm6" type="radio" value="0" <? if ($row['kizm6']==0) {?> checked="checked"<? }?> />
              <? if ($row['kizm6']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
              <input name="kizm6" type="radio" value="1" <? if ($row['kizm6']==1) {?> checked="checked"<? }?> />
              <? if ($row['kizm6']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kizm61" type="hidden" class="input1"  id="kizm61" value="<?=$kizm61?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">五行自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kizm61" type="text" class="input1"  id="kizm61" value="<?=$kizm61?>" size="35" /></td> -->
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">过关：</td>
            <td bordercolor="#CCCCCC"><input name="kigg" type="radio" value="0" <? if ($row['kigg']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kigg']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kigg" type="radio" value="1" <? if ($row['kigg']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kigg']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kigg1" type="hidden" class="input1"  id="kigg1" value="<?=$kigg1?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">过关自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kigg1" type="text" class="input1"  id="kigg1" value="<?=$kigg1?>" size="35" /></td> -->
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">连码：</td>
            <td bordercolor="#CCCCCC"><input name="kilm" type="radio" value="0" <? if ($row['kilm']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kilm']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kilm" type="radio" value="1" <? if ($row['kilm']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kilm']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kilm1" type="hidden" class="input1"  id="kilm1" value="<?=$kilm1?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">连码自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kilm1" type="text" class="input1"  id="kilm1" value="<?=$kilm1?>" size="35" /></td> -->
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">生肖/正特尾：</td>
            <td bordercolor="#CCCCCC"><input name="kisx" type="radio" value="0" <? if ($row['kisx']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kisx']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kisx" type="radio" value="1" <? if ($row['kisx']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kisx']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kisx1" type="hidden" class="input1"  id="kisx1" value="<?=$kisx1?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">生肖自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kisx1" type="text" class="input1"  id="kisx1" value="<?=$kisx1?>" size="35" /></td> -->
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">半波/半半波/正肖七色波：</td>
            <td bordercolor="#CCCCCC"><input name="kibb" type="radio" value="0" <? if ($row['kibb']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kibb']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kibb" type="radio" value="1" <? if ($row['kibb']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kibb']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kibb1" type="hidden" class="input1"  id="kibb1" value="<?=$kibb1?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">半波自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kibb1" type="text" class="input1"  id="kibb1" value="<?=$kibb1?>" size="35" /></td> -->
          </tr>
          <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">头尾数：</td>
            <td bordercolor="#CCCCCC"><input name="kiws" type="radio" value="0" <? if ($row['kiws']==0) {?> checked="checked"<? }?> />
                  <? if ($row['kiws']==0) {?>
              <font color="ff6600">封</font>
              <? }else{?>
              封
              <? }?>
                  <input name="kiws" type="radio" value="1" <? if ($row['kiws']==1) {?> checked="checked"<? }?> />
                  <? if ($row['kiws']==1) {?>
              <font color="ff6600">开</font>
              <? }else{?>
              开
              <? }?></td><input name="kiws1" type="hidden" class="input1"  id="kiws1" value="<?=$kiws1?>" size="35" />
            <!-- <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">尾数自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="kiws1" type="text" class="input1"  id="kiws1" value="<?=$kiws1?>" size="35" /></td> -->
          </tr>
          <!-- <tr>
            <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td>
            <td bordercolor="#CCCCCC">&nbsp;</td>
            <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">全部自动封盘时间：</td>
            <td bordercolor="#CCCCCC"><input name="quanbu" type="text" class="input1"  id="quanbu" value="" size="35" onchange="javascript: if (this.value) {document.getElementById('kizt1').value=this.value; document.getElementById('kizm61').value=this.value; document.getElementById('kigg1').value=this.value; document.getElementById('kilm1').value=this.value; document.getElementById('kisx1').value=this.value; document.getElementById('kibb1').value=this.value; document.getElementById('kiws1').value=this.value; document.getElementById('kizm1').value=this.value; document.getElementById('kitm1').value=this.value;}" /></td>
          </tr> -->
          <tr>
            <td height="30" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td>
            <td colspan="3" bordercolor="#CCCCCC"><br />
                  <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="6"></td>
                    </tr>
                  </table>
              <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="保存盘口" />
                  <br />
                  <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="10"></td>
                    </tr>
                </table></td>
          </tr>
        </form>
      </table>
      <? } ?>
      <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
        <tr>
          <td height="25" align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">预设开奖期数</td>
          <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">开奖时间</td>
          <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">自动开盘时间</td>
          <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">自动封盘时间</td>
          <td align="center" valign="middle" bordercolor="cccccc" bgcolor="#FDF4CA">操作</td>
        </tr>
        <?
		$resultf = mysql_query("select * from ya_kithe order by nn");   
while($imagef = mysql_fetch_array($resultf)){?>
	    <tr>
          <td height="25" align="center" valign="middle" bordercolor="cccccc"><?=$imagef['nn']?></td>
          <td align="center" valign="middle" bordercolor="cccccc"><?=$imagef['nd']?></td>
          <td align="center" valign="middle" bordercolor="cccccc"><?=$imagef['zfbdate1']?></td>
          <td align="center" valign="middle" bordercolor="cccccc"><?=$imagef['zfbdate']?></td>
          <td align="center" valign="middle" bordercolor="cccccc"><button onclick="javascript:location.href='index.php?action=ykithe&amp;id=<?=$imagef['id']?>'"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:50;height:22" ;><img src="images/icon_21x21_edit01.gif" align="absmiddle" />设置</button></td>
        </tr>
		<?  }
		?>
      </table>
    </div></td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left"> </div></td>
    <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 操作提示：自动封盘时间必须大于当前系统时间。</div></td>
  </tr>
</table>

<script language="JavaScript" type="text/JavaScript">
//if (document.getElementById('kitm1').value == document.getElementById('kizm1').value) document.getElementById('quanbu').value = document.getElementById('kitm1').value;
</script>
