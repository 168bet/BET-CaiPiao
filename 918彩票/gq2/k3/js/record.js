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
var cutStr= function(n){
	   var b=parseInt(n).toString();
	   var len=b.length;
	   if(len<=3){return b;}
	   var r=len%3;
	   return r>0?b.slice(0,r)+","+b.slice(r,len).match(/\d{3}/g).join(","):b.slice(r,len).match(/\d{3}/g).join(",");
	 } 
var pnum=1;
var context="";


	var record=function(pzise,pnum){
		$.ajax({
			url:"/grounder/kpgoldbeanaccout.go?flag=0&qtype=0&date1=2015-01-01&psize="+pzise+"&pnum="+pnum,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				$("#nodata").hide();
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				var tpage = R.attr("tpage");
				(tpage==pnum)?($(".more").hide()):($(".more").show());
	
				var  p  = R.find("phrecords");
				var  row  = R.find("row");
				var  oli='';
					if(row.length>0){
						row.each(function(i){
	
							var gname = $(this).attr("gname");
							var cperiodid = $(this).attr("cperiodid");
							
							var kjcodes = $(this).attr("kjcodes");
							kjcodes=kjcodes?("开奖号:"+kjcodes):"等待开奖";
							
							var tztime = $(this).attr("tztime").substr(5,14);
							var tzmoney =$(this).attr('tzmoney');
							var ibonus =$(this).attr('ibonus');
							var ccodesdesc = $(this).attr('ccodesdesc');
							var ireturn = $(this).attr('ireturn');
							var result = $(this).attr('result');
	
							
							var backmoney="";
							if(ireturn==0||ireturn==1){
								backmoney="等待开奖"
							}else{
								if(result==1){
									backmoney="<i>"+ibonus+"</i>金豆"
								}else if(result==0){
									backmoney="未中奖";
								}
							}
						
							var one_list='<li><div><span>'+gname+'<i><em>'+cperiodid+'</em>期</i><cite>'+kjcodes+'</cite></span><span>投注:<em>'+tzmoney+'</em>金豆('+ccodesdesc+')<cite>'+tztime+'</cite></span><span>返还:'+backmoney+'</span></div></li>'
							oli=oli+one_list; 
						})
					}else if(code==1){
						$("#nodata").show();
					}
					$("#z_list").append(oli);
					}
				})
		
	}

		var bind=function(){
			
			$('#qiandao').bind('click',function(){	
			 	$('#jd,#ceng').show();
			})
			
			$('#close').bind('click',function(){
			
			 	$('#jd,#ceng').hide();
			
			})
			
			$('.more').bind('click',function(){
			
				pnum++
			record(10,pnum);
				
			})
			
			$('#tab1').bind('click',function(){
			
			window.location.href="/gq2/hdjd.html";	
			
			})

			$('#tab2').bind('click',function(){
			
			window.location.href="/gq2/jpzx/";	
			
			})
			
			$("#card_href").bind("click",function(){
				window.location.href="/gq2/sign/qdfb.html"

			})	
			
			
			
		}



		
		
		
		


		//刷新金余额
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
					$("#user_account i").html("("+balance+"金豆)");
				}else if(code==1){
					window.location.href="login.html";
				}
			}
		})
	}
		
		
		//取签到弹窗状态显示
		var is_qd = function(){
		$.ajax({
			url:'/grounder/fgoldenbeanaccount.go?flag=0&qtype=3',
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

				
					var nickid = row.attr("cnickid");//用户名
					var balance = row.attr("balance");//用户名
					$("#user_account").html(nickid+'<i>('+balance+'金豆)</i>');
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
						$('#jd,#ceng').show();

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
				}else if(code==1){
					window.location.href="/gq2/login.html";
					}
				}
			})
		
		}

		//签到按钮
		$("#get_jd").bind("click",function(){
			$.ajax({
				url:"/grounder/goldenbeanaccount.go?flag=1&utype=0&qtype=0",
				dataType:'xml',
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
		
						}else if($(".jdtext ul:eq(1) li").hasClass("wqd")){
							var index = $(".jdtext ul:eq(1) li.wqd").index();
							
							$(".jdtext ul:eq(1) li:eq("+index+")").removeClass("wqd");
							$(".jdtext ul:eq(1) li:eq("+index+")").addClass("yqd");
		
						}
						
						$("#get_jd").addClass("graybg");
						$("#get_jd").html("已签到");
						$("#get_jd").unbind("click");
						alert("恭喜您，领取成功，赶快参与竞猜吧！");
						getGolden();
						$('#jd,#ceng').hide();
		
					}else{
						alert(desc);
					}
				}
			});
		})


		var init=function(){		
			is_qd();
			record(10,pnum);
			bind();
		}
		
		
		init();
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
