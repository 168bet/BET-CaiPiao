var pn = 1;
$(function(){
	var obj={
			200:"用户充值",
			201:"自购中奖",
			202:"跟单中奖",
			203:"中奖提成",
			204:"追号中奖",
			210:"自购撤单返款",
			211:"认购撤单返款",
			212:"追号撤销返款",
			213:"提现撤销返款",
			214:"提款失败转款",
			215:"保底返款",
			216:"红包派送",
			300:"转款",
			100:"自购",
			101:"认购",
			102:"追号",
			103:"保底认购",
			104:"提现",
			105:"保底冻结",
			99:"转账",
			98:"套餐追号",
	};
	$(".hmTit").bind("click",function(){
		$(".hmPull").toggle();
	});
	$("#zhmx").bind("click",function(){
		$(".hmPull").slideDown(400);
		$(this).addClass("cur");
	});
	accountDetails();
	function accountDetails(){
		$("#moresult1").hide();
		$(".loading").show();
		$.ajax({
			url:"/user/queryAccount.go?pn="+pn+"&ps=10&flag=13",
			success  : function (xml){
				var R = $(xml).find("rows");
				var tp = R.attr("tp")
				if(tp=="1"){
					$("#moresult1").hide()
				}else{
					$("#moresult1").show()
				}
					var r = R.find("row")
					if(r.length>0){
						var oldValue = $(".all").html();
							var html="";
							html+=oldValue;
							r.each(function(){
								var imoney = $(this).attr("imoney");
								var ibiztype = parseInt($(this).attr("ibiztype"));
								var itype = $(this).attr("itype");
								var wf = $(this).attr("wf");
								var cadddate = $(this).attr("cadddate");
								var bh = $(this).attr("bh");
								var gid = bh.substring(0,2);
								if(itype==1){
									imoney="-"+imoney;
								}
								var sss=$_sys.showcmemo(ibiztype,wf);
								if(bh.indexOf('HM')>0 || bh.indexOf('DG')>0){

									html+='<a href="#class=url&xo=viewpath/index.html&lotid='+gid+'&projid='+bh+'">';

								}else if (bh.indexOf('ZH')>0){
									if(bh.indexOf('_')>=0){
										bh = bh.split('_')[0];
									}
									html+='<a href="/useraccount/zhxq.html?flag=39&gid='+gid+'&tid='+bh+'">';

								}else{
									html+='<a href="javascript:;">';
								} 
								html+='<span>';
								html+='<cite>'+imoney+'</cite>';
								html+='<em>'+obj[ibiztype]+'</em>';
								html+='</span>';
								html+='<span class="number">';
								html+='<cite>'+sss+'</cite>';
								html+='<em>'+cadddate+'</em>';
								html+='</span>';
								if(bh.indexOf('HM')>0 || bh.indexOf('DG')>0 || bh.indexOf('ZH')>0){
									html+='<i class="rightArrow"></i>';
								}
								html+='</a>';
							})
							$("#moresult1").show();
							$(".loading").hide();
							$(".all").html(html);
					}else{
						$("#moresult1").hide();
						$(".loading").hide();
						$(".all").html("暂无记录");
					}
			}
		})
	}
	/***
	$(window).scroll(function(){
		var flag = $_Y.getInt(location.search.getParam("flag"));
		//alert(flag)
		description(flag,pn,obj);
	})
	***/
	$("#moresult1").bind("click",function(){
		pn++;
		accountDetails();
	});
});
$_sys.showcmemo = function (ibiztype,wf){
	var memo='';	
	ibiztype=parseInt(ibiztype);
	switch (ibiztype){
	case 200:
		switch(wf){
			case '9014':
				memo='充值';
				break;
			case '2070':
				memo='安智充值';
				break;
			default:
				memo = $_sys.getaddmoneyname(wf);
				break;
		}
		break;
	case 100:
	case 101:
	case 103:
	case 105:
	case 201:		
	case 202:
	case 203:	
	case 210:
	case 211:	
	case 252:
	case 253:
	case 215:			
	case 98:
	case 102:	
	case 212:
	case 254:
	case 204:
		memo=$_sys.getlotname(wf);
		break;	
	case 300:
		memo="转款";
		break;
	case 107:	
	case 216:	
	case 213:
	default:
		break;
	}
	return memo;
};