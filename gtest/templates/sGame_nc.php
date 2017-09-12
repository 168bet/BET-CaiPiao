<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/global.php';
$ConfigModel = configModel("`g_nc_game_lock`, `g_game_nc_1`, `g_game_nc_2`, `g_game_nc_3`, `g_game_nc_4`, `g_game_nc_5`, `g_game_nc_6`, `g_game_nc_7`, `g_game_nc_8`");
if ($ConfigModel['g_nc_game_lock'] !=1)
exit(href('right.php'));
$g = $_GET['g'];
$onclick = 'onclick="getResult(this)" href="javascript:void(0)" ';
$getResult = 'class="nv_a" '.$onclick;

$_SESSION['cq'] = false;
$_SESSION['gx'] = false;
$_SESSION['jx'] = false;
$_SESSION['gd'] = false;
$_SESSION['nc'] = true;
//获取当前盘口
	$name = base64_decode($_COOKIE['g_user']);
	$db=new DB();
	$sql = "SELECT g_panlu,g_panlus FROM g_user where g_name='$name' LIMIT 1";
	$result = $db->query($sql, 1);

 $pan = explode (',', $result[0]['g_panlus']); 
 
 
 //$abc = $_GET['abc'];
//if($abc==null) $abc=$pan[0];
//$sql = "update g_user set g_panlu='$abc' where g_name='$name'";
//$result1 = $db->query($sql, 2);

switch ($g) {
	case 'g1':
		if ($ConfigModel['g_game_nc_1'] !=1)exit(href('right.php'));
		$types = '第一球';
		$aHtml = '<a '.$getResult.'>第1球</a>';
		break;
	case 'g2':
		if ($ConfigModel['g_game_nc_2'] !=1)exit(href('right.php'));
		$types = '第二球';
		$aHtml = '<a '.$getResult.'>第2球</a>';
		break;
	case 'g3':
		if ($ConfigModel['g_game_nc_3'] !=1)exit(href('right.php'));
		$types = '第三球';
		$aHtml = '<a '.$getResult.'>第3球</a>';
		break;
	case 'g4':
		if ($ConfigModel['g_game_nc_4'] !=1)exit(href('right.php'));
		$types = '第四球';
		$aHtml = '<a '.$getResult.'>第4球</a>';
		break;
	case 'g5':
		if ($ConfigModel['g_game_nc_5'] !=1)exit(href('right.php'));
		$types = '第五球';
		$aHtml = '<a '.$getResult.'>第5球</a>';
		break;
	case 'g6':
		if ($ConfigModel['g_game_nc_6'] !=1)exit(href('right.php'));
		$types = '第六球';
		$aHtml = '<a '.$getResult.'>第6球</a>';
		break;
	case 'g7':
		if ($ConfigModel['g_game_nc_7'] !=1)exit(href('right.php'));
		$types = '第七球';
		$aHtml = '<a '.$getResult.'>第7球</a>';
		break;
	case 'g8':
		if ($ConfigModel['g_game_nc_8'] !=1)exit(href('right.php'));
		$types = '第八球';
		$aHtml = '<a '.$getResult.'>第8球</a>';
		break;
	default:exit;
}

markPos("前台-幸运农场下注-$types");
?>
<?php include_once 'inc/topnc.php';?>
<table class="thsz" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table height="50">
        <tr>
          <td  height="20" colspan="2" class="bolds">幸运农场</td>
          <td width="60" class="bolds" align="right"><!--<img id='soundbut' name='soundbut' src="images/soundon.png" width="27" height="19" value='on' onclick="soundset(this);" title="开奖音开关"/>--></td>
          <td colspan="3" class="bolds" align="left"> <span id="n" style="font-size:14px;position:relative; top:1px"></span>期開獎</td>
          <td colspan="2" align="left" class="bolds" style="color:#FF0000"><div  id="row1" style="position: relative; filter: blur(add=1, direction=45, strength=3); FONT-FAMILY: Arial; height: 15px; color: red; font-size: 10pt;"> <span>今天輸贏：</span></div>            <div id="row2"><span id="sy" style="font-size:14px;position:relative; top:-2px">0</span></div></td>
        </tr>
        <tr>
           <td width="60"><div class="nc" id="a"></div></td>
          <td width="60"><div class="nc" id="b"></div></td>
          <td width="60"><div  class="nc" id="c"></div></td>
          <td width="60"><div class="nc" id="d"></div></td>
          <td width="60"><div  class="nc" id="e"></div></td>
          <td width="60"><div class="nc" id="f"></div></td>
          <td width="60"><div  class="nc" id="g"></div></td>
          <td width="60"><div  class="nc" id="h"></div></td>
        </tr>
    </table></td>
  </tr>
