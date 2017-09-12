<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
include "../include/address.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
require ("../include/curl_http.php");
$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$rtype=ltrim(strtolower($_REQUEST['rtype']));
$league_id=$_REQUEST['league_id'];
require ("../include/traditional.$langx.inc.php");
if ($rtype==""){
	$rtype="fs";
}
$sql = "select UserName,Status from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
$username=$row['UserName'];
mysql_close();
?>
<!--<script>if (top.game_alert.indexOf('FS')==-1){alert("<?=$mem_msg?>"); top.game_alert+='FS,'}</script>-->
<html>
<head>
<title>冠軍</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='Page-Exit' content='revealTrans(Duration=0,Transition=5)'>
<link rel="stylesheet" href="/style/member/mem_body.css" type="text/css">
<script> 
top.str_input_pwd = "密碼請務必輸入!!";
top.str_input_repwd = "確認密碼請務必輸入!!";
top.str_err_pwd = "密碼確認錯誤,請重新輸入!!";
top.str_pwd_limit = "您的密碼必須至少6個字元長，最多12個字元長，並只能是數字，英文字母等符號，其他的符號都不能使用!!";
top.str_pwd_limit2 = "您的密碼需使用字母加上數字!!";
top.str_pwd_NoChg = "您的密碼未做任何變更!!";
top.str_input_longin_id = "登錄帳號請務必輸入!!";
top.str_longin_limit1 = "登錄帳號最少必須有2個英文大小寫字母和數字(0~9)組合輸入限制(6~12字元)";
top.str_longin_limit2 = "您的登錄帳號需使用字母加上數字!!";
top.str_o="單";
top.str_e="雙";
top.str_checknum="驗證碼錯誤,請重新輸入";
top.str_irish_kiss="和局";
top.dPrivate="私域";
top.dPublic="公有";
top.grep="群組";
top.grepIP="群組IP";
top.IP_list="IP列表";
top.Group="組別";
top.choice="請選擇";
top.account="請輸入帳號!!";
top.password="請輸入密碼!!";
top.S_EM="特早";
top.alldata="全部";
top.webset="資訊網";
top.str_renew="更新";
top.outright="冠軍";
top.financial="金融";
 
//====== Live TV
top.str_FT = "足球";
top.str_BK = "籃球";
top.str_TN = "網球";
top.str_VB = "排球";
top.str_BS = "棒球";
top.str_OP = "其他";
top.str_game_list = "所有球類";
top.str_second = "秒";
top.str_demo = "樣本播放";
top.str_alone = "獨立";
top.str_back = "返回";
top.str_RB = "滾球";
 
top.str_ShowMyFavorite="我的最愛";
top.str_ShowAllGame="全部賽事";
top.str_delShowLoveI="移出";
</script>
<script>
 
var Showtypes="R";
var ordersR=new Array();
var ordersOU=new Array();
var keep_rs_windows="";
var se="90";
var sessions="2";
var keep_action1="";
var keep_leg="";
var Ratio=new Array();
var defaultOpen = true;			// 預設盤面顯示全縮 或是 全打開
 
