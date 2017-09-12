<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

if (strpos($_SESSION['flag'],'11') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}



if ($_GET['kithe']!=""){$kithe=$_GET['kithe'];}else{$kithe=$Current_Kithe_Num;}







?>

<link rel="stylesheet" href="images/xp.css" type="text/css">

<script language="javascript" type="text/javascript" src="js_admin.js"></script>






<style type="text/css">
<!--
.STYLE3 {color: #FF3300}
.STYLE4 {color: #FFFFFF}
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
    <td width="15%"><strong><font color="#FFFFFF">注单查询[
      <?=$kithe?>
    期]</font></strong></td>
    <td width="48%"><table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="73" align="right" nowrap><span class="STYLE4">选择期数：</span> </td>
        <td width="36" nowrap><SELECT class=zaselect_ste name=temppid onChange="var jmpURL=this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}">
            <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=index.php?action=x1&ids=".$ids."&kithe=".$image['nn'];
				 if ($kithe!="") {
				 if ($kithe==$image['nn']) {
				  echo " selected=selected ";
				  }				
				}
				 echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
        </SELECT></td>
        <td width="697">&nbsp;</td>
      </tr>
    </table></td>
    <td width="37%" align="right"><button onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/asp.gif" width="16" height="16" align="absmiddle" />打印</button></td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>

<br>
<table border="1" align="center" cellspacing="1" cellpadding="2" bordercolor="f1f1f1" bordercolordark="#FFFFFF" width="99%">
  <tr>
    <form name=form55 action="index.php?action=xxx5" method=post>
      <td><table width="100" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td nowrap>查询种类：</td>
          <td nowrap><select name="class" id="class">
            <option  value="" selected>-全部-</option>
            <option value="1">会员账号</option>
            <option value="2">下注单号</option>
            <option value="3">下注盘类</option>
          </select>
                <input name="key"  class="input1" type="text" id="key" size="8"></td>
          <td nowrap>投注品种：</td>
          <td nowrap><select name="class2" id="class2">
   
            <option value="特A" selected>特码：特A</option>
            <option value="特B">特码：特B</option>
            <option value="正A">正码：正A</option>
            <option value="正B">正码：正B</option>
            <option value="正1特">正特：正1特</option>
            <option value="正2特">正特：正2特</option>
            <option value="正3特">正特：正3特</option>
            <option value="正4特" >正特：正4特</option>
            <option value="正5特" >正特：正5特</option>
            <option value="正6特" >正特：正6特</option>
                       <option value="过关" >过关</option>
            <option value="三全中" >连码：三全中</option>
            <option value="三中二" >连码：三中二</option>
            <option value="二全中" >连码：二全中</option>
            <option value="二中特"  >连码：二中特</option>
            <option value="特串" >连码：特串</option>
            <option value="特肖" >生肖：特肖</option>
            <option value="四肖"  >生肖：四肖</option>
            <option value="五肖" >生肖：五肖</option>
            <option value="六肖"  >生肖：六肖</option>
            <option value="一肖" >生肖：一肖</option>
            <option value="半波" >半波</option>
            <option value="半半波" >半半波</option>
            <option value="头数">头数</option>
            <option value="尾数">尾数</option>
            <option value="正特尾数">正特尾数</option>
            <option value="正肖" >正肖</option>
            <option value="七色波" >七色波</option>
			<option value="五行">五行</option>
          </select>
                <input name="ac2" type="hidden" id="ac" value="A" /></td>
          <td nowrap>日期区间：</td>
          <td><table cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr>
                <td><input name="txt8" type="text" class="input1" value="<?=date("Y-m-d")?>" size="12">
                </td>
                <td><img src="images/date.gif" align="absmiddle" class="cursor" onClick="javascript:popdate(txt8)"> </td>
                <td align="middle" width="20">~</td>
                <td><input name="txt9" type="text" class="input1" value="<?=date("Y-m-d")?>" size="12">
                </td>
                <td><img src="images/date.gif" align="absmiddle" class="cursor" onClick="javascript:popdate(txt9)"></td>
                <td align="right" width="200"></td>
              </tr>
            </tbody>
          </table></td>
          <td nowrap>选择期数：</td>
          <td><select name="kithe" id="kithe">
            <option value="" selected="selected">按时间来查</option>
            <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=".$image['nn'];
				echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
          </select></td>
          <td><INPUT  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type=submit value=查询 name=SUBMIT></td>
        </tr>
      </table></td>
    </FORM>
  </tr>
</table>
<div align="center"></div>
