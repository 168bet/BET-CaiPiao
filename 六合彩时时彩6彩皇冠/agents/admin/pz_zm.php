<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

$ids="正A";

if ($_GET['zsave']=="zsave") {

if ($_POST['tm']=="") {       
  echo "<script>alert('预计亏损不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}
if ($_POST['ttm1']=="") {       
  echo "<script>alert('退水不能为空，请输入数字!');window.history.go(-1);</script>"; 
  exit;
}

$exe=mysql_query("update adad set zm='".$_POST['tm']."',zm1='".$_POST['ttm1']."'  Where id=1");
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
$zds=$zm1;
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



echo "<script>alert('补仓成功!');window.location.href='index.php?action=pz_zm&kithe=".$kithe."';</script>"; 
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
 setTimeout("makeRequest('"+url+"')",<?=$ftime?>);

}


function init() {
 
    if (http_request.readyState == 4) {
   
        if (http_request.status == 0 || http_request.status == 200) {
       
            var result = http_request.responseText;
			
           
            if(result==""){
           
                result = "Access failure ";
           
            }
           
		   var arrResult = result.split("###");	
		   for(var i=0;i<arrResult.length-1;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


num1 = "<font color="+arrTmp[13]+"><strong><center>"+arrTmp[0]+"</center></strong></font>"; //字段num2的值
num2 = arrTmp[10]; //字段num2的值
num3 = arrTmp[2]; //字段num1的值
if (i!=(arrResult.length-2)){
var zmzm1="index.php?action=look&kithe=<?=$kithe?>&lx=0&id=3&class3="+arrTmp[12];
num4 = "<center><button class=headtd4  onmouseover=this.className='headtd3';window.status='正码'; return true; onMouseOut=this.className='headtd4';window.status='正码';return true;  onClick=ops('"+zmzm1+"',400,700)><font color=000000><b>"+arrTmp[3]+"</b></font></button></center>"; //字段num2的值
}else{num4 = "<center>"+arrTmp[2]+"</center>";
}
num5 = "<center>"+arrTmp[3]+"</center>"; //字段num1的值
num8 = "<center>"+arrTmp[6]+"</center>"; //字段num2的值
if (arrTmp[7]<0){
num9 = "<center><font color=ff0000>"+arrTmp[7]+"</font></center>"; //字段num2的值
}else{
num9 = "<center>"+arrTmp[7]+"</center>"; //字段num2的值
}
num10 = "<center>"+arrTmp[8]+"</center>"; //字段num1的值

if (arrTmp[9]!="0" && i!=(arrResult.length-2)){

var zmzm2="index.php?action=look&lx=1&kithe=<?=$kithe?>&id=3&class3="+arrTmp[12];
num11 = "<center><button class=headtd4  onmouseover=this.className='headtd3';window.status='正码'; return true; onMouseOut=this.className='headtd4';window.status='正码';return true;  onClick=ops('"+zmzm2+"',400,700)>"+arrTmp[9]+"</button></center>"; //字段num2的值
}else{
num11 = "<center>"+arrTmp[9]+"</center>"; //字段num2的值
}

if (i<53){
var tm;
tm="tm"+i;
document.all[tm].innerHTML= num1;
var bbl;
bbl="bbl"+i;
document.all[bbl].innerHTML= num2;
var gold;
gold="gold"+i;
document.all[gold].innerHTML= "<font color=ff6600>"+num4+"</font>";

if (i<53){
var yj;
yj="yj"+i;
document.all[yj].innerHTML= num9;
var zf;
zf="zf"+i;
document.all[zf].innerHTML= num10;
var zzf;
zzf="zzf"+i;
document.all[zzf].innerHTML= num11;}

}else{
	
	var zsum;
zsum="zsum";
document.all[zsum].innerHTML= arrTmp[2];

var zasum;
zasum="zasum";
document.all[zasum].innerHTML= arrTmp[3];

var zfsum;
zfsum="zfsum";
document.all[zfsum].innerHTML= arrTmp[9];
	}	




}


		
			
           
        } else {//http_request.status != 200
           
                alert("Request failed! ");
       
        }
   
    }
 
}


function UpdateRate(commandName,inputID,cellID,strPara)
{
	//功能：将strPara参数串发送给rake_update页面，并将返回结果回传
	//传入参数：	inputID,cellID:要显示返回数据的页面控件名
	//		strPara，包含发送给rake_update页面的参数
	//class1:类别1
	//ids:(即class2)标记正码为正A或特B；qtqt:调整幅度；lxlx调整方向，1为加，否则为减
	//class3:调整的类别
	switch(commandName)
	{
	
	
		case "MODIFYRATE":	//更新赔率
			{
				var strResult = sendCommand(commandName,"rake_update.php",strPara);
				
				if (strResult!="")
				{
					//makeRequest('index.php?action=server&class1=正码&class2=正A')
				makeRequest('index.php?action=server_zm&class1=正码&class2=<?=$ids?>&kithe=<?=$kithe?>')
					//document.all[inputID].value=parseFloat(strResult).toFixed(2);
				//alert("ok")
					
				}
				break;
			}
			
			
			case "Mate":	//更新赔率
			{
				var strResult = sendCommand(commandName,"rake_update1.php",strPara);
				
				if (strResult!="")
				{
					//makeRequest('index.php?action=server&class1=正码&class2=')
				makeRequest('index.php?action=server_zm&class1=正码&class2=<?=$ids?>&kithe=<?=$kithe?>')
					//document.all[inputID].value=parseFloat(strResult).toFixed(2);
				//alert("ok")
					
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
.STYLE3 {	color: #FF0000;
	font-weight: bold;
}
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
        <td width="150" nowrap>正码统计[<?=$kithe?>期]</td>
        <td width="10" align="right" nowrap>&nbsp;</td>
        <td width="69" align="right" nowrap>选择期数： </td>
        <td width="36" nowrap><SELECT class=zaselect_ste name=temppid onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}">
          <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=index.php?action=pz_zm&kithe=".$image['nn'];
				 if ($kithe!="") {
				 if ($kithe==$image['nn']) {
				  echo " selected=selected ";
				  }				
				}
				 echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
        </SELECT></td>
        <form name=form55 action="index.php?action=pz_zm&zsave=zsave&kithe=<?=$kithe?>" method=post>
          <td width="77" align="right" nowrap>风险值：</td>
          <td width="62"><span class="STYLE2">
            <input name="tm" class="input1" id="tm" value='<?=$zm?>' size="10" />
          </span></td>
          <td width="45" align="right" nowrap>退水：</td>
          <td width="53"><input name="ttm1" class="input1" type="text" id="ttm1" value="<?=$zm1?>" size="5"></td>
          <td width="89"><button onClick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />走飞计算</button></td>
        </form>
        <td width="480"><input name="lm" type="hidden" id="lm" value="0"></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="99%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="f1f1f1">
  <tr>
    <td width="10%" height="25" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=all');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=all');"><font color="#0000FF">↓</font></a>全部<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=all');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=all');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FFF0F5"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=单');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=单');"><font color="#0000FF">↓</font></a>单<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=单');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=单');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FFF0F5"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=双');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=双');"><font color="#0000FF">↓</font></a>双<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=双');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=双');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FFF0F5"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=大');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=大');"><font color="#0000FF">↓</font></a>大<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=大');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=大');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FFF0F5"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=小');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=小');"><font color="#0000FF">↓</font></a>小<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=小');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=小');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FFD0D0"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=红');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=红');"><font color="#0000FF">↓</font></a>红<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=红');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=红');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#D9D9FF"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=蓝');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=蓝');"><font color="#0000FF">↓</font></a>蓝<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=蓝');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=蓝');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#ECFFEC"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=绿');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=绿');"><font color="#0000FF">↓</font></a>绿<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=绿');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=绿');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=合单');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=合单');"><font color="#0000FF">↓</font></a>合单<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=合单');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=合单');"><font color="#ff0000">+</font></a></td>
    <td width="10%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA"><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.5&amp;class3=合双');"><font color="#0000FF">-</font></a><a href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=0&amp;qtqt=0.1&amp;class3=合双');"><font color="#0000FF">↓</font></a>合双<A href="#" onClick="UpdateRate('Mate','lm','bl8','class1=正码&ids=正A&sqq=sqq&lxlx=1&qtqt=0.1&class3=合双');"><font color="#ff0000">↑</font><a href="#" onclick="UpdateRate('Mate','lm','bl8','class1=正码&amp;ids=正A&amp;sqq=sqq&amp;lxlx=1&amp;qtqt=0.5&amp;class3=合双');"><font color="#ff0000">+</font></a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>
<table   width="99%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="f1f1f1" bgcolor="cccccc" >
  <tr >
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">已补 </td>
    <td rowspan="14" align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">已补</td>
    <td rowspan="14" align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">已补</td>
    <td rowspan="14" align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
    <td width="30" height="28" align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">已补</td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm0></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl0>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold0>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj0>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf0>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf0>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm13></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl13>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold13>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj13>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf13>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf13>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm26></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl26>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold26>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj26>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf26>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf26>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm39></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl39>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold39>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj39>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf39>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf39>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm1></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl1>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold1>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj1>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf1>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf1>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm14></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl14>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold14>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj14>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf14>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf14>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm27></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl27>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold27>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj27>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf27>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf27>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm40></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl40>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold40>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj40>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf40>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf40>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm2></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl2>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold2>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj2>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf2>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf2>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm15></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl15>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold15>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj15>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf15>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf15>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm28></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl28>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold28>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj28>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf28>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf28>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm41></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl41>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold41>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj41>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf41>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf41>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm3></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl3>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold3>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj3>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf3>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf3>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm16></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl16>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold16>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj16>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf16>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf16>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm29></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl29>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold29>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj29>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf29>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf29>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm42></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl42>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold42>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj42>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf42>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf42>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm4></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl4>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold4>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj4>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf4>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf4>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm17></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl17>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold17>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj17>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf17>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf17>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm30></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl30>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold30>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj30>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf30>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf30>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm43></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl43>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold43>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj43>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf43>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf43>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm5></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl5>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold5>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj5>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf5>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf5>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm18></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl18>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold18>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj18>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf18>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf18>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm31></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl31>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold31>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj31>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf31>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf31>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm44></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl44>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold44>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj44>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf44>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf44>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm6></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl6>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold6>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj6>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf6>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf6>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm19></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl19>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold19>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj19>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf19>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf19>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm32></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl32>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold32>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj32>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf32>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf32>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm45></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl45>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold45>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj45>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf45>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf45>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm7></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl7>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold7>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj7>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf7>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf7>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm20></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl20>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold20>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj20>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf20>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf20>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm33></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl33>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold33>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj33>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf33>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf33>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm46></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl46>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold46>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj46>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf46>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf46>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm8></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl8>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold8>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj8>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf8>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf8>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm21></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl21>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold21>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj21>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf21>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf21>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm34></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl34>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold34>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj34>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf34>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf34>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm47></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl47>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold47>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj47>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf47>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf47>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm9></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl9>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold9>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj9>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf9>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf9>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm22></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl22>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold22>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj22>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf22>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf22>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm35></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl35>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold35>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj35>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf35>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf35>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm48></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl48>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold48>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj48>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf48>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf48>0</span></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm10></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl10>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold10>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj10>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf10>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf10>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm23></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl23>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold23>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj23>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf23>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf23>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm36></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl36>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold36>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj36>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf36>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf36>0</span></td>
    <td colspan="6" bgcolor="#FEFBED"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40%" align="right"><span class="STYLE3">下注总额:</span></td>
        <td width="60%"><strong><span id=zsum></span></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm11></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl11>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold11>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj11>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf11>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf11>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm24></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl24>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold24>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj24>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf24>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf24>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm37></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl37>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold37>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj37>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf37>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf37>0</span></td>
    <td colspan="6" bgcolor="#FEFBED"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40%" align="right"><span class="STYLE3">占成总额:</span></td>
        <td width="60%"><strong><span id=zasum></span></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1"  ><span id=tm12></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl12>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold12>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj12>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf12>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf12>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FEFBED"  class="ballf_ff"><span id=tm25></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=bbl25>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=gold25>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=yj25>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zf25>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFFFFF"><span id=zzf25>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="#FFF4E1"  class="ballf_ff"><span id=tm38></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=bbl38>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold38>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj38>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf38>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf38>0</span></td>
    <td colspan="6" bgcolor="#FEFBED"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40%" align="right"><span class="STYLE3">走飞总额:</span></td>
        <td width="60%"><strong><span id=zfsum></span></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td align="center" height="28" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" >赔率</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">已补</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">已补</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">号码</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">赔率</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">总额</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">走飞</td>
    <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA">已补</td>
    <td align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td>
    <td align="center" bgcolor="#FDF4CA">号码</td>
    <td align="center" bgcolor="#FDF4CA">赔率</td>
    <td align="center" bgcolor="#FDF4CA">总额</td>
    <td align="center" bgcolor="#FDF4CA">预计盈利</td>
    <td align="center" bgcolor="#FDF4CA">走飞</td>
    <td align="center" bgcolor="#FDF4CA">已补</td>
  </tr>
  <tr >
  <?  for ($I=1; $I<=4; $I=$I+1){?>
    <td align="center" bordercolor="cccccc" class="ballf_ff" bgcolor="#FFF4E1" style="font-size:12px"  ><span id=tm<?=($I+49-1)?>></span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff" ><span id=bbl<?=($I+49-1)?>>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=gold<?=($I+49-1)?>>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=yj<?=($I+49-1)?>>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zf<?=($I+49-1)?>>0</span></td>
    <td align="center" bordercolor="cccccc" bgcolor="ffffff"><span id=zzf<?=($I+49-1)?>>0</span></td>
    <? if ($I!=4){?><td align="center" nowrap bordercolor="cccccc" bgcolor="ffffff">&nbsp;</td><? }?>
	<? }?>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10"></td>
  </tr>
</table>
<DIV id=rs_window style="DISPLAY: none; POSITION: absolute">
 <form action="index.php?action=pz_zm&save=save&ids=<?=$ids?>&kithe=<?=$kithe?>"    method="post" name="form1" > <?
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

document.all["r_title"].innerHTML = '<font color="#ffffff"><b>['+ id +'码] 请设定</b></font>';
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
 makeRequest('index.php?action=server_zm&class1=正码&class2=<?=$ids?>&kithe=<?=$kithe?>')</script>
