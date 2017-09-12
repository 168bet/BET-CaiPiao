<%@ Page language="c#" Codebehind="system800add.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.system800add" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>system800add</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<link href="css/css.css" type="text/css" rel="stylesheet">
		<script language=javascript type=text/javascript>
			function checksys800add()
			{
				if(document.Form1.username.value == "")
				{
					alert('会员帐号不能为空！');
					return false;
				}
				if(document.Form1.amount.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1 )
				{					
					alert('请填写正确的数额！');
					return false;
				}
				else if(document.Form1.amount.value == "0")
				{
					alert("数额不能为零！");
					return false;
				}
							
				return true;
			}
		</script>
	</HEAD>
	<body>
		<form id="Form1" method="post" runat="server" onsubmit="return checksys800add();">
			<table cellSpacing="0" cellPadding="0" width="500" border="0">
				<tr>
					<td class="m_tline">&nbsp;&nbsp;新增&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<a href="system800.aspx">返回</a></td>
					<td width="30"><img height="24" src="images/top_04.gif" width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" cellpadding="2" cellspacing="1" class="tableNoBorder1" width="400">
				<tr class="tableBody1">
					<td width="100">会员帐号</td>
					<td width="350">
						<asp:dropdownlist ID="username" Runat="server">
							<asp:ListItem></asp:ListItem>
						</asp:dropdownlist>
					</td>
				</tr>
				<tr class="tableBody1">
					<td>付帐方式</td>
					<td>
						<asp:DropDownList ID="paytype" Runat="server">
							<asp:ListItem Value="Credit Card">信用卡转帐</asp:ListItem>
							<asp:ListItem Value="ATM">自动提款  转帐</asp:ListItem>
							<asp:ListItem Value="Transfer">银行转帐</asp:ListItem>
						</asp:DropDownList>
						<asp:TextBox ID="paytypeno" Runat="server" Columns="20" TextMode="SingleLine" MaxLength="30"></asp:TextBox>
					</td>
				</tr>
				<tr class="tableBody1">
					<td>现金/信用</td>
					<td>
						<input id="usertype1" type="radio" value="按金" checked name="usertype" runat="server">按金&nbsp;
						<input id="usertype2" type="radio" value="现金提款" name="usertype" runat="server">现金提款
					</td>
				</tr>
				<tr class="tableBody1">
					<td>数额</td>
					<td>
						<asp:TextBox ID="amount" Runat="server" Columns="10" TextMode="SingleLine" MaxLength="10"></asp:TextBox><!--
						<label id="amounthiden" runat="server" style="WIDTH: 100px; BORDER-TOP-STYLE: none; BORDER-RIGHT-STYLE: none; BORDER-LEFT-STYLE: none; HEIGHT: 20px; BACKGROUND-COLOR: #efefef; BORDER-BOTTOM-STYLE: none">
						</label>-->
					</td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td height="8" width="100%"></td>
				</tr>
				<tr>
					<td width="100%">&nbsp;&nbsp;
						<asp:Button ID='addsys800' Runat="server" Text='存储'></asp:Button>&nbsp;&nbsp;<!--
						<asp:Button ID="clearsys800" Runat="server" Text='清除'></asp:Button>-->
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
