<script>
var msg = '';
var grp_show = 'Y';
</script>
<script>
top.str_FT = "����";
top.str_FS = "�ھ�";
top.str_BK = "����";
top.str_TN = "����";
top.str_VB = "����";
top.str_BS = "����";
top.str_OP = "����";

//���ö��
top.str_maxcre = "�����ö�Ƚ�����������!!";

top.str_gopen = "����";
top.str_gameclose = "�ر�";
top.str_gopenY = "�Ƿ�ȷ�����̿���";
top.str_gopenN = "�Ƿ�ȷ�����̹ر�";
top.str_strongH = "�Ƿ�ȷ��ǿ������";
top.str_strongC = "�Ƿ�ȷ��ǿ������";
top.str_close_ioratio = "�Ƿ�ȷ���ر�����";
top.str_checknum = "��֤�����,����������";

//�¹ھ�
top.str_scoreY = "��";
top.str_scoreN = "ʤ";
top.str_change = "ȷ�����ý��!!";
top.str_eliminate = "�Ƿ���̭";
top.str_format = "��������ȷ��ʽ";
top.str_close_time = "�Ƿ�ȷ���ر�ʱ��??"
top.str_check_date = "�������ڸ�ʽ !!";
top.str_champ_win = "�ھ��Ƿ�Ϊ:";
top.str_champ_wins = "����ȷ�Ϲھ��Ƿ�Ϊ:";
top.str_NOchamp = "��ʤ�����飬�������趨!!";
top.str_NOloser = "����̭���飬�������趨!!";

//�ʺ�
top.str_co = "�ɶ�";
top.str_su = "�ܴ���";
top.str_ag = "������";
top.str_input_account = "�ʺ����������!!";
top.str_input_alias = "�������������!!";
top.str_input_credit = "���ö�����������!!";
top.str_confirm_add_su = "�Ƿ�ȷ��д���ܴ���?";

//����
top.str_input_pwd = "�������������!!";
top.str_input_repwd = "ȷ���������������!!";
top.str_input_pwd2 = top.str_input_pwd;
top.str_input_repwd2 = top.str_input_repwd;
top.str_pwd_limit = "�����������6��12����Ԫ��,��ֻ��ʹ�����ֺ�Ӣ����ĸ������ 1 ��Ӣ����ĸ,����������Ų���ʹ�� ��";
top.str_pwd_limit2 = "����������ʹ����ĸ��������!!";
top.str_err_pwd = "����ȷ�ϴ���,����������!!";
top.str_err_pwd_fail = "����������ʹ�ù�, Ϊ�˰�ȫ���, ��ʹ��������!!";

//�p����}
top.dPrivate="˽��";
top.dPublic="����";
top.grep="Ⱥ��";
top.grepIP="Ⱥ��IP";
top.IP_list="IP�б�";
top.Group="���";
top.choice="��ѡ��";
top.webset="��T��";</script>

<script>
function reload_table() {
	//alert("aaa===>"+grp_show);
	if (grp_show == "Y") {
		var shows = document.getElementById("showlayer").innerHTML; //=== �ĤG�h div
		var tr_data = document.getElementById("show_tr").innerHTML; //=== �ĤT�h div
		var AllLayer = ""; //=== �ĤT�h div
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


//����
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
			<td width="300" align="center">�YӍ�W</td>
		</tr>
		*SHOWLIST*
	</table>
<div>
<!-- �d�L��Ʈ� start -->
<div id="no_data" style="display: none;">
	<table align="center" width="300" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" >
		<tr class="m_title">
			<td width="300" align="center">*WEBSET*</td>
		</tr>
	</table>
</div>
<!-- �d�L��Ʈ� end -->

<div id="show_tr" style="display: none;">
	<tr onMouseOver="colorTRx(0)" onMouseOut="colorTRx(1)" class="m_cen" >
		<td>*MSG*</td>
	</tr>
</div>
</body>
</html>