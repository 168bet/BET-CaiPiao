<?php 
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'function/cheCookie.php';
if ($user[0]['g_look'] == 2) exit(back($UserOut));

$name = base64_decode($_COOKIE['g_user']);

	$db = new DB();
	
	
	if(isset($_POST['un'])){
		$uname=$name;
		$sql = "SELECT * FROM `g_ziliao` WHERE `g_name` = '{$uname}' LIMIT 1 ";
		if($result=$db->query($sql, 1)){
		if($result[0]['g_lock']==1){
		alert('资料已锁定，不能修改，请联系管理员！');
		}else {
		if(isset($_POST['lock'])){
		$lock=1;
		}else{
		$lock=0;
		}
		$sql = "update `g_ziliao` set g_name='{$uname}',g_yinhang='{$_POST['qtype']}',g_zhanghao='{$_POST['zh']}',g_xingming='{$_POST['xm']}',g_qq='{$_POST['qq']}',g_phone='{$_POST['ph']}',g_lock=$lock where  `g_name` = '{$uname}'  ";
		alert('资料修改成功！');
		$db->query($sql, 2);
		}
		}else{
		if(isset($_POST['lock'])){
		$lock=1;
		}else{
		$lock=0;
		}
		$sql = "insert into `g_ziliao`(g_name,g_yinhang,g_zhanghao,g_xingming,g_qq,g_phone,g_lock) values('{$uname}','{$_POST['qtype']}','{$_POST['zh']}','{$_POST['xm']}','{$_POST['qq']}','{$_POST['ph']}',$lock) ";
		$db->query($sql, 2);
		alert('资料修改成功！');
		}
	}
	
	$sql = "SELECT * FROM `g_ziliao` WHERE `g_name` = '{$name}' LIMIT 1 ";
	$result=$db->query($sql, 1);
	
	$sql = "SELECT * FROM `g_user` WHERE `g_name` = '{$name}' LIMIT 1 ";
	$resultu=$db->query($sql, 1);
	
	$sql = "SELECT * FROM `g_qc` ";
	$resultc=$db->query($sql, 1);
	
	$sql = "SELECT * FROM `g_qdetail` WHERE `g_name` = '{$name}' and  to_days(g_date) = to_days(now()) and g_type=1";
	$resultqd=$db->query($sql, 1);
	
	
	if(isset($_POST['qy'])&&$_POST['qy']!=""){
		if($resultc[0]['g_count']-count($resultqd)<=0) exit(alert_href('你今天取款次数已达限额！','qukuan.php'));
		if($_POST['qy']<$resultc[0]['g_limit']) exit(alert_href('取款金额低于额定金额！','qukuan.php'));
		if($_POST['qy']>$resultu[0]['g_money_yes']) exit(alert_href('取款金额超过信用余额！','qukuan.php'));
		$sql = "insert into `g_qdetail`(g_name,g_money,g_date,g_type) values('{$name}','{$_POST['qy']}',now(),1) ";
		$db->query($sql, 2);
		$money_yes=$resultu[0]['g_money_yes']-$_POST['qy'];
		$sql = "update `g_user` set g_money_yes={$money_yes},g_dmoney=g_dmoney+{$_POST['qy']} where `g_name` = '{$name}'  ";
		$db->query($sql, 2);
		
		exit(alert_href('取款申请已提交！','qukuan.php'));
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" oncontextmenu="return false">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/left.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src=".js/sc.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="./js/Pwd_Safety.js"></script>
<title></title>
<script type="text/javascript">
function SubChk(){
    if(document.all.xm.value.length == ""){
	    alert("請輸入取款账号姓名！");
	    document.all.xm.focus();
	    return false;
    }
    if(document.all.zh.value.length == ""){
	    alert("請輸入取款账号！");
	    document.all.zh.focus();
	    return false;
    }
	 if(document.all.qq.value.length == ""){
	    alert("請輸入联系QQ！");
	    document.all.qq.focus();
	    return false;
    }
	 if(document.all.ph.value.length == ""){
	    alert("請輸入手机号码！");
	    document.all.ph.focus();
	    return false;
    }
}
</script>
</head>
<body>
<table width="100%" border="0">
<tr>
<td width="60%">
<table border="0" cellpadding="0" cellspacing="1" class="t_list" width="600">
		 <form action="" method="post" onsubmit="return SubChk()">
        <tr>
            <td class="t_list_caption" colspan="2">在线取款</td>
        </tr>
        <tr style="height:28px">
            <td  colspan="2" style="text-align:center" class="t_td_caption_1">取款资料</td>
        </tr>
		 <tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="160">會員帳戶：</td>
            <td class="t_td_text" width="530"><?php echo $name; ?><input type="hidden" name="un" id="un" value="<?php echo $name; ?>" /></td>
		 </tr>
        <tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="156">取款方式：</td>
            <td class="t_td_text">
			<select style=" margin-left:3px;border:1px #0099CC solid; background:#F3F3F3"  name="qtype" id="qtype" <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>  >
			<!--<option value="中国工商银行" <?php echo$result[0]['g_yinhang']=='中国工商银行'? 'selected="selected"':'';?> >中国工商银行</option>
			<option value="中国银行"  <?php echo$result[0]['g_yinhang']=='中国银行'? 'selected="selected"':'';?> >中国银行</option>
			<option value="中国农业银行"  <?php echo$result[0]['g_yinhang']=='中国农业银行'? 'selected="selected"':'';?> >中国农业银行</option>
			<option value="中国建设银行"  <?php echo$result[0]['g_yinhang']=='中国建设银行'? 'selected="selected"':'';?> >中国建设银行</option>
			<option value="中国邮政"  <?php echo$result[0]['g_yinhang']=='中国邮政'? 'selected="selected"':'';?> >中国邮政</option>
			<option value="兴业银行"  <?php echo$result[0]['g_yinhang']=='兴业银行'? 'selected="selected"':'';?> >兴业银行</option>
			<option value="支付宝"  <?php echo$result[0]['g_yinhang']=='支付宝'? 'selected="selected"':'';?> >支付宝</option>-->
			<option value="财付通" <?php echo$result[0]['g_yinhang']=='财付通'? 'selected="selected"':'';?>  >财付通</option>
			</select>			</td>
        </tr>
       
		<tr style="height:28px">
            <td  style="text-align:right" class="t_td_caption_1" width="156">账号姓名：</td>
            <td class="t_td_text"><input  style=" margin-left:3px;border:1px #0099CC solid; background:#F3F3F3; height:16px" name="xm"  value="<?php echo$result[0]['g_xingming'];?>"   <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>/></td>
        </tr>
		
		 <tr style="height:28px">
            <td  style="text-align:right" class="t_td_caption_1" width="156">取款账号：</td>
            <td class="t_td_text"><input  style=" margin-left:3px;border:1px #0099CC solid; background:#F3F3F3; height:16px" size="52" name="zh"   value="<?php echo$result[0]['g_zhanghao'];?>" <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>/></td>
        </tr>
		
		 <tr style="height:28px">
            <td  style="text-align:right" class="t_td_caption_1" width="156">联系QQ：</td>
            <td class="t_td_text"><input  style=" margin-left:3px;border:1px #0099CC solid; background:#F3F3F3; height:16px" size="52" name="qq"   value="<?php echo$result[0]['g_qq'];?>" <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>/></td>
        </tr>
		
		 <tr style="height:28px">
            <td  style="text-align:right" class="t_td_caption_1" width="156">手机号码：</td>
            <td class="t_td_text"><input  style=" margin-left:3px;border:1px #0099CC solid; background:#F3F3F3; height:16px" size="52" name="ph"   value="<?php echo$result[0]['g_phone'];?>" <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>/></td>
        </tr>
		
		<tr style="height:28px">
            <td  style="text-align:right" class="t_td_caption_1" width="156">资料锁定：</td>
            <td class="t_td_text">&nbsp;<input name="lock" type="checkbox" id="lock" value="0"  <?php echo$result[0]['g_lock']==1? 'checked="checked"':'';?> <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>/>&nbsp;安全起见，请锁定你的取款资料。</td>
        </tr>
        <tr>
        	<td colspan="2" align="center" class="textcc"><input type="submit" class="inputs" value="確認提交" <?php echo$result[0]['g_lock']==1? 'disabled="disabled"':'';?>/></td>
        </tr></form>
		
		 <tr>
            <td class="t_list_caption" colspan="2">取款申请</td>
        </tr>
		 <form action="" method="post" onsubmit="">
		<tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="160">帳戶余额：</td>
            <td class="t_td_text" width="530"><span style="color: #FF0000"><?php echo$resultu[0]['g_money_yes']; ?>&nbsp;元</span></td>
		 </tr>
		 <tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="160">取款金额：</td>
            <td class="t_td_text" width="530"><input type="text" name="qy" id="qy" onKeyUp="this.value=this.value.replace(/[^\d]/g,'');" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/>&nbsp;元（最低取款<?php echo$resultc[0]['g_limit'];?>元）</td>
		 </tr>
		 <tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="160">提示：</td>
            <td class="t_td_text" width="530"><strong>每天取款最多<?php echo$resultc[0]['g_count'];?>次，今天您还可以再取<span style="color: #FF0000"><?php echo $resultc[0]['g_count']-count($resultqd);?></span>次。</strong> </td>
		 </tr>
		 
		  <tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="160"></td>
            <td class="t_td_text" width="530"><input type="submit" name="Submit2" class="button" value="提  交"></td>
		 </tr>
		 </form>
		 <tr style="height:28px">
            <td style="text-align:right" class="t_td_caption_1" width="160">取款说明：</td>
            <td class="t_td_text" width="530"><?php echo$resultc[0]['g_text'];?><br/>
			取款时间：<?php echo$resultc[0]['g_start'];?>点~<?php echo$resultc[0]['g_end'];?>点,平常10分钟内到帐，高峰30分钟。</td>
		 </tr>
</table>
</td>
<td width="40%" valign="top" align="left">
<table border="0" cellpadding="0" cellspacing="1" class="t_list"  width="362">
 <tr c>
            <td class="t_list_caption" colspan="4">最近10条取款明细</td>
        </tr>
		<tr>
			  <td class="t_list_caption">取款账户</td>
			    <td class="t_list_caption">取款金额</td>  
				<td class="t_list_caption">取款日期</td>
				<td class="t_list_caption" >状态</td>
        </tr>
		<?php
		$sql = "SELECT * FROM `g_qdetail` WHERE `g_name` = '{$name}' and g_type=1  ORDER BY g_id DESC LIMIT 10";
		if($resultqdt=$db->query($sql, 1)){
		for($i=0;$i<count($resultqdt);$i++){
		?>
		<tr>
			    <td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_name'];?></td>
			    <td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_money'];?></td>  
				<td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_date'];?></td>
				<td class="t_td_text" align="center"><?php echo$resultqdt[$i]['g_state'];?></td>
        </tr>
		<?php
		}
		}
		 ?>
</table></td>
</tr>
</table>
</body>
</html>