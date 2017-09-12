<!--

function ChkSelect(sdate){
    //按下確認時清掉暫存的資料
    //alert(parent.parent.name);
    parent.parent.paramData=new Array();
    var count=0;
	var teamcount=eval('document.form'+sdate+'.teamcount.value');
	for(i=1; i<=teamcount; i++){
        // ==== 取Radio的長度 ====
		for(var j=0;j < eval('document.form'+sdate+'.game'+i).length;j++){
			// ==== 判斷是否有點選 ====
            if(eval('document.form'+sdate+'.game'+i+'['+j+'].checked') == true){count++;}
		}
	}
	if(count < 1){
		alert("請選擇下注隊伍!!");
		return false;
	}
	if(count == 1){
		alert("單式投注請至單式下注頁面下注!!");
		return false;
	}
	//alert(minlimit);
	if(count < minlimit || count > maxlimit){
		alert("僅接受"+minlimit+"~"+maxlimit+"串投注!!");
		return false;
	}
	//return true;
	//document.all.TEAM_SELETC.disabled = true;
	reload_var();
}

var ReloadTimeID;

function onLoad(){
    parent.loading = 'N';
	parent.ShowType = 'P';
	if(parent.loading_var == 'N'){
        parent.ShowGameList();
		obj_layer = document.getElementById('LoadLayer');
		obj_layer.style.display = 'none';
	}
	//if(parent.retime_flag == 'Y')
	//count_down();
	futureShowGtypeTable();
}

//倒數自動更新時間
function count_down(){
    setTimeout('count_down()',1000);
    if(parent.retime_flag == 'Y'){
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
    //alert("aaa====>");
    minlimit=parent.minlimit_VAR;
	maxlimit=parent.maxlimit_VAR;
	parent.loading_var == 'Y';
	parent.body_var.location.reload();
}

function chg_league(){
	obj_pg = document.getElementById('pg_txt');
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	//parent.ShowGameList();
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&league_id="+obj_league.value;
	if (obj_league.value==''){
		parent.pg=0;
		onload();
	}else{
		obj_pg.innerHTML =''; 
	}	 	
}



