<%@ Page language="c#" Codebehind="BallGoTime.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.BallGoTime.BallGoTime" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>����ʱ��</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script>
			function show_win(autoID,addORchg,updatetime) 
			{				
				if(addORchg == "0")
				{
					document.all["r_title"].innerHTML = '<font color="#FFFFFF">����������</font>';
					
					rs_form.pl.value       = updatetime;
				
				}
				else
				{
					document.all["r_title"].innerHTML = '<font color="#FFFFFF">���޸�����</font>';
					
					rs_form.pl.value       = updatetime;
					
				}									

				//rs_form.kind.value=kind;
				rs_form.autoID.value=autoID;      //addORchg == "0" Ϊballid,"1" Ϊ ball_pl1_fenid
				rs_form.addORchg.value = addORchg;//addORchg == "0" Ϊ������ "1" Ϊ �޸�
				var popTopAdjust=-10;
				var popLeftAdjust=-30;
				if(event.y+200 > document.body.clientHeight) popTopAdjust =-200;else popTopAdjust = -10;
				rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+250 > document.body.clientWidth) popLeftAdjust=-200;else popLeftAdjust=0;	
				rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["rs_window"].style.display = "block";
			}
			
			function close_win() 
			{
				document.all["rs_window"].style.display = "none";	
				document.all["all_window"].style.display = "none";				
			}	
			function show_all_win(autoID,addORchg,updatetime) 
			{				
				
				
				document.all["all_title"].innerHTML = '<font color="#FFFFFF">�޸�ȫ������</font>';
					
				all_form.pl.value       = '';

				//rs_form.kind.value=kind;
				all_form.autoID1.value=autoID;      //addORchg == "0" Ϊballid,"1" Ϊ ball_pl1_fenid
				all_form.addORchg.value = addORchg;//addORchg == "0" Ϊ������ "1" Ϊ �޸�
				var popTopAdjust=-10;
				var popLeftAdjust=-30;
				if(event.y+200 > document.body.clientHeight) popTopAdjust =-200;else popTopAdjust = -10;
				  all_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+250 > document.body.clientWidth) popLeftAdjust=-200;else popLeftAdjust=0;	
				  all_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["all_window"].style.display = "block";
			}			
			
		</script>
	</HEAD>
	<BODY leftMargin="0" topMargin="3">
		<form runat="server" method="post">
			<FONT face="����">&nbsp;&nbsp; <A href="BallGoTime.aspx?type=1,2,3,4,5,6,7">��˫��С</A> &nbsp;<A href="BallGoTime.aspx?type=8">�ر��</A>&nbsp;&nbsp;&nbsp;<A href="BallGoTime.aspx?type=9">����</A>&nbsp;&nbsp;&nbsp;
				<A href="BallGoTime.aspx?type=10">����1-6</A>&nbsp;&nbsp; <A href="BallGoTime.aspx?type=11,12,13,14,15">
					����&nbsp;</A>&nbsp; <A href="BallGoTime.aspx?type=16">�������</A>&nbsp; <A href="BallGoTime.aspx?type=17,18">
					��Фɫ��</A>&nbsp; <A href="BallGoTime.aspx?type=19">һФ</A>&nbsp;&nbsp; <A href="BallGoTime.aspx?type=20">
					��Ф</A>&nbsp; <A href="BallGoTime.aspx?type=21">�벨 </A>&nbsp;&nbsp; <SPAN style="CURSOR: hand" onClick="javascript:show_all_win('<%# type%>','1','1.85')" >
					<font color="#0000ff">ȫ���޸�</font></SPAN>
				<asp:TextBox id="TxtOdds" runat="server" Width="50px" Visible="False"></asp:TextBox>
				<asp:Button id="BtnSingle" runat="server" Text="��" Visible="False"></asp:Button>
				<asp:Button id="BtnTwin" runat="server" Text="˫" Visible="False"></asp:Button>
				<asp:Button id="BtnOver" runat="server" Text="��" Visible="False"></asp:Button>
				<asp:Button id="BtnUnder" runat="server" Text="С" Visible="False"></asp:Button>
				<asp:Button id="BtnRed" runat="server" Text="��" Visible="False"></asp:Button>
				<asp:Button id="BtnGreen" runat="server" Text="��" Visible="False"></asp:Button>
				<asp:Button id="BtnBlue" runat="server" Text="��" Visible="False"></asp:Button>
				<asp:Button id="BtnHeDang" runat="server" Visible="False" Text="�ϵ�"></asp:Button>
				<asp:Button id="BtnHeShuang" runat="server" Visible="False" Text="��˫"></asp:Button>
				<asp:Button id="btnSub" runat="server" Visible="False" Text="��0.5"></asp:Button>
				<asp:Button id="btnAdd" runat="server" Visible="False" Text="��0.5"></asp:Button>
				<table cellSpacing="1" cellPadding="2" width="780" bgColor="#000000" border="0">
					<tr class="blueheader" align="center">
						<td width="80">���</td>
						<td width="60">����</td>
						<td width="60">����</td>
						<td width="80">���</td>
						<td width="60">����</td>
						<td width="60">����</td>
						<td width="80">���</td>
						<td width="60">����</td>
						<td width="60">����</td>
					</tr>
					<%# kyglContent %>
				</table>
		</form>
		<div id="rs_window" style="DISPLAY: none; POSITION: absolute">
			<form name=rs_form action="BallGoTime.aspx?type=<%# type%>" method=post>
				<input type="hidden" value="ffpost" name="action"> <input type="hidden" name="autoID">
				<input type="hidden" name="addORchg">
				<table cellSpacing="1" cellPadding="2" width="150" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td id="r_title" width="200" bgColor="#0163a2"><font color="#ffffff">&nbsp;����������</font></td>
									<td vAlign="top" align="right" width="20" bgColor="#0163a2" colSpan="2"><a style="CURSOR: hand" onClick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td colSpan="3">
										<table cellSpacing="0" cellPadding="0" width="100%" border="0">
											<tr>
												<td colSpan="2">&nbsp;</td>
											</tr>
											<tr>
												<td align="center">���ʣ�</td>
												<td><input type="text" maxLength="10" size="10" value="1.87" name="pl"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td align="center">&nbsp;</td>
									<td colSpan="2">&nbsp;</td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="submit" value="ȷ  ��" name="rs_ok"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="all_window" style="DISPLAY: none; POSITION: absolute">
			<form name=all_form action="BallGoTime.aspx?type=<%# type%>" method=post>
				<input type="hidden" value="ffpost" name="action"> <input type="hidden" name="autoID1">
				<input type="hidden" name="addORchg">
				<table cellSpacing="1" cellPadding="2" width="150" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td id="all_title" width="200" bgColor="#0163a2"><font color="#ffffff">&nbsp;����������</font></td>
									<td vAlign="top" align="right" width="20" bgColor="#0163a2" colSpan="2"><a style="CURSOR: hand" onClick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td colSpan="3">
										<table cellSpacing="0" cellPadding="0" width="100%" border="0">
											<tr>
												<td colSpan="2">&nbsp;</td>
											</tr>
											<tr>
												<td align="center">���ʣ�</td>
												<td><input type="text" maxLength="10" size="10" value="1.87" name="pl"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td align="center">&nbsp;</td>
									<td colSpan="2">&nbsp;</td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="submit" value="ȷ  ��" name="rs_ok"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		</FONT>
	</BODY>
</HTML>