function showgame_table(){
	init();
	obj_msg = document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"120\">'+msg+'</marquee>';
	
	var tmp_outright='';
	if(parent.rtype=='fs'){
		tmp_outright=top.outright;
	}else{
		tmp_outright=top.financial;
	}
	obj_TMP_ITEM = document.getElementById('tmp_TMP_ITEM');
	obj_TMP_ITEM.innerHTML=tmp_outright;
	
	start_time=get_timer();
	var AllLayer="";
	var layers="";
	var shows=showlayers.innerHTML;
	var tr_data=document.getElementById('glist').innerHTML;
	doings="";
	keep_leg="";
	
	for (i=0;i<gamount;i++){
		gid=GameFT[i][0];
		AllLayer+=layer_screen(gid,tr_data);
		
	}
	//alert("aaa==>"+AllLayer);
	showgames.innerHTML=shows.replace("*ShowGame*",AllLayer);
	if (defaultOpen){
		for (i=0;i<gamount;i++){
			gid=GameFT[i][0];
			document.getElementById('TR'+gid).style.display="block";
		}
	}
	parent.document.getElementById("body").height=document.body.scrollHeight; 
	//alert(document.body.scrollHeight);
	//alert('asdfasdf');
	
	//alert(document.body.scrollHeight);
	//document.getElementById('pages').innerHTML=get_timer()-start_time;
}
function layer_screen(gid,layers){	
	//檢查賠率是否有變動
	changeRatio=check_ratio(gid).split(",");	
		param=getpararm('2');
		gno=gidx[gid];
		layers=layers.replace("*GID*",GameFT[gno][0]);/*gid*/
		//layers=layers.replace("*GID*",GameFT[gno][0]);/*gid*/ 
		layers=layers.replace("*TIME*",change_time(GameFT[gno][1]));/*時間*/
		layers=layers.replace("*LEG*","<font style='cursor: hand' onClick='showLEG("+GameFT[gno][0]+");'>"+GameFT[gno][2]+"</font>");/*聯盟*/
		if (keep_leg==GameFT[gno][2]) layers=layers.replace("*ST*","style='display: none'");
		else layers=layers.replace("*ST*","");
		
		keep_leg=GameFT[gno][2]
		layers=layers.replace("*ITEM*",GameFT[gno][3]); /*場次*/
		if (parent.LegGame.indexOf((GameFT[gno][2]+"_").replace("<br>"," ").replace(" _","_"),0)<0 && parent.LegGame!="ALL" ) return ""; //select game
		if (GameFT[gno][4]=="N"){
			return "";
		}else{
			layers=layers.replace("*CLASS*",'bgcolor=#ffffff');
		}
		
		teamdata="<table class='b_tab' cellpadding=0 cellspacing=1>";
		
		result="";
		if (GameFT[gno][5]*1>0){
			
			for (k=0;k<GameFT[gno][5];k++){
				
				if (GameFT[gno][6+k*4]=="N") {
					
					if (GameFT[gno][9+k*4]*1==0) {
						
						GameFT[gno][9+k*4]="";
					}else{
						GameFT[gno][9+k*4]=printf(GameFT[gno][9+k*4],2);
						teamdata+="<tr><td bgcolor=white width=400 class='b_lgf'>"+result+GameFT[gno][8+k*4]+ "</td>";
						//teamdata+="<td width=60 class='b_cen' bgcolor=white><font class='r_bold' style='cursor:hand' onclick=parseOrder('../order_FS/FS_order_r.php','"+param+","+gid+","+GameFT[gno][7+k*4]+","+GameFT[gno][9+k*4]+"')>"+GameFT[gno][9+k*4]+"</font></td></tr>";
						//alert("../FT_order/FT_order_nfs.php?gametype="+GameFT[i][(GameFT[i].length-1)]+"&gid="+GameFT[i][0]+"&uid="+top.uid+"&rtype="+GameFT[gno][7+k*4]);
						teamdata+="<td "+getcolor(changeRatio,k)+" width=60 class='b_cen' bgcolor=white><font class='r_bold'  title=\""+GameFT[gno][8+k*4]+"\" style='cursor:hand' onclick=parent.mem_order.location.href='../FT_order/FT_order_nfs.php?gametype="+GameFT[i][(GameFT[i].length-1)]+"&gid="+GameFT[i][0]+"&uid="+parent.uid+"&rtype="+GameFT[gno][7+k*4]+"&wtype="+parent.rtype.toUpperCase()+"'>"+GameFT[gno][9+k*4]+"</font></td></tr>";
						//teamdata+="<td width=60 class='b_cen' bgcolor=white><a style='cursor:hand;' href='../FT_order/FT_order_nfs.php?gametype="+GameFT[i][(GameFT[i].length-1)]+"&gid="+GameFT[i][0]+"&uid="+top.uid+"&rtype="+GameFT[gno][7+k*4]+"' target=\"mem_order\">"+GameFT[gno][9+k*4]+"</A></td></tr>";
					
					}
				}
			}
		}
		teamdata+="</table>";
		orders="";
		//alert(teamdata);
		layers=layers.replace("*ORDER*",orders);
		layers=layers.replace("*TEAM*",teamdata);
		//layers=layers.replace("*IORATIO*",teamdata_R);
		
		
	return layers;
}
 
