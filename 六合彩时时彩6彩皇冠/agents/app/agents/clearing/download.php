<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>体育结算</title>
<script> 
<!-- 
var limit="10:00" 
if (document.images){ 
	var parselimit=limit.split(":") 
	parselimit=parselimit[0]*60+parselimit[1]*1 
} 
function beginrefresh(){ 
	if (!document.images) 
		return 
	if (parselimit==1) 
		window.location.reload() 
	else{ 
		parselimit-=1 
		curmin=Math.floor(parselimit/60) 
		cursec=parselimit%60 
		if (curmin!=0) 
			curtime=curmin+"分"+cursec+"秒后自动登陆！" 
		else 
			curtime=cursec+"秒后自动登陆！" 
		//	timeinfo.innerText=curtime 
			setTimeout("beginrefresh()",1000) 
	} 
} 
window.onload=beginrefresh 
//--> 
</script>
</head>

<frameset rows="156,157,156,156" cols="*">
  <frameset rows="*" cols="244,244,244,244">
    <frame src="clearing_ft.php" />
    <frame src="parlay_clearing_ft.php" />
    <frame src="clearing_bk.php">
	<frame src="parlay_clearing_bk.php">
  </frameset>
  
   <frameset rows="*" cols="244,244,244,244">
	  <frame src="clearing_bs.php" />
      <frame src="parlay_clearing_bs.php" />
      <frame src="clearing_tn.php" />
	  <frame src="parlay_clearing_tn.php">
   </frameset>
   
   <frameset rows="*" cols="244,244,244,244">
	  <frame src="clearing_vb.php" />
      <frame src="parlay_clearing_vb.php" />
      <frame src="clearing_op.php" />
	  <frame src="parlay_clearing_op.php">
   </frameset>
   <frameset rows="*" cols="244,244,244,244">
	  <frame src="clearing_fs.php" />
      <frame src="clearing_ftb.php" />
      <frame src="score18.php" />
	  <frame src="about:blank">
   </frameset>   
</frameset>

<noframes>
<body>
</body>
</noframes></html>
