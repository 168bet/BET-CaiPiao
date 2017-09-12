var AutoRenewID;
var ChkUserTimerID;
var ChkUserTime = 10;
var ReloadTime = 60;
var TimerID = 0;
var gamedate = "";
var T_color_h = "";
var T_color_c = "";
var Livegtype ="";
var Livegidm ="";
var gameAry = new Array("FT","BK","TN","VB");
var pages='TVbut';
function onload() {
	chg_page();
	onloadGame();
	reloadioratio();
}
function reloadioratio(){
	
	//document.getElementById("right_div").style.display = "block";
	
	mem_order.self.location =o_path;
	Live_mem.self.location  = "./game_ioratio_view.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+Livegtype+"&gidm="+Livegidm+"&gdate="+document.getElementById("gdate").value;
}
function onloadGame(){
	var tmp_opt = "";
	//====== 處理球類選單
	tmp_opt = "<option value='All' selected>"+top.str_game_list+"</option>\n";
	for (var i = 0; i < gameAry.length; i++) {
		tmp_opt+= "<option value='"+gameAry[i]+"'>"+eval("top.str_"+gameAry[i])+"</option>\n";
	}
	tmp_opt = "<select id=\"gameOpt\" name=\"gameOpt\" onChange=\"chggype()\" class=\"select\">\n"+tmp_opt+"</select>";
	document.getElementById("game_type").innerHTML = tmp_opt;

	//====== 處理日期選單
	tmp_opt = "";
	for (i = 0; i < GameDate.length; i++) {
		tmp_opt+= "<option value='"+GameDate[i]+"'>"+GameDate[i]+"</option>\n";
	}
	tmp_opt = "<select id=\"gdate\" name=\"gdate\" onChange=\"chggdate()\">\n"+tmp_opt+"</select>";
	document.getElementById("date_list").innerHTML = tmp_opt;
	document.getElementById("alone_btn").alt = top.str_alone;

	//====== 讀取賽程
	document.getElementById("gameOpt").value = "FT";
	Livegtype ="FT";
	reloadGame();
	StartChkTimer();
	if (videoData != "") {
		document.getElementById("DemoLink").style.display = "none";
		registLive.self.location = "./RegistLive.php?uid="+uid+"&langx="+langx+"&gameary="+videoData+"&liveid="+mtvid;
	}
}

function chggype(){
	var gameOpt =document.getElementById("gameOpt").value;
        Livegtype =gameOpt;
	reloadGame();
	reloadioratio();

}
function chggdate(){

	reloadGame();
	reloadioratio();
}
function reloadGame() {
	clearInterval(AutoRenewID);
	TimerID = 0;
	reloadgame.self.location = "./game_list.php?uid="+uid+"&langx="+parent.top.langx+"&gtype="+Livegtype+"&gdate="+document.getElementById("gdate").value;
}

function ResetTimer() {
	document.getElementById("timer_str").innerHTML = ReloadTime+"&nbsp;"+top.str_second;
	AutoRenewID = setInterval("RenewTimerStr()",1000);
}
function RenewTimerStr() {
	document.getElementById("timer_str").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+top.str_second;
	if ((ReloadTime - TimerID) <= 1) {
		TimerID = 0;
		reloadGame();
	} else {
		TimerID++;
		var tmp = (ReloadTime - TimerID);
		if (tmp < 10) { tmp = "&nbsp;&nbsp;"+tmp; }
		document.getElementById("timer_str").innerHTML = tmp+"&nbsp;"+top.str_second;
	}
}

function independent() {
	if (document.getElementById("top_div").style.display == "none") {	//取消獨立顯示
		document.getElementById("top_div").style.display = "block";
		document.getElementById("right_div").style.display = "block";
		document.getElementById("table_Live_order").style.display = "block";
		
		document.getElementById("alone_btn").alt = top.str_alone;
		if (document.all) { // IE
		    window.resizeTo(791,640);
		} else { // NETSCAPE
		    window.outerHeight = 640;
		    window.outerWidth = 791;
		}
	} else {	//獨立顯示
		if (document.all) { // IE
		    window.resizeTo(510,570);
		} else { // NETSCAPE
		    window.outerHeight = 570;
		    window.outerWidth = 510;
		}
		//document.getElementById("right_div").style.display = "none";
		chg_page(pages);
		document.getElementById("top_div").style.display = "none";
		document.getElementById("alone_btn").alt = top.str_back;
	}
}

//====== 啟動 user 定時檢查計時器
function StartChkTimer() {
	clearInterval(ChkUserTimerID);
	ChkUserTimerID = setInterval("ChkUid('"+mtvid+"','"+eventid+"')",ChkUserTime * 60 *1000);
}

