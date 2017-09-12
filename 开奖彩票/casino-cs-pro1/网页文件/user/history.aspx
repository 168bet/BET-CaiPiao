<%@ Page language="c#" Codebehind="history.aspx.cs" AutoEventWireup="false" Inherits="newball.user.history" codePage="936" %>
<HTML>
	<HEAD>
		<title>history_data</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
			<SCRIPT LANGUAGE="JAVASCRIPT">
if(self == top) location = '/';
			</SCRIPT>
	</HEAD>
	<body bgcolor="#000000" leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false">
		<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top" bgcolor="#e5eaee">
					<table width="96%" height="96" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td height="100%" colspan="3"><TABLE cellSpacing="1" cellPadding="0" width="500" border="0">
									<TBODY>
										<TR>
											<TD><table width="100%" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td height="5"></td>
													</tr>
													<tr>
														<td><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0">
																<tbody>
																	<tr>
																		<td width="99%" class="td_02" bgcolor="#cccccc"><font size="2">
																				<marquee scrolldelay="120" class="td_02">
																					<span id="Msg">
																						<%# msg%>
																					</span>
																				</marquee>
																			</font>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td height="5"></td>
													</tr>
												</table>
											</TD>
										</TR>
									</TBODY>
									<TBODY>
										<TR>
											<TD height="20">
												<table class="table_banner" cellSpacing="0" cellPadding="0" width="500" border="0">
													<tr>
														<td>
															<TABLE class="banner_set" height="24" cellSpacing="0" cellPadding="0" width="100%" border="0">
																<TBODY>
																	<TR>
																		<TD width="107" height="12">六合彩历史帐户</TD>
																		<TD width="441" height="12">&nbsp;</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</td>
													</tr>
												</table>
											</TD>
										</TR>
									</TBODY>
								</TABLE>
								<TABLE class="table_title_line" cellSpacing="0" cellPadding="0" width="500" border="0">
									<TBODY>
										<TR>
											<TD height="5"></TD>
										</TR>
										<TR>
											<TD><TABLE width="100%" border="1">
													<TBODY>
														<TR class="tr_title_set_cen">
															<TD width="20%" height="20" align="center">日期</TD>
															<TD width="10%" height="20" align="center">
															期数
															<TD width="20%" height="20" align="center">下注金额</TD>
															<TD width="20%" height="20" align="center">结果</TD>
															<!--<TD width="10%" height="20" align="center">结清</TD>-->
															<TD height="20" align="center">馀额</TD>
														</TR>
														<%# kyglList %>
														<TR>
														</TR>
													</TBODY>
												</TABLE>
												<table>
													<tr>
														<td align="center"><%# System.Configuration.ConfigurationSettings.AppSettings["CopyRight"] %></td>
													</tr>
												</table>
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
	</body>
</HTML>
