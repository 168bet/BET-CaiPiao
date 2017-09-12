<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'templates/offGamenc.php';
$ConfigModel = configModel("`g_nc_game_lock`, `g_mix_money`");
if ($ConfigModel['g_nc_game_lock'] !=1)exit(href('right.php'));
$onclick = 'onclick="getResult(this)" href="javascript:void(0)" ';

//获取当前盘口
	$name = base64_decode($_COOKIE['g_user']);
	$db=new DB();
	$sql = "SELECT g_panlu,g_panlus FROM g_user where g_name='$name' LIMIT 1";
	$result = $db->query($sql, 1);

 $pan = explode (',', $result[0]['g_panlus']); 

$_SESSION['cq'] = false;
$_SESSION['gx'] = false;
$_SESSION['jx'] = false;
$_SESSION['gd'] = false;
$_SESSION['nc'] = true;

$g = $_GET['g'];
$abc = $_GET['abc'];
if($abc==null) {$abc=$result[0]['g_panlu'];
}else{
$sql = "update g_user set g_panlu='$abc' where g_name='$name'";
$result1 = $db->query($sql, 2);
}

markPos("前台-幸运农场下注-数字盘");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/sGame.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/sc.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="./js/odds_sz_nc.js"></script>
<title></title>
<script type="text/javascript">
var s = window.parent.frames.leftFrame.location.href.split('/');
		s = s[s.length-1];
		if (s !== "left.php")
			window.parent.frames.leftFrame.location.href = "/templates/left.php";
			
			
function soundset(sod){
if(sod.value=="on"){
sod.src="images/soundoff.png";
sod.value="off";
}
else{
sod.src="images/soundon.png";
sod.value="on";
}
SetCookie("soundbut",sod.value);
}
</script>
<style type="text/css">
div#row1 { float: left;  }
div#row2 { }
</style>
</head>
<body>
<table class="thsz" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table height="50">
        <tr>
          <td  height="20" colspan="2" class="bolds">幸运农场</td>
          <td width="60" class="bolds" align="right"><!--<img id='soundbut' name='soundbut' src="images/soundon.png" width="27" height="19" value='on' onclick="soundset(this);" title="开奖音开关"/>--></td>
          <td colspan="3" class="bolds" align="left"><span id="number" style="font-size:14px;position:relative; top:1px"></span>期開獎        </td>
          <td colspan="2" align="left" class="bolds" style="color:#FF0000"><div  id="row1" style="position: relative; filter: blur(add=1, direction=45, strength=3); FONT-FAMILY: Arial; height: 15px; color: red; font-size: 10pt;">
