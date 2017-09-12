var XHC={}
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

var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="100%"></figure><p>暂无数据</p></article>';
XHC.JCZQ=(function(){
	
	//查询所需参数
	/***
	var Queryparam={
			"mtype":"4",//终端类型    不能为空    安卓 1，iOS 2，WP 3，触屏 4
			"appversion":"",//客户端版本号   只有触屏可以为空
			"flag":"0",//操作类型标识  0-查询类标识   1-增删改类标识
			"qtype":"0",//查询类操作 标识   flag=0时不可为空
			"phtype":"",//排行榜类型  qtype=4时不可为空
			"utype":"",//增删改类操作标识 flag=1时不可为空
			"usepoint":"",//utype=1时不可为空
			"psize":"10",//每页显示记录数,可为空
			"pnum":"1",//当前页数,可为空
			"date1":"",//查询开始日期,可为空
			"date2":"",//查询截止日期,可为空
			"mid":"",//场次id  phtype=s时不可为空
			"ddstatus":"",//竞猜记录类型 可为空  1-有效竞猜   2-无效竞猜    空-全部竞猜
			"cgameid":""//彩种类型 可为空   1-足球  2-篮球   空-不区分彩种
	};
	***/
	
	
	//查询所需参数
	var Queryparam={
			"mtype":"4",//终端类型    不能为空    安卓 1，iOS 2，WP 3，触屏 4
			"appversion":"",//客户端版本号   只有触屏可以为空
			"flag":"0",//操作类型标识  0-查询类标识   1-增删改类标识
			"qtype":"0",//查询类操作 标识   flag=0时不可为空
			"phtype":"",//排行榜类型  qtype=4时不可为空
			"utype":"",//增删改类操作标识 flag=1时不可为空
			"usepoint":"",//utype=1时不可为空
			"psize":"10",//每页显示记录数,可为空
			"pnum":"1",//当前页数,可为空
			"date1":"",//查询开始日期,可为空
			"date2":"",//查询截止日期,可为空
			"mid":"",//场次id  phtype=s时不可为空
			"ddstatus":"",//竞猜记录类型 可为空  1-有效竞猜   2-无效竞猜    空-全部竞猜
			"cgameid":"",//彩种类型 可为空   1-足球  2-篮球   空-不区分彩种
			"money":"",
			"zjcs":"",
			"gtype":""
			
	};
	
	//查询是否签到和今日参与人数
	var is_qd = function(){


		Queryparam.flag=0;
		Queryparam.qtype=3;
		$.ajax({
			url:'/grounder/fgoldenbeanaccount.go',
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var row = R.find("row");
				
				var fbzjcs3 = row.attr("fbzjcs3");
				var fbzjcs10 = row.attr("fbzjcs10");//中奖次数，领取字段
				
				var zjcs3 = row.attr("zjcs3");
				var zjcs10 = row.attr("zjcs10");//中奖次数，领取字段
				
				//足球
				var fbyjdtrjl = row.attr("fbyjdtrjl");//中奖次数，领取字段
				var fbphbpj = row.attr("fbphbpj");//中奖次数，领取字段
				var fbyphbpj = row.attr("fbyphbpj");//中奖次数，领取字段
				var fbyjdtr = row.attr("fbyjdtr");//足球昨日累计竞猜金豆
				
				var fbjdtrjl = row.attr("fbjdtrjl");//足球金豆投入，领取字段
				
				//篮球
				var yjdtrjl = row.attr("yjdtrjl");//中奖次数，领取字段
				var jdtrjl = row.attr("jdtrjl");//中奖次数，领取字段
				var phbpj = row.attr("phbpj");//中奖次数，领取字段
				var yphbpj = row.attr("yphbpj");//中奖次数，领取字段
				var yjdtr = row.attr("yjdtr");//篮球昨日累计竞猜金豆
				
				
				var fbyzjcs3 = row.attr("fbyzjcs3" );
				var fbyzjcs10 = row.attr("fbyzjcs10");
				
				var yzjcs3 = row.attr("yzjcs3");
				var yzjcs10 = row.attr("yzjcs10");
				
				var fbymzcs = row.attr("fbymzcs");
				var ymzcs = row.attr("ymzcs");
				var remainday = row.attr("remainday");//签到失效剩余天数
		
				
				var ctype = row.attr("ctype");//当前用户翻倍卡状态
				if(ctype==0){				
					$("#qdsx").html("购买“翻倍卡”,签到得<em style='color:red'>1000</em>倍金豆");
				}else if(ctype==1||ctype==2){
					$("#qdsx").html('正在使用“签到千倍卡”,<i class="red" >'+remainday+'</i>天后失效。');
				}else if(ctype==3||ctype==4){
					$("#qdsx").html("您购买的“签到翻倍卡”,次日开始生效");

				}

				
				
				
				

				
				
				
				


				
				
				
				//buy_golden_scope(fbyjdtrjl);
				
				var nickid = row.attr("cnickid");//用户名
				var balance = row.attr("balance");//用户名
				$("#user_account").html(nickid+'<em>('+balance+'金豆)</em>');
				

					var sqdcs = parseInt(row .attr("sqdcs"));//签到次数
					var isqd = row.attr("isqd");//是否签到 0-未签到 1-签到
										
					sqdcs=(sqdcs>=7&&isqd==0)?0:sqdcs;
					
					var mzcs = row.attr("mzcs");//篮球中奖次数
					var fbmzcs = row.attr("fbmzcs");//足球中奖次数
					
					
					
					
					var fbjdtr = parseInt(row.attr("fbjdtr"));//足球今日累计竞猜金豆3
					var jdtr = parseInt(row.attr("jdtr"));//篮球今日累计竞猜金豆3
					
				if(code==0){
					
					var jdstr = row.attr("jdstr").split(",");//签到乘以的倍数

					$(".jdtext li:eq(0) span").html("+"+(jdstr[0]==1?100:((parseInt(jdstr[0])*100)/10000+"万")));
					$(".jdtext li:eq(1) span").html("+"+(jdstr[1]==1?150:((parseInt(jdstr[1])*150)/10000+"万")));
					$(".jdtext li:eq(2) span").html("+"+(jdstr[2]==1?200:((parseInt(jdstr[2])*200)/10000+"万")));
					$(".jdtext li:eq(3) span").html("+"+(jdstr[3]==1?250:((parseInt(jdstr[3])*250)/10000+"万")));
					$(".jdtext li:eq(4) span").html("+"+(jdstr[4]==1?300:((parseInt(jdstr[4])*300)/10000+"万")));
					$(".jdtext li:eq(5) span").html("+"+(jdstr[5]==1?350:((parseInt(jdstr[5])*350)/10000+"万")));
					$(".jdtext li:eq(6) span").html("+"+(jdstr[6]==1?400:((parseInt(jdstr[6])*400)/10000+"万")));
					
					
					$("#ftr_t_jd dl dd:eq(0) cite").html(fbjdtr);
					$("#ftr_y_jd dl dd:eq(0) cite").html(fbyjdtr);
					
					
					$("#ltr_t_jd dl dd:eq(0) cite").html(jdtr);
					$("#ltr_y_jd dl dd:eq(0) cite").html(yjdtr);
					
					
					buy_golden_scope(fbjdtr,$("#ftr_t_jd dl dt cite"))
					buy_golden_scope(fbyjdtr,$("#ftr_y_jd dl dt cite"))
					
					buy_golden_scope(jdtr,$("#ltr_t_jd dl dt cite"))
					buy_golden_scope(yjdtr,$("#ltr_y_jd dl dt cite"))
					
					
					//足球今日投注送金豆
					if(fbjdtr>9999){//如果有投入
						if(fbjdtrjl==0){//足球本日累计竞猜金豆奖励是否已领取,0,未领取,1,已领取
							if(fbphbpj==0){//足球本日排行榜是否已派奖,0,未派奖,1,已派奖
								$("#ftr_t_jd dl dd:eq(1) b").html("未完成");
								//$("#ftr_t_jd dl").addClass("ywc");
								$("#ftr_t_jd dl dd:eq(1)").unbind("click");
								$("#ftr_t_jd dl dd:eq(0) span:eq(1)").html("进行中")
							}else{
								$("#ftr_t_jd dl dd:eq(1) b").html("领取");
								$("#ftr_t_jd").addClass("ywc");
								$("#ftr_t_jd dl dd:eq(0) span:eq(1)").html("完成")
							}
							
						}else{
							$("#ftr_t_jd dl dd:eq(1) b").html("已领取");
							//$("#ftr_t_jd dl").addClass("ywc");
							$("#ftr_t_jd dl dd:eq(1)").unbind("click");
							$("#ftr_t_jd dl dd:eq(0) span:eq(1)").html("完成")
						}
					}else{
						$("#ftr_t_jd dl dd:eq(1) b").html("未完成");
						//$("#ftr_t_jd dl").addClass("ywc");
						$("#ftr_t_jd dl dd:eq(1)").unbind("click");
						
						$("#ftr_t_jd dl dd:eq(0) span:eq(1)").html("进行中")
					}
					
					//足球昨日投注送金豆
					if(fbyjdtr>9999){//如果有投入
						if(fbyjdtrjl==0){//足球本日累计竞猜金豆奖励是否已领取,0,未领取,1,已领取
							if(fbyphbpj==0){//足球本日排行榜是否已派奖,0,未派奖,1,已派奖
								$("#ftr_y_jd dl dd:eq(1) b").html("未完成");
								//$("#ftr_y_jd dl").addClass("ywc");
								$("#ftr_y_jd dl dd:eq(1)").unbind("click");
								
								$("#ftr_y_jd dl dd:eq(0) span:eq(1)").html("进行中")
							}else{
								$("#ftr_y_jd dl dd:eq(1) b").html("领取");
								$("#ftr_y_jd").addClass("ywc");
								$("#ftr_y_jd dl dd:eq(0) span:eq(1)").html("完成")
							}
							
						}else{
							$("#ftr_y_jd dl dd:eq(1) b").html("已领取");
							//$("#ftr_y_jd dl").addClass("ywc");
							$("#ftr_y_jd dl dd:eq(1)").unbind("click");
							$("#ftr_y_jd dl dd:eq(0) span:eq(1)").html("完成")
						}
					}else{
						$("#ftr_y_jd dl dd:eq(1) b").html("未完成");
						//$("#ftr_y_jd dl").addClass("ywc");
						$("#ftr_y_jd dl dd:eq(1)").unbind("click");
						$("#ftr_y_jd dl dd:eq(0) span:eq(1)").html("进行中")
					}
					
					//篮球今日投注送金豆
					if(jdtr>9999){//如果有投入
						if(jdtrjl==0){//足球本日累计竞猜金豆奖励是否已领取,0,未领取,1,已领取
							if(phbpj==0){//足球本日排行榜是否已派奖,0,未派奖,1,已派奖
								$("#ltr_t_jd dl dd:eq(1) b").html("未完成");
								//$("#ftr_t_jd dl").addClass("ywc");
								$("#ltr_t_jd dl dd:eq(1)").unbind("click");
								
								$("#ltr_t_jd dl dd:eq(0) span:eq(1)").html("进行中")
							}else{
								$("#ltr_t_jd dl dd:eq(1) b").html("领取");
								$("#ltr_t_jd").addClass("ywc");
								$("#ltr_t_jd dl dd:eq(0) span:eq(1)").html("完成")
							}
							
						}else{
							$("#ltr_t_jd dl dd:eq(1) b").html("已领取");
							//$("#ftr_t_jd dl").addClass("ywc");
							$("#ltr_t_jd dl dd:eq(1)").unbind("click");
							$("#ltr_t_jd dl dd:eq(0) span:eq(1)").html("完成")
						}
					}else{
						$("#ltr_t_jd dl dd:eq(1) b").html("未完成");
						//$("#ftr_t_jd dl").addClass("ywc");
						$("#ltr_t_jd dl dd:eq(1)").unbind("click");
						$("#ltr_t_jd dl dd:eq(0) span:eq(1)").html("进行中")
					}
					
					//篮球昨日投注送金豆
					if(yjdtr>9999){//如果有投入
						if(yjdtrjl==0){//足球本日累计竞猜金豆奖励是否已领取,0,未领取,1,已领取
							if(yphbpj==0){//足球本日排行榜是否已派奖,0,未派奖,1,已派奖
								$("#ltr_y_jd dl dd:eq(1) b").html("未完成");
								//$("#ftr_y_jd dl").addClass("ywc");
								$("#ltr_y_jd dl dd:eq(1)").unbind("click");
								$("#ltr_y_jd dl dd:eq(0) span:eq(1)").html("进行中")
							}else{
								$("#ltr_y_jd dl dd:eq(1) b").html("领取");
								$("#ltr_y_jd").addClass("ywc");
								$("#ltr_y_jd dl dd:eq(0) span:eq(1)").html("完成")
							}
							
						}else{
							$("#ltr_y_jd dl dd:eq(1) b").html("已领取");
							//$("#ftr_y_jd dl").addClass("ywc");
							$("#ltr_y_jd dl dd:eq(1)").unbind("click");
							$("#ltr_y_jd dl dd:eq(0) span:eq(1)").html("完成")
						}
					}else{
						$("#ltr_y_jd dl dd:eq(1) b").html("未完成");
						//$("#ftr_y_jd dl").addClass("ywc");
						$("#ltr_y_jd dl dd:eq(1)").unbind("click");
						$("#ltr_y_jd dl dd:eq(0) span:eq(1)").html("进行中")
					}
					
					//中奖送金豆
					if(fbmzcs>=3 && fbmzcs<10){//中奖次数大于3次，小于10次
						$("#zj_jd div.zj:eq(1)").removeClass("ywc");
						$("#zj_jd div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						//$("#zj_jd div.zj:eq(1) dl dd:eq(1)").unbind("click");
						
						$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(fbmzcs+"/10")
						if(fbzjcs3==0){//未领取
							$("#f_cont div.zj:eq(0)").addClass("ywc")
							$("#f_cont div.zj:eq(0) dl dd:eq(1) b").html("领取");
							
							//$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
							
						}else{
							$("#f_cont div.zj:eq(0)").removeClass("ywc")
							$("#f_cont div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							
							!$("#f_cont div.zj:eq(0)").hasClass("ywc")||$("#f_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
							$("#f_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
							//$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
							
							//$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						}
						$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						
					}else if(fbmzcs>=10){
						if(fbzjcs3==0){
							$("#f_cont div.zj:eq(0)").addClass("ywc")
							$("#f_cont div.zj:eq(0) dl dd:eq(1) b").html("领取");
							$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						}else{
							$("#f_cont div.zj:eq(0)").removeClass("ywc")
							$("#f_cont div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
							$("#f_cont div.zj:eq(0) dl dd:eq(1)").unbind("click");
						}
						
						if(fbzjcs10==0){//未领取
							$("#f_cont div.zj:eq(1)").addClass("ywc")
							$("#f_cont div.zj:eq(1) dl dd:eq(1) b").html("领取");
							$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
						}else{
							$("#f_cont div.zj:eq(1)").removeClass("ywc")
							$("#f_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
							$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
							$("#f_cont div.zj:eq(1) dl dd:eq(1) b").html("已领取");
						}
						$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
					}else{
						$("#zj_jd div.zj:eq(0) dl dd:eq(1) b").html("未完成");
						$("#zj_jd div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						
						$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html(fbmzcs+"/3")
						$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(fbmzcs+"/10")
						
						$("#f_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						$("#f_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						
						$("#f_cont div.zj:eq(0) dl dd:eq(1)").unbind("click");
						$("#f_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
						
					}
					
					
					//中奖送金豆(篮球)
					if(mzcs>=3 && mzcs<10){//未完成
						$("#l_cont div.zj:eq(1)").removeClass("ywc");
						$("#l_cont div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						
						$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						
						$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(mzcs+"/10")
						
						$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						if(zjcs3==0){//未领取
							$("#l_cont div.zj:eq(0)").addClass("ywc")
							$("#l_cont div.zj:eq(0) dl dd:eq(1) b").html("领取");
						}else{
							$("#l_cont div.zj:eq(0)").removeClass("ywc")
							$("#l_cont div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							$("#l_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
						}
					}else if(mzcs>=10){
						if(zjcs3==0){//未领取
							$("#l_cont div.zj:eq(0)").addClass("ywc")
							$("#l_cont div.zj:eq(0) dl dd:eq(1) b").html("领取");
							$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						}else{
							$("#l_cont div.zj:eq(0)").removeClass("ywc")
							$("#l_cont div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
							$("#l_cont div.zj:eq(0) dl dd:eq(1)").unbind("click");
						}
						
						if(zjcs10==0){//未领取
							$("#l_cont div.zj:eq(1)").addClass("ywc")
							$("#l_cont div.zj:eq(1) dl dd:eq(1) b").html("领取");
							$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
						}else{
							$("#l_cont div.zj:eq(1)").removeClass("ywc")
							$("#l_cont div.zj:eq(1) dl dd:eq(1) b").html("已领取");
							$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
							$("#l_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
						}
						
						$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
					}else{
						//$("#zj_jd div.zj:eq(0)").addClass("ywc")
						$("#l_cont div.zj:eq(0) dl dd:eq(1) b").html("未完成");
						
						//$("#zj_jd div.zj:eq(1)").addClass("ywc")
						$("#l_cont div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						
						$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html(mzcs+"/3")
						$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(mzcs+"/10")
						
						$("#l_cont div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						$("#l_cont div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						
						$("#l_cont div.zj:eq(0) dl dd:eq(1)").unbind("click");
						$("#l_cont div.zj:eq(1) dl dd:eq(1)").unbind("click");
					}
					
					//昨天中奖送金豆
					if(fbymzcs>=3 && fbymzcs<10){//中奖次数大于3次，小于10次
						$("#zj_jd div.zj:eq(1)").removeClass("ywc");
						$("#zj_jd div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						//$("#zj_jd div.zj:eq(1) dl dd:eq(1)").unbind("click");
						
						$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(fbymzcs+"/10")
						if(fbyzjcs3==0){//未领取
							$("#f_cont_y div.zj:eq(0)").addClass("ywc")
							$("#f_cont_y div.zj:eq(0) dl dd:eq(1) b").html("领取");
							
							//$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
							
						}else{
							$("#f_cont_y div.zj:eq(0)").removeClass("ywc")
							$("#f_cont_y div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							
							!$("#f_cont_y div.zj:eq(0)").hasClass("ywc")||$("#f_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
							$("#f_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
							//$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
							
							//$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						}
						$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						
					}else if(fbymzcs>=10){
						if(fbyzjcs3==0){
							$("#f_cont_y div.zj:eq(0)").addClass("ywc")
							$("#f_cont_y div.zj:eq(0) dl dd:eq(1) b").html("领取");
							$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						}else{
							$("#f_cont_y div.zj:eq(0)").removeClass("ywc")
							$("#f_cont_y div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
							$("#f_cont_y div.zj:eq(0) dl dd:eq(1)").unbind("click");
						}
						
						if(fbyzjcs10==0){//未领取
							$("#f_cont_y div.zj:eq(1)").addClass("ywc")
							$("#f_cont_y div.zj:eq(1) dl dd:eq(1) b").html("领取");
							$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
						}else{
							$("#f_cont_y div.zj:eq(1)").removeClass("ywc")
							$("#f_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
							$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
							$("#f_cont_y div.zj:eq(1) dl dd:eq(1) b").html("已领取");
						}
						$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
					}else{
						$("#f_cont_y div.zj:eq(0) dl dd:eq(1) b").html("未完成");
						$("#f_cont_y div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						
						$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html(fbymzcs+"/3")
						$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(fbymzcs+"/10")
						
						$("#f_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						$("#f_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						
						$("#f_cont_y div.zj:eq(0) dl dd:eq(1)").unbind("click");
						$("#f_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
						
					}
					
					
					//昨天中奖送金豆(篮球)
					if(ymzcs>=3 && ymzcs<10){//未完成
						$("#l_cont_y div.zj:eq(1)").removeClass("ywc");
						$("#l_cont_y div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						
						$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						
						$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(ymzcs+"/10")
						
						$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						if(yzjcs3==0){//未领取
							$("#l_cont_y div.zj:eq(0)").addClass("ywc")
							$("#l_cont_y div.zj:eq(0) dl dd:eq(1) b").html("领取");
						}else{
							$("#l_cont_y div.zj:eq(0)").removeClass("ywc")
							$("#l_cont_y div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							$("#l_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
						}
					}else if(ymzcs>=10){
						if(yzjcs3==0){//未领取
							$("#l_cont_y div.zj:eq(0)").addClass("ywc")
							$("#l_cont_y div.zj:eq(0) dl dd:eq(1) b").html("领取");
							$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
						}else{
							$("#l_cont_y div.zj:eq(0)").removeClass("ywc")
							$("#l_cont_y div.zj:eq(0) dl dd:eq(1) b").html("已领取");
							$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html("3/3")
							$("#l_cont_y div.zj:eq(0) dl dd:eq(1)").unbind("click");
						}
						
						if(yzjcs10==0){//未领取
							$("#l_cont_y div.zj:eq(1)").addClass("ywc")
							$("#l_cont_y div.zj:eq(1) dl dd:eq(1) b").html("领取");
							$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
						}else{
							$("#l_cont_y div.zj:eq(1)").removeClass("ywc")
							$("#l_cont_y div.zj:eq(1) dl dd:eq(1) b").html("已领取");
							$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html("10/10")
							$("#l_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
						}
						
						$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
						$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("完成")
					}else{
						//$("#zj_jd div.zj:eq(0)").addClass("ywc")
						$("#l_cont_y div.zj:eq(0) dl dd:eq(1) b").html("未完成");
						
						//$("#zj_jd div.zj:eq(1)").addClass("ywc")
						$("#l_cont_y div.zj:eq(1) dl dd:eq(1) b").html("未完成");
						
						$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(1)").html(ymzcs+"/3")
						$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(1)").html(ymzcs+"/10")
						
						$("#l_cont_y div.zj:eq(0) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						$("#l_cont_y div.zj:eq(1) dl dd:eq(0) span:eq(1) em:eq(0)").html("进行中")
						
						$("#l_cont_y div.zj:eq(0) dl dd:eq(1)").unbind("click");
						$("#l_cont_y div.zj:eq(1) dl dd:eq(1)").unbind("click");
					}
					
					
					
					//签到送金豆
					
					
					if(isqd==0){//未签到
						
						if(sqdcs<4){
							if(sqdcs==0){
								$(".jdtext ul:eq(0) li:eq(0)").addClass("wqd");
							}else{
								$(".jdtext ul:eq(0) li:lt("+sqdcs+")").addClass("yqd");
								$(".jdtext ul:eq(0) li:eq("+(sqdcs)+")").addClass("wqd");
							}
						}else{
							var temp = sqdcs-4
							$(".jdtext ul:eq(0) li").addClass("yqd");
							if(sqdcs==4){
								$(".jdtext ul:eq(1) li:eq("+temp+")").addClass("wqd")
							}else{
								$(".jdtext ul:eq(1) li:lt("+temp+")").addClass("yqd");
								$(".jdtext ul:eq(1) li:eq("+(temp)+")").addClass("wqd");
							}
							
						}
						
						
						$(".jdpopup").show();
						$(".mask").show();
					}else{
						if(sqdcs<4){
							$(".jdtext ul:eq(0) li:lt("+sqdcs+")").addClass("yqd");
						}else{
							var temp = sqdcs-4
							$(".jdtext ul:eq(0) li").addClass("yqd");
							$(".jdtext ul:eq(1) li:lt("+temp+")").addClass("yqd");
							
						}
						
						$("#get_jd").addClass("graybg");
						$("#get_jd").html("已签到");
						$("#get_jd").unbind("click")
					}
					//$("#cyrs").html(new_cyrs);
					//$("#user_account").html(nickid+'<em>('+balance+'金豆)</em>');
					//$("#qdnum").html(sqdcs+"天");
					remove_C();
				}else if(code==1){
					window.location.href="/gq2/login.html";
				}
			}
		})

	
	}
	
	 var cutStr= function(n){
		   var b=parseInt(n).toString();
		   var len=b.length;
		   if(len<=3){return b;}
		   var r=len%3;
		   return r>0?b.slice(0,r)+","+b.slice(r,len).match(/\d{3}/g).join(","):b.slice(r,len).match(/\d{3}/g).join(",");
		 } 
	
	var getGolden = function(){
		$.ajax({
			async:false,
			url:'/grounder/fgoldenbeanaccount.go?flag=0&qtype=5',
			type: 'GET',
			dataType: 'xml',
			timeout: 1000,
			success: function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				//userinfo code="0" desc="查询成功" source="null" total="1" tpage="1" balance="6101407.0"
				if(code==0){//查询成功
					var userinfo  = R.find("userinfo ");
					var balance = userinfo.attr("balance");
					var balance=cutStr(balance);
					$("#user_account em").html("("+balance+"金豆)");
				}else if(code==1){
					window.location.href="login.html";
				}
			}
		})
	}
	
	var remove_C = function(){
		if($("#f_cont div.zj").hasClass("ywc")||$("#l_cont div.zj").hasClass("ywc") || $("#f_cont_y div.zj").hasClass("ywc")  || $("#l_cont_y div.zj").hasClass("ywc")  ){
			$("#qd_nav li:eq(1)").addClass("yxq");
		}else{
			$("#qd_nav li:eq(1)").removeClass("yxq");
		}
		if($("#ftr_t_jd").hasClass("ywc")||$("#ftr_y_jd").hasClass("ywc")||$("#ltr_t_jd").hasClass("ywc")||$("#ltr_y_jd").hasClass("ywc")){
			$("#qd_nav li:eq(2)").addClass("yxq");
		}else{
			$("#qd_nav li:eq(2)").removeClass("yxq");
		}
		if(!$("#get_jd").hasClass("graybg")){
			$("#qd_nav li:eq(0)").addClass("yxq");
		}else{
			$("#qd_nav li:eq(0)").removeClass("yxq");
		}
		
		
		if($("#qd_nav li:eq(1)").hasClass("yxq")||$("#qd_nav li:eq(2)").hasClass("yxq")||$("#qd_nav li:eq(0)").hasClass("yxq")){
			$("#dot").show();
		}else{
			$("#dot").hide();
		}
	}
	
	//投注领取金豆值的范围
	var buy_golden_scope=function(param,obj){
		var str="+0";
		if (param >= 1e4 && param < 5e4) {
			str = "+100"
		} else if (param >= 5e4 && param < 1e5) {
			str = "+500"
		} else if (param >= 1e5 && param < 5e5) {
			str = "+1000"
		} else if (param >= 5e5 && param < 1e6) {
			str = "+5000"
		} else if (param >= 1e6) {
			str = "1%"
		}
		
		$(obj).html(str);
	}
	
	var bindEvent=function(){
		var urlArr={
				"0":"bkbc.html",
				"1":"phb.html",
				"2":"fx.html",
				"3":"myjc.html",
		};
		
		$(".kcfooter li").bind("click",function(){
			
			var index=$(this).index();
			
			window.location.href=urlArr[index];
		})
		
		$("#ts").bind("click",function(){			
			$(".jcpop").show();	
			$(".mask").show();	
			
		})
		$(".jctrue").bind("click",function(){			
			$(".jcpop").hide();
			$(".mask").hide();	
		})		
		
		$(".up").bind("click",function(){
			$(this).parent().next().toggle();
			$(this).toggleClass("down");
		});
		
		
		$("#tab1").bind("click",function(){
			window.location.href="/gq2/hdjd.html";
		});
		$("#tab2").bind("click",function(){
			
			window.location.href="/gq2/jdmx.html";
		});
		$("#tab3").bind("click",function(){
			
			window.location.href="/gq2/jpzx/";
		});
		
		$("#sign").bind("click",function(){
			//$(".jdpopup").show();
			//$(".mask").show();
			$(".jdpopup").show();
			$(".mask").show();
			//is_qd();
		})
		
		
		$("#get_jd").bind("click",function(){
			Queryparam.flag=1;
			Queryparam.utype=0;
			Queryparam.qtype=0;			
			$.ajax({
				url:"/grounder/goldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						
						var row = R.find("row");
						var balance = row.attr("balance");//账户余额
						var daward = row.attr("daward");//当日盈利
						var taward = row.attr("taward");//总盈利
						var dpm = row.attr("dpm");//当日排名
						var tpm = row.attr("tpm");//总排行
						var isqd = row.attr("isqd");//是否签到
						
						if($(".jdtext ul:eq(0) li").hasClass("wqd")){
							var index = $(".jdtext ul:eq(0) li.wqd").index();
							
							$(".jdtext ul:eq(0) li:eq("+index+")").removeClass("wqd");
							$(".jdtext ul:eq(0) li:eq("+index+")").addClass("yqd");
							/***
							if(index<3){
								$(".jdtext ul:eq(0) li:eq("+(index+1)+")").addClass("wqd");
							}
							***/
						}else if($(".jdtext ul:eq(1) li").hasClass("wqd")){
							var index = $(".jdtext ul:eq(1) li.wqd").index();
							
							$(".jdtext ul:eq(1) li:eq("+index+")").removeClass("wqd");
							$(".jdtext ul:eq(1) li:eq("+index+")").addClass("yqd");
							/***
							if(index<2){
								$(".jdtext ul:eq(0) li:eq("+(index+1)+")").addClass("wqd");
							}
							***/
						}
						
						$("#get_jd").addClass("graybg");
						$("#get_jd").html("已签到");
						$("#get_jd").unbind("click");
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						remove_C();
						//$(".jdpopup").hide();
						//$(".zhezhao").hide();
						//account_info();
					}else{
						alert(desc);
					}
				}
			});
		})
		
		
		
		//足球领取金豆(中奖)
		$("#f_cont div.zj").find("dl dd:eq(1)").bind("click",function(){
			if(!$(this).parent().parent().hasClass("ywc")){
				$(this).find("dl dd:eq(1)").unbind("click");
				return;
			}
			//!$(this).hasClass("ywc")||$(this).find("dl dd:eq(1)").unbind("click");
			var index = $(this).parent().parent().index();
			if(index==0){
				Queryparam.zjcs=3;
			}else{
				Queryparam.zjcs=10;
			}
			Queryparam.flag=1;
			Queryparam.utype=3;
			Queryparam.qtype="";
			$.ajax({
				url:"/grounder/fgoldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						$("#f_cont div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>")
						
						$("#f_cont div:eq("+index+")").removeClass("ywc");//样式变灰
						//$("#f_cont div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>");//改变内容
						$("#f_cont div:eq("+index+")").find("dl dd:eq(1)").unbind("click");//解除绑定
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						remove_C()
					}else{
						alert(desc);
					}
				}
			});
		});
		
		//篮球领取金豆(中奖)
		$("#l_cont div.zj").find("dl dd:eq(1)").bind("click",function(){
			if(!$(this).parent().parent().hasClass("ywc")){
				$(this).unbind("click");
				return;
			}
			var index = $(this).parent().parent().index();
			if(index==0){
				Queryparam.zjcs=3;
			}else{
				Queryparam.zjcs=10;
			}
			Queryparam.flag=1;
			Queryparam.utype=3;
			Queryparam.qtype=0;
			$.ajax({
				url:"/grounder/goldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						
						var row = R.find("row");
						var balance = row.attr("balance");//账户余额
						var daward = row.attr("daward");//当日盈利
						var taward = row.attr("taward");//总盈利
						var dpm = row.attr("dpm");//当日排名
						var tpm = row.attr("tpm");//总排行
						var isqd = row.attr("isqd");//是否签到
						
						$("#l_cont div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>")
						
						$("#l_cont div:eq("+index+")").removeClass("ywc");//样式变灰
						$("#l_cont div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>");//改变内容
						$("#l_cont div:eq("+index+")").find("dl dd:eq(1)").unbind("click");//解除绑定
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						//account_info();
						remove_C();
					}else{
						alert(desc);
					}
				}
			});
		})
			//昨天足球领取金豆(中奖)
		$("#f_cont_y div.zj").find("dl dd:eq(1)").bind("click",function(){
			if(!$(this).parent().parent().hasClass("ywc")){
				$(this).find("dl dd:eq(1)").unbind("click");
				return;
			}
			//!$(this).hasClass("ywc")||$(this).find("dl dd:eq(1)").unbind("click");
			var index = $(this).parent().parent().index();
			if(index==0){
				Queryparam.zjcs=3;
			}else{
				Queryparam.zjcs=10;
			}
			Queryparam.flag=1;
			Queryparam.utype=3;
			Queryparam.qtype="";
			Queryparam.gtype=1;
			$.ajax({
				url:"/grounder/fgoldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						$("#f_cont_y div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>")
						
						$("#f_cont_y div:eq("+index+")").removeClass("ywc");//样式变灰
						//$("#f_cont div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>");//改变内容
						$("#f_cont_y div:eq("+index+")").find("dl dd:eq(1)").unbind("click");//解除绑定
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						remove_C()
					}else{
						alert(desc);
					}
				}
			});
		});
		
		//昨天篮球领取金豆(中奖)
		$("#l_cont_y div.zj").find("dl dd:eq(1)").bind("click",function(){
			if(!$(this).parent().parent().hasClass("ywc")){
				$(this).unbind("click");
				return;
			}
			var index = $(this).parent().parent().index();
			if(index==0){
				Queryparam.zjcs=3;
			}else{
				Queryparam.zjcs=10;
			}
			Queryparam.flag=1;
			Queryparam.utype=3;
			Queryparam.qtype=0;
			Queryparam.gtype=1;

			$.ajax({
				url:"/grounder/goldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						
						var row = R.find("row");
						var balance = row.attr("balance");//账户余额
						var daward = row.attr("daward");//当日盈利
						var taward = row.attr("taward");//总盈利
						var dpm = row.attr("dpm");//当日排名
						var tpm = row.attr("tpm");//总排行
						var isqd = row.attr("isqd");//是否签到
						
						$("#l_cont_y div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>")
						
						$("#l_cont_y div:eq("+index+")").removeClass("ywc");//样式变灰
						//$("#l_cont_y div:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>");//改变内容
						$("#l_cont_y div:eq("+index+")").find("dl dd:eq(1)").unbind("click");//解除绑定
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						//account_info();
						remove_C();
					}else{
						alert(desc);
					}
				}
			});
		})
		
		
		//领取足球累计(累计投入金豆)
		$("#f_t_cont div.ft").find("dl dd:eq(1)").bind("click",function(){
			var index = $(this).parent().parent().index();
			if(index==0){
				Queryparam.gtype=0;
			}else{
				Queryparam.gtype=1;
			}
			Queryparam.flag=1;
			Queryparam.utype=4;
			Queryparam.qtype=0;
			$.ajax({
				url:"/grounder/fgoldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						
						var row = R.find("row");
						var balance = row.attr("balance");//账户余额
						var daward = row.attr("daward");//当日盈利
						var taward = row.attr("taward");//总盈利
						var dpm = row.attr("dpm");//当日排名
						var tpm = row.attr("tpm");//总排行
						var isqd = row.attr("isqd");//是否签到
						
						$("#f_t_cont div.ft:eq("+index+")").removeClass("ywc");//样式变灰
						$("#f_t_cont div.ft:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>");//改变内容
						$("#f_t_cont div.ft:eq("+index+")").find("dl dd:eq(1)").unbind("click");//解除绑定
						$("#f_t_cont div.ft:eq("+index+")").find("dl dd:eq(0) span:eq(1)").html("完成")
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						remove_C();
						//account_info();
					}else{
						alert(desc);
					}
				}
			});
		})
		
		//领取篮球累计()
		$("#l_t_cont div.lt").find("dl dd:eq(1)").bind("click",function(){
			var index = $(this).parent().parent().index();
			if(index==0){
				Queryparam.gtype=0;
			}else{
				Queryparam.gtype=1;
			}
			Queryparam.flag=1;
			Queryparam.utype=4;
			Queryparam.qtype=0;
			$.ajax({
				url:"/grounder/goldenbeanaccount.go",
				dataType:'xml',
				data:Queryparam,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){
						
						
						var row = R.find("row");
						var balance = row.attr("balance");//账户余额
						var daward = row.attr("daward");//当日盈利
						var taward = row.attr("taward");//总盈利
						var dpm = row.attr("dpm");//当日排名
						var tpm = row.attr("tpm");//总排行
						var isqd = row.attr("isqd");//是否签到
						
						$("#l_t_cont div.lt:eq("+index+")").removeClass("ywc");//样式变灰
						$("#l_t_cont div.lt:eq("+index+")").find("dl dd:eq(1)").html("<b>已领取</b>");//改变内容
						$("#l_t_cont div.lt:eq("+index+")").find("dl dd:eq(1)").unbind("click");//解除绑定
						$("#l_t_cont div.lt:eq("+index+")").find("dl dd:eq(0) span:eq(1)").html("完成")
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						remove_C();
						//account_info();
					}else{
						alert(desc);
					}
				}
			});
		});
		
		
		$("#qd_nav li").bind("click",function(){
			var index = $(this).index();
			
			$(this).addClass("cur").siblings().removeClass("cur");
			
			$("#qd_cont article:eq('"+index+"')").show();
			$("#qd_cont article:eq('"+index+"')").siblings().hide();
		})
		
		$(".jdclock").bind("click",function(){
			$(".jdpopup").hide();
			$(".mask").hide();
		})
		
		
		$("#betting_nav li").bind("click",function(){
			Queryparam.pnum=1
			$(".myRecord").html("");
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}else{
				l_bet_list(index);
			}
			
		});
		
		$(".myAccount2 li").bind("click",function(){
			Queryparam.pnum=1
			$(".myRecord").html("");
			$("#betting_nav li:first").addClass("cur").siblings().removeClass("cur");
			$(this).addClass("cur").siblings().removeClass("cur");
			if($(this).index()==0){
				$("#ts").show();
				$("#betting_nav li:eq(1)").html("有效竞猜");
				$("#betting_nav li:eq(2)").html("无效竞猜");
				z_bet_list(0);
			}else{
				$("#ts").hide();
				$("#betting_nav li:eq(1)").html("已结算竞猜");
				$("#betting_nav li:eq(2)").html("未结算竞猜");
				l_bet_list(0);
			}
		});
		
		$(".more").bind("click",function(){
			
			var index=$("#betting_nav li.cur").index();
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}else{
				l_bet_list(index);
			}
		});
		
		
		
		$("#card_href").bind("click",function(){
			window.location.href="/gq2/sign/qdfb.html"
		});
		
		/***
		$("#z_more").bind("click",function(){
			
			var index=$("#betting_nav li.cur").index();
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}
		});
		
		$("#l_more").bind("click",function(){
			
			var index=$("#betting_nav li.cur").index();
			if($(".myAccount2 li:eq(0)").hasClass("cur")){
				z_bet_list(index);
			}
		});
		***/
	};
	
	
	
	//初始化
	var init = function(){
	//	account_info();
		z_bet_list(0);
		//l_bet_list(0)
		bindEvent();
		is_qd();
	};
	
	
	
	//sqdcs="0" mzcs="0" jdtr="0" fbmzcs="0" fbjdtr="0" balance="10,400" daward="0" taward="0"
	//dpm="100+" tpm="100+" isqd="0" nickid="墨家乙" point="1020"
	//账户信息
	/**
	var account_info=function(){
		Queryparam.flag=0;
		Queryparam.qtype=3;
		$.ajax({
			url:'/grounder/goldenbeanaccount.go',
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code==0){
					var row = R.find("row");
					var balance = row.attr("balance");//账户余额
					var nickid = row.attr("nickid");//用户名
					var isqd = row.attr("isqd");//是否签到 0-未签到 1-签到
					
					var daward = row.attr("daward");
					var dpm = row.attr("dpm");

					if(daward!=0){
						//$("#pm").show();
						$("#pm").html("<div> <span>&nbsp;&nbsp;您今日盈利<em>"+daward+"</em>金豆，排第<em>"+dpm+"</em>名<span></div>");
					}else{
						$("#pm").hide();
					}

					
			
					$("#user_account").html(nickid+'<em>('+balance+'金豆)</em>');
				}else if(code==1){
					window.location.href="/gq2/login.html";
				}else{
					alert(desc);
				}
			}
		})

	}
	**/
	
	//投注记录
	//足球记录
	var z_bet_list=function(index){
		var html=$(".myRecord").html();
		url = '/grounder/fgoldenbeanaccount.go';
		Queryparam.qtype=1;
		
		if(index==0){
			Queryparam.ddstatus="";//全部方案
		}else if(index==1){
			Queryparam.ddstatus="1";//有效竞猜
		}else if(index==2){
			Queryparam.ddstatus="2";//无效竞猜
		}
		
		$.ajax({
			url:url,
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var jcrecords = R.find("jcrecords");
				var total = jcrecords.attr("total");
				var tpage = jcrecords.attr("tpage");
				
				
				if(total==0){
					$(".myRecord").html(nodata);
					$(".more").hide();
				}else{
					if(code==0){
						var row = R.find("row");
						var len = row.length;
						if(Queryparam.pnum<=tpage){
							row.each(function(){
								var jctime = $(this).attr("jctime").substr(5);
								var jctm = $(this).attr("jctm");
								var tzxx = $(this).attr("tzxx");
								var wftype = $(this).attr("wftype");
								var section = $(this).attr("section");
								var tzjd = $(this).attr("tzjd");
								var result = $(this).attr("result");
								var isjj = $(this).attr("isjj");
								var ispj = $(this).attr("ispj");
								var sp = $(this).attr("sp");
								var xxcg = $(this).attr("xxcg");
								var award = $(this).attr("award");
								var cretdate = $(this).attr("cretdate");
								var relwin = $(this).attr("relwin");
								//var relwin_text=(relwin==1)?"赢":(relwin==2)?"输一半":(relwin==3)?"赢一半":(relwin==4)?"输":(relwin==5)?"不输不赢":"--";
								var relwin_text="--";
								var c="red";
								if(relwin==1){
									relwin_text="赢"
										c="red";
								}else if(relwin==2){
									relwin_text="输一半"
										c="red"
								}else if(relwin==3){
									relwin_text="赢一半"
										c="red";
								}else if(relwin==4){
									relwin_text="输"
								}else if(relwin==5){
									relwin_text="不输不赢"
								}else{
									relwin_text="&nbsp;"
								}
								
								if(jctm.length>12){
									var tmp1 = jctm.substr(0,4)
									var tmp2 = jctm.substr(-7)
									
									jctm = tmp1+tmp2
								}
								
								html += '<ul>';
								html += '<li>';
								html += '<p><span>'+jctm+'</span><br><span>'+tzxx+'</span><cite>'+sp+'</cite></p>';
								html += '<p><b>投入'+tzjd+'</b><em>'+relwin_text+'</em></p>';
								html += '</li>';
								html += '<li>';
								html += '<p>'+jctime+'</p>';//02/07 12:11:28
								if(xxcg!="--"){
									html += '<p>比分:'+xxcg+'</p>';//02/07 12:11:28
								}else{
									html += '<p>&nbsp;</p>';//02/07 12:11:28

								}
								award = award.replace(/,/g,"");
								/**
								if(isNaN(award)){
									html += '<p>'+award+'</p>';
								}else{
									html += '<p class="'+c+'">返还'+award+'</p>';
								}
								***/
								if((relwin==1||relwin==3) && (ispj==2)){
									html += '<p class="'+c+'">返还'+award+'</p>';
								}else if((relwin==2||relwin==5)&&(ispj==2)){
									html += '<p>返还'+award+'</p>';
								}else{
									html += '<p>'+award+'</p>';
								}
								
								html += '</li>';
								html += '</ul>';
							});
							
							if(tpage==Queryparam.pnum){
								$(".more").hide()
							}else{
								$(".more").show().css("display","block");
							}
							Queryparam.pnum++;
						}else{
							$(".more").hide();
							return;
						}
					}
					
					$(".myRecord").html(html);
				}
				
			}
		})
		
		
		//分类信息
		//dist(index);
	};
	
	
	//篮球记录
	var l_bet_list=function(index){
		var html=$(".myRecord").html();
		url = '/grounder/goldenbeanaccount.go';
		Queryparam.qtype=1;
		
		if(index==0){
			Queryparam.ddstatus="";//全部方案
		}else if(index==1){
			Queryparam.ddstatus="1";//有效竞猜
		}else if(index==2){
			Queryparam.ddstatus="2";//无效竞猜
		}
		
		$.ajax({
			url:url,
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				var jcrecords = R.find("jcrecords");
				var total = jcrecords.attr("total");
				var tpage = jcrecords.attr("tpage");
				if(total==0){
					$(".myRecord").html(nodata);
					$(".more").hide();
				}else{
					if(code==0){
						var jcrecords = R.find("jcrecords");
						var row = jcrecords.find("row");
						var len = row.length;
						if(len>0){
							row.each(function(){
								var month = $(this).attr("month");
								var day = $(this).attr("day");
								var jctm = $(this).attr("jctm");
								var section = $(this).attr("section");
								var wftype = $(this).attr("wftype");
								var tzxx = $(this).attr("tzxx");
								var sp = $(this).attr("sp");
								var tzjd = $(this).attr("tzjd");
								var result = $(this).attr("result");
								var isjj = $(this).attr("isjj");
								var award = $(this).attr("award");
								var jctime = $(this).attr("jctime").substr(5);
								
								
								html += '<ul>';
								html += '<li>';
								html += '<p><span>'+jctm+'</span><br><span>'+tzxx+'</span><cite>'+sp+'</cite></p>';
								html += '<p><b>投入'+tzjd+'</b><em>&nbsp;</em></p>';
								html += '</li>';
								html += '<li>';
								html += '<p>'+jctime+'</p>';//02/07 12:11:28
								html += '<p>&nbsp;</p>';
								award = award.replace(/,/g,"");
								if(isNaN(award.substr(0,1))){//因为45,655 带逗号，判断第一位是否为数字即可
									html += '<p>'+award+'</p>';
								}else{
									html += '<p class="red">返还'+award+'</p>';
								}
								html += '</li>';
								html += '</ul>';
							});
							
							if(tpage==Queryparam.pnum){
								$(".more").hide()
							}else{
								$(".more").show().css("display","block");
							}
							Queryparam.pnum++;
						}else{
							$(".more").hide();
							return;
						}
					}
					
					$(".myRecord").html(html);
				}
				
			}
		})
	};
	
	
	
	var dist=function(index){
		if(index==0){
			Queryparam.ddstatus="";//全部方案
		}else if(index==1){
			Queryparam.ddstatus="1";//有效竞猜
		}else if(index==2){
			Queryparam.ddstatus="2";//无效竞猜
		}
		
		Queryparam.qtype=1;
		
		$.ajax({
			url:url,
			data:Queryparam,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				
			}
		})
	};
	
	
	return {
		init:init
	}
})()

$(function(){
	XHC.JCZQ.init();
});

var remove_header=function(){
	var arg = localStorage.getItem("from");
	if(arg){
		$(".tzHeader").hide();
	}else{
		$(".tzHeader").show();
	}
}
remove_header();
