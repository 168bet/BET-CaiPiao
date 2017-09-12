<%@ Page language="c#" Codebehind="index.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.odds.index" %>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>WELCOME</title>
<script language="JavaScript" type="text/JavaScript">
<!--

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<link href="css/mem_index.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/index_bk.jpg">
        <tr> 
          <td width="49%">&nbsp;</td>
          <td width="2%"><table width="770" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><img src="images/index_ph11.jpg" width="237" height="145"></td>
                <td><img src="images/index_ph12.jpg" width="140" height="145"></td>
                <td><img src="images/index_ph13.jpg" width="125" height="145"></td>
                <td><img src="images/index_ph14.jpg" width="207" height="145"></td>
                <td><img src="images/index_ph15.jpg" width="63" height="145"></td>
              </tr>
              <tr> 
                <td><img src="images/index_ph21.jpg" width="237" height="126"></td>
                <td><img src="images/index_ph22.jpg" width="140" height="126" border="0" usemap="#Map"></td>
                <td><img src="images/index_ph23.jpg" width="125" height="126" border="0" usemap="#Map2"></td>
                <td background="images/index_ph24.jpg">
                 <table border="0" align="center" cellpadding="0" cellspacing="0">
                   
                    <tr>
                      <td>&nbsp;</td>
                      <td><!--<select name="menu1" class="za_select" onChange="MM_jumpMenu('parent',this,0)">
                          <option value="#" selected>一般会员</option>
                        </select>--></td>
                    </tr>
					 <FORM name="myForm" id="myForm" runat="server">
                    <tr>
                      <td>帐 号:</td>
                      <td><asp:TextBox id="TextBoxUserName" runat="server" size=16 class="za_text"></asp:TextBox></td>
                    </tr>
                    <tr>
                      <td>密 码:</td>
                      <td><asp:TextBox id="TextBoxUserPass" runat="server" size=16 class="za_text" TextMode="Password"></asp:TextBox></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td><td><asp:Button id="ButtonLogin" runat="server"  class="za_button" Text="登入"></asp:Button></td>
                    </tr>
                    </form>
                  </table></td>
				  <td><img src="images/index_ph25.jpg" width="63" height="126"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><img src="images/index_ph31.jpg" width="207" height="18"></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          <td width="49%">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<map name="Map">
  <area shape="rect" coords="64,14,123,39" href="tindex.aspx">
</map>
<map name="Map2">
  <area shape="rect" coords="16,14,72,37" href="index.aspx">
</map>
</body>
</html>
