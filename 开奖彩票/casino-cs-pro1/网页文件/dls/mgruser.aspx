<%@ Page language="c#" Codebehind="mgruser.aspx.cs" AutoEventWireup="false" Inherits="newball.dls.mgruser" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>��Ա</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<script src="js/std.js"></script>
		<script language="javascript" type="text/javascript">		
			function lockproc(lockflag,userid)
			{				
				document.getElementById("myFORM").action = "mgruser.aspx?lockflag="+ lockflag +"&userid="+ userid;
				document.getElementById("myFORM").submit();
				document.getElementById("myFORM").action = "mgruser.aspx";
			}
		</script>
		
		
		<link href="css/css.css" rel="stylesheet" type="text/css">
	</HEAD>
	<body>
		<form id="myFORM" name="myFORM" method="post" runat="server">
			<table height="27" cellSpacing="0" cellPadding="0" width="830" border="0">
				<tr >
					<td class="m_tline">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="70">&nbsp;&nbsp;ѡ�������:</td>
								<td>
									<select name="agenceid" id="agenceid" runat="server" onChange="document.myFORM.submit();">
										<option value="" selected></option>
									</select>
								</td>
								<td>
									-- ����:</td>
								<td>
									<select id="sortname" name="sortname" onChange="document.myFORM.submit();" runat="server">
										<option value="dlsname" selected>������</option>
										<option value="username">��Ա�ʺ�</option>
										<option value="regtime">����ʱ��</option>
									</select>
									<select id="sortorderby" name="sortorderby" onChange="self.myFORM.submit()" runat="server">
										<option value="asc" selected>����(��С����)</option>
										<option value="desc">����(�ɴ�С)</option>
									</select>
								</td>
								<td>&nbsp;&nbsp;
									<select id="sortenable" name="sortenable" onChange="self.myFORM.submit()" runat="server">
										<option value="">ȫ��</option>
										<option value="1" selected>����</option>
										<option value="0">ͣ��</option>
									</select>
									-- ��ҳ��:
									<select id="selectpage" name="selectpage" onChange="self.myFORM.submit()" runat="server">
										<option value="0">0</option>
									</select>
									/<label id="sumpages" runat="server">0</label>ҳ <input type="button" id="appendbutton" name="appendbutton" value="�� ��" runat="server" onClick="javascript:window.location.href='adduser.aspx'" class="Text">
								</td>
							</tr>
						</table>
					</td>
					<td width="30"><img src="images/top_04.gif" width="30" height="24"></td>
				</tr>
				<tr>
					<td colspan="2" height="4"></td>
				</tr>
			</table>
			<table border="0" width="800" cellpadding="0" cellspacing="2" runat="server" id="userLists">
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
