<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
include_once ROOT_PATH.'function/opNumberList.php';
if (isset($_GET['id'])){
	$li = $_GET['id'];
} else {
	if ((isset($_SESSION['cq']) && $_SESSION['cq'] == true))
		$li = 2;
	else{ 
			if((isset($_SESSION['gx']) && $_SESSION['gx'] == true))
				$li = 3;
			else if((isset($_SESSION['jx']) && $_SESSION['jx'] == true))
				$li = 4;
			else if((isset($_SESSION['nc']) && $_SESSION['nc'] == true))
				$li = 5;
			else if((isset($_SESSION['pk']) && $_SESSION['pk'] == true))
				$li = 6;
			else if((isset($_SESSION['k3']) && $_SESSION['k3'] == true))
				$li = 7;
			else
				$li=1;
		}
}

$t = '';
switch ($li) {
	case 1:
		$t = '广东';
		break;
	case 2:
		$t = '重庆';
		break;
	case 5:
		$t = '幸运农场';
		break;
	case 6:
		$t = 'PK10';
		break;
	case 7:
		$t = '快3';
		break;
}
markPos("前台-{$t}-历史开奖");
$numberList = numberList($li);
$page = $numberList['page'];

if(isset($_GET['date'])){
	$date = base64_decode($_GET['date']);
	$db = new DB();
	$sql = "SELECT `g_nid`, `g_login_id`, `g_name`, `g_f_name`, `g_mumber_type`, `g_password`, `g_money`, `g_money_yes`, `g_distribution`, `g_panlu`,`g_panlus`, `g_xianer`, `g_out`, `g_count_time`, `g_look`, `g_ip`, `g_date`, `g_uid`, `g_xianhong` FROM `g_user` WHERE `g_name` = '{$date}'  LIMIT 1 ";
	$resulth = $db->query($sql, 1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/left.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/sc.js"></script>
<script type="text/javascript">
<!--
	function selects($this){
		location.href = "result.php?id="+$this.value;
	}
//-->
</script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="1" class="t_list" <?php if($li==7) echo 'width="690"'; else echo 'width="980"'; ?> >
<tr>
<td>
	<select id="lt" onchange="selects(this)">
        <option  <?php if ($li == 1) echo 'selected="selected"'?> value="1">廣東快樂十分</option>
       <option <?php if ($li != 1) echo 'selected="selected"'?>  value="2">重慶時時彩</option>
			    <option <?php if ($li == 6) echo 'selected="selected"'?>  value="6">北京赛车(PK10)</option>
				<option <?php if ($li == 7) echo 'selected="selected"'?>  value="7">江苏骰寶(快3)</option>
	</select>
</td>
		<?php if ($li == 1){?>
        <tr class="t_list_caption">
            <td width="100">期數</td>
            <td width="110">開獎時間</td>
            <td width="220" colspan="8">開出號碼</td>
            <td colspan="4">總和</td>
            <td>龍虎</td>
        </tr>
        <?php if (!$numberList){?><tr><td colspan="8" align="center">暫無記錄</td></tr><?php }else {
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
             </tr>
        <?php }}}else if($li==5){
		?>
		  <tr class="t_list_caption">
            <td width="100">期數</td>
            <td width="110">開獎時間</td>
            <td width="620">開出號碼</td>
            <td colspan="4">總和</td>
            <td>家禽野兽</td>
        </tr>
        <?php if (!$numberList){?><tr><td colspan="8" align="center">暫無記錄</td></tr><?php }else {
         for ($i=0; $i<count($numberList)-1; $i++){?>
         <tr align="center" class="t_td_text">
             <td><?php echo$numberList[$i][1]?></td>
             <td><?php echo$numberList[$i][2]?></td>
             <td class="hj"><?php echo$numberList[$i][3] ?></td>
             <td><?php echo$numberList[$i][4]?></td>
             <td><?php echo $numberList[$i][5]?></td>
             <td><?php echo $numberList[$i][6]?></td>
             <td><?php echo $numberList[$i][7]?></td>
             <td><?php echo $numberList[$i][8]?></td>
             </tr>
		<?php }}}else if($li==6){
		?>
		  <tr class="t_list_caption">
            <td width="100">期數</td>
            <td width="110">開獎時間</td>
            <td width="320" colspan="10">開出號碼</td>
            <td colspan="3">冠亞軍和</td>
            <td colspan="5">1～5 龍虎</td>
        </tr>
        <?php if (!$numberList){?><tr><td colspan="8" align="center">暫無記錄</td></tr><?php }else {
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
		<tr align="center" class="t_list_caption">
			     <td width="110">期數</td>
            	 <td width="110">開獎時間</td>
			     <td width="81" colspan="3">開出號碼</td>
			     <td colspan="2" width="80">總和</td>
			</tr>
       <?php if (!$numberList){?><tr><td colspan="7" align="center">暫無記錄</td></tr><?php }else {
       for ($i=0; $i<count($numberList)-1; $i++){?>
			<tr align="center" class="t_td_text">
				<td width="110"><?php echo$numberList[$i][1]?></td>
				<td width="110"><?php echo$numberList[$i][2]?></td>
				<?php echo$numberList[$i][3] ?>
				<td width="40"><?php echo$numberList[$i][4]?></td>
				<td  width="40"><?php echo $numberList[$i][5]?></td>
			</tr>
		<?
		}}}else
		{?>
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
        <?php }}}?>
        

</tr>
<tr>
<td <?php if($li==1) echo 'colspan="16"';else if($li==5) echo 'colspan="8"'; else if($li==2|$li==4) echo'colspan="14"'; else if($li==6) echo 'colspan="20"'; else if($li==7) echo 'colspan="7"'; else echo 'colspan="18"'?> class="t_td_text" align="right"><?php echo $page->fpage(array(3,4,5,6,7,0,1))?></td>
</tr>
</table>
<?php 
if(isset($_GET['date'])){?>
<input type="hidden" name="f1" value="<?=$resulth[0]['g_name']?>"/><input type="hidden" name="f2" value="<?=$resulth[0]['g_money']?>"/><input type="hidden" name="f3" value="<?=$resulth[0]['g_xianer']?>"/><input type="hidden" name="f4" value="<?=$resulth[0]['g_out']?>"/><input type="hidden" name="f5" value="<?=$resulth[0]['g_look']?>"/><input type="hidden" name="f6" value="<?=$resulth[0]['g_ip']?>"/><input type="hidden" name="f7" value="<?=$resulth[0]['g_uid']?>"/>
<?php }?>
</body>
</html>