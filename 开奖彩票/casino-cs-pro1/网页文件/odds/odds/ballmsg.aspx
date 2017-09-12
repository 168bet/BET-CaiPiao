<%@ Page language="c#" Codebehind="ballmsg.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.ballmsg" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>ballmsg</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<script>
		
function  check(obj)
{  
if(strDate(document.form1.kaisai.value)==false)
{alert('日期格式错误');
document.form1.kaisai.select();
return  false;
};  
}  
function  strDate(str)
{  
var  reg  =  /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;    
var  r  =  str.match(reg);    
if(r==null)return  false;    
var  d=  new  Date(r[1],r[3]-1,r[4]);    
if(r[1]!=d.getFullYear())return  false;  
if(r[3]!=(d.getMonth()+1))return  false;  
if(r[4]!=d.getDate())return  false;  
return  true;  
}  

function show_win(name)
{
	var popTopAdjust;
	var popLeftAdjust;
	if(event.y+150 > document.body.clientHeight) popTopAdjust = -130;else popTopAdjust = 0;
	document.all[name].style.top = event.y+20+document.body.scrollTop+popTopAdjust;
	if(event.x+200 > document.body.clientWidth) popLeftAdjust=-200 - 50;else popLeftAdjust=+50;	
	document.all[name].style.left = event.x+document.body.scrollLeft+popLeftAdjust;
	document.all[name].style.display = "block";	

}

function SelTime()
{
	var tmpTime = "";
	tmpTime = rs_form.myhour.value +':'+ rs_form.mymin.value + rs_form.ampm.value;
	Form1.TextBoxBallTime.value = tmpTime;
	document.all['rs_window'].style.display = 'none';
}

function SelMatch()
{
	//document.match_form.selectmatchname.options[match_form.selectmatchname.options.selectedIndex].text
	Form1.TextBoxMatchName.value=document.match_form.selectmatchname.options[match_form.selectmatchname.options.selectedIndex].text;
	Form1.TextBoxMatchColor.value=match_form.selectmatchname.value;
	document.all['sel_matchwin'].style.display = 'none';
	
}

function Sel_Rq()
{
	var tmpStr = "";
	if(rq_form.rq2.value == "" )
		Form1.TextBoxGiveup.value = rq_form.rq1.value;
	else
		Form1.TextBoxGiveup.value = rq_form.rq1.value +"/"+rq_form.rq2.value;
	document.all['sel_rqwin'].style.display = 'none';
}

function Sel_Dx()
{
	var tmpStr = "";
	if(dx_form.dx2.value == "" )
		Form1.TextBoxBigSmall.value = dx_form.dx1.value;
	else
		Form1.TextBoxBigSmall.value = dx_form.dx1.value +"/"+dx_form.dx2.value;
	document.all['sel_dxwin'].style.display = 'none';
}

function Sel_Ball()
{
	var tmpStr = "";
	Form1.TextBoxBallid1.value = ball_form.ballid1.value;
	document.all['sel_ballwin'].style.display = 'none';	
}

