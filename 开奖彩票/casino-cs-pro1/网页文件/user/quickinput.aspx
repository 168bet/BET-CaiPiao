<%@ Page language="c#" Codebehind="quickinput.aspx.cs" AutoEventWireup="false" Inherits="newball.user.quickinput" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>quick input</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link href="css/mem_order.css" type=text/css rel=stylesheet>
<LINK href="css/client_LT_game.css" type=text/css rel=stylesheet>
<SCRIPT language=JAVASCRIPT>
if(self == top){location = '/';} 
</SCRIPT>

<SCRIPT language=Javascript>
<!--
var count_win=false;
window.setTimeout("self.location='betting-entry.aspx'", 180000);
var singleGame='<%# singleGame%>'.split(',');
function CheckKey(){
	if(event.keyCode == 13) return true;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("下注金额仅能输入数字!!"); return false;}
}

function SubChk(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		alert("请输入下注金额!!");
		return false;
	}
	if(isNaN(document.all.gold.value) == true){
		document.all.gold.focus();
		alert("下注金额仅能输入数字!!");
		return false;
	}
	if(eval(document.all.gold.value) < <%# MinBet%>){
		document.all.gold.focus();
		alert("下注金额不可小於最低下注金额!!");
		return false;
	}
	if(eval(document.all.gold.value) > <%# maxc%>){
		document.all.gold.focus();
		alert("对不起,本期有最高下注限额?: <%# maxc%> !!");
		return false;
	}
	if(eval(document.all.gold.value) > <%# maxz%>){
		document.all.gold.focus();
		alert("下注金额不可大於单注限额!!");
		return false;
	}

	if(eval(document.all.gold.value) > <%# curmoney%>){
		document.all.gold.focus();
		alert("下注金额不可大於信用额度!!");
		return false;
	} 

	if(eval(document.all.gold.value) > 769960){
		document.all.gold.focus();
		alert("下注金额不可大於总代理信用额度!!");
		return false;
	}

}

function ChkSumbit(){
	document.all.btnCancel.disabled = true;
	document.all.btnSubmit.disabled = true;
	

	if (BallsSUM()==false) {
		document.all.btnCancel.disabled = false;
		document.all.btnSubmit.disabled = false;
		return;
	}
	
	if (quickForm.wagerstext.value!='') {
		document.quickForm.submit();
	}else{
		document.all.btnCancel.disabled = false;
		document.all.btnSubmit.disabled = false;
		return false;
	}


}
function BallsSUM() {

	var wagers = '';
	var wlist = '';
	var total=0;                

	if (wagers_list.length==0)	{
		alert("请先下注!!");
		return false;
	}
		
        if (!confirm("是否确定下注"))
          return false;  

	for(i=0; i<wagers_list.length; i++)	{
		wagers += wagers_list.options[i].value+"-";
		wlist = wagers_list.options[i].value.split("+");
		total += eval(wlist[1]);
	}
	/*
	if((40+total) > 20000){
		document.all.gold.focus();
		alert("本期累计下注共: 40\n下注金额已超过单期限额!!");
		return false;
	}
 */
	if (total > <%# curmoney%>) {
		alert("下注金额不可大於信用额度!!");
		return false;
	}
	
	if (total > 769960) {
		alert("下注金额不可大於总代理信用额度!!");
		return false;
	}
              
	
	quickForm.wagerstext.value = wagers;
}

var ball_color = Array(0,0,1,1,2,2,0,0,1,1,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,1,1,2,2,0,0,1,1,2);
var bcolor = Array('red','blue','green');
var null_col='#C1D7E5';
var over_col='#ffffff';
var click_col='#ffff00';

function showTable()
{
	show_table = document.getElementById('showTable');
	if (typeof(parent.body.sOdds)!='undefined' || parent.body.wtype =='<%# rtype %>'){
		var odds = parent.body.sOdds;
	}

	with(show_table)
	{
		while(rows.length > 1)
			deleteRow(rows.length-1);
			
		for(i=1; i<=10; i++)
		{
			newTR = insertRow();
			newTR.className = 'list_cen';
			with(newTR)
			{
				for (j=0; j<=4; j++)
				{
					var nums = 10*j+i;
					num_str = '';
					
					if (nums < 10) {
						num_str = '0'+nums.toString();
					}else{
						num_str = nums.toString();
					}
					
					newTD = insertCell();
					newTD.className = 'ball_td';
					if (nums==50) {
						newTD.innerHTML = "&nbsp;";
					}else{
						newTD.id = 'Ball'+num_str;
						if (odds[nums-1]=='') {
							newTD.innerHTML = "";
						}else{
							newTD.innerHTML = "<span style='cursor: hand;' onmouseover=\"light_bar(Ball"+num_str+",'ovr')\" onmouseout=\"light_bar(Ball"+num_str+",'out')\" onmousedown=\"light_bar(Ball"+num_str+",'clk')\"><font size=2 color='"+bcolor[ball_color[nums-1]]+"'>"+num_str+"</font></span>";
						}
					}
				}
			}
		}
	}	
}

