<? if(!defined('PHPYOU')) {
	exit('非法进入');
}




if ($_GET['kithe']!="" or $_POST['kithe']!="" ){

if ($_GET['kithe']!=""){
$kithe=$_GET['kithe'];}else{$kithe=$_POST['kithe'];}


}

$username=$_GET['username'];

if ($_GET['save']=="save"){

if ($_POST['Submit']=="修改"){

//if ($_POST['kithe1']!=$Current_Kithe_Num){
//echo "alert('本期已经开过奖,请不要修改!');window.history.go(-1);"; 
//exit;
//}

if (strpos($_SESSION['flag'],'13') ){}else{ 
echo "<center>你没有该权限功能!</center>";
exit;}

$exe=mysql_query("update ka_tan set class1='".$_POST['class11']."',class2='".$_POST['class22']."',class3='".$_POST['class33']."',rate='".$_POST['rate']."',sum_m='".$_POST['sum_m']."',user_ds='".$_POST['user_ds']."',adddate='".$_POST['adddate']."' where id=".$_GET['id']);

	if ($_POST['kithe1']!=$Current_Kithe_Num){}else{
	$result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$_POST['kithe1']."  and   username='".$_GET['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
    $exe=mysql_query("update ka_mem set ts=(cs-".$mkmk.") where kauser='".$_GET['username']."'");}


}

if ($_POST['Submit']=="删除"){

mysql_query("Delete from ka_tan where id=".$_GET['id']);

if ($_POST['kithe1']!=$Current_Kithe_Num){}else{
	$result2 = mysql_query("Select SUM(sum_m) As sum_m1   From ka_tan Where kithe=".$_POST['kithe1']."  and   username='".$_GET['username']."' order by id desc");
	$rsw = mysql_fetch_array($result2);
	if ($rsw[0]<>""){$mkmk=$rsw[0];}else{$mkmk=0;}
    $exe=mysql_query("update ka_mem set ts=(cs-".$mkmk.") where kauser='".$_GET['username']."'");}


}




}

if ($_GET['del']=="del"){


	
	
 }


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
    <td width="26%"><strong><font color="#FFFFFF"><? if( $username!="" and $kithe!="" ){?>[<?=$username?>]会员注单[<?=$kithe?>期]查询列表<? }else{echo "注单查询表表";}?></font></strong></td>
    <td width="58%"><table border="0" align="center" cellspacing="0" cellpadding="1" bordercolor="888888" bordercolordark="#FFFFFF" width="100%">
      <tr>
        <td>&nbsp;<span class="STYLE4">当前报表-->>
            <? if( $kithe!=""){?>
          查第
            <?=$kithe?>
            期
            <? }else{?>
          日期区间：
            <?=$_POST['txt8']?>
            -----
            <?=$_POST['txt9']?>
            
          <? }?>
&nbsp;&nbsp;&nbsp;&nbsp;投注品种：
            <? if ($_POST['class2']!=""){?>
            <?=$_POST['class2']?>
            <? }else{?>
            全部
            <? }?>
            查询种类：
              <? if ($_POST['class']!=""){?>
              (
              <?
		   
		 
			if ($_POST['class']=="1"){echo "会员账号";}
		if ($_POST['class']=="2"){echo "下注单号";}
		if ($_POST['class']=="3"){echo "下注盘类";}
		
		
			?>
              :
              <?=$_POST['key']?>
              )
              <? }else{?>
              全部
              <? }?>
          </span> </td>
      </tr>
    </table></td>
    <td width="16%"><div align="right">
      <button onClick="javascript:history.go(-1);"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><img src="images/add.gif" width="16" height="16" align="absmiddle"><SPAN id=rtm1 STYLE='color:<%=z1color%>;'>返回上一页</span></button>&nbsp;<button onClick="javascript:window.print();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/asp.gif" width="16" height="16" align="absmiddle" />打印</button>
    </div></td>
  </tr>
  <tr >
    <td height="5" colspan="3"></td>
  </tr>
</table>
<table id="tb"  border="1" align="center" cellspacing="1" cellpadding="1" bordercolordark="#FFFFFF" bordercolor="f1f1f1" width="99%">
  <tr>
    <td width="4%" height="28" align="center" nowrap="nowrap" bordercolor="cccccc" bgcolor="#FDF4CA">序号</td>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">会员</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下单时间 </TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">期数</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA">下注金额</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">赔率</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">退佣%</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">类型1</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">类型2</TD>
    <TD align="center" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">球号</TD>
    <TD width="30" align="center" style="display:<? if($_SESSION['stadmin666']==1){echo ""; }else{ echo "none";}?>;" bordercolor="cccccc" bgcolor="#FDF4CA" class="m_title_reall">操作</TD>
  </tr>
  <?
		$z_re=0;
		$z_sum=0;
		$z_dagu=0;
		$z_guan=0;
		$z_zong=0;
		$z_dai=0;
		$re=0;
		
		$vvv="where 1=1";
		if ($kithe!=""){
		$vvv.=" and kithe='".$kithe."' ";
		}else{
		if ($_POST['txt8']!="" and $_POST['txt9']!="" ){
		
		$stime=$_POST['txt8']." 00:00:00";
   $etime=$_POST['txt9']." 23:59:59";
		 
		$vvv.=" and adddate>='".$stime."' and adddate<='".$etime."' ";
		
		}else{$vvv.=" and Kithe='".$kithe."' ";}
		
		}
		
	
		if ($username!=""){
		$vvv.=" and username='".$username."' ";
		}
		
		if ($_POST['class']!=""){
		if ($_POST['key']!=""){
		if ($_POST['class']=="1"){$vvv.=" and username='".$_POST['key']."' ";}
		if ($_POST['class']=="2"){$vvv.=" and num='".$_POST['key']."' ";}
		if ($_POST['class']=="3"){$vvv.=" and abcd='".$_POST['key']."' ";}
		
		}		
		}
		if ($_POST['class2']!=""){
		$vvv.=" and class2='".$_POST['class2']."' ";
		}
		
		
		
		
		
		 $result = mysql_query("select id,kithe,username,adddate,sum_m,rate,user_ds,class1,class2,class3,abcd  from   ka_tan ".$vvv." order by sum_m desc");   
$ii=0;
while($rs = mysql_fetch_array($result)){




$ii++;
$z_re++;






$z_sum+=$rs['sum_m'];
//$z_dagu+=$Rs5['dagu_zc'];
//$z_guan+=$Rs5['guan_zc'];
//$z_zong+=$Rs5['zong_zc'];
//$z_dai+=$Rs5['dai_zc'];

$result2=mysql_query("select * from ka_mem where  kauser='".$rs['username']."' order by id"); 
$row11=mysql_fetch_array($result2);


if ($row11!=""){$xm="<font color=ff6600> (".$row11['xm'].")</font>";}
?>
  <form action="index.php?action=x5&save=save&id=<?=$rs['id']?>&kithe=<?=$kithe?>&username=<?=$rs['username']?>" method="post" name="form" id="form">
    <tr >
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><?=$ii?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><?=$rs['username']?>
          <?=$xm?>
        .
        <?=$rs['abcd']?></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="adddate" type="text" class="input1"  id="adddate" value="<?=$rs['adddate']?>" size="25"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><font color=ff6600>
        <?=$rs['kithe']?>
        期</font></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="sum_m" type="text" class="input1"  id="sum_m" value="<?=$rs['sum_m']?>" size="10"></td>
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><input name="rate" type="text" class="input1"  id="rate" value="<?=$rs['rate']?>" size="4"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="user_ds" type="text" class="input1"  id="user_ds" value="<?=$rs['user_ds']?>" size="4"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="class11" type="text" class="input1"  id="class11" value="<?=$rs['class1']?>" size="10"></td>
      <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc"><input name="class22" type="text" class="input1"  id="class22" value="<?=$rs['class2']?>" size="25"></td>
      <td align="center" nowrap="nowrap" bordercolor="cccccc"><input name="class33" type="text" class="input1"  id="class33" value="<?=$rs['class3']?>" size="25">
          <input name="class" type="hidden" id="class" value="<?=$_POST['class']?>">
          <input name="key" type="hidden" id="key" value="<?=$_POST['key']?>">
          <input name="class2" type="hidden" id="class2" value="<?=$_POST['class2']?>">
          <input name="txt8" type="hidden" id="txt8" value="<?=$_POST['txt8']?>">
          <input name="txt9" type="hidden" id="txt9" value="<?=$_POST['txt9']?>">
          <input name="kithe1" type="hidden" id="kithe1" value="<?=$rs['kithe']?>"></td>
      <td align="center" style="display:<? if($_SESSION['stadmin666']==1){echo ""; }else{ echo "none";}?>;" nowrap="nowrap" bordercolor="cccccc"><span style="display:<? if($_SESSION['stadmin666']==1){echo ""; }else{ echo "none";}?>;">
        <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="修改" />
      </span><span style="display:<? if($_SESSION['stadmin666']==1){echo ""; }else{ echo "none";}?>;">
      <input  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" type="submit" name="Submit" value="删除" >
      </span></td>
    </tr>
  </form>
  <? }?>
  <tr >
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">总计</span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=$z_re?>
      注 </span></td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc"><span class="STYLE3">
      <?=$z_sum?>
    </span></td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td height="28" align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
    <td align="center" style="display:<? if($_SESSION['stadmin666']==1){echo ""; }else{ echo "none";}?>;" nowrap="nowrap" bordercolor="cccccc">&nbsp;</td>
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
			<option value="二肖" >生肖：二肖</option>
			<option value="三肖" >生肖：三肖</option>
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
