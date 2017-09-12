<!--
function ChkSelect(sdate){
	//絋粄睲奔既戈
	//alert(parent.parent.name);
	parent.parent.paramData=new Array();
	var count = 0;
	var teamcount = eval('document.form'+sdate+'.teamcount.value');

	for(i=1; i<=teamcount; i++){
		for (var j=0;j < eval('document.form'+sdate+'.game'+i).length;j++){
			if (eval('document.form'+sdate+'.game'+i+'['+j+'].checked') == true){count++;}
		}
	}
	if(count < 1){
		alert("请选择下注队伍!!");
		return false;
	}
	if(count == 1){
		alert("单式投注请至单式下注页面下注!!");
		return false;
	}
	if(count < minlimit || count > maxlimit){
		alert("仅接受"+minlimit+"~"+maxlimit+"串投注!!");
		return false;
	}
	//return true;
	//document.all.TEAM_SELETC.disabled = true;
	reload_var();
}

 var ReloadTimeID;

 function onLoad()
 {
  parent.loading = 'N';
  parent.ShowType = 'PR';
  if(parent.loading_var == 'N')
  {
   parent.ShowGameList();
   obj_layer = document.getElementById('LoadLayer');
   obj_layer.style.display = 'none';
  }
//  if(parent.retime_flag == 'Y')
   count_down();
   futureShowGtypeTable();
 }

//倒数自动更新时间
 function count_down(){
  setTimeout('count_down()',1000);
  if (parent.retime_flag == 'Y'){
	  if(parent.retime <= 0)
	  {
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
 	minlimit=parent.minlimit_VAR;
	maxlimit=parent.maxlimit_VAR;
	parent.loading_var == 'Y';
	parent.body_var.location.reload();
}
 function chg_league()
 {
  var obj_league = document.getElementById('sel_lid');
  parent.body_var.location="./body_var.php?uid="+parent.uid+"&rtype=pr&mtype={MTYPE}&sel_lid="+obj_league.value;
 }
//-->
