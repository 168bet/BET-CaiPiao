<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #0077cc;
}
body,td,th {
	font-size: 12px;
	color: #494949;
}
a:link {
	text-decoration: none;
	color: #494949;
}
a:visited {
	text-decoration: none;
	color: #494949;
}
a:hover {
	text-decoration: underline;
	color: #494949;
}
a:active {
	text-decoration: none;
}
-->
</style>
<? 
if ($_GET['fen']=="fen"){
$locked=$_GET['fid'];

if ($_GET['ids']=="特码"){
if ($locked==0){
$sql="Update ka_kithe Set kitm=0 where id=$Current_KitheTable[0]";
}else{
$sql="Update ka_kithe Set kitm=1,zfb=1 where id=$Current_KitheTable[0]";
}
$exe=mysql_query($sql) or die ($sql);

}

if ($_GET['ids']=="正码"){
if ($locked==0){
$sql="Update ka_kithe Set kizt=0,kizm=0,kizm6=0,kigg=0,kiws=0,kilm=0,kisx=0,kibb=0 where id=$Current_KitheTable[0]";
}else{
$sql="Update ka_kithe Set kizt=1,kizm=1,kizm6=1,kigg=1,kiws=1,kilm=1,kisx=1,kibb=1,zfb=1 where id=$Current_KitheTable[0]";
}
$exe=mysql_query($sql) or die ($sql);
}
}
?>
<script language="JavaScript">
 function rl_rl1(bb){
rl1.style.color="494949"
rl2.style.color="494949"
rl3.style.color="494949"
rl4.style.color="494949"
rl5.style.color="494949"
rl6.style.color="494949"
rl7.style.color="494949"
rl8.style.color="494949"
rl9.style.color="494949"
rl10.style.color="494949"
rl11.style.color="494949"
rl12.style.color="494949"
rl13.style.color="494949"
rl14.style.color="494949"
rl15.style.color="494949"
rl16.style.color="494949"


bb.style.color="ff0000"	
} </script>
<body scroll="no" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="164" height="74" valign="top"><img src="images/top_01.gif" width="164" height="74"></td>
    <td background="images/top_02.gif"><table width="100%" height="74" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="44" valign="middle" nowrap><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="523" height="30" align="right"><strong><font color="#0000FF">服务器时间:</font></strong><font color="#FF0000"><strong><?=date("Y-m-d")?> <span id="span_dt_dt1"></span></strong></font>&nbsp;&nbsp&nbsp;<SCRIPT language=javascript> 
function show_student163_time(){ 
var xmlHttp = false; 
//获取服务器时间 
try { 
   xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); 
} catch (e) { 
   try { 
     xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
   } catch (e2) { 
     xmlHttp = false; 
   } 
} 
if (!xmlHttp && typeof XMLHttpRequest != 'undefined') { 
   xmlHttp = new XMLHttpRequest(); 
} 
xmlHttp.open("GET", "null.txt", false); 
xmlHttp.setRequestHeader("Range", "bytes=-1"); 
xmlHttp.send(null); 
severtime=new Date(xmlHttp.getResponseHeader("Date")); 

window.setTimeout("show_student163_time()", 1000); 
BirthDay=new Date("<?=date("m-d-Y H:i:s",strtotime($Current_KitheTable[30]))?>");

today=new Date(severtime); 
span_dt_dt1.innerHTML="<?=date("Y-m-d")?>  "+today.toLocaleTimeString(); 
}
//show_student163_time(); 
<?
  $date=getdate();
  echo "var time = new Date(".$date['year'].",".$date['mon'].",".$date['mday'].",".$date['hours'].",".$date['minutes'].",".$date['seconds'].");";
?>

