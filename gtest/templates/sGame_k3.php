<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'templates/offGamek3.php';
$ConfigModel = configModel("`g_k3_game_lock`, `g_mix_money`,`g_game_k3_1`");
if ($ConfigModel['g_k3_game_lock'] !=1)exit(href('right.php'));
$onclick = 'onclick="getResult(this)" href="javascript:void(0)" ';
$_SESSION['cq'] = false;
$_SESSION['nc'] = false;
//获取当前盘口
	$name = base64_decode($_COOKIE['g_user']);
	$db=new DB();
	$sql = "SELECT g_panlu,g_panlus FROM g_user where g_name='$name' LIMIT 1";
	$result = $db->query($sql, 1);

 $pan = explode(',', $result[0]['g_panlus']); 
$_SESSION['cq'] = false;
$_SESSION['gx'] = false;
$_SESSION['jx'] = false;
$_SESSION['gd'] = false;
$_SESSION['pk'] = false;
$_SESSION['k3'] = true;


$g = $_GET['g'];
$abc = $_GET['abc'];
if($abc==null) {$abc=$result[0]['g_panlu'];
}else{
$sql = "update g_user set g_panlu='$abc' where g_name='$name'";
$result1 = $db->query($sql, 2);
}
switch ($g) {
	case 'g11':
		if ($ConfigModel['g_game_k3_1'] !=1)exit(href('right.php'));
		$types = '大小骰寶';
		$aHtml = '<a '.$getResult.'>大小骰寶</a>';
		break;
	default:exit;
}

