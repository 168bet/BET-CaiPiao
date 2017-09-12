var ReloadTimeID;
function onLoad(ptype){
	parent.loading = "N";
	if (ptype == "t") {
		parent.ShowType = "EO";
	} else {
		parent.ShowType = ptype.toUpperCase();
		if (ptype == "all" || ptype == "r4") parent.ShowType = "S";
	}
	document.getElementById("ltype").value = parent.ltype;
	document.getElementById("retime").value = parent.retime;
	var obj_retime = document.getElementById("retime").value;
	var homepage = "./real_wagers_var.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+ptype+"&page_no=0";
	homepage += Chk_gdate();	//=== 早餐需多帶日期
	parent.body_var.location = homepage;
	parent.pg = 0;
	if(obj_retime != -1)
		ReloadTimeID = setInterval("parent.body_var.location.reload()",obj_retime * 1000);
}

function onUnload(){
	if (ReloadTimeID) clearInterval(ReloadTimeID);
	if (parent.GameTimerID) clearInterval(parent.GameTimerID);
	parent.loading = "Y";
	parent.ShowType = "";
	parent.pg = 0;
	parent.sel_league = "";
}

function chg_retime(){
	parent.retime = document.getElementById("retime").value;
	TimeValue = parent.retime;
	if(ReloadTimeID) clearInterval(ReloadTimeID);
	if(TimeValue != -1){
		parent.body_var.location.reload();
		ReloadTimeID = setInterval("parent.body_var.location.reload()",TimeValue*1000);
	}
}

function chg_ltype(){
	var obj_ltype = document.getElementById("ltype");
	var gdate = Chk_gdate();
	var league = Chk_league();
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+parent.stype_var+"&ltype="+obj_ltype.value+"&set_account="+parent.set_account+"&page_no="+parent.pg+league+gdate;
}

function chg_page(page_type){
	var gdate = Chk_gdate();
	//var obj_retime = document.getElementById("retime");
	var homepage = "real_wagers.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+page_type+gdate;
	self.location = homepage;
}

function chg_pg(pg){
	if (pg == parent.pg)return;
	var gdate = Chk_gdate();
	parent.loading_var = "Y";
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+parent.stype_var+"&ltype="+parent.ltype+"&set_account="+parent.set_account+"&page_no="+pg+gdate;
}

function chg_account(set_account){
	var gdate = Chk_gdate();
	var league = Chk_league();
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+parent.stype_var+"&ltype="+parent.ltype+"&set_account="+set_account+"&page_no="+parent.pg+league+gdate;
}

function chg_gdate(value){
	parent.pg = 0;
	parent.sel_league = "";
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+parent.stype_var+"&ltype="+parent.ltype+"&set_account="+parent.set_account+"&page_no="+parent.pg+"&gdate="+value;
}

function chg_league(value){
	var gdate = Chk_gdate();
	parent.ShowGameList();
	parent.body_var.location = "./real_wagers_var.php?uid="+parent.uid+"&gtype="+parent.gtype+"&ptype="+parent.stype_var+"&ltype="+parent.ltype+"&set_account="+parent.set_account+"&league_id="+value+gdate;
	parent.pg = 0;
}

//====== 判斷是否有日期選項
function Chk_gdate() {
	var url_gdate = "";
	if (document.getElementById("gdate") != null) {
		if (parent.gdate == "") {
			parent.gdate = document.getElementById("gdate").value;
		} else {
			document.getElementById("gdate").value = parent.gdate;
		}
		url_gdate = "&gdate="+document.getElementById("gdate").value;
	}
	return url_gdate;
}

//====== 判斷是否有聯盟選項
function Chk_league() {
	var url_league = "";
	if (document.getElementById("sel_lid") != null) {
		document.getElementById("sel_lid").value = parent.sel_league;
		url_league = "&league_id="+document.getElementById("sel_lid").value;
	}
	return url_league;
}

//====== 已開賽 more
function show_detail(gid){
	document.getElementById("line_window").style.position = "absolute";
	document.getElementById("line_window").style.top = document.body.scrollTop+event.clientY+40;
	document.getElementById("line_window").style.left = document.body.scrollLeft+event.clientX-400;
	line_form.gid.value = gid;
	if (document.getElementById("cid") != null)	{
		if(parent.set_account == "1") {
			line_form.cid.value = parent.cid;
		} else {
			line_form.cid.value = "";
		}
	} else {
		if (document.getElementById("sid") != null)	line_form.sid.value = parent.sid;
		if (document.getElementById("aid") != null)	line_form.aid.value = parent.aid;
		line_form.set_acc.value = parent.set_account;
	}
	document.getElementById("line_window").style.visibility = "visible";
	line_form.submit();
}

/**
 * more 目前只有 FT、BS、OP 有, 變數名稱也都就 top.divFT
 */
function show_one(){
	show_table = document.getElementById("gdiv_table");
	parent.ShowData_PL_DETAIL(show_table,top.divFT);
}
