

<?
if(!defined('PHPYOU_VER')) {
	exit('�Ƿ�����');
}





?>


	<?
	$nana=1;
	$result=mysql_query("select * from ka_kithe  order by id desc LIMIT 1"); 
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


$na=$row['na'];
$n1=$row['n1'];
$n2=$row['n2'];
$n3=$row['n3'];
$n4=$row['n4'];
$n5=$row['n5'];
$n6=$row['n6'];

$zfb=$row['zfb'];
  
	
	


if ($zfb==1){
echo "<script>alert('���ȷ������Զ�������!');window.location.href='index.php?action=kithe';</script>"; 
exit;
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
.style2 {color: #ffffff}
.STYLE3 {color: #FFFFFF}
.bg2 {background-color:#FFA730; }
.tablebg {border-collapse:collapse;border:1px solid #DBDBDB; }
-->
</style>
<table border="0" align="center" cellspacing="0" cellpadding="5" bordercolor="888888" bordercolordark="#FFFFFF" width="100%">
  <tr>
    <td class="tbtitle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25"><? require_once '1top.php';?></td>
        
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="left">
      <? if ($na==0) { ?>
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
		   


num1 = arrTmp[0]; //�ֶ�num1��ֵ
num2 = parseFloat(arrTmp[1]).toFixed(2); //�ֶ�num2��ֵ
num3 = arrTmp[2]; //�ֶ�num1��ֵ
num4 = arrTmp[3]; //�ֶ�num2��ֵ


if (arrTmp[9]!=1){
var bl="n1";
document.all[bl].value=arrTmp[2];
var bl="n2";
document.all[bl].value=arrTmp[3];
var bl="n3";
document.all[bl].value=arrTmp[4];

var bl="n4";
document.all[bl].value=arrTmp[5];

var bl="n5";
document.all[bl].value=arrTmp[6];
var bl="n6";
document.all[bl].value=arrTmp[7];
var bl="na";
document.all[bl].value=arrTmp[8];}

if (arrTmp[10]!="0"){window.location.href='index.php?action=kawin&amp;kithe='+arrTmp[1];
}	
}
	
			
           
        } else {//http_request.status != 200
           
                alert("Request failed! ");
       
        }
   
    }
 
}


function UpdateRate(commandName,inputID,cellID,strPara)
{
	//���ܣ���strPara���������͸�rake_updateҳ�棬�������ؽ���ش�
	//���������	inputID,cellID:Ҫ��ʾ�������ݵ�ҳ��ؼ���
	//		strPara���������͸�rake_updateҳ��Ĳ���
	//class1:���1
	//ids:(��class2)�������Ϊ��A����B��qtqt:�������ȣ�lxlx��������1Ϊ�ӣ�����Ϊ��
	//class3:���������
	switch(commandName)
	{
		case "MODIFYRATE":	//��������
			{
				var strResult = sendCommand(commandName,"rake_update.php",strPara);
				
				if (strResult!="")
				{
					makeRequest('index.php?action=kaaout')
					document.all[inputID].value=parseFloat(strResult).toFixed(2);
					
				}
				break;
			}
		case "LOCK":		//�ر���Ŀ
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
		default:	//�������
	}
}
function sendCommand(commandName,pageURL,strPara)
{
	//���ܣ���pageURLҳ�淢�����ݣ�����ΪstrPara
	//���ش����������ص�����
	var oBao = new ActiveXObject("Microsoft.XMLHTTP");
	//�����ַ���+,%,&,=,?�ȵĴ������취.�ַ�������escape�����.
	oBao.open("GET",pageURL+"?commandName="+commandName+"&"+strPara,false);
	oBao.send();
	//�������˴����ص��Ǿ���escape������ַ���.
	var strResult = unescape(oBao.responseText);
	return strResult;
}


</script>

      <table width="100%" height="100" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <td align="center" bgcolor="#FFFFFF">
		 
		  <table border="1" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
            <form action="index.php?action=kithe&amp;svave=svave&amp;id=<?=$id?>"  method="post" name="testFrm" id="testFrm">
              <tr class="tbtitle">
                <td height="25" colspan="7" align="center" class="STYLE2">��<?=$nn?>���Զ�����</td>
                </tr>
              <tr class="tbtitle">
                <td height="25" align="center" class="STYLE2">ƽ1</td>
            
                <td height="25" align="center" class="STYLE2">ƽ2</td>
               
                <td height="25" align="center" class="STYLE2">ƽ3</td>
              
                <td height="25" align="center" class="STYLE2">ƽ4</td>
             
                <td height="25" align="center" class="STYLE2">ƽ5</td>
             
                <td height="25" align="center" class="STYLE2">ƽ6</td>
              
                <td height="25" align="center" class="STYLE2">����</td>
                </tr>
              <tr>
                <td height="25" align="center"><input name="n1" type="text" class="input1"  id="n1" value="<?=$row['n1']?>" size="8" /></td>
             
                <td height="25" align="center"><input name="n2"type="text" class="input1"  id="n2" value="<?=$row['n2']?>" size="8" /></td>
               
                <td height="25" align="center"><input name="n3" type="text" class="input1"  id="n3" value="<?=$row['n3']?>" size="8" /></td>
              
                <td height="25" align="center"><input name="n4" type="text" class="input1"  id="n4" value="<?=$row['n4']?>" size="8" /></td>
            
                <td height="25" align="center"><input name="n5" type="text" class="input1"  id="n5" value="<?=$row['n5']?>" size="8" /></td>
              
                <td height="25" align="center"><input name="n6" type="text" class="input1"  id="n6" value="<?=$row['n6']?>" size="8" /></td>
              
                <td height="25" align="center"><input name="na" type="text" class="input1"  id="na" value="<?=$row['na']?>" size="8" /></td>
              </tr>
              <tr>
                <td height="25" colspan="7" align="center">���ڿ�����....</td>
              </tr>
            </form>
		    </table></td>
        </tr>
      </table>
	  <SCRIPT language=javascript>
 makeRequest('index.php?action=kaaout1')</script>
      <?
				 }else{
				 ?>
      <table width="100%" height="100" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <td align="center" bgcolor="#FFFFFF"><button   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:200;height:25" ;><font color="ff0000">�ѿ���</font></button></td>
        </tr>
      </table>
      <? } ?>
    </div></td>
  </tr>
</table>
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left"> </div></td>
    <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> ������ʾ���Զ�������ʱ����̫��û�п��������ֶ�����,����Զ�����������������ϻ��Զ�����,���������ȷ�Ͽ����Ƿ��д�.����д����޸ĺ������½��㡣</div></td>
  </tr>
</table>
