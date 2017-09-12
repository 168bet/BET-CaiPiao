<%@ Page language="c#" Codebehind="OrderEdit.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.OrderEdit" validateRequest="false" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>OrderEdit</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script>
		function SumMoney()
		{
			//try
			//{
				if(Form1.TextBoxWin.value != '' && Form1.TextBoxLose.value != '')
				{
					winmoney = parseFloat(Form1.TextBoxWin.value)-parseFloat(Form1.TextBoxLose.value);
					if(winmoney > 0)
					{
						Form1.TextBoxDlsMoney.value = winmoney + parseFloat(Form1.TextBoxTzMoney.value)*(parseFloat(Form1.TextBoxDlsHs_w.value)-parseFloat(Form1.TextBoxUserHs_w.value))/100;
						Form1.TextBoxZdlMoney.value = winmoney + parseFloat(Form1.TextBoxTzMoney.value)*(parseFloat(Form1.TextBoxZdlHs_w.value)-parseFloat(Form1.TextBoxUserHs_w.value))/100;
						Form1.TextBoxGdMoney.value = winmoney + parseFloat(Form1.TextBoxTzMoney.value)*(parseFloat(Form1.TextBoxGdHs_w.value)-parseFloat(Form1.TextBoxUserHs_w.value))/100;
						
					}
					else
					{
						Form1.TextBoxDlsMoney.value = winmoney + parseFloat(Form1.TextBoxTzMoney.value)*(parseFloat(Form1.TextBoxDlsHs_l.value)-parseFloat(Form1.TextBoxUserHs_l.value))/100;
						Form1.TextBoxZdlMoney.value = winmoney + parseFloat(Form1.TextBoxTzMoney.value)*(parseFloat(Form1.TextBoxZdlHs_l.value)-parseFloat(Form1.TextBoxUserHs_l.value))/100;
						Form1.TextBoxGdMoney.value = winmoney + parseFloat(Form1.TextBoxTzMoney.value)*(parseFloat(Form1.TextBoxGdHs_l.value)-parseFloat(Form1.TextBoxUserHs_l.value))/100;
					}
				}
			//}
			//catch(e)
			//{
			
			//}
		}
		</script>
	</HEAD>
	<body leftMargin="3" topMargin="3">
		<form id="Form1" name="Form1" method="post" runat="server">
			<table width="500" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
				<tr class="addmember">
					<td colspan="3">修改注单</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td width="105">注单号</td>
					<td colspan="2"><FONT face="宋体"></FONT>
						<asp:TextBox id="TextBoxOrderid" runat="server" CssClass="text" Width="200px" ReadOnly="True"
							BorderWidth="0px"></asp:TextBox></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td style="HEIGHT: 26px">注单内容</td>
					<td colspan="2" style="HEIGHT: 26px">
						<asp:TextBox id="TextBoxContent" runat="server" Width="360px" CssClass="Text" Height="88px" TextMode="MultiLine"></asp:TextBox></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td>下注金额</td>
					<td colspan="2">
						<asp:TextBox id="TextBoxTzMoney" runat="server" CssClass="text"></asp:TextBox></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td>下注时间</td>
					<td>
						<asp:TextBox id="TextBoxTzTime" runat="server" CssClass="text"></asp:TextBox></td>
					<td align="center">回水(赢/输)</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td>会员结果</td>
					<td width="249">赢
						<asp:TextBox id="TextBoxWin" runat="server" CssClass="text" Width="72px"></asp:TextBox>&nbsp;&nbsp;&nbsp;&nbsp; 
						输
						<asp:TextBox id="TextBoxLose" runat="server" CssClass="text" Width="72px"></asp:TextBox></td>
					<td width="124" align="center">
						<asp:TextBox id="TextBoxUserHs_w" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox><FONT face="宋体">/
							<asp:TextBox id="TextBoxUserHs_l" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox></FONT></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td>代理商结果</td>
					<td>
						<asp:TextBox id="TextBoxDlsMoney" runat="server" CssClass="text"></asp:TextBox><FONT face="宋体">(赢为正,输为负)</FONT></td>
					<td align="center"><FONT face="宋体">
							<asp:TextBox id="TextBoxDlsHs_w" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox>/</FONT>
						<asp:TextBox id="TextBoxDlsHs_l" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td>总代理结果</td>
					<td>
						<asp:TextBox id="TextBoxZdlMoney" runat="server" CssClass="text"></asp:TextBox><FONT face="宋体">(赢为正,输为负)</FONT></td>
					<td align="center"><FONT face="宋体">
							<asp:TextBox id="TextBoxZdlHs_w" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox>/
							<asp:TextBox id="TextBoxZdlHs_l" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox></FONT></td>
				</tr>
				<tr bgcolor="#ffffff">
					<td>股东结果</td>
					<td>
						<asp:TextBox id="TextBoxGdMoney" runat="server" CssClass="text"></asp:TextBox><FONT face="宋体">(赢为正,输为负)</FONT></td>
					<td align="center"><FONT face="宋体">
							<asp:TextBox id="TextBoxGdHs_w" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox>/
							<asp:TextBox id="TextBoxGdHs_l" runat="server" BorderWidth="0px" Width="50px"></asp:TextBox></FONT></td>
				</tr>
				<TR bgcolor="#ffffff">
					<td>是否已结</td>
					<TD align="left" colSpan="2">
						<asp:DropDownList id="DropDownListJs" runat="server">
							<asp:ListItem Value="0" Selected="True">未结</asp:ListItem>
							<asp:ListItem Value="1">已结</asp:ListItem>
						</asp:DropDownList></TD>
				</TR>
				<TR bgcolor="#ffffff">
					<td>是否取消</td>
					<TD align="left" colSpan="2">
						<asp:DropDownList id="DropdownlistIsCancel" runat="server">
							<asp:ListItem Value="0" Selected="True">有效</asp:ListItem>
							<asp:ListItem Value="1">取消</asp:ListItem>
						</asp:DropDownList></TD>
				</TR>
				<TR bgcolor="#ffffff">
					<td>投注队伍</td>
					<TD align="left" colSpan="2">
						<asp:TextBox id="TextBoxTzTeam" runat="server" CssClass="text"></asp:TextBox>让球/单双</TD>
				<TR bgcolor="#ffffff">
					<td>投注大小</td>
					<TD align="left" colSpan="2">
						<asp:TextBox id="TextBoxDS" runat="server" CssClass="text"></asp:TextBox></TD>
				<TR bgcolor="#ffffff">
					<td>赔率</td>
					<TD align="left" colSpan="2">
						<asp:TextBox id="TextBoxPl" runat="server" CssClass="text"></asp:TextBox></TD>
				<tr align="center" bgcolor="#ffffff">
					<td colspan="3" align="center">&nbsp;
						<asp:Button id="Button1" runat="server" CssClass="Text" Text="确  定"></asp:Button></td>
				</tr>
				<asp:TextBox Runat="server" Visible="False" ID="TextBoxTzType"></asp:TextBox>
			</table>
		</form>
	</body>
</HTML>
