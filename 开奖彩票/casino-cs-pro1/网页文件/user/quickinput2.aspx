<%@ Page language="c#" Codebehind="quickinput2.aspx.cs" AutoEventWireup="false" Inherits="newball.user.betting_matches_1x2parlay" codePage="936" %>
<LINK 
href="css/client_LT_game.css" type=text/css rel=stylesheet>
<SCRIPT language=JAVASCRIPT>
if(self == top){location = '/';} 
<%# kyglcontent %>
var gTime='<%# gTime %>';
var singlebet='<%#singlebet%>'.split(',');
var singlegame='<%#singlegame%>'.split(',');
var singlegames='<%#singlegames%>'.split(',');
function onload() {
	if (gTime=='') {
		show_table.style.display = "none";
	}else{	
		show_table.style.display = "block";
	}
}
</SCRIPT>
<!--因error弹回後所下注的总金额值-->
<META content="MSHTML 6.00.3790.279" name=GENERATOR></HEAD>
<BODY oncontextmenu=window.event.returnValue=false leftMargin=0 topMargin=0 onload="onload();">
<TABLE class=table_banner height="100%" cellSpacing=0 cellPadding=0 width=546 
border=0 id="show_table" style="DISPLAY: none">
  <TBODY>
  <TR>
    <TD vAlign=top>
      <TABLE height=96 cellSpacing=0 cellPadding=0 width="96%" align=center 
      border=0>
        <TBODY>
        <TR>
          <TD vAlign=top colSpan=4 height="100%">
            <TABLE cellSpacing=1 cellPadding=0 width=502 border=0>
              <TBODY>
              <TR>
                <TD>
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                    <TBODY>
                    <TR>
                      <TD height=5></TD></TR>
                    <TR>
                      <TD>
                        <TABLE cellSpacing=0 cellPadding=2 width="100%" 
                        align=left border=0>
                          <TBODY>
                          <TR>
                            <TD class=td_02 width="99%" bgColor=#cccccc><FONT 
                              size=2>
                              <MARQUEE class=td_02 scrollDelay=120><SPAN 
                              id=Msg><%# msg%></SPAN></MARQUEE></FONT></TD></TR></TBODY></TABLE></TD></TR>
                    <TR>
                      <TD height=5></TD></TR></TBODY></TABLE></TD></TR></TBODY>
              <TBODY>
              <TR>
                <TD>
                  <TABLE class=table_banner cellSpacing=0 cellPadding=0 
                  width=500 border=0>
                    <TBODY>
                    <TR>
                      <TD>
                        <TABLE class=banner_set cellSpacing=0 cellPadding=0 
                        width=500 border=0>
                          <TBODY>
                          <TR bgColor=#c1d7e5>
                            <TD width=50 height=20>快速下注</TD>
                            <TD width=30><INPUT class=select_cen onclick="location.href='quickinput2.aspx'" type=button value=更新 name=button></TD>
                            <TD align=right>(<B>香港时间:</B>(<%# DateTime.Now %>)</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <FORM name=lt_form action=betting-entry.aspx method=post 
        target=bbnet_mem_order><INPUT type=hidden 
        value='' name=gold> <INPUT type=hidden  value=MultiTema name=action> 
        <TR>
          <TD colSpan=4 height="100%">
            <SCRIPT language=JAVASCRIPT>
<!--
var count_win=false;
//window.setTimeout("self.location='quickinput2.php'", 180000);
function CheckKey(){
	if(event.keyCode == 13) return true;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
}
function ChkSubmit(){
    //设定『确定』键为反白 
	document.all.btnSubmit.disabled = true;

	if (eval(document.all.allgold.innerHTML)<=0 || eval(total_gold.value)<=0)
	{
		alert("请输入下注金额!!");
	    document.all.btnSubmit.disabled = false;
		return false;

	}

        if (!confirm("是否确定下注")){
	    document.all.btnSubmit.disabled = false;
        return false;
        }        

        document.lt_form.submit();
}
function CountGold(gold,type,rtype){
  switch(type) {
  	  case "focus":
  	  	goldvalue = gold.value;
  	  	if (goldvalue=='') goldvalue=0;
  	  	document.all.allgold.innerHTML = eval(document.all.allgold.innerHTML+"-"+goldvalue);
  	  	total_gold.value = document.all.allgold.innerHTML;
  	  	break;
  	  case "blur":
  	  	goldvalue = gold.value;
  	  	if (goldvalue=='') goldvalue=0;
  	  	if (goldvalue>0){
  	  	if ((eval(goldvalue) > <%# ConfigurationSettings.AppSettings["MaxPayOut"] %>)) {gold.focus(); alert("对不起,本期有下注金额最高限制 : <%# ConfigurationSettings.AppSettings["MaxPayOut"] %>!!"); return false;}
 	  	if ((eval(goldvalue) > singlebet[rtype])) {gold.focus(); alert("下注金额不可大於单注限额"+singlebet[rtype]+"!!"); return false;}
  	  	if ((eval(goldvalue+"\+"+singlegames[rtype]) > singlegame[rtype])) {gold.focus();alert("下注金额已超过单号(项)限额"+singlegame[rtype]+"!!"); return false;}
  	  	if ((eval(goldvalue) < <%# ConfigurationSettings.AppSettings["MinBet"] %>)) {gold.focus(); alert("对不起,本期有下注金额最低限制 : <%# ConfigurationSettings.AppSettings["MinBet"] %>!!"); return false;}
 	  	
        }

	  	document.all.allgold.innerHTML = eval(total_gold.value+"\+"+ goldvalue);
		total_gold.value = document.all.allgold.innerHTML;
	  	if (eval(document.all.allgold.innerHTML) > <%# curmoney%>)   {gold.focus(); alert("下注金额不可大於信用额度!!");    return false;}
                /*
    	        if (eval(document.all.allgold.innerHTML) > ){gold.focus(); alert("下注金额不可大於总代理信用额度!!"); return false;}
                */
                break;
  	  case "keyup":
  	  	goldvalue = gold.value;
  	  	if (goldvalue=='') goldvalue=0;
  	  	document.all.allgold.innerHTML = eval(total_gold.value+"\+"+ goldvalue);
  	  	break;
  }
  //alert(goldvalue);
}
//-->
</SCRIPT>

            <TABLE class=table_title_line  cellSpacing=1 cellPadding=0 width=510 
            border=0>
              <TBODY>
              <TR>
                <TD height=5></TD></TR>
              <TR>
                <TD colSpan=4 height=30>期数: <B><%# qishu %></B>&nbsp;&nbsp;<B>开奖日期: 
                  </B><%# kaisai %>&nbsp;&nbsp;&nbsp;<INPUT class=select_cen onclick="parent.body.location='betting-matches.aspx?rtype=SP&mtype=3'" type=button value=切换一般模式 name=quickinput></TD></TR>
              <TR>
                <TD colSpan=4>
                  <TABLE cellSpacing=1 cellPadding=0 width="100%" border=0>
                    <TBODY>
                    <TR class=tr_title_set_cen>
                      <TD colSpan=2>帐户名称</TD>
                      <TD colSpan=2><B><%# Session.Contents["username"].ToString().Trim() %></B></TD>
                      <TD colSpan=3>信用额度</TD>
                      <TD colSpan=2><SPAN_ID=TOTAL_SP><B><%# curmoney %></B></SPAN> 
                      <TD colSpan=3>下注金额</TD>
                      <TD colSpan=3><SPAN id=allgold>0</SPAN></SPAN> </TD>
                    <TR class=tr_title_set_cen>
                      <TD colSpan=2>最低限额</TD>
                      <TD colSpan=2><%# ConfigurationSettings.AppSettings["MinBet"]%></TD>
                      <TD colSpan=3>特别号单注限额</TD>
                      <TD colSpan=2><%# maxz %></TD>
                      <TD colSpan=3>特别号单号限额</TD>
                      <TD colSpan=3><%# maxc %></TD></TR>
                    <TR class=tr_title_set_cen>
                      <TD width=30>号码</TD>
                      <TD width=35>赔率</TD>
                      <TD width=35>金额</TD>
                      <TD width=30>号码</TD>
                      <TD width=35>赔率</TD>
                      <TD width=35>金额</TD>
                      <TD width=30>号码</TD>
                      <TD width=35>赔率</TD>
                      <TD width=35>金额</TD>
                      <TD width=30>号码</TD>
                      <TD width=35>赔率</TD>
                      <TD width=35>金额</TD>
                      <TD width=30>号码</TD>
                      <TD width=35>赔率</TD>
                      <TD width=35>金额</TD></TR>
                  <%# kygltable %>
                   
                   </TBODY></TABLE></TD></TR></TBODY></TABLE>
            <TABLE id="MainTable" cellSpacing=0 cellPadding=0 width="100%" border=0  runat="server">
              <TBODY>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>特单</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','50');" 
                  onkeyup="return CountGold(this,'keyup','50');" 
                  onfocus="CountGold(this,'focus','50');this.value='';" size=5 
                  name=1></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>特双</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','51');" 
                  onkeyup="return CountGold(this,'keyup','51');" 
                  onfocus="CountGold(this,'focus','51');this.value='';" size=5 
                  name=2></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>特大</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','52');" 
                  onkeyup="return CountGold(this,'keyup','52');" 
                  onfocus="CountGold(this,'focus','52');this.value='';" size=5 
                  name=3></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>特小</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','53');" 
                  onkeyup="return CountGold(this,'keyup','53');" 
                  onfocus="CountGold(this,'focus','53');this.value='';" size=5 
                  name=4></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>合单</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','54');" 
                  onkeyup="return CountGold(this,'keyup','54');" 
                  onfocus="CountGold(this,'focus','54');this.value='';" size=5 
                  name=5></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>合双</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','55');" 
                  onkeyup="return CountGold(this,'keyup','55');" 
                  onfocus="CountGold(this,'focus','55');this.value='';" size=5 
                  name=6></TD></TR>
                  <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>红波</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','56');" 
                  onkeyup="return CountGold(this,'keyup','56');" 
                  onfocus="CountGold(this,'focus','56');this.value='';" size=5 
                  name=212></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>绿波</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','57');" 
                  onkeyup="return CountGold(this,'keyup','57');" 
                  onfocus="CountGold(this,'focus','57');this.value='';" size=5 
                  name=213></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>蓝波</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','58');" 
                  onkeyup="return CountGold(this,'keyup','58');" 
                  onfocus="CountGold(this,'focus','58');this.value='';" size=5 
                  name=214></TD></TR></TBODY></TABLE></TD></TR>
            </TBODY></TABLE></TD></TR></TBODY></TABLE>
                  <INPUT type=hidden  value=<%# ballid %> name=ballid> <INPUT type=hidden  value=<%# ballid1%>  name=ballid1> 
                  <INPUT type=hidden  value=<%# curpl %> name=curpl> <INPUT type=hidden  value=<%# curpl1%>  name=curpl1> </FORM><INPUT type=hidden value=0 name=total_gold> 
  </TD></TR></TBODY></TABLE>
<SCRIPT language=JavaScript>
var cd=parent.retime;

function go_back(){

if (cd <= 0) {
  self.location='quickinput2.aspx';
}
if (cd > 0){
  cd--;
  setTimeout("go_back()",1000);
}

}
//go_back();
</SCRIPT>
</BODY></HTML>
