<%@ Page language="c#" Codebehind="dlsmsg.aspx.cs" AutoEventWireup="false" Inherits="newball.zdl.dlsmsg" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>gdmsg</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server" onsubmit="return CheckForm();">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="1000" border="0">
					<TR>
						<TD colSpan="3"><FONT face="宋体">代理商 总代理:
								<asp:Label id="LabelZdl" runat="server">Label</asp:Label>
								&nbsp; 修改代理商 --<A href="dlslist.aspx">返回上页</A></FONT></TD>
					</TR>
					<TR>
						<TD align="left" colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="3" width="60%" bgColor="#000000" border="0">
								<TR>
									<TD class="pinkheader" align="center" colSpan="2">基本资料设定</TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 150px" align="right"><FONT face="宋体">代理商帐号:</FONT></TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxUserName" runat="server" BorderWidth="0px" ReadOnly="True" CssClass="Text"></asp:textbox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">新密码:</FONT></TD>
									<TD class="TableBody1"><FONT face="宋体" color="#ff0000"><asp:textbox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:textbox>
											<asp:textbox id="TextBoxDlsID" runat="server" Visible="False"></asp:textbox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">确定密码:</FONT></TD>
									<TD class="TableBody1"><FONT face="宋体" color="#ff0000"><asp:textbox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:textbox></FONT></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">代理商名称:</FONT></TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:textbox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">电话:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxTel" runat="server" CssClass="Text" Width="216px"></asp:TextBox></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right"><FONT face="宋体">帐号状态:</FONT></TD>
									<TD class="TableBody1"><asp:dropdownlist id="DropDownListIsUseAble" runat="server">
											<asp:ListItem Value="1" Selected="True">启用</asp:ListItem>
											<asp:ListItem Value="0">停用</asp:ListItem>
										</asp:dropdownlist></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">总信用额度:</TD>
									<TD class="TableBody1"><asp:textbox id="TextBoxUseMoney" runat="server" CssClass="Text"></asp:textbox>&nbsp;
										<asp:Label id="Label1" runat="server" Width="288px">Label</asp:Label></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">最大会员数:</TD>
									<TD class="TableBody1">
										<asp:TextBox id="TextBoxMaxMem" runat="server" CssClass="Text">0</asp:TextBox><font color="red">(0为无限制)</font></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">总代理成数:</TD>
									<TD class="TableBody1">
										<asp:Label id="LabelZdlBl" runat="server">Label</asp:Label></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="right">代理商成数:</TD>
									<TD class="TableBody1">
										<asp:Label id="LabelDlsBl" runat="server">Label</asp:Label></TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="center" colSpan="2"><FONT face="宋体"><asp:button id="ButtonModify" runat="server" CssClass="Text" Text="修 改"></asp:button>&nbsp;&nbsp;
											<asp:button id="ButtonSave" runat="server" CssClass="Text" Text="保 存"></asp:button>&nbsp;&nbsp;
											<asp:button id="ButtonCancel" runat="server" CssClass="Text" Text="返 回"></asp:button></FONT></TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR height="22">
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
					</TR>
				</TABLE>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>&nbsp;</P>
				<P>
			</FONT>&nbsp;</P></form>
		<script>
		try
		{
			Form1.TextBoxUserName.value = Form1.DropDownListZdl.options[Form1.DropDownListZdl.options.selectedIndex].text.substring(0,2) + Form1.DropDownListName1.value+Form1.DropDownListName2.value+Form1.DropDownListName3.value;
		}
		catch(e){}
		function account()
		{
			Form1.TextBoxUserName.value = Form1.DropDownListZdl.options[Form1.DropDownListZdl.options.selectedIndex].text.substring(0,2) + Form1.DropDownListName1.value+Form1.DropDownListName2.value+Form1.DropDownListName3.value;
		}
		
		function chgzdl()
		{
			if(parseInt(Form1.DropDownListGsBl.value) + parseInt(Form1.DropDownListGdBl.value) + parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100)
			{
				alert('公司,股东,总代理和代理商的比例相加不能大于100');
				Form1.DropDownListZdlBl.value = 0;
				return;
			}
			else
				Form1.DropDownListDlsBl.value=100-parseInt(Form1.DropDownListGsBl.value) -Form1.DropDownListGdBl.value-Form1.DropDownListZdlBl.value; 
		}
		function chgdls()
		{
			if(parseInt(Form1.DropDownListGsBl.value) + parseInt(Form1.DropDownListGdBl.value) + parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100)
			{
				alert('公司,股东,总代理和代理商的比例相加不能大于100');
				Form1.DropDownListDlsBl.value = 0;
				return;
			}
			else			
				Form1.DropDownListZdlBl.value=100-parseInt(Form1.DropDownListGsBl.value) -Form1.DropDownListGdBl.value-Form1.DropDownListDlsBl.value; 
		}			
		
		function CheckForm()
		{
			if(parseInt(Form1.DropDownListGsBl.value) + parseInt(Form1.DropDownListGdBl.value) + parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100)
			{
				alert('公司,股东,总代理和代理商的比例相加不能大于100');
				return false;				
			}
			else
				return true;
		}	
		document.all.TextBoxNewpass1.value = "<%= pubshowpass%>";
		document.all.TextBoxNewpass2.value = "<%= pubshowpass%>";
		</script>
	</body>
</HTML>
