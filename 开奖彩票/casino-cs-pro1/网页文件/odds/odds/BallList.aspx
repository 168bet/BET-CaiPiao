<%@ Page language="c#" Codebehind="BallList.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.BallList" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>BallList</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
		<script>
function show_win(ballid,maxc1,maxc2,maxc3,maxc4,maxc5,maxc6,serverlist)
{
	var ss;
	var i;
	var tmpStr;
	var tn;
	rs_form.ballid.value=ballid;
	rs_form.maxc1.value=maxc1;
	rs_form.maxc2.value=maxc2;
	rs_form.maxc3.value=maxc3;
	rs_form.maxc4.value=maxc4;
	rs_form.maxc5.value=maxc5;
	rs_form.maxc6.value=maxc6;
	
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
	var popTopAdjust;
	var popLeftAdjust;
	if(event.y+300 > document.body.clientHeight) popTopAdjust = -230;else popTopAdjust = 0;
	rs_window.style.top = event.y+20+document.body.scrollTop+popTopAdjust;
	if(event.x+250 > document.body.clientWidth) popLeftAdjust=-250 - 50;else popLeftAdjust=+50;	
	rs_window.style.left = event.x+document.body.scrollLeft+popLeftAdjust;
	document.all["rs_window"].style.display = "block";	


}
function checkThis(fieldName,tt){
	var len = document.rs_form.elements.length;
	for (var i=0; i<len; i++){
	     var e = document.rs_form.elements[i];
             if (e.type == 'checkbox' && e.id == fieldName){
             //if(e.type == 'checkbox' && e.name == fieldName)
			 	e.checked = tt;
             }
	}
}

function checkThis1(fieldName,tt){
	var len = document.rs_form.elements.length;
	for (var i=0; i<len; i++){
	     var e = document.rs_form.elements[i];
             if (e.type == 'checkbox' && e.id.indexOf(fieldName) != -1){
             //if(e.type == 'checkbox' && e.name == fieldName)
			 	e.checked = tt;
             }
	}
}

function close_win() {
	document.all["rs_window"].style.display = "none";
}

function checkdate()
{
	if(!isint(rs_form.maxc1) || !isint(rs_form.maxc2) || !isint(rs_form.maxc3) || !isint(rs_form.maxc4) || !isint(rs_form.maxc5) || !isint(rs_form.maxc6))
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
				//alert(msg + "!\n");
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
				<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="980" border="0">
					<TR id="twoButtonFunc">
						<TD style="WIDTH: 678px" width="678"></TD>
						<TD align="left" width="500"><INPUT class="text" onclick="self.location.href='ballmsg.aspx?action=add';" type="button"
								value="添加">&nbsp;&nbsp;</TD>
					</TR>
					<TR>
						<TD colSpan="2">
							<table height="100%" cellSpacing="0" cellPadding="0" width="546" border="0">
								<tr>
									<td vAlign="top" bgColor="#e5eaee">
										<table height="96" cellSpacing="0" cellPadding="0" width="96%" align="center" border="0">
											<tr>
												<td colSpan="3" height="100%">
													<TABLE cellSpacing="1" cellPadding="0" width="500" border="0">
														<TBODY>
															<TR>
																<TD>
																	<table cellSpacing="0" cellPadding="0" width="100%" border="0">
																		<tr>
																			<td height="5"></td>
																		</tr>
																		<tr>
																			<td height="5"></td>
																		</tr>
																	</table>
																</TD>
															</TR>
														</TBODY>
														<FORM action="?" method="get" name="myFORM">
															<TBODY>
																<TR>
																	<TD>
																		<table class="table_banner" cellSpacing="0" cellPadding="0" width="600" border="0">
																			<tr>
																				<td>
																					<TABLE class="banner_set" height="24" cellSpacing="0" cellPadding="0" width="100%" border="0">
																						<TR bgColor="#c1d7e5">
																							<TD width="130" height="12"><a href="http://www.hkjc.com/chinese/mark6/results.asp" target="_blank">香港马会开奖结果</a></TD>
																							<TD width="50" height="12">&nbsp;
																							</TD>
																							<td align="right" width="400">总页数:
																								<select class="zaselect_ste" onchange="self.myFORM.submit()" name="page">
																									<%# pageorder %>
																								</select>
																						</TR>
																					</TABLE>
																				</td>
																			</tr>
																		</table>
																	</TD>
																</TR>
														</FORM>
													</TABLE>
													<TABLE class="table_title_line" height="8" cellSpacing="0" cellPadding="0" width="600"
														border="0">
														<TBODY>
															<TR>
																<TD>
																	<TABLE width="100%" border="1">
																		<TBODY>
																			<TR class="tr_title_set_cen">
																				<TD align="center" width="10%" bgColor="#c1d7e5" rowSpan="2">期数</TD>
																				<TD noWrap bgColor="#a4c6db" rowSpan="2">
																					<div align="center">时间</div>
																				</TD>
																				<TD class="title_00" bgColor="#9d2e2e" colSpan="9">
																					<div align="center">彩球号码</div>
																				</TD>
																			</TR>
																			<TR class="tr_title_set_cen">
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">正码一</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">正码二</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">正码三</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">正码四</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">正码五</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">正码六</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">特别号</TD>
																				<TD class="title_02" align="center" width="5%" bgColor="#b9c0c4">总合</TD>
																				<TD class="title_02" align="center" width="12%" bgColor="#b9c0c4">操作</TD>
																			</TR>
																			<%# kyglcontent%>
																		</TBODY>
																	</TABLE>
																</TD>
															</TR>
														</TBODY>
													</TABLE>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</TD>
					</TR>
					<TR>
						<TD style="WIDTH: 678px"></TD>
						<TD></TD>
					</TR>
					</TBODY></TABLE>
			</FONT>
		</form>
		<div id="rs_window" style="DISPLAY: none; POSITION: absolute">
			<form name="rs_form" onsubmit="return checkdate();" action="balllist.aspx" method="post">
				<input type="hidden" name="ballid"> <input type="hidden" value="ffpost" name="action">
				<table cellSpacing="1" cellPadding="2" width="220" bgColor="#00558e" border="0">
					<tr>
						<td bgColor="#ffffff">
							<table class="m_tab_fix" cellSpacing="0" cellPadding="0" width="100%" bgColor="#a4c0ce"
								border="0">
								<tr>
									<td id="r_title" width="66" bgColor="#0163a2"><font color="#ffffff">&nbsp;请输入</font></td>
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
											<tr>
												<td>走地</td>
												<td><input name="maxc3" type="text" size="10" class="text"></td>
												<td><input name="maxc4" type="text" size="10" class="text"></td>
											</tr>
											<tr>
												<td>上半场</td>
												<td><input name="maxc5" type="text" size="10" class="text"></td>
												<td><input name="maxc6" type="text" size="10" class="text"></td>
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
		<script>
	if("3" == "<%=btnclassid%>")
	{				
		document.all["twoButtonFunc"].style.display = "none";
	}
		</script>
	</body>
</HTML>
