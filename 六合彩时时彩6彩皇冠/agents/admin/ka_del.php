<?
if(!defined('PHPYOU')) {
	exit('�Ƿ�����');
}


if ($_GET['act']=="���"){

if ($_POST['key']>=$Current_Kithe_Num or $_POST['key1']>=$Current_Kithe_Num){ 
echo("<script type='text/javascript'>alert('�Բ��𣬵������ݲ���ɾ����');history.back();</script>"); 
exit;
}


if ($_POST['key']=="" or $_POST['key1']==""){ 
echo("<script type='text/javascript'>alert('������������');history.back();</script>"); 
exit;
}

mysql_query("Delete from ka_tan where kithe>=".$_POST['key']." and kithe<=".$_POST['key1']." ");
mysql_query("Delete from ka_tong where kithe>=".$_POST['key']." and kithe<=".$_POST['key1']." ");

echo "<script>alert('��".$_POST['key']."������".$_POST['key1']."���ѱ�ɾ����!');window.location.href='index.php?action=ka_del';</script>"; 

  



}


?>


<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script language="JavaScript" src="tip.js"></script>

<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
function SubChk()
{
	
 	if(document.all.key.value=='')
 		{ document.all.key.focus(); alert("�������������!!"); return false; 
		
		}
		
			if(document.all.key1.value=='')
 		{ document.all.key1.focus(); alert("�������������!!"); return false; 
		
		}
		
	
  	
 	
 
		
		
  
 	
	if(!confirm("�Ƿ�ȷ��ɾ����������?")){
  		return false;
 	}
}



</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="51%"><? require_once '2top.php';?></td>
  </tr>
  <tr >
    <td height="5"></td>
  </tr>
</table>
 <? if (strpos($_SESSION['flag'],'10') ){}else{ 
echo "<center>��û�и�Ȩ�޹���!</center>";
exit;}?>
<div align="center">
  <table width="99%" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="f1f1f1" class="about">
    <tr>
      <td bordercolor="cccccc" bgcolor="#FDF4CA">ɾ������</td>
    </tr>
    <tr>
      <td align="center" bordercolor="cccccc"><table>
          <form action="index.php?action=ka_del&amp;act=���" method="post" name="testFrm" id="testFrm" onsubmit="return SubChk()">
            <tr>
              <td colspan="2" align="center" nowrap="nowrap"><p align="right">������������</p></td>
              <td align="center" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="key" type="text" class="input1" id="key" size="20" />
                      ����
                      <input name="key1" type="text" class="input1" id="key1" size="20" /></td>
                    <td width="80" align="center"><input type="submit" value="ȷ��ɾ��" name="B1"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;></td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </form>
      </table></td>
    </tr>
  </table>
  <br>
<br>

<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70"><div align="left"> </div></td>
    <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> ��ʾ�����һ��ɾ���˾Ͳ������ڻ�ԭ.��С���������.</div></td>
  </tr>
</table>
</div>
