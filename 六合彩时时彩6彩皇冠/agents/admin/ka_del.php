<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}


if ($_GET['act']=="添加"){

if ($_POST['key']>=$Current_Kithe_Num or $_POST['key1']>=$Current_Kithe_Num){ 
echo("<script type='text/javascript'>alert('对不起，当期数据不能删除！');history.back();</script>"); 
exit;
}


if ($_POST['key']=="" or $_POST['key1']==""){ 
echo("<script type='text/javascript'>alert('请输入期数！');history.back();</script>"); 
exit;
}

mysql_query("Delete from ka_tan where kithe>=".$_POST['key']." and kithe<=".$_POST['key1']." ");
mysql_query("Delete from ka_tong where kithe>=".$_POST['key']." and kithe<=".$_POST['key1']." ");

echo "<script>alert('第".$_POST['key']."期至第".$_POST['key1']."期已被删除！!');window.location.href='index.php?action=ka_del';</script>"; 

  



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
 		{ document.all.key.focus(); alert("请务必输入期数!!"); return false; 
		
		}
		
			if(document.all.key1.value=='')
 		{ document.all.key1.focus(); alert("请务必输入期数!!"); return false; 
		
		}
		
	
  	
 	
 
		
		
  
 	
	if(!confirm("是否确定删除该期数据?")){
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
echo "<center>你没有该权限功能!</center>";
exit;}?>
<div align="center">
  <table width="99%" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="f1f1f1" class="about">
    <tr>
      <td bordercolor="cccccc" bgcolor="#FDF4CA">删除数据</td>
    </tr>
    <tr>
      <td align="center" bordercolor="cccccc"><table>
          <form action="index.php?action=ka_del&amp;act=添加" method="post" name="testFrm" id="testFrm" onsubmit="return SubChk()">
            <tr>
              <td colspan="2" align="center" nowrap="nowrap"><p align="right">请输入期数：</p></td>
              <td align="center" colspan="6"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="key" type="text" class="input1" id="key" size="20" />
                      ——
                      <input name="key1" type="text" class="input1" id="key1" size="20" /></td>
                    <td width="80" align="center"><input type="submit" value="确定删除" name="B1"   class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;></td>
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
    <td><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 提示：如果一但删除了就不可能在还原.请小心清除数据.</div></td>
  </tr>
</table>
</div>
