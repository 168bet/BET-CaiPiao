String.prototype.getParam = function(n){
	var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
	var r1=new RegExp(n+"=","gi");
	var m=this.match(r);
	if(m==null){
		return "";
	}else{
		return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
	}
};

var CP={}


var qc = location.search.getParam("qc");
var itemid = location.search.getParam("itemid");
var cpyid = location.search.getParam("cpyid");//赔率公司id
var cpyidObj = JSON.parse(localStorage.getItem("cpyidObj"));
CP.JSBF=(function(){
	var init=function(){
		loadCont();
	};
	
	
	//加载内容(欧赔接口)
	var loadCont = function(){
		var html="";
		$.ajax({
			url:'/zlk/jsbf/jc/newodds/150321/OP/150321001/150321001_99999.xml',
			type:'GET',
			DataType:'XML',
			success:function(){
				for(var k in cpyidObj){
					html+='<li>'+cpyidObj[k]+'</li>';
				}
				alert(html)
				$("#navCont").html(html);
			}
		});
	};
	
	//高亮显示
	var highLight=function(){
		
	}
	
	return {
		init:init
	}
})();
$(function(){
	CP.JSBF.init();
})
