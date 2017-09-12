<? if(!defined('PHPYOU')) {
	exit('非法进入');
}




if ($_GET['kithe']!=""){$kithe=$_GET['kithe'];}else{$kithe=$Current_Kithe_Num;}

$username=$_GET['username'];







?>

<link rel="stylesheet" href="images/xp.css" type="text/css">
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
</SCRIPT>
<script language="javascript" type="text/javascript" src="js_admin.js"></script>






<style type="text/css">
<!--
.STYLE3 {color: #FF3300}
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
    <td width="28%"><strong><font color="#FFFFFF">[<?=$username?>]总代理注单查询[<?=$kithe?>期]</font></strong></td>
    <td width="35%">&nbsp;</td>
    <td width="37%"><div align="right">
      <button onClick="javascript:history.go(-1);"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<%=z1color%>;'>返回上一页</span></button>&nbsp;<button onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/asp.gif" width="16" height="16" align="absmiddle" />打印</button>
    </div></td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table id="tb"  border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="98%">
  <tr>
    <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA" >序号</td>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">会员账号</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">注数</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下注金额</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">实投</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">公司占成</TD>
    <TD align="center" nowrap bordercolor="cccccc" bgcolor="#FDF4CA">股东占成</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">总代占成</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">代理占成</TD>
  </tr>
  <?
  $z_st=0;
		$z_re=0;
		$z_sum=0;
		$z_dagu=0;
		$z_guan=0;
		$z_zong=0;
		$z_dai=0;
		
		 $result = mysql_query("select distinct(username)   from   ka_tan where Kithe='".$kithe."' and dai='$username' order by username desc");   
$ii=0;
while($rs = mysql_fetch_array($result)){



$result1 = mysql_query("Select sum(sum_m) as sum_m,count(*) as re,sum(sum_m*dagu_zc/10) as dagu_zc,sum(sum_m*guan_zc/10) as guan_zc,sum(sum_m*zong_zc/10) as zong_zc,sum(sum_m*dai_zc/10) as dai_zc,sum(sum_m-sum_m*user_ds/100) as sum_st from ka_tan   where Kithe='".$kithe."' and username='".$rs['username']."'");

$Rs5 = mysql_fetch_array($result1);



$ii++;
$re=$Rs5['re'];

$sum_m=$Rs5['sum_m'];
$dagu_zc=$Rs5['dagu_zc'];
$guan_zc=$Rs5['guan_zc'];
$zong_zc=$Rs5['zong_zc'];
$dai_zc=$Rs5['dai_zc'];

$z_st+=$Rs5['sum_st'];

$z_re+=$Rs5['re'];
$z_sum+=$Rs5['sum_m'];
$z_dagu+=$Rs5['dagu_zc'];
$z_guan+=$Rs5['guan_zc'];
$z_zong+=$Rs5['zong_zc'];
$z_dai+=$Rs5['dai_zc'];
$result2=mysql_query("select * from ka_mem where  kauser='".$rs['username']."' order by id"); 
$row11=mysql_fetch_array($result2);


if ($row11!=""){$xm="<font color=ff6600> (".$row11['xm'].")</font>";}
?>
  <tr >
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$ii?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['username']?>
        <?=$xm?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$Rs5['re']?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><button onClick="javascript:location.href='index.php?action=x5&kithe=<?=$kithe?>&username=<?=$rs['username']?>'"  class="headtd4" style="width:80;height:22" ;><font color=ff6600>
      <?=$Rs5['sum_m']?>
    </font></button></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=round($Rs5['sum_st'],2)?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=round($Rs5['dagu_zc'],2)?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=round($Rs5['guan_zc'],2)?></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=round($Rs5['zong_zc'],2)?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=round($Rs5['dai_zc'],2)?></td>
  </tr>
  <? }?>
  <tr >
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">总计</span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=$z_re?>
    </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=$z_sum?>
    </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=round($z_st,2)?></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=round($z_dagu,2)?>
    </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=round($z_guan,2)?>
    </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=round($z_zong,2)?>
    </span></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=round($z_dai,2)?>
    </span></td>
  </tr>
</table>
<br>
<table border="1" align="center" cellspacing="0" cellpadding="2" bordercolor="f1f1f1" bordercolordark="#FFFFFF" width="99%">
  <tr>
    <form name=form55 action="index.php?action=xx5" method=post>
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
