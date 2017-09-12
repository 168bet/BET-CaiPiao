<%@ Page language="c#" Codebehind="football_select.aspx.cs" AutoEventWireup="false" Inherits="newball.gs.football_select" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>football_select</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link href="css/css.css" type="text/css" rel="stylesheet">
		<script language="javascript" type="text/javascript">

			/*-----------------------------------------------------------------*/
			/* checkThis2(string, object)
				o For checker trigger where child will follow master's setting */
			/*-----------------------------------------------------------------*/
			function checkThis2(fieldName,masterCheckbox)
			{
			
		
			  var e =document.getElementsByName(fieldName);
				if(e)
				{
					var len = document.getElementsByName(fieldName).length;					
					for(var i=0;i<len;i++)
					{
						e[i].checked = masterCheckbox.checked;
					}
				}		
			}
			
			
			
		
			
			//这是第二种方法；
			function CheckAllDeal(fileName,masterCheckbox)
			{				
				var len = document.myForm.elements.length;
				for(var i=0;i<len;i++)
				{
					var e = document.myForm.elements[i];
					if(e.type == 'checkbox' && e.name.indexOf(fileName) != -1)
					{
						e.checked = masterCheckbox.checked;
					}
				}
			}
		</script>
	</HEAD>
	<body>
		<form id="myForm" method="post" action="football_select.aspx?path=<%# pathStr %>" runat="server">
			<table border="0" cellpadding="0" cellspacing="0" width="500">
				<tr>
					<td>
						&nbsp;&nbsp;选择联赛&nbsp;--&nbsp; <a href="javascript:window.myForm.submit();">完成</a>&nbsp;&nbsp;
						<a href="javascript:window.history.back();">返回</a>
					</td>				
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" cellspacing="1" cellpadding="0" id="tableSelect" width="150" class="tableBorder1" runat="server">
				<tr>
					<td width="100%" align="left" style="background-color:#0099ff;color:#FFFFFF;height:25;">
						<input type="checkbox" name="fr_checkall" onClick="checkThis2('fr_league',this);">联赛
					</td>
				</tr>
				<tr>
					<td align="left" bgcolor="#ffffff" width="100%"></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>

