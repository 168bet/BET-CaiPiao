<%@ Page language="c#" Codebehind="quickinput_ev.aspx.cs" AutoEventWireup="false" Inherits="newball.user.quickinput_ev" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>body_lotto</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312"><LINK 
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
<!--��error����������ע���ܽ��ֵ-->
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
                            <TD width=50 height=20>������ע</TD>
                            <TD width=30><INPUT class=select_cen onclick="location.href='quickinput_ev.aspx'" type=button value=���� name=button></TD>
                            <TD align=right>(<B>���ʱ��:</B><%# DateTime.Now %>)</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <FORM name=lt_form action=betting-entry.aspx method=post 
        target=bbnet_mem_order onsubmit="document.lt_form.reset();">
         <INPUT type=hidden  value=<%# ballid %> name=ballid> 
    <INPUT type=hidden  value=<%# curpl %> name=curpl>
        <TR>
          <TD colSpan=4 height="100%">
            <SCRIPT language=JAVASCRIPT>
<!--
var count_win=false;

function CheckKey(){
	if(event.keyCode == 13) return true;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("��ע��������������!!"); return false;}
}
function ChkSubmit(){
    //�趨��ȷ������Ϊ���� 
	document.all.btnSubmit.disabled = true;

	if (eval(document.all.allgold.innerHTML)<=0 || eval(total_gold.value)<=0)
	{
		alert("��������ע���!!");
	    document.all.btnSubmit.disabled = false;
		return false;

	}

        if (!confirm("�Ƿ�ȷ����ע")){
	    document.all.btnSubmit.disabled = false;
        return true;
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
  	  	if ((eval(goldvalue) > <%# ConfigurationSettings.AppSettings["MaxPayOut"] %>)) {gold.focus(); alert("�Բ���,��������ע���������� : <%# ConfigurationSettings.AppSettings["MaxPayOut"] %>!!"); return false;}
 	  	if ((eval(goldvalue) > singlebet[rtype])) {gold.focus(); alert("��ע���ɴ�춵�ע�޶�"+singlebet[rtype]+"!!"); return false;}
  	  	if ((eval(goldvalue+"\+"+singlegames[rtype]) > singlegame[rtype])) {gold.focus();alert("��ע����ѳ�������(��)�޶�"+singlegame[rtype]+"!!"); return false;}
       if ((eval(goldvalue) < <%# ConfigurationSettings.AppSettings["MinBet"] %>)) {gold.focus(); alert("�Բ���,��������ע���������� : <%# ConfigurationSettings.AppSettings["MinBet"] %>!!"); return false;}
 	  	
        }
	  	document.all.allgold.innerHTML = eval(total_gold.value+"\+"+ goldvalue);
		total_gold.value = document.all.allgold.innerHTML;
	  	if (eval(document.all.allgold.innerHTML) > <%# curmoney%>)   {gold.focus(); alert("��ע���ɴ�����ö��!!");    return false;}
                /*
    	        if (eval(document.all.allgold.innerHTML) > ){gold.focus(); alert("��ע���ɴ���ܴ������ö��!!"); return false;}
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
                <TD colSpan=4 height=30>����: <B><%# qishu %></B>&nbsp;&nbsp;<B>��������: 
                  </B><%# kaisai %>&nbsp;&nbsp;&nbsp;<INPUT class=select_cen onclick="parent.body.location='betting-matches.aspx?rtype=EVEN&mtype=3'" type=button value=�л�һ��ģʽ name=quickinput></TD></TR>
              <TR>
                <TD colSpan=4>
                  <TABLE cellSpacing=1 cellPadding=0 width=510 border=0>
                    <TBODY>
                    <TR class=tr_title_set_cen>
                      <TD colSpan=2>�ʻ�����</TD>
                      <TD colSpan=2><B><%# Session.Contents["username"].ToString().Trim() %></B></TD>
                      <TD colSpan=3>���ö��</TD>
                      <TD colSpan=2><SPAN_ID=TOTAL_SP><B><%# curmoney %></B></SPAN> 
                      <TD colSpan=3>��ע���</TD>
                      <TD colSpan=3><SPAN id=allgold>0</SPAN></SPAN> 
                    </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
            <TABLE cellSpacing=1 cellPadding=0 width=510 border=0 id="MainTable" runat="server">
              <TBODY>
              <TR class=tr_title_set_cen>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>�ص�</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','1');" 
                  onkeyup="return CountGold(this,'keyup','1');" 
                  onfocus="CountGold(this,'focus','1');this.value='';" size=5 
                  name=dsdx1></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','2');" 
                  onkeyup="return CountGold(this,'keyup','2');" 
                  onfocus="CountGold(this,'focus','2');this.value='';" size=5 
                  name=dsdx2></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>�ش�</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','3');" 
                  onkeyup="return CountGold(this,'keyup','3');" 
                  onfocus="CountGold(this,'focus','3');this.value='';" size=5 
                  name=dsdx3></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','4');" 
                  onkeyup="return CountGold(this,'keyup','4');" 
                  onfocus="CountGold(this,'focus','4');this.value='';" size=5 
                  name=dsdx4></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>�ϵ�</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','5');" 
                  onkeyup="return CountGold(this,'keyup','5');" 
                  onfocus="CountGold(this,'focus','5');this.value='';" size=5 
                  name=dsdx5></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','6');" 
                  onkeyup="return CountGold(this,'keyup','6');" 
                  onfocus="CountGold(this,'focus','6');this.value='';" size=5 
                  name=dsdx6></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>�ܵ�</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','7');" 
                  onkeyup="return CountGold(this,'keyup','7');" 
                  onfocus="CountGold(this,'focus','7');this.value='';" size=5 
                  name=dsdx7></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','8');" 
                  onkeyup="return CountGold(this,'keyup','8');" 
                  onfocus="CountGold(this,'focus','8');this.value='';" size=5 
                  name=dsdx8></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>�ܴ�</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','9');" 
                  onkeyup="return CountGold(this,'keyup','9');" 
                  onfocus="CountGold(this,'focus','9');this.value='';" size=5 
                  name=dsdx9></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','10');" 
                  onkeyup="return CountGold(this,'keyup','10');" 
                  onfocus="CountGold(this,'focus','10');this.value='';" size=5 
                  name=dsdx10></TD></TR></TBODY></TABLE>
            <TABLE class=table_title_line cellSpacing=1 cellPadding=0 width=510 border=0 id="MainTable1" runat="server" >
              <TBODY>
              <TR class=tr_title_set_cen>
                <TD colSpan=3>����һ</TD>
                <TD colSpan=3>�����</TD>
                <TD colSpan=3>������</TD>
                <TD colSpan=3>������</TD></TR>
              <TR class=tr_title_set_cen>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','11');" 
                  onkeyup="return CountGold(this,'keyup','11');" 
                  onfocus="CountGold(this,'focus','11');this.value='';" size=5 
                  name=dsdx11></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','12');" 
                  onkeyup="return CountGold(this,'keyup','12');" 
                  onfocus="CountGold(this,'focus','12');this.value='';" size=5 
                  name=dsdx12></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','13');" 
                  onkeyup="return CountGold(this,'keyup','13');" 
                  onfocus="CountGold(this,'focus','13');this.value='';" size=5 
                  name=dsdx13></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','14');" 
                  onkeyup="return CountGold(this,'keyup','14');" 
                  onfocus="CountGold(this,'focus','14');this.value='';" size=5 
                  name=dsdx14></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','17');" 
                  onkeyup="return CountGold(this,'keyup','17');" 
                  onfocus="CountGold(this,'focus','17');this.value='';" size=5 
                  name=dsdx17></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','18');" 
                  onkeyup="return CountGold(this,'keyup','18');" 
                  onfocus="CountGold(this,'focus','18');this.value='';" size=5 
                  name=dsdx18></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','19');" 
                  onkeyup="return CountGold(this,'keyup','19');" 
                  onfocus="CountGold(this,'focus','19');this.value='';" size=5 
                  name=dsdx19></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','20');" 
                  onkeyup="return CountGold(this,'keyup','20');" 
                  onfocus="CountGold(this,'focus','20');this.value='';" size=5 
                  name=dsdx20></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','23');" 
                  onkeyup="return CountGold(this,'keyup','23');" 
                  onfocus="CountGold(this,'focus','23');this.value='';" size=5 
                  name=dsdx23></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','24');" 
                  onkeyup="return CountGold(this,'keyup','24');" 
                  onfocus="CountGold(this,'focus','24');this.value='';" size=5 
                  name=dsdx24></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','25');" 
                  onkeyup="return CountGold(this,'keyup','25');" 
                  onfocus="CountGold(this,'focus','25');this.value='';" size=5 
                  name=dsdx25></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','26');" 
                  onkeyup="return CountGold(this,'keyup','26');" 
                  onfocus="CountGold(this,'focus','26');this.value='';" size=5 
                  name=dsdx26></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','29');" 
                  onkeyup="return CountGold(this,'keyup','29');" 
                  onfocus="CountGold(this,'focus','29');this.value='';" size=5 
                  name=dsdx29></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','30');" 
                  onkeyup="return CountGold(this,'keyup','30');" 
                  onfocus="CountGold(this,'focus','30');this.value='';" size=5 
                  name=dsdx30></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','31');" 
                  onkeyup="return CountGold(this,'keyup','31');" 
                  onfocus="CountGold(this,'focus','31');this.value='';" size=5 
                  name=dsdx31></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','32');" 
                  onkeyup="return CountGold(this,'keyup','32');" 
                  onfocus="CountGold(this,'focus','32');this.value='';" size=5 
                  name=dsdx32></TD></TR>
            
              <TR class=tr_title_set_cen>
                <TD colSpan=3>������</TD>
                <TD colSpan=3>������</TD></TR>
              <TR class=tr_title_set_cen>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD>
                <TD width=30>����</TD>
                <TD width=35>����</TD>
                <TD width=35>���</TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','15');" 
                  onkeyup="return CountGold(this,'keyup','15');" 
                  onfocus="CountGold(this,'focus','15');this.value='';" size=5 
                  name=dsdx15></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','16');" 
                  onkeyup="return CountGold(this,'keyup','16');" 
                  onfocus="CountGold(this,'focus','16');this.value='';" size=5 
                  name=dsdx16></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','21');" 
                  onkeyup="return CountGold(this,'keyup','21');" 
                  onfocus="CountGold(this,'focus','21');this.value='';" size=5 
                  name=dsdx21></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>˫</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','22');" 
                  onkeyup="return CountGold(this,'keyup','22');" 
                  onfocus="CountGold(this,'focus','22');this.value='';" size=5 
                  name=dsdx22></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','27');" 
                  onkeyup="return CountGold(this,'keyup','27');" 
                  onfocus="CountGold(this,'focus','27');this.value='';" size=5 
                  name=dsdx27></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>��</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','28');" 
                  onkeyup="return CountGold(this,'keyup','28');" 
                  onfocus="CountGold(this,'focus','28');this.value='';" size=5 
                  name=dsdx28></TD></TR>
              <TR>
                <TD align=middle width=35 bgColor=#c1d7e5>С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','33');" 
                  onkeyup="return CountGold(this,'keyup','33');" 
                  onfocus="CountGold(this,'focus','33');this.value='';" size=5 
                  name=dsdx33></TD>
                <TD align=middle width=35 bgColor=#c1d7e5>С</TD>
                <TD align=middle width=40><FONT 
                  style="FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #cc0000"></FONT></TD>
                <TD align=middle><INPUT onkeypress="return CheckKey();" 
                  onblur="return CountGold(this,'blur','34');" 
                  onkeyup="return CountGold(this,'keyup','34');" 
                  onfocus="CountGold(this,'focus','34');this.value='';" size=5 
                  name=dsdx34></TD></TR></TBODY></TABLE></TR></TBODY></TABLE>
  <TR>
    <TD align=middle colSpan=3><INPUT onclick="return ChkSubmit(); document.lt_form.reset();" type=button value=ȷ�� name=btnSubmit> 
<INPUT onclick="location.href='quickinput_ev.aspx'" type=reset value=���� name=btnReset> 
    </TD></TR></TD></TR></TBODY></TABLE><INPUT type=hidden  value=even name=action>
    </FORM><INPUT type=hidden value=0 name=total_gold> 
</TD></TR></TABLE>
<SCRIPT language=JavaScript>
var cd=parent.retime;

function go_back(){

if (cd <= 0) {
  self.location='quickinput_ev.aspx';
}
if (cd > 0){
  cd--;
  setTimeout("go_back()",1000);
}

}
//go_back();
</SCRIPT>
</BODY></HTML>