//=== 檢查 user id
function ChkUid(id, gid) {
	try{
		reloadPHP.self.location = "./chk_registid.php?uid="+uid+"&langx="+parent.top.langx+"&regist_id="+id+"&liveid="+window.opener.top.liveid+"&gid="+gid;
	} catch (E) {
//alert("./chk_registid.php?uid="+uid+"&langx="+parent.top.langx+"&regist_id="+id+"&liveid="+window.opener.top.liveid+"&gid="+gid);
		self.location = "http://"+document.domain;
	}
}

function send_result(datas) {
	var tmp = datas.split(",");
	if (tmp.length <= 1) {
		tmp[0] = datas;
	}
	if (tmp[0] == "false") {
		self.location.reload();
	}
	if (tmp.length > 1) {
		SetClothesColor(tmp[1], tmp[2]);
	}
}

//=== QA
function GoToQAPage() {
	window.open("/tpl/member/"+langx+"/QA.html","LiveQA","width=720,height=600,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=yes,personalbar=no");
}

function ShowVideo() {
	var swf_name = "liveTV_"+langx.substring(3)+".swf";
	var swf_str = "<object id=\"liveTV\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\""+
	              "width=\"480\" height=\"410\" codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab#version=9,0,124,0'>"+
	              "<param name=\"movie\" value=\""+swf_name+"\" />"+
	              "<param name=\"quality\" value=\"high\" />"+
	              "<param name=\"bgcolor\" value=\"#1C0D00\" />"+
	              "<param name=\"allowScriptAccess\" value=\"sameDomain\" />"+
	              "<embed name=\"liveTV\" id=\"liveTV\" src=\""+swf_name+"\" quality=\"high\" bgcolor=\"#1C0D00\""+
	                  "width=\"480\" height=\"410\" align=\"middle\""+
	                  "play=\"true\""+
	                  "loop=\"false\""+
	                  "quality=\"high\""+
	                  "allowScriptAccess=\"sameDomain\""+
	                  "type=\"application/x-shockwave-flash\""+
	                  "pluginspage='http://www.adobe.com/go/getflashplayer'>"+
	              "</embed>"+
	          "</object>";
	videoFrame.innerHTML = swf_str;
	videoFrame.style.display = "block";
	document.getElementById("FlahLayer").style.display = "block";
	document.getElementById("video_msg").style.display = "block";
	document.getElementById("DemoImgLayer").style.display = "none";
	document.getElementById("demo_msg").style.display = "block";
	document.getElementById("demo_msg").innerHTML = "<font class='mag_info'>"+top.str_demo+"</font>";
}

//=== 傳遞參數
function appInit() {
	liveTV.FLashFunction(langx);
}

window.onbeforeunload = unload_swf;
function unload_swf() {
	var obj=document.getElementById("liveTV");
	try {
		obj.unloadSWF();
	} catch (e) {}
	for (var x in obj){
		try{
			obj[x]=null;
		}catch(e){}
	}
}

function unLoad() {
	clearInterval(AutoRenewID);
	clearInterval(ChkUserTimerID);
}
/**
 * 賽程列表
 */
function reload_game() {
	var shows = document.getElementById("tb_layer").innerHTML;
	var tr_data = "";
	for (var i = 0; i < GameData.length; i++) {
		tr_data+= showlayer(document.getElementById("tr_layer").innerHTML,i)+"\n";
	}
	shows = shows.replace("*GAMEDATE*",gamedate);
	shows = shows.replace("*GAMELIST*",tr_data);
	showlayers.innerHTML = shows;
	parent.ResetTimer();
}

function showlayer(layers,i){
	if (GameData[i][6] == "Y") {	//判斷是否開賽
		layers = layers.replace("*ID*",i);
		layers = layers.replace("*STYLE*","style='cursor:hand'");
		layers = layers.replace("*STYLE_TIME*","time");
		layers = layers.replace("*STYLE_GTYPE*","gtype");
		layers = layers.replace("*STYLE_TEAM*","team");
	} else {
		layers = layers.replace("*ID*","");
		layers = layers.replace("*STYLE*","");
		layers = layers.replace("*STYLE_TIME*","time_2");
		layers = layers.replace("*STYLE_GTYPE*","gtype_2");
		layers = layers.replace("*STYLE_TEAM*","team_2");
	}
	if (GameData[i][5] == "Y" && GameData[i][6] == "Y") {	//判斷是否為熱門賽
		layers = layers.replace("*HOT_PIC*","<img src='/images/member/hot_1.gif' class=\"hot\">");
	} else if (GameData[i][5] == "Y") {
		layers = layers.replace("*HOT_PIC*","<img src='/images/member/hot_2.gif' class=\"hot\">");
	} else {
		layers = layers.replace("*HOT_PIC*","");
	}
	layers = layers.replace("*GTYPE*",eval("top.str_"+GameData[i][0]));
	layers = layers.replace("*TIME*",GameData[i][2]);
	layers = layers.replace("*TEAMH*",GameData[i][3]);
	layers = layers.replace("*TEAMC*",GameData[i][4]);
	layers = layers.replace("*LEAGUE*",GameData[i][9]);
	return layers;
}

