<%@ Page language="c#" Codebehind="basketjsdeal.aspx.cs" AutoEventWireup="false" Inherits="odds.odds.basketjsdeal" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>basketjsdeal</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<script>
		function showcontent(type)
		{
			switch(type)
			{				
				case 'dx':parent.document.all["dx"].innerHTML = "<font color=red>正在结算大小注单,请稍后..</font>";parent.document.myForm.jstype.value='dx';parent.document.myForm.submit();break;
				case 'ds':parent.document.all["ds"].innerHTML = "<font color=red>正在结算单双注单,请稍后..</font>";parent.document.myForm.jstype.value='ds';parent.document.myForm.submit();break;
				case 'uah':parent.document.all["uah"].innerHTML = "<font color=red>正在结算上半场让球注单,请稍后..</font>";parent.document.myForm.jstype.value='uah';parent.document.myForm.submit();break;
				case 'udx':parent.document.all["udx"].innerHTML = "<font color=red>正在结算上半场大小注单,请稍后..</font>";parent.document.myForm.jstype.value='udx';parent.document.myForm.submit();break;
				case 'uds':parent.document.all["uds"].innerHTML = "<font color=red>正在结算上半场单双注单,请稍后..</font>";parent.document.myForm.jstype.value='uds';parent.document.myForm.submit();break;				
				case 'dah':parent.document.all["dah"].innerHTML = "<font color=red>正在结算下半场让球注单,请稍后..</font>";parent.document.myForm.jstype.value='dah';parent.document.myForm.submit();break;
				case 'ddx':parent.document.all["ddx"].innerHTML = "<font color=red>正在结算下半场大小注单,请稍后..</font>";parent.document.myForm.jstype.value='ddx';parent.document.myForm.submit();break;
				case 'dds':parent.document.all["dds"].innerHTML = "<font color=red>正在结算下半场单双注单,请稍后..</font>";parent.document.myForm.jstype.value='dds';parent.document.myForm.submit();break;
				
				case 'ah_ht':parent.document.all["ah_ht"].innerHTML = "<font color=red>正在结算让球过关注单,请稍后..</font>";parent.document.myForm.jstype.value='ah_ht';parent.document.myForm.submit();break;				
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