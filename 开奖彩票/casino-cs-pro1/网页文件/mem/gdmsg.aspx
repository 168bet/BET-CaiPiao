<%@ Page language="c#" Codebehind="gdmsg.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gdmsg" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>adminmsg</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script>
			function RefreshList()
			{
				while (Form1.DropDownListGsGd.length){document.Form1.DropDownListGsGd.options[0]=null;}
				for(var i=parseInt(Form1.DropDownListBL.value),j=0;i<=100;i+=1,j++)
				{
					document.Form1.DropDownListGsGd.options[j]=new Option(i+' %',i);
					if(i == parseInt(Form1.DropDownListBL.value)) 
						document.Form1.DropDownListGsGd.selectedIndex=j;
				}
			}
		</script>			
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="700" border="0">
					<TR>
						<TD colSpan="3"><FONT face="����">�ɶ����� &gt;&gt; �޸� --<a href="gdlist.aspx">������ҳ</a></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="100%" border="0" bgcolor="#000000">
								<TR bgcolor="#3399cc">
									<TD colSpan="2" align="center" style="COLOR: white">���������趨</TD>
								</TR>
								<TR>
									<TD style="WIDTH: 182px" align="right" class="TableBody1"><FONT face="����">�ʺ�:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUserName" runat="server" CssClass="Text" ReadOnly="True" BorderWidth="0px"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD align="right" class="TableBody1"><FONT face="����">������:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD align="right" class="TableBody1"><FONT face="����">ȷ������:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD align="right" class="TableBody1"><FONT face="����">�ɶ�����:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text" MaxLength="8"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD align="right" class="TableBody1"><FONT face="����"><FONT face="����">��˾����</FONT>:</FONT></TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListBL" runat="server">
											<asp:ListItem Value="0">0 %</asp:ListItem>
											<asp:ListItem Value="10">10 %</asp:ListItem>
											<asp:ListItem Value="20">20 %</asp:ListItem>
											<asp:ListItem Value="30">30 %</asp:ListItem>
											<asp:ListItem Value="40">40 %</asp:ListItem>
											<asp:ListItem Value="50">50 %</asp:ListItem>
											<asp:ListItem Value="60">60 %</asp:ListItem>
											<asp:ListItem Value="70">70 %</asp:ListItem>
											<asp:ListItem Value="80">80 %</asp:ListItem>
											<asp:ListItem Value="90">90 %</asp:ListItem>
											<asp:ListItem Value="100">100 %</asp:ListItem>
										</asp:DropDownList>
										<asp:TextBox id="TextBoxGdID" runat="server" Visible="False"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����"><FONT face="����">��˾+�ɶ���ͳ���:</FONT></FONT></TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListGsGd" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�����ö��:</TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxUseMoney" runat="server" CssClass="Text"></asp:textbox>&nbsp;
										<asp:Label id="Label1" runat="server" Width="288px">Label</asp:Label>
									</TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">����Ա��:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox><font color="red">(0Ϊ������)</font></TD>
								</TR>
								<TR>
									<TD colSpan="2" class="TableBody1" align="center"><FONT face="����">
											<asp:Button id="ButtonModify" runat="server" Text="�� ��" CssClass="Text"></asp:Button>&nbsp;&nbsp;
											<asp:Button id="ButtonSave" runat="server" Text="�� ��" CssClass="Text"></asp:Button>&nbsp;&nbsp;
											<asp:Button id="ButtonCancel" runat="server" Text="�� ��" CssClass="Text"></asp:Button></FONT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="����"></FONT></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
		<script language="javascript" type="text/javascript">
	document.all.TextBoxNewpass1.value = "<%= pubshowpass%>";
	document.all.TextBoxNewpass2.value = "<%= pubshowpass%>";
		</script>
	</body>
</HTML>
