<%@ Page language="c#" Codebehind="adduser.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.adduserform" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>adduser</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link href="css/css.css" type="text/css" rel="stylesheet">
		<script language="javascript" type="text/javascript">
		function chgAccount()
		{
			var tmpStr="";
			tmpStr = document.getElementById("username").innerText;
			document.getElementById("username").innerText = tmpStr.substr(0,5) + document.adduserform.num_2.value + document.adduserform.num_3.value; 
			document.all.usernamehid.value = document.getElementById("username").innerText;
		}
		function checkSubmit()
		{
			if(document.all.userid.value == '')
			{
				if(document.all.userpass.value == '')
				{
					document.all.userpass.focus();
					alert("����������!!");
					return false;
				}
				if(document.all.reuserpass.value==''){
					document.all.reuserpass.focus();
					alert("������ȷ������!!");
					return false;
				}
			}
			if(document.all.reuserpass.value != document.all.userpass.value)
			{
				document.all.userpass.focus();
				alert("������������벻һ��");
				return false;
			}			
			if(document.all.truename.value==''){
				document.all.truename.focus();
				alert("�������Ա����!!");
				return false;
			}
			if(document.all.usemoney.value=='')
			{
				document.all.usemoney.focus();
				alert("�����������ö��");
				return false;
			}
			if(document.all.usemoney.value=='0'){
				document.all.usemoney.focus();
				alert("�����������ö��");
				return false;				
			}
			if(document.getElementById("leftMoneyTr").style.display != "none")
			{
				if(document.all.leftMoneyValue.value == '' || document.all.leftMoneyValue.value == '0'){
					document.all.leftMoneyValue.focus();
					alert("��������ʱ���ö��");
					return false;
				} 
			}
			return true;
		}
		function onchgmoneysort(varthis)
		{
			document.getElementById("moneysortview").innerHTML = varthis;
		}
		</script>
	</HEAD>
	<body>
		<form id="adduserform" onsubmit="return checkSubmit();" method="post" runat="server">
			<table cellSpacing="0" cellPadding="0" width="778" border="0">
				<tr>
					<td class="m_tline"><label id="headtitle" runat="server">&nbsp;&nbsp;��Ա����&nbsp;��&nbsp;&nbsp;
							<A href="javascript:history.go(-1)">����һҳ</A> </label>
					</td>
					<td width="30"><IMG height="24" src="images/top_04.gif" width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			<table class="tableNoBorder1" cellSpacing="1" cellPadding="2" width="755" border="0">
				<tr class="dlsheader">
					<td colSpan="2">���������趨</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">������:</td>
					<td class="TableBody1"><select id="dls" onchange="chgAccount()" name="dls" runat="server" disabled>
							<option value="" selected></option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right" width="120">�ʺ�:<font color="red"><label id="username" runat="server">cni</label></font></td>
					<td class="TableBody1">
						<select id="num_2" style="BORDER-RIGHT: 0px solid; BORDER-TOP: 0px solid; BORDER-LEFT: 0px solid; BORDER-BOTTOM: 0px solid"
							onchange="chgAccount()" size="1" name="num_2" runat="server">
							<option value="0" selected>0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
						</select>
						<select id="num_3" style="BORDER-RIGHT: 0px solid; BORDER-TOP: 0px solid; BORDER-LEFT: 0px solid; BORDER-BOTTOM: 0px solid"
							onchange="chgAccount()" size="1" name="num_3" runat="server">
							<option value="0" selected>0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
						</select>&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">�� ��:</td>
					<td class="TableBody1"><input id="userpass" type="password" maxLength="10" size="10" name="userpass" runat="server"><font color="red"><label id="passchangeview" runat="server"></label></font>
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">ȷ������:</td>
					<td class="TableBody1"><input id="reuserpass" type="password" maxLength="10" size="10" name="reuserpass" runat="server"
							autocomplete="on">
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">��Ա����:</td>
					<td class="TableBody1"><input id="truename" type="text" maxLength="10" size="10" name="truename" runat="server">
					</td>
				</tr>
				<tr>
					<td class="TableBody1" align="right">�绰����:</td>
					<td class="TableBody1"><input id="tel" type="text" maxLength="20" size="10" name="tel" runat="server">
					</td>
				</tr>
			</table>
			============================================================================================================
			<table class="tableNoBorder1" cellSpacing="1" cellPadding="0" width="755" border="0">
				<tr class="dlsheader">
					<td colSpan="2">��ע�����趨</td>
				</tr>
				<tr class="TableBody1">
					<td align="right" width="120">��������:</td>
					<td><select id="ABC" name="ABC" runat="server">
							<option value="D">D��</option>
							<option value="C" selected>C��</option>
							<option value="B">B��</option>
							<option value="A">A��</option>
						</select>
					</td>
				</tr>
				<tr class="TableBody1">
					<td align="right">��������:</td>
					<td><select id="pltype" name="pltype" runat="server">
							<option value="�����" selected>�����</option>
						</select>
					</td>
				</tr>
				<tr class="TableBody1">
					<td align="right">����:</td>
					<td vAlign="middle"><label id="credit" runat="server"><input id="usertype" type="radio" value="����" name="usertype" runat="server">����&nbsp;</label>
						<label runat="server" id="cash"><input id="usertype1" type="radio" value="�ֽ�" runat="server" style="DISPLAY:none"></label>
					</td>
				</tr>
				<tr class="TableBody1">
					<td align="right">ʹ�ñ���:</td>
					<td><SELECT id="moneysort" onchange="onchgmoneysort(this.value);" name="moneysort" runat="server"></SELECT>
						&nbsp;���ʣ�<FONT color="#ff0000"><label id="moneysortview" runat="server">1.00000</label></FONT>
					</td>
				</tr>
				<tr class="TableBody1">
					<td align="right">���ö��:</td>
					<td><input id="usemoney" type="text" maxLength="10" size="10" name="usemoney" runat="server">&nbsp;<font color="red">CNY</font>
					</td>
				</tr>
				<tr class="TableBody1" runat="server" id="leftMoneyTr" style="DISPLAY:none">
					<td align="right">��ʱ���ö��:</td>
					<td><input id="leftMoneyValue" type="text" maxLength="10" size="10" runat="server"></td>
				</tr>
				<tr class="TableBody1">
					<td vAlign="middle" align="center" colSpan="2"><input id="addbutton" type="submit" value="ȷ ��" name="addbutton" runat="server">
						&nbsp; &nbsp; <input id="cancelbutton" onclick="javascript:window.location = 'mgruser.aspx';" type="button"
							value="�� ��" name="cancelbutton">
					</td>
				</tr>
			</table>
			<input id="userid" type="hidden" name="userid" runat="server"> <input id="usernamehid" type="hidden" name="usernamehid" runat="server">
		</form>
		<script language="javascript" type="text/javascript">
	document.all.userpass.value = "<%= pubpass%>";
	document.all.reuserpass.value = "<%= pubpass%>";
		</script>
	</body>
</HTML>
