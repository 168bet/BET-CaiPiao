$(function(){
	//合买请求数据
	var ggid = '';
	ggid = decodeURIComponent(CP.Util.getParaHash("gid"));
	var page=1;
	chippedList(ggid);
	/*
	 * description 控制右上角链接的
	 * Author wei 
	 */
	if(ggid == '01' || ggid == '03' || ggid == '07' || ggid == '50' || ggid == '51' || ggid == '52' || ggid == '53' 
		|| ggid == '54' || ggid == '80' || ggid == '81' || ggid == 'bd' || ggid == 'jczq' || ggid == 'jclq'){
		$('#pullIco').show();
		//右上角菜单显示或隐藏
		$("#pullIco").bind("click",function(){
			$(this).parent().toggleClass("pullHover");
			$("#pullText").toggle();
		});
		/*
		 * param t (区分竞彩篮彩北单里面的具体玩法方便回调)
		 */
		var t = decodeURIComponent(CP.Util.getParaHash("t"));
		if(ggid == 'bd'){
			$('#pullText a:eq(0)').html('选择比赛');
			$('#pullText a:eq(0)').click(function(){//投注
				location.href = '#class=url&xo=bjdc/'+(!!t?t+'/index.html':'index.html');
			});
			$('#pullText a:eq(2)').click(function(){//开奖结果
				location.href = '#class=url&xo=bjdc/kj/index.html';
			});
			$('#pullText a:eq(3)').click(function(){//玩法
				location.href = '#class=url&xo=bjdc/wf/index.html';;
			});
		}else if(ggid == 'jclq'){
			$('#pullText a:eq(0)').html('选择比赛');
			$('#pullText a:eq(0)').click(function(){//投注
				location.href = '#class=url&xo=jclq/'+(!!t?t+'/index.html':'index.html');
			});
			$('#pullText a:eq(2)').click(function(){//开奖结果
				location.href = '/jclq/kj/';
			});
			$('#pullText a:eq(3)').click(function(){//玩法
				location.href = '#class=url&xo=jclq/wf/index.html';;
			});
		}else if(ggid == 'jczq'){
			$('#pullText a:eq(0)').html('选择比赛');
			$('#pullText a:eq(0)').click(function(){//投注
				location.href = '#class=url&xo=jczq/'+(!!t?t+'/index.html':'index.html');
			});
			$('#pullText a:eq(2)').click(function(){//开奖结果
				location.href = '/jczq/kj/';
			});
			$('#pullText a:eq(3)').click(function(){//玩法
				location.href = '#class=url&xo=jczq/wf/index.html';;
			});
		}else{
			var url = $_sys.getlotdir(ggid).substr(1);
			if(ggid == '80' || ggid == '81'){
				$('#pullText a:eq(0)').html('选择比赛');
			}
			$('#pullText a:eq(0)').click(function(){//投注
				location.href = '#class=url&xo='+url+'index.html';
			});
			$('#pullText a:eq(2)').click(function(){//开奖结果
				ggid = {'81':'80'}[ggid]||ggid;
				location.href = '#class=url&xo=kj/r.html&gid='+ggid;
			});
			$('#pullText a:eq(3)').click(function(){//玩法
				location.href = '#class=url&xo='+url+'wf/index.html';
			});
		}
		
	}
	
	/*
	 * description all of the following 看不懂
	 */
	if(ggid==undefined ||ggid==''){
		$('#pullIco').hide();
		$('.hmPull a:eq(0)').addClass('cur');
		$(".fixed2 ul").removeClass("hmSort");
		$(".fixed2 ul").addClass("hmSort2");
	}else if(ggid == 'jczq'){
		$('.hmPull a:eq(1)').addClass('cur');
		var html = $('.hmPull a:eq(1)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == 'jclq'){
		$('.hmPull a:eq(2)').addClass('cur');
		var html = $('.hmPull a:eq(2)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '80'){
		$('.hmPull a:eq(3)').addClass('cur');
		var html = $('.hmPull a:eq(3)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '81'){
		$('.hmPull a:eq(4)').addClass('cur');
		var html = $('.hmPull a:eq(4)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == 'bd'){
		$('.hmPull a:eq(5)').addClass('cur');
		var html = $('.hmPull a:eq(5)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '01'){
		$('.hmPull a:eq(6)').addClass('cur');
		var html = $('.hmPull a:eq(6)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '03'){
		$('.hmPull a:eq(7)').addClass('cur');
		var html = $('.hmPull a:eq(7)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '07'){
		$('.hmPull a:eq(8)').addClass('cur');
		var html = $('.hmPull a:eq(8)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '50'){
		$('.hmPull a:eq(9)').addClass('cur');
		var html = $('.hmPull a:eq(9)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '51'){
		$('.hmPull a:eq(10)').addClass('cur');
		var html = $('.hmPull a:eq(10)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '53'){
		$('.hmPull a:eq(11)').addClass('cur');
		var html = $('.hmPull a:eq(11)').html();
		$(".hmHeader h1").html(html);
	}else if(ggid == '52'){
		$('.hmPull a:eq(12)').addClass('cur');
		var html = $('.hmPull a:eq(12)').html();
		$(".hmHeader h1").html(html);
	}
	$(".hmPull a").bind("click",function(){
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur")
	})
	
	function chippedList(ggid){
		if(!ggid){
			$(".hmzxHeader ul li").removeClass("cur");
			$("#moresult2").hide();
			D.load();
			$.ajax({
				url:"/data/app/phot/1.xml",
				dataType : "xml",
				success: function(data) {
					D.load(close);
					var R = $(data).find("Resp");
					var code = R.attr("code");
					if (code == "0") {
						var html="";
						var r = $(data).find("row");
						r.each(function(a,b){
							var gid = $(this).attr("gid");
							var hid = $(this).attr("hid");
							var iorder = $(this).attr("iorder");//置顶标志
							var lnum = $(this).attr("lnum");//剩余份数(金额)
							var pnum = $(this).attr("pnum");//发起人保底份数
							//var istate = $(this).attr("istate");
							var views = $(this).attr("views");//跟单人数
							var aunum = $(this).attr("aunum");//等级，战绩
							var nickid = $(this).attr("nickid");//人名
							var money = $(this).attr("money");//人名
							var jindu = $(this).attr("jindu");//人名
							
							//var bpercent = parseFloat(pnum/money).toFixed(2)*100+"%";
							var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
							var lpercent = jindu;
							
							
							var iso = iorder>0?true:false;
							
							
							
							
							
							html+="<a href='#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"'>";
							html+='<dl>'
							html+='<dt>'
								if(gid=="01"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid==85 || gid==87 || gid==88|| gid==89|| gid==90|| gid==91|| gid==92|| gid==93|| gid==70|| gid==72){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+'竞彩足球'+'</h2>';
										}
									}
								}else if(gid=="03"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="04"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}
								else if(gid=="05"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="06"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="07"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="08"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid==20){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="50"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="51"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="52"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="53"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="54"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="80"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="81"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="82"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="83"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid==94 || gid==95 || gid==96|| gid==97|| gid==71){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+'竞彩篮球'+'</h2>';
										}
									}
								}
							html+='</dt>'
							html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
							html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
							html+='</dl>'
							html+='<dl>'
							html+='<dt>'
							html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
							html+='<span class="pro">保 '+bpercent+'</span>'
							html+='</dt>'
							html+='<dd>'
							html+='<cite>'+money+'元</cite>'
							html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
							html+='</dd>'
							html+='<dd class="hmNum">'
							html+='<cite>'+views+'人</cite>'
							html+='<p>参与人数</p>'
							html+='</dd>'
							html+='<dd>'
							html+='<cite>'+lnum+'元</cite>'
							html+='<p>剩余金额</p>'
							html+='</dd>'
							html+='</dl>'
							
							if(iso){
								html+='<em class="hmTop"></em>';
								html+='<em class="hmArrow"></em>';
							}else{
								html+='<em class="hmArrow"></em>';
							}
							
							html+='</a>';
							$(".hmAll").html(html);
							D.load(close);
							$("#moresult1").show();
							
							
						})
					}
				}
			});
		}else if(ggid=="01" || ggid=="03" || ggid=="07" || ggid=="50" || ggid=="51" || ggid=="52" || ggid=="53" || ggid=="80" || ggid=="81"){
			var id = $(".fixed2 ul li.cur").attr("id")
			D.load();
			$.ajax({
				url:"/trade/hemai_list.go?gid="+ggid+"&state=0&pn=1&ps=18&dsort=descending&fsort="+id,
				dataType : "xml",
				success: function(data) {
					D.load(close);
					var R = $(data).find("Resp");
					var desc = R.attr("desc");
					var code = R.attr("code");
					if (code == "0") {
						var r = R.find("row");
						var len = r.length;
						if(r){
							var html="";
							r.each(function(a,b){
								var gid = $(this).attr("gid");
								var hid = $(this).attr("hid");
								var iorder = $(this).attr("iorder");//置顶标志
								var lnum = $(this).attr("lnum");//剩余份数(金额)
								var pnum = $(this).attr("pnum");//发起人保底份数
								var views = $(this).attr("views");//跟单人数
								var aunum = $(this).attr("aunum");//等级，战绩
								var nickid = $(this).attr("nickid");//人名
								var money = $(this).attr("money");//金钱数
								var jindu = $(this).attr("jindu");//进度
								
								var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
								var lpercent = jindu;
								
								var iso = iorder>0?true:false;
								
								
								html+="<a href='#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"'>";
								html+='<dl>'
								html+='<dt>'
								if(gid=="01" || ggid=="03" || ggid=="07" || ggid=="50" || ggid=="51" || ggid=="52" || ggid=="53" || ggid=="80" || ggid=="81"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}
								html+='</dt>'
								html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
								html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
								html+='</dl>'
								html+='<dl>'
								html+='<dt>'
								html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
								html+='<span class="pro">保 '+bpercent+'</span>'
								html+='</dt>'
								html+='<dd>'
								html+='<cite>'+money+'元</cite>'
								html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
								html+='</dd>'
								html+='<dd class="hmNum">'
								html+='<cite>'+views+'人</cite>'
								html+='<p>参与人数</p>'
								html+='</dd>'
								html+='<dd>'
								html+='<cite>'+lnum+'元</cite>'
								html+='<p>剩余金额</p>'
								html+='</dd>'
								html+='</dl>'
								//html+='<em class="hmTop"></em>'
								//html+='<em class="hmArrow"></em>'
								
								if(iso){
									html+='<em class="hmTop"></em>';
									html+='<em class="hmArrow"></em>';
								}else{
									html+='<em class="hmArrow"></em>';
								}
								
								html+='</a>';
								
							})
							$(".hmAll").html(html);
							D.load(close);
							$("#moresult2").show();
							$("#moresult1").hide();
						}else{
							$("#moresult2").hide();
							$(".hmAll").html("无此数据");
						}
						
					}else{
						D.alert(desc);
					}
				}
			})
		}else if(ggid=="jczq"){
			var id = $(".fixed2 ul li.cur").attr("id")
			$("#moresult2").hide();
			$("#moresult1").hide();
			D.load();
			ggid="70,72,90,91,92,93";
			$.ajax({
				url:"/trade/hemai_list.go?gid="+ggid+"&state=0&pn=1&ps=18&dsort=descending&fsort="+id,
				dataType : "xml",
				success: function(data) {
					D.load(close);
					var R = $(data).find("Resp");
					var desc = R.attr("desc");
					var code = R.attr("code");
					if (code == "0") {
						var r = R.find("row");
						var html="";
						if(r){
							if(r.length<18){
								$("#moresult2").hide();
								$("#moresult1").hide();
							}else{
								$("#moresult2").show();
								$("#moresult1").hide();
							}
							r.each(function(a,b){
								var gid = $(this).attr("gid");
								var hid = $(this).attr("hid");
								var iorder = $(this).attr("iorder");//置顶标志
								var lnum = $(this).attr("lnum");//剩余份数(金额)
								var pnum = $(this).attr("pnum");//发起人保底份数
								//var istate = $(this).attr("istate");
								var views = $(this).attr("views");//跟单人数
								var aunum = $(this).attr("aunum");//等级，战绩
								var nickid = $(this).attr("nickid");//人名
								var money = $(this).attr("money");//金钱数
								var jindu = $(this).attr("jindu");//进度
								
								var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
								var lpercent = jindu;
								
								var iso = iorder>0?true:false;
								
								
								html+="<a href='#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"'>";
								html+='<dl>'
								html+='<dt>'
								html+='<h2>竞彩足球</h2>';
								html+='</dt>'
								html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
								html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
								html+='</dl>'
								html+='<dl>'
								html+='<dt>'
								html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
								html+='<span class="pro">保 '+bpercent+'</span>'
								html+='</dt>'
								html+='<dd>'
								html+='<cite>'+money+'元</cite>'
								html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
								html+='</dd>'
								html+='<dd class="hmNum">'
								html+='<cite>'+views+'人</cite>'
								html+='<p>参与人数</p>'
								html+='</dd>'
								html+='<dd>'
								html+='<cite>'+lnum+'元</cite>'
								html+='<p>剩余金额</p>'
								html+='</dd>'
								html+='</dl>'
								//html+='<em class="hmTop"></em>'
								//html+='<em class="hmArrow"></em>'
								if(iso){
									html+='<em class="hmTop"></em>';
									html+='<em class="hmArrow"></em>';
								}else{
									html+='<em class="hmArrow"></em>';
								}
								html+='</a>';
							})
							$(".hmAll").html(html);
							$("#moresult2").show();
							$(".loading").hide()
							
						}else{
							$("#moresult2").hide();
							$(".hmAll").html("无此数据");
						}
					}else{
						D.alert(desc);
					}
				}
			})
		}else if(ggid=="jclq"){
			var id = $(".fixed2 ul li.cur").attr("id")
			$("#moresult2").hide();
			$("#moresult1").hide();
			D.load();
			ggid="71,94,95,96,97";
			$.ajax({
				url:"/trade/hemai_list.go?gid="+ggid+"&state=0&pn=1&ps=18&dsort=descending&fsort="+id,
				dataType : "xml",
				success: function(data) {
					D.load(close);
					var R = $(data).find("Resp");
					var info = R.find("info");
					var tp = info.attr("tp")
					var pn = info.attr("pn")
					
					var desc = R.attr("desc");
					var code = R.attr("code");
					if (code == "0") {
						
						var r = R.find("row");
						//var len = r.length;
						if(r.length>0){
							if(r.length<18){
								$("#moresult2").hide();
								$("#moresult1").hide();
							}else{
								$("#moresult2").show();
								$("#moresult1").hide();
							}
							var html="";
							r.each(function(a,b){
								var gid = $(this).attr("gid");
								var hid = $(this).attr("hid");
								var iorder = $(this).attr("iorder");//置顶标志
								var lnum = $(this).attr("lnum");//剩余份数(金额)
								var pnum = $(this).attr("pnum");//发起人保底份数
								var views = $(this).attr("views");//跟单人数
								var aunum = $(this).attr("aunum");//等级，战绩
								var nickid = $(this).attr("nickid");//人名
								var money = $(this).attr("money");//金钱数
								var jindu = $(this).attr("jindu");//进度
								
								//var bpercent = parseFloat(pnum/money).toFixed(2)*100+"%";
								var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
								var lpercent = jindu;
								
								var iso = iorder>0?true:false;
								
								
								html+="<a href='#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"'>";
								html+='<dl>'
								html+='<dt>'
								
								html+='<h2>竞彩篮球</h2>';
										
								html+='</dt>'
								html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
								html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
								html+='</dl>'
								html+='<dl>'
								html+='<dt>'
								html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
								html+='<span class="pro">保 '+bpercent+'</span>'
								html+='</dt>'
								html+='<dd>'
								html+='<cite>'+money+'元</cite>'
								html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
								html+='</dd>'
								html+='<dd class="hmNum">'
								html+='<cite>'+views+'人</cite>'
								html+='<p>参与人数</p>'
								html+='</dd>'
								html+='<dd>'
								html+='<cite>'+lnum+'元</cite>'
								html+='<p>剩余金额</p>'
								html+='</dd>'
								html+='</dl>'
								//html+='<em class="hmTop"></em>'
								//html+='<em class="hmArrow"></em>'
								if(iso){
									html+='<em class="hmTop"></em>';
									html+='<em class="hmArrow"></em>';
								}else{
									html+='<em class="hmArrow"></em>';
								}
								html+='</a>';
								
							})
							$("#moresult2").show();
							//$("#moresult1").hide();
							$(".loading").hide()
							$(".hmAll").html(html);
							
						}else{
							$("#moresult2").hide();
							D.load(close);
							$(".hmAll").html("无此数据");
						}
						if(tp==pn){
							$("#moresult2").hide();
						}else{
							$("#moresult2").show();
						}
					}else{
						D.alert(desc);
					}
				}
			})
		}else if(ggid=="bd"){
			var id = $(".fixed2 ul li.cur").attr("id")
			$("#moresult2").hide();
			$("#moresult1").hide();
			D.load();
			ggid="85,86,87,88,89";
			$.ajax({
				url:"/trade/hemai_list.go?gid="+ggid+"&state=0&pn=1&ps=18&dsort=descending&fsort="+id,
				dataType : "xml",
				success: function(data) {
					D.load(close);
					var R = $(data).find("Resp");
					var code = R.attr("code");
					if (code == "0") {
						var r = R.find("row");
						var html="";
						if(r){
							if(r.length<18){
								$("#moresult2").hide();
								$("#moresult1").hide();
							}else{
								$("#moresult2").show();
								$("#moresult1").hide();
							}
							r.each(function(a,b){
								var gid = $(this).attr("gid");
								var hid = $(this).attr("hid");
								var iorder = $(this).attr("iorder");//置顶标志
								var lnum = $(this).attr("lnum");//剩余份数(金额)
								var pnum = $(this).attr("pnum");//发起人保底份数
								//var istate = $(this).attr("istate");
								var views = $(this).attr("views");//跟单人数
								var aunum = $(this).attr("aunum");//等级，战绩
								var nickid = $(this).attr("nickid");//人名
								var money = $(this).attr("money");//金钱数
								var jindu = $(this).attr("jindu");//进度
								
								//var bpercent = parseFloat(pnum/money).toFixed(2)*100+"%";
								var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
								var lpercent = jindu;
								
								var iso = iorder>0?true:false;
								
								
								html+="<a href='#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"'>";
								html+='<dl>'
								html+='<dt>'
								html+='<h2>足球单场</h2>';
									
								html+='</dt>'
								html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
								html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
								html+='</dl>'
								html+='<dl>'
								html+='<dt>'
								html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
								html+='<span class="pro">保 '+bpercent+'</span>'
								html+='</dt>'
								html+='<dd>'
								html+='<cite>'+money+'元</cite>'
								html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
								html+='</dd>'
								html+='<dd class="hmNum">'
								html+='<cite>'+views+'人</cite>'
								html+='<p>参与人数</p>'
								html+='</dd>'
								html+='<dd>'
								html+='<cite>'+lnum+'元</cite>'
								html+='<p>剩余金额</p>'
								html+='</dd>'
								html+='</dl>'
								//html+='<em class="hmTop"></em>'
								//html+='<em class="hmArrow"></em>'
								if(iso){
									html+='<em class="hmTop"></em>';
									html+='<em class="hmArrow"></em>';
								}else{
									html+='<em class="hmArrow"></em>';
								}
								html+='</a>';
							})
						}else{
							$("#moresult2").hide();
							$(".hmAll").html("无此数据");
							D.load(close);
						}
						$("#moresult2").show();
						//$("#moresult1").hide();
						$(".loading").hide()
						$(".hmAll").html(html);
					}else{
						D.alert(desc);
					}
				}
			})
		}
	}
	
	
	
	//显示、隐藏合买列表
	$(".hmHeader h1").Touch(function(){
		$(".hmPull").toggle();
		$(this).toggleClass("hmTit");
	})
	
	//首页的查看更多
	function plusResults(){
		var oldHTML = $(".hmAll").html();
		page++;
		$("#moresult1").hide()
		D.load();
		
		$.ajax({
			url:"/data/app/phot/"+page+".xml",
			dataType : "xml",
			success: function(data) {
				D.load(close);
				var R = $(data).find("Resp");
				var code = R.attr("code");
				if (code == "0") {
					
					var info = R.find("info");
					var tp = info.attr("tp");
					if(page>=tp){
						$("#moresult1").hide();
					}
					var html="";
					html += oldHTML;
					var r = $(data).find("row");
					r.each(function(a,b){
						var gid = $(this).attr("gid");
						var hid = $(this).attr("hid");
						var iorder = $(this).attr("iorder");//置顶标志
						var lnum = $(this).attr("lnum");//剩余份数(金额)
						var pnum = $(this).attr("pnum");//发起人保底份数
						//var istate = $(this).attr("istate");
						var views = $(this).attr("views");//跟单人数
						var aunum = $(this).attr("aunum");//等级，战绩
						var nickid = $(this).attr("nickid");//人名
						var money = $(this).attr("money");//人名
						var jindu = $(this).attr("jindu");//人名
						
						//var bpercent = parseFloat(pnum/money).toFixed(2)*100+"%";
						var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
						var lpercent = jindu;
						
						
						var iso = iorder>0?true:false;
						html+="<a href=\"#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"\">";
						html+='<dl>';
						html+='<dt>';
						if(gid=="01"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid==85 || gid==87 || gid==88|| gid==89|| gid==90|| gid==91|| gid==92|| gid==93|| gid==70|| gid==72){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+'竞彩足球'+'</h2>';
								}
							}
						}else if(gid=="03"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="04"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}
						else if(gid=="05"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="06"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="07"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="08"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid==20){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="08"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="50"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="51"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="52"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="53"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="54"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="80"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="81"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="82"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid=="83"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(gid==94 || gid==95 || gid==96|| gid==97|| gid==71){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+'竞彩篮球'+'</h2>';
								}
							}
						}
						
						html+='</dt>'
						html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
						html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
						html+='</dl>'
						html+='<dl>'
						html+='<dt>'
						html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
						html+='<span class="pro">保 '+bpercent+'</span>'
						html+='</dt>'
						html+='<dd>'
						html+='<cite>'+money+'元</cite>'
						html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
						html+='</dd>'
						html+='<dd class="hmNum">'
						html+='<cite>'+views+'人</cite>'
						html+='<p>参与人数</p>'
						html+='</dd>'
						html+='<dd>'
						html+='<cite>'+lnum+'元</cite>'
						html+='<p>剩余金额</p>'
						html+='</dd>'
						html+='</dl>'
						
						
						if(iso){
							html+='<em class="hmTop"></em>';
							html+='<em class="hmArrow"></em>';
						}else{
							html+='<em class="hmArrow"></em>';
						}
						
						html+='</a>';
						 //html+='<a href="gcjl.html" class="myMore">查看更多</a>'
						$(".loading").hide()
						$("#moresult1").show()
						$(".hmAll").html(html);
					})
				}
			}
		});
	}
	
	$("#moresult1").bind("click",function(){
		plusResults();
	})
	
	
	//不同的彩种的查看更多
	
	var pn=1;//页数
	function pageResults(){
		var id = $(".fixed2 ul li.cur").attr("id")
		var oldHTML = $(".hmAll").html();
		if(ggid=="bd"){
			ggid="85,86,87,88,89";
		}else if(ggid=="jczq"){
			ggid="70,72,90,91,92,93";
		}else if(ggid=="jclq"){
			ggid="71,94,95,96,97";
		}
		pn++;
		$("#moresult2").hide();
		$(".loading").show()
		$.ajax({
			
			url:"/trade/hemai_list.go?gid="+ggid+"&state=0&pn="+pn+"&ps=18&dsort=descending&fsort="+id,
			dataType : "xml",
			success: function(data) {
				D.load(close);
				var R = $(data).find("Resp");
				var code = R.attr("code");
				
				if (code == "0") {
					var info = R.find("info");
					var tp = info.attr("tp");
					if(pn>=tp){
						$("#moresult2").hide();
					}
					var r = R.find("row");
					var html="";
					html+=oldHTML;
					r.each(function(a,b){
						var gid = $(this).attr("gid");
						var hid = $(this).attr("hid");
						var iorder = $(this).attr("iorder");//置顶标志
						var lnum = $(this).attr("lnum");//剩余份数(金额)
						var pnum = $(this).attr("pnum");//发起人保底份数
						//var istate = $(this).attr("istate");
						var views = $(this).attr("views");//跟单人数
						var aunum = $(this).attr("aunum");//等级，战绩
						var nickid = $(this).attr("nickid");//人名
						var money = $(this).attr("money");//金钱数
						var jindu = $(this).attr("jindu");//进度
						
						//var bpercent = parseFloat(pnum/money).toFixed(2)*100+"%";
						var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
						var lpercent = jindu;
						
						var iso = iorder>0?true:false;
						
						
						html+="<a href=\"#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"\">";
						html+='<dl>';
						html+='<dt>';
						if(gid=="01" || ggid=="03" || ggid=="07" || ggid=="50" || ggid=="51" || ggid=="52" || ggid=="53" || ggid=="80" || ggid=="81"){
							for(var i = 0;i<$_sys.lot.length;i++){
								if($_sys.lot[i][0]==gid){
									html+='<h2>'+$_sys.lot[i][1]+'</h2>';
								}
							}
						}else if(ggid=="85,86,87,88,89"){
							html+='<h2>足球单场</h2>';
						}else if(ggid=="70,72,90,91,92,93"){
							html+='<h2>竞彩足球</h2>';
						}
						else if(ggid=="71,94,95,96,97"){
							html+='<h2>竞彩篮球</h2>';
						}
						html+='</dt>'
						html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
						html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
						html+='</dl>'
						html+='<dl>'
						html+='<dt>'
						html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
						html+='<span class="pro">保 '+bpercent+'</span>'
						html+='</dt>'
						html+='<dd>'
						html+='<cite>'+money+'元</cite>'
						html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
						html+='</dd>'
						html+='<dd class="hmNum">'
						html+='<cite>'+views+'人</cite>'
						html+='<p>参与人数</p>'
						html+='</dd>'
						html+='<dd>'
						html+='<cite>'+lnum+'元</cite>'
						html+='<p>剩余金额</p>'
						html+='</dd>'
						html+='</dl>'
						if(iso){
							html+='<em class="hmTop"></em>';
							html+='<em class="hmArrow"></em>';
						}else{
							html+='<em class="hmArrow"></em>';
						}
						html+='</a>';
						$(".hmAll").html(html);
						$(".loading").hide()
						$("#moresult2").show();
					})
					}
				}
			})
		
	}
	$("#moresult2").bind("click",function(){
		event.preventDefault();
		pageResults();
	})
	function sortData(ggid,id){
		if(ggid=="bd"){
			ggid="85,86,87,88,89";
		}else if(ggid=="jczq"){
			ggid="70,72,90,91,92,93";
		}else if(ggid=="jclq"){
			ggid="71,94,95,96,97";
		}
		var url;

		if(!ggid){
			$(".hmzxHeader ul li").removeClass("cur");
			$("#moresult2").hide();
			$("#moresult1").show();
			
		}else{
			$("#moresult2").show();
			url="/trade/hemai_list.go?gid="+ggid+"&state=0&pn="+pn+"&ps=18&dsort=descending&fsort="+id,
			$.ajax({
				url:url,
				dataType : "xml",
				success: function(data) {
					D.load(close);
					var R = $(data).find("Resp");
					var code = R.attr("code");
					if (code == "0") {
						var r = R.find("row");
						if(r){
							var html="";
							if(r.length<18){
								$("#moresult2").hide();
								$("#moresult1").hide();
							}else{
								$("#moresult2").show();
								$("#moresult1").hide();
							}
							
							r.each(function(){
								var gid = $(this).attr("gid");
								var hid = $(this).attr("hid");
								
								var iorder = $(this).attr("iorder");//置顶标志
								var lnum = $(this).attr("lnum");//剩余份数(金额)
								var pnum = $(this).attr("pnum");//发起人保底份数
								var views = $(this).attr("views");//跟单人数
								var aunum = $(this).attr("aunum");//等级，战绩
								var nickid = $(this).attr("nickid");//人名
								var money = $(this).attr("money");//金钱数
								var jindu = $(this).attr("jindu");//进度
								var bpercent = Math.floor(parseFloat((pnum/money*100)))+"%";
								var lpercent = jindu;
								
								var iso = iorder>0?true:false;
								
								
								html+="<a href='#class=url&xo=viewpath/index.html&lotid="+gid+"&projid="+hid+"'>";
								html+='<dl>'
								html+='<dt>'
								if(gid=="01" || ggid=="03" || ggid=="07" || ggid=="50" || ggid=="51" || ggid=="52" || ggid=="53" || ggid=="80" || ggid=="81"){
									for(var i = 0;i<$_sys.lot.length;i++){
										if($_sys.lot[i][0]==gid){
											html+='<h2>'+$_sys.lot[i][1]+'</h2>';
										}
									}
								}else if(gid=="85"||gid=="86"||gid=="87"||gid=="88"||gid=="89"){
									html+='<h2>足球单场</h2>';
								}else if(gid=="70"||gid=="72"||gid=="90"||gid=="91"||gid=="92"||gid=="93"){
									html+='<h2>竞彩足球</h2>';
								}
								else if(gid=="71"||gid=="94"||gid=="95"||gid=="96"||gid=="97"){
									html+='<h2>竞彩篮球</h2>';
								}
								html+='</dt>'
								html+='<dd class="hmTtile"><em class="hmAdimi"></em>'+nickid+'</dd>'
								html+='<dd>L'+aunum+'<em class="fiveStar"></em></dd>'
								html+='</dl>'
								html+='<dl>'
								html+='<dt>'
								html+='<cite class="per">'+lpercent+'<o>%</o></cite>'
								html+='<span class="pro">保 '+bpercent+'</span>'
								html+='</dt>'
								html+='<dd>'
								html+='<cite>'+money+'元</cite>'
								html+='<p>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;额</p>'
								html+='</dd>'
								html+='<dd class="hmNum">'
								html+='<cite>'+views+'人</cite>'
								html+='<p>参与人数</p>'
								html+='</dd>'
								html+='<dd>'
								html+='<cite>'+lnum+'元</cite>'
								html+='<p>剩余金额</p>'
								html+='</dd>'
								html+='</dl>'
								if(iso){
									html+='<em class="hmTop"></em>';
									html+='<em class="hmArrow"></em>';
								}else{
									html+='<em class="hmArrow"></em>';
								}
								html+='</a>';
								$(".hmAll").html(html);
							})
						}else{
							$("#moresult2").hide();
							$(".hmAll").html("无此数据");
						}
					}
				}
			})
		}
	}
	$(".hmzxHeader ul li").bind("click",function(){
		$("body").scrollTop(0)
		$(this).addClass("cur");
		$(this).siblings().removeClass("cur");
		var jindu= $(this).attr("id");
		sortData(ggid,jindu)
	})
	//排序方法
	function sortArr(obj1,obj2){
		var id = $(".hmzxHeader ul li.cur").attr("id");
		if($(obj1).attr(id)>$(obj2).attr(id)){
			return -1;
		}else if($(obj1).attr(id)<$(obj2).attr(id)){
			return 1;
		}else{
			return 0;
		}
	}
	
})
