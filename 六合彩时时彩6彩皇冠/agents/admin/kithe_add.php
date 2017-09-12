<?
if(!defined('PHPYOU_VER')) {
	exit('非法进入');
}
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
if ($_POST['tv5']=="是"){	
	
	$best=1;
	}else{
	$best=0;
	}
	


$result=mysql_query("select * from ka_kithe where nn=".$_POST['nn']."   order by id"); 
$row11=mysql_fetch_array($result);
if ($row11!=""){
 echo "<script>alert('对不起！这一“期”已被开过，请重新输入!');window.history.go(-1);</script>"; 
  exit;
exit;

}

$result=mysql_query("select * from ka_kithe where na=0  order by id"); 
$row11=mysql_fetch_array($result);
if ($row11!=""){
 echo "<script>alert('对不起！第[".$row11['nn']."]期还未开奖！请先开完奖在添加新的盘口!');window.history.go(-1);</script>"; 
  exit;
}


$result22=mysql_query("update ka_bl set gold=0");


	
	$sql="INSERT INTO  ka_kithe set best='".$best."',nn='".$_POST['nn']."',nd='".$_POST['nd']."',kitm='".$_POST['kitm']."',kizt='".$_POST['kizt']."',kizm='".$_POST['kizm']."',kizm6='".$_POST['kizm6']."',kigg='".$_POST['kigg']."',kilm='".$_POST['kilm']."',kisx='".$_POST['kisx']."',kibb='".$_POST['kibb']."',kiws='".$_POST['kiws']."',zfbdate='".$_POST['zfbdate']."',kitm1='".$_POST['kitm1']."',kizt1='".$_POST['kizt1']."',kizm1='".$_POST['kizm1']."',kizm61='".$_POST['kizm61']."',kigg1='".$_POST['kigg1']."',kilm1='".$_POST['kilm1']."',kisx1='".$_POST['kisx1']."',kibb1='".$_POST['kibb1']."',kiws1='".$_POST['kiws1']."',zfbdate1='".$_POST['zfbdate1']."',n1=0,n2=0,n3=0,n4=0,n5=0,n6=0,na=0,lx=0 ";
	
$exe=mysql_query($sql) or  die("数据库修改出错");
	


	echo "<script>alert('盘口修改成功!');window.location.href='index.php?action=kithe';</script>"; 
exit;
}

