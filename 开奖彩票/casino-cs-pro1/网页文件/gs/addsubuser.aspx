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
			//打开新增窗口
			function open_win()
			{	
				addsubdiv.style.top = document.body.scrollTop + event.clientY + 15;
				addsubdiv.style.left= document.body.scrollLeft+ event.clientX;
				addsubdiv.style.display = "block";
			}
			//关闭窗口
			function close_win()
			{
				addsubdiv.style.display = "none";
			}		
			function close_editwin()
			{
				editsubdiv.style.display = "none";
			}
			//提交前的处理
			function chk_deal()
			{
				obj["submitflag"].value = 'dosubmit';
				if(addsubdiv.style.display == "block")
				{
					if(obj["subname"].value == '')
					{
						alert("帐号不能为空！");
						obj["subname"].focus();
						return false
					}
					if(obj["subpass"].value == '')
					{
						alert("密码不能为空！");
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
						&nbsp;&nbsp;子帐号：&nbsp;
						<asp:DropDownList ID="showlist" Runat="server" AutoPostBack="True" OnSelectedIndexChanged="showlist_SelectIndexChanged">
							<asp:ListItem Value="">全部显示</asp:ListItem>
							<asp:ListItem Value="1">启用</asp:ListItem>
							<asp:ListItem Value="0">停用</asp:ListItem>
						</asp:DropDownList>&nbsp;&nbsp; <input type="button" name="buttonadd" onclick="open_win();" class="Text" value="新 增">
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
					<asp:BoundColumn DataField="truename" HeaderText="名称"></asp:BoundColumn>
					<asp:BoundColumn DataField="subname" HeaderText="会员帐号"></asp:BoundColumn>
					<asp:BoundColumn DataField="regtime" HeaderText="注册日期"></asp:BoundColumn>
					<asp:TemplateColumn HeaderText="状态">
						<ItemTemplate>
							<%# showuseable(DataBinder.Eval(Container.DataItem,"isuseable").ToString())%>
						</ItemTemplate>
					</asp:TemplateColumn>
					<asp:TemplateColumn HeaderText="功能">
						<ItemTemplate>
							<asp:LinkButton ID="useable" CommandName="useable" CssClass="hander" Runat="server">
								<%# showuseablebutton(DataBinder.Eval(Container.DataItem,"isuseable").ToString())%>
							</asp:LinkButton>&nbsp;/&nbsp;
							<asp:LinkButton ID="delsub" CommandName="delsub" CssClass="hander" Runat="server">删除</asp:LinkButton>&nbsp;/&nbsp;
							<asp:LinkButton ID="editsub" CommandName="editsub" CssClass="hander" Runat="server">修改</asp:LinkButton>
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
									<td width="250" bgcolor="#0163a2"><font color="#ffffff">&nbsp;新增子帐户：</font></td>
									<td align="right" valign="middle"><a class="hander" onClick="close_win();"><img src="images/edit_dot.gif" width="16" height="14"></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgcolor="#a4c0ce">
						<td colspan="2" height="18">
							帐号：<input type="text" name="subname" size="8">&nbsp; 密码：<input type="password" name="subpass" size="8">
						</td>
					</tr>
					<tr bgcolor="#a4c0ce">
						<td height="18">
							名称：<input type="text" name="truename" size="8">&nbsp; 状态：<select name="isuseable">
								<option value="0" selected>停用</option>
								<option value="1">启用</option>
							</select>
						</td>
					</tr>
					<tr bgcolor="#a4c0ce">
						<td height="18" align="center">
							<input type="submit" name="submitbutton" value="确 定" class="Text">
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
									<td width="250" bgColor="#0163a2"><font color="#ffffff">&nbsp;修改子帐户：</font></td>
									<td vAlign="middle" align="right"><a class="hander" onclick="close_editwin();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td colSpan="2" height="18">
							名称：<input id="edittruename" type="text" size="8" runat="server" NAME="editsubname">&nbsp; 
							密码：<input id="editsubpass" type="password" size="8" runat="server" NAME="editsubpass"><font color="red">不改不填</font>
						</td>
					</tr>
					<tr bgColor="#a4c0ce">
						<td align="center" height="18"><input class="Text" type="submit" value="确 定" name="submitbutton">
						</td>
					</tr>
				</table>
				<input type="hidden" id="subid" name="subid" runat="server">
			</div>
		</form>
	</body>
</HTML>
