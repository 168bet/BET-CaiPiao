<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if ($_GET['page']!="") {$page=$_GET['page'];}else{$page=0;}

if ($_GET['ids']!="") {$ids=$_GET['ids'];}else{$ids="三全中";
$c1="三全中";}

if ($ids=="三全中" ){
$c1="三全中";
$z6color="494949";
$z2color="494949";
$z4color="494949";
$z3color="494949";
$z5color="494949";
$z1color="ff0000";
}elseif ($ids=="三中二" ){
$c1="中三";
$z6color="494949";
$z5color="494949";
$z4color="494949";
$z3color="494949";
$z1color="494949";
$z2color="ff0000";
}elseif ($ids=="二全中" ){
$c1="二全中";
$z6color="494949";
$z2color="494949";
$z4color="494949";
$z5color="494949";
$z1color="494949";
$z3color="ff0000";
}elseif ($ids=="二中特" ){
$c1="二中";
$z6color="494949";
$z2color="494949";
$z5color="494949";
$z3color="494949";
$z1color="494949";
$z4color="ff0000";


}elseif ($ids=="特串" ){
$c1="特串";
$z6color="494949";
$z2color="494949";
$z4color="494949";
$z3color="494949";
$z1color="494949";
$z5color="ff0000";

}elseif ($ids=="四中一" ){
$c1="四中一";
$z5color="494949";
$z2color="494949";
$z4color="494949";
$z3color="494949";
$z1color="494949";
$z6color="ff0000";


}