function light_bar(st,act){
  switch(act){
   case 'ovr':
     if( st.style.backgroundColor==null_col || st.style.backgroundColor=='' )  st.style.backgroundColor=over_col;
     break;
   
   case 'out':
     if( st.style.backgroundColor==over_col )  st.style.backgroundColor=null_col;
     break;
    
   case 'clk':
     if( st.style.backgroundColor!=click_col ) st.style.backgroundColor=click_col;
     else st.style.backgroundColor=over_col;
     break;
  }
}


function sel_col_ball(color)
{
	var c;
	switch(color) {
		case 'blue':
			c = 1;
			break;
		case 'red':
			c = 0;
			break;
		case 'green':
			c = 2;
			break;
		case 'cancel':
			c = 4;
			break;
		case 'all':
			c = 5;
			break;
		default:
			return;
			break;
	}
	
	for(i=0; i<49 ;i++)
	{
		num_str = '';
		num_str = num_format(i+1);
			
		if (c==4)
		{
			 if (eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+null_col+"'");
			continue;
		}
		
	
		if ((ball_color[i] == c && c != 4) || c==5)
		{
			if (eval("Ball"+num_str+".style.backgroundColor != '"+click_col+"'")){
				if (eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+click_col+"'");
			}else{
				if (eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+null_col+"'");
			}
		}
	}
}

function sel_oe_ball(oe)
{
	var e = '';
	switch(oe) {
		case 'odd':
			e = 1; 
			break;
		case 'even':
			e = 0;
			break;
		default:
			return;
	}
	
	for(i=0; i<49 ;i++)
	{
		if ((i+1) % 2 == e)
		{
			num_str = '';
			num_str = num_format(i+1);
			
			if (eval("Ball"+num_str+".style.backgroundColor != '"+click_col+"'")) {
				if(eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+click_col+"'");
			}else{
				if(eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+null_col+"'");
			}
		}
	}
}

function sel_sum_ball(oe)
{
	var e = '';
	var l_num = 0;
	var r_num = 0;
	var k = l_num + r_num;
	switch(oe) {
		case 'odd':
			e = 1; 
			break;
		case 'even':
			e = 0;
			break;
		default:
			return;
	}
	
	for(i=0; i<49 ;i++)
	{
	    num_str = '';
	    num_str = num_format(i+1);
	    l_num = eval(num_str.substr(0,1));
	    r_num = eval(num_str.substr(1,1));
	    k = l_num + r_num;
	    //alert (l_num + '+' + r_num +'=' + k);
	    if (k % 2 == e)
		{
			num_str = '';
			num_str = num_format(i+1);
			
			
			if (eval("Ball"+num_str+".style.backgroundColor != '"+click_col+"'")) {
				if(eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+click_col+"'");
			}else{
				if(eval("Ball"+num_str+".innerHTML != ''")) eval("Ball"+num_str+".style.backgroundColor='"+null_col+"'");
			}
		}
	}
}

function num_format(numb)
{
	if (numb < 10) {
		return '0'+numb.toString();
	}else{
		return numb.toString();
	}
}

function CheckOK()
{
	if (SubChk() == false) return;
	
	var CStr = seled_ball().split(",");
	
	if (CStr=='') {
		alert("请选择下注球号!!");
		return;
	}

	for (i=0;i<CStr.length-1;i++){
		if (w_add('<%# rtype %>',CStr[i],get_odds(eval(CStr[i])),gold.value) == false) return;
	}
	
	sel_col_ball('cancel');
	gold.value='';
	document.all.ok.disabled = true;
}

function seled_ball()
{
	var Numbers = '';

	for (j=0; j<=48; j++)
	{
		var nums = j+1;
		num_str = '';
					
		if (nums < 10) {
			num_str = '0'+nums.toString();
		}else{
			num_str = nums.toString();
		}
		
		if(eval("Ball"+num_str+".style.backgroundColor == '"+click_col+"'"))
		{
			Numbers += num_str+",";
		}
	}
	
	return Numbers;
}

function w_add(wtype,num,odds,gold)
{
	switch(wtype)
	{
		case 'SP':
			wtype_text = '特别号 ';
			break;
		case 'NA':
			wtype_text = '正码 ';
			break;
		default:
			wtype_text = 'Error';
			break;
	}
	if (eval(gold)+eval(singleGame[eval(num)])><%# maxc%>){
		alert(num+"号球已经大于单号限额<%# maxc%>!!");
		return false;
	}
	
	
	if (typeof(odds) == "undefined") return false;
	if (odds=='') {
		alert(num+"号球已经封牌!!");
		return false;
	}
	
	if(wtype_text != 'Error' && typeof(odds) != "undefined") {
		var wtext = wtype_text+num+','+odds+',$'+gold;
		var wvalue = num+':'+odds+'\+'+gold;
		var wadd = new Option(wtext,wvalue);
		wagers_list.add(wadd);
	}
}

