<%@ Page language="c#" Codebehind="addsubuser.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.addsubuser" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>addsubuser</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" href="css/css.css" type="text/css">
		<script language="javascript" type="text/javascript">
			var obj = document.all;
			//����������
			function open_win()
			{	
				addsubdiv.style.top = document.body.scrollTop + event.clientY + 15;
				addsubdiv.style.left= document.body.scrollLeft+ event.clientX;
				addsubdiv.style.display = "block";
			}
			//�رմ���
			function close_win()
			{
				addsubdiv.style.display = "none";
			}		
			function close_editwin()
			{
				editsubdiv.style.display = "none";
			}
			//�ύǰ�Ĵ���
			function chk_deal()
			{
				obj["submitflag"].value = 'dosubmit';
				if(addsubdiv.style.display == "block")
				{
					if(obj["subname"].value == '')
					{
						alert("�ʺŲ���Ϊ�գ�");
						obj["subname"].focus();
						return false
					}
					if(obj["subpass"].value == '')
					{
						alert("���벻��Ϊ�գ�");
						obj["subpass"].focus();
						return false;
					}
					close_win();
				}
				else
				{
					close_editwin();
				}
				return true;
			}
		</script>
	</HEAD>
	<body topmargin="1">
		<form id="addsubform" method="post" runat="server" onsubmit="return chk_deal();">
			<table width="500" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="middle">
						&nbsp;&nbsp;���ʺţ�&nbsp;
						<asp:DropDownList ID="showlist" Runat="server" AutoPostBack="True" OnSelectedIndexChanged="showlist_SelectIndexChanged">
							<asp:ListItem Value="">ȫ����ʾ</asp:ListItem>
							<asp:ListItem Value="1">����</asp:ListItem>
							<asp:ListItem Value="0">ͣ��</asp:ListItem>
						</asp:DropDownList>&nbsp;&nbsp; <input type="button" name="buttonadd" onclick="open_win();" class="Text" value="�� ��">
					</td>
				</tr>
			</table>
			<asp:DataGrid ID="subuserlist" OnItemDataBound="subuserlist_DataGridBand" AutoGenerateColumns="False"
				HeaderStyle-CssClass="blueheader" ItemStyle-BackColor="#ffffff" ItemStyle-Height="22" OnItemCommand="subuserlist_ItemCommand"
				Runat="server" Width="470px" BorderColor="Black">
				<ItemStyle Height="22px" BorderColor="Black" BackColor="White"></ItemStyle>
				<HeaderStyle CssClass="blueheader"></HeaderStyle>
				<Columns>
					<asp:BoundColumn Visible="False" DataField="subid"></asp:BoundColumn>
					<asp:BoundColumn DataField="truename" HeaderText="����"></asp:BoundColumn>
					<asp:BoundColumn DataField="subname" HeaderText="��Ա�ʺ�"></asp:BoundColumn>
					<asp:BoundColumn DataField="regtime" HeaderText="ע������"></asp:BoundColumn>
					<asp:TemplateColumn HeaderText="״̬">
						<ItemTemplate>
							<%# showuseable(DataBinder.Eval(Container.DataItem,"isuseable").ToString())%>
						</ItemTemplate>
					</asp:TemplateColumn>
					<asp:TemplateColumn HeaderText="����">
						<ItemTemplate>
							<asp:LinkButton ID="useable" CommandName="useable" CssClass="hander" Runat="server">
								<%# showuseablebutton(DataBinder.Eval(Container.DataItem,"isuseable").ToString())%>
							</asp:LinkButton>&nbsp;/&nbsp;
							<asp:LinkButton ID="delsub" CommandName="delsub" CssClass="hander" Runat="server">ɾ��</asp:LinkButton>&nbsp;/&nbsp;
							<asp:LinkButton ID="editsub" CommandName="editsub" CssClass="hander" Runat="server">�޸�</asp:LinkButton>
						</ItemTemplate>
					</asp:TemplateColumn>
					<asp:BoundColumn Visible="False" DataField="isuseable"></asp:BoundColumn>
					<asp:BoundColumn Visible="False" DataField="subpass"></asp:BoundColumn>
				</Columns>
			</asp:DataGrid>
			<div id="addsubdiv" style="DISPLAY: none;POSITION: absolute">
				<table border="0" cellspacing="1" cellpadding="0" width="300" bgcolor="gray">
					<tr height="20" valign="middle">
						<td bgcolor="#0163a2" width="100%">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="250" bgcolor="#0163a2"><font color="#ffffff">&nbsp;�������ʻ���</font></td>
									<td align="right" valign="middle"><a class="hander" onClick="close_win();"><img src="images/edit_dot.gif" width="16" height="14"></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgcolor="#a4c0ce">
						<td colspan="2" height="18">
							�ʺţ�<input type="text" name="subname" size="8">&nbsp; ���룺<input type="password" name="subpass" size="8">
						</td>
					</tr>
					<tr bgcolor="#a4c0ce">
						<td height="18">
							���ƣ�<input type="text" name="truename" size="8">&nbsp; ״̬��<select name="isuseable">
								<option value="0" selected>ͣ��</option>
								<option value="1">����</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#a4c0ce">
						<td height="18" align="center">
							<input type="submit" name="submitbutton" value="ȷ ��" class="Text">
						</td>
					</tr>
				</table>
				<input id="submitflag" type="hidden" name="submitflag" runat="server">
			</div>
			<div id="editsubdiv" style="DISPLAY: none; POSITION: absolute" runat="server">
				<table cellSpacing="1" cellPadding="0" width="300" bgColor="gray" border="0">
					<tr vAlign="middle" height="20">
						<td width="100%" bgColor="#0163a2">
							<table cellSpacing="0" cellPadding="0" width="100%" border="0">
								<tr>
									<td width="250" bgColor="#0163a2"><font color="#ffffff">&nbsp;�޸����ʻ���</font></td>
									<td vAlign="middle" align="right"><a class="hander" onclick="close_editwin();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td colSpan="2" height="18">
							���ƣ�<input id="edittruename" type="text" size="8" runat="server" NAME="editsubname">&nbsp; 
							���룺<input id="editsubpass" type="password" size="8" runat="server" NAME="editsubpass"><font color="red">���Ĳ���</font>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td align="center" height="18"><input class="Text" type="submit" value="ȷ ��" name="submitbutton">
						</td>
					</tr>
				</table>
				<input type="hidden" id="subid" name="subid" runat="server">
			</div>
		</form>
	</body>
</HTML>
