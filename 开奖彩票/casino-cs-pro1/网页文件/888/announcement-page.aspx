<%@ Page language="c#" Codebehind="announcement-page.aspx.cs" AutoEventWireup="false" Inherits="newball.subuser.announcement_page" %>

<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/manager-ch.css">
		
			<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<script language="JavaScript" src="../javascript/function-no-status-msg.js"></script>
	<script language="JavaScript" src="../javascript/generic-tr-hover.js"></script>
</head>

<div id="oddnavi"><%# language[lang][0]%></div>
<span style="color:white" style="display:none">.</span>
	<table class="om" cellspacing=1 width="50%">
		<tr>
			<th class="tdC" colspan=2><%# language[lang][0]%></th>
		</tr>
		<tr>
			<td style="background-color:#d6d6d6;"><%# language[lang][1]%></th>
			<td style="background-color:#d6d6d6;"><%# language[lang][0]%></th>
		</tr>
							<%#kyglContent%>
							
			</table>
<br>
</body>
</html>
