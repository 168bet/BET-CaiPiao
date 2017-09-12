<%@ Page language="c#" Codebehind="BallJsFrame.aspx.cs" AutoEventWireup="false" Inherits="newball.mem.BallJsFrame" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>BallJsFrame</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<script>
		function showcontent(type)
		{
			switch(type)
			{
				case 'ht_rq':parent.document.all["ht_rq"].innerHTML = "<font color=red>正在结算上半场让球注单,请稍后..</font>";parent.document.myForm.jstype.value='ht_rq';parent.document.myForm.submit();break;
				case 'ht_dx':parent.document.all["ht_dx"].innerHTML = "<font color=red>正在结算上半场大小注单,请稍后..</font>";parent.document.myForm.jstype.value='ht_dx';parent.document.myForm.submit();break;
				case 'rq':parent.document.all["rq"].innerHTML = "<font color=red>正在结算让球注单,请稍后..</font>";parent.document.myForm.jstype.value='rq';parent.document.myForm.submit();break;
				case 'dx':parent.document.all["dx"].innerHTML = "<font color=red>正在结算大小注单,请稍后..</font>";parent.document.myForm.jstype.value='dx';parent.document.myForm.submit();break;
				case 'zd_rq':parent.document.all["zd_rq"].innerHTML = "<font color=red>正在结算特别号大小注单,请稍后..</font>";parent.document.myForm.jstype.value='zd_rq';parent.document.myForm.submit();break;
				case 'zd_dx':parent.document.all["zd_dx"].innerHTML = "<font color=red>正在结算特别号合数单双注单,请稍后..</font>";parent.document.myForm.jstype.value='zd_dx';parent.document.myForm.submit();break;
				case 'zd_ds':parent.document.all["zd_ds"].innerHTML = "<font color=red>正在结算正码注单,请稍后..</font>";parent.document.myForm.jstype.value='zd_ds';parent.document.myForm.submit();break;
				case 'ds':parent.document.all["ds"].innerHTML = "<font color=red>正在结算单双注单,请稍后..</font>";parent.document.myForm.jstype.value='ds';parent.document.myForm.submit();break;
				case 'dw':parent.document.all["dw"].innerHTML = "<font color=red>正在结算标准注单,请稍后..</font>";parent.document.myForm.jstype.value='dw';parent.document.myForm.submit();break;
				case 'bd':parent.document.all["bd"].innerHTML = "<font color=red>正在结算波胆注单,请稍后..</font>";parent.document.myForm.jstype.value='bd';parent.document.myForm.submit();break;
				case 'rqs':parent.document.all["rqs"].innerHTML = "<font color=red>正在结算入球数注单,请稍后..</font>";parent.document.myForm.jstype.value='rqs';parent.document.myForm.submit();break;
				case 'ht':parent.document.all["ht"].innerHTML = "<font color=red>正在结算半全场注单,请稍后..</font>";parent.document.myForm.jstype.value='ht';parent.document.myForm.submit();break;
				
			}
			return true;
		
		}
		</script>
	</HEAD>
	<body>
		<script><%# kyglContent %></script>
		<FONT face="宋体"></FONT>
	</body>
</HTML>
