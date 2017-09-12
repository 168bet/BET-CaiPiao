<!--
var ReloadTimeID='';
var sel_gtype=parent.sel_gtype;
//網頁載入
function onLoad(){
	if((""+eval("parent."+sel_gtype+"_lname_ary"))=="undefined") eval("parent."+sel_gtype+"_lname_ary='ALL'");
	if((""+eval("parent."+sel_gtype+"_lid_ary"))=="undefined") eval("parent."+sel_gtype+"_lid_ary='ALL'");
	if(parent.ShowType==""||rtype=="r") parent.ShowType = 'OU';
	if(rtype=="hr") parent.ShowType = 'OU';
	if(rtype=="re") parent.ShowType = 'RE';
	if(rtype=="pd") parent.ShowType = 'PD';
	if(rtype=="hpd") parent.ShowType = 'HPD';
	if(rtype=="t") parent.ShowType = 'EO';
	if(rtype=="f") parent.ShowType = 'F';
	if(parent.parent.leg_flag=="Y"){
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
	if(sel_gtype=="FU"){
		if(top.showtype!='hgft'){
			selgdate(rtype);
		}
	}
	document.getElementById("odd_f_window").style.display = "none";
	futureShowGtypeTable();
}
function selgdate(rtype,cdate){
	//賽事分日期
	var date_opt = "";
	var arrDate =new Array();
	var year ='';
	if(top.showtype=='hgft'){
		var tmpdate=DateAry[0].split("-");
		for (i = 0; i < parent.hotgdateArr.length; i++) {
			var tmpd =parent.hotgdateArr[i].split("-");
			if(tmpdate[1]*1 > tmpd[0]*1){
				year =tmpdate[0]*1+1;
			}else{
				year =tmpdate[0];
			}
			arrDate =arraySort(arrDate,year+'-'+parent.hotgdateArr[i]);
		}
		if(cdate=='')cdate ='ALL';
		date_opt = '<select id="g_date" name="g_date" onChange="chg_gdate()">';
		date_opt+= '<option value="ALL" '+((cdate =='ALL')?'selected':'')+'>'+top.alldata+'</option>';
		for (i = 0; i < arrDate.length; i++) {
			date_opt+= '<option value="'+arrDate[i]+'" '+((cdate ==arrDate[i])?'selected':'')+'>'+arrDate[i]+'</option>';
		}
		date_opt+= "</select>";
	}else{
		arrDate=DateAry ;
		date_opt = "<select id=\"g_date\" name=\"g_date\" onChange=\"chg_gdate()\">";
		date_opt+= "<option value=\"ALL\" selected>"+top.alldata+"</option>";
		if (rtype == "r") {
			date_opt+= "<option value=\"1\" >"+top.S_EM+"</option>";
		}
		for (i = 0; i < arrDate.length; i++) {
			date_opt+= "<option value=\""+arrDate[i]+"\" >"+arrDate[i]+"</option>";
		}
		date_opt+= "</select>";
	}
	
	document.getElementById("show_date_opt").innerHTML = date_opt;
}
function arraySort(array ,data){
	var outarray =new Array();
	var newarray =new Array();
	for(var i=0;i < array.length ;i++){
		if(array[i]<= data){
			outarray.push(array[i]);
		}else{
			newarray.push(array[i]);
		}
	}
	outarray.push(data);
	for(var i=0;i < newarray.length ;i++){
		outarray.push(newarray[i]);		
	}
	return  outarray;
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
		var tmp = "./FT_future/body_var.php";
	}else{
		var tmp = "./body_var.php";
	}
	var l_id =eval("parent.parent."+sel_gtype+"_lid_type")
	if(top.showtype=='hgft'){
		l_id=3;	
	}
	var homepage = tmp+"?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&page_no="+parent.pg+"&g_date="+parent.g_date+"&league_id="+l_id+"&showtype="+top.showtype;
	parent.body_var.location = homepage;
	if(rtype=="r")document.all.line_window.style.visibility='hidden';
}

//切換日期
function chg_gdate(){
	var obj_gdate = document.getElementById("g_date");
	parent.g_date=obj_gdate.value;
	parent.pg=0;
	reload_var();
}

//賽事換頁
function chg_pg(pg){
	if (pg==parent.pg) {return;}
	parent.pg=pg;
	reload_var();
}

//選擇聯盟
function chg_league(){
	self.location="./body_var_lid.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype+"&g_date="+parent.g_date;
}


function show_more(gid){
	document.all.line_window.style.position='absolute';
	document.all.line_window.style.top=document.body.scrollTop+event.clientY+12;
	document.all.line_window.style.left=document.body.scrollLeft+5;
	line_form.gid.value=gid;
	line_form.uid.value=parent.uid;
	line_form.ltype.value=parent.ltype;
//	document.all.line_window.style.visibility='visible';
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
