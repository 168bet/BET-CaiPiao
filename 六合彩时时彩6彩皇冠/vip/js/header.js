<!--
function onloaded() {
	if (top.casino != "SI2") {
		document.getElementById("live").style.display = "none";
		document.getElementById("QA_row").style.display = "none";
	}
	try{
		if ((navigator.appVersion).indexOf("MSIE 6")==-1){
			document.getElementById("download").style.visibility="visible";
		}
	}catch(E){}
	showTable();
}
function chg_type(a,b,c){
	//eval("top."+c+"_mem_index").body.location=a+"&league_id="+b;
	if(top.swShowLoveI)b=3;
	if(top.showtype=='hgft')b=3;
	parent.body.location=a+"&league_id="+b;
}
function chg_index(a,b,c){
	top.swShowLoveI=false;
	top.getNewGtype = a;
	parent.location=a+"&league_id="+b;
}

/* 流程 SetRB ---> reloadRB --->  showLayer */

/*滾球提示--將值帶進去去開啟getrecRB.php程式,去抓取伺服器是否有滾球賽程*/
var record_RB = 0;
function reloadRB(gtype,uid){
	reloadPHP.location.href="./getrecRB.php?gtype="+gtype+"&uid="+top.uid;
}

/*滾球提示--將getrecRB.php的結果帶進去,去判斷是否record_RB是否大於0,如果有會顯示滾球圖示*/

function showLayer(record_RB){
	if (record_RB > 0) {
		document.getElementById('extra1').style.display='block';
	}else{
		document.getElementById('extra1').style.display='none';
	}
}

/* 滾球提示--程式一開始值呼叫reloadRb,setInterval函式 多久會呼叫reloadRB函數預設 5分鐘 */
function SetRB(gttype,uid){
	reloadRB(gttype,top.uid);
	setInterval("reloadRB('"+gttype+"','"+top.uid+"')",5*60*1000);
}
function  getdomain(){
	var a = new Array();
	a[0]= document.domain;
	ESTime.setdomain(a);
	return a;
}
function OnMouseOverEvent() {
	document.getElementById("informaction").style.display = "block";
}
function OnMouseOutEvent() {
	document.getElementById("informaction").style.display = "none";
}

function Go_Chg_pass(){
	Real_Win=window.open("./account/chg_passwd.php?uid="+top.uid,"Chg_pass","width=360,height=166,status=no");
}
function OpenLive(){
	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}
	window.open("./live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid,"Live","width=780,height=580,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
}

function showTable(){
	 showGtypeTable();
	
}

function showGtypeTable(){
	for (var i=0 ; i < showGtype.length ; i++){
		var txtnum = StatisticsGty(top.today_gmt,showGtype[i]);	
		var gtypenum =(txtnum[0] == 0)?"_2":"";		
		document.getElementById("img_"+showGtype[i]).src ="../../../images/member/head_L"+showGtype[i]+gtypenum+".gif";	
		document.getElementById("img_"+showGtype[i]).title =	eval("top.str_"+showGtype[i]);
		document.getElementById("img_"+showGtype[i]).style.cursor =((txtnum[0] == 0)?"":"hand");
		document.getElementById("imp_"+showGtype[i]).title =top.str_delShowLoveI;
	}
}


function chkLookGtypeShowLoveI(getgtype,gtype){
	var txtnum = StatisticsGty(top.today_gmt,gtype);	
	if(txtnum[0]==0)return ;
	top.swShowLoveI =true;
	if(getgtype != top.getNewGtype ){
		top.getNewGtype =getgtype;		
		parent.location=getgtype+"&league_id=3";
	}else{
		eval("parent."+gtype+"_lid_type='3'");
		//parent.body.ShowGameList();
		//alert(parent.body.pg);
		parent.body.pg =0;
		parent.body.body_browse.reload_var("up");
	}
}
function chkDelAllShowLoveI(getGtype){
	top.ShowLoveIarray[getGtype]= new Array();
	top.ShowLoveIOKarray[getGtype]="";
	if(top.swShowLoveI){
		top.swShowLoveI=false;
		eval("parent."+parent.body.sel_gtype+"_lid_type=top."+parent.body.sel_gtype+"_lid['"+parent.body.sel_gtype+"_lid_type']");
		parent.body.pg =0;
		parent.body.body_browse.reload_var("up");
	}else{
		parent.body.ShowGameList();
	}
	showTable();
	parent.body.body_browse.futureShowGtypeTable();
}
function mouseEnter_pointer(tmp){
	try{
		var tmp1 = tmp.split("_")[1];
		var txtnum = top.ShowLoveIarray[tmp1].length;
		if(txtnum !=0)
			document.getElementById(tmp).style.display ="block";
	}catch(E){}
}

function mouseOut_pointer(tmp){
	try{
	document.getElementById(tmp).style.display ="none";
	}catch(E){}
}
try{
	showGtype = top.gtypeShowLoveI;
	var xx=showGtype.length;
}catch(E){
	initDate();
	showGtype = top.gtypeShowLoveI;
}
//top.swShowLoveI=false;
//window.onscroll =chkscrollShowLoveI;
function initDate(){
	
	top.gtypeShowLoveI =new Array("FT","BK","BS","TN","VB","OP");
	top.ShowLoveIarray = new Array();
	top.ShowLoveIOKarray = new Array();
	for (var i=0 ; i < top.gtypeShowLoveI.length ; i++){
		top.ShowLoveIarray[top.gtypeShowLoveI[i]]= new Array();
		top.ShowLoveIOKarray[top.gtypeShowLoveI[i]]= new Array();
	}
}
function StatisticsGty(today,gtype){
	var array =new Array(0,0);
	var tmp =today.split("-");
	var newtoday =tmp[1]+"-"+tmp[2];
	var tmpgday = new Array(0,0);
	var bf = false;
	for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
		tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];
		tmpgday = tmpday.split("-");
		if(++tmpgday[0] < tmp[1]){ 
			bf = true;
		}else{
			bf = false;
		}
		if(bf){
			array[1]++;
		}else{
			if(newtoday >= tmpday ){
				array[0]++;	//單式	
			}else if(newtoday < tmpday){
				array[1]++;	//早餐
			}
		}
	}
	return array;
}
function hrefs(){
	window.open("./getVworld.php?langx="+top.langx+"&uid="+top.uid,"Vworld","width=780,height=580,top=0,left=0,status=no,toolbar=no,scrollbars=yes,resizable=no,personalbar=no");
}
-->
