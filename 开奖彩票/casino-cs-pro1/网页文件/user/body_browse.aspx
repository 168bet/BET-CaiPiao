<%@ Page language="c#" Codebehind="body_browse.aspx.cs" AutoEventWireup="false" buffer="False" Inherits="newball.user.body_browse" %>
<HTML>
	<HEAD>
		<title>body_football_r</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<link rel="stylesheet" href="css/mem_body.css" type="text/css">
			<script language="JavaScript" src="js/refresh-function.js"></script>
			<LINK href="css/client_LT_game.css" type="text/css" rel="stylesheet">
				<SCRIPT language="JAVASCRIPT">

var gid="55555556666";
if (self == top)
{
	window.open('/','_top');
}



var cd=60;
var gt = 0;
var Difft = 0;



function preloadImage() {
   	var arrayImg = new Array();
	var argus = preloadImage.arguments;
	for(var i=0; i < argus.length; i++) {
		arrayImg[i] = new Image();
		arrayImg[i].src = argus[i];
	}
	
}

function time_reload()
{
	if (typeof(parent.timer.time_list)!="undefined")
	{
	
		for (var i=0;i < parent.timer.time_list.length;i++) 
		{			
			parent.timer.time_list.options[i].text -= 1;
				
			if (parent.timer.time_list.options[i].text <= 1)
			{
				eval(parent.timer.time_list.options[i].value+"1_bg.style.backgroundColor=''");
				eval(parent.timer.time_list.options[i].value+"2_bg.style.backgroundColor=''");
				parent.timer.time_list.options[i] = null;
				i--;
			}else{
			    if (eval("window."+parent.timer.time_list.options[i].value+" != null")) {
					eval(parent.timer.time_list.options[i].value+"1_bg.style.backgroundColor='#FFFFAA'");
					eval(parent.timer.time_list.options[i].value+"2_bg.style.backgroundColor='#FFFFAA'");
			    }else{
			        parent.timer.time_list.options[i] = null;
			        i--;
		    	}
			}
		}
	}
	
	// parent.main.countdown_num.innerHTML=cd;
	
	if (typeof(parent.sTime) != 'undefined' && parent.sTime != 'N') {
		
		if (parent.sTime != '' && typeof(parent.gTime)!='undefined') {
			
			closeM.style.display = "block";
			closeM1.style.display = "none"
			gt = eval(parent.sTime);
			
			if (Difft != gt) {
				Difft = gt;
				close_msg.innerHTML = Difft;
			}else{
				if (close_msg.innerHTML!='&nbsp;'){
					if (eval(close_msg.innerHTML) < 1) { 
						cd=0;
						parent.sTime = 'N';
					}else{
						close_msg.innerHTML = close_msg.innerHTML -1;
					}
				}else{
					close_msg.innerHTML = Difft;
				}
			}
		}
	}else{
		if (close_msg.innerHTML != '&nbsp;') close_msg.innerHTML = '&nbsp;';
		if (closeM.style.display != "none") closeM.style.display = "none";
	}
	
	if (cd<=0)
	{
	  cd=60;
	  loading();
	}else{
	  cd--;
	}
	close_msg1.innerHTML=cd;
	  if (parent.s=='Y')
     parent.s='YY';
	setTimeout("time_reload()",1000);
}

function loading()
{
	//Loading.style.display ='block';
	cd=60;	
	parent.action.location ="body_var.aspx?rtype=<%# Request.QueryString["rtype"] %>&langx=zh-cn&mtype=<%# Request.QueryString["mtype"] %>&Reload=Y";
}
function onload()
{
  parent.loading_var = 'N';
 if(parent.loading == 'N' && parent.wtype != '')

  {

   parent.ShowGameList(); 

  }

	
}

var sgame_num = '<%# sgame_num%>';

if(self == top) location = '/';


