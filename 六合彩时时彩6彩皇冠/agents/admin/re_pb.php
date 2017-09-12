<? if(!defined('PHPYOU')) {
	exit('非法进入');
}

 if (strpos($_SESSION['flag'],'09') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}

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
.style2 {color: #FF0000}
.STYLE3 {color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<div align="center">
<link rel="stylesheet" href="xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<script src="inc/forms.js"></script>
<script language="JavaScript" type="text/JavaScript">
function SelectAllPub() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
function SelectAllAdm() {
	for (var i=0;i<document.form1.flag.length;i++) {
		var e=document.form1.flag[i];
		e.checked=!e.checked;
	}
}
</script>

<SCRIPT>
<!--
 function onSubmit()
 {
  kind_obj = document.getElementById("ac");
  form_obj = document.getElementById("myFORM");
  if(kind_obj.value == "A")
   form_obj.action = "index.php?action=re_all";
  else
   form_obj.action = "index.php?action=re_class";
  return true;
 }
-->
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr class="tbtitle">
    <td width="29%"><span class="STYLE3">报表查询</span></td>
    <td width="34%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table width="100%"  border="1" cellpadding="2" cellspacing="2" bordercolor="f1f1f1">
  <form id="myFORM" name="FrmData"  action="index.php?action=re_all" method="post">
    <tr>
      <td height="25" align="right" bordercolor="cccccc" ><span class="STYLE1">投注品种： </span></td>
      <td bordercolor="cccccc" ><select name="class2" id="class2">
        <option value="" selected="selected">-----全部-----</option>
        <option value="特A">特码：特A</option>
        <option value="特B">特码：特B</option>
        <option value="正A">正码：正A</option>
        <option value="正B">正码：正B</option>
        <option value="正1特">正特：正1特</option>
        <option value="正2特">正特：正2特</option>
        <option value="正3特">正特：正3特</option>
        <option value="正4特" >正特：正4特</option>
        <option value="正5特" >正特：正5特</option>
        <option value="正6特" >正特：正6特</option>
        <option value="正码1" >正1-6：正码1</option>
        <option value="正码2"  >正1-6：正码2</option>
        <option value="正码3"  >正1-6：正码3</option>
        <option value="正码4"  >正1-6：正码4</option>
        <option value="正码5" >正1-6：正码5</option>
        <option value="正码6" >正1-6：正码6</option>
        <option value="过关" >过关</option>
        <option value="三全中" >连码：三全中</option>
        <option value="三中二" >连码：三中二</option>
        <option value="二全中" >连码：二全中</option>
        <option value="二中特"  >连码：二中特</option>
        <option value="五不中" >不中：五不中</option>
        <option value="七不中" >不中：七不中</option>
        <option value="特串" >连码：特串</option>
        <option value="特肖" >生肖：特肖</option>
        <option value="四肖"  >生肖：四肖</option>
        <option value="五肖" >生肖：五肖</option>
        <option value="六肖"  >生肖：六肖</option>
		<option value="三肖" >生肖：三肖</option>
		<option value="二肖" >生肖：二肖</option>
        <option value="一肖" >生肖：一肖</option>
        <option value="半波" >半波</option>
        <option value="半半波" >半半波</option>
        <option value="头数">头数</option>
        <option value="尾数">尾数</option>
        <option value="正特尾数">正特尾数</option>
        <option value="正肖" >正肖</option>
        <option value="七色波" >七色波</option>
      </select>
          <input name="ac2" type="hidden" id="ac" value="A" /></td>
    </tr>
    <tr>
      <td height="25" align="right" bordercolor="cccccc" ><span class="STYLE1">日期区间： </span></td>
      <td bordercolor="cccccc" ><table cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td><input name="txt8" type="text" class="input1" value="<?=date("Y-m-d")?>" size="18" />
            </td>
            <td><img src="images/date.gif" align="absmiddle" class="cursor" onclick="javascript:popdate(txt8)" /> </td>
            <td align="middle" width="20">~</td>
            <td><input name="txt9" type="text" class="input1" value="<?=date("Y-m-d")?>" size="18" />
            </td>
            <td><img src="images/date.gif" align="absmiddle" class="cursor" onclick="javascript:popdate(txt9)" /></td>
            <td align="right" width="200"></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="25" align="right" bordercolor="cccccc" ><span class="STYLE1">选择期数： </span></td>
      <td bordercolor="cccccc" ><select name="kithe" id="kithe">
        <option value="" selected="selected">按时间来查</option>
        <?
		$result = mysql_query("select * from ka_kithe order by nn desc");   
while($image = mysql_fetch_array($result)){
			     echo "<OPTION value=".$image['nn'];
				echo ">第".$image['nn']."期</OPTION>";
			  }
		?>
      </select>
          <span class="style2">(如果选择了期数,上面的日期将无效！)</span> </td>
    </tr>
    <tr>
      <td width="16%" height="25" bordercolor="cccccc">&nbsp;</td>
      <td width="84%" bordercolor="cccccc"><table width="100" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="6"></td>
        </tr>
      </table>
          <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'"  type="submit" value="查询" name="SUBMIT" />
          <table width="100" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="10"></td>
            </tr>
        </table></td>
    </tr>
  </form>
</table>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left"> </div></td>
    <td height="35"><div align="right" disabled="disabled"><img src="images/slogo_10.gif" width="15" height="11" align="absmiddle" /> 操作提示：如果想按时间来查询选择期数时，请选择[按时间来查]，如果选择了期数将不按时间来查询！。</div></td>
  </tr>
</table>
</div>