function getcolor(changeRatio,Rpos){
	if (changeRatio[Rpos]=="1"){
		backgrounds=" style='background-color:yellow' ";
	}else{
		 backgrounds="";
	}
	return backgrounds;
	}
//檢查賠率
function check_ratio(gid){
	gnos=gidx[gid];
	var changes="";
	if (""+Ratio[gid]=="undefined"){ 
		Ratio[gid]=new Array();
		}
	for (u=0;u<(GameFT[gnos][5]+1);u++){
		if (""+Ratio[gid][u]!="undefined"){ 
			if (Ratio[gid][u]!=GameFT[gnos][9+u*4]){
				changes+="1,";
			}else changes+="0,";
		}else changes+="0,";
	eval("Ratio[gid]["+u+"]=GameFT[gnos]["+(9+u*4)+"];");	
	}
	return changes;
}
 
 
function showLEG(gid){
	tmp_leg=GameFT[gidx[gid]][2];
	for (x=0;x < GameFT.length;x++){
		if (tmp_leg==GameFT[x][2]){
			gid=GameFT[x][0];
			if(document.getElementById('TR'+gid).style.display=="none"){
				document.getElementById('TR'+gid).style.display="block";
			}else{
				document.getElementById('TR'+gid).style.display="none";
			}
		}
	}
}
 
//===選擇區域===
function chg_area(){
	var obj_area = document.getElementById('sel_aid');
	sel_area=obj_area.value;
	parent.sel_area=sel_area;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);
	reloadPHP.location.href=homepage;
	
}
 
function ShowArea(aid){
	//if ((""+aid=="undefined")) aid="";	
	area_data = "";
	var temp = "";
	var temparray = new Array();
	var area = document.getElementById("area");
	var bodyA = document.getElementById("bodyA");
	var show_a = document.getElementById("show_a");
	var temparea = area.innerHTML;
	txt_bodyA = bodyA.innerHTML;
	if(areasarray != '') {
		area_data = areasarray.split(",");
		for(i=1; i<area_data.length; i++) {
			temparray = area_data[i].split("*");
			txt_area = temparea.replace("*AREA_ID*",temparray[0]);
			if(aid == temparray[0]) txt_area = txt_area.replace("*SELECT_AREA*","SELECTED");
			else txt_area = txt_area.replace("*SELECT_AREA*","");
			txt_area = txt_area.replace("*AREA_NAME*",temparray[1]);
			temp += txt_area;
		}
		txt_bodyA = txt_bodyA.replace("*SHOW_A*",temp);
	} else {
		txt_bodyA =txt_bodyA.replace("*SHOW_A*","");
	}
	sel_areas.innerHTML=txt_bodyA;
}
 
//===選擇類別===
function chg_item(){
	var obj_item = document.getElementById('sel_itemid');
	sel_item=obj_item.value;
	parent.sel_item=sel_item;
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);
	reloadPHP.location.href=homepage;
	
}
 
