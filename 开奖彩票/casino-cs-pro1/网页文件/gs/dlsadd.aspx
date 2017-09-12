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
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="700" border="0">
					<TR>
						<TD colSpan="3"><FONT face="宋体"> &nbsp;添加代理商&nbsp; --<A href="dlslist.aspx">返回上页</A></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="100%" bgColor="#000000" border="0">
								<TR>
									<TD class="pinkheader" align="center" colSpan="2">基本资料设定</TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right">股东:</TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropdownlistGd" runat="server" AutoPostBack="True"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right">总代理:</TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListZdl" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="right"><FONT face="宋体">帐号:<asp:TextBox id="TextBoxUserName" runat="server" BorderWidth="0px" CssClass="Text" ReadOnly="True" ForeColor=red Columns=4></asp:TextBox></FONT></TD>
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
									<TD class="TableBody1" align="right"><FONT face="宋体">密码:</FONT></TD>
									<TD class="TableBody1"><FONT face="宋体" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">确定密码:</FONT></TD>
									<TD class="TableBody1"><FONT face="宋体" color="#ff0000">
											<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">代理商名称:</FONT></TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">电话:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTel" runat="server" CssClass="Text"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">帐号状态:</FONT></TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListIsUseAble" runat="server">
											<asp:ListItem Value="1" Selected="True">启用</asp:ListItem>
											<asp:ListItem Value="0">停用</asp:ListItem>
										</asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">总信用额度:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxUseMoney" runat="server" CssClass="Text">0</asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">最大会员数:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox><INPUT id="TextBoxGsGdBl" type="hidden" name="Hidden1" runat="server"></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right" style="HEIGHT: 17px">总代理比例:</TD>
									<TD class="TableBody1" style="HEIGHT: 17px">
										<asp:DropDownList id="DropDownListZdlBl" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">代理商比例:</TD>
									<TD class="TableBody1">
										<asp:DropDownList id="DropDownListDlsBl" runat="server"></asp:DropDownList></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="center" colSpan="2"><FONT face="宋体">
											<asp:Button id="ButtonSave" runat="server" CssClass="Text" Text="保 存"></asp:Button>&nbsp;&nbsp;
											<asp:Button id="ButtonCancel" runat="server" CssClass="Text" Text="取 消"></asp:Button></FONT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3"></TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
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
				alert('总代理和代理商的比例相加不能大于'+(100 - parseInt(Form1.TextBoxGsGdBl.value)));
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
				alert('总代理和代理商的比例相加不能大于'+(100 - parseInt(Form1.TextBoxGsGdBl.value)));
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
				alert('总代理和代理商的比例相加不能大于'+(100 - parseInt(Form1.TextBoxGsGdBl.value)));
				return false;				
			}
			else
				return true;
		}	
		</script>
	</body>
</HTML>
