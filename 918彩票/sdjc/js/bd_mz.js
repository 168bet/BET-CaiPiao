
var st={
		"0":"6",
		"1":"7",
		"2":"8"
}
var tag=1;

var agentFrom = location.search.getParam("agentFrom")||"";
var SDJC ={
		init:function(){
			this.dataList(0,1);
			this.bindEvent();
		},
		
		 cuter2 : function( str ){//abcd  
	        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
		 },
		
		dataList:function(index,tag){//无back向上，有back向下
			var t = SDJC.reFlag(index,tag);
			$("#bd_mz_list").html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>')
			$.ajax({
				url:'/user/share_user_data_list.go?flag='+t,
				type:'POST',
				dataType:'xml',
				success: function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					var rows=R.find("rows");
					var row = rows.find("row");
					var html='';
					if(row.length){
						row.each(function(){
							var nickid = $(this).attr("nickid");
							var realuid = $(this).attr("realuid");
							var returnrate = $(this).attr("returnrate");
							var winmoney = $(this).attr("winmoney");
							var projrednum = $(this).attr("projrednum");
							var projallnum = $(this).attr("projallnum");
							var userphoto = $(this).attr("userphoto");
							
							var shootrate = $(this).attr("shootrate");
							
							var followusers = $(this).attr("followusers");
							var followmoney = $(this).attr("followmoney");
							var unfinishnum = $(this).attr("unfinishnum");
						
							html+='<li realuid='+realuid+'>'
							html+='<span class="bd_headimg"><img src="'+(userphoto?userphoto:"img/zwtp.png")+'"/>'
							if(unfinishnum >= 1){
								html+='<i class="icon_sd">'+unfinishnum+'</i></span>'
							}else{
								html+='</span>'
							}
							html+='<span class="bd_name">'+nickid+'</span>'
							html+='<div class="bd_listright">'
							html+='<p class="bd_p6 number"><span>'+projallnum+'</span>中<span>'+projrednum+'</span></p>'
							html+='<p class="bd_p4">命中率:'+shootrate+'</p>'
							html+='</div>'
							html+='</li>'
						})
						$("#bd_mz_list").html(html)
					}else{
						$("#bd_mz_list").html('<div class="empty_user"><p>暂无内容</p></div>')
					}
				},
			})
		},
		bindEvent:function(){
			$("#checkAll").bind("click",function(){
				var idx = $("#headCont h3.on").index();
				if($(this).hasClass("checkAll")){
					$(this).html('当前仅显示有可跟买方案的大神<span type=a>查看全部</span>')
					
					$(this).removeClass("checkAll")
					tag=2;
					SDJC.dataList(idx,tag);
				}else{
					$(this).html('点击切换 , 显示有可跟买方案的大神<span>切换</span>');
					$(this).addClass("checkAll")
					tag=1;
					SDJC.dataList(idx,tag);
				}
			});
			$("#headCont h3").bind("click",function(){
				var idx = $(this).index();
				$(this).toggleClass("on");
				$(this).siblings().removeClass("on");
				SDJC.dataList(idx,tag);
			})
			$('#bd_mz_list').delegate('li','click',function(){
				var realuid = $(this).attr('realuid');
				if(agentFrom){
					location.href='/sdjc/details.html?loc='+realuid+'&agentFrom='+agentFrom
				}else{
					location.href='/sdjc/details.html?loc='+realuid
				}
			})
		},
		
		
		reFlag:function(index,tag){
			var flag ="";
			if(index=="0" && tag=="1"){
				flag=6
			}else if(index=="0" && tag=="2"){
				flag=16
			}else if(index=="1" && tag=="1"){
				flag=7
			}else if(index=="1" && tag=="2"){
				flag=17
			}else if(index=="2" && tag=="1"){
				flag=8
			}else if(index=="2" && tag=="2"){
				flag=18
			}
			return flag;
		}
}

$(function(){
	SDJC.init();
})