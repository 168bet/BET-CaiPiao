function onLoad(){
	document.getElementById('userid').innerHTML = username;
	document.getElementById('credit').innerHTML = maxcredit;
	document.getElementById('currency').innerHTML = currency;
	try{
	document.getElementById('passafe').innerHTML = pass_safe;
	}catch(e){}
	if (chk_fun == "Show") {
		Show10List();
	} else if (chk_fun == "Close") {
		document.all.chk.style.visibility = "hidden";
	}
	if (!show_live) {
		try{
			document.getElementById("live_layer").style.display = "none";
		}catch(e){}
	}
}

function Show10List(){
	var objs=document.getElementById('reloadPHP');
    if (parent.refresh_var=='Y'||(""+parent.refresh_var=="undefined")){
    	objs.src = "./today/show10rec.php?uid="+top.uid;
    }else{
    	objs.src="../../../tpl/member/zh-tw/show10rec_norefresh.html?uid="+top.uid;
    }
}

function show_record(){
	if (parent.show=='N'||(""+parent.show=="undefined")){
		parent.show='';
	}else{
		parent.show='N';
	}
	self.location = "./select.php?uid="+top.uid+"&langx="+top.langx+"&show="+parent.show;
}
function reload_var(){
	parent.refresh_var='Y';
	self.location.reload();
}
function Hot_click(a,b,c){

	//top.swShowLoveI=false;
        //top.getNewGtype = a;
        parent.location=a+"&league_id=3";
}