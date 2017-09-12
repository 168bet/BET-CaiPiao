<%@ Page language="c#" Codebehind="Watch.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.gj.Watch" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>Watch</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="../css/css.css" type="text/css" rel="stylesheet">
		<META HTTP-EQUIV="Refresh" CONTENT="120"> 
	</HEAD>
	<body  leftMargin="1" topMargin="1">
<a href=watch.aspx?action=1>正常</a> <a href=watch.aspx?action=2>不正常</a> <a href=watch.aspx>全部</a> <a href="javascript:window.location.reload();">刷新</a>
<table width="900" border="0" cellpadding="2" cellspacing="1" bgcolor=#000000>
  <tr align="center" class=addmember> 
    <td width="60">会员</td>
    <td width="60">密码</td>
    <td width="60">下注数</td>
    <td width="60">总信用</td>
    <td width="60">下注金额</td>
    <td width="60">信用余额</td>
    <td width="50">状况</td>
    <td width="20">&nbsp;</td>
    <td width="60">会员</td>
    <td width="60">密码</td>
    <td width="60">下注数</td>
    <td width="60">总信用</td>
    <td width="60">下注金额</td>
    <td width="60">信用余额</td>
    <td width="50">状况</td>
  </tr>
  <%# kyglContent %>
  </table>
	</body>
</HTML>
