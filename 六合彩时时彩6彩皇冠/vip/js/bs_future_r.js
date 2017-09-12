<!--
var ReloadTimeID='';

function onLoad(){
	if (""+parent.BSFU_lname_ary=="undefined") parent.BSFU_lname_ary="ALL";	
	if (""+parent.BSFU_lid_ary=="undefined") parent.BSFU_lid_ary="ALL";
	if (""+parent.sel_gtype=="undefined") parent.sel_gtype='BSFU';
	if (parent.ShowType=="") parent.ShowType = 'OU';
	if (parent.parent.leg_flag=="Y"){
		parent.parent.leg_flag="N";
		parent.pg=0;
		reload_var();
	}		
	parent.loading = 'N';
	if(parent.loading_var == 'N'){
		parent.ShowGameList();
		obj_layer = document.getElementById('LoadLayer');
		obj_layer.style.display = 'none';
	}
	if (parent.retime_flag == 'Y'){
		ReloadTimeID = setInterval("reload_var()",parent.retime*1000);
	}
	//賽事分日期
	var date_opt = "";
	date_opt = "<select id=\"g_date\" name=\"g_date\" onChange=\"chg_gdate()\">";
	//if(parent.g_date=="ALL"){
		date_opt+= "<option value=\"ALL\" selected>"+top.alldata+"</option>";
		if (rtype == "r") {
			date_opt+= "<option value=\"1\" >"+top.S_EM+"</option>";
		}
//	}else{
//		date_opt+= "<option value=\"ALL\" >"+top.alldata+"</option>";
//		if (rtype == "r") {
//			date_opt+= "<option value=\"1\"  selected>"+top.S_EM+"</option>";
//		}
//	}

	for (i = 0; i < DateAry.length; i++) {
		date_opt+= "<option value=\""+DateAry[i]+"\" >"+DateAry[i]+"</option>";
	}
	date_opt+= "</select>";
	//alert("date_opt===>"+date_opt);
	document.getElementById("show_date_opt").innerHTML = date_opt;  
	futureShowGtypeTable();  		
}

//倒數自動更新時間
function count_down(){
	setTimeout('count_down()',1000);
	if (parent.retime_flag == 'Y'){
		if(parent.retime <= 0){
			if(parent.loading_var == 'N')
			reload_var();
			return;
		}
		parent.retime--;
		obj_cd = document.getElementById('cd');
		obj_cd.innerHTML = parent.retime;
	}
}

function reload_var(Level){
	parent.loading_var = 'Y';
	if(Level=="up"){
		var tmp = "./BS_future/body_var.php";
	}else{
		var tmp = "./body_var.php";
	}
	//parent.body_var.location.reload();
	parent.body_var.location = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&g_date="+parent.g_date+"&league_id="+parent.parent.BSFU_lid_type;
	document.all.line_window.style.visibility='hidden';
	//onload();

}

//切換日期
function chg_gdate(){
	var obj_gdate = document.getElementById("g_date");
	var homepage = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&g_date="+obj_gdate.value+"&mtype="+parent.ltype+"&league_id="+parent.parent.BSFU_lid_type;
	//alert(homepage);
	parent.pg=0;
	parent.body_var.location = homepage;
}

//賽事換頁
function chg_pg(pg){
	if (pg==parent.pg) {return;}
	parent.pg=pg;
	parent.loading_var = 'Y';
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&g_date="+parent.g_date;
	//onload();
}
function show_more(gid){

	document.all.line_window.style.position='absolute';
	document.all.line_window.style.top=document.body.scrollTop+event.clientY+12;
	document.all.line_window.style.left=document.body.scrollLeft+5;
	//document.body.scrollTop = document.body.scrollTop - event.clientY-20;
	line_form.gid.value=gid;
	line_form.uid.value=parent.uid;
	line_form.ltype.value=parent.ltype;
	line_form.submit();
}
function show_detail(){
	show_team = document.getElementById("table_team");
	show_pd = document.getElementById("table_pd");
	show_t = document.getElementById("table_t");
	//show_f = document.getElementById("table_f");
	parent.ShowData_Other(show_team,show_pd,show_t,GameOther,top.odd_f_type);
	document.all.line_window.style.visibility='visible';
	document.all.line_window.focus();
}
function unload(){
	clearInterval(ReloadTimeID);
}
window.onunload=unload;
//-->