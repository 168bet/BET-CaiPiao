<%@ Page language="c#" Codebehind="gdset.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.gdset" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>adminset</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script language="JAVASCRIPT1.2">
			function Chk_acc(){
				if (rs_form.SC.value == "" || rs_form.SC.len < 1 || rs_form.SC.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1) 
				{
					alert("�����޶�ֻ��Ϊ����");
					rs_form.SC.focus();
					rs_form.SC.select();
					return false;
				}
				if (rs_form.SO.value == "" || rs_form.SO.len < 1 || rs_form.SO.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1) 
				{
					alert("��ע�޶�ֻ��Ϊ����");
					rs_form.SO.focus();
					rs_form.SO.select();
					return false;
				}
				return true;	
			}
			function show_win(vs_str,rtype,sc,so,war_set_w1,war_set_w2,war_set_w3,war_set_w4,war_set_l1,war_set_l2,war_set_l3,war_set_l4,add_count,instart_1,instart_2,instart_3,instart_4,instart_5,instart_6,instart_7,instart_8) {
				//alert(document.body.scrollTop);
				//alert(event.clientY);
				document.all["r_title"].innerHTML = '<font color="#FFFFFF">������' + vs_str + '��ˮ</font>';
				
					document.all["tA"].innerHTML = 'A��';
					document.all["tB"].innerHTML = 'B��';
					document.all["tC"].innerHTML = 'C��';
					document.all["tD"].innerHTML = 'D��';
					rs_form.war_set_w2.style.display =  'block';
					rs_form.war_set_l2.style.display =  'block';
					rs_form.war_set_w3.style.display =  'block';
					rs_form.war_set_l3.style.display =  'block';	
					rs_form.war_set_w4.style.display =  'block';
					rs_form.war_set_l4.style.display =  'block';
				
				j1=0;
				j2=0;
				j3=0;
				j4 = 0;
				j5 = 0;
				j6 = 0;
				j7 = 0;
				j8 = 0;
				var d=add_count;
				while (rs_form.war_set_w1.length){document.rs_form.war_set_w1.options[0]=null;}
				while (rs_form.war_set_w2.length){document.rs_form.war_set_w2.options[0]=null;}
				while (rs_form.war_set_w3.length){document.rs_form.war_set_w3.options[0]=null;}
				while (rs_form.war_set_w4.length){document.rs_form.war_set_w4.options[0]=null;}
				while (rs_form.war_set_l1.length){document.rs_form.war_set_l1.options[0]=null;}
				while (rs_form.war_set_l2.length){document.rs_form.war_set_l2.options[0]=null;}
				while (rs_form.war_set_l3.length){document.rs_form.war_set_l3.options[0]=null;}	
				while (rs_form.war_set_l4.length){document.rs_form.war_set_l4.options[0]=null;}	
				for(var i=0;i<=instart_1;i+=d){
					document.rs_form.war_set_w1.options[j1]=new Option(i,i);
					if(i==war_set_w1) document.rs_form.war_set_w1.selectedIndex=j1;
					j1++;
				}
				for(var i=0;i<=instart_2;i+=d){
					document.rs_form.war_set_w2.options[j2]=new Option(i,i);
					if(i==war_set_w2) document.rs_form.war_set_w2.selectedIndex=j2;
					j2++;
				}
				for(var i=0;i<=instart_3;i+=d){
					document.rs_form.war_set_w3.options[j3]=new Option(i,i);
					if(i==war_set_w3) document.rs_form.war_set_w3.selectedIndex=j3;
					j3++;
				}
				for(var i=0;i<=instart_4;i+=d){
					document.rs_form.war_set_w4.options[j4]=new Option(i,i);
					if(i==war_set_w4) document.rs_form.war_set_w4.selectedIndex=j4;
					j4++;
				}
				
				for(var i=0;i<=instart_5;i+=d){
					document.rs_form.war_set_l1.options[j5]=new Option(i,i);
					if(i==war_set_l1) document.rs_form.war_set_l1.selectedIndex=j5;
					j5++;
				}
				for(var i=0;i<=instart_6;i+=d){
					document.rs_form.war_set_l2.options[j6]=new Option(i,i);
					if(i==war_set_l2) document.rs_form.war_set_l2.selectedIndex=j6;
					j6++;
				}
				for(var i=0;i<=instart_7;i+=d){
					document.rs_form.war_set_l3.options[j7]=new Option(i,i);
					if(i==war_set_l3) document.rs_form.war_set_l3.selectedIndex=j7;
					j7++;
				}	
				for(var i=0;i<=instart_8;i+=d){
					document.rs_form.war_set_l4.options[j8]=new Option(i,i);
					if(i==war_set_l4) document.rs_form.war_set_l4.selectedIndex=j8;
					j8++;
				}		
				//rs_form.kind.value=kind;
				rs_form.rtype.value=rtype;
				rs_form.SC.value=sc;
				rs_form.SO.value=so;
				var popTopAdjust;
				var popLeftAdjust;
				if(event.y+200 > document.body.clientHeight) popTopAdjust = -200;else popTopAdjust = 0;
				rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+280 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
				rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["rs_window"].style.display = "block";
			}
			function close_win() {
				document.all["rs_window"].style.display = "none";
			}	

			function count_so(a){
				switch(a){
					case(1):
						b=eval(document.all.SC.value)/2;
						document.all.SO.value=b;
						break;
					case(2):
						b=eval(document.all.SC_2.value)/2;
						document.all.SO_2.value=b;
						break;
				}
			}
		</script>
	</HEAD>
	<body leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server" onsubmit="return CheckForm();">
			<FONT face="����">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="1000" border="0">
					<TR>
						<TD colSpan="3"><FONT face="����">�޸� �ɶ�:
								<asp:Label id="LabelGd" runat="server">Label</asp:Label>&nbsp;�趨&nbsp;&nbsp; --<A href="gdlist.aspx">������ҳ</A></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="FTable" cellSpacing="1" cellPadding="0" width="100%" bgColor="#000000" border="0"
								runat="server">
								<tr class="dlsheader">
                                  <TD nowrap>��Ŀ</TD>
                                  <TD nowrap>�ر��</TD>
                                  <TD nowrap><FONT face="����">�ر�ŵ�˫</FONT></TD>
                                  <TD nowrap>�ر�Ŵ�С</TD>
                                  <TD nowrap>�ر�ź�����˫</TD>
                                  <TD nowrap>����</TD>
                                  <TD nowrap>�ܺ͵�˫</TD>
                                  <TD nowrap>�ܺʹ�С</TD>
                                  <TD nowrap>��ȫ��</TD>
                                  <TD nowrap>��ȫ��</TD>
                                  <TD nowrap>���ж�</TD>
                                  <TD nowrap>������</TD>
                                  <TD nowrap>�ش�</TD>
                                  <TD nowrap>�������</TD>
                                  <TD nowrap>ɫ��</TD>
							  </tr>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD nowrap bgColor="#ffcccc">A�� W/L</TD>
									<TD>0</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">B�� W/L</TD>
									<TD>0</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">C�� W/L</TD>
									<TD>0</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">D�� W/L</TD>
									<TD>0</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc" nowrap>�����޶�</TD>
									<TD>0</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc" nowrap>��ע�޶�</TD>
									<TD>0</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
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
									<TD>�޸�</TD>
									<TD>�޸�</TD>
									<TD>�޸�</TD>
									<TD>�޸�</TD>
									<TD>�޸�</TD>
									<TD>�޸�</TD>
									<TD>�޸�</TD>
									<TD>�޸�</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3" height="10"><FONT face="����"></FONT></TD>
					</TR>
					<tr>
						<td colspan="3" align="left">
							<TABLE id="BKTable" cellSpacing="1" cellPadding="0" width="550" bgColor="#000000" border="0"
								runat="server">
								<TR class="dlsheader">
                                  <TD >��Ŀ</TD>
                                  <TD>��Ф</TD>
                                  <TD>����1-6��˫</TD>
                                  <TD>����1-6��С</TD>
                                  <TD>����1-6ɫ��</TD>
                                  <TD>һФ</TD>
                                  <TD>��Ф</TD>
							  </TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD nowrap bgColor="#ffcccc">A�� W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">B�� W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">C�� W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">D�� W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc" nowrap>�����޶�</TD>
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
						</td>
					</tr>
			</TABLE>
			</FONT>
		</form>
		<!----------------------�����Ӵ�1---------------------------->
		<div id="rs_window" style="DISPLAY: none; POSITION: absolute">
			<form name="rs_form" onsubmit="return Chk_acc();" action="gdset.aspx" method="post">
				<input type="hidden" name="rtype"> <input type="hidden" value="ffpost" name="action">
				<INPUT type=hidden value="<%# kygluserid %>" name=id> <input type="hidden" value="<%# kyglgsid %>" name="gid">
				<table cellSpacing="1" cellPadding="2" width="280" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr bgColor="#0163a2">
									<td id="r_title" width="200"><font color="#ffffff">&nbsp;������</font></td>
									<td vAlign="top" align="right"><a style="CURSOR: hand" onclick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr bgColor="#000000">
									<td colSpan="2" height="1"></td>
								</tr>
								<tr>
									<td colSpan="2">
										<table cellSpacing="0" cellPadding="0" width="100%" border="0">
											<tr align="center">
												<TD width="30"></TD>
												<td id="tA">A��</td>
												<td id="tB">B��</td>
												<td id="tC">C��</td>
												<td id="tD">D��</td>
											</tr>
											<tr align="center">
												<TD>Ӯ</TD>
												<td><select name="war_set_w1"></select></td>
												<td><select name="war_set_w2"></select></td>
												<td><select name="war_set_w3"></select></td>
												<td><select name="war_set_w4"></select></td>
											</tr>
											<tr align="center">
												<TD>��</TD>
												<td><select name="war_set_l1"></select></td>
												<td><select name="war_set_l2"></select></td>
												<td><select name="war_set_l3"></select></td>
												<td><select name="war_set_l4"></select></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr bgColor="#000000">
									<td colSpan="2" height="1"></td>
								</tr>
								<tr>
									<td colSpan="2">�����޶�&nbsp;&nbsp;<input class="text" onkeyup="count_so(1);" type="text" maxLength="8" size="8" name="SC"></td>
								</tr>
								<tr bgColor="#000000">
									<td colSpan="2" height="1"></td>
								</tr>
								<tr>
									<td colSpan="2">��ע�޶�&nbsp;&nbsp;<input class="text" type="text" maxLength="8" size="8" name="SO"></td>
								</tr>
								<tr bgColor="#000000">
									<td colSpan="2" height="1"></td>
								</tr>
								<tr>
									<td align="center" colSpan="2"><input class="text" type="submit" value="ȷ  ��" name="rs_ok">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<script>
		
		function CheckForm()
		{
			return true;
		}	
		</script>
	</body>
</HTML>