var type_nums = 6;  //预设为 3中2
var type_min = 3;
var cb_num = 1;
var mess1 =  '尚未选满 6 个生肖';
var mess2 =  '最多选择 6 个生肖';
var mess = mess2;


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

				</SCRIPT>
				<!--<body leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false" onload="preloadImage('../../images/ball/r.gif','../../images/ball/b.gif','../../images/ball/g.gif');">-->
				<META content="MSHTML 6.00.3790.279" name="GENERATOR">
	</HEAD>
	<BODY oncontextmenu="window.event.returnValue=false" leftMargin="0" topMargin="0" onLoad="preloadImage('images/ball/r.gif','images/ball/b.gif','images/ball/g.gif');onload();">
		<TABLE class="table_banner" height="100%" cellSpacing="0" cellPadding="0" width="546" border="0">
			<TBODY>
				<TR>
					<TD vAlign="top">
						<TABLE height="96" cellSpacing="0" cellPadding="0" width="96%" align="center" border="0">
							<TBODY>
								<TR>
									<TD vAlign="top" colSpan="3" height="100%">
										<TABLE cellSpacing="1" cellPadding="0" width="502" border="0">
											<TBODY>
												<TR>
													<TD>
														<TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
															<TBODY>
																<TR>
																	<TD height="5"></TD>
																</TR>
																<TR>
																	<TD>
																		<TABLE cellSpacing="0" cellPadding="2" width="100%" align="left" border="0">
																			<TBODY>
																				<TR>
																					<TD class="td_02" width="99%" bgColor="#cccccc"><FONT size="2">
																							<MARQUEE class="td_02" scrollDelay="120">
																								<SPAN id="real_Msg"></SPAN>
																							</MARQUEE></FONT></TD>
																				</TR>
																			</TBODY></TABLE>
																	</TD>
																</TR>
																<TR>
																	<TD height="5"></TD>
																</TR>
															</TBODY></TABLE>
													</TD>
												</TR>
											</TBODY>
											<TBODY>
												<TR>
													<TD>
														<TABLE class="table_banner" cellSpacing="0" cellPadding="0" width="500" border="0">
															<TBODY>
																<TR>
																	<TD>
																		<TABLE class="banner_set" cellSpacing="0" cellPadding="0" width="500" border="0">
																			<TBODY>
																				<TR>
																					<TD width="50" height="20"><%# rtype%></TD>
																					<TD width="135"><%# quickinput %><!--<INPUT class="select_cen" onclick="javascript:loading()" type=button value=更新 name=button> -->
																					</TD>
																					<TD><B><FONT id="countdown_num">&nbsp;</FONT></B></TD>
																					<TD align="right">(<B>香港时间:</B>
																						<SPAN id="HKTime"></SPAN>)</TD>
																				</TR>
																			</TBODY></TABLE>
																	</TD>
																</TR>
															</TBODY></TABLE>
													</TD>
												</TR>
											</TBODY></TABLE>
									</TD>
								</TR>
								<TR>
									<TD colSpan="3" height="100%">
										<TABLE class="table_title_line" id="showTable" style="DISPLAY: none" cellSpacing="0" cellPadding="0"
											width="500" border="0">
											<TBODY>
												<TR>
													<TD colSpan="2" height="5"></TD>
												</TR>
												<TR>
													<TD height="30">期数: <B>
															<SPAN id="gNumber">&nbsp;</SPAN></B> &nbsp;&nbsp;<B>开奖日期: </B>
														<SPAN id="gametime">&nbsp;</SPAN>&nbsp;&nbsp;&nbsp;<%# quickinput2 %></TD>
													<TD id="closeM1" align="right">自动刷新 倒数:
														<SPAN id="close_msg1">&nbsp;</SPAN>
														秒</TD>
													<TD id="closeM" align="right"><FONT color="red">即将封盘</FONT> 倒数:
														<SPAN id="close_msg">&nbsp;</SPAN>
														秒</TD>
												</TR>
												<%# kygltable %>
											</TBODY></TABLE>
									</TD>
								</TR>
							</TBODY></TABLE>
					</TD>
				</TR>
			</TBODY></TABLE>
		<input type="hidden" name="gid">
		<SCRIPT>
  time_reload();
 
parent.action.location ="body_var.aspx?rtype=<%# Request.QueryString["rtype"] %>&langx=zh-cn&mtype=<%# Request.QueryString["mtype"] %>&Reload=Y";

		</SCRIPT>
	</BODY>
</HTML>