function ShowItem(FS_items){
	item_data = "";
	var temp = "";
	var temparray = new Array();
	var item = document.getElementById("item");
	var bodyI = document.getElementById("bodyI");
	var show_i = document.getElementById("show_i");
	var tempitem = item.innerHTML;
	txt_bodyI = bodyI.innerHTML;
	if(itemsarray != '') {
		item_data = itemsarray.split(",");
		for(i=1; i<item_data.length; i++) {
			temparray = item_data[i].split("*");
			txt_item = tempitem.replace("*ITEM_ID*",temparray[0]);
			if(FS_items == temparray[0]) txt_item = txt_item.replace("*SELECT_ITEM*","SELECTED");
			else txt_item = txt_item.replace("*SELECT_ITEM*","");
			txt_item = txt_item.replace("*ITEM_NAME*",temparray[1]);
			temp += txt_item;
		}
		txt_bodyI = txt_bodyI.replace("*SHOW_I*",temp);
	} else {
		txt_bodyI =txt_bodyI.replace("*SHOW_I*","");
	}
	sel_items.innerHTML=txt_bodyI;
}</script>
<script>
//-------------------onmouse over out變色---------------------------------
//if(top.uid=="" || self==top || top.document.domain!=document.domain){ top.location="http:/"+"/"+document.domain;}
var bgclass="";
var futrue="";
var GameFT=new Array();
var gidx=new Array();
parent.records=40;
var Npages=1;
var rang=0;
var choice="";
 
function mouseover_pointer(mouseTR){
	//alert("11111111");
	bgclass=mouseTR.bgColor;
	//mouseTR.className='tr_over';
	trid=(mouseTR.id).replace("C","");
	eval("document.getElementById('"+trid+"').bgColor='gold'");
	try{
	eval("document.getElementById('"+trid+"C').bgColor='gold'");
	}catch(E){}
}
 
function mouseout_pointer(mouseTR){
	if (bgclass!="")
		{
		//mouseTR.className=bgclass;
		trid=(mouseTR.id).replace("C","");
		eval("document.getElementById('"+trid+"').bgColor='"+bgclass+"'");
		try{
			eval("document.getElementById('"+trid+"C').bgColor='"+bgclass+"'");
		}catch(E){}
	}
}
/*
---------------reload time------------------
*/
var ReloadTimeID="";
function set_reloadtime()
{
	 reloadtime();
}
function reloadtime(){
	
	//reloadPHP.location.href='reloadgame_'+Showtypes+".php?uid="+top.uid+"&langx="+top.langx+"&mid="+top.mid;
	parent.sel_item="";
	reloadPHP.location.href='reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam();
	setrefesh();
	
}
function setrefesh(){
	//alert("reladtime-------"+top.retime);
	clearInterval(ReloadTimeID);
	if ((""+parent.retime=="undefined") || parent.retime=="") parent.retime="X";
	if (parent.retime != 'X' ){ReloadTimeID = setInterval("reload_var()",parent.retime*1000);}
	}
function reload_var(){	
	//document.getElementById('forms').reset();
	//reloadPHP.location.href='reloadgame_'+Showtypes+".php?uid="+top.uid+"&langx="+top.langx+"&mid="+top.mid;
	reloadPHP.location.href='reloadgame_'+Showtypes+".php?mid="+parent.mid+"&"+get_pageparam();
	
}
/*
----------------功能menu--------------
*/
//function change_game(gtype,vals,gid)
//{
//if ((gtype=="gopen" || gtype=="strong") && (vals!="all"))
//	a=confirm(eval("str_"+gtype+vals));
//else a=true;
//if (a==true){
//	alert('FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&"+get_pageparam());
//	self.location.href='FT_Game_change.php?gid='+gid+"&"+gtype+"="+vals+"&ShowType="+Showtypes+"&"+get_pageparam();
//	}
//}
/*
 公用 FUNC
*/
function printf(vals,points){ //小數點位數
	vals=""+vals;
	var cmd=new Array();
	cmd=vals.split(".");
	if (cmd.length>1){
		for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
	}else{
		vals=vals+".";
		for (ii=0;ii<points;ii++)vals=vals+"0";
	}
	return vals;
}
function get_timer(){return (new Date()).getTime();} // 計數器
/*
鍵盤
*/
document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){
	}
}
 
