<%@ Page language="c#" Codebehind="dlsadd.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.dlsadd" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>gdadd</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server" onsubmit="return CheckForm();">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="700" border="0">
					<TR>
						<TD colSpan="3"><FONT face="����"> &nbsp;��Ӵ�����&nbsp; --<A href="dlslist.aspx">������ҳ</A></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="100%" bgColor="#000000" border="0">
								<TR>
									<TD class="pinkheader" align="center" colSpan="2">���������趨</TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right">�ɶ�:</TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropdownlistGd" runat="server" AutoPostBack="True"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right">�ܴ���:</TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListZdl" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right"><FONT face="����">�ʺ�:<asp:TextBox id="TextBoxUserName" runat="server" BorderWidth="0px" CssClass="Text" ReadOnly="True" ForeColor=red Columns=4></asp:TextBox></FONT></TD>
									<TD class="TableBody1">
										
										<asp:DropDownList id="DropDownListName2" runat="server">
											<asp:ListItem Value="0">0</asp:ListItem>
											<asp:ListItem Value="1">1</asp:ListItem>
											<asp:ListItem Value="2">2</asp:ListItem>
											<asp:ListItem Value="3">3</asp:ListItem>
											<asp:ListItem Value="4">4</asp:ListItem>
											<asp:ListItem Value="5">5</asp:ListItem>
											<asp:ListItem Value="6">6</asp:ListItem>
											<asp:ListItem Value="7">7</asp:ListItem>
											<asp:ListItem Value="8">8</asp:ListItem>
											<asp:ListItem Value="9">9</asp:ListItem>											
										</asp:DropDownList>
										<asp:DropDownList id="DropDownListName3" runat="server">
											<asp:ListItem Value="0">0</asp:ListItem>
											<asp:ListItem Value="1">1</asp:ListItem>
											<asp:ListItem Value="2">2</asp:ListItem>
											<asp:ListItem Value="3">3</asp:ListItem>
											<asp:ListItem Value="4">4</asp:ListItem>
											<asp:ListItem Value="5">5</asp:ListItem>
											<asp:ListItem Value="6">6</asp:ListItem>
											<asp:ListItem Value="7">7</asp:ListItem>
											<asp:ListItem Value="8">8</asp:ListItem>
											<asp:ListItem Value="9">9</asp:ListItem>
										</asp:DropDownList>
										</TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">����:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">ȷ������:</FONT></TD>
									<TD class="TableBody1"><FONT face="����" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">����������:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�绰:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTel" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="����">�ʺ�״̬:</FONT></TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListIsUseAble" runat="server">
											<asp:ListItem Value="1" Selected="True">����</asp:ListItem>
											<asp:ListItem Value="0">ͣ��</asp:ListItem>
										</asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�����ö��:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUseMoney" runat="server" CssClass="Text">0</asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">����Ա��:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox><INPUT id="TextBoxGsGdBl" type="hidden" name="Hidden1" runat="server"></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right" style="HEIGHT: 17px">�ܴ������:</TD>
									<TD class="TableBody1" style="HEIGHT: 17px">
										<asp:DropDownList id="DropDownListZdlBl" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">�����̱���:</TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListDlsBl" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="center" colSpan="2"><FONT face="����">
											<asp:Button id="ButtonSave" runat="server" CssClass="Text" Text="�� ��"></asp:Button>&nbsp;&nbsp;
											<asp:Button id="ButtonCancel" runat="server" CssClass="Text" Text="ȡ ��"></asp:Button></FONT></TD>
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
		<script>
		
		try
		{
			Form1.TextBoxUserName.value = Form1.DropDownListZdl.options[Form1.DropDownListZdl.options.selectedIndex].text.substring(0,3) + Form1.DropDownListName2.value+Form1.DropDownListName3.value;
		}
		catch(e){}
		function account()
		{
			Form1.TextBoxUserName.value = Form1.DropDownListZdl.options[Form1.DropDownListZdl.options.selectedIndex].text.substring(0,3) + Form1.DropDownListName2.value+Form1.DropDownListName3.value;
		}
		
		function chgzdl()
		{
			if(parseInt(Form1.TextBoxGsGdBl.value) + parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100)
			{
				alert('�ܴ���ʹ����̵ı�����Ӳ��ܴ���'+(100 - parseInt(Form1.TextBoxGsGdBl.value)));
				Form1.DropDownListZdlBl.value = 0;
				return;
			}
			else
				Form1.DropDownListDlsBl.value=100-parseInt(Form1.TextBoxGsGdBl.value) - Form1.DropDownListZdlBl.value; 
		}
		function chgdls()
		{
			if( parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100 - parseInt(Form1.TextBoxGsGdBl.value))
			{
				alert('�ܴ���ʹ����̵ı�����Ӳ��ܴ���'+(100 - parseInt(Form1.TextBoxGsGdBl.value)));
				Form1.DropDownListDlsBl.value = 0;
				return;
			}
			else			
				Form1.DropDownListZdlBl.value=100-parseInt(Form1.TextBoxGsGdBl.value) - Form1.DropDownListDlsBl.value; 
		}	
		function CheckForm()
		{
			if(parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100 - parseInt(Form1.TextBoxGsGdBl.value))
			{
				alert('�ܴ���ʹ����̵ı�����Ӳ��ܴ���'+(100 - parseInt(Form1.TextBoxGsGdBl.value)));
				return false;				
			}
			else
				return true;
		}	
		</script>
	</body>
</HTML>