if ($_GET['zsave']=="zsave") {

if ($_POST['tm']=="") {       
  echo "<script>alert('预计亏损不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}
if ($_POST['tm1']=="") {       
  echo "<script>alert('退水不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}

$exe=mysql_query("update adad set lm='".$_POST['tm']."',lm1='".$_POST['tm1']."'  Where id=1");
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
	
	$dx=$lm;
	
$zds=$lm1;
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



echo "<script>alert('补仓成功!');window.location.href='index.php?action=pz_lm&ids=".$ids."&kithe=".$kithe."';</script>"; 
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
		  var imim=arrResult.length-1;
		   var page=<?=$page?>
		 
		  if (page==0){
		 var im=0
		if (imim>50){ 
		var ie=50}else{ie=imim}
		
}else{
		  var im=50*page
		  
		  if ((imim-im)>50){
		var ie=im+50}else{ie=(imim)}
}
var bb=0
var bbb=1
var mm8=""
 for(var bs=0;bs<arrResult.length-1;bs=bs+50)
{

var mm8=mm8+"<a href=index.php?action=pz_lm&ids=<?=$ids?>&kithe=<?=$kithe?>&page="+bb+"><strong>第"+bbb+"页</strong></a>&nbsp;&nbsp;&nbsp;"
bb++
bbb++
}
var mm8="共"+(bbb-1)+"页&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当前是第<?=$page+1?>页&nbsp;&nbsp;&nbsp;"+mm8
var bl;
bl="blbl";
document.all[bl].innerHTML= mm8;


		  for(var i=im;i<ie;i++)
{
arrTmp = arrResult[i].split("@@@");




num2 = "<font color="+arrTmp[13]+"><strong><center>"+arrTmp[0]+"</center></strong></font>"; //字段num2的值

if (i==(arrResult.length-2)){
num2="<center><font color=ff6600>总计</font></center>"
num1 = "<center>&nbsp;</center>";
}else{
num1 = "<center>"+(i+1)+"</center>"; //字段num1的值
}

num3 = "<center>"+arrTmp[1]+"</center>"; //字段num1的值
if (i!=(arrResult.length-2)){
var zmzm1="index.php?action=look&kithe=<?=$kithe?>&class2=<?=$ids?>&lx=0&id=8&class3="+arrTmp[12];
num4 = "<center><button class=headtd4  onmouseover=this.className='headtd3';window.status='生肖'; return true; onMouseOut=this.className='headtd4';window.status='生肖';return true;  onClick=ops('"+zmzm1+"',400,700)>"+arrTmp[2]+"</button></center>"; //字段num2的值
}else{num4 = "<center>"+arrTmp[2]+"</center>";
}
num5 = "<center>"+arrTmp[3]+"</center>"; //字段num1的值
num6 = "<center>"+arrTmp[4]+"</center>"; //字段num2的值
num7 = "<center>"+arrTmp[5]+"</center>"; //字段num1的值
num8 = "<center>"+arrTmp[6]+"</center>"; //字段num2的值
num9 = "<center>"+arrTmp[7]+"</center>"; //字段num2的值
num10 = "<center>"+arrTmp[8]+"</center>"; //字段num1的值

if (arrTmp[9]!="0" && i!=(arrResult.length-2)){

var zmzm2="index.php?action=look&lx=1&kithe=<?=$kithe?>&class2=<?=$ids?>&id=8&class3="+arrTmp[12];
num11 = "<center><button class=headtd4  onmouseover=this.className='headtd3';window.status='生肖'; return true; onMouseOut=this.className='headtd4';window.status='生肖';return true;  onClick=ops('"+zmzm2+"',400,700)>"+arrTmp[9]+"</button></center>"; //字段num2的值
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

function UpdateRate(commandName,inputID,cellID,strPara)
{
	//功能：将strPara参数串发送给rake_update页面，并将返回结果回传
	//传入参数：	inputID,cellID:要显示返回数据的页面控件名
	//		strPara，包含发送给rake_update页面的参数
	//class1:类别1
	//ids:(即class2)标记特码为特A或特B；qtqt:调整幅度；lxlx调整方向，1为加，否则为减
	//class3:调整的类别
	switch(commandName)
	{
		case "MODIFYRATE":	//更新赔率
			{
				var strResult = sendCommand(commandName,"rake_update.php",strPara);
				
				if (strResult!="")
				{
					//makeRequest('index.php?action=server&class1=特码&class2=特A')
	 makeRequest('index.php?action=server_lm&class1=连码&class2=<?=$ids?>&class3=<?=$c1?>&kithe=<?=$kithe?>')
					document.all[inputID].value=parseFloat(strResult).toFixed(2);
					
				}
				break;
			}
		case "LOCK":		//关闭项目
			{


				var strResult=sendCommand(commandName,"rake_update.php",strPara);
				

				if (strResult!="")
				
				{
					if(strResult=='1')					
						document.all[inputID].checked=true;
					else
						document.all[inputID].checked=false;
				}else{
				
				
					document.all[inputID].checked=!document.all[inputID].checked;
				}
				break;
			}
		default:	//其它情况
	}
}
function sendCommand(commandName,pageURL,strPara)
{
	//功能：向pageURL页面发送数据，参数为strPara
	//并回传服务器返回的数据
	var oBao = new ActiveXObject("Microsoft.XMLHTTP");
	//特殊字符：+,%,&,=,?等的传输解决办法.字符串先用escape编码的.
	oBao.open("GET",pageURL+"?commandName="+commandName+"&"+strPara,false);
	oBao.send();
	//服务器端处理返回的是经过escape编码的字符串.
	var strResult = unescape(oBao.responseText);
	return strResult;
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
        <td width="170" nowrap>[<?=$ids?>]统计[<?=$kithe?>期]</td>
        <td width="63" align="right" nowrap>选择期数： </td>
        <td width="36" nowrap><SELECT class=zaselect_ste name=temppid onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}">
          <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=index.php?action=pz_lm&ids=".$ids."&kithe=".$image['nn'];
				 if ($kithe!="") {
				 if ($kithe==$image['nn']) {
				  echo " selected=selected ";
				  }				
				}
				 echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
        </SELECT></td>
        <form name=form55 action="index.php?action=pz_lm&zsave=zsave&kithe=<?=$kithe?>&ids=<?=$ids?>" method=post>
          <td width="64" align="right" nowrap>最大亏损：</td>
          <td width="62"><span class="STYLE2">
            <input name="tm" class="input1" id="tm" value='<?=$dx?>' size="10" />
          </span></td>
          <td width="42" align="right" nowrap>退水：</td>
          <td width="32"><input name="tm1" class="input1" type="text" id="tm1" value="<?=$lm1?>" size="5"></td>
          <td width="81"><button onClick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button></td>
        </form>
        <td width="494"><div align="right">
          <input name="lm" type="hidden" id="lm" value="0">
          <button onClick="javascript:location.href='index.php?action=pz_lm&ids=三全中&kithe=<?=$kithe?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<?=$z1color?>;'>三全中</span></button>
          <button onClick="javascript:location.href='index.php?action=pz_lm&ids=三中二&kithe=<?=$kithe?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z2color?>;'>三中二</span></button>
          <button onClick="javascript:location.href='index.php?action=pz_lm&ids=二全中&kithe=<?=$kithe?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z3color?>;'>二全中</span></button>
          <button onClick="javascript:location.href='index.php?action=pz_lm&ids=二中特&kithe=<?=$kithe?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z4color?>;'>二中特</span></button>
          <button onClick="javascript:location.href='index.php?action=pz_lm&ids=特串&kithe=<?=$kithe?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z5color?>;'>特串</span></button>
          <button onClick="javascript:location.href='index.php?action=pz_lm&ids=四中一&kithe=<?=$kithe?>';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm2 STYLE='color:<?=$z6color?>;'>四中一</span></button>
        </div></td>
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
 <form action="index.php?action=pz_lm&save=save&ids=<?=$ids?>&kithe=<?=$kithe?>"    method="post" name="form1" > <?
include("d1.php");
?>
</form>
</div>
<table width="99%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1">
  <tr>
    <td height="25" align="right" bordercolor="cccccc" bgcolor="#FDF4CA">
	
	<span id=blbl></span></td>
  </tr>
</table>
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
 makeRequest('index.php?action=server_lm&class1=连码&class2=<?=$ids?>&class3=<?=$c1?>&kithe=<?=$kithe?>')</script>
