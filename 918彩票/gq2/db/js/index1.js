
/***
var o = $({});
$.subscribe = function () {o.on.apply(o, arguments);};
$.unsubscribe = function () {o.off.apply(o, arguments);};
$.publish = function () { o.trigger.apply(o, arguments);};

***/

    
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
}

var XHC={};

/***
var D={
		render:function(e, opt){
			$("#tz_cont div.pdLeft1:eq(0) div.redText p:eq(1)").html("积分余额："+opt.integral);
			
			$("#tz_cont div.pdLeft1:eq(1) div.redText p:eq(1)").html("奖券余额："+opt.award);
			
		},
		
		//integral-积分  award-奖券  integral_balance-积分余额  award_balance-奖券余额
		confirm_tz:function(integral,award,fn,fn1){
			
			$('.ceng, #tz_confirm').show();
			Query.query_balance();
			$.subscribe("/login/success", D.render);
			$("#tz_cont div.pdLeft1:eq(0) div.redText p:eq(0)").html("是用"+integral+"积分报名参赛");
			$("#tz_cont div.pdLeft1:eq(1) div.redText p:eq(0)").html("是用"+award+"奖券报名参赛");
			
			$('#tz_cont div.btn_bg span:eq(0)').off().bind('click',function(){//积分充值
				if(typeof(fn) == "function"){fn();}
				$('.ceng, #tz_confirm').hide();
			});
			$('#tz_cont div.btn_bg span:eq(1)').off().bind('click',function(){//报名参赛
				if(typeof(fn1) == "function"){fn1();}
				$('.ceng, #tz_confirm').hide();
			});
			
			//关闭层
			$("#tz_confirm .ts_close").bind("click",function(){
				$('.ceng, #tz_confirm').hide();
			});
			
		}
};
***/

/***
var g={
		integral:0,//积分
		award:0,//奖券
		fps:1000
};
***/

//var username = localStorage.getItem("username");//获取用户名


/***
var Query={
		//查询各种余额
		query_balance:function(){
			this.integral_balance();
		},

		//积分余额
		integral_balance:function(){
			$.ajax({
				url : '/user/mlottery.go?flag=40',
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var point = R.attr("point");//积分
					
					//奖券余额
					$.ajax({
						url : '/activity/ticket.go?flag=2&visit=3000',
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							var R=$(xml).find("Resp");
							var award = R.attr("balance");
							var opt = {
									integral:point,
									award:award
							}
							g.integral=point;
							g.award=award;
							$.publish("/login/success", opt);//发布
						}
					});
				}
			});
		},

		
}
***/

