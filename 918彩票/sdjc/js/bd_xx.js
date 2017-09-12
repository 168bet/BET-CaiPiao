
var agentFrom = location.search.getParam("agentFrom")||"";
var SDJC ={
		init:function(){
			this.dataList(10);
			this.bindEvent();
		},
		
		 cuter2 : function( str ){//abcd  
	        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
		 },
		
		dataList:function(flag){//无back向上，有back向下
			$("#bd_xx_list").html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>')
			$.ajax({
				url:'/user/share_user_data_list.go?flag='+flag,
				type:'POST',
				dataType:'xml',
				success: function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					var rows=R.find("rows");
					var tr = rows.attr("tr");//总条数
					var tp = rows.attr("tp");//总页数
					var ps = rows.attr("ps");//条数
					var pn = rows.attr("pn");//当前页
					
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
							var unfinishnum = $(this).attr("unfinishnum");
							var money = SDJC.money_dot(winmoney)
						
							html+='<li realuid='+realuid+'>'
							html+='<span class="bd_headimg"><img src="'+(userphoto?userphoto:"img/zwtp.png")+'"/>'
							if(unfinishnum >= 1){
								html+='<i class="icon_sd">'+unfinishnum+'</i></span>'
							}else{
								html+='</span>'
							}
							html+='<span class="bd_name">'+nickid+'</span>'
							html+='<div class="bd_listright">'
							html+='<p class="bd_p1">累计奖金：<span class="number">'+money+'元</span></p>'
							html+='<p class="bd_p1"><i class="number">'+projallnum+'中'+projrednum+'</i></p>'
							html+='</div>'
							html+='</li>'
						})
						$("#bd_xx_list").html(html)
					}else{
						$("#bd_xx_list").html('<div class="empty_user"><p>暂无内容</p></div>')
					}
				},
			})
		},
		bindEvent:function(){
			$("#checkAll").bind("click",function(){
				if($(this).hasClass("checkAll")){
					$(this).html('当前仅显示有可跟买方案的大神<span type=a>查看全部</span>')
					
					$(this).removeClass("checkAll");
					SDJC.dataList(20);
				}else{
					$(this).html('点击切换 , 显示有可跟买方案的大神<span>切换</span>');
					
					$(this).addClass("checkAll");
					SDJC.dataList(10);
				}
			})
			$('#bd_xx_list').delegate('li','click',function(){
				var realuid = $(this).attr('realuid');
				if(agentFrom){
					location.href='/sdjc/details.html?loc='+realuid+'&agentFrom='+agentFrom
				}else{
					location.href='/sdjc/details.html?loc='+realuid
				}
			})
		},
		money_dot:function(m){
			var str = m.split('.')[0];
			return str.replace( /\B(?=(?:\d{3})+$)/g,',');  
		}
}

$(function(){
	SDJC.init();
})