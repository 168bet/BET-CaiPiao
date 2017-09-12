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

CP.KP=(function(){
	var cgameid=location.search.getParam("cgameid");
	
	var g={
			qid:"",//期次id
			fps :1000
	};
	var kjTimer = function(){}//定时刷新数据
	var pic_obj={
			"1":"one",
			"2":"two",
			"3":"three",
			"4":"four",
			"5":"five",
			"6":"six"
	};
	
	//投注所需参数
	var betting_param={
			"flag":"1",
			"utype":"0",
			"cgameid":cgameid,//彩种id
			"cperiodid":g.qid,//期次id
			"tzmoney":"",//投注金豆
			"wftype":"",//玩法类型(0/1/2分别表示大小/顺子/豹子玩法)
			"mtype":"4",//投注来源
			"ccodes":"",//投注号码，0表示小，1表示大/顺子/豹子。
	};
	//数字
	var sz_str="123,132,213,231,321,312,234,243,324,432,324,423,354,435,453,543,534,345,456,465,546,564,645,654";
	var dz_str="111,222,333,444,555,666";
	var last_flag="";//判断是否有当前期

	var o={
			//获取期次信息
			info:function(){
				last_flag="";
				function main(date1){
					var ls_html="";
					if (typeof(date1) == "undefined"){
						date1="";
					}
					$.ajax({
						url : '/grounder/kpgoldbeanaccout.go?flag=0&qtype=2&cgameid='+cgameid+"&date1="+date1+"&psize=12",
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							var R = $(xml).find("Resp");
							var row = R.find("row");
							
							var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
							
							
							row.each(function(i){
								var id = $(this).attr("id");
								var cgameid = $(this).attr("cgameid");//彩种id
								var cperiodid = $(this).attr("cperiodid");//期次id
								//cperiodid=cperiodid.substr(-3)
								var etime = $(this).attr("etime");//期次截止时间
								var atime = $(this).attr("atime");//期次开奖时间
								var kjcodes = $(this).attr("kjcodes");//开奖号码
								var iscurrent = $(this).attr("iscurrent");//是否是当前期，为1表示是当前期
									last_flag=last_flag+","+iscurrent;//存在当前期

								if(i==0){//当前期
									if(iscurrent==1){//当前期
										g.qid = cperiodid;//期次id
										$('#jz_').html('距离<cite id="qc_id">'+g.qid.substr(-3)+'</cite>期竞猜截止还剩: <i></i>');
										expect_change(n_, etime);//n_当前时间  a截止时间
										if(g.qid.substr(-3)=="001"){
											if(cgameid=="06"){
												$(".ts_kjq p:eq(0)").html("每天8:40~22:00");
											}else if(cgameid=="08"){
												$(".ts_kjq p:eq(0)").html("每天9:30~22:00");
											}else if(cgameid=="09"){
												$(".ts_kjq p:eq(0)").html("每天8:30~22:10");
											}
											//alert(1)
											$(".ts_kjq").show();
										}else{
											$(".ts_kjq").hide();	
										}
										
//										if ( g.cIssue == ){
//											
//										}
										
									}
								}
								
								if(i==1){//上一期
									if(kjcodes && kjcodes!=""){
										$("#kj_cont").html(cperiodid.substr(-3)+"期开奖:");
										$("#prev_num").show();
										var kjcode_arr = kjcodes.split(",");
										$("#prev_num span:eq(0)").addClass(pic_obj[kjcode_arr[0]]);
										$("#prev_num span:eq(1)").addClass(pic_obj[kjcode_arr[1]]);
										$("#prev_num span:eq(2)").addClass(pic_obj[kjcode_arr[2]]);
										
										
										$("#wait").hide();
										$("#kj_ing").show();
										
										window.setTimeout(function(){
											$("#prev_num span:eq(0)").removeClass("ani_sz1");
											$("#prev_num span:eq(1)").removeClass("ani_sz2");
											$("#prev_num span:eq(2)").removeClass("ani_sz3");
										}, 1000);
										clearInterval(kjTimer);
									}else{
										$("#wj").html(cperiodid.substr(-3)+"期开奖中,请稍后~");
										$("#prev_num").hide();
										$("#wait").show();
										$("#kj_ing").hide();
									}
									
								}
								
								if(i<11&&i>0){
									if(kjcodes){
										var kj_arr=kjcodes.split(",");
										
										var tmp_type = kjcodes.replace(/,/g,"");
										
										var tm = (parseInt(kj_arr[0])+parseInt(kj_arr[1])+parseInt(kj_arr[2]))
										var big=""
										if(tm>10){
											big="大"
										}else{
											big="小"
										}
										ls_html+='<ul>';
										ls_html+='<li>'+cperiodid.substr(-3)+'</li>';
										ls_html+='<li>';
										ls_html+='<span class="'+pic_obj[kj_arr[0]]+'"></span>';
										ls_html+='<span class="'+pic_obj[kj_arr[1]]+'"></span>';
										ls_html+='<span class="'+pic_obj[kj_arr[2]]+'"></span>';
										ls_html+='</li>';
										ls_html+='<li>'+tm+'('+big+')</li>';
										if(kj_arr[0]==kj_arr[1] && kj_arr[0]==kj_arr[2] && kj_arr[1]==kj_arr[2]){
											ls_html+='<li>豹子</li>';
										}else if(sz_str.indexOf(tmp_type)>=0){
											ls_html+='<li>顺子</li>';
										}else{
											ls_html+='<li>--</li>';
										}
										
										ls_html+='</ul>';
									}else{
										ls_html+='<ul>';
										ls_html+='<li>'+cperiodid.substr(-3)+'</li>';
										ls_html+='<li>等待开奖..</li>';
										ls_html+='<li></li>';
										ls_html+='<li></li>';
										ls_html+='</ul>';
									}
								}
							});
							$(".ls_kj").html(ls_html);
							
							if(last_flag.indexOf("1")==-1){
								
								var today="";
								var now = new Date();//今天
								var date = new Date((now/1000+86400*1)*1000);//明天	
								var y = date.getFullYear();
								var m = date.getMonth()+1;
								m = m<10?"0"+m:m;
								var d = date.getDate();
								d = d<10?"0"+d:d;
								today=y.toString()+"-"+m.toString()+"-"+d.toString();
								
										
										$("#prev_num").hide();
	
										
										$("#kj_cont").hide();
								
								last_flag=="";
								main(today)
							}
							
						}
					});
				}
				
				function diffToString(num, iscn) {
					var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
					var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
					for (var i = 0, l = unit.length; i < l; i++) {
						date[i] = parseInt(num / unit[i]);
						cnDate[i] = date[i] + cn[i];
						num %= unit[i];
					}
					return iscn ? cnDate : date;
				}
				
				function eachClock(){
					this.now += g.fps;
					var diff = this.endtime_ - this.now;
					var msg = '';
					if(diff >= 0){
						timeout = diffToString(diff,false);
						msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
						$('#jz_>i').html(msg);
					}else{
						msg = '已截止';
						$('#jz_>i').html(msg);
						
						clearInterval(this.timer);
						
						/***
						//kjTimer = setInterval(function(){
							//o.info();
						//}, 1e3);
						kjTimer = setInterval(function(){
							o.info();
						}, 5e3);
						***/
					}
				}
				function expect_change(now, endtime){
					this.now = now.getTime();
					this.endtime_ = new Date(endtime.replace(/-/g , '/'));
					//this.atime_ = new Date(atime.replace(/-/g , '/'));
					clearInterval(this.timer);
					this.timer = setInterval(function(){
						eachClock();
					}, g.fps); 
					eachClock();
				}
				
				main();
			},
			
			
			//获取金豆余额信息
			getGolden : function(){
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
							balance=parseInt(balance);
							$("#jdyue").html(balance?balance:0);
						}else if(code==1){
							window.location.href="/gq2/k3/login.html";
						}
					}
				});
			},
			
			//投注方法
			betting_fun:function(){
				//var data=dodata;
				$.ajax({
					url:"/grounder/kpgoldbeanaccout.go",
					dataType:'xml',
					data:betting_param,
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code==0){//投注成功
							alert("参与竞猜成功");
							$("#za").hide();
							$("#tz").hide();
							o.getGolden();//重新加载金豆
							$("#in_golden").val(50);
						}else if(code==1){
							window.location.href="/gq2/k3/login.html";
						}else if(code==6){
							alert("每期快三最多投注1000万金豆");
						}else{
							alert(desc);
						}
					}
				});
			}
	}
	
	
	var bindEvent=function(){
		//投注弹出层
		$("#odiv div").bind("click",function(){
			var index = $(this).index();
			
			var tmp_html_1 = $(this).find("h1").html();
			var tmp_html_2 = $(this).find("span").html();
			
			$("#pl_cont").html(tmp_html_1+"<span>"+tmp_html_2+"</span>");
			
			betting_param.cperiodid=g.qid;//期次id
			if(index==0){//大
				betting_param.wftype=0;
				betting_param.ccodes=1;
			}else if(index==1){//小
				betting_param.wftype=0;
				betting_param.ccodes=0;
			}else if(index==2){
				betting_param.wftype=1;
				betting_param.ccodes=1;
			}else if(index==3){
				betting_param.wftype=2;
				betting_param.ccodes=1;
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			var pl = $("#pl_cont cite").text();
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));
			
			$("#za").show();
			$("#tz").show();
		});
		
		//关闭弹层
		$("#close").bind("click",function(){
			$("#in_golden").val(50)
			$("#za").hide();
			$("#tz").hide();
		});
		
		//获得金豆
		$("#obtain").bind("click",function(){
			window.location.href="/gq2/hdjd.html"
		});
		
		//确认投注
		$(".sure").bind("click",function(){
			betting_param.tzmoney=$("#in_golden").val();
			o.betting_fun();
		});
		
		
		//返还值
		$("#in_golden").keyup(function(){
			var v = parseInt($(this).val())||0;
			var pl = $("#pl_cont cite").text();
			//pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			if(!v){
				$("fh").html(0);
			}else if(v>500000){
				$("#in_golden").val(500000)
				alert("单次竞猜最大投入50万金豆");
				$("#fh").html(Math.ceil(500000*pl));
			}else{
				$("#fh").html(Math.ceil(v*pl));
				$("#sjd").hide();
			}
			
			var jdyue=$("#jdyue").html();//显示隐藏余额不足			
			if(parseInt(jdyue)<parseInt($("#in_golden").val())){
				$("#sjd").show();
			}else{
				$("#sjd").hide();
			}			
			
		});
		
		
		//积分切换
		$("#switcher button").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur")
			setTimeout(function(){
				$("#switcher button").removeClass("cur")
			},100);
			var num = parseInt($("#in_golden").val())||0;
			var remain_jd = parseInt(delFH($("#jdyue").html()));
			var v = $(this).html();
			if(v=="全押"){
				if(remain_jd>500000){
					alert("单次竞猜最大投入500000金豆");
					$("#in_golden").val(500000);
				}else{
					$("#in_golden").val(remain_jd);
				}
				
				//$("#sjd").hide();
			}else{
				if(parseInt(v)+num>500000){
					alert("单次竞猜最大投入500000金豆");
					$("#in_golden").val(500000);
				}else{
					if(remain_jd>parseInt(v)+num){
						$("#in_golden").val(parseInt(v)+num);
						//$("#sjd").hide();
					}else{
						$("#in_golden").val(parseInt(v)+num);
						//$("#sjd").show();
					}
				}
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			
			if(newnum>500000){
				alert("单次竞猜最大投入500000金豆");
				return;
			}
			
			var pl = $("#pl_cont cite").text();
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));
		});
		
		
		//全压
		$(".all_y").bind("click",function(){
			var remain_jd = parseInt(delFH($("#jdyue").html()));
			if(remain_jd>500000){
				alert("单次竞猜最大投入500000金豆");
				$("#in_golden").val(500000);
			}else{
				$("#in_golden").val(remain_jd);
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			if(newnum>500000){
				alert("单次竞猜最大投入500000金豆");
				return;
			}
			
			var pl = $("#pl_cont cite").text();
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));
		});
		
		
		//历史开奖(展示)
		$("#pulldown").bind("click",function(){
			$("#pulldown").hide();
			$("#ls").show();
			$("#za").show();
			$("#ls").addClass("ani_down");
		});
		
		//历史开奖(收起)
		$("#ls_sq").bind("click",function(){
			$("#pulldown").show();
			$("#ls").hide();
			$("#za").hide();
			$("#ls").removeClass("ani_down");
		});
		
	};
	
	var delFH = function(str){
		str = str.replace(/,/g,'');
		return str;
	}
	
	var init=function(){
		bindEvent();
		o.getGolden();
		o.info();
	}
	
	return {
		init:init
	}
})()

$(function(){
	CP.KP.init();
})