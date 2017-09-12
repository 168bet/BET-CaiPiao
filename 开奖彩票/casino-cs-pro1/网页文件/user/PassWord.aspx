<%@ Page language="c#" Codebehind="PassWord.aspx.cs" AutoEventWireup="false" Inherits="newball.user.PassWord" codePage="936"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>PassWord</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
		<link rel="stylesheet" href="css/mem_body.css" type="text/css">
		<SCRIPT language="JavaScript" src="js/function-right-click.js"></SCRIPT>
		<SCRIPT language="JavaScript" src="js/function-no-copying.js"></SCRIPT>
		<SCRIPT language="JavaScript" src="js/function-no-status-msg.js"></SCRIPT>
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
	</HEAD>
	<body bgcolor="#ffffff" text="#000000" leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false">
		<form id="Form1" method="post" runat="server">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
				<tr>
					<td valign="middle">
						<table width="250" border="0" cellspacing="1" cellpadding="1" bgcolor="#e5eaee" align="center">
							<tr>
								<td>
									<table width="250"  border="1" cellpadding="0" cellspacing="0"
										bgColor="#e5eaee" >
										<TBODY>
											<tr align="center" bgcolor="#C1D7E5">
												<td height="22" colspan="2" align="center" >密码更改</td>
										  </tr>
											<TR style="BACKGROUND-COLOR: #e5eaee">
												<TH height="22"  class="b_rig_02">
													旧密码</TH>
												<TD height="22" ><FONT face="宋体">
											  <asp:TextBox id="TextBoxOldPass" runat="server" TextMode="Password"></asp:TextBox></FONT></TD>
											</TR>
											<TR style="BACKGROUND-COLOR: #e5eaee">
												<TH height="22"  class="b_rig_02">
													新密码</TH>
												<TD height="22" ><FONT face="宋体">
											  <asp:TextBox id="TextBoxNewPass1" runat="server" TextMode="Password"></asp:TextBox></FONT></TD>
											</TR>
											<TR style="BACKGROUND-COLOR: #e5eaee">
												<TH height="22" class="b_rig_02">
													确认密码</TH>
												<TD height="22" ><FONT face="宋体">
											  <asp:TextBox id="TextBoxNewPass2" runat="server" TextMode="Password"></asp:TextBox></FONT></TD>
											</TR>
											<TR style="BACKGROUND-COLOR: #e5eaee">
											  <td colspan="2"  height="22" align="center"><asp:Button id="ButtonPost" runat="server" Text="更改" class="za_button_01"></asp:Button>&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="取消" class="za_button_01" onClick="javascript:window.close();"></td>
											</TR>
										</TBODY>
								  </table>
								</td>
							</tr>
					  </table>
					</td>
				</tr>
			</table>
			<BR>
		</form>
		<BR>
		<br>
		<div id="footer"><%# System.Configuration.ConfigurationSettings.AppSettings["CopyRight"] %></div>
		<br>
	</body>
</HTML>
