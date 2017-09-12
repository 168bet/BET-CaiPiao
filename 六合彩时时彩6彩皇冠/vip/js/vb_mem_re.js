<!--
var ReloadTimeID;

function onLoad(){
	parent.loading = 'N';
	parent.ShowType = 'RE';
	if(parent.loading_var == 'N'){
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

function reload_var(){
	parent.loading_var == 'Y';
	parent.body_var.location.reload();
}

function chg_league(){
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	parent.body_var.location="./body_var.php?uid="+parent.uid+"&rtype=re&mtype="+parent.mtype+"&langx="+parent.langx+"&league_id="+obj_league.value+((obj_league.value ==''&&top.swShowLoveI)?"3":"");
}
//-->