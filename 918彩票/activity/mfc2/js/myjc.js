var CP={};
var username = localStorage.getItem("username")||"";//获取用户名
CP.ZLK=(function(){
	var init=function(){
		loadCont();
	};
	
	
	var istateCont = function(flag,grade,ibonus){
		var html="";
		if(flag=="0"||flag=="1"||flag=="2"){//未开奖
			html='<strong>等待开奖</strong>';
		}else if(flag>=3){
			if(ibonus=="0"||ibonus==""){
				html="<strong>未中奖</strong>"
			}else{
				if(grade=="1"){
					html='<strong>一等奖</strong><p class="red">分得'+ibonus+'元</p>';
				}else if(grade=="2"){
					html='<strong>二等奖</strong><p class="red">分得'+ibonus+'元</p>';
				}else if(grade=="3"){
					html = '<strong>三等级</strong><p class="red">分得'+ibonus+'元</p>';
					
				}else if(grade=="4"){
					html = '<strong>四等奖</strong><p class="red">分得'+ibonus+'元</p>';
					
				}else if(grade=="5"){
					html = '<strong>五等奖</strong><p class="red">分得'+ibonus+'元</p>';
					
				}else if(grade=="6"){
					html = '<strong>六等奖</strong><p class="red">分得'+ibonus+'元</p>';
					
				}
			}
		}
		return html;
	};

	//开奖号码 投注号码颜色	
	function changecolor(str1,str2) //str1:投注的ccode    str2:开奖的ccode
	{
		html="";
		html2="";
		if(str1 && str2){
			red1=str1.split("|")[0];
			red2=str2.split("|")[0];

			for( k=0;k<=35;k++) //红球
			{
				if(k<10){	
					i="0"+parseInt(k);
				}
				else{
					i=parseInt(k);
				}
				
				if(red1.indexOf(i)!=-1 && red2.indexOf(i)!=-1){
				html=html+"<cite>"+i+"</cite>&nbsp;";	
				}else if(red1.indexOf(i)!=-1){
				html=html+i+"&nbsp;";
				}
				//开奖号码变色
				if(red2.indexOf(i)!=-1){
					html2=html2+"<cite>"+i+"</cite>&nbsp;"
				}
			}
				if(str1.split("|")[1].substr(0,2)==str2.split("|")[1].substr(0,2)) //篮球
				{
					html=html+"|&nbsp;<em>"+str1.split("|")[1].substr(0,2)+"</em>";
				}
				else{
					html=html+"|&nbsp;"+str1.split("|")[1].substr(0,2);
				}
				
				html2=html2+"|&nbsp;<em>"+str2.split("|")[1].substr(0,2)+"</em>";//开奖号码变色
		}else if(str1 && !str2){
			red1=str1.split("|")[0];
			for( k=0;k<=35;k++) //红球
			{
				if(k<10){	
					i="0"+parseInt(k);
				}
				else{
					i=parseInt(k);
				}
				
				
			if(red1.indexOf(i)!=-1){
				html=html+"<cite>"+i+"</cite>&nbsp;"


			}

			}
				html=html+"|&nbsp;<em>"+str1.split("|")[1].substr(0,2)+"</em>";
				html2=" --";

		}
	
		return (html+"$"+html2);
	}
	
	
	//开奖内容
	/***
	var kjcodeCont = function(ccode,cawardcode){
		alert(ccode+"-----------"+cawardcode);
		var html="";
		
		if(ccode && cawardcode){
			var ccodeArr = ccode.split("|");
			var cawardcodeArr = cawardcode.split("|");
			var redccodeArr = ccodeArr[0].split(",");
			var redcawardcodeArr = cawardcodeArr[0].split(",");
			alert(changecolor(ccode,cawardcode));
			html+='<p>竞猜号码：'+changecolor(ccode,cawardcode)+'</p>';
			html+='<p>开奖号码：<cite>'+redcawardcodeArr+'</cite> | <em>'+redcawardcodeArr[1]+'</em></p>';
		}else if(ccode && !cawardcode){
			var ccodeArr = ccode.split("|");
			//var cawardcodeArr = cawardcode.split("|");
			var redccodeArr = ccodeArr[0].split(",");
			//var redcawardcodeArr = cawardcodeArr[0].split(",");
			html+='<p>竞猜号码：'+redccodeArr+'| <em>'+redccodeArr[1]+'</em></p>';
			html+='<p>开奖号码：--</p>';
		}
		return html;
	}
	***/
	var data={
			func:"freeguess_detail",
			gid:"01",
			pn:1,//当前页数
			ps:25,//每页记录数
	};
	
	var loadCont=function(){
		var html="";
		$.ajax({
			url:"/activity/queryDatas.go",
			dataType:'xml',
			data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				
				
				if(code=="0"){//查询成功
					$(".ts").show();
					
					var rows = R.find("rows");
					var tr = rows.attr("tr")||"0";//累计投注次数
					var sumbonus = rows.attr("sumbonus")||"0";
					$("#user_info").html('<span>'+username+'</span>累计竞猜 <em class="red">'+tr+'</em> 注 中奖 <em class="red">'+sumbonus+'</em> 元')
					
					var row = R.find("row");
					row.each(function(){
						/***
						var cjoinid = $(this).attr("cjoinid");//记录id
						var cnickid = $(this).attr("cnickid");//昵称
						var cmobileno = $(this).attr("cmobileno");//参与人手机号
						var cidcardno = $(this).attr("cidcardno");//参与人身份证号
						var cgameid = $(this).attr("cgameid");//彩种
						var cretdate = $(this).attr("cretdate");//派奖时间
						***/
						var ccode = $(this).attr("ccode");//竞猜号码
						var cadddate = $(this).attr("cadddate");//cadddate 竞猜时间
						var cperiodid = $(this).attr("cperiodid");//cperiodid 竞猜期次
						var cawardcode = $(this).attr("cawardcode");//开奖号码
						var ibonus = $(this).attr("ibonus");//竞猜获得奖金
						var igrade = $(this).attr("igrade");//奖级   1 一等奖  2  二等奖   3  三等奖   6   六等奖    -1 未中奖
						var istate = $(this).attr("istate");//当前状态   0  未开奖   1 2已开奖   3 已算奖
						
						//ccode="02,14,16,18,24,25|13:1:1";
						//cawardcode="05,14,16,18,25,30|15";
						var week=parseInt(cperiodid.substr(5,2));						  
						html+='<dl>';
						html+='<dt>第'+cperiodid+'期 '+cadddate+'</dt>';
						html+='<dd>';
						html+='<div class="left">';
						//alert(changecolor(ccode,cawardcode));
						html+='<p>竞猜号码：'+changecolor(ccode,cawardcode).split("$")[0]+'</p>'
						//alert(cawardcode.replace(/,/g," "));
					
						if(ccode && cawardcode){
						html+='<p>开奖号码：'+changecolor(ccode,cawardcode).split("$")[1]+'</p>';
						}else if(ccode && !cawardcode){
							if(week%3==2){
								html+="<p>开奖号码：预计 周日21:30开奖</p>";
							}
							else if(week%3==0){
								html+="<p>开奖号码：预计 周二21:30开奖</p>";
							}
							else if(week%3==1){
								html+="<p>开奖号码：预计 周四21:30开奖</p>";
							}
						}
						html+='</div>';
						html+='<div class="right">';
						html+=istateCont(istate,igrade,ibonus);
						html+='</div>'
						html+='</dd>';
						html+='</dl>';
					})
					$("#jcjlCont").html(html);
				}else{
					$(".ts").hide();
					$("#jcjlCont").html(desc);
				}
			}
		})
	}
	
	return {
		init:init
	};
})();

$(function(){
	CP.ZLK.init();
})