$result=mysql_query("select * from ka_kithe where na=0  order by id"); 
$row11=mysql_fetch_array($result);
if ($row11!=""){
 echo "<script>alert('对不起！第[".$row11['nn']."]期还未开奖！请先开完奖在添加新的盘口!');window.history.go(-1);</script>"; 
  exit;
}
$result=mysql_query("select * from ka_kithe where na<>0 order by nn desc LIMIT 1"); 
$row=mysql_fetch_array($result);
$nn=$row['nn']+1;
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
	
 	if(document.all.nn.value=='')
 		{ document.all.nn.focus(); alert("期数请务必输入!!"); return false; }
		
		if(document.all.nd.value=='')
 		{ document.all.nd.focus(); alert("开奖时间请务必输入!!"); return false; }
  	
 	
 	if(document.all.zfbdate.value=='')
 		{ document.all.zfbdate.focus(); alert("总封盘时间请务必输入!!"); return false; }
		
		
  
 	
	if(!confirm("是否确定写入盘口?")){
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
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="29%"><? require_once '1top.php';?></td>
    <td width="34%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">



<form name=testFrm onSubmit="return SubChk()" method="post" action="index.php?action=kithe_add&act=添加">
    <tr> 
      <td valign="top">
        <div align="center">
          <table width="100%"  border="1" cellpadding="2" cellspacing="2" bordercolor="#ECE9D8">
            <tr>
              <td width="11%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">期数：</td>
              <td width="27%" bordercolor="#CCCCCC"><input name="nn" type="text" class="input1"  id="nn" value="<?=$nn?>" size="8" />
                  <span class="STYLE2"> *</span></td>
              <td width="17%" height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">开奖时间：</td>
              <td width="45%" bordercolor="#CCCCCC"><input name="nd" type="text" class="input1"  id="nd" value="<?=$nd?>" size="35" />
                  <span class="STYLE2">*</span> </td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="zfbdate" type="text" class="input1"  id="zfbdate" value="<?=$zfbdate?>" size="35" />
                  <span class="STYLE2">*</span> </td>
              <td align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">自动开盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="zfbdate1" type="text" class="input1"  id="zfbdate1" value="<?=$zfbdate1?>" size="35" />
                  <input name="tv5" type="hidden" id="tv5" value="否" />
                  <img src="images/icon_21x21_selectboxoff.gif" name="tv5_b" align="absmiddle" class="cursor" id="tv5_b" onclick="javascript:ra_select('tv5')" />(是否充许自动开盘)<span class="STYLE2">*</span></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">总封盘：</td>
              <td bordercolor="#CCCCCC"><input name="zfb" type="radio" value="0" checked="checked" />
                封盘
                <input name="zfb" type="radio" value="1" />
                开盘</td>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">&nbsp;</td>
              <td bordercolor="#CCCCCC">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">特码：</td>
              <td bordercolor="#CCCCCC"><input name="kitm" type="radio" value="0" />
                封
                <input name="kitm" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">特码自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kitm1" type="text" class="input1"  id="kitm1" value="<?=$kitm1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正特：</td>
              <td bordercolor="#CCCCCC"><input name="kizt" type="radio" value="0" />
                封
                <input name="kizt" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正特自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kizt1" type="text" class="input1"  id="kizt1" value="<?=$kizt1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码：</td>
              <td bordercolor="#CCCCCC"><input name="kizm" type="radio" value="0" />
                封
                <input name="kizm" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正码自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kizm1" type="text" class="input1"  id="kizm1" value="<?=$kizm1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">五行：</td>
              <td bordercolor="#CCCCCC"><input name="kizm6" type="radio" value="0" />
                封
                <input name="kizm6" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">正1-6自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kizm61" type="text" class="input1"  id="kizm61" value="<?=$kizm61?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">过关：</td>
              <td bordercolor="#CCCCCC"><input name="kigg" type="radio" value="0" />
                封
                <input name="kigg" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">过关自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kigg1" type="text" class="input1"  id="kigg1" value="<?=$kigg1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">连码：</td>
              <td bordercolor="#CCCCCC"><input name="kilm" type="radio" value="0" />
                封
                <input name="kilm" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">连码自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kilm1" type="text" class="input1"  id="kilm1" value="<?=$kilm1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">生肖：</td>
              <td bordercolor="#CCCCCC"><input name="kisx" type="radio" value="0" />
                封
                <input name="kisx" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">生肖自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kisx1" type="text" class="input1"  id="kisx1" value="<?=$kisx1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">半波：</td>
              <td bordercolor="#CCCCCC"><input name="kibb" type="radio" value="0" />
                封
                <input name="kibb" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">半波自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kibb1" type="text" class="input1"  id="kibb1" value="<?=$kibb1?>" size="35" /></td>
            </tr>
            <tr>
              <td height="30" align="right" bordercolor="#CCCCCC" bgcolor="#FDF4CA">尾数：</td>
              <td bordercolor="#CCCCCC"><input name="kiws" type="radio" value="0" />
                封
                <input name="kiws" type="radio" value="1" checked="checked" />
                开</td>
              <td height="30" align="right" nowrap="nowrap" bordercolor="#CCCCCC" bgcolor="#FDF4CA">尾数自动封盘时间：</td>
              <td bordercolor="#CCCCCC"><input name="kiws1" type="text" class="input1"  id="kiws1" value="<?=$kiws1?>" size="35" /></td>
            </tr>
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
          </table>
          <br>
          <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr> 
              <td> 
                <div align="left"> </div>
              </td>
              <td> 
                <div align="right" disabled><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle"> 
                  操作提示：自动封盘时间必须大于当前系统时间。</div>
              </td>
            </tr>
          </table>
          <table width="100" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td height="10"></td>
            </tr>
          </table> 
        </div>
      </td>
    </tr>
  </form></table>

</div>
