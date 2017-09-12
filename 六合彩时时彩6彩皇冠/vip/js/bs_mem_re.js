<!--
var ReloadTimeID;

function onLoad(){
	parent.loading = 'N';
	parent.ShowType = 'RE';
	if (parent.parent.leg_flag=="Y"){
		parent.parent.leg_flag="N";
		parent.pg=0;
		reload_var();
	}		
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

function reload_var(){
	parent.loading_var == 'Y';
	parent.body_var.location.reload();
}
function unload(){
	clearInterval(ReloadTimeID);
}
window.onunload=unload;
//-->