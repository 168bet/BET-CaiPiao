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
					alert("单场限额只能为数字");
					document.rs_form.ft_b4_1.focus();
					document.rs_form.ft_b4_1.select();
					return false;
				}
				if (document.rs_form.ft_b4_2.value == "" || document.rs_form.ft_b4_2.len < 1 || document.rs_form.ft_b4_2.value.search(/^(-|\+)?\d+(\.\d+)?$/) == -1) 
				{
					alert("单注限额只能为数字");
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
				document.all["r_title"].innerHTML = "<font color=#ffffff>请输入"+ titleStr +"回水</font>";
				var d = add_count;
				
				//清空赢退水下拉框
				while(rs_form.userW.length)
				{
					document.rs_form.userW.options[0] = null;
				}			
				//添加赢退水
				for(var i=0,j=0;i<=instartW;i+=d,j++)  //j for sumlists
				{
					document.rs_form.userW.options[j] = new Option(i,i);
					if(i == uW)document.rs_form.userW.selectedIndex = j;
				}
				//清空输退水下拉框
				while(rs_form.userL.length)
				{
					document.rs_form.userL.options[0] = null;
				}			
				//添加输退水
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
					alert("请输入数字！");
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
					alert("请输入数字！");
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
					<td class="m_tline">&nbsp;&nbsp;会员详细设定&nbsp;&nbsp;&nbsp;帐号:<label id="username" runat="server"></label>
						-- 会员名称:<label id="truename" runat="server"></label> -- 盘口:<label id="ABC" runat="server"></label>
						-- 使用币别:<label id="moneysort" runat="server"></label> -- 投注方式:信用额度 -- <a href="javascript:window.location = 'mgruser.aspx';">
							回上一页</a></td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" cellSpacing="1" cellPadding="0" class="tableNoBorder1" width="1000" id="footballsettable"
				runat="server">
				<tr class="dlsheader">
					<TD width="75" nowrap>项目</TD>
					<TD width="46" nowrap>特别号</TD>
					<TD width="77" nowrap><FONT face="宋体">特别号单双</FONT></TD>
					<TD width="76" nowrap>特别号大小</TD>
					<TD width="97" nowrap>特别号合数单双</TD>
					<TD width="40" nowrap>正码</TD>
					<TD width="62" nowrap>总和单双</TD>
					<TD width="63" nowrap>总和大小</TD>
					<TD width="54" nowrap>二全中</TD>
					<TD width="61" nowrap>三全中</TD>
					<TD width="48" nowrap>三中二</TD>
					<TD width="51" nowrap>二中特</TD>
					<TD width="37" nowrap>特串</TD>
					<TD  nowrap>正码过关</TD>
					<TD width="87" nowrap>色波</TD>
				</tr>
				<tr align="center" class="TableBody1">
					<td bgColor="#ffcccc" nowrap>退水设定 W/L</td>
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
					<td bgColor="#ffcccc" nowrap>单项(号)限额</td>
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
					<td bgColor="#ffcccc" nowrap>单注限额</td>
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
					<td bgColor="#ffcccc" nowrap>操作</td>
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
					<TD width="80" >项目</TD>
					<TD width="62">生肖</TD>
					<TD width="97">正码1-6单双</TD>
					<TD width="82">正码1-6大小</TD>
					<TD width="87">正码1-6色波</TD>
					<TD width="54">一肖</TD>
					<TD width="49">六肖</TD>
				</TR>
				<TR align="center" bgColor="#ffffff" height="22">
					<TD bgColor="#ffcccc" nowrap>退水设定 W/L</TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
					<TD></TD>
				</TR>
				<TR align="center" bgColor="#ffffff" height="22">
					<TD bgColor="#ffcccc" nowrap>单项(号)限额</TD>
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
			<!----------------------结帐视窗1---------------------------->
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
									<td id="r_title" width="200"><font color="#ffffff">&nbsp;请输入</font></td>
									<td align="right" valign="top"><a style="CURSOR:hand" onClick="close_win();"><img src="images/edit_dot.gif" width="16" height="14"></a></td>
								</tr>
								<tr>
									<td colspan="2" height="1" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="2">退水设定&nbsp;(赢)
										<select name="userW" id="userW" runat="server">
										</select>
										(输)
										<select name="userL" id="userL" runat="server">
										</select>
									</td>
								</tr>
								<tr bgcolor="#000000">
									<td colspan="2" height="1"></td>
								</tr>
								<tr>
									<td colspan="2">单场限额&nbsp;&nbsp; <input type="text" id="ft_b4_1" name="SC" size="12" maxlength="12" runat="server" onkeyup="Chg_Sc_Mcy();count_so();Chg_So_Mcy()">
									</td>
								</tr>
								<tr bgcolor="#000000">
									<td colspan="2" height="1"></td>
								</tr>
								<tr>
									<td colspan="2">单注限额&nbsp;&nbsp; <input type="text" id="ft_b4_2" name="SO" size="12" maxlength="12" runat="server" onkeyup="Chg_So_Mcy();">
									</td>
								</tr>
								<tr bgcolor="#000000">
									<td colspan="2" height="1"></td>
								</tr>
								<tr align="center">
									<td colspan="2">
										<input type="submit" name="rs_ok" value="确定" class="Text"> &nbsp;&nbsp; <input type="hidden" name="userid" id="useridhid" runat="server">
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
