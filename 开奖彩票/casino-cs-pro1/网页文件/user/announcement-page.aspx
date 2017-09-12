<%@ Page language="c#" Codebehind="announcement-page.aspx.cs" AutoEventWireup="false" Inherits="newball.user.announcement_page" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>announcement-page</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
<LINK href="css/user.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/function-no-status-msg.js"></SCRIPT>

<SCRIPT language=JavaScript src="js/function-no-copying.js"></SCRIPT>

<SCRIPT language=JavaScript src="js/generic-tr-hover.js"></SCRIPT>		
	
<title><MMString:LoadString id="insertbar/formsCheckbox" /></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<!-- Copyright 2000,2001 Macromedia, Inc. All rights reserved. -->
<style type="text/css">
<!--
tr {font-family: "Arial";font-size: 12px;}
.ad_title {
	background-color: #bbd5fb;
	border-top: 1px solid #707161;
	border-right: 1px solid #707161;
	border-bottom: 0px solid #707161;
	border-left: 1px solid #707161;
	padding-top: 4px;
	padding-right: 2px;
	padding-left: 8px;
}
.b_tab {
	padding-top: 4px;
	padding-bottom: 2px;
	padding-left: 4px;
	background-color: #707161;
	width: 524px;
}
.b_tbline {
	background-color: #BBB1A1;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	width: 530px;
	border-top: 0px solid #707161;
	border-right: 1px solid #707161;
	border-bottom: 1px solid #707161
	border-left: 1px solid #707161;}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="10" vlink="#0000FF" alink="#0000FF" >
<div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: hidden; left: 7px;"> 
  <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>


<table width="530" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="ad_title">历史跑马灯：</td>
  </tr>
</table>
<div class="b_tbline">
  <table border="0" cellpadding="0" cellspacing="1" class="b_tab">
  <TR>
      <TH >时间</TH>
    <TH >消息</TH></TR>
     <%# kyglContent %>
</table>
</div>
</body>
</html>