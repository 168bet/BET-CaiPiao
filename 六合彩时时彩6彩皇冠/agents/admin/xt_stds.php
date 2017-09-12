<?
if(!defined('PHPYOU')) {
	exit('非法进入');
}

$result=mysql_query("select * from adad order by id"); 
$row=mysql_fetch_array($result);

	$best=$row['best'];
	
	$zm=$row['zm'];
	$zm6=$row['zm6'];
	$lm=$row['lm'];	
	$zlm=$row['zlm'];
	$ys=$row['ys'];
	$ls=$row['ls'];
	$dx=$row['dx'];
	$tm=$row['tm'];
	$spx=$row['spx'];
	$bb=$row['bb'];
	$zmt=$row['zmt'];
	$ws=$row['ws'];
	
	$zm1=$row['zm1'];
	$zm61=$row['zm61'];
	$lm1=$row['lm1'];	
	$zlm1=$row['zlm1'];
	$ys1=$row['ys1'];
	$ls1=$row['ls1'];
	$dx1=$row['dx1'];
	$tm1=$row['tm1'];
	$spx1=$row['spx1'];
	$bb1=$row['bb1'];
	$zmt1=$row['zmt1'];
	$ws1=$row['ws1'];
	
	$ps1=$row['ps1'];
	$ps=$row['ps'];
	
	


if ($_GET['save']=="save") {
	

$rid=$_POST['drop_id'];
$drop_name=$_POST['drop_name'];
$rate=$_POST['rate'];
$ratedrop=$_POST['ratedrop'];
$low_drop=$_POST['low_drop'];


for ($I=0; $I<=count($rid)-1; $I=$I+1)
{

  if (is_numeric($rate[$I])!=1){
  
 echo "<script>alert('".$rate[$I]."的数值填写有误，请输入数字1!');window.history.go(-1);</script>";
 exit();
  } 


  if (!is_numeric($ratedrop[$I]))
  {

 echo "<script>alert('".$ratedrop[$I]."的下调赔率填写有误，请输入数字2！');window.history.go(-1);</script>";
  
    exit();

  } 


  if (!is_numeric($low_drop[$I]))
  {
 echo "<script>alert('".$low_drop[$I]."的下调赔率填写有误，请输入数字3！');window.history.go(-1);</script>";

    exit();

  } 


} 



// $Rs6 is of type "Adodb.RecordSet"

for ($I=0; $I<=count($rid); $I=$I+1)
{

$exe=mysql_query("Update ka_drop Set drop_value=".$rate[$I].",drop_unit=".$ratedrop[$I].",low_drop=".$low_drop[$I]." where ID=".$rid[$I]);

} 



print "<script language='javascript'>alert('设置成功！');window.location.href='index.php?action=xt_stds';</script>";
exit();

}








$result=mysql_query("Select ID,drop_sort,drop_value,drop_unit,low_drop from ka_drop order by ID");
$drop_table = array();
$y=0;
while($image = mysql_fetch_array($result)){
$y++;
array_push($drop_table,$image);

}

$drop_count=$y-1;


 ?>

	

<link rel="stylesheet" href="images/xp.css" type="text/css">
<script language="javascript" type="text/javascript" src="js_admin.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style>

<noscript>
<iframe scr=″*.htm″></iframe>
</noscript>
<SCRIPT language=JAVASCRIPT>
if(self == top) {location = '/';} 
if(window.location.host!=top.location.host){top.location=window.location;} 
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
  <table width="99%" 
 border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="f1f1f1">
  <form name=form1 action=index.php?action=xt_stds&save=save method=post>  <tbody>
      <tr >
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA"  ><span class="STYLE2">类型</span></td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2">数值</span></td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2">每次下调赔率的单位</span></td>
        <td align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2">最低赔率</span></td>
      </tr>
      <? for ($I=0; $I<=$drop_count; $I=$I+1)
{
    //if ($drop_table[$I][1] == "五行") continue;

?>
      <tr >
        <td width="22%" align="center" bordercolor="cccccc" bgcolor="#FDF4CA" ><span class="STYLE2"><strong>
          <?   echo $drop_table[$I][1]; ?>
        </strong></span></td>
        <td width="23%" align="center" bordercolor="cccccc" ><input type="hidden" name="drop_id[]" value='<?   echo $drop_table[$I][0]; ?>' />
            <input type="hidden" name="drop_name[]" value='<?   echo $drop_table[$I][1]; ?>' />
            <input size="10" value='<?   echo $drop_table[$I][2]; ?>'
      name="rate[]" /></td>
        <td width="28%" align="center" bordercolor="cccccc" ><input  size="10" value='<?   echo $drop_table[$I][3]; ?>'
      name="ratedrop[]" /></td>
        <td width="27%" align="center" bordercolor="cccccc"><input  size="10" value='<?   echo $drop_table[$I][4]; ?>'
      name="low_drop[]" /></td>
      </tr>
    
      <? 
} ?>
  <tr >
        <td colspan="4" align="center" bordercolor="cccccc" ><button onclick="submit()"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:80;height:22" ;><img src="images/icon_21x21_copy.gif" align="absmiddle" />确认修改</button>
      <button onclick="javascript:location.reload();"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="width:60;height:22" ;><img src="images/icon_21x21_info.gif" align="absmiddle" />刷新</button></td>
      </tr>
    </tbody></form >
  </table>

