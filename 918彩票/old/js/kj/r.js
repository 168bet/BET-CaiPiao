$(function(){
	var gid,flag;
	gid = decodeURIComponent(CP.Util.getParaHash("gid"));
	flag = decodeURIComponent(CP.Util.getParaHash("flag"));
	
	if(gid == '01' || gid == '03' || gid == '06' || gid == '07' || gid == '50' || gid == '51' || gid == '52' || gid == '53' 
		|| gid == '54' || gid == '56' || gid == '58'|| gid == '20' || gid == '80'){//控制右上角导航显示
		$('#pullIco,#payment').show();
		var url = '#class=url&xo='+$_sys.getlotdir(gid).substr(1)+'index.html';
		$('#payment').click(function(){
			window.location.href = url;
		});
		//右上角菜单显示或隐藏
		$("#pullIco").bind("click",function(){
			$(this).parent().toggleClass("pullHover");
			$("#pullText").toggle();
		});
		$('#pullText a:eq(0)').click(function(){//投注
			location.href = url;
		});
		$('#pullText a:eq(1)').click(function(){//合买
			location.href = '#class=url&xo=hm/index.html&gid='+gid;
		});
		$('#pullText a:eq(3)').click(function(){//玩法
			location.href = '#class=url&xo='+$_sys.getlotdir(gid).substr(1)+'wf/index.html'
		});
		if(gid == '80'){
			$('#pullText a:eq(0)').html('选择比赛');
		}
		if(gid == '54' || gid == '06' || gid == '56' || gid == '58' || gid == '20'){//隐藏合买
			$('#pullText a:eq(1)').hide();
		}
	}
	if($("#newinfo").is(":visible")){
		$("#newinfo").show();
		$("#moresult1").hide();
		$("#historyList").hide();
		$("#newinfo").addClass("cur")
		$("#historykj").removeClass("cur");
	}else{
		$("#newinfo").hide();
		$("#historyList").show();
		$("#moresult1").show();
		$("#historykj").addClass("cur")
		$("#newkj").removeClass("cur");
	}
	if(gid == '80'){
		$('#historyList').addClass('sfcall').removeClass('kjall');
	}
	if(!flag){
		if($("#newinfo").is(":hidden")){
			$("#newinfo").show();
			$("#historyList").hide();
			$("#newinfo").addClass("cur");
			$("#historykj").removeClass("cur");
		}
	}else{
		if($("#historyList").is(":hidden")){
			$("#newinfo").hide();
			$("#historyList").show();
			$("#historykj").addClass("cur");
			$("#newkj").removeClass("cur");
		}
	}
	$("#newkj").bind("click",function(){
		if($("#newinfo").is(":hidden")){
			$("#newinfo").show();
			$("#moresult1").hide();
			$("#historyList").hide();
			$(this).addClass("cur");
			$("#historykj").removeClass("cur");
		}
	});
	$("#historykj").bind("click",function(){
		if($("#historyList").is(":hidden")){
				$("#newinfo").hide();
				$("#moresult1").show();
				$("#historyList").show();
				$(this).addClass("cur");
				$("#newkj").removeClass("cur");
		}
	});
	var pn=1;
		//开奖历史列表
		if(gid == "03"|| gid == "07" || gid == "01"||gid == "80"||gid == "83"||gid == "82"||gid == "50"||gid == "51"||gid == "52"
			||gid == "53"||gid == "54"||gid == "56"||gid == "57"||gid == "58"||gid == "20"||gid == "06"||gid == "08"||gid == "09"||gid == "04"){
			D.load();
			$.ajax({
				url : $_trade.url.cacheperiod,
				type : "POST",
				dataType : "xml",
				data : "gid="+gid+"&pn="+pn+"&ps=10"+"&pn=1",
				success : function(xml){
						var R = $(xml).find("rows");
						var r = R.find("row");
						var html = "";
						var wwpid = r.attr('pid');
						//对应期数开奖详情
						$.ajax({
							url : "/trade/detail.go",
							dataType:"xml",
							data:"gid="+gid+"&pid="+wwpid,
							success : function(xml){
								D.load(close);
								var R = $(xml).find("rows");
								var gsale = R.attr("gsale");//本期销量
								gsale = addCommas(gsale);
								var ginfo = R.attr("ginfo");//单注奖金
								var ninfo = R.attr("ninfo");//中奖注数
								var gpool = R.attr("gpool");//奖池滚存
								gpool = addCommas(gpool);
								var ginfo1,ninfo1;
								if(ginfo.indexOf(",") != -1){
									ginfo1 = ginfo.split(',');
								}else{
									ginfo1 = ginfo;
								}
								if(ninfo.indexOf(",") != -1){
									ninfo1 = ninfo.split(',');
								}else{
									ninfo1 = ninfo;
								}
								var html = '';
								var rank = {'0':'一等奖','1':'二等奖','2':'三等奖','3':'四等奖','4':'五等奖','5':'六等奖','6':'二等奖加奖'};
								var code = R.attr("acode");//开奖号码
								var atime = R.attr("atime");//开奖日期
								if(gid == '01' || gid == '07' || gid == '50' || gid == '51' || gid == '52'){
									$("#newkj").show();
									$("#moresult1").hide();
									html += '<p class="pdTop04 pdLeft04"><span class="fontSize1">第'+wwpid+'期</span><cite class="gray pdLeft04">'+atime+'</cite></p>';
									//html += '<div class="kjBall pdLeft04">'+anyCodeKJ(code)+'</div>';
									html+=anyCodeKJ(code);
									html += '<ul class="kjList">';
									html += '<li class="gray"><em>奖项</em><cite>注数</cite><span>每注金额</span></li>';
									if(gid == '01' || gid == '07' || gid == '51'){
										if(code.split("|").length==3){//双色球幸运嘉奖
											for(var n = 0; n<7; n++){
												html += '<li><em>'+rank[n]+'</em><cite>'+(ninfo1[n]?ninfo1[n]:"--")+'</cite><span>'+(ginfo1[n]?ginfo1[n]:"--")+'</span></li>';
											}
										}else{
											for(var n = 0; n<6; n++){
												html += '<li><em>'+rank[n]+'</em><cite>'+(ninfo1[n]?ninfo1[n]:"--")+'</cite><span>'+(ginfo1[n]?ginfo1[n]:"--")+'</span></li>';
											}
										}
									}else if(gid == '50'){
										for(var i=0;i<ginfo1.length;i++){
											if(ginfo1[i] != "--"){
												html+='<li>';
												html+='<em>'+level[i+1]+'</em>';
												html+='<cite>'+ninfo1[i]+'</cite>';
												html+='<span>'+ginfo1[i]+'</span>';
												html+='</li>';
											}else{
												html+='<li>';
												html+='<em>'+level[i+1]+'</em>';
												html+='<cite>--</cite>';
												html+='<span>--</span>';
												html+='</li>';
											}
										}
									}else if(gid == '52'){
										html += '<li><em>一等奖</em><cite>'+ninfo1+'</cite><span>'+ginfo1+'</span></li></ul>';
									}
									html += '</ul>';
									html += '<div class="gray pdTop06"><p>本期销量'+gsale+'元</p>';
									if(gid == '01' || gid=='50' || gid == '51'){
										html+='<p class="pdTop03">奖池滚存：<cite class="yellow">'+gpool+'元</cite></p>';
									}
									html += '</div>';
								}else if(gid == '03' || gid == '53' || gid == '54' || gid=="56" || gid == '57' || gid == '58'
									|| gid == '20' || gid == '06' || gid == '08' || gid == '09' || gid == '04' || gid == '80'){
									$("#newinfo").hide();
									$("#moresult1").show();
									$("#historyList").show();
								}
								$("#newinfo").html(html);
							}
						})
						r.each(function(){
								var pid =  $(this).attr("pid");
								var atime=$(this).attr("atime");
								var acode =  $(this).attr("acode");
								var code;
								if(acode.indexOf("|") != -1){
									code = acode.split('|');
								}else{
									code = acode;
								}
								if(gid == "03"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "53"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "51"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="#class=url&xo=kj/lskjxq.html&gid='+gid+'&pid='+pid+'">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='<i class="rightArrow"></i>';
						            	html+='</a>';
									}
							    }
								if(gid == "52"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="#class=url&xo=kj/lskjxq.html&gid='+gid+'&pid='+pid+'">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='<i class="rightArrow"></i>';
						            	html+='</a>';
									}
							    }
								if(gid == "54"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "56"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "57"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
								}
								if(gid == "58"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjdice">';
						            	acode = acode.split(',');
						            	for(var n=0; n<acode.length; n++){
						            		var co = acode[n],co1,co2;
						            		co1 = co.substr(0,1);
						            		co1 = {'1':'spade','2':'heart','3':'club','4':'box'}[co1];//黑红梅方
						            		co2 = co.substring(1);
						            		co2 = {'01':'A','11':'J','12':'Q','13':'K'}[co2]||parseInt(co2);
						            		html+='<span><cite class='+co1+'></cite><em '+(co1 == 'heart' || co1 == 'box' ?'class=red':'')+'>'+co2+'</em></span>';
						            	}
						            	html+='</div></a>';
									}
							    }
								if(gid == "06"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "08"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "09"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "20"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }if(gid == "04"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
								if(gid == "01"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="#class=url&xo=kj/lskjxq.html&gid='+gid+'&pid='+pid+'">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	//html+=anyCodeKJ(acode)
						            	html+='<i class="rightArrow"></i>';
						            	html+='</a>';
									}
							    }
								if(gid == "50"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="#class=url&xo=kj/lskjxq.html&gid='+gid+'&pid='+pid+'">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='<i class="rightArrow"></i>';
						            	html+='</a>';
									}
							    }
								if(gid == "07"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="#class=url&xo=kj/lskjxq.html&gid='+gid+'&pid='+pid+'">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
						            	html+='<i class="rightArrow"></i>';
						            	html+='</a>';
									}
							    }
								if(gid == "80"){
									var str = anyName(gid,$_sys.lot)
									$(".hmzxHeader .kjHeader h1").html(str);
									if(acode !=""){
										html+='<a href="javascript:;">';
						            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
						            	html+='<div class="kjBox">'+anyCodelist(acode)+'</div>';
						            	html+='</a>';
									}
							    }
						});
						$("#historyList").html(html);
				},
				
			});
		}
	$("#moresult1").bind("click",function(){
			dyna();
	});
	function dyna(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
			var oldhtml = $("#historyList").html();
			pn++;
			$("#moresult1").hide()
			D.load();
			$.ajax({
				url : $_trade.url.cacheperiod,
				type : "POST",
				dataType : "xml",
				data : "gid="+gid+"&pn="+pn+"&ps=10"+"&pn=1",
				success  : function (xml){
					var R = $(xml).find("rows");
					var tp = R.attr("tp")
					var r = R.find("row");
					if(pn<tp){
						var html="";
						html+=oldhtml;
						r.each(function(){
							var pid =  $(this).attr("pid");
							var atime=$(this).attr("atime");
							var acode =  $(this).attr("acode");
							if(acode.indexOf("|") != -1){
								var code = acode.split('|');
							}else{
								var code = acode;
							}
							var str = anyName(gid,$_sys.lot)
							$(".hmzxHeader .kjHeader h1").html(str);
							var codered = code[0].split(',').join(' ');
							var codeblue = code[1];
							if(acode !="" && gid == '80'){
								html+='<a href="javascript:;">';
				            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
				            	html+='<div class="kjBox">'+anyCodelist(acode)+'</div>';
				            	html+='</a>';
							}else if(gid == '03' || gid == '53' || gid == '54' || gid == '56' || gid == '57'
								|| gid == '06' || gid == '08' || gid == '09' || gid == '20' || gid == '04'){
								html+='<a href="javascript:;">';
				            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
				            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
				            	html+='</a>';
							}else if(gid == '58'){
								var str = anyName(gid,$_sys.lot)
								$(".hmzxHeader .kjHeader h1").html(str);
								var codered = code[0].split(',').join(' ');
								var codeblue = code[1];
								if(acode !=""){
									html+='<a href="javascript:;">';
					            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
					            	html+='<div class="kjdice">';
					            	acode = acode.split(',');
					            	for(var n=0; n<acode.length; n++){
					            		var co = acode[n],co1,co2;
					            		co1 = co.substr(0,1);
					            		co1 = {'1':'spade','2':'heart','3':'club','4':'box'}[co1];//黑红梅方
					            		co2 = co.substring(1);
					            		co2 = {'01':'A','11':'J','12':'Q','13':'K'}[co2]||parseInt(co2);
					            		html+='<span><cite class='+co1+'></cite><em '+(co1 == 'heart' || co1 == 'box' ?'class=red':'')+'>'+co2+'</em></span>';
					            	}
					            	html+='</div></a>';
								}
						    }else{
								html+='<a href="#class=url&xo=kj/lskjxq.html&gid='+gid+'&pid='+pid+'">';
				            	html+='<div class="clearfix lskjTit">第'+pid+'期&nbsp;'+  atime   +'</div>';
				            	html+='<div class="kjNum">'+anyCodelist(acode)+'</div>';
				            	html+='</a>';
							}
						})
					}
					$("#moresult1").show()
					D.load(close);		
					$("#historyList").html(html);
				}
			});
	}
	$("#historykj").click();
})


