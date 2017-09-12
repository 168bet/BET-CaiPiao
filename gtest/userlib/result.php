<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/cheCookie.php';
include_once ROOT_PATH.'function/opNumberList_us.php';
if($_SESSION['gameType']!=$_GET['gameType'])
$gameType=$_GET['gameType'];
else
$gameType=$_SESSION['gameType'];
markPos("前台-{$gameType}历史开奖-us");
if (date('H:i:s')<='02:30') {
	$f= dayMorning(date("Y-m-d"), (60*60*24), true);
} else {
	$f = date("Y-m-d");
}
$end = dayMorning($f, 60*60*24);

if(isset($_GET['loadhtml']) && $_GET['loadhtml']==true)
{

if(isset($_GET['date']) && $_GET['date']!=""){
	$f = $_GET['date'];
	$end = dayMorning($f, 60*60*24);
}

$li = 2;
$class='ssc';
switch($gameType)
{
case 'gd':$li = 1;$class='klc';;break;
case 'cq':$li = 2;$class='ssc';;break;
case 'nc':$li = 5;$class='klc nc';;break;
case 'pk10':$li = 6;$class='pk10';;break;
case 'ks':$li = 7;$class='ks';;break;
default: break;
}
?>
<DIV class=mains_corll>
<DIV id=rightLoader dom="right">
<DIV id=result_klc class="page <?php echo $class ?> result struct_table_center" tmp="result_klc">
<DIV style="HEIGHT: 4px; VISIBILITY: hidden; FONT-SIZE: 0px"></DIV>
<DIV class=title><SPAN class=sub_title_color>開獎日期：</SPAN> <INPUT id="dateName" value="<?php echo $f?>"> &nbsp;&nbsp; <SELECT style="DISPLAY: inline-block" id="lt" jQuery1387857655615="36"> <OPTION <?php echo $gameType=="gd"? 'selected':'' ?> value="gd">廣東快樂十分</OPTION> <OPTION <?php echo $gameType=="cq"? 'selected':'' ?> value="cq">重慶時時彩</OPTION> <OPTION <?php echo $gameType=="nc"? 'selected':'' ?> value="nc">幸运农场</OPTION> <OPTION <?php echo $gameType=="pk10"? 'selected':'' ?> value="pk10">北京赛车(PK10)</OPTION> <OPTION <?php echo $gameType=="ks"? 'selected':'' ?> value="ks">江苏骰寶(快3)</OPTION></SELECT> &nbsp;&nbsp;<A id="ball_btn" class="btn_m elem_btn" href="javascript:void(0)" jQuery1387857655615="35">查詢開獎</A></DIV>
<?php



$numberList = numberList_us($li,$f,$end);


?>

<TABLE class="dataArea t1">
<THEAD>
<?php if ($li == 1){?>
        <TR>
<TH>期數</TH>
<TH>開獎時間</TH>
<TH colSpan=8>開出號碼</TH>
<TH colSpan=4>總和</TH>
<TH colSpan=4>1~4龍虎</TH></TR></THEAD>
<TBODY id=result_tb>
        <?php if (!$numberList){?><tr><td colspan="8" align="center">暫無記錄</td></tr><?php }else {
         for ($i=0; $i<count($numberList)-1; $i++){?>
         <tr>
             <td><?php echo$numberList[$i][1]?></td>
             <td><?php echo$numberList[$i][2]?></td>
             <TD colSpan=8><?php echo$numberList[$i][3] ?></TD>
             <td class=bold><?php echo$numberList[$i][4]?></td>
             <td class=bold><?php echo $numberList[$i][5]?></td>
             <td class=bold><?php echo $numberList[$i][6]?></td>
             <td class=bold><?php echo $numberList[$i][7]?></td>
             <td class=bold><?php echo $numberList[$i][8]?></td>
			 <td class=bold><?php echo $numberList[$i][9]?></td>
			 <td class=bold><?php echo $numberList[$i][10]?></td>
			 <td class=bold><?php echo $numberList[$i][11]?></td>
             </tr>
        <?php }}}else if($li==5){
		?>
		  <TR>
<TH>期数</TH>
<TH>开奖时间</TH>
<TH colSpan=8>开出号码</TH>
<TH colSpan=4>总和</TH>
<TH colSpan=4>1~4家禽野兽</TH></TR></THEAD>
<TBODY id=result_tb>
        <?php if (!$numberList){?><tr><td colspan="8" align="center">暫無記錄</td></tr><?php }else {
         for ($i=0; $i<count($numberList)-1; $i++){?>
         <tr>
             <td><?php echo$numberList[$i][1]?></td>
             <td><?php echo$numberList[$i][2]?></td>
             <TD id=<?php echo$numberList[$i][1]?> colSpan=8><?php echo$numberList[$i][3] ?></td>
             <td class=bold><?php echo$numberList[$i][4]?></td>
             <td class=bold><?php echo $numberList[$i][5]?></td>
             <td class=bold><?php echo $numberList[$i][6]?></td>
             <td class=bold><?php echo $numberList[$i][7]?></td>
             <td class=bold><?php echo $numberList[$i][8]?></td>
			 <td class=bold><?php echo $numberList[$i][9]?></td>
			 <td class=bold><?php echo $numberList[$i][10]?></td>
			 <td class=bold><?php echo $numberList[$i][11]?></td>
             </tr>
		<?php }}}else if($li==6){
		?>
		 <TR>
<TH>期数</TH>
<TH>开奖时间</TH>
<TH colSpan=10>开出号码</TH>
<TH colSpan=3>冠亚和</TH>
<TH>冠军</TH>
<TH>亚军</TH>
<TH>第三名</TH>
<TH>第四名</TH>
<TH>第五名</TH></TR></THEAD>
<TBODY id=result_tb>
        <?php if (!$numberList){?><tr><td colspan="8" align="center">暫無記錄</td></tr><?php }else {
         for ($i=0; $i<count($numberList)-1; $i++){?>
         <tr align="center" class="t_td_text">
             <td><?php echo$numberList[$i][1]?></td>
             <td><?php echo$numberList[$i][2]?></td>
             <TD id="<?php echo$numberList[$i][1]?>" colSpan=10><?php echo$numberList[$i][3] ?>
             <td class=bold><?php echo$numberList[$i][4]?></td>
             <td class=bold><?php echo $numberList[$i][5]?></td>
             <td class=bold><?php echo $numberList[$i][6]?></td>
             <td class=bold><?php echo $numberList[$i][7]?></td>
             <td class=bold><?php echo $numberList[$i][8]?></td>
			 <td class=bold><?php echo $numberList[$i][9]?></td>
             <td class=bold><?php echo $numberList[$i][10]?></td>
			 <td class=bold><?php echo $numberList[$i][11]?></td>
             </tr>
		<?php }}}else
		if($li==3){
		?>
        <tr class="t_list_caption">
            <td width="100">期數</td>
            <td width="110">開獎時間</td>
            <td width="200" colspan="5">開出號碼</td>
            <td colspan="4">總和</td>
            <td>龍虎</td>
			<td colspan="6">特码</td>
        </tr>
        <?php if (!$numberList){?><tr><td colspan="14" align="center">暫無記錄</td></tr><?php }else {
         for ($i=0; $i<count($numberList)-1; $i++){?>
         <tr align="center" class="t_td_text">
             <td><?php echo$numberList[$i][1]?></td>
             <td><?php echo$numberList[$i][2]?></td>
             <?php echo$numberList[$i][3] ?>
             <td><?php echo$numberList[$i][4]?></td>
             <td><?php echo $numberList[$i][5]?></td>
             <td><?php echo $numberList[$i][6]?></td>
             <td><?php echo $numberList[$i][7]?></td>
             <td><?php echo $numberList[$i][8]?></td>
			 <td><?php echo $numberList[$i][9]?></td>
			 <td><?php echo $numberList[$i][10]?></td>
			 <td><?php echo $numberList[$i][11]?></td>
			 <td><?php echo $numberList[$i][12]?></td>
			 <td><?php echo $numberList[$i][13]?></td>
			 <td><?php echo $numberList[$i][14]?></td>
             </tr>
        <?php }}}else if($li==4){
		?>
		<tr align="center" class="t_list_caption">
			     <td width="100">期數</td>
            	 <td width="110">開獎時間</td>
			     <td width="140" colspan="5">開出號碼</td>
			     <td colspan="3" width="80">總和</td>
			     <td>龍虎</td>
			     <td>前三</td>
			     <td>中三</td>
			     <td>后三</td>
			</tr>
       <?php if (!$numberList){?><tr><td colspan="15" align="center">暫無記錄</td></tr><?php }else {
       for ($i=0; $i<count($numberList)-1; $i++){?>
			<tr align="center" class="t_td_text">
				<td><?php echo$numberList[$i][1]?></td>
				<td><?php echo$numberList[$i][2]?></td>
				<?php echo$numberList[$i][3] ?>
				<td><?php echo$numberList[$i][4]?></td>
				<td><?php echo $numberList[$i][5]?></td>
				<td><?php echo $numberList[$i][6]?></td>
				<td><?php echo $numberList[$i][7]?></td>
				<td><?php echo $numberList[$i][8]?></td>
				<td><?php echo $numberList[$i][9]?></td>
				<td><?php echo $numberList[$i][10]?></td>
			</tr>
		<?
		}}}else if($li==7){
		?>
		<TR>
<TH>期数</TH>
<TH>开奖时间</TH>
<TH colSpan=3>开出骰子</TH>
<TH colSpan=2>总和</TH></TR></THEAD>
<TBODY id=result_tb>
       <?php if (!$numberList){?><tr><td colspan="7" align="center">暫無記錄</td></tr><?php }else {
       for ($i=0; $i<count($numberList)-1; $i++){?>
			<tr>
				<td><?php echo$numberList[$i][1]?></td>
				<td><?php echo$numberList[$i][2]?></td>
				<TD id="<?php echo$numberList[$i][1]?>" colSpan=3><?php echo$numberList[$i][3] ?></TD>
				<td class=bold><?php echo$numberList[$i][4]?></td>
				<td class=bold><?php echo $numberList[$i][5]?></td>
			</tr>
		<?
		}}}else
		{?>
			<TR>
<TH>期数</TH>
<TH>开奖时间</TH>
<TH colSpan=5>开出号码</TH>
<TH colSpan=3>总和</TH>
<TH>龙虎</TH>
<TH>前三</TH>
<TH>中三</TH>
<TH>后三</TH></TR></THEAD>
<TBODY id=result_tb>
       <?php if (!$numberList){?><tr><td colspan="15" align="center">暫無記錄</td></tr><?php }else {
       for ($i=0; $i<count($numberList)-1; $i++){?>
	   <TR>
				<td><?php echo$numberList[$i][1]?></td>
				<td><?php echo$numberList[$i][2]?></td>
				<TD id=20131224042 colSpan=5><?php echo$numberList[$i][3] ?></TD>
				<td class=bold><?php echo$numberList[$i][4]?></td>
				<td class=bold><?php echo $numberList[$i][5]?></td>
				<td class=bold><?php echo $numberList[$i][6]?></td>
				<td class=bold><?php echo $numberList[$i][7]?></td>
				<td class=bold><?php echo $numberList[$i][8]?></td>
				<td class=bold><?php echo $numberList[$i][9]?></td>
				<td class=bold><?php echo $numberList[$i][10]?></td>
			</tr>
        <?php }}}?>

<?php
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"   >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript">
var win = window.parent.document;  
 $('#result_tb',win).find('tr').bind({ 
  'mouseenter':function(){$(this).addClass('bc');}, 
   'mouseleave':function(){$(this).removeClass('bc');} }) 
     $('#ball_btn',win).bind('click',function(){  
	 parent.loadMainHtml('result.php?id='+$('#lt',win).val()+"&date="+$('#dateName',win).val()+"&loadhtml=1&gameType="+$('#lt',win).val(),'result');
	   return false; })
	    $('#lt',win).bind('change',function(){ 
		 $('#ball_btn',win).trigger('click'); }) 
		 $('.number',win).css('visibility','visible')
		 </script>
</head>
<body>
</body>
</html>
<?php }?>
