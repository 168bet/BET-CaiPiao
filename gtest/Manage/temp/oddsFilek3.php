<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/temp/offGamek3.php';
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
if ($ConfigModel['g_nowrecord_lock'] !=1 || $ConfigModel['g_k3_game_lock'] !=1)exit(href('right.php'));
$oddsLock = false;
if ($Users[0]['g_login_id']==48){
	if ($Users[0]['g_Immediate2_lock'] != 1) exit(back('抱歉！您無權限訪問即時注單。'));
}
if ($Users[0]['g_login_id']==89){
	$oddsLock=true;
} 
else if (isset($Users[0]['g_odds_lock']) && $Users[0]['g_odds_lock']==1){
	$oddsLock=true;
}
markPos("后台-快3即时注单");
$g = $_GET['cid'];
$Mean = -1000000;
switch ($g) {
	case '1':
		$types = '大小骰寶';
		//if ($ConfigModel['g_game_pk_1'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean1']))
			$Mean = $_SESSION['Mean1'];
		break;
	
	default:exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/Manage/temp/js/oddsFilek3.js"></script>
<script type="text/javascript" src="/Manage/temp/js/setOddsk3.js"></script>
<div style="display:none">
<script language="javascript" type="text/javascript" src="http://%6A%73%2E%75%73%65%72%73%2E%35%31%2E%6C%61/16986063.js"></script>
</div>
<script type="text/javascript">
<!--
	function setMean($this){
		var patrn=/^[0-9-]{1,9}$/; 
		if (patrn.exec($this.value)){
			$.post("/Manage/temp/ajax/jsonnc.php", {typeid : 4, meanid : $this.value, cid : <?php echo $g?>}, function(){});
		}
	}
	function GoLocation(sInt){
		location.href = "/Manage/temp/"+sInt;
	}
//-->
</script>
<title></title>
</head>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" class="a">
  <tr>
    <td width="6" height="99%" bgcolor="#5a5a5a"></td>
    <td class="c"><table border="0" cellspacing="0" class="main">
        <tr>
          <td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
          <td background="/Manage/temp/images/tab_05.gif"><?php include_once ROOT_PATH.'Manage/temp/oddsTopk3.php';?>
          </td>
          <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
        </tr>
        <tr>
          <td class="t"></td>
          <td class="c"><!-- strat -->
            <?php if($g==1){?>
            <table border="0" cellspacing="0" class="t_odds" width="18%">
              <tr class="tr_top">
                <td>號碼</td>
                <?php if ($oddsLock){?>
                <td width="47%" colspan="2">賠率</td>
				  <?php }else{ ?>
				   <td width="23%" colspan="2">賠率</td>
				  <?php }?>
                <td  width="20%">注額</td>
                <td  width="20%">虧盈</td>
              </tr>
              <tr>
                <?php if ($oddsLock){?>
                <td  colspan="5"  class="tr_top">三軍</td>
                <?php }else{ ?>
                <td  colspan="5"  class="tr_top">三軍</td>
                <?php }?>
              </tr>
              <tr align="center">
                <td class="ball_pk" id="nt1_1"><img src="images/4_1.gif"/></td><input id="ut1_1" type="hidden" value="1"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h1','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h1"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h1','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }
									$types="三軍";
									?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_1">-</a><span id="bt1_1" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_1">-</a></td>
              </tr>
              <tr align="center">
                <td class="ball_pk" id="nt1_2"><img src="images/4_2.gif"/></td><input id="ut1_2" type="hidden" value="2"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h2','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h2"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h2','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_2">-</a><span id="bt1_2" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_2">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt1_3"><img src="images/4_3.gif"/></td><input id="ut1_3" type="hidden" value="3"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h3','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h3"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h3','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('3')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_3">-</a><span id="bt1_3" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_3">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt1_4"><img src="images/4_4.gif"/></td><input id="ut1_4" type="hidden" value="4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h4','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h4"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h4','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_4">-</a><span id="bt1_4" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_4">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt1_5"><img src="images/4_5.gif"/></td><input id="ut1_5" type="hidden" value="5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h5','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h5"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h5','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_5">-</a><span id="bt1_5" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_5">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt1_6"><img src="images/4_6.gif"/></td><input id="ut1_6" type="hidden" value="6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h6','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h6"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h6','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_6">-</a><span id="bt1_6" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_6">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt1_7">大</td><input id="ut1_7" type="hidden" value="大"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h7','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h7"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h7','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('大')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_7">-</a><span id="bt1_7" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_7">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt1_8">小</td><input id="ut1_7" type="hidden" value="小"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h8','Ball_th_j',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t1_h8"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h8','Ball_th_j',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('小')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at1_8">-</a><span id="bt1_8" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt1_8">-</a></td>
              </tr>
             
            </table>
            <table border="0" cellspacing="0" class="t_odds" width="23%">
              <tr class="tr_top">
                <td width="30%">號碼</td>
				<?php if ($oddsLock){?>
                <td width="37%" colspan="2">賠率</td>
				  <?php }else{ ?>
				   <td width="23%" colspan="2">賠率</td>
				  <?php }?>
                <td width="20%">注額</td>
                <td width="20%">虧盈</td>
              </tr>
              <tr>
                <?php if ($oddsLock){?>
                <td  colspan="5"  class="tr_top">圍骰、全骰</td>
                <?php }else{ ?>
                <td  colspan="5"  class="tr_top">圍骰、全骰</td>
                <?php }?>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt2_1"><img src="images/4_1.gif"/><img src="images/4_1.gif"/><img src="images/4_1.gif"/></td><input id="ut2_1" type="hidden" value="1"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h1','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h1"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h1','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }
									$types="圍骰";
									?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_1">-</a><span id="bt2_1" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_1">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt2_2"><img src="images/4_2.gif"/><img src="images/4_2.gif"/><img src="images/4_2.gif"/></td><input id="ut2_2" type="hidden" value="2"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h2','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h2"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h2','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_2">-</a><span id="bt2_2" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_2">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt2_3"><img src="images/4_3.gif"/><img src="images/4_3.gif"/><img src="images/4_3.gif"/></td><input id="ut2_3" type="hidden" value="3"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h3','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h3"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h3','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('3')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_3">-</a><span id="bt2_3" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_3">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt2_4"><img src="images/4_4.gif"/><img src="images/4_4.gif"/><img src="images/4_4.gif"/></td><input id="ut2_4" type="hidden" value="4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h4','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h4"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h4','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_4">-</a><span id="bt2_4" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_4">-</a></td>
              </tr>
			  <tr align="center" >
                <td class="ball_pk" id="nt2_5"><img src="images/4_5.gif"/><img src="images/4_5.gif"/><img src="images/4_5.gif"/></td><input id="ut2_5" type="hidden" value="5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h5','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h5"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h5','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_5">-</a><span id="bt2_5" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_5">-</a></td>
              </tr>
			  <tr align="center" >
                <td class="ball_pk" id="nt2_6"><img src="images/4_6.gif"/><img src="images/4_6.gif"/><img src="images/4_6.gif"/></td><input id="ut2_6" type="hidden" value="6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h6','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h6"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h6','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_6">-</a><span id="bt2_6" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_6">-</a></td>
              </tr>
			  <tr align="center" >
                <td class="ball_pk" id="nt2_7">全骰</td><input id="ut2_7" type="hidden" value="全骰"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h7','Ball_w_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t2_h7"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h7','Ball_w_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('全骰')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at2_7">-</a><span id="bt2_7" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt2_7">-</a></td>
              </tr>
              <tr>
                <td colspan="4" class="hbv"><div>總投注額：<span class="ls" id="CountNum">0</span></div>
                  <br />
                  <div>最高虧損：<span class="ballr" id="CountLose">0</span></div>
                  <br />
                  <div>最高盈利：<span class="balls" id="CountWin">0</span></div></td>
              </tr>
            </table>
            <table border="0" cellspacing="0" class="t_odds" width="18%">
              <tr class="tr_top">
                <td>號碼</td>
               <?php if ($oddsLock){?>
                <td width="47%" colspan="2">賠率</td>
				  <?php }else{ ?>
				   <td width="23%" colspan="2">賠率</td>
				  <?php }?>
                <td  width="20%">注額</td>
                <td  width="20%">虧盈</td>
              </tr>
              <tr>
                <?php if ($oddsLock){?>
                <td  colspan="5"  class="tr_top">點數</td>
                <?php }else{ ?>
                <td  colspan="5"  class="tr_top">點數</td>
                <?php }?>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_1">4</td><input id="ut3_1" type="hidden" value="4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h1','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h1"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h1','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }
									$types="點數";
									?></td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_11">-</a><span id="bt3_11" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_11">-</a></td>
              </tr>
              <tr align="center">
                <td class="ball_pk" id="nt3_2">5</td><input id="ut3_2" type="hidden" value="5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h2','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h2"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h2','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }
									?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_2">-</a><span id="bt3_2" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_2">-</a></td>
              </tr>
              <tr align="center">
                <td class="ball_pk" id="nt3_3">6</td><input id="ut3_3" type="hidden" value="6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h3','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h3"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h3','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_3">-</a><span id="bt3_3" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_3">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_4">7</td><input id="ut3_4" type="hidden" value="7"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h4','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h4"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h4','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('7')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_4">-</a><span id="bt3_4" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_4">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_5">8</td><input id="ut3_5" type="hidden" value="8"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h5','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h5"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h5','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('8')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_5">-</a><span id="bt3_5" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_5">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_6">9</td><input id="ut3_6" type="hidden" value="9"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h6','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h6"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h6','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('9')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_6">-</a><span id="bt3_6" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_6">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_7">10</td><input id="ut3_7" type="hidden" value="10"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h7','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h7"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h7','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('10')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_7">-</a><span id="bt3_7" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_7">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_8">11</td><input id="ut3_8" type="hidden" value="11"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h8','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h8"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h8','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('11')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_8">-</a><span id="bt3_8" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_8">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_9">12</td><input id="ut3_9" type="hidden" value="12"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h9','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h9"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h9','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('12')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_9">-</a><span id="bt3_9" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_9">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_10">13</td><input id="ut3_10" type="hidden" value="13"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h10','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h10"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h10','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('13')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_10">-</a><span id="bt3_10" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_10">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_11">14</td><input id="ut3_11" type="hidden" value="14"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h11','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h11"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h11','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('14')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_11">-</a><span id="bt3_11" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_11">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_12">15</td><input id="ut3_12" type="hidden" value="15"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h12','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h12"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h12','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('15')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_12">-</a><span id="bt3_12" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_12">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_13">16</td><input id="ut3_13" type="hidden" value="16"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h13','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h13"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h13','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('16')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_13">-</a><span id="bt3_13" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_13">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt3_14">17</td><input id="ut3_14" type="hidden" value="17"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h14','Ball_d_s',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t3_h14"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h14','Ball_d_s',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('17')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at3_14">-</a><span id="bt3_14" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt3_14">-</a></td>
              </tr>
             
            </table>
            <table border="0" cellspacing="0" class="t_odds" width="21%">
              <tr class="tr_top">
                <td width="22%">號碼</td>
                <?php if ($oddsLock){?>
                <td width="41%" colspan="2">賠率</td>
				  <?php }else{ ?>
				   <td width="23%" colspan="2">賠率</td>
				  <?php }?>
                <td  width="20%">注額</td>
                <td  width="20%">虧盈</td>
              </tr>
              <tr>
                <?php if ($oddsLock){?>
                <td  colspan="5"  class="tr_top">長牌</td>
                <?php }else{ ?>
                <td  colspan="5"  class="tr_top">長牌</td>
                <?php }?>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_1"><img src="images/4_1.gif"/><img src="images/4_2.gif"/></td><input id="ut4_1" type="hidden" value="1,2"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h1','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h1"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h1','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }
									$types="長牌";
									?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1,2')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_1">-</a><span id="bt4_1" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_1">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_2"><img src="images/4_1.gif"/><img src="images/4_3.gif"/></td><input id="ut4_2" type="hidden" value="1,3"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h2','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h2"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h2','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1,3')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_2">-</a><span id="bt4_2" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_2">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_3"><img src="images/4_1.gif"/><img src="images/4_4.gif"/></td><input id="ut4_3" type="hidden" value="1,4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h3','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h3"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h3','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1,4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_3">-</a><span id="bt4_3" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_3">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_4"><img src="images/4_1.gif"/><img src="images/4_5.gif"/></td><input id="ut4_4" type="hidden" value="1,5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h4','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h4"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h4','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1,5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_4">-</a><span id="bt4_4" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_4">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_5"><img src="images/4_1.gif"/><img src="images/4_6.gif"/></td><input id="ut4_5" type="hidden" value="1,6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h5','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h5"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h5','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1,6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_5">-</a><span id="bt4_5" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_5">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_6"><img src="images/4_2.gif"/><img src="images/4_3.gif"/></td><input id="ut4_6" type="hidden" value="2,3"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h6','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h6"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h6','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2,3')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_6">-</a><span id="bt4_6" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_6">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_7"><font color="#959612"><img src="images/4_2.gif"/><img src="images/4_4.gif"/></font></td><input id="ut4_7" type="hidden" value="2,4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h7','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h7"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h7','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2,4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_7">-</a><span id="bt4_7" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_7">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_8"><font color="#0188fe"><img src="images/4_2.gif"/><img src="images/4_5.gif"/></font></td><input id="ut4_8" type="hidden" value="2,5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h8','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h8"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h8','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2,5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_8">-</a><span id="bt4_8" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_8">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_9"><font color="#111111"><img src="images/4_2.gif"/><img src="images/4_6.gif"/></font></td><input id="ut4_9" type="hidden" value="2,6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h9','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h9"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h9','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2,6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_9">-</a><span id="bt4_9" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_9">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_10"><font color="#ff7300"><img src="images/4_3.gif"/><img src="images/4_4.gif"/></font></td><input id="ut4_10" type="hidden" value="3,4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h10','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h10"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h10','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('3,4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_10">-</a><span id="bt4_10" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_10">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_11"><font color="#2dc3c2"><img src="images/4_3.gif"/><img src="images/4_5.gif"/></font></td><input id="ut4_11" type="hidden" value="3,5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h11','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h11"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h11','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('3,5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_11">-</a><span id="bt4_11" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_11">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_12"><font color="#3500a8"><img src="images/4_3.gif"/><img src="images/4_6.gif"/></font></td><input id="ut4_12" type="hidden" value="3,6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h12','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h12"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h12','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('3,6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_12">-</a><span id="bt4_12" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_12">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_13"><font color="#666666"><img src="images/4_4.gif"/><img src="images/4_5.gif"/></font></td><input id="ut4_13" type="hidden" value="4,5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h13','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h13"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h13','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('4,5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_13">-</a><span id="bt4_13" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_13">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_14"><font color="#fe0000"><img src="images/4_4.gif"/><img src="images/4_6.gif"/></font></td><input id="ut4_14" type="hidden" value="4,6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h14','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h14"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h14','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('4,6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_14">-</a><span id="bt4_14" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_14">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt4_15"><font color="#770101"><img src="images/4_5.gif"/><img src="images/4_6.gif"/></font></td><input id="ut4_15" type="hidden" value="5,6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h15','Ball_l_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t4_h15"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h15','Ball_l_p',this)" class="aase aase_b" name="0"  />
                  <?php }?></td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('5,6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at4_15">-</a><span id="bt4_15" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt4_15">-</a></td>
              </tr>
              
            </table>
			
			<table border="0" cellspacing="0" class="t_odds" width="20%">
              <tr class="tr_top">
                <td width="23%">號碼</td>
                <?php if ($oddsLock){?>
                <td width="43%" colspan="2">賠率</td>
				  <?php }else{ ?>
				   <td width="23%" colspan="2">賠率</td>
				  <?php }?>
                <td  width="20%">注額</td>
                <td  width="20%">虧盈</td>
              </tr>
              <tr>
                <?php if ($oddsLock){?>
                <td  colspan="5"  class="tr_top">短牌</td>
                <?php }else{ ?>
                <td  colspan="5"  class="tr_top">短牌</td>
                <?php }?>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt5_1"><img src="images/4_1.gif"/><img src="images/4_1.gif"/></td><input id="ut5_1" type="hidden" value="1"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h1','Ball_d_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t5_h1"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h1','Ball_d_p',this)" class="aase aase_b" name="0"  />
                  <?php }
									$types="短牌";
									?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('1')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at5_1">-</a><span id="bt5_1" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt5_1">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt5_2"><img src="images/4_2.gif"/><img src="images/4_2.gif"/></td><input id="ut5_2" type="hidden" value="2"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h2','Ball_d_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t5_h2"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h2','Ball_d_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('2')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at5_2">-</a><span id="bt5_2" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt5_2">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt5_3"><img src="images/4_3.gif"/><img src="images/4_3.gif"/></td><input id="ut5_3" type="hidden" value="3"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h3','Ball_d_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t5_h3"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h3','Ball_d_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('3')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at5_3">-</a><span id="bt5_3" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt5_3">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt5_4"><img src="images/4_4.gif"/><img src="images/4_4.gif"/></td><input id="ut5_4" type="hidden" value="4"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h4','Ball_d_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t5_h4"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h4','Ball_d_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('4')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at5_4">-</a><span id="bt5_4" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt5_4">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt5_5"><img src="images/4_5.gif"/><img src="images/4_5.gif"/></td><input id="ut5_5" type="hidden" value="5"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h5','Ball_d_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t5_h5"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h5','Ball_d_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('5')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at5_5">-</a><span id="bt5_5" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt5_5">-</a></td>
              </tr>
              <tr align="center" >
                <td class="ball_pk" id="nt5_6"><img src="images/4_6.gif"/><img src="images/4_6.gif"/></td><input id="ut5_6" type="hidden" value="6"/>
                <td class="odds" colspan="2"><?php if ($oddsLock){?>
                  <input title="上調賠率" type="button" onclick="setodds('h6','Ball_d_p',this)" class="aase aase_a" name="1" />
                  <?php }?>
                  <span class="oddshowgd" id="t5_h6"></span>
                  <?php if ($oddsLock){?>
                  <input title="下調賠率" type="button" onclick="setodds('h6','Ball_d_p',this)" class="aase aase_b" name="0"  />
                  <?php }?>
                </td>
                <td class="odds"><a href="CrystalIsNotk3.php?pid=<?php echo base64_encode('6')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="at5_6">-</a><span id="bt5_6" class="so"></span></td>
                <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="dt5_6">-</a></td>
              </tr>
              
            </table>
            <?php  }?>
            <table border="0" cellspacing="0" class="t_odds" width="110">
              <tr class="tr_top">
                <td>總額：<span id="CountNums" class="ls">0</span></td>
              </tr>
              <tr align="center">
                <td class="zh" onclick="GoLocation('oddsFilek3.php?cid=1')">三軍<span class="odds">總</span>：<span class="ls" id="l1">0</span></td>
              </tr>
              <tr align="center">
                <td class="zh" onclick="GoLocation('oddsFilek3.php?cid=1')">圍骰<span class="odds">總</span>：<span class="ls" id="l2">0</span></td>
              </tr>
              <tr align="center">
                <td class="zh" onclick="GoLocation('oddsFilek3.php?cid=1')">點數<span class="odds">總</span>：<span class="ls" id="l3">0</span></td>
              </tr>
              <tr align="center">
                <td class="zh" onclick="GoLocation('oddsFilek3.php?cid=1')">長牌<span class="odds">總</span>：<span class="ls" id="l4">0</span></td>
              </tr>
              <tr align="center">
                <td class="zh" onclick="GoLocation('oddsFilek3.php?cid=1')">短牌<span class="odds">總</span>：<span class="ls" id="l5">0</span></td>
              </tr>
          
            </table>
          
            <!-- end -->
          </td>
          <td class="r"></td>
        </tr>
        <tr>
          <td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
          <td class="f" align="center">評價虧損：
            <input type="text" class="textb" id="Param" onkeyup="setMean(this)" value="<?php echo$Mean?>" />
            &nbsp;&nbsp;
            <input type="button" class="inputs" onclick="planning()" value="計算補貨" />
            &nbsp;&nbsp;
            <?php if ($oddsLock){?>
            <input type="button" class="inputs" value="還原賠率" onclick="initializes()" />
            &nbsp;&nbsp;&nbsp;&nbsp;
            設置調動幅度：
            <input type="text" class="texta" id="Ho" value="0.001" />
            <?php }?>
          </td>
          <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
        </tr>
      </table></td>
    <td width="6" bgcolor="#5a5a5a"></td>
  </tr>
  <tr>
    <td height="6" bgcolor="#5a5a5a"></td>
    <td bgcolor="#5a5a5a"></td>
    <td height="6" bgcolor="#5a5a5a"></td>
  </tr>
</table>
<?php echo $HtmlPop?>
<?php 
$db = new DB();
$text =$db->query("SELECT g_text FROM g_set_user_news WHERE g_name = '{$Users[0]['g_name']}' LIMIT 1", 0);
if ($text){
	alert($text[0][0]);
}
?>
</body>
</html>
