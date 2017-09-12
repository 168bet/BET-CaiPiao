<%@ Page language="c#" Codebehind="SelBallList.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.SelBallList" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>SelBallList</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script src="js/hint.js"></script>
		<script language="javascript">
			var bodywidth = 450;
			var bodyheight = 250;
			function Hint_OnLoad()
			{
				//SetBodySize(bodywidth, bodyheight);
			}
			function cli(ccc,vvv)
			{
				parent.document.all[ccc].value=vvv;
				parent.CloseHint();
			}
var  tmpList = "";
function AddToList(chk,vvv)
{
	if(chk.checked)
	{
		if(tmpList == "")
			tmpList = vvv;
		else
			tmpList += ","+vvv;
	}
	else
		tmpList = RemoveValue(vvv);
	Form1.TextBoxList.value=tmpList;
}

function RemoveValue(vvv)
{
	var newList = "";
	var tmpArray = tmpList.split(",");
	var i;
	for(i=0;i<tmpArray.length;i++)
	{
		if(tmpArray[i] != vvv)
		{
			if(newList == "")
				newList = tmpArray[i];
			else
				newList += ","+tmpArray[i]; 
		}
	}
	return newList;
}
		</script>
	</HEAD>
	<body onmousedown="Hint_OnMouseDown()" ondblclick="Hint_OnDblClick()" bgColor="#cccccc"
		leftMargin="5" topMargin="1" onload="Hint_OnLoad()" onmousedblclick="Hint_OnDblClick()">
		<form id="Form1" method="post" runat="server">
			<input id="TextBoxList" type="hidden" name="TextBoxList">
			<TABLE id="Table1" cellSpacing="0" cellPadding="0" width="420" border="0" bgcolor="#ffffff">
				<TR>
					<TD><INPUT class="text" onclick="cli('TextBoxBallid',Form1.TextBoxList.value);" type="button"
							value="确定"> <INPUT class="text" onclick="parent.CloseHint()" type="button" value="关闭"></TD>
					<TD></TD>
				</TR>
				<TR>
					<TD colSpan="2"><asp:datagrid id="DataGrid1" runat="server" AutoGenerateColumns="False" HeaderStyle-CssClass="blueheader"
							BorderWidth="1px" BorderColor="Black" Width="100%">
							<HeaderStyle Height="20px" CssClass="blueheader"></HeaderStyle>
							<Columns>
								<asp:TemplateColumn>
									<HeaderStyle Width="20px"></HeaderStyle>
									<ItemStyle HorizontalAlign="Center"></ItemStyle>
									<ItemTemplate>
										<asp:CheckBox id="cbxStatus" Checked="False" Runat="server"></asp:CheckBox>
									</ItemTemplate>
								</asp:TemplateColumn>
								<asp:BoundColumn DataField="ballid" ReadOnly="True" HeaderText="球赛ID">
									<HeaderStyle Width="50px"></HeaderStyle>
									<ItemStyle HorizontalAlign="Center"></ItemStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="sortballtime" SortExpression="sortballtime" HeaderText="开赛时间" HeaderStyle-Width="30"
									DataFormatString="{0:HH:mm}"></asp:BoundColumn>
								<asp:BoundColumn DataField="matchname" ReadOnly="True" HeaderText="联赛名">
									<HeaderStyle Width="60px"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="team1" ReadOnly="True" HeaderText="主队">
									<HeaderStyle Width="100px"></HeaderStyle>
								</asp:BoundColumn>
								<asp:BoundColumn DataField="team2" ReadOnly="True" HeaderText="客队">
									<HeaderStyle Width="100px"></HeaderStyle>
								</asp:BoundColumn>
							</Columns>
						</asp:datagrid></TD>
				</TR>
				<TR>
					<TD colSpan="2"><FONT face="宋体"></FONT></TD>
				</TR>
			</TABLE>
		</form>
	</body>
</HTML>
