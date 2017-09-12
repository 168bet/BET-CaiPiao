<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}
$ids="正码1-6";

if ($_GET['act']=="修改") {
for ($tt=1; $tt<=78; $tt++) {
if (empty($_POST['Num_'.$tt])) {       
  echo "<script>alert('赔率不能为空:".$_POST['Num_'.$tt]."/".$tt."!');window.history.go(-1);</script>"; 
  exit;
}

 }
 
 
 for ($tt=1; $tt<=78; $tt++) {
 
 $num=$_POST['Num_'.$tt];
 

  
 $num1=$num+ka_config(3);
 $num2=$num-ka_config(3);
 
  $num3=$num+ka_config(4);
 $num4=$num-ka_config(4);
  $num5=$num+ka_config(5);
 $num6=$num-ka_config(5);
 
 $class3=$_POST['class3_'.$tt];
  $class2=$_POST['class2_'.$tt];
 
  $text=date("Y-m-d H:i:s");
$exe=mysql_query("update ka_bl  set adddate='". $text."',rate=".$num." where class1='正1-6' and class2='".$class2."' and  class3='".$class3."'");

 
 

 }//for
 
 
echo "<script>alert('修改成功!');window.location.href='index.php?action=rake_zm6&ids=".$ids."';</script>"; 
exit;
	
}//结速


$result=mysql_query("Select rate,class3,class2,locked from ka_bl where class1='正1-6'   Order By class2,ID");
$ShowTable = array();
$y=0;
while($Image = mysql_fetch_array($result)){
$y++;
array_push($ShowTable,$Image);

}

$drop_count=$y-1;

?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>

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
           
		   var arrResult = result.split("###");	//alert(arrResult);
		   for(var i=0;i<78;i++)
{	   
		   arrTmp = arrResult[i].split("@@@");
		   


num1 = arrTmp[0]; //字段num1的值
num2 = arrTmp[1]; //字段num2的值
num3 = arrTmp[2]; //字段num1的值
num4 = arrTmp[3]; //字段num2的值
var bl,num;
bl="bl"+i;
num="Num_"+(i+1);
document.all[num].value=num2;//parseFloat(num2).toFixed(2);
document.all[bl].innerHTML=num2;//parseFloat(num2).toFixed(2);

var gold;
gold="gold"+i;
document.all[gold].innerHTML= "<font color=ff6600>"+num4+"</font>";
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
					makeRequest('index.php?action=server&class1=正1-6&class2=<?=$ids?>')
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

<SCRIPT language=javascript>


function adv_format(value,num) //四舍五入
{
var a_str = formatnumber(value,num);
var a_int = parseFloat(a_str);
if (value.toString().length>a_str.length)
{
var b_str = value.toString().substring(a_str.length,a_str.length+1)
var b_int = parseFloat(b_str);
if (b_int<5)
{
return a_str
}
else
{
var bonus_str,bonus_int;
if (num==0)
{
bonus_int = 1;
}
else
{
bonus_str = "0."
for (var i=1; i<num; i++)
bonus_str+="0";
bonus_str+="1";
bonus_int = parseFloat(bonus_str);
}
a_str = formatnumber(a_int + bonus_int, num)
}
}
return a_str
}

function formatnumber(value,num) //直接去尾
{
var a,b,c,i

a = value.toString();
b = a.indexOf('.');
c = a.length;
if (num==0)
{
if (b!=-1)
a = a.substring(0,b);
}
else
{
if (b==-1)
{
a = a + ".";
for (i=1;i<=num-1;i++)
a = a + "0";
}
else
{
a = a.substring(0,b+num+1);
for (i=c;i<=b+num-1;i++)
a = a + "0";
}
}
return a
}

var ball_color = Array(0,0,1,1,2,2,0,0,1,1,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,1,1,2,2,0,0,1,1,2);
var bcolor = Array('red','blue','green');

function sel_col_ball(color)
{
	var c;
	var str1
	var zmzm
	var zmn=0.5
	var zmnn=0.01
	switch(color) {
		case 'blue':
			c = 1;
			break;
		case 'red':
			c = 0;
			break;
		case 'green':
			c = 2;
			break;
		case 'alal':
			c = 4;
			break;
		case 'all':
			c = 5;
			break;
		default:
			return;
			break;
	}
	
	
	
	if (c==4 ){
		
		
		var m=0
	for(i=0; i<78 ;i++)
	{
				
		m++
		
	
		
			str1="Num_"+m;
			var t_big = new Number(document.all[str1].value);
t_big*=10000;
t_big+=10000*zmnn;
t_big/=10000;
document.all[str1].value=adv_format(t_big,2);

		
			
			
		
}
	
	
	}else{
	
	var m=0
	for(i=0; i<78 ;i++)
	{
				
		m++
		
	
		
			str1="Num_"+m;
			var t_big = new Number(document.all[str1].value);
t_big*=10000;
t_big+=10000*zmnn;
t_big/=10000;
document.all[str1].value=adv_format(t_big,2);

		
			
			
		
}
		
		
		
		
	}
}


function sel_col_ball1(color,sj)
{
	var c;
	var str1
	var zmzm
	var zmn=0.5
	var zmnn=0.01
	switch(color) {
		case 'blue':
			c = 1;
			break;
		case 'red':
			c = 0;
			break;
		case 'green':
			c = 2;
			break;
		case 'alal':
			c = 4;
			break;
		case 'all':
			c = 5;
			break;
		default:
			return;
			break;
	}
	
	
	
	if (c==4 ){var m=0
	for(i=0; i<78 ;i++)
	{
				
		m++
		
	
		
			str1="Num_"+m;
			var t_big = new Number(document.all[str1].value);
t_big*=10000;
t_big-=10000*zmnn;
t_big/=10000;
document.all[str1].value=adv_format(t_big,2);

		
			
			
		
}
 



		
		
		//// document.all.t_double.value=eval(document.all.t_double.value+"-"+zmnn);
		 ///document.all.t_big.value=eval(document.all.t_big.value+"-"+zmnn);
		 ///document.all.t_small.value=eval(document.all.t_small.value+"-"+zmnn);
		/// document.all.h_signle.value=eval(document.all.h_signle.value+"-"+zmnn);
		//document.all.h_double.value=eval(document.all.h_double.value+"-"+zmnn);
	
	
	}else{
	
	var m=0
	for(i=0; i<49 ;i++)
	{
				
		m++
		
	
			if (ball_color[i] == c)
		{
			
			str1="Num_"+m;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"-"+sj);
			
			 document.all[str1].value =zmzm ;
			
			
		}
}
		
		
		
		
	}
}



