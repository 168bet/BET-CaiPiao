<?php 
if (!defined('ROOT_PATH'))
exit('invalid request');
if (!defined('Copyright') && Copyright != '作者QQ:503064228')
exit('作者QQ:503064228');
include_once ROOT_PATH.'function/global.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK id=lhgdglink rel=stylesheet type=text/css href="/webssc/js/skins/skin_brown.css">
<TITLE><?php echo $Title?></TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<SCRIPT language=javascript src="/js/jquery.js"></SCRIPT>

<SCRIPT language=javascript src="/webssc/js/login.js?112"></SCRIPT>

<SCRIPT language=javascript src="/webssc/js/dlg.js"></SCRIPT>
<LINK rel=stylesheet type=text/css href="/webssc/css/all_f.css"></LINK>
<STYLE type=text/css>BODY {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif; FONT-SIZE: 12px; PADDING-TOP: 0px
}
.header1 {
	BACKGROUND: url(/webssc/company/zb/header2.png) #3163a7 no-repeat center 50%; HEIGHT: 84px
}
.protol {
	BACKGROUND: url(/webssc/company/zb/bg_prototol.png) repeat-x 50% top; PADDING-TOP: 24px
}
.g_xy {
	BORDER-BOTTOM: rgb(181,198,226) 1px solid; BORDER-LEFT: rgb(181,198,226) 1px solid; MARGIN: 0px auto; WIDTH: 975px; BACKGROUND: rgb(240,247,255); BORDER-TOP: rgb(181,198,226) 1px solid; BORDER-RIGHT: rgb(181,198,226) 1px solid
}
.g_xy H3 {
	BORDER-BOTTOM: rgb(206,219,239) 1px solid; TEXT-ALIGN: center; PADDING-BOTTOM: 18px; MARGIN: 0px 84px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; COLOR: rgb(22,46,146); FONT-SIZE: 14px; PADDING-TOP: 28px
}
.g_xy .txt {
	PADDING-BOTTOM: 40px; LINE-HEIGHT: 24px; MARGIN: 0px 80px 0px 84px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 20px
}
.protol .bottom {
	TEXT-ALIGN: center; MARGIN-TOP: 13px
}
.protol .bottom A {
	MARGIN: 0px 2px
}
</STYLE>

</head>
<body class="skin_brown"><?php
$sql = "SELECT * FROM `g_user` WHERE `g_name` = '{$loginName}' AND `g_pwd` = 1 LIMIT 1 ";
		$result = $db->query($sql, 1);
		if ($result)
		{
			//判斷帳號是否需要重新设置密码
			alert_href($loginName.'你是首次登陆或者上级更改密码，需要修改密码！','templates/UpPwd_first.php');		
		}else{
?>
<DIV class=header1></DIV>
<DIV class=main>
<DIV class=protol>
<DIV class=g_xy>
<H3><STRONG>游戏协议</STRONG> </H3>
<DIV class=txt>
<UL>
<LI>・ 01. 为避免出现争议，请您务必在下注之后查看“下注状况”。 
<LI>・ 02. 任何投诉必须在开奖之前，后台将不接受任何开奖之后的投诉。 
<LI>・ 03. 公布赔率时出现的任何打字错误或非故意人为失误，所有（相关）注单一律不算。 
<LI>・ 04. 公布之所有赔率为浮动赔率，下注时请确认当前赔率及金额，下注确认后一律不能修改。 
<LI>・ 05. 开奖后接受的投注，一律视为无效。 
<LI>・ 06. 若本后台发现客户以不正当的手法投注或投注注单不正常，后台将有权“取消”相应之注单，客户不得有任何异议。 
<LI>・ 07. 如因软件或线路问题导致交易内容或其他与账号设定不符合的情形，请在开奖前立即与本后台联络反映问题，否则本后台将以资料库中的数据为准。 
<LI>・ 08. 倘若发生遭黑客入侵破坏行为或不可抗拒之灾害致网站故障或资料损坏、数据丢失等情况，后台将以资料库数据为依据。 
<LI>・ 09. 各级管理人员及客户必须对本系统各项功能进行了解及熟悉，任何违反正常使用的操作，后台概不负责。 
<LI>・ 10. 请认真了解游戏规则。 </LI></UL></DIV></DIV>
<DIV class=bottom><A id=agree class="btn_m elem_btn" href="javascript:void(0)" jQuery1388576853218="5">同意</A> <A id=disagree class="btn_m elem_btn" href="javascript:void(0)" jQuery1388576853218="6">不同意</A> </DIV></DIV></DIV>
<FORM method=post name=form1 action=/><INPUT value=yes type=hidden name=sid><INPUT value=1 type=hidden name=banben> </FORM>
<SCRIPT language=javascript>
initValidatePage(); 
if(getCookie("skinclass")!=null){
	$('body').attr('class',getCookie("skinclass"));	
}
</SCRIPT>
<?php }?>