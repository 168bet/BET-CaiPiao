<?php
define('Copyright', '作者QQ:503064228');
define('ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/');
include_once ROOT_PATH.'Manage/ExistUser.php';
include_once ROOT_PATH.'Manage/config/config.php';
global $Users, $ConfigModel;

if ($Users[0]['g_login_id'] != 89) exit;

if (isset($Users[0]['g_lock_1_6'])){
	if ($Users[0]['g_lock_1_6'] !=1) 
		exit(back('您的權限不足！'));
}

$db=new DB();
if(isset($_GET['uid'])&&$_GET['uid']!=""){
$name=$_GET['uid'];
$sql = "SELECT * FROM `g_user` where `g_name`='{$name}' limit 1";
$result=$db->query($sql, 1);
}
$value = mb_substr($result[0]['g_nid'], 0, mb_strlen($result[0]['g_nid'],'utf-8')-32);
$a = $userModel->GetUserName_Like($value);
$Luser = $userModel->GetUserName_Like($result[0]['g_nid']);
if ($Luser) {
    $pp = $Luser;
}else{
    $pp = $a;
}

if(isset($_POST['cjin'])&&$_POST['cjin']!=""){
$dmoney=$_POST['cjin'];
if ($dmoney > 0) {
    $num = $dmoney ;
    if ($num > $pp[0]['g_money'] ) {
        exit(back('上级余额不足！'));
    }
}else{
    $num = $dmoney * -1;
    if ($num > $result[0]['g_money_yes']) {
        exit(back('该用户余额不足!'));
    }

}


$sql="update g_rank set g_money=g_money-{$dmoney} where g_name='{$pp[0]['g_name']}'";
$db->query($sql, 2);

$sql="update g_user set g_money=g_money+{$dmoney},g_money_yes=g_money_yes+{$dmoney} where g_name='{$_POST['uname']}'";
$db->query($sql, 2);
$dmoney>0? $state='已充值':$state='扣除金额';
$sql="insert into  g_qdetail(g_name,g_money,g_date,g_state,g_type) values('{$_POST['uname']}','{$dmoney}',now(),'{$state}',0)";
$db->query($sql, 2);



//jia

$valueList = array();
				$valueList['g_name'] = $name;//被改的用户名
				$valueList['g_f_name'] = $_SESSION['sName'];//管理员或者是上级
				$valueList['g_initial_value'] = $result[0]['g_money_yes'];////初始值
				$valueList['g_up_value'] = $result[0]['g_money_yes']+$dmoney;//更新之后的值
				$valueList['g_up_type'] = '可用余额';//修改的名称
				$valueList['g_s_id'] = 1;//1为管理员或者上级修改，2为自己修改
				insertLogValue($valueList);
//jia


exit(back('充值完成！'));
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo $oncontextmenu?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/SystemControl/ActionLib/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/actiontop.js"></script>
<title></title>
</head>
<body>
	<table width="100%" height="100%" border="0" cellspacing="0" class="a">
    	<tr>
        	<td width="6" height="99%" bgcolor="#5a5a5a"></td>
            <td class="c">
            	<table border="0" cellspacing="0" class="main">
                	<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_03.gif" alt="" /></td>
                        <td background="/SystemControl/ActionLib/images/tab_05.gif">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="17"><img src="/SystemControl/ActionLib/images/tb.gif" width="16" height="16" /></td>
                                    <td width="99%">&nbsp;充值功能</td>
                                  </tr>
                            </table>
                        </td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_07.gif" alt="" /></td>
                    </tr>
                    <tr>
                    	<td class="t"></td>
                        <td class="c">
                        <!-- strat -->
						
                      <form action="" method="post" onsubmit="" >
						
						  <table border="0" cellspacing="0" class="conter">
                            	<tr class="tr_top">
                                	<th colspan="2">充值操作</th>
                                </tr>
								  <tr style="height:28px">
                                	<td class="bj">會員帳戶:</td>
                                    <td class="left_p6">&nbsp;<?php echo $result[0]['g_name']?><input type="hidden" value="<?php echo $result[0]['g_name']?>" name="uname" id="uname"/></td>
                                </tr>
                                <tr style="height:28px">
                                    <td class="bj">上级用户:</td>
                                    <td class="left_p6">&nbsp;<?php echo $pp[0]['g_name']?></td>
                                </tr>
								
								<tr style="height:28px">
                                	<td class="bj">可用金額:</td>
                                    <td class="left_p6">&nbsp;<?php echo round($result[0]['g_money_yes'],2)?> 元</td>
                                </tr>
								
								<tr style="height:28px">
                                	<td class="bj">充值金额:</td>
                                    <td class="left_p6">&nbsp;<input name="cjin" id="cjin" type="text" size="10" /> 元</td>
                                </tr>
								
								<tr style="height:28px">
                                	<td class="bj">&nbsp;</td>
                                    <td class="left_p6">&nbsp;<input type="submit" value="提   交"/></td>
                                </tr>
								
						</table></form>
						  <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
					<tr>
                    	<td width="12"><img src="/SystemControl/ActionLib/images/tab_18.gif" alt="" /></td>
                        <td class="f" align="right">&nbsp;</td>
                        <td width="16"><img src="/SystemControl/ActionLib/images/tab_20.gif" alt="" /></td>
                    </tr>
                </table>
            </td>
            <td width="6" bgcolor="#5a5a5a"></td>
        </tr>
        <tr>
        	<td height="6" bgcolor="#5a5a5a"></td>
            <td bgcolor="#5a5a5a"></td>
            <td height="6" bgcolor="#5a5a5a"></td>
        </tr>
    </table>
</body>
</html>