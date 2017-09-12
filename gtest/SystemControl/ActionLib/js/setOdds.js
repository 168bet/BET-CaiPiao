
function initializes(){
	if (confirm("您確認還原所有賠率初始值碼？")){
		$.post(Urls, {typeid : 9}, function(data){
			alert("賠率還原完成！");
			location.href = location.href;
		},"text");
	}
}

function setodds(str, tid, $this){

	
	if (str.indexOf('-')<0){	
	var oddsHtml = $("#"+str);
	var odds = parseFloat(oddsHtml.html());
	var Ho = $("#Ho").val();
	var h = str;
	var value = $this.name;
	}
	else{
	var oddsHtml = $("#"+str.split('-')[0]);
	var odds = parseFloat(oddsHtml.html());
	var Ho = $("#Ho").val();
	var h = str.split('-')[1];
	var value = $this.name;
	}
	
	if (Ho == "" || !/^[0-9]+\.?[0-9]*$/.test(Ho)){$("#Ho").val("0.001");return}
	Ho = parseFloat(Ho);
	if ($this.name == 1){
		odds = odds + Ho;
	} else {
		if (odds < Ho){return}
		odds = isFloat(odds - Ho);
	}
	$.post(Urls, {typeid : 8, tid : tid, hid : h, oid : odds}, function(data){
		if (data == 1){
			oddsHtml.html(isFloat(odds));
		}
	},"text");
}