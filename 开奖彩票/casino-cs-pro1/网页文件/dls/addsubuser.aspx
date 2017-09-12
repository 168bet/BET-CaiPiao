<%@ Page language="c#" Codebehind="addsubuser.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.addsubuser" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>addsubuser</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script language="javascript" type="text/javascript">
			var obj = document.all;
			//����������
			function open_win()
			{	
				addsubdiv.style.top = document.body.scrollTop + event.clientY + 15;
				addsubdiv.style.left= document.body.scrollLeft+ event.clientX;
				
				
				document.getElementById("subname").style.disabled = false;
				document.getElementById("isuseable").style.disabled = false;
				
				obj["subname"].value = "";
				obj["subpass"].value = "";
				obj["truename"].value = "";
				
				
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
					close_editwin();
				}
				else
				{
					close_win();
					close_editwin();
				}
				return true;
			}
		</script>
	</HEAD>
	<body>
		<form id="addsubform" onsubmit="return chk_deal();" method="post" runat="server">
			<table cellSpacing="0" cellPadding="0" width="500" border="0">
				<tr>
					<td class="m_tline">&nbsp;&nbsp;���ʺţ�&nbsp;
						<asp:dropdownlist id="showlist" OnSelectedIndexChanged="showlist_SelectIndexChanged" AutoPostBack="True"
							Runat="server">
							<asp:ListItem Value="">ȫ����ʾ</asp:ListItem>
							<asp:ListItem Value="1">����</asp:ListItem>
							<asp:ListItem Value="0">ͣ��</asp:ListItem>
						</asp:dropdownlist>&nbsp;&nbsp; <input class="Text" onclick="open_win();" type="button" value="�� ��" name="buttonadd">
					</td>
					<td width="30"><IMG height="24" src="images/top_04.gif" width="30"></td>
				</tr>
				<tr>
					<td colSpan="2" height="4"></td>
				</tr>
			</table>
			<asp:datagrid id="subuserlist" Runat="server" Width="470px" OnItemCommand="subuserlist_ItemCommand"
				ItemStyle-Height="22" ItemStyle-BackColor="#ffffff" AutoGenerateColumns="False" ItemStyle-HorizontalAlign="Center"
				HeaderStyle-HorizontalAlign="Center" HeaderStyle-Height="20" HeaderStyle-Wrap="false" BorderColor="Gray"
				HeaderStyle-ForeColor="#ffffff" HeaderStyle-BackColor="#0099ff">
				<ItemStyle HorizontalAlign="Center" Height="22px" BackColor="White"></ItemStyle>
				<HeaderStyle Wrap="False" HorizontalAlign="Center" Height="20px" ForeColor="White" BackColor="#0099FF"></HeaderStyle>
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
			</asp:datagrid>
			<div id="addsubdiv" style="DISPLAY: none; POSITION: absolute" runat="server">
				<table cellSpacing="1" cellPadding="0" width="300" bgColor="gray" border="0">
					<tr vAlign="middle" height="20">
						<td width="100%" bgColor="#0163a2">
							<table cellSpacing="0" cellPadding="0" width="100%" border="0">
								<tr>
									<td width="250" bgColor="#0163a2"><font color="#ffffff">&nbsp;�������ʻ���</font></td>
									<td vAlign="middle" align="right"><a class="hander" onclick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td colSpan="2" height="18">�ʺţ�<input id="subname" type="text" size="8" name="subname" runat="server">&nbsp; 
							���룺<input id="subpass" type="password" size="8" name="subpass" runat="server">
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td height="18">���ƣ�<input id="truename" type="text" size="8" name="truename" runat="server">&nbsp; 
							״̬��<select id="isuseable" name="isuseable" runat="server">
								<option value="0" selected>ͣ��</option>
								<option value="1">����</option>
							</select>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td align="center" height="18"><input class="Text" type="submit" value="ȷ ��" name="submitbutton">
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
							���ƣ�<input id="editsubname" type="text" size="8" runat="server">&nbsp; ���룺<input id="editsubpass" type="password" size="8" runat="server"><font color=red>���Ĳ���</font>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td align="center" height="18"><input class="Text" type="submit" value="ȷ ��" name="submitbutton">
						</td>
					</tr>
				</table>
				<input id="editsubmitflag" type="hidden" runat="server"> <input type="hidden" id="subid" name="subid" runat="server">
			</div>
		</form>
	</body>
</HTML>
