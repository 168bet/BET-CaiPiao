<%@ Page language="c#" Codebehind="edituser.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.edituser" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>edituser</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" href="css/css.css" type="text/css">
		<script type="text/javascript" language="javascript">
			document.onkeypress = checkfunc;
			function checkfunc(e)
			{
				switch(event.keyCode){}
			}				
			function Chk_acc()
			{				
				if(document.rs_form.ft_b4_1.value == '')
					document.rs_form.ft_b4_1.value = '0';	
				if(document.rs_form.ft_b4_2.value == '')
					document.rs_form.ft_b4_2.value = '0';	
					
				if (document.rs_form.ft_b4_1.value == "" || document.rs_form.ft_b4_1.len < 1 || document.rs_form.ft_b4_1.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1) 
				{
					alert("�����޶�ֻ��Ϊ����");
					document.rs_form.ft_b4_1.focus();
					document.rs_form.ft_b4_1.select();
					return false;
				}
				if (document.rs_form.ft_b4_2.value == "" || document.rs_form.ft_b4_2.len < 1 || document.rs_form.ft_b4_2.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1) 
				{
					alert("��ע�޶�ֻ��Ϊ����");
					document.rs_form.ft_b4_2.focus();
					document.rs_form.ft_b4_2.select();
					return false;
				}
				rs_form.act.value='Y';
				close_win();
				return true;
			}
			
			function show_win(titleStr,rtype,sc,so,uW,uL,add_count,instartW,instartL,kind)
			{
				document.all["r_title"].innerHTML = "<font color=#ffffff>������"+ titleStr +"��ˮ</font>";
				var d = add_count;
				
				//���Ӯ��ˮ������
				while(rs_form.userW.length)
				{
					document.rs_form.userW.options[0] = null;
				}			
				//���Ӯ��ˮ
				for(var i=0,j=0;i<=instartW;i+=d,j++)  //j for sumlists
				{
					document.rs_form.userW.options[j] = new Option(i,i);
					if(i == uW)document.rs_form.userW.selectedIndex = j;
				}
				//�������ˮ������
				while(rs_form.userL.length)
				{
					document.rs_form.userL.options[0] = null;
				}			
				//�������ˮ
				for(var i=0,j=0;i<=instartL;i+=d,j++)  //j for sumlists
				{
					document.rs_form.userL.options[j] = new Option(i,i);
					if(i == uL)document.rs_form.userL.selectedIndex = j;
				}														
				
				document.rs_form.kind.value = kind;
				document.rs_form.rtype.value = rtype;
				document.rs_form.ft_b4_1.value = sc;
				document.rs_form.ft_b4_2.value = so;
				rs_window.style.top = document.body.scrollTop+event.clientY+15;
				rs_window.style.left= document.body.scrollLeft+event.clientX-80;
				//document.all["rs_window"].style.display = "block";
				rs_window.style.display = "block";			
				Chg_Sc_Mcy();
				Chg_So_Mcy();
			}
			function Chg_Sc_Mcy()
			{
				if(document.rs_form.ft_b4_1.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1 && document.rs_form.ft_b4_1.value != '')
				{
					alert("���������֣�");
					return false;
				}
				else
				{
					return true;
				}
			}
			function Chg_So_Mcy()
			{
				if(document.rs_form.ft_b4_2.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1 && document.rs_form.ft_b4_2.value != '')
				{
					alert("���������֣�");
					return false;
				}
				else
				{
					return true;
				}
			}
			
			function close_win()
			{
				rs_window.style.display = "none";
			}
			
			function count_so()
			{
				if(document.rs_form.ft_b4_1.value.search(/^(-|\+)?\d+(\.\d+)?$/) != -1)
				{
					b = Math.ceil(eval(document.rs_form.ft_b4_1.value)/2);
					document.rs_form.ft_b4_2.value = b;
				}
			}	

		</script>
	</HEAD>
	<body>
		<form id="rs_form" name="rs_form" method="post" onsubmit="return Chk_acc();" runat="server">
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="m_tline">&nbsp;&nbsp;��Ա��ϸ�趨&nbsp;&nbsp;&nbsp;�ʺ�:<label id="username" runat="server"></label>
						-- ��Ա����:<label id="truename" runat="server"></label> -- �̿�:<label id="ABC" runat="server"></label>
						-- ʹ�ñұ�:<label id="moneysort" runat="server"></label> -- Ͷע��ʽ:���ö�� -- <a href="javascript:window.location = 'mgruser.aspx';">
							����һҳ</a></td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" cellSpacing="1" cellPadding="0" class="tableNoBorder1" width="1000" id="footballsettable"
				runat="server">
				<tr class="dlsheader">
					<TD width="75" nowrap>��Ŀ</TD>
					<TD width="46" nowrap>�ر��</TD>
					<TD width="77" nowrap><FONT face="����">�ر�ŵ�˫</FONT></TD>
					<TD width="76" nowrap>�ر�Ŵ�С</TD>
					<TD width="97" nowrap>�ر�ź�����˫</TD>
					<TD width="40" nowrap>����</TD>
					<TD width="62" nowrap>�ܺ͵�˫</TD>
					<TD width="63" nowrap>�ܺʹ�С</TD>
					<TD width="54" nowrap>��ȫ��</TD>
					<TD width="61" nowrap>��ȫ��</TD>
					<TD width="48" nowrap>���ж�</TD>
					<TD width="51" nowrap>������</TD>
					<TD width="37" nowrap>�ش�</TD>
					<TD  nowrap>�������</TD>
					<TD width="87" nowrap>ɫ��</TD>
				</tr>
				<tr align="center" class="TableBody1">
					<td bgColor="#ffcccc" nowrap>��ˮ�趨 W/L</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr align="center" class="TableBody1">
					<td bgColor="#ffcccc" nowrap>����(��)�޶�</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr align="center" class="TableBody1">
					<td bgColor="#ffcccc" nowrap>��ע�޶�</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr align="center" id="operatetablerow" runat="server" class="TableBody1">
					<td bgColor="#ffcccc" nowrap>����</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
		  </table>
			<BR>
			<TABLE id="BKTable" cellSpacing="1" cellPadding="0" width="550" bgColor="#000000" border="0"
				runat="server">
				<TR class="dlsheader">
					<TD width="80" >��Ŀ</TD>
					<TD width="62">��Ф</TD>
					<TD width="97">����1-6��˫</TD>
					<TD width="82">����1-6��С</TD>
					<TD width="87">����1-6ɫ��</TD>
					<TD width="54">һФ</TD>
					<TD width="49">��Ф</TD>
				</TR>
				<TR align="center" bgColor="#ffffff" height="22">
					<TD bgColor="#ffcccc" nowrap>��ˮ�趨 W/L</TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
				</TR>
				<TR align="center" bgColor="#ffffff" height="22">
					<TD bgColor="#ffcccc" nowrap>����(��)�޶�</TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
				</TR>
				<TR align="center" bgColor="#ffffff" height="22">
					<TD bgColor="#ffcccc" nowrap>��ע�޶�</TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
				</TR>
				<TR align="center" bgColor="#ffffff" height="22">
					<TD bgColor="#ffcccc"></TD>
					<TD>�޸�</TD>
					<TD>�޸�</TD>
					<TD>�޸�</TD>
					<TD>�޸�</TD>
					<TD>�޸�</TD>
					<TD>�޸�</TD>
				</TR>
		  </TABLE>
			<!----------------------�����Ӵ�1---------------------------->
			<div id="rs_window" style="DISPLAY: none;POSITION: absolute">
				<input type="hidden" name="rtype" id="rtype" runat="server"> <input type="hidden" name="act" id="act" value="N" runat="server">
				<input type="hidden" name="id" id="id" runat="server"> <input type="hidden" name="sid" id="sid" runat="server">
				<input type="hidden" name="kind" id="kind" runat="server"> <input type="hidden" name="pay_type" id="pay_type" value="0" runat="server">
				<input type="hidden" name="currency" id="currency" value="RMB" runat="server"> <input type="hidden" name="ratio" id="ratio" value="1" runat="server">
				<table width="240" border="0" cellspacing="1" cellpadding="2" bgcolor="#00558e">
					<tr>
						<td bgcolor="#ffffff">
							<table width="240" border="0" cellspacing="0" cellpadding="0" bgcolor="#a4c0ce">
								<tr bgcolor="#0163a2">
									<td id="r_title" width="200"><font color="#ffffff">&nbsp;������</font></td>
									<td align="right" valign="top"><a style="CURSOR:hand" onClick="close_win();"><img src="images/edit_dot.gif" width="16" height="14"></a></td>
								</tr>
								<tr>
									<td colspan="2" height="1" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="2">��ˮ�趨&nbsp;(Ӯ)
										<select name="userW" id="userW" runat="server">
										</select>
										(��)
										<select name="userL" id="userL" runat="server">
										</select>
									</td>
								</tr>
								<tr bgcolor="#000000">
									<td colspan="2" height="1"></td>
								</tr>
								<tr>
									<td colspan="2">�����޶�&nbsp;&nbsp; <input type="text" id="ft_b4_1" name="SC" size="12" maxlength="12" runat="server" onkeyup="Chg_Sc_Mcy();count_so();Chg_So_Mcy()">
									</td>
								</tr>
								<tr bgcolor="#000000">
									<td colspan="2" height="1"></td>
								</tr>
								<tr>
									<td colspan="2">��ע�޶�&nbsp;&nbsp; <input type="text" id="ft_b4_2" name="SO" size="12" maxlength="12" runat="server" onkeyup="Chg_So_Mcy();">
									</td>
								</tr>
								<tr bgcolor="#000000">
									<td colspan="2" height="1"></td>
								</tr>
								<tr align="center">
									<td colspan="2">
										<input type="submit" name="rs_ok" value="ȷ��" class="Text"> &nbsp;&nbsp; <input type="hidden" name="userid" id="useridhid" runat="server">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</HTML>
