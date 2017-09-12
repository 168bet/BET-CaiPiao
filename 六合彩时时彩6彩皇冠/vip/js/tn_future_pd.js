<!--

var ReloadTimeID;

//網頁載入
function onLoad(){
    parent.loading = 'N';
    parent.ShowType = 'PD';
    if(parent.loading_var == 'N'){
        parent.ShowGameList();
        obj_layer = document.getElementById('LoadLayer');
        obj_layer.style.display = 'none';
    }
        count_down();
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
	
    //if(parent.retime_flag == 'Y')
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
    	parent.loading_var == 'Y';
    	if(Level=="up"){
		var tmp = "./TN_future/body_var.php";
	}else{
		var tmp = "./body_var.php";
	}
    	var obj_league = document.getElementById('sel_lid');
	parent.body_var.location = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&g_date="+parent.g_date+"&league_id="+obj_league.value;
	
}

//用日期時間區分早餐賽事
function chg_gdate(){
	var obj_gdate = document.getElementById("g_date");
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;	
	var homepage = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&g_date="+obj_gdate.value+"&mtype="+parent.ltype+"&league_id="+obj_league.value;
	//alert(homepage);
	parent.pg=0;
	parent.body_var.location = homepage;
}

function chg_league(){
	obj_pg = document.getElementById('pg_txt');
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	//parent.ShowGameList();
	if (obj_league.value==''){
		parent.pg=0;
	}else{
		obj_pg.innerHTML ='';
	}
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&league_id="+obj_league.value+((obj_league.value ==''&&top.swShowLoveI)?"3":"")+"&g_date="+parent.g_date;
		
}



function chg_pg(pg){
    if (pg==parent.pg)return; 
 	parent.pg=pg;
	parent.loading_var = 'Y';
	//alert("./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg)
	parent.body_var.location = "./body_var.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&g_date="+parent.g_date;
}

//-->