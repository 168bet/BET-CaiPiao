<%@ Page language="c#" Codebehind="useradd.aspx.cs" AutoEventWireup="false" Inherits="newball.zdl.useradd" %>
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
		<script>
		function setCurrentCreditLocal() {
			var creditlimit_local = parseInt(document.myForm.TextBoxUseMoney.value * document.myForm.DropDownListRate.value);
			try
			{
			if (creditlimit_local > 0) {
				document.getElementById('creditlimit_local').innerHTML = creditlimit_local;
				//document.myForm.fr_selcurr_rate.value = document.getElementById('rate_'+document.myForm.DropDownListRate.value).innerHTML;
			}else{
				document.getElementById('creditlimit_local').innerHTML = '';
				//document.myForm.fr_selcurr_rate.value = '';
			}
			document.getElementById('exchange_rate').innerHTML = document.myForm.DropDownListRate.value;
			}
			catch(e){}
		}
		
		function onBodyLoad() {
			setCurrentCreditLocal();
		}	
		</script>
	</HEAD>
	<body leftMargin="5" topMargin="1" onLoad="onBodyLoad()">
		<form id="myForm" method="post" runat="server" onsubmit="return CheckForm();">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="700" border="0">
					<TR>
						<TD colSpan="3"><FONT face="宋体">新增会员&nbsp;&nbsp;&nbsp;&nbsp;总代理:
								<asp:Label id="LabelZdl" runat="server">Label</asp:Label></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table2" cellSpacing="1" cellPadding="0" width="450" bgColor="#000000" border="0">
								<TR>
									<TD class="addmember" align="center" colSpan="2" height="25">资料</TD>
								</TR>
								<TR>
									<TD class="TableBody1" style="WIDTH: 182px" align="left" colSpan="2">
										<TABLE id="Table3" cellSpacing="0" cellPadding="5" width="450" border="0">
											<TR>
												<TD>代理商</TD>
												<TD>
													<asp:TextBox id="TextBoxGdid" runat="server" Width="32px" Visible="False"></asp:TextBox>
													<asp:TextBox id="TextBoxGdName" runat="server" Width="32px" Visible="False"></asp:TextBox></TD>
												<TD>
													<asp:DropDownList id="DropDownListDls" runat="server" AutoPostBack="True" OnSelectedIndexChanged="DropDownListDls_SelectedIndexChanged"></asp:DropDownList>
													<asp:Label id="LabelUseMoney" runat="server">Label</asp:Label></TD>
											</TR>
											<TR>
												<TD>会员帐号</TD>
												<TD align="right">
													<asp:TextBox id="TextBoxUserName" runat="server" ReadOnly="True" CssClass="Text" BorderWidth="0px"
														Width="80px" ForeColor="#ff0000" Font-Bold="True"></asp:TextBox></TD>
												<TD>
													
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
													</asp:DropDownList></TD>
											</TR>
											<TR>
												<TD>密码</TD>
												<TD></TD>
												<TD>
													<asp:TextBox id="TextBoxNewpass1" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></TD>
											</TR>
											<TR>
												<TD>确认密码</TD>
												<TD></TD>
												<TD>
													<asp:TextBox id="TextBoxNewpass2" runat="server" CssClass="Text" TextMode="Password"></asp:TextBox></TD>
											</TR>
											<TR>
												<TD>名称</TD>
												<TD></TD>
												<TD>
													<asp:TextBox id="TextBoxTrueName" runat="server" CssClass="Text"></asp:TextBox></TD>
											</TR>
											<TR>
												<TD>电话号码</TD>
												<TD></TD>
												<TD>
													<asp:TextBox id="TextBoxTel" runat="server" CssClass="Text"></asp:TextBox></TD>
											</TR>
										</TABLE>
									</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="Table4" cellSpacing="1" cellPadding="0" width="500" bgColor="#000000" border="0">
								<TR>
									<TD class="addmember" align="center" colSpan="2" height="25">下注设定</TD>
								</TR>
								<TR>
									<TD class="TableBody1" align="left" colSpan="2">
										<TABLE id="Table5" cellSpacing="0" cellPadding="5" width="500" border="0">
											<TR>
												<TD width="100">水位</TD>
												<TD width="100"></TD>
												<TD width="300">
													<asp:DropDownList id="DropDownListABC" runat="server">
														<asp:ListItem Value="A">A</asp:ListItem>
														<asp:ListItem Value="B">B</asp:ListItem>
														<asp:ListItem Value="C" Selected="True">C</asp:ListItem>
														<asp:ListItem Value="D">D</asp:ListItem>
													</asp:DropDownList></TD>
											</TR>
											<TR>
												<TD>赔类种类</TD>
												<TD></TD>
												<TD>
													<asp:DropDownList id="DropDownListPlType" runat="server">
														<asp:ListItem Value="香港盘" Selected="True">香港盘</asp:ListItem>
													</asp:DropDownList></TD>
											</TR>
											<TR>
												<TD>信用/现金</TD>
												<TD align="right"></TD>
												<TD>
													<asp:RadioButton id="RadioButton1" runat="server" Text="信用" Checked="True" GroupName="1"></asp:RadioButton>
													<asp:RadioButton id="RadioButton2" runat="server" Text="现金" GroupName="1" Visible="False"></asp:RadioButton></TD>
											</TR>
											<TR>
												<TD>货币代码</TD>
												<TD></TD>
												<TD>
													<asp:DropDownList id="DropDownListRate" runat="server"></asp:DropDownList>况换率:<span id="exchange_rate" style="COLOR:red"></span></TD>
											</TR>
											<TR>
												<TD>信用额度</TD>
												<TD></TD>
												<TD>
													<asp:TextBox id="TextBoxUseMoney" runat="server" Width="100px"></asp:TextBox>&nbsp;CNY:&nbsp;<span id='creditlimit_local' style="COLOR:red"></span></TD>
											</TR>
										</TABLE>
									</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3"><FONT face="宋体"><FONT face="宋体">
									<asp:Button id="ButtonSave" runat="server" CssClass="Text" Text="保 存"></asp:Button>&nbsp;&nbsp;&nbsp;&nbsp;
									<asp:Button id="ButtonCancel" runat="server" CssClass="Text" Text="取 消"></asp:Button></FONT></FONT></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
		<script>
		
		myForm.TextBoxUserName.value = myForm.DropDownListDls.options[myForm.DropDownListDls.options.selectedIndex].text.substring(0,5) + myForm.DropDownListName2.value+myForm.DropDownListName3.value;
		function account()
		{
			myForm.TextBoxUserName.value = myForm.DropDownListDls.options[myForm.DropDownListDls.options.selectedIndex].text.substring(0,5) + myForm.DropDownListName2.value+myForm.DropDownListName3.value;
		}
		
		function CheckForm()
		{
			/*if(parseInt(Form1.DropDownListGdBl.value) + parseInt(Form1.DropDownListZdlBl.value) + parseInt(Form1.DropDownListDlsBl.value) > 100)
			{
				alert('股东,总代理和代理商的比例相加不能大于100');
				return false;				
			}
			else
				return true;*/
				return true;
		}	
		</script>
	</body>
</HTML>