function CheckKey(){
	if(event.keyCode == 13) return true;
	if (event.keyCode!=46){
		if((event.keyCode < 48 || event.keyCode > 57))
		{
			alert(top.str_only_keyin_num);	/*僅能接受數字!!*/
			return false;
		}
	}
}
/*
parser 球頭
*/
function get_cr_str(cr){
	var crs=new Array();
	var word ="";
	if (cr.indexOf("+")>0) {	
		crs=cr.split("+");		
		if(crs[0]=="0"){
			if(crs[1]=="0") word = crs[1].replace('0',top.str_ratio[0]);
		}else{
			switch(crs[1]){
				case '100':
					//alert(cr);
					if(crs[0]*1==1){
						word =top.str_ratio[1];
					}else{	
						
						word =""+(crs[0]*1 - 0.5);
						
						word = word.replace('.5',top.str_ratio[2]);	
					}
				break;
				case '50':
					if(crs[0]*1==1){
						word =top.str_ratio[1]+"&nbsp;/&nbsp;"+crs[0]+top.str_ratio[3];
					}else{	
						word =(crs[0]*1 - 0.5)+"&nbsp;/&nbsp;"+crs[0]+top.str_ratio[3];
						word = word.replace('.5',top.str_ratio[2]);
					}
				break;
				case '0':
					word = crs[0]+top.str_ratio[3];
				break;
			}
		}	
	}
	
	if (cr.indexOf("-")>0) {
		crs=cr.split("-");
		crs[1]="-"+crs[1];
		if(crs[0]=="0")	word = top.str_ratio[0]+"&nbsp;/&nbsp;"+top.str_ratio[1];
		else{
			word =crs[0]+top.str_ratio[3]+"&nbsp;/&nbsp;"+(1+crs[0]*1 - 0.5);
			word = word.replace('.5',top.str_ratio[2]);
		}
		
	}
	if(word=="") return cr;
	return word;
}
 
function get_ou_str(cr){
	
	var crs=new Array();
	var word ="";
	if (cr.indexOf("+")>0) {	
		crs=cr.split("+");		
		if(crs[0]=="0"){
			if(crs[1]=="0") word = crs[1];
			if(crs[1]=="50") word = crs[0]+" / "+(crs[0]*1+1 - 0.5);
		}else{
			switch(crs[1]){
				case '100':
					word =crs[0]*1 - 0.5;	
				break;
				case '50':
					word =(crs[0]*1 - 0.5)+"&nbsp;/&nbsp;"+crs[0];
				break;
				case '0':
					word =crs[0];
				break;
			}
		}	
	}
	
	if (cr.indexOf("-")>0) {
		crs=cr.split("-");
		crs[1]="-"+crs[1];
		word =crs[0]+"&nbsp;/&nbsp;"+(1+crs[0]*1 - 0.5);
	}
	
	
	if(word=="")return cr;
	return word;
}
function  change_time(get_time){
	var dates=get_time.split(" ");
	if (dates.length>1) get_time=dates[1]; 
	gtime=get_time.split(":");
	if (gtime[0]>12){
		return dates[0].substring(5,10) + "<br>" +(gtime[0]*1-12)+":"+gtime[1]+"p";		
	}else if(gtime[0] == 12){
		return dates[0].substring(5,10) + "<br>" +gtime[0]+":"+gtime[1]+"p";
	}
	
	return dates[0].substring(5,10) + "<br>" +gtime[0]+":"+gtime[1]+"a";
}
/*
設定分頁
*/
function setpage(){
	
	//document.getElementById('times').innerHTML=nowtime;
	
	var pagehtml="";	
	
	if (""+top.pages=="undefined") top.pages=1;
	if (top.pages<=1) top.pages=1;
	
		if (gamount<=(top.records*(top.pages-1))) top.pages=1;
	
	for (cc=1;cc<=(Math.floor(gamount/top.records)+1);cc++){
		if (top.pages==cc)
			pagehtml+=" <font color=red>"+cc+"</font>";
		else
		 pagehtml+=" <font style='cursor:hand' onclick=change_page('"+cc+"')>"+cc+"</font> ";
		}
		
	document.getElementById('pages').innerHTML=pagehtml;
	}
