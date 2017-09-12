<%@ Page language="c#" Codebehind="BasketBallList.aspx.cs" AutoEventWireup="false" Inherits="odds.odds.BasketBallList" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>BasketBallList</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script>
			function show_win(ballid,maxc1,maxc2,serverlist)
			{
				var ss;
				var i;
				var tmpStr;
				var tn;
				rs_form.ballid.value=ballid;
				rs_form.maxc1.value=maxc1;
				rs_form.maxc2.value=maxc2;				
				
				if(serverlist != "")
				{
					if(serverlist.indexOf(",") < 0)
					{
						checkThis("cc"+serverlist,true)
					}
					else
					{
						ss = serverlist.split(",");
						for(i=0;i<ss.length;i++)
						{
							tn = "cc"+ss[i]
							checkThis(tn,true)
						}
					}
				}
				else
					checkThis1("cc",false);
					
				//设置弹出窗口的显示位置	
				var popTopAdjust;
				var popLeftAdjust;
				if(event.y+300 > document.body.clientHeight) popTopAdjust = -230;else popTopAdjust = 0;
				rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+250 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
				rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["rs_window"].style.display = "block";	


			}
			
			function show_allwin()
			{
				var ss;
				var i;
				var tmpStr;
				var tn;
				all_form.ballid.value="0";
				all_form.plvalue.value="1.82";
				all_form.maxc1.value="0";
				all_form.maxc2.value="0";			
								
				var popTopAdjust;
				var popLeftAdjust;
				if(event.y+300 > document.body.clientHeight) popTopAdjust = -230;else popTopAdjust = 0;
				all_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
				if(event.x+250 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
				all_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
				document.all["all_window"].style.display = "block";	
			}
			
			function checkThis(fieldName,tt){
				var len = document.rs_form.elements.length;
				for (var i=0; i<len; i++){
					var e = document.rs_form.elements[i];
						if (e.type == 'checkbox' && e.id == fieldName){
			 				e.checked = tt;
						}
				}
			}

			function checkThis1(fieldName,tt){
				var len = document.rs_form.elements.length;
				for (var i=0; i<len; i++){
					var e = document.rs_form.elements[i];
						if (e.type == 'checkbox' && e.id.indexOf(fieldName) != -1){
			 				e.checked = tt;
						}
				}
			}

			function close_win() {
				document.all["rs_window"].style.display = "none";
				document.all["all_window"].style.display = "none";
			}

			function checkdate()
			{
				if(!isint(rs_form.maxc1) || !isint(rs_form.maxc2))
				{
					alert("请输入整数");
					return false;
				}
				else
					return true;
			}
			function checkdate()
			{
				if(!isint(all_form.maxc1) || !isint(all_form.maxc2))
				{
					alert("请输入整数");
					return false;
				}
				else
					return true;
			}

			function isint(aaa)
			{
					if (aaa.value.search(/^[0-9]+$/) == -1) // 判断是否是整数 
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
			<FONT face="宋体">
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="700" border="0">
					<TR id="twoButtonFunc">
						<TD width="400"></TD>
						<TD width="400" align="right">&nbsp;&nbsp;<INPUT type="button" value="全部设定" class="text" onclick="show_allwin();">&nbsp;&nbsp;<INPUT type="button" value="球赛比分" class="text" onclick="self.location.href='basketgamefen.aspx';"></TD>
					</TR>
					<TR>
						<TD colspan="2"><table width="700" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
								<tr class="blueheader" height="25">
									<td width="50">时间</td>
									<td width="100">联赛</td>
									<td width="150">比赛队伍</td>
									<td width="85">状态</td>
									<td width="315">操作</td>
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
			<form name="rs_form" onsubmit="return checkdate();" action="basketballlist.aspx" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="66" bgcolor="#0163a2" id="r_title"><font color="#ffffff">&nbsp;请输入</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="27%">&nbsp;</td>
												<td width="39%">让球</td>
												<td width="34%">大小</td>
											</tr>
											<tr>
												<td>单式</td>
												<td><input name="maxc1" type="text" size="10" class="text"></td>
												<td><input name="maxc2" type="text" size="10" class="text"></td>
											</tr>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3" align="center">子服务器(是否显示)</td>
								</tr>
								<tr>
									<td colspan="3" align="center" id="s_list"><%# kyglServerList %></td>
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
		
		
		<div id="all_window" style="DISPLAY: none; POSITION: absolute">
			<form name="all_form" onsubmit="return checkalldate();" action="basketballlist.aspx" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td width="66" bgcolor="#0163a2" id="r_title"><font color="#ffffff">&nbsp;请输入</font></td>
									<td colspan="2" align="right" vAlign="top" bgcolor="#0163a2"><a style="CURSOR: hand" onclick="close_win();"><IMG height="14" src="images/edit_dot.gif" width="16"></a></td>
								</tr>
								<tr>
									<td height="1" colSpan="3" bgcolor="#000000"></td>
								</tr>
								<tr>
									<td colspan="3">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="27%">&nbsp;</td>
												<td width="39%">让球</td>
												<td width="34%">大小</td>
											</tr>
											<tr>
												<td>赔率值</td>
												<td colspan=2><input name="plvalue" type="text" size="10" class="text"></td>
											</tr>
											<tr>
												<td>单式</td>
												<td><input name="maxc1" type="text" size="10" class="text"></td>
												<td><input name="maxc2" type="text" size="10" class="text"></td>
											</tr>											
										</table>
									</td>
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
		
		
		
	</body>	
</HTML>
<script>
	if("3" == "<%=btnclassid%>")
	{				
		document.all["twoButtonFunc"].style.display = "none";
	}
</script>
