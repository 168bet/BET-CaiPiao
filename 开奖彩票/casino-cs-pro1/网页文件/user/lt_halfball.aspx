<%@ Page language="c#" Codebehind="lt_halfball.aspx.cs" AutoEventWireup="false" Inherits="newball.user.lt_football" codePage="936" %>
<html>
	<head>
		<title>body_lotto</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
			<script language="javascript">
if(self == top) location = '/';


var type_nums = 6;  //预设为 3中2
var type_min = 3;
var cb_num = 1;
var mess1 =  '尚未选满 6 个生肖';
var mess2 =  '最多选择 6 个生肖';
var mess = mess2;
var gTime='<%# gTime %>';

function select_types(type) {
	if (type == 1 || type == 2) {
		type_nums = 10;
		type_min = 3;
	} else {
		type_nums = 10;
		type_min = 2;
	}
}      
function SubChk(obj) {
	var checkCount = 0;
	var checknum = obj.elements.length;
	var rtypechk = 0;
	for(i=0; i<obj.rtype.length; i++) {
		if (obj.rtype[i].checked)
			rtypechk ++;
	}

	if (rtypechk == 0) {
	  alert('请选择类别');
	  return false;
	}
	
	for(i=0; i<checknum; i++) {
		if (obj.elements[i].checked) {
			checkCount ++;
		}
	}
	if(checkCount != (type_nums + 1)){
		alert(mess1);
		return false;
	}else{
		return true;
	}
}

function SubChkBox(obj) {

	if(obj.checked == false)
	{
		cb_num--;
	}
	if(obj.checked == true)	{
		if ( cb_num > type_nums ) {
			alert(mess);
			cb_num--;
			obj.checked = false;
		}
		cb_num++;
	}
}
function reset_num(){
	cb_num='1';
	return true;
}
function show_allwin()
			{
				
				document.all["all_window"].style.display = "block";	
			}