function changeColor()
{
	document.all['showcolor'].style.background  = match_form.selectmatchname.value;
}
		</script>
	</HEAD>
	<body leftMargin="3" topMargin="1">
		<form id="Form1" name="Form1" method="post" runat="server" onsubmit="return check(Form1);">
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="776" border="0">
					<TR>
						<TD><asp:label id="Label1" runat="server" Width="208px"></asp:label></TD>
					</TR>
					<TR>
						<TD>
							<table cellSpacing="1" cellPadding="3" width="700" bgColor="#000000" border="0">
								<tr bgColor="#ffffff">
									<td align="center" width="10%"><font face="宋体">开赛时间</font></td>
									<td colspan="4" align="left"><asp:textbox id="kaisai" runat="server" Width="150px" CssClass="text"></asp:textbox>	
									期数	<FONT face="宋体">
									<asp:textbox id="qishu" runat="server" Width="70px" CssClass="text"></asp:textbox>
									</FONT>									  <div align="left"><FONT face="宋体"></FONT></div></td>
								</tr>
								<tr bgColor="#ffffff">
									<td align="center"><font face="宋体">正码一</font></td>
									<td width="13%" align="center"><asp:textbox id="num1" runat="server" Width="70px" CssClass="text"></asp:textbox></td>
									<td width="7%" align="center"><font face="宋体">正码四</font></td>
									<td width="14%" align="center"><asp:textbox id="num4" runat="server" Width="70px" CssClass="text"></asp:textbox></td>
									<td width="26%" align="left"><FONT face="宋体">特码
											<asp:textbox id="tema" runat="server" Width="70px" CssClass="text"></asp:textbox>
										</FONT>
									</td>
								</tr>
								<tr bgColor="#ffffff">
									<td align="center"><font face="宋体">正码二</font></td>
									<td align="center"><asp:textbox id="num2" runat="server" Width="70px" CssClass="text"></asp:textbox></td>
									<td align="center"><font face="宋体">正码五</font></td>
									<td align="center"><asp:textbox id="num5" runat="server" Width="70px" CssClass="text"></asp:textbox></td>
									<td align="center">&nbsp;</td>
								</tr>
								<tr bgColor="#ffffff">
									<td align="center"><font face="宋体">正码三</font></td>
									<td align="center"><asp:textbox id="num3" runat="server" Width="70px" CssClass="text"></asp:textbox></td>
									<td align="center"><font face="宋体">正码六</font></td>
									<td align="center"><asp:textbox id="num6" runat="server" Width="70px" CssClass="text"></asp:textbox></td>
									<td align="center">&nbsp;</td>
								</tr>
								<tr bgColor="#ffffff">
									<td colSpan="5">&nbsp;</td>
								</tr>
								<tr bgColor="#ffffff">
									<td colSpan="5">
										<table cellSpacing="0" cellPadding="3" width="300" border="0">
											<%# kyglServerList %>
										</table>
									</td>
								</tr>
								<tr align="center" bgColor="#ffffff">
									<td colSpan="7"><asp:textbox id="TextBoxAction" runat="server" Visible="False"></asp:textbox><asp:textbox id="ballid" runat="server" Visible="False"></asp:textbox><asp:button id="ButtonSaveBtn" runat="server" CssClass="text" Text="保  存"></asp:button>&nbsp;&nbsp;&nbsp;
										<asp:button id="Button2" runat="server" CssClass="text" Text="取  消"></asp:button></td>
								</tr>
							</table>
						</TD>
					</TR>
					<TR>
						<TD></TD>
					</TR>
				</TABLE>
			</FONT>
		</form>
		<div id="rs_window" style="DISPLAY: none; WIDTH: 220px; POSITION: absolute; HEIGHT: 105px">
			<form name="rs_form" action="" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td id="r_title" width="100" bgColor="#0163a2"><font color="#ffffff">&nbsp;选择开赛时间</font></td>
									<td vAlign="top" align="right" bgColor="#0163a2" colSpan="2"><a style="CURSOR: hand" onclick="document.all['rs_window'].style.display = 'none';"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr align="center">
									<td colSpan="3"><select name="myhour">
											<option value="1" selected>1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
										</select>
										:
										<select name="mymin">
											<option value="00" selected>00</option>
											<option value="05">05</option>
											<option value="10">10</option>
											<option value="15">15</option>
											<option value="20">20</option>
											<option value="25">25</option>
											<option value="30">30</option>
											<option value="35">35</option>
											<option value="40">40</option>
											<option value="45">45</option>
											<option value="50">50</option>
											<option value="55">55</option>
										</select>
										<select name="ampm">
											<option value="am" selected>am</option>
											<option value="pm">pm</option>
										</select>
									</td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td id="s_list" align="center" colSpan="3">&nbsp;</td>
								</tr>
								<tr>
									<td bgColor="#000000" colSpan="3" height="1"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="button" value="确  定" name="rs_ok" onclick="SelTime()">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="sel_matchwin" style="DISPLAY: none; WIDTH: 220px; POSITION: absolute; HEIGHT: 105px">
			<form name="match_form" action="" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="66" bgcolor="#0163a2" id="r_title1"><font color="#ffffff">&nbsp;选择联赛</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="document.all['sel_matchwin'].style.display = 'none';"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr align="center">
									<td colspan="3">
										<select name="selectmatchname" onchange="changeColor()">
											<option value="" selected></option>
											<%# kyglSelMatch %>
										</select>
									</td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3" align="center"><span id="showcolor" style="WIDTH: 50px; HEIGHT: 20px; BACKGROUND-COLOR: black"></span></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="button" value="确  定" name="rs_ok" onclick="SelMatch()">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="sel_rqwin" style="DISPLAY: none; WIDTH: 220px; POSITION: absolute; HEIGHT: 105px">
			<form name="rq_form" action="" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="100" bgcolor="#0163a2"><font color="#ffffff">&nbsp;选择让球情况</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="document.all['sel_rqwin'].style.display = 'none';"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr align="center">
									<td colspan="3">
										<select name="rq1" id="rq1">
											<option value="" selected></option>
											<option value="平手">平手</option>
											<option value="半球">半球</option>
											<option value="一球">一球</option>
											<option value="球半">球半</option>
											<option value="两球">两球</option>
											<option value="两球半">两球半</option>
											<option value="三球">三球</option>
											<option value="三球半">三球半</option>
											<option value="四球">四球</option>
											<option value="四球半">四球半</option>
										</select>
										/
										<select name="rq2" id="rq2">
											<option value="" selected></option>
											<option value="平手">平手</option>
											<option value="半球">半球</option>
											<option value="一球">一球</option>
											<option value="球半">球半</option>
											<option value="两球">两球</option>
											<option value="两球半">两球半</option>
											<option value="三球">三球</option>
											<option value="三球半">三球半</option>
											<option value="四球">四球</option>
											<option value="四球半">四球半</option>
										</select></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="button" value="确  定" name="rs_ok" onclick="Sel_Rq()">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="sel_dxwin" style="DISPLAY: none; WIDTH: 220px; POSITION: absolute; HEIGHT: 105px">
			<form name="dx_form" action="" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="100" bgcolor="#0163a2"><font color="#ffffff">&nbsp;选择让球情况</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="document.all['sel_dxwin'].style.display = 'none';"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr align="center">
									<td colspan="3">
										<select name="dx1" id="dx1">
											<option value="" selected></option>
											<option value="1">1</option>
											<option value="1.5">1.5</option>
											<option value="2">2</option>
											<option value="2.5">2.5</option>
											<option value="3">3</option>
											<option value="3.5">3.5</option>
											<option value="4">4</option>
											<option value="4.5">4.5</option>
											<option value="5">5</option>
											<option value="5.5">5.5</option>
										</select>
										/
										<select name="dx2" id="dx2">
											<option value="" selected></option>
											<option value="1">1</option>
											<option value="1.5">1.5</option>
											<option value="2">2</option>
											<option value="2.5">2.5</option>
											<option value="3">3</option>
											<option value="3.5">3.5</option>
											<option value="4">4</option>
											<option value="4.5">4.5</option>
											<option value="5">5</option>
											<option value="5.5">5.5</option>
											<option value="6">6</option>
										</select></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="button" value="确  定" name="rs_ok" onclick="Sel_Dx()">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="sel_ballwin" style="DISPLAY: none; WIDTH: 220px; POSITION: absolute; HEIGHT: 105px">
			<form name="ball_form" action="" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="100" bgcolor="#0163a2"><font color="#ffffff">&nbsp;选择让球情况</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="document.all['sel_ballwin'].style.display = 'none';"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr align="center">
									<td colspan="3">
										<select name="ballid1" id="ballid1">
											<option value="" selected></option>
											<%# kyglSelBallId %>
										</select></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td align="center" colSpan="3"><input class="text" type="button" value="确  定" name="rs_ok" onclick="Sel_Ball()">
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
