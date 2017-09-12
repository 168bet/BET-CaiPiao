<? if(!defined('PHPYOU')) {
	exit('非法进入');
}


if ($_GET['save']=="save") {

$exe=mysql_query("Update config Set a1='".$_POST['a1']."',a3='".$_POST['a3']."' where id=1");

print "<script language='javascript'>alert('修改成功！');window.location.href='index.php?action=sm';</script>";
exit();
}?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style><noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<body >

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10"></td>
  </tr>
</table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>
<table   border="1" align="center" cellspacing="1" cellpadding="2" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="95%">
   <form name=form1 action=index.php?action=sm&save=save method=post> <tr >
      <td width="26%" height="28" bordercolor="cccccc" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><font color=ff0000 size="3"><B>即时开奖</B></font></td>
    <td ><font color=ffffff></font></td>
  </tr>
</table></td>
      </tr>
     <tr >
       <td height="28" bordercolor="cccccc" bgcolor="#FFFFFF"><table width="600" border="0" cellpadding="2" cellspacing="1" bordercolor="#cccccc">
         <tr>
           <td height="100" align="center" bgcolor="#FFFFFF"><TABLE cellSpacing=2 cellPadding=0 border=0>
               <TBODY>
                 <TR>
                   <TD width= 
          150 height=27 align=middle nowrap ><span id=gold0>0</span></TD>
                   <TD class=ball_td align=middle width=32 height=27><span id=gold1>0</span></TD>
                   <TD class=ball_td align=middle width=32 height=27><span id=gold2>0</span></TD>
                   <TD class=ball_td align=middle width=32 height=27><span id=gold3>0</span></TD>
                   <TD class=ball_td align=middle width=32 height=27><span id=gold4>0</span></TD>
                   <TD class=ball_td align=middle width=32 height=27><span id=gold5>0</span></TD>
                   <TD class=ball_td align=middle width=32 height=27><span id=gold6>0</span></TD>
                   <TD class=ball_td align=middle width=25 
         height=27><img src='images/q1.gif' /></TD>
                   <TD class=ball_td align=middle width=32 
        height=27><span id=gold7>0</span></TD>
                 </TR>
               </TBODY>
           </TABLE></td>
         </tr>
       </table></td>
     </tr>
  </form >
</table>
  <br>

<script>
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

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
 setTimeout("makeRequest('"+url+"')",2000);

}


function init() {
 
    if (http_request.readyState == 4) {
   
        if (http_request.status == 0 || http_request.status == 200) {
       
            var result = http_request.responseText;
			
           
            if(result==""){
           
                result = "Access failure ";
           
            }
           
		   var arrResult = result.split("###");	
		   for(var i=0;i<1;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


for(var b=0;b<8;b++){
var gold;
gold="gold"+b;
document.all[gold].innerHTML= arrTmp[b];}




}
			
			
           
        } else {//http_request.status != 200
           
                alert("Request failed! ");
       
        }
   
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
<SCRIPT language=javascript>
 makeRequest('index.php?action=serverf&style=<?=$_GET['style'];?>')
 </script>