function get_odds(num)
{
	if (typeof(parent.body.sOdds)=='undefined' || parent.body.wtype!='<%# rtype %>')
	{
		alert('请选择下注类别!!');
		location.href = "betting-entry.aspx";
	}else{
		var nums_odds = parent.body.sOdds;
		return nums_odds[num-1];
	}
}
function clearlist()
{
	for (i=0;i<wagers_list.length;i++) {
		wagers_list.remove(i);
		i--;
	}
	document.all.ok.disabled = false;
}
//-->
</SCRIPT>

<META content="MSHTML 6.00.3790.279" name=GENERATOR></HEAD>
<BODY oncontextmenu=window.event.returnValue=false bgColor=#e5eaee leftMargin=0 
topMargin=0 onload=showTable()>
<TABLE height="100%" cellSpacing=0 cellPadding=0 
background=images/order_bk.gif border=0>
  <TBODY>
  <TR>
    <TD vAlign=top height=22><IMG height=22 
      src="images/order_ph11.gif" width=241></TD></TR>
  <TR>
    <TD class=m-title background=images/order_ph21.jpg height=36>六合彩 
      <%# pltype %> 下注单</TD></TR>
  <TR>
    <TD vAlign=top height=30><IMG height=30 
      src="images/order_ph31.gif" width=241></TD></TR>
  <TR>
    <TD vAlign=top background=images/order_ph41.gif height=100>
      <TABLE cellSpacing=0 cellPadding=0 width=190 align=center border=0>
        <TBODY>
        <TR>
          <TD><BR>
            <TABLE class=table_banner height=15 cellSpacing=0 cellPadding=0 
            width=180 align=center border=0>
              <TBODY>
              <TR>
                <TD vAlign=top>
                  <TABLE class=table_title_line id=showTable cellSpacing=1 
                  cellPadding=0 width="100%" border=0>
                    <TBODY></TBODY></TABLE></TD></TR>
              <TR>
                <TD class=list_tr_cen vAlign=top><A 
                  href="javascript:sel_col_ball('red')"><FONT 
                  color=red>红波</FONT></A>&nbsp; <A 
                  href="javascript:sel_col_ball('blue')"><FONT 
                  color=blue>蓝波</FONT></A>&nbsp; <A 
                  href="javascript:sel_col_ball('green')"><FONT 
                  color=green>绿波</FONT></A>&nbsp; <A 
                  href="javascript:sel_oe_ball('odd')">单</A>&nbsp; <A 
                  href="javascript:sel_oe_ball('even')">双</A><BR><A 
                  href="javascript:sel_sum_ball('odd')">合数单</A>&nbsp; <A 
                  href="javascript:sel_sum_ball('even')">合数双</A>&nbsp; <A 
                  href="javascript:sel_col_ball('all')">不用</A>&nbsp;<A 
                  href="javascript:sel_col_ball('cancel')">取消</A>&nbsp; 
              </TD></TR></TBODY></TABLE><BR>
            <TABLE class=table_02 height=150 cellSpacing=0 cellPadding=0 
            width=150 align=center border=0>
              <TBODY>
              <TR>
                <TD class=td_fail><FONT color=#ff0000>
                  <TABLE cellSpacing=0 cellPadding=0 width="97%" border=0>
                    <TBODY>
                    <TR>
                      <TD>下注金额: <INPUT onkeypress="return CheckKey()" id=gold 
                        maxLength=8 size=7 name=gold> <INPUT class=select_cen onclick=CheckOK() type=button value=OK name=ok> 
                      </TD></TR>
                    <TR>
                      <TD>最低限额: <%# MinBet%></TD></TR>
                    <TR>
                      <TD>单注限额: <%# maxz%> </TD></TR>
                    <TR>
                      <TD>
                        <P>单号限额: <%# maxc%> </P></TD></TR>
                    <TR>
                      <TD>&nbsp; </TD></TR>
                    <TR>
                      <TD><SELECT style="WIDTH: 150px" size=8 
                        name=wagers_list></SELECT></TD></TR>
                    <TR align=middle>
                      <TD><INPUT class=sumbit_cen onclick=clearlist() type=button value=重设 name=clear> 
                        &nbsp; <INPUT class=sumbit_cen onclick="self.location='betting-entry.aspx'" type=button value=取消 name=btnCancel> 
                        &nbsp; <INPUT class=sumbit_cen onclick=ChkSumbit(); type=button value=确定 name=btnSubmit> 
                      </TD></TR></TBODY></TABLE></FONT></TD></TR></TBODY></TABLE></TD></TR></TD></TBODY></TABLE>
  <TR>
    <TD vAlign=top height=11><IMG height=11 
      src="images/order_ph51.gif" width=241></TD></TR>
  <TR>
    <TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>
<FORM name=quickForm action=betting-entry.aspx method=post><INPUT type=hidden 
value=quickForm name=action> <INPUT type=hidden 
name=wagerstext> <INPUT type=hidden 
name=rtype value=<%# rtype %>></FORM></BODY></HTML>
