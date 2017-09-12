<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_GET['ids']!="") {$ids=$_GET['ids'];}else{$ids="过关";}



if ($_GET['zsave']=="zsave") {

if ($_POST['tm']=="") {       
  echo "<script>alert('预计亏损不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}
if ($_POST['tm1']=="") {       
  echo "<script>alert('退水不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}

$exe=mysql_query("update adad set zlm='".$_POST['tm']."',zlm1='".$_POST['tm1']."'  Where id=1");
}
$result=mysql_query("select * from adad order by id"); 
$row=mysql_fetch_array($result);

$best=$row['best'];	
	$zm=$row['zm'];
	$zm6=$row['zm6'];
	$lm=$row['lm'];	
	$zlm=$row['zlm'];
	$ys=$row['ys'];
	$ls=$row['ls'];
	$dx=$row['dx'];
	$tm=$row['tm'];
	$spx=$row['spx'];
	$bb=$row['bb'];
	$zmt=$row['zmt'];
	$ws=$row['ws'];
	$zm1=$row['zm1'];
	$zm61=$row['zm61'];
	$lm1=$row['lm1'];	
	$zlm1=$row['zlm1'];
	$ys1=$row['ys1'];
	$ls1=$row['ls1'];
	$dx1=$row['dx1'];
	$tm1=$row['tm1'];
	$spx1=$row['spx1'];
	$bb1=$row['bb1'];
	$zmt1=$row['zmt1'];
	$ws1=$row['ws1'];
	$ps1=$row['ps1'];
	$ps=$row['ps'];	
$zds=$zlm1;
if ($_GET['kithe']!=""){$kithe=$_GET['kithe'];}else{$kithe=$Current_Kithe_Num;}
if ($kithe!=$Current_Kithe_Num){$ftime=20000000;}





if ($_GET['save']=="save") {

if ($kithe==$Current_Kithe_Num){
if ($Current_KitheTable[30]==0) {       
  echo "<script>alert('封盘中');window.history.go(-1);</script>"; 
  exit;
}}else{ echo "<script>alert('封盘中');window.history.go(-1);</script>"; 
  exit;

}


if ($_POST['ds']=="") {       
  echo "<script>alert('退水有误，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}

if (empty($_POST['rate'])) {       
  echo "<script>alert('赔率有误，请输入数字！');window.history.go(-1);</script>"; 
  exit;
}

if (empty($_POST['sum_m'])) {       
  echo "<script>alert('金额有误，请输入数字');window.history.go(-1);</script>"; 
  exit;
}
 $text=date("Y-m-d H:i:s");

$num=randStr();
$sql="INSERT INTO  ka_tan set num='".$num."',username='外调',kithe='".$Current_Kithe_Num."',adddate='".$text."',class1='".$_POST['class1']."',class2='".$_POST['class2']."',class3='".$_POST['class3']."',rate='".$_POST['rate']."',sum_m='".-$_POST['sum_m']."',user_ds='".-$_POST['ds']."',dai_ds='".-$_POST['ds']."',zong_ds='".-$_POST['ds']."',guan_ds='".-$_POST['ds']."',dai_zc=0,zong_zc=0,guan_zc=0,dagu_zc=10,bm=0,dai='外调',zong='外调',guan='外调',abcd='A',lx=1";

$exe=mysql_query($sql) or  die("数据库修改出错");



echo "<script>alert('补仓成功!');window.location.href='index.php?action=pz_gg&ids=".$ids."&kithe=".$kithe."';</script>"; 
exit;

}


?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script>

function makeRequest(url) {

    http_request = false;
   
    if (window.XMLHttpRequest) {
   
        http_request = new XMLHttpRequest();
   
        if (http_request.overrideMimeType){
   
            http_request.overrideMimeType('text/xml');
   
        }
   
    } else if (window.ActiveXObject) {
   
        try{
       
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
       
        } catch (e) {
       
            try {
           
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
           
            } catch (e) {
       
            }
   
        }

     }
     if (!http_request) {
     
        alert("Your browser nonsupport operates at present, please use IE 5.0 above editions!");
       
        return false;
       
     }
 

//method init,no init();
 http_request.onreadystatechange = init;
 
 http_request.open('GET', url, true);

//Forbid IE to buffer memory
 http_request.setRequestHeader("If-Modified-Since","0");

//send count
 http_request.send(null);

//Updated every two seconds a page
 setTimeout("makeRequest('"+url+"')", <?=$ftime?>);

}


function init() {
 
    if (http_request.readyState == 4) {
   
        if (http_request.status == 0 || http_request.status == 200) {
       
            var result = http_request.responseText;
			
           
            if(result==""){
           
                result = "Access failure ";
           
            }
           
		   var arrResult = result.split("###");	
		   RemoveRow(); //删除以前的数据.
		   
		  for(var i=0;i<arrResult.length-1;i++)
{
arrTmp = arrResult[i].split("@@@");

if (i!=arrResult.length-2){

var arrTmp1 = arrTmp[0].split("##");

var mu1=arrTmp1[2];
var ma1=arrTmp1[1];
var mu = mu1.split(",");
var ma = ma1.split(",");
var z=0;
var zmzm=0;
var zmzm="";

for(var b=0;b<ma.length-1;b++)
{
zmzm=zmzm+ma[b]+" "+mu[z]+"@<font color=ff6600>"+mu[z+1]+"</font><br>";
	
	z=z+2
}

 
		
var zmzm1="index.php?action=look&kithe=<?=$kithe?>&class2="+arrTmp1[1]+"&lx=0&id=9&class3="+arrTmp1[2];
var zmzm2="index.php?action=look&lx=1&kithe=<?=$kithe?>&class2="+arrTmp1[1]+"&id=9&class3="+arrTmp1[2];

//var zmzm1="look.asp?lx=0&id=9&class2="+arrTmp1[0]+"&class3="+arrTmp1[1];
//var zmzm2="look.asp?lx=1&id=9&class2="+arrTmp1[0]+"&class3="+arrTmp1[1];

num2 = "<center>"+zmzm+"</center>"; //字段num2的值
}else{

//num2 = "<font color="+arrTmp[13]+"><strong><center>"+arrTmp[0]+"</center></strong></font>"; //字段num2的值

num2 = "<center>"+arrTmp[0]+"</center>";
}










if (i==(arrResult.length-2)){
num2="<center><font color=ff6600>总计</font></center>"
num1 = "<center>&nbsp;</center>";
}else{
num1 = "<center>"+(i+1)+"</center>"; //字段num1的值
}

num3 = "<center>"+arrTmp[1]+"</center>"; //字段num1的值
if (i!=(arrResult.length-2)){

num4 = "<center><button class=headtd4  onmouseover=this.className='headtd3';window.status='过关'; return true; onMouseOut=this.className='headtd4';window.status='过关';return true;  onClick=ops('"+zmzm1+"',400,700)>"+arrTmp[2]+"</button></center>"; //字段num2的值
}else{num4 = "<center>"+arrTmp[2]+"</center>";
}
num5 = "<center>"+arrTmp[3]+"</center>"; //字段num1的值
num6 = "<center>"+arrTmp[4]+"</center>"; //字段num2的值
num7 = "<center>"+arrTmp[5]+"</center>"; //字段num1的值
num8 = "<center>"+arrTmp[6]+"</center>"; //字段num2的值
num9 = "<center>"+arrTmp[7]+"</center>"; //字段num2的值
num10 = "<center>"+arrTmp[8]+"</center>"; //字段num1的值

if (arrTmp[9]!="0" && i!=(arrResult.length-2)){


num11 = "<center><button class=headtd4  onmouseover=this.className='headtd3';window.status='过关'; return true; onMouseOut=this.className='headtd4';window.status='过关';return true;  onClick=ops('"+zmzm2+"',400,700)>"+arrTmp[9]+"</button></center>"; //字段num2的值
}else{
num11 = "<center>"+arrTmp[9]+"</center>"; //字段num2的值
}


if ( i!=(arrResult.length-2)){
num12 = "<center>"+arrTmp[10]+"</center>"; //字段num2的值

}else{
num12 = "<center>"+arrTmp[10]+"</center>"; //字段num2的值
}


num13 = arrTmp[11]; //字段num2的值



row1 = tb.insertRow();
with(tb.rows(tb.rows.length-1)){
//bgColor="skyblue";
if(i%2==0){
//bgColor="#E8E4D0"; 
}
//onMouseOver=this.className='headtd1';
// onMouseOut=this.className='headtd2';
 
//onmouseover="javascript:this.bgColor='#ffffcc'";
//onmouseout="javascript:this.bgColor='#ffffff'";
}
with(tb.rows(tb.rows.length-1)){
if (arrResult.length-1==i){
// bgColor="#E0DCC0";
 }
}

with(tb.rows(tb.rows.length-1)){
 height="28";
}




cell1 = row1.insertCell();
cell1.innerHTML = num1;

cell2 = row1.insertCell();
cell2.innerHTML = num2;

cell3 = row1.insertCell();
cell3.innerHTML = num3;

cell4 = row1.insertCell();
cell4.innerHTML = num4;

cell5 = row1.insertCell();
cell5.innerHTML = num5;

cell6 = row1.insertCell();
cell6.innerHTML = num7;
cell7 = row1.insertCell();
cell7.innerHTML = num8;
cell8 = row1.insertCell();
cell8.innerHTML = num9;
cell9 = row1.insertCell();
cell9.innerHTML = num10;
cell10 = row1.insertCell();
cell10.innerHTML = num11;


cell11 = row1.insertCell();
cell11.innerHTML = num12;


}
			
			
           
        } else {//http_request.status != 200
           
                alert("Request failed! ");
       
        }
   
    }
 
}

function RemoveRow()
{
//保留第一行表头,其余数据均删除.
var iRows = tb.rows.length;
for(var i=0;i<iRows-1;i++)
{
tb.deleteRow(1);
}
}


</script>





<style type="text/css">
<!--
.STYLE1 {
	font-size: 12px;
	font-weight: bold;
	color: #FF0000;
}
.STYLE2 {font-weight: bold}
-->
</style>
<body  >
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">


<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td><? require_once '3top.php';?></td>
  </tr>
  <tr >
    <td height="5"></td>
  </tr>
</table>
<table   border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
  <tr>
    <td width="72%" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td width="150" nowrap><?=$ids?>统计[<?=$kithe?>期]</td>
        <td width="73" align="right" nowrap>选择期数： </td>
        <td width="36" nowrap><SELECT class=zaselect_ste name=temppid onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}">
          <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=index.php?action=pz_gg&ids=".$ids."&kithe=".$image['nn'];
				 if ($kithe!="") {
				 if ($kithe==$image['nn']) {
				  echo " selected=selected ";
				  }				
				}
				 echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
        </SELECT></td>
        <form name=form55 action="index.php?action=pz_gg&zsave=zsave&kithe=<?=$kithe?>&ids=<?=$ids?>" method=post>
          <td width="85" align="right" nowrap>最大亏损：</td>
          <td width="30"><span class="STYLE2">
            <input name="tm" class="input1" id="tm" value='<?=$zlm?>' size="10" />
          </span></td>
          <td width="50" align="right" nowrap>退水：</td>
          <td width="63"><input name="tm1" class="input1" type="text" id="tm1" value="<?=$zlm1?>" size="5"></td>
          <td width="94"><button onClick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button></td>
        </form>
        <td width="697">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

<table id="tb"  border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
  <tr >
    <td width="4%" height="28" align="center" nowrap="NOWRAP" bordercolor="cccccc" bgcolor="#FDF4CA">序号</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td width="40" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">注数</td>
    <td width="9%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">下注总额</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">占成</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">佣金</td>
    <td width="9%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">彩金</td>
    <td width="9%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td width="8%" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">走飞金额</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
  </tr>
  <tr >
    <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td height="28" align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
    <td align="center" nowrap="nowrap">&nbsp;</td>
  </tr>
</table>
<DIV id=rs_window style="DISPLAY: none; POSITION: absolute">
 <form action="index.php?action=pz_gg&save=save&ids=<?=$ids?>&kithe=<?=$kithe?>"    method="post" name="form1" > <?
include("d1.php");
?>
</form>
</div>
<DIV id=rs1_window style="DISPLAY: none; POSITION: absolute">

</div>

<SCRIPT language=javascript>

function show1_win(zid) {
rs1_window.style.top=220;
rs1_window.style.left=300;
document.all["rs1_window"].style.display = "block";
document.all["rs_window"].style.display = "none";

}




function show_win(id,sum_m,rate,class1,class2) {

document.all["r_title"].innerHTML = '<font color="#FF6600"><b>['+ id +'码] 请设定</b></font>';
document.form1.rate.value =rate;
document.all.ag_count.innerHTML =rate;
document.form1.sum_m.value =sum_m;
document.all.ag1_c.innerHTML =class1+":"+id;
document.form1.class1.value =class1;
document.form1.class3.value =id;
document.form1.class2.value =class2;
//document.form1.bl1.value =rate;

rs_window.style.top=220;
rs_window.style.left=300;
document.all["rs_window"].style.display = "block";
document.all["rs1_window"].style.display = "none";
}

function changep1(pid)
{
if (pid==1){
document.form1.rate.value =document.form1.bl1.value;
document.all.ag_count.innerHTML =document.form1.bl1.value;}else{
document.form1.rate.value =document.form1.bl.value;
document.all.ag_count.innerHTML =document.form1.bl.value;


}
}

function close_win() {
	document.all["rs_window"].style.display = "none";
}
function close1_win() {
	document.all["rs1_window"].style.display = "none";
}



</SCRIPT>
<SCRIPT language=javascript>
 makeRequest('index.php?action=server_gg&class1=过关&class2=<?=$ids?>&kithe=<?=$kithe?>')</script>
