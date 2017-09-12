<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
global $Users, $LoginId, $ConfigModel;
if ($Users[0]['g_login_id'] != 89) if ($Users[0]['g_lock'] == 2)
exit(back($UserOut)); //帳號已被凍結

//子帳號
if (isset($Users[0]['g_lock_2'])){
	if ( $Users[0]['g_s_lock'] == 2 || $Users[0]['g_lock_2'] != 1)
		exit(back($UserOut)); //帳號已被凍結
}
markPos("后台-代理下属会员");
$userModel = new UserModel();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['sid']) && isset($_GET['cid']) && isset($_GET['actions']))
{
	if (!isset($_POST['s_Name']) || !Matchs::isString($_POST['s_Name'], 4,10)) exit(back('您輸入的帳號錯誤！'));
	if (!isset($_POST['s_F_Name']) || !Matchs::isStringChi($_POST['s_F_Name'])) exit(back('您輸入的名稱錯誤！'));
	if (!isset($_POST['s_Pwd']) || !Matchs::isString($_POST['s_Pwd'], 8, 20)) exit(back('請輸入密碼！'));
	if (!isset($_POST['s_money']) || !Matchs::isNumber($_POST['s_money'])) exit(back('信用額錯誤！'));
	if (!isset($_POST['Size_KY']) || !Matchs::isNumber($_POST['Size_KY'])) exit(back('占成錯誤！'));
	if (!isset($_POST['user_lock']) || !Matchs::isNumber($_POST['user_lock'])) exit(back('限額錯誤！'));
	if (!isset($_POST['g_xianhong']) || !Matchs::isNumber($_POST['g_xianhong'])) exit(back('限額錯誤！'));
	$sid = $_GET['sid'];
	$s = $_POST['s'];
	$s_Name = $_POST['s_Name'];
	$s_F_Name = $_POST['s_F_Name'];
	$s_Pwd = $_POST['s_Pwd'];
	$s_money = $_POST['s_money'];
	$s_Size_KY = $_POST['Size_KY'];
	$s_pan = $_POST['s_pan'];
	$s_select = $_POST['select'];
	$g_xianhong = $_POST['g_xianhong'];
	
	
	$p_result = $userModel->GetUserModel(null, $s);
	if ($sid == 2) 
	{
		if ($ConfigModel['g_son_member_lock'] != 1) 
			exit(back('權限不足，無法新增直屬會員！'));
		$s_Nid = $p_result[0]['g_nid'].md5(uniqid(time(),true));
		$Lid = $userModel->GetLoginIdByString($p_result[0]['g_login_id']);
		if ($p_result[0]['g_login_id'] == 22) {
			$loid = 78;
		} else if ($p_result[0]['g_login_id'] == 78) {
			$loid = 48;
		} else if ($p_result[0]['g_login_id'] == 56) {
			$loid = 22;
		} else {
			$loid = 9;
		}
	}
	else 
	{
		$loid = 9;
		$s_Nid = $p_result[0]['g_nid'];
	}
	if ($p_result[0]['g_login_id'] != 56 && ($sid == 2 || $sid == 1))
	{
		//得到當前用戶可用額
		if ($p_result[0]['g_login_id'] == 48)
		{
			$nid = $p_result[0]['g_nid'].'%';
			$validMoney = $p_result[0]['g_money'] - $userModel->SumMoney($nid, true);
		}
		else 
		{
			$nid = $p_result[0]['g_nid'].UserModel::Like();
			$validMoney = $p_result[0]['g_money'] - $userModel->SumMoney($nid);
		}
		if ($s_money > $validMoney)exit(back('上級可用餘額：'.$validMoney));
		if ($s_Size_KY > $p_result[0]['g_distribution'])exit(back('最高占成率：'.$p_result[0]['g_distribution']));
	}
	$userList = array();
	$userList['s_L_Name'] = $s;
	$userList['g_nid'] = $s_Nid;
	$userList['g_login_id'] = $loid;
	$userList['g_name'] = $s_Name;
	$userList['g_f_name'] = $s_F_Name;
	$userList['g_mumber_type'] = $sid;
	$userList['g_password'] = sha1($s_Pwd);
	$userList['g_money'] = $s_money;
	$userList['g_money_yes'] = $s_money;
	$userList['g_distribution'] = $s_Size_KY;
	$userList['g_tuishui'] = $s_select;
	$userList['g_xianhong'] = $g_xianhong;
	//为会员分配盘口
	for($i=0;$i<count($s_pan);$i++){
	$s_panlus=$s_panlus.strtoupper($s_pan[$i]).',';
	}
	$s_panl=strtoupper($s_pan[0]);
	$userList['g_panlus'] = strtoupper($s_panlus);
	$userList['g_panlu'] = strtoupper($s_panl);
	
	
	$userList['g_xianer'] = $_POST['user_lock'];
	$userList['g_out'] = 0;
	$userList['g_look'] = 1;
	$userList['g_ip'] = UserModel::GetIP();
	$userList['g_date'] = date("Y-m-d H:i:s");
	$userList['g_uid'] = md5(uniqid(time(),true));
	if ($userModel->ExistUnion($userList['g_name']))
	{
		alert_href('此用戶已存在', 'Actfor.php?cid='.$_GET['cid']);
		exit;
	}
	$userModel->AddMumberUser($userList);
	alert_href('新增成功，請設置退水項！', 'Member_MR.php?cid='.$_GET['cid'].'&uid='.$s_Name);
	exit;
}
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['sid']) && isset($_GET['cid']))
{
	$sid = $_GET['sid'];
	$cid = $_GET['cid'];
	if ($sid == 2){
		if ($ConfigModel['g_son_member_lock'] != 1) 
			exit(back('權限不足，無法新增直屬會員！'));
		$Munber = '新增直屬會員';
	} else {
		$Munber = '新增會員';
	}
	$Rank = UserModel::GetNextRank($cid, $LoginId, $Users);
	if ($sid == 1) //新增普通會員
	{
		//查詢當前用戶的代理
		$select = getSelect ($Rank, $userModel);
	}
	else 
	{
		//查詢直屬關係
		$o1 = '<tr><td class="bj" id="bj">上級直屬</td><td class="left_p5" id="pc">';
		$o2 = '&nbsp;&nbsp;<span id="FirstRankMoney"></span></td></tr>';
		$Rank[0] = '上級';
		if ($Users[0]['g_login_id'] == 89 || $Users[0]['g_login_id'] ==56)
		{
		$select =$o1.'<input type="radio" onclick="Gos(this);" name="tse" value="0">分公司&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" onclick="Gos(this);" name="tse" value="1">股東&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" onclick="Gos(this);" name="tse" value="2">總代理';
		}
		else if($Users[0]['g_login_id'] == 22) {
			$select =$o1.'<input type="radio" onclick="Gos(this);" name="tse" value="1">股東&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" onclick="Gos(this);" name="tse" value="2">總代理';
		} else if ($Users[0]['g_login_id'] == 78) {
			$select =$o1.'<input type="radio" onclick="Gos(this);" name="tse" value="2">總代理';
		}
	}
}