function timeview()
{
  timestr=time.toLocaleString();
  timestr=timestr.match(/.{2}\:{1}.{2}\:{1}.{2}/i);
  document.getElementById("span_dt_dt1").innerHTML = timestr;
  time.setSeconds(time.getSeconds()+1);
  window.setTimeout( "timeview()", 1000 );
}
timeview();
</SCRIPT></td>
              <td width="251" nowrap><div align="right" id="fbl">
                      
               
              </div></td>
              <td width="313" nowrap><input type="button" onClick="parent.parent.bb_mem_index.location.href='/app/agents/chk_login.php'" value="足球博彩管理">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td nowrap><table width="760" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td width="8" align="center"></td>
              <td align="left" nowrap><a href="#" onClick="rl_rl1(rl1);javascript:parent.right.location.href='index.php?action=kithe';"><SPAN id=rl1 STYLE='color:494949;'>盘口管理</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl2);javascript:parent.right.location.href='index.php?action=rake_tm';"><SPAN id=rl2 STYLE='color:494949;'>赔率设置</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl3);javascript:parent.right.location.href='index.php?action=pz_tm';"><SPAN id=rl3 STYLE='color:494949;'>即时注单</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl4);javascript:parent.right.location.href='index.php?action=tm';"><SPAN id=rl4 STYLE='color:494949;'>走飞</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl5);javascript:parent.right.location.href='index.php?action=kaguan';"><SPAN id=rl5 STYLE='color:494949;'>股东</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl6);javascript:parent.right.location.href='index.php?action=kazong';"><SPAN id=rl6 STYLE='color:494949;'>总代理</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl7);javascript:parent.right.location.href='index.php?action=kadan';"><SPAN id=rl7 STYLE='color:494949;'>代理</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl8);javascript:parent.right.location.href='index.php?action=kamem';"><SPAN id=rl8 STYLE='color:494949;'>会员</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl9);javascript:parent.right.location.href='index.php?action=re_pb';"><SPAN id=rl9 STYLE='color:494949;'>报表</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl10);javascript:parent.right.location.href='index.php?action=right';"><SPAN id=rl10 STYLE='color:494949;'>系统维护</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl11);javascript:parent.right.location.href='index.php?action=x1';"><SPAN id=rl11 STYLE='color:494949;'>注单查询</SPAN></a>
<font color=494949>┊</font><a href="#" onClick="rl_rl1(rl16);javascript:parent.right.location.href='index.php?action=l';"><SPAN id=rl16 STYLE='color:494949;'>总底单</SPAN></a>
 <font color=494949>┊</font><div style="display:none"><a href="#" onClick="rl_rl1(rl15);javascript:parent.right.location.href='';"><SPAN id=rl15 STYLE='color:494949;'></SPAN></a><a href="#" onClick="rl_rl1(rl12);javascript:parent.right.location.href='index.php?action=edit';"><SPAN id=rl12 STYLE='color:494949;'>密码</SPAN></a><font color=494949>┊</font><a href="#" onClick="rl_rl1(rl13);javascript:parent.right.location.href='index.php?action=tj';"><SPAN id=rl13 STYLE='color:494949;'>在线</SPAN></a><font color=494949>┊</font></div><a href="#" onClick="rl_rl1(rl14);javascript:top.location.href='index.php?action=logout';"><SPAN id=rl14 STYLE='color:494949;'>退出</SPAN></a></td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script>

function makeRequest(url) {
//alert(url);
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
 setTimeout("makeRequest('"+url+"')",5000);

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
		   


num1 = arrTmp[0]; //字段num1的值
var fbl;
fbl="fbl";
document.all[fbl].innerHTML= num1;




	
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
	//ids:(即class2)标记特码为特A或特B；qtqt:调整幅度；lxlx调整方向，1为加，否则为减
	//class3:调整的类别
	switch(commandName)
	{
		case "MODIFYRATE":	//更新赔率
			{
				var strResult = sendCommand(commandName,"rake_update.php",strPara);
				
				if (strResult!="")
				{
					makeRequest('index.php?action=kaaout')
					document.all[inputID].value=strResult;
					
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
<SCRIPT language=javascript>
 makeRequest('kk.php')</script>
