<%@ Page language="c#" Codebehind="lt_nap.aspx.cs" AutoEventWireup="false" Inherits="newball.user.betting_matches_ahparlay" codePage="936"%>

<html>
<head>
<title>body_lotto</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="css/client_LT_game.css" type="text/css">
<script language="javascript">
if(self == top) location = '/';


var mess1 =  '请先下注!';
var mess2 =  '请选择二组以上玩法，若只要单一下注请前往正码1-6投注!' ;
var gTime='<%# gTime %>';

function SubChk(obj) {
	var checkCount = 0;
	var checknum = obj.elements.length;
	
	for( i=0; i < checknum; i++ ) {
		if (obj.elements[i].checked) {
			checkCount ++;
		}
	}
	
	if (checkCount == 0)
	{
		alert(mess1);
		return false;
	}
	if (checkCount == 1)
	{
		alert(mess2);
		return false;
	}
	if (checkCount >= 2)
	{
		return true;
		//alert(checkCount);
		//document.lt_form.submit();
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
<body leftmargin="0" topmargin="0" oncontextmenu="window.event.returnValue=false" onload="onload();">
<table width="546" height="100%" border="0" cellpadding="0" cellspacing="0" class="table_banner">
  <tr> 
    <td valign="top" valign="top"> 
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
              <TBODY>
                <TR> 
                  <TD>
                  <table class="table_banner" cellSpacing=0 cellPadding=0 width="500" border=0>
                  	<tr>
                  	  <td>
                  	    <TABLE class="banner_set" cellSpacing=0 cellPadding=0 width="500" border=0>
                  	    <TBODY>
                        <TR>
                          <TD width=50 height=20>正码过关</TD>
                          <TD width=30><!--<INPUT class=select_cen onclick=javascript:location.reload() type=button value=更新 name=button>-->&nbsp;
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
              </TBODY>
            </TABLE>
          </td>
        </tr>
        <form name="lt_form_100" method="post" action="betting-entry.aspx" target="bbnet_mem_order" onSubmit="return SubChk(this);">
        <input type="hidden" name="action" value="nap">
        <tr>
          <td height="100%" colspan="3">
            <TABLE class="table_title_line" id="show_table" style="DISPLAY: none" cellSpacing=0 cellPadding=0 width=500 border=0>
              <TBODY>
                <TR> 
                  <TD height=5></TD>
                </TR>
                <TR> 
                  <TD height=30 colSpan=2>期数: <B><%# qishu %></B> &nbsp;&nbsp;<B>开奖日期: </B><%# kaisai%>&nbsp;&nbsp;&nbsp;</TD>
                </TR>
                <TR> 
                  <TD>
                     <table width="100%" border="0"   cellspacing="1" cellpadding="0">
                       <tr class="tr_title_set_cen">
                         <td align="center" valign="middle">号码</td>
                         <td colspan="3">赔率</td>
                       </tr>
                       <%# kygltable %>
                                             
                        
                        <tr>
                         <td colspan="4" align="center">                         
                           <input type="SUBMIT" name="TEAM_SELETC" value="确认" class="select_cen">
                           &nbsp;&nbsp;&nbsp;
                           <input type="RESET" name="cancel" value="重设" class="select_cen"></td>
                       </tr>
                     </table>
                  </td>
                </tr>
                <TR> 
                  <TD>
                  </TD>
                </TR>
              </TBODY>
            </TABLE></td>
        </tr>
        </form>
              </table>
    </td>
  </tr>
</table>
<script language="JavaScript">
var cd=parent.retime;

function go_back(){

// countdown_num.innerHTML=cd;

if (cd <= 0) {
  self.location='lt_nap.aspx';
}
if (cd > 0){
  cd--;
  setTimeout("go_back()",1000);
}

}
//go_back();
</script>
</body>
</html>
