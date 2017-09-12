<%@ Page language="c#" Codebehind="frmheader.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.frmheader" %>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>Super User</title>
<link href="/style/css-g.css" rel="stylesheet" type="text/css">
<script language=javascript>
function new_win(html_name,winname,w,h){
  if(winname=='') winname='WINDOWS';
  if(w=='') w=640;
  if(h=='') h=480;
  //undefined
  winformat="toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width="+w+",height="+h;
  winid = window.open(html_name,winname,winformat)
} 
</script>
<script>
		function refreshkygl()
		{
			document.refreshForm.submit();
			setTimeout('refreshkygl()',300000);
		}
	</script>
<style type="text/css">
.title_01 {
	FONT-SIZE: 12px;
	COLOR: #000000;
	cursor: auto;
	text-decoration: none;
}
a:link {
    color: #FFFFFF;
	text-decoration: none;
	font-size: 13px;
	line-height:16px;
}
a:hover { 
	color: #FF0000;
	text-decoration: none;
	font-size: 13px;
	line-height: 16px;
}
a:visited {
	color: #FFFFFF;
	text-decoration: none;
	font-size: 13px;
	line-height:16px;
}
a:visited:hover { 
color: #FF0000;
	text-decoration: none;
	font-size: 13px;
	line-height: 16px;
	}
</style>
</head>

<body leftmargin="0" topmargin="0">
<form action=announcement.aspx method="post" name="refreshForm" target="iframe"></form>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="111"><img src="image/header_ph11.jpg" width="111" height="52"></td>
    <td><img src="image/header_ph12.jpg" width="207" height="52"><img src="image/header_ph13.jpg" width="306" height="52"></td>
  </tr>
  <tr> 
    <td><img src="image/header_ph21.jpg" width="111" height="48"></td>
    <td background="image/header_ph22.jpg"><table><tr>
							<td width="649" height="22"><strong>ac577</strong> | <a href="quit.aspx" target="_top">
									登出</a>
								<asp:Label id="LabelLoginUserName" runat="server" BorderColor="Transparent" BackColor="Transparent" ForeColor=red>kk</asp:Label>&nbsp;&nbsp;&nbsp;<a href=../download/te4.exe>下载清洗工具</a> <a href=../download/setup.htm target=_blank>如何安装</a></td>
							<td width="10"><iframe name="iframe" id="iframe" allowtransparency frameborder="0" width="350" height="20"
									marginwidth="0" marginheight="0" src="announcement.aspx"></iframe></td>
						</tr></table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="21" background="image/top-5x.gif"><div align="center">
        <TABLE cellSpacing=0 cellPadding=0 width=800 border=0 id="TD_ToolBar" runat="server">
          <TBODY>
            <TR> 
            <td></td>  
            </TR>
          </TBODY>
        </TABLE>
      </div></td>
  </tr>
</table>
<script>
			setTimeout('refreshkygl()',300000);
		</script>
</body>
</html>

