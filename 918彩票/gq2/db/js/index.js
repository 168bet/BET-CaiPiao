
var CP={};
CP.Util={
	pad:function(source, length) {
		var pre = "",
		negative = (source < 0),
		string = String(Math.abs(source));
		if (string.length < length) {
			pre = (new Array(length - string.length + 1)).join('0');
		}
		return (negative ? "-" : "") + pre + string;
	}	
};

var XHC={};
XHC.DB=(function(){
	var init=function(){
		news_cont();
		bindEvent();
		progressing();
	};
	var curDate = '';
	var bindEvent=function(){
		//头部导航切换
		$("#nav span").bind("click",function(){
			var index=$(this).index();
			$(this).addClass("cur");
			$(this).siblings().removeClass("cur");
			if(index==0){//进行中
				$("#progress").show();
				$("#over").hide();
				//clearInterval(this.timer);
				//progressing();
			}else{//已结束
				$("#progress").hide();
				$("#over").show();
				//clearInterval(this.timer);
				//overing();
				var oHTML = $("#over").html();
				if(!oHTML){
					overing();
				}
			}
		});
		
		//奖券、积分切换
		$("#tz_cont div.pdLeft1").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur");
			$(this).siblings().removeClass("cur");
			if(index==0){
				sign_up_success_param.stype=1;//积分
			}else{
				sign_up_success_param.stype=2;//奖券
			}
			$("#lack_of_balance").hide();
		});
		
		//进行中报名参赛
		$("#progress").delegate(".bm","click",function(event){
			event.stopPropagation();
			if($(this).hasClass("gray")){//不能报名参赛
				return;
			}
			var integral = bm_jf_jq.integral= $(this).parents("li").attr("integral");//积分
			var ticket =bm_jf_jq.award= $(this).parents("li").attr("ticket");//奖券
			var periodid = sign_up_success_param.periodid = $(this).parents("li").attr("periodid");//期次编号
			
			$("#tz_confirm").attr("periodid",periodid);
			D.confirm_tz(integral,ticket);
		});
		
		//报名成功
		$("#toSignUp").bind("click",function(){
			var periodid = $(this).parents("article#tz_confirm").attr("periodid");
			if(sign_up_success_param.stype==1){//积分
				if(parseInt(g.integral)<parseInt(bm_jf_jq.integral)){
					$("#lack_of_balance").show();
					return;
				}
			}else{
				if(parseInt(g.award)<parseInt(bm_jf_jq.award)){
					$("#lack_of_balance").show();
					$("#lack_of_balance").html("奖券余额不足")
					return;
				}
			}
			
			bm_success(null,$("#progress li[periodid="+periodid+"] .bm"));
		});
		
		$("#progress,#over").delegate("li","click",function(){
			var integral = bm_jf_jq.integral= $(this).attr("integral");//积分
			var ticket =bm_jf_jq.award= $(this).attr("ticket");//奖券
			var periodid =bm_jf_jq.periodid= $(this).attr("periodid");//奖券
			var mids = $(this).attr("mids");
			var itype = $(this).attr("itype");
			localStorage.setItem("mids", mids);
			localStorage.setItem("tmp_data", JSON.stringify(bm_jf_jq));
			if(itype==1){
				window.location.href="cqdb.html";
			}else{
				window.location.href="cqdb1.html";
			}
			
		});
	};
	
	var progressing=function(){//开启销售，进行中
		clearInterval(this.timer);
		$("#progress").empty();//清空progress元素下的所有后代节点
		
		$.ajax({
			url : '/grounder/takeinaccout.go?flag=5&pstate=4',
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
				curDate = n_.getTime();
				clearInterval(this.timer);
				this.timer=setInterval(function(){
					curDate = curDate+g.fps;
				}, g.fps); 
				var R= $(xml).find("Resp");
				var desc = R.attr("desc");
				var total = R.attr("total");//总条数
				var tpage = R.attr("tpage");//第几页
				
				var r = R.find("row");

				
				if(r.length){
					$(".lqend").hide();
					r.each(function(){
						var progressHTML="";
						
						var periodid = $(this).attr("periodid");//期次id
						var integral = $(this).attr("integral");//报名所需积分
						var ticket = $(this).attr("ticket");//报名所需奖券
						var chipnum = $(this).attr("chipnum");//初始筹码
						var currentnum = $(this).attr("currentnum");//当前参与人数
						var sendticket = $(this).attr("sendticket");//奖励奖券基数
						sendticket=sendticket.substring(0,sendticket.indexOf(","))
						var pstate = $(this).attr("pstate");//期次状态(-1 未开售，0-进行中， 1-已截止，2-撤销  )
						var expiretime = $(this).attr("expiretime");//截止时间
						var sendnum = $(this).attr("sendnum");//有效计奖人数
						var itype = $(this).attr("itype");//类型   足球\篮球
						var mids = $(this).attr("mids");//类型   足球\篮球
						var fullnum = $(this).attr("fullnum");//满员人数
						var synum = $(this).attr("synum");//剩余人数
						
						var isjoin = $(this).attr("isjoin");//剩余人数
						
						var iClass = (itype&&itype==1) ? "zu_bg" : "lan_bg";//区分足球、篮球颜色
						
						var percent = parseFloat(currentnum/fullnum)*100+"%";
						
						var tmpHTML="";
						if(currentnum<20){
							tmpHTML="不满20人退还报名费";
						}else if(currentnum==0){
							tmpHTML=sendticket+"X参与人数";
						}else{
							tmpHTML="人数越多奖励越高";
						}
						
						var class_bm = "";
						if(currentnum==fullnum){
							class_bm="gray";
						}
						
						
						
						progressHTML += '<li class="'+iClass+'" itype="'+itype+'" integral="'+integral+'" ticket="'+ticket+'" periodid="'+periodid+'" mids="'+mids+'">';
						progressHTML += '<label class=\"t'+sendticket+'jq\" ></label>';
						progressHTML += '<div class="top_card">';
						progressHTML += '<span>'+periodid+'期</span>';
						progressHTML += '<span>剩余<span class="t_"></span></span>';//剩余时间
						progressHTML += '</div>';
						progressHTML += '<div class="main_card">';
						progressHTML += '<div>';
						progressHTML += '<span>已参与<i>'+currentnum+'</i>人</span>';
						progressHTML += '<span>剩余名额:<i>'+synum+'</i></span>';
						progressHTML += '</div>';
						progressHTML += '<div>';
						progressHTML += '<span style="width:'+percent+'"></span>';
						progressHTML += '</div>';
						progressHTML += '<div>'+tmpHTML+'</div>';
						progressHTML += '</div>';
						progressHTML += '<div class="btm_card">';
						
						if(parseInt(currentnum)>0 && parseInt(currentnum)<=parseInt(fullnum)){
							progressHTML += '<span>第1名奖励: '+sendticket+'奖券x'+currentnum+'=<i>'+(parseInt(sendticket)*currentnum)+'</i>奖券</span>';
						}else if(currentnum==0){
							progressHTML += '<span>第1名奖励: '+sendticket+'奖券x参与人数</span>';
						}
						progressHTML += '<span class="bm '+class_bm+'">报名参赛</span>';
						progressHTML += '</div>';
						progressHTML += '</li>';
						
						$("#progress").append(progressHTML);
						expect_change(expiretime,periodid);
					});
				}else{
					$(".lqend").show();

					
				}
				

			}
		});
	};
	
	var overing=function(){//截止
		var overHTML="";
		$.ajax({
			url : '/grounder/takeinaccout.go?flag=5&pstate=3',
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				//var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
				var R= $(xml).find("Resp");
				var desc = R.attr("desc");
				var total = R.attr("total");//总条数
				var tpage = R.attr("tpage");//第几页
				
				var r = R.find("row");
				if(r.length){
					$(".lqend").hide();
					r.each(function(){
						var periodid = r.attr("periodid");//期次id
						var integral = r.attr("integral");//报名所需积分
						var ticket = r.attr("ticket");//报名所需奖券
						var chipnum = r.attr("chipnum");//初始筹码
						var currentnum = r.attr("currentnum");//当前参与人数
						var sendticket = r.attr("sendticket");//奖励奖券基数
						sendticket=sendticket.substring(0,sendticket.indexOf(","))
						var pstate = r.attr("pstate");//期次状态(-1 未开售，0-进行中， 1-已截止，2-撤销  )
						var expiretime = r.attr("expiretime");//截止时间
						var sendnum = r.attr("sendnum");//有效计奖人数
						var mids = r.attr("mids");//类型   足球\篮球
						var itype = r.attr("itype");//类型   足球\篮球
						var fullnum = r.attr("fullnum");//满员人数
						var synum = r.attr("synum");//剩余人数
						var iClass = (itype&&itype==1) ? "zu_bg" : "lan_bg";//区分足球、篮球颜色
						
						var percent = parseFloat(currentnum/fullnum)*100+"%";
						
						overHTML += '<li class="'+iClass+'" itype="'+itype+'" integral="'+integral+'" ticket="'+ticket+'" periodid="'+periodid+'" mids="'+mids+'">';
						overHTML += '<label class=\"t'+sendticket+'jq\" ></label>';
						overHTML += '<div class="top_card">';
						overHTML += '<span>'+periodid+'期</span>';
						overHTML += '<span class="balck">已截止</span>';//剩余时间
						overHTML += '</div>';
						overHTML += '<div class="main_card">';
						overHTML += '<div>';
						overHTML += '<span>已参与<i>'+currentnum+'</i>人</span>';
						overHTML += '<span>剩余名额:<i>'+synum+'</i></span>';
						overHTML += '</div>';
						overHTML += '<div>';
						overHTML += '<span style="width:'+percent+'"></span>';
						overHTML += '</div>';
						overHTML += '<div>人数越多奖励越高</div>';
						overHTML += '</div>';
						overHTML += '<div class="btm_card">';
						overHTML += '<span>第1名奖励: '+sendticket+'奖券x'+currentnum+'=<i>'+(sendticket*currentnum)+'</i>奖券</span>';
						overHTML += '<span class="gray bm">报名参赛</span>';
						overHTML += '</div>';
						overHTML += '</li>';
					});	
				}else{
					$(".lqend").show();
				}
				$("#over").html(overHTML);
			}
		});
	};
	
	var diffToString=function(num, iscn) {
		var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
		var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
		for (var i = 0, l = unit.length; i < l; i++) {
			date[i] = parseInt(num / unit[i]);
			cnDate[i] = date[i] + cn[i];
			num %= unit[i];
		}
		return iscn ? cnDate : date;
	};
	

	var eachClock=function(periodid, endtime_){
		var diff = endtime_ - curDate;
		var msg = '';
		if(diff >= 0){
			timeout = diffToString(diff,false);
			//msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
			if(timeout[0]=="0"){
				msg = '<i>'+(timeout[1]<10?"0"+timeout[1]:timeout[1])+'</i><i>'+(timeout[2]<10?"0"+timeout[2]:timeout[2])+'</i><i>'+CP.Util.pad(timeout[3],2)+'</i>';
			}else{
				msg = '<i>'+((timeout[1]+24)<10?"0"+timeout[1]:(timeout[1]+24))+'</i><i>'+(timeout[2]<10?"0"+timeout[2]:timeout[2])+'</i><i>'+CP.Util.pad(timeout[3],2)+'</i>';
			}
			
			$("#progress li[periodid="+periodid+"] .t_").html(msg);
		}else{
			msg = '已截止';
			$("#progress li[periodid="+periodid+"] .t_").html(msg);
			$("#progress li[periodid="+periodid+"] .t_").prev().remove();
			$("#progress li[periodid="+periodid+"] .bm").addClass("gray");
		}
	};
	
	 var expect_change = function(endtime,periodid){
		 this.periodid=periodid;
		var endtime_ = new Date(endtime.replace(/-/g , '/'));
		
		setInterval(function(){
			eachClock(periodid, endtime_);
		}, g.fps); 
		eachClock(periodid, endtime_);
	};
	
	var news_cont=function(){
		var html="";
		$.ajax({
			url:"/activity/ticket.go?flag=5",
			dataType:'xml',
			cache:true,
			success:function(xml){
				var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
				
				var R = $(xml).find("Resp");
				var desc = R.attr("desc");
				var code = R.attr("code");
				var rows = R.find("rows");
				if(code==200){
					var row = rows.find("row");
					$(".gd").show();
					if(row.length){
						if(row.length>1){
							$("#demo").show();						
						}
						row.each(function(a){
							var operor = $(this).attr("operor");//操作人
							var cnickid = $(this).attr("cnickid");//操作人
							var createTime = Date.parse(new Date($(this).attr("createTime")));//操作时间
							var itemRemark = $(this).attr("itemRemark");//奖品描述
							
							//var temp=""
							var strtime = (parseInt((parseInt(n_)-parseInt(createTime))/(60*1000)))
							if(strtime>10){
								var D = new Date(createTime);
								var H = D.getHours();
								H=H<10?"0"+H:H;
								
								var M = D.getMinutes();
								M=M<10?"0"+M:M;
								
								strtime=H+":"+M
							}else{
								strtime=strtime+"分钟前&nbsp;"
							}
							
							a<10 && (html+='<li>'+strtime+'&nbsp;<cite>'+cnickid+'</cite>兑换了<em>'+itemRemark+'</em></li>')
							
						});					
						
					}else{
						$("#demo").hide();

					}

					
					$("#scroll_Cont").html(html);
					
					var speed=50
					   var demo = document.getElementById("demo");
					   var scroll_Cont = document.getElementById("scroll_Cont");
					   var demo2 = document.getElementById("demo2");
					   demo2.innerHTML=scroll_Cont.innerHTML
					   function Marquee(){
						   if(demo.scrollLeft-demo2.offsetWidth>=0){
						    demo.scrollLeft-=scroll_Cont.offsetWidth;
						   }
						   else{
						    demo.scrollLeft++;
						   }
					   }
						  
					   var MyMar=setInterval(Marquee,speed);
					   /*demo.onmouseover=function() {clearInterval(MyMar)}
					   demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}*/
				}else if(code==1){
					$(".gd").hide();
					
				}
			}
		})
	}
	
	return {
		init:init
	};
})();


$(function(){
	XHC.DB.init();
})