markPos("前台-快3下注-$types");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/sGame.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/sc.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="./js/odds_k3.js"></script>
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
<table class="th" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="105" height="28" class="bolds">江苏骰寶(快3)　　　</td>
    <td colspan="3" class="bolds" style="color:red"><div  id="row1" style="position: relative; filter: blur(add=1, direction=45, strength=3); FONT-FAMILY: Arial; height: 15px; color: red; font-size: 10pt;"> <span>今天輸贏：</span></div>
      <div id="row2"><span id="sy" style="font-size:14px;position:relative; top:-2px">0</span></div></td>
    <td colspan="5"></td>
    <td width="36" ></td>
    <td width="24" ><img id='soundbut' name='soundbut' src="images/soundon.png" width="27" height="19" value='on' onclick="soundset(this);" title="开奖音开关" style="display:none"/></td>
    <td width="140"  class="bolds" ><span id="number" style="font-size:14px;position:relative; top:1px"></span>期開獎 </td>
    <td width="28" class="No_" id="a"></td>
    <td width="27" class="No_" id="b"></td>
    <td width="27" class="No_" id="c"></td>
  </tr>
  <tr>
    <td height="30"><span id="o" style=" color:#009900; font-weight:bold; font-size:14px;position:relative; top:1px"></span>期</td>
    <td width="100" align="center"><span style="color:#0033FF; font-weight:bold" id="tys">大小骰寶</span></td>
    <td colspan="2"><form id="form1" name="form1" method="post" action="">
     <!--   <label><span style="color:#0033FF; font-weight:bold" id="tys">
        <script>
			function changepan(sel){
			window.parent.frames.mainFrame.location.href = "sGame_k3.php?g=<?php echo$g?>&abc="+sel.value;
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
    <td width="150" align="right">距離封盤：<span style="font-size:104%" id="endTime">加載中...</span></td>
    <td colspan="8"  align="center">距離開獎：<span style="color:red;font-size:104%" id="endTimes">加載中...</span> </td>
    <td colspan="2" align="right"><span id="endTimea"></span>秒</td>
  </tr>
</table>
<form id="dp" action="" method="post" target="leftFrame" onsubmit = "return submitforms()">
  <input type="hidden" name="actions" value="fn3" />
  <input type="hidden" name="gtypes" value="1" />
  <input type="hidden" id="mix" value="<?php echo$ConfigModel['g_mix_money']?>" />
  <table class="wq" border="0" cellpadding="0" cellspacing="1">
    <tr class="t_list_caption" style="color:#000">
      <td colspan="12"><strong>三軍【賠率說明：一同骰＝(賠率-1)×1、二同骰＝(賠率-1)×2、三同骰＝(賠率-1)×3】、大小</strong></td>
    </tr>
    <tr class="t_td_text">
      <td width="27" class="No_k31"></td>
      <td class="o" width="45" id="ah1"></td>
      <td class="tt" id="t1_h1"></td>
      <td width="27" class="No_k32">&nbsp;</td>
      <td class="o" width="45" id="ah2"></td>
      <td class="tt" id="t1_h2"></td>
      <td width="27" class="No_k33">&nbsp;</td>
      <td class="o" width="45" id="ah3"></td>
      <td class="tt" id="t1_h3"></td>
      <td width="57" class="caption_1">大</td>
      <td class="o" width="45" id="ah7"></td>
      <td class="tt" id="t1_h7"></td>
    </tr>
    <tr class="t_td_text">
      <td width="27" class="No_k34"></td>
      <td class="o" width="45" id="ah4"></td>
      <td class="tt" id="t1_h4"></td>
      <td width="27" class="No_k35">&nbsp;</td>
      <td class="o" width="45" id="ah5"></td>
      <td class="tt" id="t1_h5"></td>
      <td width="27" class="No_k36">&nbsp;</td>
      <td class="o" width="45" id="ah6"></td>
      <td class="tt" id="t1_h6"></td>
      <td width="57" class="caption_1">小</td>
      <td class="o" width="45" id="ah8"></td>
      <td class="tt" id="t1_h8"></td>
    </tr>
  </table>
  <table class="wq" border="0" cellpadding="0" cellspacing="1">
    <tr class="t_list_caption" style="color:#000">
      <td colspan="9"><strong>圍骰、全骰</strong></td>
    </tr>
    <tr class="t_td_text">
      <td width="83"><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_1.gif" complete="complete"/></td>
      <td class="o" width="45" id="bh1"></td>
      <td class="tt" id="t2_h1"></td>
      <td width="83"><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_2.gif" complete="complete"/></td>
      <td class="o" width="45" id="bh2"></td>
      <td class="tt" id="t2_h2"></td>
      <td width="83"><img width="27" src="/templates/images/4_3.gif" complete="complete"/><img width="27" src="/templates/images/4_3.gif" complete="complete"/><img width="27" src="/templates/images/4_3.gif" complete="complete"/></td>
      <td class="o" width="45" id="bh3"></td>
      <td class="tt" id="t2_h3"></td>
    </tr>
    <tr class="t_td_text">
      <td width="83"><img width="27" src="/templates/images/4_4.gif" complete="complete"/><img width="27" src="/templates/images/4_4.gif" complete="complete"/><img width="27" src="/templates/images/4_4.gif" complete="complete"/></td>
      <td class="o" width="45" id="bh4"></td>
      <td class="tt" id="t2_h4"></td>
      <td width="83"><img width="27" src="/templates/images/4_5.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/></td>
      <td class="o" width="45" id="bh5"></td>
      <td class="tt" id="t2_h5"></td>
      <td width="83"><img width="27" src="/templates/images/4_6.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="bh6"></td>
      <td class="tt" id="t2_h6"></td>
    </tr>
    <tr class="t_td_text">
      <td>全骰</td>
      <td class="o" width="45" id="bh7"></td>
      <td class="tt" id="t2_h7"></td>
      <td class="tt" colspan="6"></td>
    </tr>
  </table>
  <table class="wq" border="0" cellpadding="0" cellspacing="1">
    <tr class="t_list_caption" style="color:#000">
      <td colspan="12"><strong>點數</strong></td>
    </tr>
    <tr class="t_td_text">
      <td width="57" class="caption_1">4點</td>
      <td class="o" width="45" id="qh1"></td>
      <td class="tt" id="t3_h1"></td>
      <td width="57" class="caption_1">5點</td>
      <td class="o" width="45" id="qh2"></td>
      <td class="tt" id="t3_h2"></td>
      <td width="57" class="caption_1">6點</td>
      <td class="o" width="45" id="qh3"></td>
      <td class="tt" id="t3_h3"></td>
      <td width="57" class="caption_1">7點</td>
      <td class="o" width="45" id="qh4"></td>
      <td class="tt" id="t3_h4"></td>
    </tr>
    <tr class="t_td_text">
      <td width="57" class="caption_1">8點</td>
      <td class="o" width="45" id="qh5"></td>
      <td class="tt" id="t3_h5"></td>
      <td width="57" class="caption_1">9點</td>
      <td class="o" width="45" id="qh6"></td>
      <td class="tt" id="t3_h6"></td>
      <td width="57" class="caption_1">10點</td>
      <td class="o" width="45" id="qh7"></td>
      <td class="tt" id="t3_h7"></td>
      <td width="57" class="caption_1">11點</td>
      <td class="o" width="45" id="qh8"></td>
      <td class="tt" id="t3_h8"></td>
    </tr>
    <tr class="t_td_text">
      <td width="57" class="caption_1">12點</td>
      <td class="o" width="45" id="qh9"></td>
      <td class="tt" id="t3_h9"></td>
      <td width="57" class="caption_1">13點</td>
      <td class="o" width="45" id="qh10"></td>
      <td class="tt" id="t3_h10"></td>
      <td width="57" class="caption_1">14點</td>
      <td class="o" width="45" id="qh11"></td>
      <td class="tt" id="t3_h11"></td>
      <td width="57" class="caption_1">15點</td>
      <td class="o" width="45" id="qh12"></td>
      <td class="tt" id="t3_h12"></td>
    </tr>
    <tr class="t_td_text">
      <td width="57" class="caption_1">16點</td>
      <td class="o" width="45" id="qh13"></td>
      <td class="tt" id="t3_h13"></td>
      <td width="57" class="caption_1">17點</td>
      <td class="o" width="45" id="qh14"></td>
      <td class="tt" id="t3_h14"></td>
      <td colspan="6" class="caption_1"></td>
    </tr>
  </table>
  <table class="wq" border="0" cellpadding="0" cellspacing="1">
    <tr class="t_list_caption" style="color:#000">
      <td colspan="9"><strong>長牌</strong></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_2.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh1"></td>
      <td class="tt" id="t4_h1"></td>
      <td width="83" ><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_3.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh2"></td>
      <td class="tt" id="t4_h2"></td>
      <td width="83" ><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_4.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh3"></td>
      <td   class="tt" id="t4_h3"></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh4"></td>
      <td class="tt" id="t4_h4"></td>
      <td width="83" ><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh5"></td>
      <td class="tt" id="t4_h5"></td>
      <td width="83" ><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_3.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh6"></td>
      <td  class="tt" id="t4_h6"></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_4.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh7"></td>
      <td class="tt" id="t4_h7"></td>
      <td width="83" ><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh8"></td>
      <td class="tt" id="t4_h8"></td>
      <td width="83" ><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh9"></td>
      <td   class="tt" id="t4_h9"></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_3.gif" complete="complete"/><img width="27" src="/templates/images/4_4.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh10"></td>
      <td class="tt" id="t4_h10"></td>
      <td width="83" ><img width="27" src="/templates/images/4_3.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh11"></td>
      <td class="tt" id="t4_h11"></td>
      <td width="83" ><img width="27" src="/templates/images/4_3.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh12"></td>
      <td   class="tt" id="t4_h12"></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_4.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh13"></td>
      <td class="tt" id="t4_h13"></td>
      <td width="83" ><img width="27" src="/templates/images/4_4.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh14"></td>
      <td class="tt" id="t4_h14"></td>
      <td width="83" ><img width="27" src="/templates/images/4_5.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="lh15"></td>
      <td   class="tt" id="t4_h15"></td>
    </tr>
    <tr class="t_list_caption" style="color:#000">
      <td colspan="9"><strong>短牌</strong></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_1.gif" complete="complete"/><img width="27" src="/templates/images/4_1.gif" complete="complete"/></td>
      <td class="o" width="45" id="dh1"></td>
      <td class="tt" id="t5_h1"></td>
      <td width="83" ><img width="27" src="/templates/images/4_2.gif" complete="complete"/><img width="27" src="/templates/images/4_2.gif" complete="complete"/></td>
      <td class="o" width="45" id="dh2"></td>
      <td class="tt" id="t5_h2"></td>
      <td width="83" ><img width="27" src="/templates/images/4_3.gif" complete="complete"/><img width="27" src="/templates/images/4_3.gif" complete="complete"/></td>
      <td class="o" width="45" id="dh3"></td>
      <td class="tt" id="t5_h3"></td>
    </tr>
    <tr class="t_td_text">
      <td width="83" ><img width="27" src="/templates/images/4_4.gif" complete="complete"/><img width="27" src="/templates/images/4_4.gif" complete="complete"/></td>
      <td class="o" width="45" id="dh4"></td>
      <td class="tt" id="t5_h4"></td>
      <td width="83" ><img width="27" src="/templates/images/4_5.gif" complete="complete"/><img width="27" src="/templates/images/4_5.gif" complete="complete"/></td>
      <td class="o" width="45" id="dh5"></td>
      <td class="tt" id="t5_h5"></td>
      <td width="83" ><img width="27" src="/templates/images/4_6.gif" complete="complete"/><img width="27" src="/templates/images/4_6.gif" complete="complete"/></td>
      <td class="o" width="45" id="dh6"></td>
      <td class="tt" id="t5_h6"></td>
    </tr>
  </table>
  <table border="0" width="700">
    <tr height="30">
      <td align="right" style="padding-right:10px"><input type="button" onclick="reset()" class="inputs ti" value="重填" /></td>
      <td align="left" style="padding-left:10px"><input type="submit" id="submits" class="inputs ti" value="下註" /></td>
      <td width="0" class="actiionn"></td>
    </tr>
  </table>
</form>
<br />
<div id="look" style="display:none"></div>
<div class="pop" stype="display:none">
<table bgcolor="#e9ba84" border="0" cellpadding="0" cellspacing="1" width="167" id="cl">
</table>
</div>
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