<span>今天輸贏：</span></div><div id="row2"><span id="sy" style="font-size:14px;position:relative; top:-2px">0</span></div></td>
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
        <td><span style="color:#0033FF; font-weight:bold" id="tys">數字盤</span></td>
        <td><form id="form1" name="form1" method="post" action="">
         <!--   <label><span style="color:#0033FF; font-weight:bold" id="tys">
			<script>
			function changepan(sel){
			window.parent.frames.mainFrame.location.href = "sGame_sz_nc.php?g=<?php echo$g?>&abc="+sel.value;
			}
			
			</script>
            <select name="abc" style="width:75px" onchange="changepan(this)">
			<?php   
			for($i=0;$i<count($pan);$i++){
			if($pan[$i]!=""){
			if($abc==$pan[$i]){
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
           </label>-->
      </form></td>
       <td width="85"></td>
        <td>距離封盤：<span style="font-size:104%" id="endTime">加載中...</span></td>
        <td colspan="6">距離開獎：<span style="color:red;font-size:104%" id="endTimes">加載中...</span></td>
        <td colspan="2" align="right"><span id="endTimea"></span>秒</td>
    </tr>
</table>
<form id="dp" action="" method="post" target="leftFrame" onsubmit = "return submitforms()">
<input type="hidden" name="actions" value="fn3" />
<input type="hidden" name="gtypes" value="1" />
<input type="hidden" id="mix" value="<?php echo$ConfigModel['g_mix_money']?>" />
<table class="wqsz" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption" style="color:#000">
    	<td colspan="3">第一球</td>
    	<td colspan="2">第二球</td>
    	<td colspan="2">第三球</td>
    	<td colspan="2">第四球</td>
		<td colspan="2">第五球</td>
    	<td colspan="2">第六球</td>
    	<td colspan="2">第七球</td>
    	<td colspan="2">第八球</td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc1">1</div></td>
    	<td class="o" width="45" id="ah1"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh1"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch1"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh1"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh1"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh1"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh1"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh1"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc2">2</div></td>
    	<td class="o" width="45" id="ah2"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh2"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch2"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh2"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh2"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh2"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh2"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh2"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc3">3</div></td>
    	<td class="o" width="45" id="ah3"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh3"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch3"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh3"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh3"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh3"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh3"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh3"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc4">4</div></td>
    	<td class="o" width="45" id="ah4"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh4"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch4"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh4"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh4"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh4"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh4"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh4"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc5">5</div></td>
    	<td class="o" width="45" id="ah5"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh5"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch5"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh5"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh5"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh5"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh5"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh5"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc6">6</div></td>
    	<td class="o" width="45" id="ah6"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh6"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch6"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh6"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh6"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh6"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh6"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh6"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc7">7</div></td>
    	<td class="o" width="45" id="ah7"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh7"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch7"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh7"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh7"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh7"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh7"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh7"></td>
    	<td class="loads"></td>
    </tr>
    <tr class="t_td_text">
    	<td><div class="nc8">8</div></td>
    	<td class="o" width="45" id="ah8"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh8"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch8"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh8"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh8"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh8"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh8"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh8"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc9">9</div></td>
    	<td class="o" width="45" id="ah9"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh9"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch9"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh9"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh9"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh9"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh9"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh9"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc10">10</div></td>
    	<td class="o" width="45" id="ah10"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh10"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch10"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh10"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh10"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh10"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh10"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh10"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc11">11</div></td>
    	<td class="o" width="45" id="ah11"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh11"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch11"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh11"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh11"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh11"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh11"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh11"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc12">12</div></td>
    	<td class="o" width="45" id="ah12"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh12"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch12"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh12"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh12"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh12"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh12"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh12"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc13">13</div></td>
    	<td class="o" width="45" id="ah13"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh13"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch13"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh13"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh13"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh13"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh13"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh13"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc14">14</div></td>
    	<td class="o" width="45" id="ah14"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh14"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch14"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh14"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh14"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh14"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh14"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh14"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc15">15</div></td>
    	<td class="o" width="45" id="ah15"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh15"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch15"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh15"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh15"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh15"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh15"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh15"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc16">16</div></td>
    	<td class="o" width="45" id="ah16"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh16"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch16"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh16"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh16"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh16"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh16"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh16"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc17">17</div></td>
    	<td class="o" width="45" id="ah17"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh17"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch17"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh17"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh17"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh17"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh17"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh17"></td>
    	<td class="loads"></td>
    </tr>
	 <tr class="t_td_text">
    	<td><div class="nc18">18</div></td>
    	<td class="o" width="45" id="ah18"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh18"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch18"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh18"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh18"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh18"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh18"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh18"></td>
    	<td class="loads"></td>
    </tr> 
	<tr class="t_td_text">
    	<td><div class="nc19">19</div></td>
    	<td class="o" width="45" id="ah19"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh19"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch19"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh19"></td>
    	<td class="loads"></td>
		<td class="o" width="45" id="eh19"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh19"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh19"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh19"></td>
    	<td class="loads"></td>
    </tr> 
	<tr class="t_td_text">
    	<td><div class="nc20">20</div></td>
    	<td class="o" width="45" id="ah20"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="bh20"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="ch20"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="dh20"></td>
    	<td class="loads"></td>
   		<td class="o" width="45" id="eh20"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="fh20"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="gh20"></td>
    	<td class="loads"></td>
    	<td class="o" width="45" id="hh20"></td>
    	<td class="loads"></td>
	</tr>
</table>
<table border="0" width="860">
	<tr height="30">
    	<td align="right" style="padding-right:10px"><input type="button" onclick="reset()" class="inputs ti" value="重填" /></td>
        <td align="left" style="padding-left:10px"><input type="submit" id="submits" class="inputs ti" value="下註" /></td>
        <td width="0" class="actiionn"></td>
    </tr>
</table>
</form>
<br />
<table class="wqsz" border="0" cellpadding="0" cellspacing="1">
	<tr class="t_list_caption">
        <td><a class="nv_a" <?php echo $onclick?>>第1球</a></td>
       <td><a class="nv" <?php echo $onclick?>>第2球</a></td>
        <td><a class="nv" <?php echo $onclick?>>第3球</a></td>
       <td><a class="nv" <?php echo $onclick?>>第4球</a></td>
	   <td><a class="nv" <?php echo $onclick?>>第5球</a></td>
	   <td><a class="nv" <?php echo $onclick?>>第6球</a></td>
	   <td><a class="nv" <?php echo $onclick?>>第7球</a></td>
	   <td><a class="nv" <?php echo $onclick?>>第8球</a></td>
    </tr>
    <tr>
    	<td colspan="8" class="t_td_text" align="center">
        	<table class="hj" border="0" cellpadding="0" cellspacing="1">
            	<tr class="t_td_text" id="z_cl"><td></td></tr>
            </table>
        </td>
    </tr>
</table>
<div id="look" style="display:none"></div>
<?php include_once 'inc/cl_filesz.php';?>
<?php 
$name = base64_decode($_COOKIE['g_user']);
$db = new DB();
$text =$db->query("SELECT g_text FROM g_set_user_news WHERE g_name = '{$name}' LIMIT 1", 0);
if ($text){
	alert($text[0][0]);
}
?>
</body>
</html>