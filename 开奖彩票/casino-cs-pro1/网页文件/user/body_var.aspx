<%@ Page language="c#" Codebehind="body_var.aspx.cs" AutoEventWireup="false" Inherits="newball.user.body_var" %>
<HTML>
	<HEAD>
		<title>ì瞴跑计</title>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<SCRIPT language="JAVASCRIPT">
parent.wtype='<%# wtype %>';
parent.gNum = '<%# qishu %>';
parent.num = '<%# num %>';
parent.Msg='<%# msg %>';
parent.gTime = '<%# kaisai %>';
parent.isclose = '<%# isclose %>';
<%# kyglcontent %>

function onLoad()
 {
  parent.loading='N';
  if(parent.loading_var == 'N' && parent.wtype != '')
  {
  
parent.ShowGameList();
parent.loading_var = 'Y';
parent.s='Y';
  }  

  if (parent.s=='YY')
   {parent.ShowDiffOdds();  }
 
 }
		</SCRIPT>
	</HEAD>
	<body bgcolor="#ffffff" onLoad="onLoad()">
	</body>
</HTML>
