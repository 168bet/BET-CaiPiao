<%@ Page language="c#" Codebehind="BallJs.aspx.cs" AutoEventWireup="false" Inherits="newball.odds.subadmin.BallJs" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>BallJs</title>
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
				<td id="ht_rq">&nbsp;</td>
			</tr>
			<tr>
				<td id="ht_dx">&nbsp;</td>
			</tr>
			<tr>
				<td id="rq">&nbsp;</td>
			</tr>
			<tr>
				<td id="dx">&nbsp;</td>
			</tr>
			<tr>
				<td id="zd_rq">&nbsp;</td>
			</tr>
			<tr>
				<td id="zd_dx">&nbsp;</td>
			</tr>
			<tr>
				<td id="zd_ds">&nbsp;</td>
			</tr>
			<tr>
				<td id="ds">&nbsp;</td>
			</tr>
			<tr>
				<td id="dw">&nbsp;</td>
			</tr>
			<tr>
				<td id="bd">&nbsp;</td>
			</tr>
			<tr>
				<td id="rqs">&nbsp;</td>
			</tr>
			<tr>
				<td id="ht"></td>
			</tr>
		</table>
		<form id="myForm" name="myForm" action="BallJsFrame.aspx" method="post" target="jsFrame">
			<input type="hidden" value="<%# kyglJstype %>" name="jstype"><input type="hidden" value="<%# kyglBallid %>" name="ballid">
			<input type="hidden" value="kygl" name="action"><input type="hidden" value="<%# kyglThisdate %>" name="thisdate">
		</form>
		<iframe style='display:none' src='' id="jsFrame" name="jsFrame"></iframe>
	</body>
	<script>
			if(myForm.ballid.value != "0")
			{
				document.all["ht_rq"].innerHTML = "<font color=red>正在结算上半场让球注单,请稍后..</font>";
				document.myForm.jstype.value = 'ht_rq';
				document.myForm.submit();
			}
			else
			{
				
				document.all["ht_rq"].innerHTML = "<font color=red>正在结算注单,请稍后..</font>";
				document.myForm.submit();
			}
	</script>
</HTML>
