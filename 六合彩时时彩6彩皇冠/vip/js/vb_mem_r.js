<!--
var ReloadTimeID;

function onLoad(){
	parent.loading = 'N';
	parent.ShowType = 'OU';
	if(parent.loading_var == 'N')	{
		parent.ShowGameList();
		obj_layer = document.getElementById('LoadLayer');
		obj_layer.style.display = 'none';
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
	if(Level=="up"){
		var tmp = "./"+parent.sel_gtype+"_browse/body_var.php";
	}else{
		var tmp = "./body_var.php";
	}
	var obj_league = document.getElementById('sel_lid').value;
	if(obj_league=='')if(top.swShowLoveI)obj_league='1';
	parent.body_var.location = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&league_id="+obj_league;	
	//if (obj_league.value==''){
	//	onload();
	//}	
}
function chg_league(){
	obj_pg = document.getElementById('pg_txt');
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	//parent.ShowGameList();
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&league_id="+obj_league.value+((obj_league.value ==''&&top.swShowLoveI)?"3":"");
	if (obj_league.value==''){
		parent.pg=0;
		onload();
	}else{
		obj_pg.innerHTML =''; 
	}	 	
}
function chg_pg(pg){
	if (pg==parent.pg)return; 
	parent.pg=pg;
	parent.loading_var = 'Y';
	//alert("./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg)
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg;
	onload();
}
-->