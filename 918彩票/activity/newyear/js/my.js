var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p').html(msg);
			tag && $('#dAlert a.bfb').html(tag) || $('#dAlert a.bfb').html('确定');
			$("#dAlert").show();
			$("#zhezhao").show();
			$('#dAlert a.bfb').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$("#zhezhao").hide();
			});
		},
		confirm:function(msg, fn, tag){
			$('#dConfirm p').html(msg);
			tag && $('#dConfirm div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			$('#dConfirm').show();
			$("#zhezhao").show()
			$('#dConfirm a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
			});
			$('#dConfirm a:eq(1)').one('click',function(){//确定
				//if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$("#zhezhao").hide();
			});
		}
};
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var CP={};

CP.ZLK=(function(){
	//初始化方法
	var init=function(){
		loadCont();
		bindEvent();
	};
	
	
	var bindEvent=function(){
		$('.sdTab li').bind(start_ev, function(){
			if($(this).hasClass('cur')){return}
			$(this).addClass("cur").siblings().removeClass("cur")
			var index = $(this).index();
			$(".redcard,.qdk").hide();
			index && $(".redcard").show() ||  $(".qdk").show();
			var w = $(this).width();
			var l = $(".downline").offset().left;
			$(".downline").animate({"left":index*w})
		});
		
		
		
		//立即兑换
		$(".ljdh").bind("click",function(){
			if($(this).hasClass("gray")){
				return false;
			}else{
				$.ajax({
					url:"/activity/exchangeNewYearPresent.go",
					dataType:'xml',
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code=="0"){
							D.alert(desc);
						}
					},
				});
			}
		})
		
	};
	
	//加载礼包/红包内容
	var loadCont=function(){
		var packageHTML = "";
		var cardHTML="";
		$.ajax({
			url:"/activity/queryMyNewYearPresent.go",
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				if(code=="0"){
					var rows = R.find("rows");
					var packet = rows.find("packet");//红包节点
					var card = rows.find("card");//卡片节点
					
					packet.each(function(){
						var rid = $(this).attr("rid");//红包ID
						var imoney = $(this).attr("imoney");//红包总金额
						var cdeaddate = $(this).attr("cdeaddate");//红包过期时间
						var irmoney = $(this).attr("irmoney");//
						var cadddate = $(this).attr("cadddate");//添加时间
						var istate = $(this).attr("istate");//红包状态
						var cmemo = $(this).attr("cmemo");//备注
						var iaddmoney = $(this).attr("iaddmoney");//
						var crpname = $(this).attr("crpname");//红包名称
						var scale = $(this).attr("scale");//使用比例
						var gid = $(this).attr("gid");//可用彩种
						var itid = $(this).attr("itid");//使用方式
						var ctname = $(this).attr("ctname");//红包类型名称
						var rcmemo = $(this).attr("rcmemo");//备注
						
						if(scale=="1/10"){
							packageHTML+='<dl>'
							packageHTML+='<dt>￥<strong>'+imoney+'</strong>元</dt>'
							packageHTML+='<dd><span>新年满10减1红包</span>有效期至'+cdeaddate+'</dd>'
							packageHTML+='<dd class="last">余额<cite>'+irmoney+'</cite>元</dd>'
							packageHTML+='</dl>'
						}else if(scale==""){
							packageHTML+='<dl>'
							packageHTML+='<dt>￥<strong>'+imoney+'</strong>元</dt>'
							packageHTML+='<dd><span>新年无限制使用红包</span>有效期至'+cdeaddate+'</dd>'
							packageHTML+='<dd class="last">余额<cite>'+irmoney+'</cite>元</dd>'
							packageHTML+='</dl>'
						}
						
						
					});
					$(".redcard").html(packageHTML);
					
					var len = card.length;
					if(len !=7 || !card){
						$(".ljdh").addClass("gray");
					}else{
						$(".ljdh").removeClass("gray");
					}
					card.each(function(){
						var cardid = parseInt($(this).attr("cardid"));
						
						if(cardid==0){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(1) span:eq(0)").addClass("cur");
							$(".qdk ul li:eq(1) span:eq(0)").html(total?total:"0");
						}
						
						if(cardid==1){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(0) span:eq(0)").addClass("cur");
							$(".qdk ul li:eq(0) span:eq(0)").html(total?total:"0");
						}
						
						if(cardid==2){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(0) span:eq(1)").addClass("cur");
							$(".qdk ul li:eq(0) span:eq(1)").html(total?total:"0");
							
						}
						
						if(cardid==3){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(0) span:eq(2)").addClass("cur");
							$(".qdk ul li:eq(0) span:eq(2)").html(total?total:"0");
						}
						
						if(cardid==4){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(1) span:eq(2)").addClass("cur");
							$(".qdk ul li:eq(1) span:eq(2)").html(total?total:"0");
						}
						
						if(cardid==5){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(2) span:eq(0)").addClass("cur");
							$(".qdk ul li:eq(2) span:eq(0)").html(total?total:"0");
						}
						
						if(cardid==6){
							var total = parseInt($(this).attr("total"));
							$(".qdk ul li:eq(1) span:eq(1)").addClass("cur");
							$(".qdk ul li:eq(1) span:eq(1)").html(total?total:"0");
						}
					});
				}else{
					D.confirm('参与"礼包天天送活动"，需先登录;点击去登录，立即登录！',function(){
						window.location.href="/alone/login.html";
					},"去登录");
				}
			},
		});
	};
	
	return {
		init:init
	};
})();
$(function(){
	CP.ZLK.init();
})