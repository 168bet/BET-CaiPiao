var XHC={};

var noGame  = '<div style="text-align: center; padding: 50px;">暂无奖券明细</div>';
//公用弹出层和加载层

var mymx={"0":"兑换话费","1":"兑换Q币","2":"兑换红包","3":"排行榜派奖","4":"游戏","5":"其他","6":"实物奖品","7":"撤销兑换","8":"兑换现金","10":"足球日榜奖励","11":"足球月榜奖励","13":"足球单场排行奖励","14":"足球周榜奖励","20":"篮球日榜奖励","21":"篮球月榜奖励","23":"篮球单场排行奖励","24":"篮球周榜奖励","27":"快频日榜奖励","25":"猜球夺宝退还报名费","26":"猜球夺宝奖励"};


var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};

var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};


XHC.ZLK=(function(){
	var name = localStorage.getItem("username")||"";
	var init = function(){
		bindEvent();
		query_list();
	}
	
	var data = {
			flag:1,
			pageNo:1,//当前页页数
			cnickid:name,
			visit:3000
	};
	
	var bindEvent=function(){
		$(".more").bind("click",function(){
			query_list();
		});
	};
	
	
	
	
	var query_list=function(){
		var html = $(".details").html();
		$.ajax({
			 url: "/activity/ticket.go",
	        type: "POST",
	        data:data,
	        dataType:"xml",
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var code = R.attr("code");
	        	var desc = R.attr("desc");
	        	if(code==200){
	        		var rows = R.find("rows");
		        	var pageTotal = rows.attr("pageTotal");//总页数
		        	var pageSize = rows.attr("pageSize");//页长度
		        	var pageNo = rows.attr("pageNo");//当前页页数
		        	var countTotal = rows.attr("countTotal");//总条数
		        	
		        	var row = rows.find("row");
		        	
		        	if(pageTotal==0){
		        		$(".details").html(noGame);
		        		$(".more").hide();
		        	}else{
		        		if(data.pageNo<=pageTotal){
		        			if(row.length){
				        		row.each(function(){
				        			var itype = $(this).attr("itype");//0-收入  1-支出
				        			var money = $(this).attr("money");//收入支出金额
				        			var ioldmoney = $(this).attr("ioldmoney");//变化前余额
				        			var ibalance = $(this).attr("ibalance");//奖券余额
				        			var ibiztype = $(this).attr("ibiztype");//0、1、2：兑换奖品；3：冲榜赢奖券；4：砸蛋抢奖券
				        			var remark = $(this).attr("remark");//备注
				        			var createTime = $(this).attr("createTime");//创建时间
				        			var tmp_time = ""
				        				
				        			var d = new Date(createTime);
				        			var m = d.getMonth()+1;
				        			m = m<10?"0"+m:m;
				        			var day = d.getDate();
				        			day = day<10?"0"+day:day;
				        			
				        			var H = d.getHours();
				        			H = H<10?"0"+H:H;
				        			var M = d.getMinutes();
				        			M = M<10?"0"+M:M;
				        			
				        			tmp_time = m+"-"+day+"&nbsp;"+H+":"+M;
				        			/**
				        			var jq_type=""
				        				if(ibiztype==1){
				        					jq_type="兑换奖品";
				        				}else if(ibiztype==2){
				        					jq_type="冲榜赢奖券";
				        				}else if(ibiztype==3){
				        					jq_type="砸蛋抢奖券";
				        				}
				        				**/
				        			
				        			html+='<li>'
				        			html+='<strong class="'+(itype==0?"red":"green")+'">'+(itype==0?"+":"-")+''+money+'</strong>'
				        			html+='<span>'
				        			html+='<cite>'+mymx[ibiztype]+'</cite>'
				        			html+='<em>'+tmp_time+'</em>'
				        			html+='</span>'
				        			html+='</li>'
				        		})
				        		
				        		$(".details").html(html)
				        	}
		        			
		        			if(pageTotal==data.pageNo){
								$(".more").hide()
							}else{
								$(".more").show().css("display","block");
							}
		        			data.pageNo++;
		        		}else{
		        			$(".more").hide();
							return;
		        		}
		        	}
	        	}else if(code==1002){
	        		$(".details").html(noGame);
	        		$(".more").hide();
	        	}
	        }
		})
	};
	
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})


var remove_header=function(){
	var arg = localStorage.getItem("from");
	if(arg){
		$(".tzHeader").hide();
	}else{
		$(".tzHeader").show();
	}
}
remove_header();

