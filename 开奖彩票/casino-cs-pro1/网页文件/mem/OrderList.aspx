<%@ Page language="c#" Codebehind="OrderList.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.OrderList" codePage="936" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>OrderList</title>
		<META http-equiv="Content-Type" content="text/html; charset=gb2312">
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<meta http-equiv="refresh" content="180">
		<LINK href="css/css.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body leftMargin="3" topMargin="3">
		180秒自动刷新  [<a href="javascript:window.location.reload();">更新</a>]<br>
		<table width="1024" border="0" cellpadding="3" cellspacing="1" class="bet_enq">
			<tr>
				<th width="130">订单ID</th>
				<th width="70">时间</th>
				<th width="60">会员</th>
				<th width="70">方式</th>
				<th width="200">详情</th>
				<th width="100">投注IP</th>
				<th width="90">注额金额</th>
				<th width="60">输赢情况</th>
				<th width="90">注额结果</th>
				<th width="80">操作</th>
			</tr>
			<%# kyglContent %>
		</table>
	</body>
</HTML>
