<%@ Page language="c#" Codebehind="lt_ch.aspx.cs" AutoEventWireup="false" Inherits="newball.user.lt_ch" codePage="936" %>
<html>
	<head>
		<title>body_lotto</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
			<script language="javascript">
if(self == top) location = '/';


var type_nums = 10;  //预设为 3中2
var type_min = 3;
var cb_num = 1;
var mess1 =  '最少选择';
var mess11 = '个数字';
var mess2 =  '最多选择10个数字';
var mess3 = '请选择正号';
var mess = mess2;
var rs_num = 'R';	//设定要选择填入ㄉ号码是 正号 还是 副号
var num_color = new Array();
var select_num = new Array();
var gTime='<%# gTime %>';

num_color['01'] = 'r.gif'; 
num_color['02'] = 'r.gif'; 
num_color['03'] = 'b.gif'; 
num_color['04'] = 'b.gif'; 
num_color['05'] = 'g.gif'; 
num_color['06'] = 'g.gif'; 
num_color['07'] = 'r.gif'; 
num_color['08'] = 'r.gif'; 
num_color['09'] = 'b.gif'; 
num_color['10'] = 'b.gif'; 
num_color['11'] = 'g.gif'; 
num_color['12'] = 'r.gif'; 
num_color['13'] = 'r.gif'; 
num_color['14'] = 'b.gif'; 
num_color['15'] = 'b.gif'; 
num_color['16'] = 'g.gif'; 
num_color['17'] = 'g.gif'; 
num_color['18'] = 'r.gif'; 
num_color['19'] = 'r.gif'; 
num_color['20'] = 'b.gif'; 
num_color['21'] = 'g.gif'; 
num_color['22'] = 'g.gif'; 
num_color['23'] = 'r.gif'; 
num_color['24'] = 'r.gif'; 
num_color['25'] = 'b.gif'; 
num_color['26'] = 'b.gif'; 
num_color['27'] = 'g.gif'; 
num_color['28'] = 'g.gif'; 
num_color['29'] = 'r.gif'; 
num_color['30'] = 'r.gif'; 
num_color['31'] = 'b.gif'; 
num_color['32'] = 'g.gif'; 
num_color['33'] = 'g.gif'; 
num_color['34'] = 'r.gif'; 
num_color['35'] = 'r.gif'; 
num_color['36'] = 'b.gif'; 
num_color['37'] = 'b.gif'; 
num_color['38'] = 'g.gif'; 
num_color['39'] = 'g.gif'; 
num_color['40'] = 'r.gif'; 
num_color['41'] = 'b.gif'; 
num_color['42'] = 'b.gif'; 
num_color['43'] = 'g.gif'; 
num_color['44'] = 'g.gif'; 
num_color['45'] = 'r.gif'; 
num_color['46'] = 'r.gif'; 
num_color['47'] = 'b.gif'; 
num_color['48'] = 'b.gif'; 
num_color['49'] = 'g.gif'; 


function select_types(type) {
	if (type == 1 || type == 2) {
		type_nums = 10;
		type_min = 3;
	} else {
		type_nums = 10;
		type_min = 2;
	}
	
	eval("RSTable.style.display=\"\";");
	select_RS('R');
	CHorRS();
} 