function getSelect ($Rank, $userModel, $p=FALSE)
{
	$select = null;
	$option1 = '<tr><td class="bj" id="bj">上級'.$Rank[0].'</td><td class="left_p5"><select name="s" id="s" onchange="FirstRankMoney()">';
	$option2 = '</select>&nbsp;&nbsp;<span id="FirstRankMoney"></span></td></tr>';
	$result = $userModel->GetUserName_Like($Rank[2]);
	if ($result == null){
		$select = '<option value="0">暫無帳號</option>';
	}  else{
		for ($i=0; $i<count($result); $i++){$select .= '<option value="'.$result[$i]['g_name'].'">'.$result[$i]['g_name'].'</option>';}
	}
	return $option1.$select.$option2;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Manage/temp/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/Manage/temp/js/common.js"></script>
<script type="text/javascript" src="/Manage/temp/js/Pwd_Safety.js"></script>
<title></title>
<script type="text/javascript">
<!--
	function Gos ($this){
		$.post("/Manage/temp/ajax/json.php", {typeid : "2", id : $this.value}, function (data){
			//alert(data);
			var pc = $("#pc");
			var p1 = '<select name="s" id="s" onchange="FirstRankMoney()">';
			var p2 = '</select>&nbsp;&nbsp;<span id="FirstRankMoney"></span>';
			var user = new Array();
			for (var i=0; i<data.user.length; i++){
				user.push('<option value="'+data.user[i]+'">'+data.user[i] + '</option>');
			}
			pc.html(p1 + user.join('') + p2);
			$("#bj").html("上級"+data.name);
			$("#zj").html(data.name+"佔成");
			FirstRankMoney($("#s"));
		}, "json");
	}
-->
</script>
</head>
<body>
<form method="post" action="?actions=add&cid=<?php echo$cid?>&sid=<?php echo$sid?>" onsubmit="return isPost()" >
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_03.gif" alt="" /></td>
                        <td background="/Manage/temp/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/Manage/temp/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;<?php echo $Munber?></td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/Manage/temp/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
                             <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                            		<th colspan="2"><?php echo $Munber?></th>
                            	</tr>
                            	<?php echo $select?>
                                <tr style="height:28px">
                                	<td class="bj">會員帳號</td>
                                	<td class="left_p5"><input name="s_Name" id="s_Name"  maxlength="20" type="text" class="text" /></td>
                                </tr>
                                <tr style="height:28px">
                                	<td class="bj">會員名稱</td>
                                    <td class="left_p5"><input class="text" name="s_F_Name"  maxlength="20" /></td>
                                </tr>
                                <tr style="height:28px">
                                	<td class="bj">登陸密碼</td>
                                    <td class="left_p5"><input class="text" type="password" name="s_Pwd" id="s_Pwd"  maxlength="20" /></td>
                                </tr>
                                <tr style="height:28px">
                                	<td class="bj">信用額度</td>
                                    <td class="left_p5"><input class="text" name="s_money" id="s_money"  maxlength="7" value="0" /></td>
                                </tr>
								 <tr>
                  					<td class="bj">限红額度</td>
                 					 <td class="left_p5"><input class="text" type="text" name="g_xianhong" id="g_xianhong"  maxlength="20"  value="0" />  &nbsp;<span class="odds">限制會員帳號當天可赢金額！0为不限制。</span></td>
               					 </tr>
                                <tr style="height:28px">
                                	<td class="bj" id="zj"><?php echo$Rank[0]?>占成</td>
                                    <td class="left_p5"><input class="texta" name="Size_KY"  maxlength="3" value="0" />%&nbsp; <font id="Size_KY"></font> </td>
                                </tr>
                                <tr style="height:28px">
                                	<td class="bj">帳號限額</td>
                                    <td class="left_p5"><input class="texta" name="user_lock"  maxlength="9" value="1000000" />&nbsp;<span class="odds">限制會員帳號當天總下注額！</span></td>
                                </tr>
                                <tr style="height:28px">
                                	<td class="bj">開放盤口</td>
									<script type="text/javascript"> 
										function check(spanl){
   											var flag=0;
   										for(var i=0;i<document.getElementsByName("s_pan[]").length;i++){
       										if(document.getElementsByName("s_pan[]")[i].checked==true){
       											flag++;
    										}
   										}
  											 if(flag==0){
   												alert("最少必须分配一个盘口");
   												spanl.checked='checked';
   													return false;
   											}
   												return true;
									}
									</script> 
                                    <td class="left_p5">
                                    <input type="radio" value="a" name="s_pan[]"  checked="checked" onclick="check(this)" />A盤&nbsp;
                                    <input type="radio" value="b" name="s_pan[]"  onclick="check(this)" />B盤&nbsp;
                                    <input type="radio" value="c" name="s_pan[]"  onclick="check(this)" />C盤&nbsp;
                                    </td>
                                </tr>
                                <tr style="height:28px">
                                	<td class="bj">設定退水</td>
                                    <td class="left_p5">
                                    	<select name="select" id="s_TS">
											<option selected="selected" value="0">水全退到底</option>
											<option value="0.3">賺取0.3退水</option>
											<option value="0.5">賺取0.5退水</option>
											<option value="1">賺取1.0退水</option>
											<option value="2">賺取2.0退水</option>
											<option value="100">賺取所有退水</option>
										</select>
                                    </td>
                                </tr>
                            </table>
                        <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                    	<td width="12"><img src="/Manage/temp/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="center"><input type="submit" class="inputs" value="確定新增" /></td>
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
 </form>
</body>
</html>