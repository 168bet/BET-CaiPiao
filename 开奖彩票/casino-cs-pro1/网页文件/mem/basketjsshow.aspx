<%@ Page language="c#" Codebehind="basketjsshow.aspx.cs" AutoEventWireup="false" Inherits="mem.basketjsshow" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>basketjsdeal</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<table width="400" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td id="ah_ht">&nbsp;</td>
			</tr>
			<tr>
				<td id="dx">&nbsp;</td>
			</tr>
			<tr>
				<td id="ds">&nbsp;</td>
			</tr>			
			<tr>
				<td id="uah">&nbsp;</td>
			</tr>
			<tr>
				<td id="udx">&nbsp;</td>
			</tr>
			<tr>
				<td id="uds">&nbsp;</td>
			</tr>
			<tr>
				<td id="dah">&nbsp;</td>
			</tr>
			<tr>
				<td id="ddx">&nbsp;</td>
			</tr>
			<tr>
				<td id="dds">&nbsp;</td>
			</tr>
		</table>
		<form id="myForm" name="myForm" action="basketjsdeal.aspx" method="post" target="jsFrame">
			<input type="hidden" value="<%# kyglJstype %>" name="jstype">
			<input type="hidden" value="<%# kyglBallid %>" name="ballid">
			<input type="hidden" value="kygl" name="action">
			<input type="hidden" value="<%# kyglThisdate %>" name="basketthisdate">
		</form>
		<iframe style='display:none' src='' id="jsFrame" name="jsFrame"></iframe>
	</body>
	<script>
			if(myForm.ballid.value != "0")
			{
				document.all["ah_ht"].innerHTML = "<font color=red>正在结算让球注单,请稍后..</font>";
				document.myForm.jstype.value = 'ah_ht';
				document.myForm.submit();
			}
			else
			{
				if(myForm.jstype.value == "21")
				{
					document.all["ah_ht"].innerHTML = "<font color=red>正在让球过关注单,请稍后..</font>";
					document.myForm.submit();
				}
			}
	</script>
</HTML>