function select_RS(temp) {	//选择现在要选ㄉ号码 是正号还是副号
	if(temp == 'R') {
		rs_num = 'R';
		document.all["RNumT"].style.color = "#FF0000";
		document.all["SNumT"].style.color = "#000000";
	} else {
		rs_num = 'S';
		document.all["RNumT"].style.color = "#000000";
		document.all["SNumT"].style.color = "#FF0000";
	}	
}



	
function SubChk(obj) {
	var checkCount = 0;
	var checknum = obj.elements.length;
	var rtypechk = 0;
	
	
	for(i=0; i<obj.rtype.length; i++) {
		if (obj.rtype[i].checked) {
			rtypechk ++;
		}
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
	
	
	//检查选ㄌ 正/副码  检查他有没有选正号
		
	if (document.lt_form.RS.checked && document.lt_form.rs_r.value == '') {
		alert(mess3);
		select_RS('r');
		return false;
	}
	
	if(document.lt_form.RS.checked && (checkCount >(type_nums + 2))){
	alert(mess2);
		return false;
	}
	else if(!document.lt_form.RS.checked &&(checkCount > (type_nums + 1))) {
		alert(mess2);
		return false;
	}
	if(document.lt_form.RS.checked && (checkCount < (type_min+2))){
		alert(mess1+type_min+mess11);
		return false;
	}else if(checkCount < (type_min+1))
	{
		alert(mess1+type_min+mess11);
		return false;
	}
	else{
		return true;
	}
	
	
}

function SubChkBox(obj) {

	if(obj.checked == false)
	{
		cb_num--;
		//obj.checked = false;
	}


	//alert (cb_num);


	if(obj.checked == true)
	{
		if ( cb_num > type_nums ) 
		{
			alert(mess);
			cb_num--;
			obj.checked = false;
		}
		cb_num++;
	}
}

function RSChkBox(obj) {
	if(rs_num == 'R' && obj.checked) {
		document.lt_form.rs_r.value = obj.value;
		select_RS('S');
	}
	document.all["RNumB"].innerHTML = "";
	document.all["SNumB"].innerHTML = "";
	numobj = document.lt_form.elements;
	for (i=0; numobj[i]; i++) {
		if (numobj[i].type == "checkbox" && numobj[i].checked == true && numobj[i].name == "num[]") {
			if(numobj[i].value == document.lt_form.rs_r.value)
				document.all["RNumB"].innerHTML  = "<span style='background-image: url(images/ball/"+ num_color[numobj[i].value] +");background-repeat: no-repeat; text-align: center; height: 25px; width: 25px;'><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">"+ numobj[i].value +"</font></span>";
			else	
				document.all["SNumB"].innerHTML += "<span style='background-image: url(images/ball/"+ num_color[numobj[i].value] +");background-repeat: no-repeat; text-align: center; height: 25px; width: 25px;'><font style=\"filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px\">"+ numobj[i].value +"</font></span>";
		}
	}
	if(document.all["RNumB"].innerHTML == "") {
		document.lt_form.rs_r.value = "";
		select_RS('R');
	}
}

function CHorRS() {
	if(document.lt_form.RS.checked) {
		eval("RNumT.style.display=\"\";");
		eval("RNumB.style.display=\"\";");
		eval("SNumT.style.display=\"\";");
		eval("SNumB.style.display=\"\";");
     
	} else {
		eval("RNumT.style.display=\"none\";");
		eval("RNumB.style.display=\"none\";");
		eval("SNumT.style.display=\"none\";");
		eval("SNumB.style.display=\"none\";");
	}	
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
	<body leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false"  onload="onload();">
		<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0" class="table_banner">
			<tr>
				<td valign="top">
					<table width="96%" height="96" border="0" align="center" cellpadding="0" cellspacing="0">
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
														<td><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0">
																<tbody>
																	<tr>
																		<td width="99%" class="td_02" bgcolor="#CCCCCC"><font size="2">
																				<marquee scrolldelay="120" class="td_02"><span id="Msg"><%# msg%></span></marquee>
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
																	<TD width="50" height="20">连码</TD>
																	<TD width="30"><!--<INPUT class=select_cen onclick=javascript:location.reload() type=button value=更新 name=button>-->
																	</TD>
																	<TD>&nbsp;&nbsp;<B><FONT id="countdown_num">&nbsp;&nbsp;&nbsp;&nbsp;</FONT></B></TD>
																	<TD align="right">(<B>香港时间:</B> <%# DateTime.Now%>)</TD>
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
						<form name="lt_form" method="post" action="betting-entry.aspx" target="bbnet_mem_order" onSubmit="return SubChk(this);">
							<input type="hidden" name="action" value="ch"> <input type="hidden" name="rs_r" value="">
							<tr>
								<td height="100%" colspan="3">
									<TABLE class="table_title_line" id="show_table" style="DISPLAY: none" cellSpacing="0" cellPadding="0" width="500" border="0">
										<TBODY>
											<TR>
												<TD height="5" colSpan="2"></TD>
											</TR>
											<TR>
												<TD height="30">期数: <B><%# qishu %></B>&nbsp;&nbsp;<B>开奖日期: </B><%# kaisai%>&nbsp;&nbsp;&nbsp;</TD>
												<TD align="left">(<b>请先选择类别,再选择号码</b>)</TD>
											</TR>
											<TR>
												<TD colSpan="2">
													<table width="100%" border="0" cellspacing="2" cellpadding="0">
														<tr class="ball_td">
															<td align="center">类别</td>
															<td align="center"><input name="rtype" type="radio" value="151" onclick="select_types(2);">三全中</td>
															<td align="center"><input name="rtype" type="radio" value="152" onclick="select_types(1);">三中二</td>
															<td align="center"><input name="rtype" type="radio" value="154" onclick="select_types(3);">二全中</td>
															<td align="center"><input name="rtype" type="radio" value="155" onclick="select_types(4);">二中特</td>
															<td align="center"><input name="rtype" type="radio" value="157" onclick="select_types(5);">特串</td>
														</tr>
														<tr class="list_cen">													
															
															<%# kygltable %>
															
														</tr>
													</table>
													<table width="100%" border="0" cellspacing="2" cellpadding="0" id='RSTable' style="display:none">
														<tr class="tr_title_set_cen">
															<td id='RS' width="80" onclick="select_RS('R');" style='cursor:hand'><input type="checkbox" name="RS" value="R" onclick='CHorRS();'>正/副号</td>
															<td id='RNumT' width="40" onclick="select_RS('R');" style='cursor:hand'>正号</td>
															<td id='RNumB' width="40" align="center">
															</td>
															<td id='SNumT' width="40" onclick="select_RS('S');" style='cursor:hand'>副号</td>
															<td id='SNumB' width="300" align="center">
															</td>
														</tr>
													</table>
												</TD>
											</TR>
											<TR>
												<TD colSpan="2">
													<TABLE width="100%" border="0" cellspacing="1" cellpadding="0">
														<TBODY>
															<TR class="tr_title_set_cen">
																<TD width="50">号码</TD>
																<TD width="50">勾选</TD>
																<TD width="50">号码</TD>
																<TD width="50">勾选</TD>
																<TD width="50">号码</TD>
																<TD width="50">勾选</TD>
																<TD width="50">号码</TD>
																<TD width="50">勾选</TD>
																<TD width="50">号码</TD>
																<TD width="50">勾选</TD>
															</TR>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">01</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="01" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">11</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="11" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">21</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="21" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">31</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="31" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">41</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="41" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">02</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="02" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">12</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="12" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">22</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="22" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">32</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="32" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">42</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="42" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">03</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="03" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">13</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="13" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">23</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="23" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">33</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="33" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">43</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="43" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">04</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="04" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">14</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="14" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">24</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="24" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">34</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="34" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">44</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="44" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">05</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="05" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">15</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="15" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">25</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="25" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">35</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="35" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">45</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="45" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">06</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="06" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">16</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="16" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">26</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="26" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">36</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="36" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">46</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="46" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">07</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="07" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">17</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="17" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">27</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="27" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">37</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="37" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">47</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="47" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">08</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="08" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">18</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="18" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">28</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="28" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">38</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="38" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">48</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="48" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">09</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="09" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">19</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="19" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">29</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="29" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">39</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="39" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/g.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">49</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="49" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
															</tr>
															<tr>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">10</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="10" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/b.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">20</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="20" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">30</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="30" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<TD align="center" class="ball_td" background="images/ball/r.gif" height="27"><font style="filter: glow(color=#000000,strength=1); height:10px; color:#000000; padding:2px">40</font></TD>
																<td align="center"><input type="checkbox" name="num[]" value="40" onClick="RSChkBox(this); SubChkBox(this,this);"></td>
																<td align="center" colspan="2">
																	<input type="submit" name="btnSubmit" value="确定"> <input type="reset" name="btnSubmit" value="取消" onclick="cb_num=1;"></td>
															</tr>
														</TBODY>
													</TABLE>
												</TD>
											</TR>
										</TBODY>
									</TABLE>
								</td>
							</tr>
						</form>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
