<%@ Page language="c#" Codebehind="lt_sx.aspx.cs" AutoEventWireup="false" Inherits="newball.user.betting_matches_cs" codePage="936"%>
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

function onload() {
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
}
</script>

</head>
<body leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false" onload="onload();">
<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0" class="table_banner">
  <tr> 
    <td valign="top"> 
      <table width="96%" height="96" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="100%" colspan="3" valign="top">
            <TABLE cellSpacing=1 cellPadding=0 width=502 border=0>
              <TBODY>
                <TR> 
                  <TD><table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height=5></td>
  </tr>
  <tr>
    <td><table width=100% border=0 align="left" cellpadding=2 cellspacing=0>
      <tbody>
        <tr>
          <td width=99% class=td_02 bgcolor="#CCCCCC"><font size=2>
            <marquee scrolldelay=120 class="td_02">
            <span id="Msg"><%# msg%></span>
            </marquee>
          </font>
          </td>
        </tr>
      </tbody>
    </table>
    </td>
  </tr>
  <tr>
    <td height=5></td>
  </tr>
</table>      
</TD>
                </TR>
              </TBODY>
                <TR> 
                  <TD>
                    <table class="table_banner" cellSpacing=0 cellPadding=0 width="500" border=0>
                  	<tr>
                  	  <td>
                  	    <TABLE class="banner_set" cellSpacing=0 cellPadding=0 width="500" border=0>
                  	    <TBODY>
                        <TR>
                          <TD width=50 height=20>六肖</TD>
                          <TD width=30><!--<INPUT class=select_cen onclick=javascript:location.reload() type=button value=更新 name=button>--> 
                          </TD>
                          <TD>&nbsp;&nbsp;<B><FONT id=countdown_num>&nbsp;&nbsp;&nbsp;&nbsp;</FONT></B></TD>
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
        <form name="lt_form" method="post" action="betting-entry.aspx" target="bbnet_mem_order" onSubmit="return SubChk(this);" onreset="return reset_num();">
        <input type="hidden" name="action" value="sx">
        <tr>
          <td height="100%" colspan="3">
            <TABLE class="table_title_line"  id="show_table" style="DISPLAY: none"  cellSpacing=0 cellPadding=0 width=500 border=0>
              <TBODY>
                <TR> 
                  <TD height=5 colSpan=2></TD>
                </TR>
                <TR> 
                  <TD height=30>期数: <B><%# qishu %></B>&nbsp;&nbsp;<B>开奖日期: </B><%# kaisai%>&nbsp;&nbsp;&nbsp;</TD>
            	  <TD align="left"></TD>
                </TR>
                <TR>
                  <TD colSpan=2>
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr align="left">
                      <td class="ball_td2" width="60" align="center">类别</td>
					  <td class="ball_td2" width="60" align="center"><input type="radio" name="rtype" value="230">中</td>
					  <td class="ball_td2" width="60" align="center"><input type="radio" name="rtype" value="231">不中</td>
					  <td class="ball_td2" width="60" align="center">赔率</td>
					  <td class="ball_td2" width="60" align="center"><font color=#ffoooo><B><%# kygltable%></B></FONT></td>
					  <td wduth=200>&nbsp;</td>
                    </tr>
                  </table>
                  </TD>
                </TR>
                <TR> 
                  <TD colSpan=2> <TABLE width="100%" border="0" cellspacing="1" cellpadding="0">
                      <TBODY>
					  <tr class="tr_title_set_cen">
          				 <td width="50">六肖</td>
          				 <td width="130">号码</td>
          				 <td>勾选</td>
          				 <td width="50">六肖</td>
          				 <td width="130">号码</td>
          				 <td>勾选</td>
          			   </tr>

          			   <tr>
          				 <td class="tr_title_set_cen">鼠</td>
          				 <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[0].ToString() %></td>
          				 <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="0" onClick="SubChkBox(this,this)"></td>
          				 <td class="tr_title_set_cen">牛</td>
          				 <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[1].ToString() %></td>
          				 <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="1" onClick="SubChkBox(this,this)"></td>
          			   </tr>
          			   <tr>
          			     <td class="tr_title_set_cen">虎</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[2].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="2" onClick="SubChkBox(this,this)"></td>
          			     <td class="tr_title_set_cen">兔</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[3].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="3" onClick="SubChkBox(this,this)"></td>
          			   </tr>
          			   <tr>
          			     <td class="tr_title_set_cen">龙</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[4].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="4" onClick="SubChkBox(this,this)"></td>
          			     <td class="tr_title_set_cen">蛇</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[5].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="5" onClick="SubChkBox(this,this)"></td>
          			   </tr>
          			   <tr>
          			     <td class="tr_title_set_cen">马</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[6].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="6" onClick="SubChkBox(this,this)"></td>
          			     <td class="tr_title_set_cen">羊</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[7].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="7" onClick="SubChkBox(this,this)"></td>
          			   </tr>
          			   <tr>
          			     <td class="tr_title_set_cen">猴</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[8].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="8" onClick="SubChkBox(this,this)"></td>
          			     <td class="tr_title_set_cen">鸡</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[9].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="9" onClick="SubChkBox(this,this)"></td>
          			   </tr>
          			   <tr>
          			     <td class="tr_title_set_cen">狗</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[10].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="10" onClick="SubChkBox(this,this)"></td>
          			     <td class="tr_title_set_cen">猪</td>
          			     <td class="ball_td2"><%# System.Configuration.ConfigurationSettings.AppSettings["twelveNum"].Split('^')[11].ToString() %></td>
          			     <td class="list_cen"><input type="checkbox" name="lt_sx[]" value="11" onClick="SubChkBox(this,this)"></td>
          			   </tr>
                      </TBODY>
                    </TABLE>
                  </TD>
                </TR>
                <tr>
				    <td height="10" colspan="2">&nbsp;</td>
				</tr>
                <TR> 
                  <TD colSpan=2>
  					 <table width="100%" border="0" cellspacing="1" cellpadding="0"> <!--id="game_table1">-->
  					  <tr class="tr_title_set_cen">  					    
  					  	<td width="100%" align="center"><input type="submit" value="送出"><input type="reset" value="取消" onmouseup="return reset();"></td>
  					  </tr>
  					 </table>
  				  </TD>
  				</tr>  
              </TBODY>
            </TABLE></td>
        </tr>
        </form>
              </table>
    </td>
  </tr>
</table>
</body>
</html>
