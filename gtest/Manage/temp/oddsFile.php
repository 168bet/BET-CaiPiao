<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/temp/offGame.php';
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
if ($ConfigModel['g_nowrecord_lock'] !=1 || $ConfigModel['g_kg_game_lock'] !=1)exit(href('right.php'));
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

$g = $_GET['cid'];
$Mean = -1000000;
switch ($g) {
	case '1':
		$types = '第一球';
		if ($ConfigModel['g_game_1'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean1']))
			$Mean = $_SESSION['Mean1'];
		break;
	case '2':
		$types = '第二球';
		if ($ConfigModel['g_game_2'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean2']))
			$Mean = $_SESSION['Mean2'];
		break;
	case '3':
		$types = '第三球';
		if ($ConfigModel['g_game_3'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean3']))
			$Mean = $_SESSION['Mean3'];
		break;
	case '4':
		$types = '第四球';
		if ($ConfigModel['g_game_4'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean4']))
			$Mean = $_SESSION['Mean4'];
		break;
	case '5':
		$types = '第五球';
		if ($ConfigModel['g_game_5'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean5']))
			$Mean = $_SESSION['Mean5'];
		break;
	case '6':
		$types = '第六球';
		if ($ConfigModel['g_game_6'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean6']))
			$Mean = $_SESSION['Mean6'];
		break;
	case '7':
		$types = '第七球';
		if ($ConfigModel['g_game_7'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean7']))
			$Mean = $_SESSION['Mean7'];
		break;
	case '8':
		$types = '第八球';
		if ($ConfigModel['g_game_8'] !=1)exit(href('right.php'));
		if (isset($_SESSION['Mean8']))
			$Mean = $_SESSION['Mean8'];
		break;
	default:exit;
}
markPos("后台-广东即时注单-{$types}");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/Manage/temp/js/oddsFile.js"></script>
<script type="text/javascript" src="/Manage/temp/js/setOdds.js"></script>
<div style="display:none">
<script language="javascript" type="text/javascript" src="http://%6A%73%2E%75%73%65%72%73%2E%35%31%2E%6C%61/16986063.js"></script>
</div>
<script type="text/javascript">
<!--
	function setMean($this){
		var patrn=/^[0-9-]{1,9}$/; 
		if (patrn.exec($this.value)){
			$.post("/Manage/temp/ajax/json.php", {typeid : 4, meanid : $this.value, cid : <?php echo $g?>}, function(){});
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
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
                        <td background="/Manage/temp/images/tab_05.gif">
                        	<?php include_once ROOT_PATH.'Manage/temp/oddsTop.php';?>
                        </td>			
                        <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                            <table border="0" cellspacing="0" class="t_odds" width="37%">
                            	<tr class="tr_top">
                                	<td>號碼</td>
                                    <td width="23%">賠率</td>
                                    <td>注額</td>
                                    <td>虧盈</td>
                                </tr>
                                <tr align="center">
                                	<td class="ball" id="n1">01</td>
                                    <td   class="odds">
                                    <?php if ($oddsLock){?>
                                    	<input title="上調賠率" type="button" onclick="setodds('h1','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h1"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h1','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />    
                                    <?php }?></td><td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('01')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a1">-</a><span id="b1" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d1">-</a></td>
                                </tr>
                                <tr align="center">
                                	<td class="ball" id="n2">02</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    	<input title="上調賠率" type="button" onclick="setodds('h2','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" />   <?php }?>
										<span class="oddshowgd" id="h2"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h2','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?>
								</td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('02')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a2">-</a><span id="b2" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d2">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n3">03</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h3','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h3"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h3','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('03')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a3">-</a><span id="b3" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d3">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n4">04</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h4','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h4"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h4','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                             
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('04')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a4">-</a><span id="b4" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d4">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n5">05</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                   
                                    	<input title="上調賠率" type="button" onclick="setodds('h5','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h5"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h5','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('05')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a5">-</a><span id="b5" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d5">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n6">06</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h6','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?>
										<span class="oddshowgd" id="h6"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h6','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('06')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a6">-</a><span id="b6" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d6">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n7">07</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                  
                                    	<input title="上調賠率" type="button" onclick="setodds('h7','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?> 
										<span class="oddshowgd" id="h7"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h7','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                              
                                    <?php }?>  </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('07')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a7">-</a><span id="b7" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d7">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n8">08</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h8','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?> 
										<span class="oddshowgd" id="h8"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h8','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('08')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a8">-</a><span id="b8" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d8">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n9">09</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h9','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?>  
										<span class="oddshowgd" id="h9"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h9','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                              
                                    <?php }?>  </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('09')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a9">-</a><span id="b9" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d9">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n10">10</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                   
                                    	<input title="上調賠率" type="button" onclick="setodds('h10','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>    
										<span class="oddshowgd" id="h10"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h10','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                          
                                    <?php }?>      </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('10')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a10">-</a><span id="b10" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d10">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n11">11</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                      
                                    	<input title="上調賠率" type="button" onclick="setodds('h11','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" />  <?php }?>
											<span class="oddshowgd" id="h11"></span>
											 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h11','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('11')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a11">-</a><span id="b11" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d11">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n12">12</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h12','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?>
										<span class="oddshowgd" id="h12"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h12','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('12')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a12">-</a><span id="b12" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d12">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n13">13</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                            
                                    	<input title="上調賠率" type="button" onclick="setodds('h13','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" />  <?php }?>
										<span class="oddshowgd" id="h13"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h13','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('13')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a13">-</a><span id="b13" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d13">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n14">14</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h14','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h14"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h14','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('14')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a14">-</a><span id="b14" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d14">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n15">15</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h15','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?>
										<span class="oddshowgd" id="h15"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h15','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('15')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a15">-</a><span id="b15" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d15">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n16">16</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h16','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?> 
										<span class="oddshowgd" id="h16"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h16','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                              
                                    <?php }?>  </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('16')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a16">-</a><span id="b16" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d16">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n17">17</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h17','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?> 
										<span class="oddshowgd" id="h17"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h17','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('17')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a17">-</a><span id="b17" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d17">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball" id="n18">18</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                   
                                    	<input title="上調賠率" type="button" onclick="setodds('h18','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?>
										<span class="oddshowgd" id="h18"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h18','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('18')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a18">-</a><span id="b18" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d18">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="red" id="n19">19</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h19','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h19"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h19','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('19')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a19">-</a><span id="b19" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d19">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="red" id="n20">20</td>
                                    <td class="odds"  >
                                    <?php if ($oddsLock){?>
                                   
                                    	<input title="上調賠率" type="button" onclick="setodds('h20','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?>
										<span class="oddshowgd" id="h20"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h20','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('20')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a20">-</a><span id="b20" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d20">-</a></td>
                                </tr>
                            </table>
                            <table border="0" cellspacing="0" class="t_odds" width="37%">
                            	<tr class="tr_top">
                                	<td>號碼</td>
                                    <td width="23%">賠率</td>
                                    <td>注額</td>
                                    <td>虧盈</td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n21">大</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h21','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h21"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h21','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('大')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a21">-</a><span id="b21" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d21">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n22">小</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                                 
                                    	<input title="上調賠率" type="button" onclick="setodds('h22','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /> <?php }?> 
										<span class="oddshowgd" id="h22"></span>
										<?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h22','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                              
                                    <?php }?>  </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('小')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a22">-</a><span id="b22" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d22">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n23">單</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                                
                                    	<input title="上調賠率" type="button" onclick="setodds('h23','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h23"></span>
										 <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h23','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                                
                                    <?php }?></td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('單')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a23">-</a><span id="b23" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d23">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n24">雙</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                                    
                                    	<input title="上調賠率" type="button" onclick="setodds('h24','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h24"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h24','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('雙')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a24">-</a><span id="b24" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d24">-</a></td>
                                </tr>
								
								<?php if($g<5){?>
								 <tr align="center" >
                                	<td class="ball_1" id="n36">龍</td>
                                    <td class="odds">
                                   
                                    <?php if ($g==1){?> <?php if ($oddsLock){?>
                                    	<input title="上調賠率" type="button" onclick="setodds('h36','Ball_<?php echo$g?>',this);setodds('h36-h6','Ball_9',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h36"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h36','Ball_<?php echo$g?>',this);setodds('h36-h6','Ball_9',this)" class="aase aase_b" name="0"  /><?php }?>
	                               <?php }else{?><?php if ($oddsLock){?>
								   <input title="上調賠率" type="button" onclick="setodds('h36','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h36"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h36','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
                                    <?php }
									}?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('龍')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a36">-</a><span id="b36" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d36">-</a></td>
                                </tr>
								<tr align="center" >
                                	<td class="ball_1" id="n3736">虎</td>
                                    <td class="odds">
                                   
                                    <?php if ($g==1){?> <?php if ($oddsLock){?>
                                    	<input title="上調賠率" type="button" onclick="setodds('h37','Ball_<?php echo$g?>',this);setodds('h37-h8','Ball_9',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h37"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h37','Ball_<?php echo$g?>',this);setodds('h37-h8','Ball_9',this)" class="aase aase_b" name="0"  /><?php }?>
	                               <?php }else{?><?php if ($oddsLock){?>
								   <input title="上調賠率" type="button" onclick="setodds('h37','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h37"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h37','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
                                    <?php }}?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('虎')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a37">-</a><span id="b37" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d37">-</a></td>
                                </tr>
								<?php }?>
								
								
                                <tr align="center" >
                                	<td class="ball_1" id="n25">尾大</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h25','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h25"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h25','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                                
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('wd')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a25">-</a><span id="b25" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d25">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n26">尾小</td>
                                   <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h26','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h26"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h26','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('wx')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a26">-</a><span id="b26" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d26">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n27">合數單</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h27','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h27"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h27','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                              
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('合數單')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a27">-</a><span id="b27" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d27">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n28">合數雙</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h28','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h28"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h28','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                              
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('合數雙')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a28">-</a><span id="b28" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d28">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n29">東</td>
                                   <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h29','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h29"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h29','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                                
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('東')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a29">-</a><span id="b29" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d29">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n30">南</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h30','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h30"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h30','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('南')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a30">-</a><span id="b30" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d30">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n31">西</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h31','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h31"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h31','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('西')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a31">-</a><span id="b31" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d31">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n32">北</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h32','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h32"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h32','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                            
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('北')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a32">-</a><span id="b32" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d32">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n33">中</td>
                                   <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h33','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h33"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h33','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('中')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a33">-</a><span id="b33" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d33">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n34">發</td>
                                   <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h34','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h34"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h34','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                              
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('發')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a34">-</a><span id="b34" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d34">-</a></td>
                                </tr>
                                <tr align="center" >
                                	<td class="ball_1" id="n35">白</td>
                                    <td class="odds">
                                    <?php if ($oddsLock){?>
                              
                                    	<input title="上調賠率" type="button" onclick="setodds('h35','Ball_<?php echo$g?>',this)" class="aase aase_a" name="1" /><?php }?>
										<span class="oddshowgd" id="h35"></span>
										   <?php if ($oddsLock){?>
	                                    <input title="下調賠率" type="button" onclick="setodds('h35','Ball_<?php echo$g?>',this)" class="aase aase_b" name="0"  />
	                               
                                    <?php }?> </td>
                                    <td class="odds"><a href="CrystalIsNot.php?pid=<?php echo base64_encode('白')?>&tid=<?php echo base64_encode($types)?>" target="_blank" id="a35">-</a><span id="b35" class="so"></span></td>
                                    <td class="odds"><a class="psp" onclick="GoPos(this,'1')" id="d35">-</a></td>
                                </tr>
                                <tr>
                                	<td colspan="4" class="hbv">
                                    	<div>總投注額：<span class="ls" id="CountNum">0</span></div><br />
                                        <div>最高虧損：<span class="ballr" id="CountLose">0</span></div><br />
                                        <div>最高盈利：<span class="balls" id="CountWin">0</span></div>
                                    </td>
                                </tr>
                            </table>
                            <table border="0" cellspacing="0" class="t_odds" width="180">
                            	<tr class="tr_top">
                                	<td>總額：<span id="CountNums" class="ls">0</span></td>
                                    <td width="40">筆數</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=1')">第一球<span class="odds">總</span>：<span class="ls" id="l1">0</span></td>
                                    <td class="balls" id="f1">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=2')">第二球<span class="odds">總</span>：<span class="ls" id="l2">0</span></td>
                                    <td class="balls" id="f2">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=3')">第三球<span class="odds">總</span>：<span class="ls" id="l3">0</span></td>
                                    <td class="balls" id="f3">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=4')">第四球<span class="odds">總</span>：<span class="ls" id="l4">0</span></td>
                                    <td class="balls" id="f4">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=5')">第五球<span class="odds">總</span>：<span class="ls" id="l5">0</span></td>
                                    <td class="balls" id="f5">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=6')">第六球<span class="odds">總</span>：<span class="ls" id="l6">0</span></td>
                                    <td class="balls" id="f6">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=7')">第七球<span class="odds">總</span>：<span class="ls" id="l7">0</span></td>
                                    <td class="balls" id="f7">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile.php?cid=8')">第八球<span class="odds">總</span>：<span class="ls" id="l8">0</span></td>
                                    <td class="balls" id="f8">0</td>
                                </tr>
                                 <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LH.php?cid=9')">總和大小：<span class="ls" id="l9">0</span></td>
                                    <td class="balls" id="f9">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LH.php?cid=9')">總和單雙：<span class="ls" id="l10">0</span></td>
                                    <td class="balls" id="f10">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LH.php?cid=9')">總尾大小：<span class="ls" id="l11">0</span></td>
                                    <td class="balls" id="f11">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LH.php?cid=9')">龍&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;虎：<span class="ls" id="l12">0</span></td>
                                    <td class="balls" id="f12">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">任&nbsp;&nbsp;選&nbsp;&nbsp;二：<span class="ls" id="l13">0</span></td>
                                    <td class="balls" id="f13">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">選二連直：<span class="ls" id="l14">0</span></td>
                                    <td class="balls" id="f14">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">選二連組：<span class="ls" id="l15">0</span></td>
                                    <td class="balls" id="f15">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">任&nbsp;&nbsp;選&nbsp;&nbsp;三：<span class="ls" id="l16">0</span></td>
                                    <td class="balls" id="f16">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">選三連直：<span class="ls" id="l17">0</span></td>
                                    <td class="balls" id="f17">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">選三連組：<span class="ls" id="l18">0</span></td>
                                    <td class="balls" id="f18">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">任&nbsp;&nbsp;選&nbsp;&nbsp;四：<span class="ls" id="l19">0</span></td>
                                    <td class="balls" id="f19">0</td>
                                </tr>
                                <tr align="center">
                                	<td class="zh" onclick="GoLocation('oddsFile_LM.php?cid=10')">任&nbsp;&nbsp;選&nbsp;&nbsp;五：<span class="ls" id="l20">0</span></td>
                                    <td class="balls" id="f20">0</td>
                                </tr>
                            </table>
                            <table border="0" cellspacing="0" class="t_odds" width="135" id="cl">
                            	<!-- <tr class="tr_top">
                                	<th colspan="2">兩面長龍</th>
                                </tr>
                                <tr align="center">
                                	<td class="uo">第一球-單</td>
                                    <td class="fe">5期</td>
                                </tr> -->
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center">評價虧損：
                        <input type="text" class="textb" id="Param" onkeyup="setMean(this)" value="<?php echo$Mean?>" />&nbsp;&nbsp;
                        <input type="button" class="inputs" onclick="planning()" value="計算補貨" />&nbsp;&nbsp;
                        <?php if ($oddsLock){?>
                        <input type="button" class="inputs" value="還原賠率" onclick="initializes()" />&nbsp;&nbsp;&nbsp;&nbsp;
                        設置調動幅度：<input type="text" class="texta" id="Ho" value="0.001" />
                        <?php }?>
                        </td>
                        <td width="16"><img src="/Manage/temp/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"> </td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"> </td>
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