</table>
<table class="thsz" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td height="30"><span id="o" style=" color:#009900; font-weight:bold; font-size:14px;position:relative; top:1px"></span>期</td>
        <td width="52"><span style="color:#0033FF; font-weight:bold" id="tys"><?php echo$types?></span></td>
        <td width="114"><form id="form1" name="form1" method="post" action="selpan.php">
         <!--   <label><span style="color:#0033FF; font-weight:bold" id="tys">
			<script>
			function changepan(sel){
			document.form1.submit();
			}
			
			</script>
            <select name="abc" style="width:75px" onchange="changepan(this)">
			<?php   
			for($i=0;$i<count($pan);$i++){
			if($pan[$i]!=""){
			if($result[0]['g_panlu']==$pan[$i]){
			?>			
			<option value="<?php echo$pan[$i]?>" selected="selected"><?php echo$pan[$i]?>盘</option>
			<?php			
			}
			else{
			?>
			<option value="<?php echo$pan[$i]?>" ><?php echo$pan[$i]?>盘</option>			
			<?php	
			}		
			}
			}		
			?>
            </select>
           </label>
		   <input type="hidden" value="<?php echo$g?>" name="gp"/>
		   <input type="hidden" value="sGame_nc" name="gsrc"/>-->
      </form></td>
        <td width="32">&nbsp;</td>
        <td>距離封盤：<span style="font-size:104%" id="endTime">加載中...</span></td>
        <td colspan="6">距離開獎：<span style="color:red; font-size:104%" id="endTimes">加載中...</span></td>
        <td colspan="2" align="right"><span id="endTimea"></span>秒</td>
    </tr>
</table>
<input type="hidden" id="mix" value="<?php echo$ConfigModel['g_mix_money']?>"><div id="look" style="display:none"></div>
<form id="dp" action="" method="post" target="leftFrame">
<input type="hidden" name="actions" value="fn1" />
<input type="hidden" name="gtypes" value="1" />
<table class="wqsz" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption">
    	<td>號</td>
        <td>賠率</td>
        <td width="70">金額</td>
        <td>號</td>
        <td>賠率</td>
        <td width="70">金額</td>
        <td>號</td>
        <td>賠率</td>
        <td width="70">金額</td>
        <td>號</td>
        <td>賠率</td>
        <td width="70">金額</td>
    </tr>
    <tr class="t_td_text">
    	<td ><div class="nc1">1</div></td>
        <td class="o" id="h1"></td>
        <td class="tt" id="t1"></td>
        <td ><div class="nc6">6</div></td>
        <td class="o" id="h6"></td>
        <td class="tt" id="t6"></td>
        <td ><div class="nc11">11</div></td>
        <td class="o" id="h11"></td>
        <td class="tt" id="t11"></td>
        <td ><div class="nc16">16</div></td>
        <td class="o" id="h16"></td>
        <td class="tt" id="t16"></td>
    </tr>
    <tr class="t_td_text">
    	<td ><div class="nc2">2</div></td>
        <td class="o" id="h2"></td>
        <td class="tt" id="t2"></td>
        <td ><div class="nc7">7</div></td>
        <td class="o" id="h7"></td>
        <td class="tt" id="t7"></td>
        <td ><div class="nc12">12</div></td>
        <td class="o" id="h12"></td>
        <td class="tt" id="t12"></td>
        <td ><div class="nc17">17</div></td>
        <td class="o" id="h17"></td>
        <td class="tt" id="t17"></td>
    </tr>
    <tr class="t_td_text">
    	<td ><div class="nc3">3</div></td>
        <td class="o" id="h3"></td>
        <td class="tt" id="t3"></td>
        <td ><div class="nc8">8</div></td>
        <td class="o" id="h8"></td>
        <td class="tt" id="t8"></td>
        <td ><div class="nc13">13</div></td>
        <td class="o" id="h13"></td>
        <td class="tt" id="t13"></td>
        <td ><div class="nc18">18</div></td>
        <td class="o" id="h18"></td>
        <td class="tt" id="t18"></td>
    </tr>
    <tr class="t_td_text">
    	<td ><div class="nc4">4</div></td>
        <td class="o" id="h4"></td>
        <td class="tt" id="t4"></td>
        <td ><div class="nc9">9</div></td>
        <td class="o" id="h9"></td>
        <td class="tt" id="t9"></td>
        <td ><div class="nc14">14</div></td>
        <td class="o" id="h14"></td>
        <td class="tt" id="t14"></td>
        <td ><div class="nc19">19</div></td>
        <td class="o" id="h19"></td>
        <td class="tt" id="t19"></td>
    </tr>
    <tr class="t_td_text">
    	<td ><div class="nc5">5</div></td>
        <td class="o" id="h5"></td>
        <td class="tt" id="t5"></td>
        <td ><div class="nc10">10</div></td>
        <td class="o" id="h10"></td>
        <td class="tt" id="t10"></td>
        <td ><div class="nc15">15</div></td>
        <td class="o" id="h15"></td>
        <td class="tt" id="t15"></td>
        <td ><div class="nc20">20</div></td>
        <td class="o" id="h20"></td>
        <td class="tt" id="t20"></td>
    </tr>