function j_soj(a,b,c)
{






if (c==1 ){



var t_big = new Number(document.all[a].value);
t_big*=100;
t_big+=100*b;
t_big/=100;
document.all[a].value=adv_format(t_big,2);

	
	
	}else{
	
var t_big = new Number(document.all[a].value);
//t_big*=100;
t_big-=b;
//t_big/=100;
document.all[a].value=adv_format(t_big,2);
	
	
	}


}




function j_dx(b,c,sj)
{

var zmn=0.5;


switch(b) {
		case '1':
			
			s=25;
			e=50;
			break;
		case '2':
		
		
		s=1;
		e=25;
			break;
		
			
			
		case '20':
			d = 20;
			break;
		default:
			return;
			break;
	}
	

if (c==1 ){


	for(i=s; i<e ;i++)
	{			
		
		
			
			str1="Num_"+i;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"+"+sj);
			
			 document.all[str1].value =zmzm ;
			
			
		
}



	
	
	}else{
	
for(i=s; i<e ;i++)
	{			
		
		
			
			str1="Num_"+i;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"-"+sj);
			
			 document.all[str1].value =zmzm ;		
		
		
}

	
	}


}


function j_ds(b,c,sj)
{

var zmn=0.5;


switch(b) {
		case '1':
			
			
			var e=1;
			break;
		case '2':
		
			
		e=0;
		
			break;
		
			
			
		case '20':
			d = 20;
			break;
		default:
			return;
			break;
	}
	m=0

if (c==1 ){


for(i=0; i<49 ;i++)
	{
	m++
	if ((i+1) % 2 == e)
	{			
		
		
			
			str1="Num_"+m;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"+"+sj);
			
			 document.all[str1].value =zmzm ;
			
			
		
}

}

	
	
	}else{
	m=0

for(i=0; i<49 ;i++)
	{m++
	if ((i+1) % 2 == e)
	{			
		
		
			
			str1="Num_"+m;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"-"+sj);
			
			 document.all[str1].value =zmzm ;
			
			
		
}

}

	
	}


}