function change_page(pages){
	top.pages=pages;
	
	homepage="reloadgame_"+Showtypes+".php?"+get_pageparam();
	//alert(homepage);
	reloadPHP.location.href=homepage;
	}
function show_xy(){
	try{
	if (rs_window.style.visibility=="visible"){
			top_y=document.body.scrollTop;
			rs_window.style.top=top_y+200;
			}
	}catch(E){}
}
function show_layer(showlayer,scrollY){
 
	try{
	if (eval(showlayer+".style.visibility=='visible'")){
			top_y=document.body.scrollTop;
			eval(showlayer+".style.top=top_y+"+scrollY);
			}
	}catch(E){}
}
 
 
function change_showtype(){	
	top.pages=1;	
	ptypes=document.getElementById('ptype').options[document.getElementById('ptype').selectedIndex].value;	
	homepage="loadgame_"+ptypes+".php?"+get_pageparam();
	//alert(homepage);
	window.location.href=homepage;
	}
function show_showRecord()
{
	if (""+top.records=="undefined") top.records=-1;
	 j=0;
	 for(i=0;i<document.getElementById('showRecord').length;i++){
			if(document.getElementById('showRecord').options[i].value==top.records) document.getElementById('showRecord').selectedIndex=j;
			j++;
			}  
	
	
}
function set_showRecord()
{
	top.pages=1;
	top.records=document.getElementById('showRecord').options[document.getElementById('showRecord').selectedIndex].value;
	homepage="loadgame_"+Showtypes+".php?"+get_pageparam();
	window.location.href=homepage;
}
function countdown(){
	if (keepsec!=""){
		if (Showtypes=="P1"||Showtypes=="P2"||Showtypes=="P3"){
			reload_time.innerHTML=keepsec+"&nbsp"+top.str_sec+top.str_auto_upgrade+"&nbsp"+"--"+par_min+"~"+par_max;
		}else{
			reload_time.innerHTML=keepsec+"&nbsp"+top.str_sec+top.str_auto_upgrade+"&nbsp";
		}
		keepsec--;
	}
}
 
var keepsec="";
cc=setInterval("countdown()",1000);
function init(){
	if ((parent.LegGame=="") || (""+parent.LegGame=='undefined')) parent.LegGame="ALL";
}
 
function get_pageparam(){
	if (choice=="") choice="ALL";
	if (!parent.LegGame) parent.LegGame="";
	if (!parent.pages) parent.pages=1;
	if (!parent.records) parent.records=-1;
	if ((parent.sel_item=="") || (""+parent.sel_item=="undefined"))parent.sel_item="";
	if ((parent.sel_area=="") || (""+parent.sel_area=="undefined"))parent.sel_area="";
	return parent.base_url+"choice="+choice+"&LegGame="+parent.LegGame+"&pages="+parent.pages+"&records="+parent.records+"&FStype="+FStype+"&area_id="+parent.sel_area+"&item_id="+parent.sel_item+"&rtype="+parent.rtype;
}
 
function getpararm(se){
	gtype="FS";
	param=parent.uid+","+gtype+","+se;
	return param;
}
function getpararmP(){
	gtype="FS";
	param=parent.uid+","+gtype;
	return param;
}
function lostFocus(thisButton){
	thisButton.blur();
}</script>
<script> 
var FStype='';
parent.uid='<?=$uid?>';
parent.rtype='<?=$rtype?>';
parent.username='<?=$username?>';
parent.langx='<?=$langx?>';
parent.base_url='uid=<?=$uid?>&langx=<?=$langx?>';
parent.mid='4430382';
</script></head>
 