XHC.DB=(function(){
	var init=function(){
		bindEvent();
		progressing();
		
	};
	
	
	
	//报名成功所需参数
	/***
	var sign_up_success_param={
			  flag:2,//操作标识，用来判断查询的逻辑，1表示查询用户是否报名过此期次，2表示进行报名操作 
			  cnickid:username,//当前登录用户名
			  periodid:"",//当前的期次号
			  stype:"2",//1表示用积分报名，2表示用奖券报名
			  pointRemain:0,//表示该用户剩余的积分
			  visit:3500//主要验证visit(来源)字段
	};
	***/
	
	var bindEvent=function(){
		//头部导航切换
		$("#nav span").bind("click",function(){
			var index=$(this).index();
			$(this).addClass("cur");
			$(this).siblings().removeClass("cur");
			if(index==0){//进行中
				$("#progress").show();
				$("#over").hide();
				progressing();
			}else{//已结束
				$("#progress").hide();
				$("#over").show();
				overing();
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
			
			D.confirm_tz(integral,ticket);
			
			
		});
		
		//报名成功
		$("#toSignUp").bind("click",function(){
			//sign_up_success_param.pointRemain=g.integral;
			
			if(g.integral<bm_jf_jq.integral){
				$("#lack_of_balance").show();
				return;
			}
			bm_success();
		});
		
		
		$("#progress").delegate("li","click",function(){
			var integral = bm_jf_jq.integral= $(this).attr("integral");//积分
			var ticket =bm_jf_jq.award= $(this).attr("ticket");//奖券
			var ticket =bm_jf_jq.periodid= $(this).attr("periodid");//奖券
			var mids = $(this).attr("mids");
			localStorage.setItem("mids", mids);
			localStorage.setItem("tmp_data", JSON.stringify(bm_jf_jq));
			window.location.href="cqdb.html";
		});
	};
	
	var progressing=function(){//开启销售，进行中
		var progressHTML=""
		$.ajax({
			url : '/grounder/takeinaccout.go?flag=5&pstate=0',
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
				
				var R= $(xml).find("Resp");
				var desc = R.attr("desc");
				var total = R.attr("total");//总条数
				var tpage = R.attr("tpage");//第几页
				
				var r = R.find("row");
				
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
					var itype = r.attr("itype");//类型   足球\篮球
					var mids = r.attr("mids");//类型   足球\篮球
					
					var iClass = (itype&&itype==1) ? "zu_bg" : "lan_bg";//区分足球、篮球颜色
					
					var tmpHTML="";
					if(currentnum<20){
						tmpHTML="不满20人退还报名费并奖励1万金豆";
					}else{
						tmpHTML="人数越多奖励越高";
					}
					
					//<i>03</i><i>11</i><i>08</i>
					progressHTML += '<li class="'+iClass+'" integral="'+integral+'" ticket="'+ticket+'" periodid="'+periodid+'" mids="'+mids+'">';
					progressHTML += '<label class="fivejq"></label>';
					progressHTML += '<div class="top_card">';
					progressHTML += '<span>'+periodid+'期</span>';
					progressHTML += '<span>剩余<span id="t_"></span></span>';//剩余时间
					progressHTML += '</div>';
					progressHTML += '<div class="main_card">';
					progressHTML += '<div>';
					progressHTML += '<span>已参与<i>'+currentnum+'</i>人</span>';
					progressHTML += '<span>剩余名额:<i>16</i></span>';
					progressHTML += '</div>';
					progressHTML += '<div>';
					progressHTML += '<span></span>';
					progressHTML += '</div>';
					progressHTML += '<div>'+tmpHTML+'</div>';
					progressHTML += '</div>';
					progressHTML += '<div class="btm_card">';
					progressHTML += '<span>第1名奖励: '+sendticket+'奖券x'+currentnum+'=<i>'+(parseInt(sendticket)*currentnum)+'</i>奖券</span>';
					progressHTML += '<span class="bm">报名参赛</span>';
					progressHTML += '</div>';
					progressHTML += '</li>';
					
					$("#progress").append(progressHTML);
					expect_change(n_,expiretime);
				});
				
			}
		});
	};
	
	
	var overing=function(){//开启销售，进行中
		var overHTML=""
		$.ajax({
			url : '/grounder/takeinaccout.go?flag=5&pstate=-1',
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
				
				
				var R= $(xml).find("Resp");
				var desc = R.attr("desc");
				var total = R.attr("total");//总条数
				var tpage = R.attr("tpage");//第几页
				
				var r = R.find("row");
				
				r.each(function(){
					var periodid = r.attr("periodid");//期次id
					var integral = r.attr("integral");//报名所需积分
					var ticket = r.attr("ticket");//报名所需奖券
					var chipnum = r.attr("chipnum");//初始筹码
					var currentnum = r.attr("currentnum");//当前参与人数
					var sendticket = r.attr("sendticket");//奖励奖券基数
					var pstate = r.attr("pstate");//期次状态(-1 未开售，0-进行中， 1-已截止，2-撤销  )
					var expiretime = r.attr("expiretime");//截止时间
					var sendnum = r.attr("sendnum");//有效计奖人数
					var itype = r.attr("itype");//类型   足球\篮球
					
					var fullnum = r.attr("fullnum");//满员人数
					var synum = r.attr("synum");//剩余人数
					
					var iClass = (itype&&itype==1) ? "zu_bg" : "lan_bg";//区分足球、篮球颜色
					
					overHTML += '<li class="'+iClass+'">';
					overHTML += '<label class="fivejq"></label>';
					overHTML += '<div class="top_card">';
					overHTML += '<span>'+periodid+'期</span>';
					overHTML += '<span>剩余<label><i>03</i><i>11</i><i>08</i></label></span>';//剩余时间
					overHTML += '</div>';
					overHTML += '<div class="main_card">';
					overHTML += '<div>';
					overHTML += '<span>已参与<i>'+currentnum+'</i>人</span>';
					overHTML += '<span>剩余名额:<i>'+synum+'</i></span>';
					overHTML += '</div>';
					overHTML += '<div>';
					overHTML += '<span></span>';
					overHTML += '</div>';
					overHTML += '<div>人数越多奖励越高</div>';
					overHTML += '</div>';
					overHTML += '<div class="btm_card">';
					overHTML += '<span>第1名奖励: '+sendticket+'奖券x'+currentnum+'=<i>'+(sendticket*currentnum)+'</i>奖券</span>';
					overHTML += '<span>报名参赛</span>';
					overHTML += '</div>';
					overHTML += '</li>';
				});
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
	}
	
	var eachClock=function(){
		this.now += g.fps;
		var diff = this.endtime_ - this.now;
		var msg = '';
		if(diff >= 0){
			timeout = diffToString(diff,false);
			//msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
			msg = '<i>'+timeout[1]+'</i><i>'+timeout[1]+'</i><i>'+CP.Util.pad(timeout[3],2)+'</i>';
			$("#t_").html(msg);
		}else{
			msg = '已截止';
			$("#t_").html(msg);
			
		}
	}
	
	 var expect_change = function(now, endtime){
		this.now = now.getTime();
		this.endtime_ = new Date(endtime.replace(/-/g , '/'));
		//this.atime_ = new Date(atime.replace(/-/g , '/'));
		clearInterval(this.timer);
		this.timer = setInterval(function(){
			eachClock();
		}, g.fps); 
		eachClock();
	}
	
	//报名参赛
	var entrants=function(){
		
	}
	
	return {
		init:init
	};
})();


$(function(){
	XHC.DB.init();
})