</table>
<table class="wqsz" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_td_text">
    	<td width="50" class="caption_1">大</td>
        <td class="o" id="h21"></td>
        <td width="70" class="tt" id="t21"></td>
        <td width="50" class="caption_1">單</td>
        <td class="o" id="h23"></td>
        <td width="70" class="tt" id="t23"></td>
        <td width="50" class="caption_1">尾大</td>
        <td class="o" id="h25"></td>
        <td width="70" class="tt" id="t25"></td>
        <td width="50" class="caption_1">合數單</td>
        <td class="o" id="h27"></td>
        <td width="70" class="tt" id="t27"></td>
    </tr>
    <tr class="t_td_text">
    	<td width="50" class="caption_1">小</td>
        <td class="o" id="h22"></td>
        <td width="70" class="tt" id="t22"></td>
        <td width="50" class="caption_1">雙</td>
        <td class="o" id="h24"></td>
        <td width="70" class="tt" id="t24"></td>
        <td width="50" class="caption_1">尾小</td>
        <td class="o" id="h26"></td>
        <td width="70" class="tt" id="t26"></td>
        <td width="50" class="caption_1">合數雙</td>
        <td class="o" id="h28"></td>
        <td width="70" class="tt" id="t28"></td>
    </tr>
    <tr class="t_td_text">
    	<td width="50" class="caption_1"><strong><font color="#FF00FF">梅</font></strong></td>
        <td class="o" id="h29"></td>
        <td width="70" class="tt" id="t29"></td>
        <td width="50" class="caption_1"><strong><font color="#0000FF">兰</font></strong></td>
        <td class="o" id="h30"></td>
        <td width="70" class="tt" id="t30"></td>
        <td width="50" class="caption_1"><strong><font color="#FF6600">菊</font></strong></td>
        <td class="o" id="h31"></td>
        <td width="70" class="tt" id="t31"></td>
        <td width="50" class="caption_1"><strong><font color="#00FF00">竹</font></strong></td>
        <td class="o" id="h32"></td>
        <td width="70" class="tt" id="t32"></td>
    </tr>
    <tr class="t_td_text">
    	<td width="50" class="caption_1">中</td>
        <td class="o" id="h33"></td>
        <td width="70" class="tt" id="t33"></td>
        <td width="50" class="caption_1">發</td>
        <td class="o" id="h34"></td>
        <td width="70" class="tt" id="t34"></td>
        <td width="50" class="caption_1">白</td>
        <td class="o" id="h35"></td>
        <td width="70" class="tt" id="t35"></td>
        <td colspan="3"></td>
    </tr>
</table>
<table border="0" width="800">
	<tr height="30">
    	<td align="right" style="padding-right:10px"><input type="button" onClick="reset()" class="inputs ti" value="重填" /></td>
        <td align="left" style="padding-left:10px"><input type="submit" id="submits" class="inputs ti" value="下註" /></td>
        <td width="0" class="actiionn"></td>
    </tr>
</table>
</form>
<br />
<table class="wqsz" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption" style="color:#0066FF">
    	<th width="80">今天</th>
    	<th>01</th>
        <th>02</th>
        <th>03</th>
        <th>04</th>
        <th>05</th>
        <th>06</th>
        <th>07</th>
        <th>08</th>
        <th>09</th>
        <th>10</th>
        <th>11</th>
        <th>12</th>
        <th>13</th>
        <th>14</th>
        <th>15</th>
        <th>16</th>
        <th>17</th>
        <th>18</th>
        <th style="color:red">19</th>
        <th style="color:red">20</th>
    </tr>
    <tr class="t_td_text" id="su">
    	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr class="t_td_text" id="se">
    	<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
</table>
<table class="wqsz" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption">
    	<td><?php echo $aHtml?></td>
        <td><a class="nv" <?php echo $onclick?>>大小</a></td>
        <td><a class="nv" <?php echo $onclick?>>單雙</a></td>
        <td><a class="nv" <?php echo $onclick?>>尾數大小</a></td>
        <td><a class="nv" <?php echo $onclick?>>合數單雙</a></td>
        <td><a class="nv" <?php echo $onclick?>>梅兰菊竹</a></td>
        <td><a class="nv" <?php echo $onclick?>>中發白</a></td>
        <td><a class="nv" <?php echo $onclick?>>總和大小</a></td>
        <td><a class="nv" <?php echo $onclick?>>總和單雙</a></td>
        <td><a class="nv" <?php echo $onclick?>>總和尾數大小</a></td>
        <td><a class="nv" <?php echo $onclick?>>家禽野兽</a></td>
    </tr>
    <tr>
    	<td colspan="11" class="t_td_text" align="center">
        	<table class="hj" border="0" cellpadding="0" cellspacing="1">
            	<tr class="t_td_text" id="z_cl"><td></td></tr>
            </table>
        </td>
    </tr>
</table>
<?php include_once 'inc/cl_filesz.php';?>
<?php 
$db = new DB();
$text =$db->query("SELECT g_text FROM g_set_user_news WHERE g_name = '{$user[0]['g_name']}' LIMIT 1", 0);
if ($text){
	alert($text[0][0]);
}
?>
</body>
</html>