function OpenTV(i) {
	if (videoFrame.style.display == "block") {
		videoFrame.style.display = "none";
		document.getElementById("DemoImgLayer").style.display = "block";
		document.getElementById("FlahLayer").style.display = "none";
		document.getElementById("demo_msg").style.display = "none";
		unload_swf();
	}
	document.getElementById("DemoLink").style.display = "none";
	if (i == "") { return false; }
	eventid = GameData[i][1];
	StartChkTimer();
	videoData = GameData[i][1]+","+GameData[i][3]+","+GameData[i][4]+","+GameData[i][9]+","+GameData[i][7]+","+GameData[i][8];
	registLive.self.location = "./RegistLive.php?uid="+uid+"&langx="+langx+"&gameary="+GameData[i][1]+"&liveid="+mtvid;
	Livegtype= GameData[i][0];
	Livegidm = GameData[i][10];
	chg_page('BEbut');
	reloadioratio();
}

function GetVideo(vurl) {
	if (vurl != "") {
		var tmp = videoData.split(",");
		document.getElementById("DefLive").src = vurl;
		document.getElementById("DefLive").style.display = "block";
		document.getElementById("video_msg").style.display = "block";
		document.getElementById("FlahLayer").style.display = "block";
		document.getElementById("DemoImgLayer").style.display = "none";
		//=== 隊名
		SetClothesColor(tmp[4], tmp[5]);
		document.getElementById("league").innerHTML = tmp[3]+"<BR>";
		document.getElementById("team").innerHTML = tmp[1]+"&nbsp;&nbsp;VS&nbsp;&nbsp;"+tmp[2];
		document.getElementById("video_msg").style.display = "block";
	}
}
function SetClothesColor(color_h, color_c) {
	if (color_h == "") { document.getElementById("team_h").style.display = "none"; }
	if (color_c == "") { document.getElementById("team_c").style.display = "none"; }
	if (T_color_h != color_h && color_h != "") {
		T_color_h = color_h;
		document.getElementById("team_h").src = "/images/member/T_"+T_color_h+".gif";
		document.getElementById("team_h").style.display = "block";
	}
	if (T_color_c != color_c && color_c != "") {
		T_color_c = color_c;
		document.getElementById("team_c").src = "/images/member/T_"+T_color_c+".gif";
		document.getElementById("team_c").style.display = "block";
	}
}

function chg_page(tmppage){
	if(tmppage =='TVbut'){		
		document.getElementById("table_Live_order").style.display = "none";
		document.getElementById("right_div").style.display = "block";
		document.getElementById("BEbut").src ="/images/member/"+langx+"/live_BEbut3.gif";
		document.getElementById("TVbut").src ="/images/member/"+langx+"/live_TVbut.gif";
		document.getElementById("mem_order").height =document.frames("mem_order").document.body.scrollHeight+5;
		document.getElementById("Live_mem").height =document.frames("Live_mem").document.body.scrollHeight+5;
	}else if(tmppage =='BEbut'){
		document.getElementById("table_Live_order").style.display = "block";
		document.getElementById("right_div").style.display = "none";
		document.getElementById("BEbut").src ="/images/member/"+langx+"/live_BEbut.gif";
		document.getElementById("TVbut").src ="/images/member/"+langx+"/live_TVbut3.gif";
		document.getElementById("mem_order").height =document.frames("mem_order").document.body.scrollHeight+5;
		document.getElementById("Live_mem").height =document.frames("Live_mem").document.body.scrollHeight+5;
	}else{
		document.getElementById("table_Live_order").style.display = "none";
		document.getElementById("right_div").style.display = "block";
		document.getElementById("BEbut").src ="/images/member/"+langx+"/live_BEbut3.gif";
		document.getElementById("TVbut").src ="/images/member/"+langx+"/live_TVbut.gif";
		document.getElementById("mem_order").height =document.frames("mem_order").document.body.scrollHeight+5;
		document.getElementById("Live_mem").height =document.frames("Live_mem").document.body.scrollHeight+5;
	}
}


function mouseEnter_pointer(tmp){
	try{
		//document.getElementById(tmp).src ="block";
	}catch(E){}
}

function mouseOut_pointer(tmp){
	try{
		//document.getElementById(tmp).src ="none";
	}catch(E){}
}


function live_order_height(tmppage){
	var tmp ="";
	//alert(tmppage);
	tmp =tmppage;//document.frames("mem_order").document.body.scrollHeight; 
	tmp +=5;
	document.getElementById("mem_order").height = 0;
	document.getElementById("mem_order").height = tmp;
	document.getElementById("mem_order").width = 300;
	document.body.scrollTop =0;
}

function live_game_heigth(){
	tmpEnd =document.frames("Live_mem").document.body.scrollHeight+5; 	
	document.getElementById("Live_mem").height=tmpEnd;
}
