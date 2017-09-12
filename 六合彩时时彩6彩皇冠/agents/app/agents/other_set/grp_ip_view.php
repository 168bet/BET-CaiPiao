<script>
var msg = '';
var grp_show = 'Y';
</script>
<script>
top.str_FT = "足球";
top.str_FS = "冠军";
top.str_BK = "篮球";
top.str_TN = "网球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";

//信用额度
top.str_maxcre = "总信用额度仅能输入数字!!";

top.str_gopen = "开放";
top.str_gameclose = "关闭";
top.str_gopenY = "是否确定赛程开放";
top.str_gopenN = "是否确定赛程关闭";
top.str_strongH = "是否确定强弱互换";
top.str_strongC = "是否确定强弱互换";
top.str_close_ioratio = "是否确定关闭赔率";
top.str_checknum = "验证码错误,请重新输入";

//新冠军
top.str_scoreY = "负";
top.str_scoreN = "胜";
top.str_change = "确定重置结果!!";
top.str_eliminate = "是否淘汰";
top.str_format = "请填入正确格式";
top.str_close_time = "是否确定关闭时间??"
top.str_check_date = "请检查日期格式 !!";
top.str_champ_win = "冠军是否为:";
top.str_champ_wins = "请再确认冠军是否为:";
top.str_NOchamp = "无胜出队伍，请重新设定!!";
top.str_NOloser = "无淘汰队伍，请重新设定!!";

//帐号
top.str_co = "股东";
top.str_su = "总代理";
top.str_ag = "代理商";
top.str_input_account = "帐号请勿必输入!!";
top.str_input_alias = "名称请务必输入!!";
top.str_input_credit = "信用额度请务必输入!!";
top.str_confirm_add_su = "是否确定写入总代理?";

//密码
top.str_input_pwd = "密码请务必输入!!";
top.str_input_repwd = "确认密码请务必输入!!";
top.str_input_pwd2 = top.str_input_pwd;
top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "您的密码必须6至12个字元长,您只能使用数字和英文字母并至少 1 个英文字母,其他特殊符号不能使用 。";
top.str_pwd_limit2 = "您的密码需使用字母加上数字!!";
top.str_err_pwd = "密码确认错误,请重新输入!!";
top.str_err_pwd_fail = "该密码您已使用过, 为了安全起见, 请使用新密码!!";

//╬办呼
top.dPrivate="私域";
top.dPublic="公有";
top.grep="群组";
top.grepIP="群组IP";
top.IP_list="IP列表";
top.Group="组别";
top.choice="请选择";
top.webset="戈癟呼";</script>

<script>
function reload_table() {
	//alert("aaa===>"+grp_show);
	if (grp_show == "Y") {
		var shows = document.getElementById("showlayer").innerHTML; //=== 材糷 div
		var tr_data = document.getElementById("show_tr").innerHTML; //=== 材糷 div
		var AllLayer = ""; //=== 材糷 div
		var layers = "";
		AllLayer=Show_Data(tr_data);
		shows = shows.replace("*SHOWLIST*",AllLayer);
		shows = shows.replace("*WEBSET*",top.webset);
		show_table.innerHTML = shows;	
	}else{
		var no_data = document.getElementById("no_data").innerHTML;
		no_data = no_data.replace("*WEBSET*",top.webset);
		show_table.innerHTML = no_data;
	}
	
}
	
function Show_Data(layers){
	//layers = layers.replace('*MSG*',Chkarray[i][2]);
	layers = layers.replace('*MSG*',msg);
	return layers;
}


//次
var current = null;
function colorTRx(flag){
	if(flag==1 && current!=null){
		current.style.backgroundColor = current._background;
		current.style.color = current._font;
		current = null;
		return;
	}
	if ((self.event.srcElement.parentElement.rowIndex!=0) && (self.event.srcElement.parentElement.tagName=="TR") && (current!=self.event.srcElement.parentElement)) {
		if (current!=null){
			current.style.backgroundColor = current._background;
			current.style.color = current._font;
		}
		self.event.srcElement.parentElement._background = self.event.srcElement.parentElement.style.backgroundColor;
		self.event.srcElement.parentElement._font = self.event.srcElement.parentElement.style.color;
		self.event.srcElement.parentElement.style.backgroundColor = "#F5CE6C";
		self.event.srcElement.parentElement.style.color = "";
		current = self.event.srcElement.parentElement;
	}
}
</script>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="/style/agents/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title {  background-color: #86C0A6; text-align: center}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="reload_table();">
	<br>
<div id="show_table" ></div>
<div id="showlayer" style="display: none;">
	<table width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
		<tr class="m_title">
			<td width="300" align="center">資訊網</td>
		</tr>
		*SHOWLIST*
	</table>
<div>
<!-- 琩礚戈 start -->
<div id="no_data" style="display: none;">
	<table align="center" width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
		<tr class="m_title">
			<td width="300" align="center">*WEBSET*</td>
		</tr>
	</table>
</div>
<!-- 琩礚戈 end -->

<div id="show_tr" style="display: none;">
	<tr onMouseOver="colorTRx(0)" onMouseOut="colorTRx(1)" class="m_cen" >
		<td>*MSG*</td>
	</tr>
</div>
</body>
</html>