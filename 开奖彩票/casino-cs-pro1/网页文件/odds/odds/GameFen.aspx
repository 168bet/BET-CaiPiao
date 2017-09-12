<%@ Page language="c#" Codebehind="GameFen.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.GameFen" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>GameFen</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
<script>
function show_win(ballid,btype,bf1,bf2) {
	//alert(document.body.scrollTop);
	//alert(event.clientY);
	if(btype == "1")
		document.all["r_title"].innerHTML = '<font color="#FFFFFF">请输入上半场比分</font>';
	else
		document.all["r_title"].innerHTML = '<font color="#FFFFFF">请输入全场比分</font>';
	for(var i=0;i<=20;i++){
		document.rs_form.bf1.options[i]=new Option(i,i);
		if(bf1 != "" && i==bf1) document.rs_form.bf1.selectedIndex=i;
	}
	for(var i=0;i<=20;i++){
		document.rs_form.bf2.options[i]=new Option(i,i);
		if(bf2 != "" && i==bf2) document.rs_form.bf2.selectedIndex=i;
	}

	//rs_form.kind.value=kind;
	rs_form.ballid.value=ballid;
	rs_form.btype.value = btype;
	var popTopAdjust;
	var popLeftAdjust;
	if(event.y+200 > document.body.clientHeight) popTopAdjust = -230;else popTopAdjust = 0;
	rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
	if(event.x+250 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
	rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
	document.all["rs_window"].style.display = "block";
}
function close_win() {
	document.all["rs_window"].style.display = "none";
}	
		
		
</script>
		
	</HEAD>
	<BODY leftMargin="1" topMargin="1">
		<form id="Form1" method="post" runat="server">
			<table width="980" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<asp:DropDownList id="SelectDay" runat="server" AutoPostBack="True"></asp:DropDownList>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="980" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
							<tr class="blueheader">
								<td width="60">时间</td>
								<td width="70">球赛ID</td>
								<td width="118">联赛名</td>
								<td width="173">主队</td>
								<td width="175">客队</td>
								<td width="75">上半场比分</td>
								<td width="79">下半场比分</td>
								<td width="70">操作</td>
								<td width="60">操作</td>
								<td width="100">状况</td>
							</tr>
							<%# kyglContent %>
						</table>
					</td>
				</tr>
			</table>
		</form>
<div id="rs_window" style="DISPLAY: none; POSITION: absolute">
			<form name="rs_form" action="gamefen.aspx" method="post">
				<input type="hidden" name="ballid" value=""> <input type="hidden" value="ffpost" name="action">
				<input type="hidden" name="btype" value=""><input type="hidden" value="<%# kyglSelDay %>" name="selday">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
            <tr> 
              <td width="145" bgcolor="#0163a2" id="r_title"><font color="#ffffff">&nbsp;请输入比分</font></td>
              <td width="69" colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
            </tr>
            <tr> 
              <td height="1" colSpan="3" bgcolor="#000000"></td>
            </tr>
            <tr> 
              <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="50%" align="center">主队分</td>
                    <td width="50%" align="center">客队分</td>
                  </tr>
                  <tr> 
                    <td align="center"><select name="bf1">
                      </select></td>
                    <td align="center"><select name="bf2">
                      </select></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <td height="1" colSpan="3" bgcolor="#000000"></td>
            </tr>
            <tr> 
              <td align="center">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr> 
              <td height="1" colSpan="3" bgcolor="#000000"></td>
            </tr>
            <tr> 
              <td align="center" colSpan="3"><input class="text" type="submit" value="确  定" name="rs_ok"> 
              </td>
            </tr>
          </table>
						</td>
					</tr>
				</table>
			</form>
		</div>		
	</BODY>
</HTML>