function anyCodelist(str){
	var html="";
	var arr=new Array();
	if(str){
		if(str.indexOf("|")!=-1){
			arr = str.split("|");
			var arr0 = arr[0];
			var arr1 = arr[1];
			var prearr = arr0.split(",");
			var nextarr = arr1.split(",");
			if(nextarr.length==1){
				for(var i=0;i<prearr.length;i++){
					html+='<b>'+prearr[i]+'</b>';
				}
				html+='<b class="blue">'+nextarr[0]+'</b>';
			}else if(nextarr.length==2){
				for(var i=0;i<prearr.length;i++){
					html+='<b>'+prearr[i]+'</b>';
				}
				html+='<b class="blue">'+nextarr[0]+'</b>';
				html+='<b class="blue">'+nextarr[1]+'</b>';
			}
		}else{
			arr = str.split(",");
			for(var i=0;i<arr.length;i++){
				html+='<b>'+arr[i]+'</b>';
			}
		}
	}
	return html;
}

function anyCodeKJ(str){
	var html="";
	
	var arr=new Array();
	if(str){
		if(str.indexOf("|")!=-1){
			arr = str.split("|");
			if(arr.length==2){
				html += '<div class="kjBall pdLeft04">'
				var arr0 = arr[0];
				var arr1 = arr[1];
				var prearr = arr0.split(",");
				var nextarr = arr1.split(",");
				if(nextarr.length==1){
					for(var i=0;i<prearr.length;i++){
						html+='<cite>'+prearr[i]+'</cite>';
					}
					html+='<cite class="blueBall">'+nextarr[0]+'</cite>';
				}else if(nextarr.length==2){
					for(var i=0;i<prearr.length;i++){
						html+='<cite>'+prearr[i]+'</cite>';
					}
					html+='<cite class="blueBall">'+nextarr[0]+'</cite>';
					html+='<cite class="blueBall">'+nextarr[1]+'</cite>';
				}
				html+='</div>';
				
			}else if(arr.length==3){//双色球嘉奖
				html += '<div class="kjBall pdLeft04">'
				var arr0 = arr[0];
				var arr1 = arr[1];
				var arr2 = arr[2];
				var prearr = arr0.split(",");
				//var nextarr = arr1.split(",");
				
				for(var i=0;i<prearr.length;i++){
					html+='<cite>'+prearr[i]+'</cite>';
				}
				html+='<cite class="blueBall">'+arr1+'</cite>';
				html+='</div>';
				html += '<div class="kjBall pdLeft04 pdTop03"><span style="margin-right:.5rem; font-size:1rem">幸运蓝球：</span><cite class="blueBall">'+arr2+'</cite></div>';
			}
			
		}else{
			html += '<div class="kjBall pdLeft04">'
			arr = str.split(",");
			for(var i=0;i<arr.length;i++){
				html+='<cite>'+arr[i]+'</cite>';
			}
			html+='</div>';
		}
	}
	
	
	return html;
}

//根据id判断是哪个彩种
function anyName(gid,arr){
	for(var i=0;i<arr.length;i++){
		if(arr[i][0]==gid){
			var str = arr[i][1];
			var kj = '开奖';
			return str+kj;
		}
	}
}