function onload() {
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
}
			</script>
	</head>
	<body bbnet_mem_ordermargin="0" topmargin="0" leftmargin="0" oncontextmenu="window.event.returnValue=false"
		onLoad="onload();">
		<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0" class="table_banner">
			<tr>
				<td valign="top">
					<table width="96%" height="58" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td height="100%" colspan="3" valign="top">
								<TABLE cellSpacing="1" cellPadding="0" width="502" border="0">
									<TBODY>
										<TR>
											<TD><table width="100%" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td height="5"></td>
													</tr>
													<tr>
														<td><table width="100%" border="0" align="bbnet_mem_order" cellpadding="2" cellspacing="0">
																<tbody>
																	<tr>
																		<td width="99%" class="td_02" bgcolor="#CCCCCC"><font size="2">
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
									<TR>
										<TD>
											<table class="table_banner" cellSpacing="0" cellPadding="0" width="500" border="0">
												<tr>
													<td>
														<TABLE class="banner_set" cellSpacing="0" cellPadding="0" width="500" border="0">
															<TBODY>
																<TR>
																	<TD width="50" height="20">半波</TD>
																	<TD width="30"><!--<INPUT class=select_cen onclick=javascript:location.reload() type=button value=更新 name=button>-->
																	</TD>
																	<TD>&nbsp;&nbsp;<B><FONT id="countdown_num">&nbsp;&nbsp;&nbsp;&nbsp;</FONT></B></TD>
																	<TD align="right">(<B>香港时间:</B>
																		<%# DateTime.Now%>
																		)</TD>
																</TR>
															</TBODY>
														</TABLE>
													</td>
												</tr>
											</table>
										</TD>
									</TR>
								</TABLE>
							</td>
						</tr>
						<tr><td><table id="show_table" style="DISPLAY: none">
						<TR>
							<TD height="30">期数: <B>
									<%# qishu %>
								</B>&nbsp;&nbsp;<B>开奖日期: </B>
								<%# kaisai%>
								&nbsp;&nbsp;&nbsp;</TD>
							<TD align="bbnet_mem_order"></TD>
						</TR>
						<tr>
							<td>
								
									<table border="0" cellpadding="0" cellspacing="1" align='bbnet_mem_order' width='508' class="banner_set" >
										<tr height='20'>
											<td width='90' align='center' bgcolor="85BAE4" class='table-title4'>半波</td>
											<td width='90' align='center' bgcolor="85BAE4" class='table-title4'>赔率</td>
											<td width='*' align='center' bgcolor="85BAE4" class='table-title4'>号码</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>红单</td>
											<td align='center'><a href='betting-entry.aspx?m=232,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.60</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>1</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>7</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>13</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>19</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>23</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>29</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>35</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>45</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>红双</td>
											<td align='center'><a href='betting-entry.aspx?m=233,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.05</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>2</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>8</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>12</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>18</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>24</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>30</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>34</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>40</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>46</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>红大</td>
											<td align='center'><a href='betting-entry.aspx?m=234,1,17' target='bbnet_mem_order' class='bet_rate_blue'>6.50</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>29</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>30</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>34</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>35</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>40</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>45</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>46</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>红小</td>
											<td align='center'><a href='betting-entry.aspx?m=235,1,17' target='bbnet_mem_order' class='bet_rate_blue'>4.50</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>1</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>2</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>7</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>8</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>12</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>13</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>18</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>19</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>23</b></td>
														<td class='redBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>24</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>绿单</td>
											<td align='center'><a href='betting-entry.aspx?m=236,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.05</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>5</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>11</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>17</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>21</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>27</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>33</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>39</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>43</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>绿双</td>
											<td align='center'><a href='betting-entry.aspx?m=237,1,17' target='bbnet_mem_order' class='bet_rate_blue'>6.50</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>6</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>16</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>22</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>28</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>32</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>38</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>44</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>绿大</td>
											<td align='center'><a href='betting-entry.aspx?m=238,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.05</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>27</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>28</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>32</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>33</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>38</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>39</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>43</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>44</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>绿小</td>
											<td align='center'><a href='betting-entry.aspx?m=239,1,17' target='bbnet_mem_order' class='bet_rate_blue'>6.50</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>5</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>6</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>11</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>16</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>17</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>21</b></td>
														<td class='greenBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>22</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>蓝单</td>
											<td align='center'><a href='betting-entry.aspx?m=240,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.60</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>3</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>9</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>15</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>25</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>31</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>37</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>41</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>47</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>蓝双</td>
											<td align='center'><a href='betting-entry.aspx?m=241,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.60</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>4</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>10</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>14</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>20</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>26</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>36</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>42</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>48</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>蓝大</td>
											<td align='center'><a href='betting-entry.aspx?m=242,1,17' target='bbnet_mem_order' class='bet_rate_blue'>5.05</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>25</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>26</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>31</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>36</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>37</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>41</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>42</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>47</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>48</b></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor='#ffffff'>
											<td align='center'>蓝小</td>
											<td align='center'><a href='betting-entry.aspx?m=243,1,17' target='bbnet_mem_order' class='bet_rate_blue'>6.50</a></td>
											<td align='bbnet_mem_order'><table border='0' cellpadding='0' cellspacing='0'>
													<tr>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>3</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>4</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>9</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>10</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>14</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>15</b></td>
														<td class='blueBall' align='center' bgcolor='#ffffff' width='25' height='25'><b>20</b></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								
							</td>
						</tr>
						</table></td></tr>
						<tr>
							<td height="100%" colspan="3">
								<TABLE class="table_title_line"  style="DISPLAY: none" cellSpacing="0" cellPadding="0"
									width="500" border="0">
									<TBODY>
										<TR>
											<TD height="5" colSpan="2"></TD>
										</TR>
										<TR>
											<TD colSpan="2">
											</TD>
										</TR>
										<tr>
											<td height="10" colspan="2">&nbsp;</td>
										</tr>
									</TBODY>
								</TABLE>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
