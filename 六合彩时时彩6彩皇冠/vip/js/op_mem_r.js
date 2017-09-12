<!--
var ReloadTimeID;
function onLoad(){
	if (""+parent.OP_lname_ary=="undefined") parent.OP_lname_ary="ALL";	
	if (""+parent.OP_lid_ary=="undefined") parent.OP_lid_ary="ALL";
	if (""+parent.sel_gtype=="undefined") parent.sel_gtype='OP';
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

function reload_var(Level) {
	parent.loading_var = 'Y';
	//parent.body_var.location.reload();
	if(Level=="up"){
		var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
	}else{
		var tmp = "./body_var.php";
	}
	parent.body_var.location = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&league_id="+parent.parent.OP_lid_type;	
	document.all.line_window.style.visibility='hidden';
	//var obj_league = document.getElementById('sel_lid');
	//onload();
}

function chg_pg(pg){
	if (pg==parent.pg)return;
	parent.pg=pg;
	parent.loading_var = 'Y';
	//alert("./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg)
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg;
	//onload();
}
function show_more(gid){
	document.all.line_window.style.position='absolute';
	document.all.line_window.style.top=document.body.scrollTop+event.clientY+12;
	document.all.line_window.style.left=document.body.scrollLeft+7;
	line_form.gid.value=gid;
	line_form.uid.value=parent.uid;
	line_form.ltype.value=parent.ltype;
	line_form.submit();
} 
function show_detail(){
	show_team = document.getElementById("table_team");
	show_pd = document.getElementById("table_pd");
	show_t = document.getElementById("table_t");
	show_f = document.getElementById("table_f");
	show_hpd = document.getElementById("table_hpd");
	parent.ShowData_Other(show_team,show_pd,show_t,show_f,show_hpd,GameOther,top.odd_f_type);
	document.all.line_window.style.visibility='visible';
	document.all.line_window.focus();
}
function unload(){
	clearInterval(ReloadTimeID);
}
window.onunload=unload;
//-->