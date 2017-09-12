<!--
var ReloadTimeID='';

function onLoad(){
	if (""+parent.BK_lname_ary=="undefined") parent.BK_lname_ary="ALL";	
	if (""+parent.BK_lid_ary=="undefined") parent.BK_lid_ary="ALL";
	if (""+parent.sel_gtype=="undefined") parent.sel_gtype='BK';
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

function reload_var(Level){
	parent.loading_var = 'Y';
	//parent.body_var.location.reload();
	//var obj_league = document.getElementById('sel_lid');
	if(Level=="up"){
		var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
	}else{
		var tmp = "./body_var.php";
	}
	parent.body_var.location = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&league_id="+parent.parent.BK_lid_type;
}
function chg_pg(pg){
	if (pg==parent.pg)return;
	parent.pg=pg;
	parent.loading_var = 'Y';
	//alert("./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg)
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg;
	//onload();
}
function unload(){
	clearInterval(ReloadTimeID);
}
window.onunload=unload;
//-->