<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
$ConfigModel = configModel("`g_kg_game_lock`, `g_game_9`");
if ($ConfigModel['g_kg_game_lock'] !=1 || $ConfigModel['g_game_9'] !=1)exit(href('right.php'));
$types = '總和、龍虎';
$onclick = 'onclick="getResult(this)" href="javascript:void(0)" ';
$getResult = 'class="nv_a" '.$onclick;




//获取当前盘口
	$name = base64_decode($_COOKIE['g_user']);
	$db=new DB();
	$sql = "SELECT g_panlu,g_panlus FROM g_user where g_name='$name' LIMIT 1";
	$result = $db->query($sql, 1);

 $pan = explode (',', $result[0]['g_panlus']); 
 
 $gurl='sGame_l';
 $g = $_GET['g'];
 markPos("前台-广东下注-$types");
?>
<?php include_once 'inc/top.php';?>
<?php include_once 'inc/file.php';?>
<form id="dp" action="" method="post" target="leftFrame">
<input type="hidden" name="actions" value="fn1" />
<input type="hidden" name="gtypes" value="1" />
<table class="wq" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption">
    	<td width="120">項目</td>
        <td>賠率</td>
        <td>金額</td>
        <td width="120">項目</td>
        <td>賠率</td>
        <td>金額</td>
    </tr>
    <tr class="t_td_text">
    	<td class="caption_1">總和大</td>
        <td class="o" id="h1"></td>
        <td class="tt" id="t1"></td>
        <td class="caption_1">總和單</td>
        <td class="o" id="h2"></td>
        <td class="tt" id="t2"></td>
    </tr>
    <tr class="t_td_text">
    	<td class="caption_1">總和小</td>
        <td class="o" id="h3"></td>
        <td class="tt" id="t3"></td>
        <td class="caption_1">總和雙</td>
        <td class="o" id="h4"></td>
        <td class="tt" id="t4"></td>
    </tr>
    <tr class="t_td_text">
    	<td class="caption_1">總和尾大</td>
        <td class="o" id="h5"></td>
        <td class="tt" id="t5"></td>
        <td class="caption_1">龍</td>
        <td class="o" id="h6"></td>
        <td class="tt" id="t6"></td>
    </tr>
    <tr class="t_td_text">
    	<td class="caption_1">總和尾小</td>
        <td class="o" id="h7"></td>
        <td class="tt" id="t7"></td>
        <td class="caption_1">虎</td>
        <td class="o" id="h8"></td>
        <td class="tt" id="t8"></td>
    </tr>
</table>
<table border="0" width="700">
	<tr height="30">
    	<td align="right" style="padding-right:10px"><input type="button" onclick="reset()" class="inputs" value="重填" /></td>
        <td align="left" style="padding-left:10px"><input type="submit" id="submits" class="inputs" value="下註" /></td>
        <td width="0" class="actiionn"></td>
    </tr>
</table>
</form>
<br />
<table class="wq" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption">
        <td><a class="nv" <?php echo $onclick?>>總和大小</a></td>
        <td><a class="nv" <?php echo $onclick?>>總和單雙</a></td>
        <td><a class="nv" <?php echo $onclick?>>總和尾數大小</a></td>
        <td><a class="nv_a" <?php echo $onclick?>>龍虎</a></td>
    </tr>
    <tr>
    	<td colspan="4" class="t_td_text" align="center">
        	<table class="hj" border="0" cellpadding="0" cellspacing="1">
            	<tr class="t_td_text" id="z_cl"></tr>
            </table>
        </td>
    </tr>
</table>
<?php include_once 'inc/cl_file.php';?>
<?php 
$db = new DB();
$text =$db->query("SELECT g_text FROM g_set_user_news WHERE g_name = '{$user[0]['g_name']}' LIMIT 1", 0);
if ($text){
	alert($text[0][0]);
}
?>
</body>
</html>