function j_dsx(b,c,sj)
{

var zmn=0.5;


switch(b) {
		case '1':
			s=25;
			f=50;
			e=1;
			break;
		case '2':
		
		s=25;
		f=50;
		
		e=0;
			break;
			
	case '3':
			s=1;
			f=25;
			e=1;
			break;
		case '4':
		
		s=1;
		f=25;
		
		e=0;
			break;
		
		
			
			
		case '20':
			d = 20;
			break;
		default:
			return;
			break;
	}
	

if (c==1 ){


for(i=s; i<f ;i++)
	{
	
	if ((i+1) % 2 == e)
	{			
		
		
			
			str1="Num_"+i;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"+"+sj);
			
			 document.all[str1].value =zmzm ;
			
			
		
}

}

	
	
	}else{
	
m=0
for(i=s; i<f ;i++)
	{
	
	if ((i+1) % 2 == e)
	{			
		
		
			
			str1="Num_"+i;
		zmzm=document.all[str1].value;
			zmzm=eval(zmzm+"-"+sj);
			
			 document.all[str1].value =zmzm ;
			
			
		
}

}

	
	}


}








</SCRIPT>
<body  oncontextmenu="return false"   onselect="document.selection.empty()" oncopy="document.selection.empty()" 
>
<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>

<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
 
       <table width="100%" border="0" cellspacing="0" cellpadding="5">
         <tr class="tbtitle">
           <td width="100%"><? require_once 'retop.php';?></td>
         </tr>
         <tr >
           <td height="5" colspan="2"></td>
         </tr>
       </table>
       
        
          <table   border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
		
		<form name="form1" method="post" action="index.php?action=rake_zm6&act=修改&ids=<?=$ids?>"> <?
		 
		 for ($B=1; $B<=2; $B=$B+1)
{
		 //for b=1 to 2
		 if ($B==1) {
		 
		 
		 ?> 
            <tr >
              <td height="28" colspan="4" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D">正码1</td>
              <td height="28" colspan="4" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D">正码2</td>
              <td height="28" colspan="4" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D">正码3</td>
            </tr>
            <tr >
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 下注总额</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 下注总额</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 下注总额</td>
            </tr>
            <? for ($I=1; $I<=13; $I=$I+1)
{?>
            <tr>
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I-1][1]?>
			  <input name="class2_<?=$I?>" value="<?=$ShowTable[$I-1][2]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I-1][0]?>" name="Num_<?=$I?>" /></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I?>','','class1=正1-6&ids=<?=$ShowTable[$I-1][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I-1][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
                    </tr>
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I?>','','class1=正1-6&ids=<?=$ShowTable[$I-1][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I-1][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
                    </tr>
                  </table></td>
                  <td><input type=checkbox id=lock<?=$I?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I?>','','class1=正1-6&ids=<?=$ShowTable[$I-1][2]?>&sqq=sqq&class3=<?=$ShowTable[$I-1][1]?>&lock='+this.checked);"  <? if ($ShowTable[$I-1][3]==1){echo "checked";}?>></td>
                </tr>
              </table>
              <input name="class3_<?=$I?>" value="<?=$ShowTable[$I-1][1]?>" type="hidden" >			  </td>
              <td height="25" align="center" bordercolor="cccccc"><span id=bl<?=($I-1)?>><?=$ShowTable[$I-1][0]?></span></td>
              <td width="4%" align="center" bordercolor="cccccc"><span id=gold<?=($I-1)?>>0</span></td>
			  
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+13-1][1]?>
			  <input name="class2_<?=$I+13?>" value="<?=$ShowTable[$I+13-1][2]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+13-1][0]?>" name="Num_<?=$I+13?>" /></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+13?>','','class1=正1-6&ids=<?=$ShowTable[$I+13-1][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I+13-1][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
                    </tr>
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+13?>','','class1=正1-6&ids=<?=$ShowTable[$I+13-1][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I+13-1][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
                    </tr>
                  </table></td>
                  <td><input type=checkbox id=lock<?=$I+13?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I+13?>','','class1=正1-6&ids=<?=$ShowTable[$I+13-1][2]?>&sqq=sqq&class3=<?=$ShowTable[$I+13-1][1]?>&lock='+this.checked);"  <? if ($ShowTable[$I+13-1][3]==1){echo "checked";}?>></td>
                </tr>
              </table>
              <input name="class3_<?=$I+13?>" value="<?=$ShowTable[$I+13-1][1]?>" type="hidden" >			  </td>
              <td height="25" align="center" bordercolor="cccccc"><span id=bl<?=$I+13-1?>><?=$ShowTable[$I+13-1][0]?></span></td>
              <td width="4%" align="center" bordercolor="cccccc"><span id=gold<?=$I+13-1?>>0</span></td>
              
			  <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+26-1][1]?>
		      <input name="class2_<?=$I+26?>" value="<?=$ShowTable[$I+26-1][2]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+26-1][0]?>" name="Num_<?=$I+26?>" /></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+26?>','','class1=正1-6&ids=<?=$ShowTable[$I+26-1][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I+26-1][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
                    </tr>
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+26?>','','class1=正1-6&ids=<?=$ShowTable[$I+26-1][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I+26-1][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
                    </tr>
                  </table></td>
                  <td><input type=checkbox id=lock<?=$I+26?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I+26?>','','class1=正1-6&ids=<?=$ShowTable[$I+26-1][2]?>&sqq=sqq&class3=<?=$ShowTable[$I+26-1][1]?>&lock='+this.checked);"  <? if ($ShowTable[$I+26-1][3]==1){echo "checked";}?>></td>
                </tr>
              </table>
              <input name="class3_<?=$I+26?>" value="<?=$ShowTable[$I+26-1][1]?>" type="hidden" >	  </td>
              <td height="25" align="center" bordercolor="cccccc"><span id=bl<?=$I+26-1?>><?=$ShowTable[$I+26-1][0]?></span></td>
              <td width="4%" align="center" bordercolor="cccccc"><span id=gold<?=$I+26-1?>>0</span></td>
            </tr>
            <? }
			}else{?>
			
			
			 <tr >
              <td height="28" colspan="4" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D">正码4</td>
              <td height="28" colspan="4" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D">正码5</td>
              <td height="28" colspan="4" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FE773D">正码6</td>
            </tr>
            <tr >
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 下注总额</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 下注总额</td>
              <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 号码</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">当前赔率</td>
              <td width="4%" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA"> 下注总额</td>
            </tr>
            <? for ($I=1; $I<=13; $I=$I+1)
{?>
            <tr>
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+39-1][1]?>
			  <input name="class2_<?=$I+39?>" value="<?=$ShowTable[$I+39-1][2]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+39-1][0]?>" name="Num_<?=$I+39?>" /></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+39?>','','class1=正1-6&ids=<?=$ShowTable[$I+39-1][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I+39-1][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
                    </tr>
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+39?>','','class1=正1-6&ids=<?=$ShowTable[$I+39-1][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I+39-1][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
                    </tr>
                  </table></td>
                  <td><input type=checkbox id=lock<?=$I+39?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I+39?>','','class1=正1-6&ids=<?=$ShowTable[$I+39-1][2]?>&sqq=sqq&class3=<?=$ShowTable[$I+39-1][1]?>&lock='+this.checked);"  <? if ($ShowTable[$I+39-1][3]==1){echo "checked";}?>></td>
                </tr>
              </table>
              <input name="class3_<?=$I+39?>" value="<?=$ShowTable[$I+39-1][1]?>" type="hidden" >	  
			  
			  
			  </td>
              <td height="25" align="center" bordercolor="cccccc"><span id=bl<?=$I+39-1?>><?=$ShowTable[$I+39-1][0]?></span></td>
              <td width="4%" align="center" bordercolor="cccccc"><span id=gold<?=$I+39-1?>>0</span></td>
			  
              <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+52-1][1]?>
			  <input name="class2_<?=$I+52?>" value="<?=$ShowTable[$I+52-1][2]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+52-1][0]?>" name="Num_<?=$I+52?>" /></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+52?>','','class1=正1-6&ids=<?=$ShowTable[$I+52-1][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I+52-1][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
                    </tr>
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+52?>','','class1=正1-6&ids=<?=$ShowTable[$I+52-1][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I+52-1][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
                    </tr>
                  </table></td>
                  <td><input type=checkbox id=lock<?=$I+52?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I+52?>','','class1=正1-6&ids=<?=$ShowTable[$I+52-1][2]?>&sqq=sqq&class3=<?=$ShowTable[$I+52-1][1]?>&lock='+this.checked);"  <? if ($ShowTable[$I+52-1][3]==1){echo "checked";}?>></td>
                </tr>
              </table>
              <input name="class3_<?=$I+52?>" value="<?=$ShowTable[$I+52-1][1]?>" type="hidden" >	  
			  
			  
			  
			  
			  
			  </td>
              <td height="25" align="center" bordercolor="cccccc"><span id=bl<?=$I+52-1?>><?=$ShowTable[$I+52-1][0]?></span></td>
              <td width="4%" align="center" bordercolor="cccccc"><span id=gold<?=$I+52-1?>>0</span></td>
              
			  <td height="25" align="center" bordercolor="cccccc"><?=$ShowTable[$I+65-1][1]?>
		      <input name="class2_<?=$I+65?>" value="<?=$ShowTable[$I+65-1][2]?>" type="hidden" ></td>
              <td height="25" align="center" bordercolor="cccccc"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input      style="HEIGHT: 18px"  class="input1" maxlength="6" size="4" value="<?=$ShowTable[$I+65-1][0]?>" name="Num_<?=$I+65?>" /></td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+65?>','','class1=正1-6&ids=<?=$ShowTable[$I+65-1][2]?>&sqq=sqq&lxlx=1&qtqt=0.01&class3=<?=$ShowTable[$I+65-1][1]?>');"><img src="images/bvbv_01.gif"   width="19" height="17" border="0"></a></td>
                    </tr>
                    <tr>
                      <td><a style="cursor:hand" onClick="UpdateRate('MODIFYRATE','Num_<?=$I+65?>','','class1=正1-6&ids=<?=$ShowTable[$I+65-1][2]?>&sqq=sqq&lxlx=0&qtqt=0.01&class3=<?=$ShowTable[$I+65-1][1]?>');"><img src="images/bvbv_02.gif" width="19" height="17" border="0"  ></a></td>
                    </tr>
                  </table></td>
                  <td><input type=checkbox id=lock<?=$I+65?> style="zoom:95%" title="关闭该项" onClick="UpdateRate('LOCK','lock<?=$I+65?>','','class1=正1-6&ids=<?=$ShowTable[$I+65-1][2]?>&sqq=sqq&class3=<?=$ShowTable[$I+65-1][1]?>&lock='+this.checked);"  <? if ($ShowTable[$I+65-1][3]==1){echo "checked";}?>></td>
                </tr>
              </table>
              <input name="class3_<?=$I+65?>" value="<?=$ShowTable[$I+65-1][1]?>" type="hidden" >
	  
	  
	  </td>
              <td height="25" align="center" bordercolor="cccccc"><span id=bl<?=$I+65-1?>><?=$ShowTable[$I+65-1][0]?></span></td>
              <td width="4%" align="center" bordercolor="cccccc"><span id=gold<?=$I+65-1?>>0</span></td>
            </tr>
            
			
			 <?
			 }
			 
			 }
			 }
			 ?>
			 <tr>
              <td height="25" colspan="12" align="center" bordercolor="cccccc"><table width="98" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="88" align="center"><input name="button2"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type=button onClick="javascript:sel_col_ball('alal')" value=赔率增加></td>
                  <td width="88" align="center"><INPUT name="button3"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type=button onClick="javascript:sel_col_ball1('alal')" value=赔率减少></td>
                  <td width="88" align="center"><input type="submit"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit2" value="提交" /></td>
                  <td width="88" align="center"><input type="reset"    class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" name="Submit3" value="重置" /></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr></form>
</table>
          <SCRIPT language=javascript>
 makeRequest('index.php?action=server&class1=正1-6&class2=<?=$ids?>')</script>
