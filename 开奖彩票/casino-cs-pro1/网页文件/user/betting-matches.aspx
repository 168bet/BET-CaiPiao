<%@ Page language="c#" Codebehind="betting-matches.aspx.cs" AutoEventWireup="false" Inherits="newball.user.betting_matches" buffer="False" codePage="936" %>

<HTML>
	<HEAD>
		<script>if(self == top) location='../';</script>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<SCRIPT language=javaScript src="js/FT_mem_showgame.js" type=text/javascript></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT">
<!--
if(self == top) location = '/';

var Msg='';
var gNum;
var gTime;
var isclose="1";
var retime;
var retime_flag;
var num;
var gID;
var num_str;
var HKtime;
var sOdds = new Array(50);
var sIds = new Array(50);
var sPds = new Array(6);
var pOdds = new Array(5);
var pOddsName = new Array(5);
var pOddsId = new Array(5);
var cOdds = new Array(4);
var cOddsName = new Array(4);
var cOddsId = new Array(4);
var uOdds = new Array(5);
var uOddsName = new Array(5);
var uOddsId = new Array(5);
var loading_var = '';
var loading = '';
var s = '';

var reload_f = 0;
var wtype='';
var ball_color = Array(0,0,1,1,2,2,0,0,1,1,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,0,1,2,2,0,0,1,1,2,2,0,1,1,2,2,0,0,1,1,2);
var bcolor = Array('r','b','g');
<%# kygltable%>

HKtime = '<%# DateTime.Now %>';
if(parent.gTime==''){
		parent.main.document.all['showTable'].style.display = 'none';}		




	
function ReloadOdds()
{
   //action.location = "body_var.aspx?rtype=<%# Request.QueryString["rtype"] %>&langx=zh-cn&mtype=<%# Request.QueryString["mtype"] %>&Reload=Y";
}
//-->
</SCRIPT>
</head>
<frameset rows="0,*,0" frameborder="NO" border="0" framespacing="0">
<frame name="action" id="action" src="body_var.aspx?rtype=<%# Request.QueryString["rtype"] %>&langx=zh-cn&mtype=<%# Request.QueryString["mtype"] %>  scrolling="NO" noresize>
<frame name="main" id="main" src="body_browse.aspx?rtype=<%# Request.QueryString["rtype"] %>&langx=zh-cn&mtype=<%# Request.QueryString["mtype"] %>  scrolling="AUTO">
<frame name="timer" scrolling="NO" noresize src="timer.aspx">
</frameset>
<noframes>
<body>

</body>
</noframes>
</html>