<body id="MNFS" onLoad="set_reloadtime();" style="height:510px;">
 
<table border="0" cellpadding="0" cellspacing="0" id="box">
    <tr>
    <td id="ad">
      <span id="real_msg"></span>
	  <p><a href="javascript://" onClick="javascript: window.open('../scroll_history.php?uid='+parent.uid+'&langx='+parent.langx+'','','menubar=no,status=yes,scrollbars=yes,top=150,left=200,toolbar=no,width=510,height=500')"><?=$News_History?></a></p>	</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
		<td class="top">
  	  <h1><span id="tmp_TMP_ITEM"></span><input type="button" name="Submit323" value="<?=$Refresh?>" class="new" onClick="javascript:reload_var()">
  	 <span class="rig">區域:<span id=sel_areas></span></span></h1>
	</td>
          <!--td class="b_title_left"></td>
          <td width="80" align="left">冠軍</td>
          <td><input type="button" value="更新" onClick="reload_var()"</td-->
          <!--<td><input type="button" value="更新" onClick="reload_var()">&nbsp;&nbsp;頁次:&nbsp;<span id=pages class="page"></span></td>-->
	  	  <!--td>區域:<span id=sel_areas></span></td>
          <td>選擇聯盟:<span id=sel_leg></span></td>
          <td class="b_title_right"></td-->
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="mem">
	<h2><div class="rig"><span class="left">選擇類別:</span><span id=sel_items></span></div></h2>
	<div id=showgames></div></td>
  </tr>
  <tr><td id="foot"><b>&nbsp;</b></td></tr>
</table>
 
<div id=showlayers style="display: none">
<table id="glist_table"  border="0" cellpadding="0" cellspacing="1" class="game" >
  <tr>
    <th class="time"><?=$Times?></th>
    <th >項目</th>
     <th width="400">隊伍(球員)</th>
    <th  width="60">賠率</th>
  </tr>
   *ShowGame*
</table>
</div>
 
 
<div id="glist" style="display: none">
 
<tr *ST*>
	<td  nowrap colspan=4 class="b_hline_nfs">*LEG*</td>
</tr>
<tr id="TR*GID*" *CLASS* style="display: none">
    <td nowrap class="b_cen">*TIME*</td>
	<td nowrap class="b_cen" >*ITEM*</td>
    <td nowrap class="b_cen" colspan=2 cellpadding=0 cellspacing=0>*TEAM*</td>
</tr>
 
</div>
<!----------------------更改下拉視窗---------------------------->
<!--區域 START-->
<span id="area" style="position:absolute; display: none">
	<option value="*AREA_ID*" *SELECT_AREA*>*AREA_NAME*</option>
</span>
<span id="bodyA" style="position:absolute; display: none">
	<select id="sel_aid" name="sel_aid" onChange="chg_area();" class="za_select">
	<option value="">全部</option>
		*SHOW_A*
	</select>
</span>
<!--區域 END-->
 
<!--類別 START-->
<span id="item" style="position:absolute; display: none">
	<option value="*ITEM_ID*" *SELECT_ITEM*>*ITEM_NAME*</option>
</span>
<span id="bodyI" style="position:absolute; display: none">
	<select id="sel_itemid" name="sel_itemid" onChange="chg_item();" class="za_select">
	<option value="">全部</option>
		*SHOW_I*
	</select>
</span>
<!--類別 END-->
 
 
<iframe id=reloadPHP name=reloadPHP width=0 height=0 ></iframe>
</body>
</html>
<!--<div id="copyright">
    版權所有 皇冠 建議您以 IE 5.0 800 X 600 以上高彩模式瀏覽本站&nbsp;&nbsp;<a id=download title="下載" href="http://www.microsoft.com/taiwan/products/ie/" target="_blank">立刻下載IE</a>
</div>-->
<div id="copyright"><?=$Copyright?></div>

