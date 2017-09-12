<%@ Page language="c#" Codebehind="FT_index.aspx.cs" AutoEventWireup="false" Inherits="newball.user.FT_index" %>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>


<script language="JavaScript">
var retime=90;
//alert('');
</script>

<frameset rows="80 ,*" cols="*" frameborder="NO" border="0" framespacing="0">
  <frame src="header.aspx" name="header" scrolling="NO" noresize >
  <frameset cols="241,*" frameborder="NO" border="0" framespacing="0">
    <frame src="betting-entry.aspx" name="bbnet_mem_order" scrolling="auto" noresize>
    <frame src="betting-matches.aspx?rtype=SP&mtype=3" name="body">
  </frameset>
</frameset>
<noframes> 
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes> 
</html>
