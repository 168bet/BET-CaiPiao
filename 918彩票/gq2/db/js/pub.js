var o = $({});
$.subscribe = function () {o.on.apply(o, arguments);};
$.unsubscribe = function () {o.off.apply(o, arguments);};
$.publish = function () { o.trigger.apply(o, arguments);};

var g={
		integral:0,//积分
		award:0,//奖券
		fps:1000
};

var bm_jf_jq={
		integral:0,//积分
		award:0,//奖券
		periodid:""
};


var delFH = function(str){
	str = str.replace(/,/g,'');
	return str;
}

var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="100%"></figure><p>暂无赛事</p></article>';
//公用弹出层和加载层

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
							};
							g.integral=point;
							g.award=delFH(award);
							$.publish("/login/success", opt);//发布
						}
					});
				}
			});
		},
};


var D={
		render:function(e, opt){
			$("#tz_cont div.pdLeft1:eq(0) div.redText p:eq(1)").html("积分余额："+opt.integral);
			$("#tz_cont div.pdLeft1:eq(1) div.redText p:eq(1)").html("奖券余额："+opt.award);
			sign_up_success_param.pointRemain=opt.integral;//用户剩余积分
		},
		
		//integral-积分  award-奖券  integral_balance-积分余额  award_balance-奖券余额
		confirm_tz:function(integral,award,fn,fn1){
			$('.ceng, #tz_confirm').show();
			Query.query_balance();
			$.subscribe("/login/success", D.render);
			$("#tz_cont div.pdLeft1:eq(0) div.redText p:eq(0)").html("是用"+integral+"积分报名参赛");
			$("#tz_cont div.pdLeft1:eq(1) div.redText p:eq(0)").html("是用"+award+"奖券报名参赛");
			
			$('#tz_cont div.btn_bg span:eq(0)').off().bind('click',function(){//积分充值
				//if(typeof(fn) == "function"){fn();}
				window.locatin.href="/user/jfcz.html";
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
		},
		sendConfirm:function(fn,fn1){
			$('.zhezhao, #popup2').show();
			$('#popup2 div a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('.zhezhao, #popup2').hide();
			});
			$('#popup2 div a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn1) == "function"){fn1();}
				$('.zhezhao, #popup2').hide();
			});
		}
};

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

var username = localStorage.getItem("username");//获取用户名


//查询是否报名成功
var is_bm_param={
		  flag:1,//操作标识，用来判断查询的逻辑，1表示查询用户是否报名过此期次，2表示进行报名操作 
		  cnickid:username,//当前登录用户名
		  periodid:"",//当前的期次号
		  visit:3500//主要验证visit(来源)字段
};


var is_bm=function(){
	$.ajax({
		url : '/grounder/takeinaccout.go',
		type : "POST",
		data:is_bm_param,
		dataType : "xml",
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if(code==3){//处理成功
				$(".cs_btn").hide();
			}else{
				$(".cs_btn").show();
			}
		}
	});
}



//报名成功所需参数
var sign_up_success_param={
		  flag:2,//操作标识，用来判断查询的逻辑，1表示查询用户是否报名过此期次，2表示进行报名操作 
		  cnickid:username,//当前登录用户名
		  periodid:"",//当前的期次号
		  stype:"1",//1表示用积分报名，2表示用奖券报名
		  pointRemain:0,//表示该用户剩余的积分
		  visit:3500//主要验证visit(来源)字段
};

var bm_success=function(fn,obj){
	$.ajax({
		url : '/grounder/takeinaccout.go',
		type : "POST",
		data:sign_up_success_param,
		dataType : "xml",
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if(code==0){//处理成功
				alert(desc);
				if(fn && typeof(fn)=="function"){
					fn();
				};
				
				if(obj){
					obj.addClass("gray");
					obj.html("已报名");
				};
				$(".ceng").hide();
				$("#tz_confirm").hide();
				$(".cs_btn").hide();
			}else{
				alert(desc);
				$(".ceng").hide();
				$("#tz_confirm").hide();
			}
		}
	});
};