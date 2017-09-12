<%@ Page language="c#" Codebehind="randomball.aspx.cs" AutoEventWireup="false" Inherits="newball.user.randomball" codePage="936" %>
<html>
<head>
<title>即时摇珠</title>
<script>
	var aryRB=new Array();
	var intTimer=0;
	var col = new Array('','r','r','b','b','g','g','r','r','b','b','g','r','r','b','b','g','g','r','r','b','g','g','r','r','b','b','g','g','r','r','b','g','g','r','r','b','b','g','g','r','b','b','g','g','r','r','b','b','g');
    var img = new Array();
    img['g'] = 'g.gif';
    img['r'] = 'r.gif';
    img['b'] = 'b.gif';
	function proBallRandom(){
		var i;
		for(i=0;i<10;i++){
		   aryRB[i] = Math.ceil(Math.random()*100%49);
		}
	}
	function proBallTimer(){
	    intTimer++;
	    if(intTimer == 4){
	        proBallRandom();
	        proBallShow();
	        intTimer = 0;
	    }
		setTimeout("proBallTimer()",1);
	}
	
	var proBSj;
	var intTmp;
	var x = '0';
	function proBallShow(){
		for(proBSj=x;proBSj<7;proBSj++){
			intTmp=aryRB.pop();
			bal[proBSj].innerText=intTmp;
		}
	}
	function stop(ball,num,lnum){
	    if(lnum != document.all['ltnum'].innerHTML){
	        document.all['ltnum'].innerHTML = lnum
	    }
	    if(x < num){
	        x = num;
		    proBallShow();
		    for(i=0;i< num; i++){	  
		  
		        bal[i].background = 'images/ball/'+img[col[Math.round(ball[i])]];	    
			    bal[i].innerText = ball[i];
		    }
        }
	}
</script>
<style>
.unnamed1 {
	background-repeat: no-repeat;
	background-position: center center;
}
TR { FONT-SIZE: 12px; LINE-HEIGHT: 17px }
td {  font-family: "Arial"; font-size: 12px}
body { background-color: #FFFFFF; }
.tr_title_set_cen1 { border: none; background-color: #165B94; padding-right: 1px; padding-left: 1px; color: #FFFC00; font-size: 10px; text-align: center; padding-top: 3px; padding-bottom: 1px}
.tr_title_set_cen2 { border: none; background-color: #85BAE4; padding-right: 1px; padding-left: 1px; color: #000000; font-size: 10px; text-align: center; padding-top: 3px; padding-bottom: 1px}
.table_banner { background-color: #E5EAEE; border: 1px #CCCCCC solid; padding-top: 2px; padding-right: 2px; padding-bottom: 2px; padding-left: 2px }
.banner_set { border: none; background-color: #C1D7E5; padding-top: 1px; padding-right: 5px; padding-bottom: 1px; padding-left: 5px}

</style>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<body onLoad="proBallTimer();" oncontextmenu="window.event.returnValue=false" style="overflow:hidden;" >
<table width="420" border="0" cellpadding="0" cellspacing="1" align="center" height="300">
  <tr >
    <td width="420" height="300">
      <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH=420 HEIGHT=300 VIEWASTEXT><PARAM NAME=movie VALUE="images/flash/lottery1.swf">
        <PARAM NAME=quality VALUE=high>
        <PARAM NAME=bgcolor VALUE=#FFFFFF>
        <EMBED src="Movie1.swf" quality=high bgcolor=#FFFFFF WIDTH=460 HEIGHT=300 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version= ShockwaveFlash"></EMBED>
      </OBJECT> 
    </td>
  </tr>
</table>
<TABLE class=table_banner cellSpacing=1 cellPadding=0 width="420" border=0 align="center">
   <TBODY>
      <TR> 
        <TD height=20>
          <TABLE class=banner_set height=24 cellSpacing=0 cellPadding=0 width="100%" border=0>
             <TBODY>
               <TR> 
    <td align="right" nowrap>香港马会第</td>
    <td id="ltnum" width="40" align="center"></td>
    <td align="left" nowrap>期开奖结果</td>
               </TR>
             </TBODY>
          </TABLE>
        </TD>
      </TR>
    </TBODY>
</TABLE>
<table width="420" border="0" cellpadding="0" cellspacing="1" align="center">
  <tr class="tr_title_set_cen1" color="yellow">
    <td width="60" height="25">正码一</td>
    <td width="60">正码二</td>
    <td width="60">正码三</td>
    <td width="60">正码四</td>
    <td width="60">正码五</td>
    <td width="60">正码六</td>
    <td width="60">特别号</td>
  </tr>
  <tr class="tr_title_set_cen2" height="50">
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
    <td width="60" id="bal" align="center" class="unnamed1">&nbsp;</td>
  </tr>
</table>

<iframe name="subframe" height="0" width="0" src="sub.aspx" >

</iframe>
</body>

</html>