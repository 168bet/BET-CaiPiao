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
					alert("单场限额只能为数字");
					rs_form.SC.focus();
					rs_form.SC.select();
					return false;
				}
				if (rs_form.SO.value == "" || rs_form.SO.len < 1 || rs_form.SO.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1) 
				{
					alert("单注限额只能为数字");
					rs_form.SO.focus();
					rs_form.SO.select();
					return false;
				}
				return true;	
			}
			function show_win(vs_str,rtype,sc,so,war_set_w1,war_set_w2,war_set_w3,war_set_w4,war_set_l1,war_set_l2,war_set_l3,war_set_l4,add_count,instart_1,instart_2,instart_3,instart_4,instart_5,instart_6,instart_7,instart_8) {
				//alert(document.body.scrollTop);
				//alert(event.clientY);
				document.all["r_title"].innerHTML = '<font color="#FFFFFF">请输入' + vs_str + '退水</font>';
				
					document.all["tA"].innerHTML = 'A盘';
					document.all["tB"].innerHTML = 'B盘';
					document.all["tC"].innerHTML = 'C盘';
					document.all["tD"].innerHTML = 'D盘';
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
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="3" width="1000" border="0">
					<TR>
						<TD colSpan="3"><FONT face="宋体">修改 股东:
								<asp:Label id="LabelGd" runat="server">Label</asp:Label>&nbsp;设定&nbsp;&nbsp; --<A href="gdlist.aspx">返回上页</A></FONT></TD>
					</TR>
					<TR>
						<TD colSpan="3">
							<TABLE id="FTable" cellSpacing="1" cellPadding="0" width="100%" bgColor="#000000" border="0"
								runat="server">
								<tr class="dlsheader">
                                  <TD nowrap>项目</TD>
                                  <TD nowrap>特别号</TD>
                                  <TD nowrap><FONT face="宋体">特别号单双</FONT></TD>
                                  <TD nowrap>特别号大小</TD>
                                  <TD nowrap>特别号合数单双</TD>
                                  <TD nowrap>正码</TD>
                                  <TD nowrap>总和单双</TD>
                                  <TD nowrap>总和大小</TD>
                                  <TD nowrap>二全中</TD>
                                  <TD nowrap>三全中</TD>
                                  <TD nowrap>三中二</TD>
                                  <TD nowrap>二中特</TD>
                                  <TD nowrap>特串</TD>
                                  <TD nowrap>正码过关</TD>
                                  <TD nowrap>色波</TD>
							  </tr>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD nowrap bgColor="#ffcccc">A盘 W/L</TD>
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
									<TD bgColor="#ffcccc">B盘 W/L</TD>
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
									<TD bgColor="#ffcccc">C盘 W/L</TD>
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
									<TD bgColor="#ffcccc">D盘 W/L</TD>
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
									<TD bgColor="#ffcccc" nowrap>单场限额</TD>
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
									<TD bgColor="#ffcccc" nowrap>单注限额</TD>
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
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD colSpan="3" height="10"><FONT face="宋体"></FONT></TD>
					</TR>
					<tr>
						<td colspan="3" align="left">
							<TABLE id="BKTable" cellSpacing="1" cellPadding="0" width="550" bgColor="#000000" border="0"
								runat="server">
								<TR class="dlsheader">
                                  <TD >项目</TD>
                                  <TD>生肖</TD>
                                  <TD>正码1-6单双</TD>
                                  <TD>正码1-6大小</TD>
                                  <TD>正码1-6色波</TD>
                                  <TD>一肖</TD>
                                  <TD>六肖</TD>
							  </TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD nowrap bgColor="#ffcccc">A盘 W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">B盘 W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">C盘 W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc">D盘 W/L</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD ></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc" nowrap>单场限额</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc" nowrap>单注限额</TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
									<TD></TD>
								</TR>
								<TR align="center" bgColor="#ffffff" height="22">
									<TD bgColor="#ffcccc"></TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
									<TD>修改</TD>
								</TR>
							</TABLE>
						</td>
					</tr>
			</TABLE>
			</FONT>
		</form>
		<!----------------------结帐视窗1---------------------------->
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
									<td id="r_title" width="200"><font color="#ffffff">&nbsp;请输入</font></td>
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
												<td id="tA">A盘</td>
												<td id="tB">B盘</td>
												<td id="tC">C盘</td>
												<td id="tD">D盘</td>
											</tr>
											<tr align="center">
												<TD>赢</TD>
												<td><select name="war_set_w1"></select></td>
												<td><select name="war_set_w2"></select></td>
												<td><select name="war_set_w3"></select></td>
												<td><select name="war_set_w4"></select></td>
											</tr>
											<tr align="center">
												<TD>输</TD>
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
									<td colSpan="2">单场限额&nbsp;&nbsp;<input class="text" onkeyup="count_so(1);" type="text" maxLength="8" size="8" name="SC"></td>
								</tr>
								<tr bgColor="#000000">
									<td colSpan="2" height="1"></td>
								</tr>
								<tr>
									<td colSpan="2">单注限额&nbsp;&nbsp;<input class="text" type="text" maxLength="8" size="8" name="SO"></td>
								</tr>
								<tr bgColor="#000000">
									<td colSpan="2" height="1"></td>
								</tr>
								<tr>
									<td align="center" colSpan="2"><input class="text" type="submit" value="确  定" name="rs_ok">
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