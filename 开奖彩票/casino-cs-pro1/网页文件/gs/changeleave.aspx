<%@ Page language="c#" Codebehind="changeleave.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.changeleave" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>����ע����ˮ</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script>
			function show_win(ballid,giveupmoney,giveuppl)
			{
				rs_form.ballid.value=ballid;
				rs_form.giveupmoney.value=giveupmoney;
				
				rs_form.giveuppl.value=giveuppl;
				
							
				var popTopAdjust;
				var popLeftAdjust;
				if(event.y+300 > document.body.clientHeight) popTopAdjust = -230;else popTopAdjust = 0;
				rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+250 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
				rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["rs_window"].style.display = "block";	
			}
           function show_allwin(ballid,giveupmoney,giveuppl)
			{
				rs_form.ballid.value=ballid;
				rs_form.giveupmoney.value=giveupmoney;
				
				rs_form.giveuppl.value=giveuppl;
				
							
				var popTopAdjust;
				var popLeftAdjust;
				if(event.y+300 > document.body.clientHeight) popTopAdjust = -230;else popTopAdjust = 0;
				rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+250 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
				rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["rs_window"].style.display = "block";	
			}
			function close_win() {
				document.all["rs_window"].style.display = "none";
			}

			function checkdate()
			{
				if(!isint(rs_form.giveupmoney) )
				{
					alert("����������");
					return false;
				}
				else if(!isdouble(rs_form.giveuppl) )
				{
					alert("������С��");
					return false;
				}
				else
					return true;
			}

			function isint(aaa)
			{
				if (aaa.value.search(/^[0-9]+$/) == -1) // �ж��Ƿ�������
				{
					aaa.focus();
					aaa.select();
					return false;
				}
				return true
			}
			function isdouble(aaa)
			{
				if (aaa.value.search(/^[0-9.-]+$/) == -1) // �ж��Ƿ�������
				{
					aaa.focus();
					aaa.select();
					return false;
				}
				return true
			}
		</script>
	</HEAD>
	<body leftMargin="3" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="700" border="0" align=center>
				<TR>
						<td colspan="2" align="center">
							���ϲ�
							
							&nbsp;&nbsp;
							<input type="button" name="allsave" id="allsave" value="ȫ���趨" onclick="show_allwin('0','10000','0.5');">
						</td>
					</TR>
					<TR>
						<TD colspan="2">
							<table width="640" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000" align=center>
								<tr class="blueheader" height="25">
									<td width="180">��Ŀ</td>
									<td width="360">����</td>
								</tr>
								<%# kyglContent %>
							</table>
						</TD>
					</TR>
					<TR>
						<TD></TD>
						<TD></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
		<div id="rs_window" style="DISPLAY: none; POSITION: absolute">
			<form name="rs_form" onsubmit="return checkdate();" action="changeleave.aspx" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="280" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="66" bgcolor="#0163a2" id="r_title"><font color="#ffffff">&nbsp;������</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											
											<tr>
												<td>�޶��</td>
												<td><input name="giveupmoney" type="text" size="6" class="text"></td>
												
												<td>�仯��</td>
												<td><input name="giveuppl" type="text" size="6" class="text"></td>
												
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="submit" value="ȷ  ��" name="rs_ok">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</HTML>
