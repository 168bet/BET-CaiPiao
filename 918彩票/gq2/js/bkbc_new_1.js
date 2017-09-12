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

var XHC={};
var CP={};
var basketball="";
var basketballArray="";
CP.MobileVer = (function ($) {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false,
		wp:false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	obj.wp = u.indexOf("Windows Phone") > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();

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

var d = new Date();
var y = d.getFullYear();
var m1 = d.getMonth()+1;
m1=m1<10?"0"+m1:m1;
var day =d.getDate();
day=day<10?"0"+day:day;
var P1 = y+""+m1+""+day;

var flag = localStorage.getItem("flag");
var sids_arr="";
var gz_total=0;
var z_cyrs={};//足球参与人数对象


var n_;//服务器时间
var all_match_zq_list={};//所有比赛对象
var gz_match_zq_list={};//关注的比赛对象

//获取所有比赛列表
var get_all_match_list=function(){
	var zq_num=0;
	$.ajax({
		async:false,
		url:'/zqjc/matchs/mobile/matchs.xml?' + new Date().getTime(),
		type: 'GET',
		dataType: 'xml',
		timeout: 1000,
		success: function(data){
			n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
			$(data).find('row').each(function(i,u){
				zq_num++;
				var cur_match={};
    			cur_match.id = $(u).attr('id');
    			cur_match.sid = $(u).attr('sid');
    			cur_match.mid = $(u).attr('mid');
    			cur_match.itemId = $(u).attr('itemId');
    			cur_match.sort = $(u).attr('sort');
    			cur_match.seasonId = $(u).attr('seasonId');
    			cur_match.ln = $(u).attr('ln');
    			cur_match.mtime = $(u).attr('mtime');
    			cur_match.code = $(u).attr('code');
    			cur_match.htime = $(u).attr('htime');
    			cur_match.hn = $(u).attr('hn');
    			cur_match.gn = $(u).attr('gn');
    			cur_match.hid = $(u).attr('hid');
    			cur_match.gid = $(u).attr('gid');
    			cur_match.hr = $(u).attr('hr');
    			cur_match.gr = $(u).attr('gr');
    			cur_match.hsc = $(u).attr('hsc');
    			cur_match.gsc = $(u).attr('gsc');
    			cur_match.hrd = $(u).attr('hrd');
    			cur_match.grd = $(u).attr('grd');
    			cur_match.halfScore = $(u).attr('halfScore');
    			cur_match.hscInfo = $(u).attr('hscInfo');
    			cur_match.gscInfo = $(u).attr('gscInfo');
    			cur_match.isRank = $(u).attr('isRank');
    			cur_match.ihot = $(u).attr('ihot');
    			all_match_zq_list[cur_match.sid+"a"]=cur_match;
			});
			$(".kctab span:eq(1)").html("足球("+zq_num+")");
		},
		error:function(){
			$(".kctab span:eq(1)").html("足球");
		}
	});
};


//获取关注比赛列表
var get_gz_match_list=function(){
	$.ajax({
		async:false,
		url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=7",
		type: 'GET',
		dataType: 'xml',
		timeout: 1000,
		success: function(data){
			n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
			$(data).find('row').each(function(i,u){
				var cur_match={};
    			cur_match.id = $(u).attr('id');
    			cur_match.sid = $(u).attr('sid');
    			cur_match.mid = $(u).attr('mid');
    			cur_match.itemId = $(u).attr('itemId');
    			cur_match.seasonId = $(u).attr('seasonId');
    			cur_match.hid = $(u).attr('hid');
    			cur_match.gid = $(u).attr('gid');
    			cur_match.ln = $(u).attr('ln');
    			cur_match.hn = $(u).attr('hn');
    			cur_match.gn = $(u).attr('gn');
    			cur_match.mtime = $(u).attr('mtime');
    			cur_match.htime = $(u).attr('htime');
    			cur_match.code = $(u).attr('code');
    			
    			cur_match.hr = $(u).attr('hr');
    			cur_match.gr = $(u).attr('gr');
    			
    			
    			cur_match.hsc = $(u).attr('hsc');
    			cur_match.gsc = $(u).attr('gsc');
    			cur_match.isrank = $(u).attr('isrank');
    			cur_match.ihot = $(u).attr('ihot');
    			cur_match.cyrs = $(u).attr('cyrs');
    			
    			gz_match_zq_list[cur_match.sid]=cur_match;
			});
		},
	});
};

XHC.ZLK=(function(){
	$(function(){
		clearInterval(_timeId_gz);
		clearInterval(_timeId);
		//loadCont_z();
		//get_all_match_list();	
		get_people();
		attention_sid();
		people_num();
	});
	
	var attention_sid = function(){
		//var sids=""
		$.ajax({
			async:false,
			url:'/grounder/fgoldenbeanaccount.go?flag=0&qtype=8',
			type: 'GET',
			dataType: 'xml',
			timeout: 1000,
			success: function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					var gzinfo  = R.find("gzinfo");
					var sids = sids_arr = gzinfo.attr("sids");
					gz_total = gzinfo.attr("total");
					$(".kctab span:eq(2)").html("关注("+gz_total+")");
				}
			},
			error:function(){
				sids_arr="";
				//gz_total = gzinfo.attr("total")
				$(".kctab span:eq(2)").html("关注(0)");
			}
		});
	};
	
	//获取足球参与人数
	var get_people=function(){
		$.ajax({
			async:false,
			url:'/zqjc/data/app/'+P1+'/tzcs.xml',
			type: 'GET',
			dataType: 'xml',
			timeout: 1000,
			success: function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					var row = R.find("row");
					if(row.length){
						row.each(function(){
							var mid = $(this).attr("mid");
							var tzcs = $(this).attr("tzcs"); 
							z_cyrs[mid]=tzcs;
						});
					}
				}else{
					alert(desc);
				}
			}
		});
	};
	
	//获取篮球参与人数
	var people_num=function(){
		$.ajax({
			url:'/nbajc/data/app/'+P1+'/tzcs.xml',
			dataType:'xml',
			cache:true,
	        success:function (xml){
	     	    var R = $(xml).find("Resp");
	 			var code = R.attr("code");
	 			if (code == "0") {//已登录
	 				var row = R.find("row");
	 				row.each(function(){
	 					var mid = $(this).attr("mid");
	 					var tzcs = $(this).attr("tzcs")?$(this).attr("tzcs"):"0";
	 					obData[mid]=tzcs;
	 				})
	 				loadCont();
	 			}else{
	 				loadCont();
	 			}
	        }
		});
	};
	
	
	var lqopenlist=function(){
		$.ajax({
			url:'/nbajc/matchs/dz_show.xml',
			dataType:'xml',
			cache:true,
	        success:function (xml){
	     	    var R = $(xml).find("Resp");
	 			var code = R.attr("code");
	 			var list = $(xml).find("row");
	 			
	 			basketball = list.text();
	 			basketballArray = basketball.split(",");
	        }
		});
	};
	
	
	//比赛状态(篮球)
	var st_={
		    '0': '开赛',
		    '13': '第一节',
		    '14': '第二节',
		    '15': '第三节',
		    '16': '第四节',
		    '20': '进行中',
		    '30': '暂停',
		    '31': '第二节',
		    '32': '中场',
		    '33': '第四节',
		    '34': '加时',
		    '40': '加时',
		    '60': '延期',
		    '90': '弃赛',
		    '100': '已完赛',
		    '110': '已完赛'
		};
	
	var _timeId_z,_timeId,_timeId_gz;
	var stMap={'17':'开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'};	
	
	var obData = {};
	
	//根据ios/android删除头部
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	};
	
	//导航切换
	var change_toggle=function(){
		if(flag && flag=="zq"){
			clearInterval(_timeId_gz);
			clearInterval(_timeId);
			$("#cont_z").show();
			$("#cont").hide();
			$("#attention").hide();
			$(".kctab span:eq(1)").addClass("cur");
			$(".kctab span:eq(1)").siblings().removeClass("cur");
		}else if(flag && flag=="lq"){
			clearInterval(_timeId_gz);
			clearInterval(_timeId_z);
			$(".kctab span:eq(0)").addClass("cur");
			$(".kctab span:eq(0)").siblings().removeClass("cur");
			$("#cont_z").hide();
			$("#attention").hide();
			$("#cont").show();
		}else if(flag && flag=="gz"){
			clearInterval(_timeId_z);
			clearInterval(_timeId);
			$(".kctab span:eq(2)").addClass("cur");
			$(".kctab span:eq(2)").siblings().removeClass("cur");
			attention_match();
			$("#cont_z").hide();
			$("#attention").show();
			$("#cont").hide();
		}else{
			$("#cont_z").show();
			$("#cont").hide();
			$(".kctab span:eq(1)").addClass("cur");
			$(".kctab span:eq(1)").siblings().removeClass("cur");
		}
	};
	
	var zq_matchs={};
	var zq_gz_matchs={};
	
	var init=function(){
		lqopenlist();
		change_toggle();
		remove_header();
		loadCont_z();
		bindEvent();
	};

	//判断用户是否登录
	var bindEvent=function(){
		var urlArr={
				"0":"bkbc.html",
				"1":"phb.html",
				"2":"fx.html",
				"3":"myjc.html"
		};
		
		//底部切换模块(页面)
		$(".kcfooter li").bind("click",function(){
			var index=$(this).index();
			window.location.href=urlArr[index];
		});
		
		//篮球、足球、关注导航切换
		$(".kctab span").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			$("article.kcdzqd:eq("+index+")").show();
			$("article.kcdzqd:eq("+index+")").siblings("article.kcdzqd").hide();
			
			if(index==0){//篮球
				clearInterval(_timeId_z);
				clearInterval(_timeId_gz);
				localStorage.setItem("flag","lq");
				loadCont();
				window.clearInterval(_timeId_z);
			}else if(index==1){//足球
				$("#over_nav").parent().addClass("cur")
				attention_sid();
				clearInterval(_timeId);
				clearInterval(_timeId_gz);
				localStorage.setItem("flag","zq");
				loadCont_z();
				window.clearInterval(_timeId);
			}else{//关注
				$("#attention_cont").html("");
				pnum=1;
				clearInterval(_timeId_z);
				clearInterval(_timeId);
				localStorage.setItem("flag","gz");
				attention_match();
			}
		});
		
		//足球=>热门导航
		$("#hotting_nav").bind("click",function(){
			$(this).parent().toggleClass("cur");
		});
		
		//足球=>进行中导航
		$("#progress_nav").bind("click",function(){
			$(this).parent().toggleClass("cur");
		});
		
		//足球=>完场导航
		$("#over_nav").bind("click",function(){
			$(this).parent().toggleClass("cur");
			over_fun();
		});
		
		//进行中的比赛(关注)
		$("#progress").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur");
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur");
			}
			add_attention();
			return false;
		});
		
		//热门比赛(关注)
		$("#hotting").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
			}
			add_attention();
			return false;
		});
		
		//完场比赛(关注)
		$("#over").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
			}
			add_attention();
			return false;
		});
		
		//关注比赛(添加/取消关注)
		$("#attention").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
			}
			add_attention();//添加关注方法
			return false;
		});
		
		//关注比赛(设置localStorage对象)
		$("#attention").delegate("a","click",function(event){
			event.preventDefault(); 
			var sid = $(this).attr("sid");
			localStorage.setItem("cur_match",JSON.stringify(gz_match_zq_list[sid]))
			window.location.href="/gq2/jczq.html";
			return false;
		});
		
		//热门、完场、进行中(设置localStorage对象)
		$("#progress,#over,#hotting").delegate("a","click",function(event){
			event.preventDefault(); 
			var sid = $(this).attr("sid");
			localStorage.setItem("cur_match",JSON.stringify(all_match_zq_list[sid+"a"]));
			window.location.href="/gq2/jczq.html";
			return false;
		});
		
		//更多关注
		$(".more").bind("click",function(){
			attention_match();
		});
	};
	
	//加载篮球内容
	var loadCont = function(){
		var html="";
		var listnum=0;		
		$.ajax({
			url:"/nbajc/matchs/"+P1+"/mallmatches.json?"+Math.random(),
			dataType:'JSON',
			cache:true,
			success:function(data){
				if(data.length){
					for(var i=0;i<data.length;i++){
						var gid = data[i]["gid"];
						var hid = data[i]["hid"];
						var gjs = data[i]["gjs"];
						var hjs = data[i]["hjs"];
						var gn = data[i]["gn"];
						var hn = data[i]["hn"];
						var gr = data[i]["gr"];//客队排名
						var hr = data[i]["hr"];//主队排名
						var id = data[i]["id"];//资料库id
						var mid = data[i]["mid"];//主站赛事id
						var gid = data[i]["gid"];
						var gsc = data[i]["gsc"];//客队比分
						var hsc = data[i]["hsc"];//主队比分
						var time = data[i]["time"];//主队比分
						var statusCode = data[i]["statusCode"];
						var isRank = data[i]["isRank"];
						var ln = data[i]["ln"];
						if(ln!="WNBA"){
							ln = ln.substring(0,3);
						}
					
				//if(basketball.indexOf(mid)!=-1){
				if($.inArray(mid,basketballArray)!=-1){
					listnum++
					var mtime = data[i]["mtime"];//开赛时间
					mtime = mtime.replace(/-/g,"/");
					var t = new Date(mtime);
					var d = t.getDate();
					var H = t.getHours();
					var M = t.getMinutes();
					var month = t.getMonth()+1
					month=month<10?"0"+month:month
					M=M<10?"0"+M:M
					var timeStr = month+"-"+d+" "+H+":"+M;
					
					html += '<a href="/gq2/jclq.html?'+id+'" class="'+(isRank==1?"cur":"")+'" id="'+id+'">'
					html += '<u>'+ln+'</u>'
					html += '<p><cite><img src="lqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
					html += '<p class="mid">';
					if(statusCode==0){
						html +=	'<span>'+timeStr+ st_[statusCode]+'</span><b>'+"--"+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>';
					}else{
						if(statusCode==100||statusCode==110){
							html +=	'<span>'+st_[statusCode]+'  '+(statusCode!=0?time:mtime)+'</span><b>'+(statusCode!=0?gsc+':'+hsc:"--")+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>'
						}else{
							html +=	'<span><i class="hqico"></i>'+st_[statusCode]+'  '+(statusCode!=0?time:mtime)+'</span><b>'+(statusCode!=0?gsc+':'+hsc:"--")+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>'
						}
					}
					html += '</p>';
					html += '<p><cite><img src="lqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
					html += '</a>';
				}

				$("#cont").html(html);
				gain();
				}		

				$(".kctab span:eq(0)").html("篮球("+listnum+")");

				}else{
					$("#cont").html(nodata);
				}
			},
			error:function(){
				//alert("网络异常");
			}
		});
	};
	
	//篮球更新比分
	var gain = function(){
		var html = "";
		//及时调用头部(5s)
		_timeId=setInterval(function(){
			$.ajax({
				url:"/nbajc/matchs/change.xml?"+Math.random(),
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Rows");
					var row = R.find("row");
					if(row.length){
						row.each(function(){
							var t = {};
							t.id = $(this).attr('id');
							t.mid = $(this).attr('mid');
							t.statusCode = $(this).attr('code');
							t.hs = $(this).attr('hs');//当前节主队比分
				    		t.gs = $(this).attr('gs');
				    		t.hsc = $(this).attr('hsc');
				    		t.gsc = $(this).attr('gsc');
				    		t.time = $(this).attr('time');//倒计时器
			    			if(t.statusCode==0){
								html =	'<span>'+timeStr+ st_[t.statusCode]+'</span><b>'+"--"+'</b><span class="pater">'+(obData[t.mid]?obData[t.mid]:"0")+'人已参与</span>'
							}else{
								if(t.statusCode==100||t.statusCode==90||t.statusCode==110){
									html =	'<span>'+st_[t.statusCode]+'  '+(t.statusCode!=0?t.time:mtime)+'</span><b>'+(t.statusCode!=0?t.gsc+':'+t.hsc:"--")+'</b><span class="pater">'+(obData[t.mid]?obData[t.mid]:"0")+'人已参与</span>'
								}else{
									html =	'<span><i class="hqico"></i>'+st_[t.statusCode]+'  '+(t.statusCode!=0?t.time:mtime)+'</span><b>'+(t.statusCode!=0?t.gsc+':'+t.hsc:"--")+'</b><span class="pater">'+(obData[t.mid]?obData[t.mid]:"0")+'人已参与</span>'
								}
							}
				    		$("#cont a[id='"+t.id+"'] p:eq(1)").html(html);
						});
						
					}else{
						clearInterval(_timeId);//清楚定时器
					}
				}
			});
		},5000);
		return html;
	};

	//加载足球内容
	var loadCont_z = function(){
		get_all_match_list();//读取所有对阵对象
		clearInterval(_timeId_gz);
		clearInterval(_timeId);
		
		var html="";
		var newhtml="";
		
		var hottingHTML="";//热门比赛内容
		var progressHTML="";//进行中比赛内容
		var overHTML="";//完场比赛内容
		
		var over_num=0;
		var progress_num=0;
		var hotting_num=0;
		
		if(all_match_zq_list != null){
			for(var i in all_match_zq_list){
				var temp={};
				var gid = temp.gid = all_match_zq_list[i]["gid"];
				var hid = temp.hid = all_match_zq_list[i]["hid"];
				var gn = temp.gn = all_match_zq_list[i]["gn"];
				gn = gn.substring(0,5);
				var hn = temp.hn = all_match_zq_list[i]["hn"];
				hn = hn.substring(0,5);
				var gr = temp.gr = all_match_zq_list[i]["gr"];//客队排名
				var hr = temp.hr = all_match_zq_list[i]["hr"];//主队排名
				var id = temp.id = all_match_zq_list[i]["id"];//资料库id
				var sid = temp.sid = all_match_zq_list[i]["sid"];
				var mid = temp.mid = all_match_zq_list[i]["mid"];//主站赛事id
				var itemId = temp.mid = all_match_zq_list[i]["itemId"];
				var seasonId = temp.seasonId = all_match_zq_list[i]["seasonId"];
				var code = temp.code = all_match_zq_list[i]["code"];
				var ihot = temp.ihot = all_match_zq_list[i]["ihot"];//是否为热门比赛
				var htime = temp.htime = all_match_zq_list[i]["htime"];
				
				var ln = temp.ln = all_match_zq_list[i]["ln"];
				ln = ln.substring(0,3);
				var gsc = temp.gsc = all_match_zq_list[i]["gsc"];//客队比分
				var hsc = temp.hsc = all_match_zq_list[i]["hsc"];//主队比分
				
				var grd = temp.grd = all_match_zq_list[i]["grd"];//客队比分
				var hrd = temp.hrd = all_match_zq_list[i]["hrd"];//主队比分
				
				var halfScore = temp.halfScore = all_match_zq_list[i]["halfScore"];//半场比分
				var swapTeam = temp.swapTeam = all_match_zq_list[i]["swapTeam"];//
				
				var gscInfo = temp.gscInfo = all_match_zq_list[i]["gscInfo"];//客队
				var hscInfo = temp.hscInfo = all_match_zq_list[i]["hscInfo"];//主队近十场战绩
				
				var isRank = temp.isRank = all_match_zq_list[i]["isRank"];//单场排行标志  1：是单场  0：不是
				var mtime = temp.mtime = all_match_zq_list[i]["mtime"];//开赛时间
				
				var ktime=htime?Date.parse(new Date(htime.replace(/-/g,"/"))):0;
				st = parseInt((n_-ktime)/60000);
				
				if(code==1){//上
					st = st<45?st:45+"+";
				}else if(code==2){//中
					st="";
				}else if(code==3){//下
					st = st<45?45+st:"90+";
				}
				
				mtime = mtime.replace(/-/g,"/");
				var t = new Date(mtime);
				var d = t.getDate();
				var H = t.getHours();
				var M = t.getMinutes();
				var month = t.getMonth()+1
				month=month<10?"0"+month:month
				M=M<10?"0"+M:M
				var timeStr = month+"-"+d+" "+H+":"+M;
				
				zq_matchs[sid]=temp;
		//var stMap={'17':'开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'}
				//热门比赛
				if(code!=4){//不是完场的比赛
					var tmpHTML = "";
					if(code==17 ||code==5 ||code==13 ||code==14 ||code==15){
						tmpHTML =	'<span>'+timeStr+ stMap[code]+'</span><b>'+"--"+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>';
					}else if(code==8||code==11){
						tmpHTML =	'<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
					}else{
						tmpHTML =	'<span><i class="lqico"></i>'+(code==2?"中场":st)+'<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
					}
					
					if(ihot==1){//热门比赛
						hotting_num++;//热门场次的个数
						hottingHTML += '<a href="/gq2/jczq.html?'+id+'" sid="'+sid+'" class="'+(sids_arr.indexOf(sid)>=0?"cur":"")+'">';
						if(isRank==1){
							hottingHTML += '<s></s>';//加奖标识
						}else{
							hottingHTML += '';
						}
						hottingHTML += '<u>'+ln+'</u>';
						hottingHTML += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>';
						hottingHTML += '<p class="mid">'+tmpHTML+'</p>';
						hottingHTML += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>';
						hottingHTML += '<div class="gz"><big></big></div>';
						hottingHTML += '</a>';
					}else{
						progress_num++;
						progressHTML += '<a href="/gq2/jczq.html?'+id+'" sid="'+sid+'" class="'+(sids_arr.indexOf(sid)>=0?"cur":"")+'">'
						progressHTML += '<u>'+ln+'</u>'
						progressHTML += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
						progressHTML += '<p class="mid">'+tmpHTML+'</p>'
						progressHTML += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
						progressHTML += '<div class="gz"><big></big></div>'
						progressHTML += '</a>'
					}
				}else{
					over_num++;
				}
			}	
				
			if(over_num<1){
				$("#over_nav").parent().hide();
			}else{
				$("#over_nav").parent().show();
			}
			
			if(hotting_num<1){
				$("#hotting_nav").parent().hide();
			}else{
				$("#hotting_nav").parent().show();
			}
			
			if(progress_num<1){
				$("#progress_nav").parent().hide();
			}else{
				$("#progress_nav").parent().show();
			}
			
			$("#progress").prev().html("竞猜中的比赛("+progress_num+")");
			$("#over_nav").html("已结束的比赛("+over_num+")");
			$("#progress").html(progressHTML);
			$("#hotting").html(hottingHTML);
			
			gain_z();//更新比分
		}else{
			$("#cont_z").html(nodata);
		}
	};
	
	//关注的对象所需要的参数
	var attention_param={
			flag:1,
			utype:5,
			sid:"",
			optype:"0"
	}
	
	//添加关注
	var add_attention=function(obj){
		if(attention_param.optype==1){
			gz_total--;
			if(gz_total<0){
				gz_total=0;
			}
		}else{
			gz_total++;
		}
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go",
			data:attention_param,
			dataType:'xml',
			cache:true,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					//attention_match();//重新加载关注内容
					$(".kctab span:eq(2)").html("关注("+gz_total+")");
				}else{
					alert(desc);
				}
			}
		});
	};
	
	var one_time=function(){
		$.ajax({
			url:"/zqjc/change/change.xml?"+Math.random(),
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Rows");
				var row = R.find("row");
				
				var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
				if(row.length){
					row.each(function(){
						var t = {};
						var mtime="";
						t.sid = $(this).attr('sid');
						//t.mid = $(this).attr('mid');
						t.statusCode = $(this).attr('code');
			    		t.hsc = $(this).attr('hsc');
			    		t.gsc = $(this).attr('gsc');
			    		t.hrd = $(this).attr('hrd');
			    		t.grd = $(this).attr('grd');
			    		var htime = t.htime = $(this).attr('htime');
			    		
			    		mtime = zq_gz_matchs[t.sid]?zq_gz_matchs[t.sid].mtime:"";
						mtime = zq_matchs[t.sid]?zq_matchs[t.sid].mtime:mtime;
						
	    				mtime = mtime?mtime.replace(/-/g,"/"):"";
						var date = new Date(mtime);
						var d = date.getDate();
						var H = date.getHours();
						var M = date.getMinutes();
						var month = date.getMonth()+1
						month=month<10?"0"+month:month
						M=M<10?"0"+M:M
						var timeStr = month+"-"+d+" "+H+":"+M;
						
						//更新关注对象的状态
						if(gz_match_zq_list[t.sid]){
							gz_match_zq_list[t.sid]["code"]=t.statusCode;
						}
						
		    			if(t.statusCode==17 ||t.statusCode==5 ||t.statusCode==13 ||t.statusCode==14 ||t.statusCode==15){
		    				html =	'<span>'+timeStr+ stMap[t.statusCode]+'</span><b>'+"--"+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>';
						}else if(t.statusCode==8||t.statusCode==11){//加时
							html =	'<span>'+stMap[code]+'</span><b>'+t.hsc+':'+t.gsc+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>'
						}else if(t.statusCode==4){//完场
							html =	'<span>'+stMap[t.statusCode]+'</span><b>'+t.hsc+':'+t.gsc+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>'
						}else{//进行中........
							htime=htime?Date.parse(new Date(htime.replace(/-/g,"/"))):"";
							st = parseInt((n_-htime)/60000);
							if(t.statusCode==1){//上
								st=st<45?st:45+"+";
							}else if(t.statusCode==2){//中
								st="";
							}else if(t.statusCode==3){//下
								st=st<45?(45+st):(90+"+")
							}
							html =	'<span><i class="lqico"></i>'+(t.statusCode==2?"中场":st+"<em class='fen'>′</em>")+'</span><b>'+t.hsc+':'+t.gsc+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>'
						}
			    		$("#attention a[sid='"+t.sid+"'] p:eq(1)").html(html);
					});
				}else{
					clearInterval(_timeId_gz);//清楚定时器
				}
			}
		});
	
	};
	
	var gain_gz = function(){
		var html = "";
		//及时调用头部(5s)
		_timeId_gz=setInterval(one_time,5000);
	};
	
	var attention_num=0;//关注比赛的个数
	var pnum=1;//分页参数，默认第一页
	//已经关注的比赛(查询关注方法)
	var attention_match=function(){
		get_gz_match_list();//获取所有关注的对象
		var html = $("#attention_cont").html();
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=7&pnum="+pnum+"&psize=10",
			dataType:'xml',
			cache:true,
			success:function(xml){
				var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");

				if(code==0){
					var gzinfo = R.find("gzinfo");
					var gcode = gzinfo.attr("code");
					var tpage = gzinfo.attr("tpage")//总页数
					if(gcode==0){
						var row = gzinfo.find("row");
						if(tpage==0){
							$(".attention_cont").html(nodata);
							$(".more").hide();
						}else if(row.length>0){
							if(pnum<=tpage){
								row.each(function(){
									var tmp={},tmp1={};
									attention_num++;
									var sid = $(this).attr("sid");
									var id =tmp.id= $(this).attr("id");
									var ln = $(this).attr("ln").substr(0,3);
									
									var hn = $(this).attr("hn");
									hn = hn.substring(0,5)
									var gn = $(this).attr("gn");
									gn = gn.substring(0,5)
									
									var hid = $(this).attr("hid");//主队id
									var gid = $(this).attr("gid");
									
									var code = $(this).attr("code");
									var mtime = $(this).attr("mtime");
									
									var hsc = $(this).attr("hsc");
									var gsc = $(this).attr("gsc");
									
									var isrank = $(this).attr("isrank");
									var cyrs = $(this).attr("cyrs");
									
									var itemId = $(this).attr("itemId");
									
									tmp.sid=sid;
									tmp.mtime=mtime;
									zq_gz_matchs[sid]=tmp;
									
									tmp1.itemId=itemId;
									tmp1.sid=sid;
									tmp1.id=id;
									tmp1.ln=ln;
									tmp1.hn=hn;
									tmp1.gn=gn;
									tmp1.hid=hid;
									tmp1.gid=gid;
									tmp1.code=code;
									tmp1.mtime=mtime;
									tmp1.hsc=hsc;
									tmp1.gsc=gsc;
									tmp1.isrank=isrank;
									tmp1.cyrs=cyrs;
									
									
									gz_match_zq_list[sid]=tmp1;
									
									var ktime=mtime?Date.parse(new Date(mtime.replace(/-/g,"/"))):0;//开赛时间
									st = parseInt((n_-ktime)/60000);
									if(code==1){//上
										st = st<45?st:45+"+";
									}else if(code==2){//中
										st="";
									}else if(code==3){//下
										st = st<45?45+st:"90+";
									}
		
									mtime = mtime.replace(/-/g,"/");//开赛时间
									var t = new Date(mtime);
									var d = t.getDate();
									var H = t.getHours();
									var M = t.getMinutes();
									var month = t.getMonth()+1
									month=month<10?"0"+month:month
									M=M<10?"0"+M:M
									var timeStr = month+"-"+d+" "+H+":"+M;
									
									var tmpHTML="";
									if(code==17 ||code==5 ||code==13 ||code==14 ||code==15){
										tmpHTML =	'<span>'+timeStr+ stMap[code]+'</span><b>'+"--"+'</b><span class="pater">'+cyrs+'人已参与</span>';
									}else if(code==4||code==8||code==11){
										tmpHTML =	'<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+cyrs+'人已参与</span>'
									}else{
										tmpHTML =	'<span><i class="lqico"></i>'+'<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+cyrs+'人已参与</span>'
									}
									
									html+='<a href="javascript:;" class="cur" sid="'+sid+'">'
									
									if (isrank==1){
										html+="<s></s>";
									}
									html+="<u>"+ln+"</u>";
									html+='<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>';
									html+='<p class="mid">';
									html+=tmpHTML;
									html+='</p>';
									html+='<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>';
									html+='<div class="gz"><big></big></div>';
									html+='</a>';
								})
								if(tpage==pnum){
									$(".more").hide();
								}else{
									$(".more").show().css("display","block");
								}
								pnum++;
								$("#attention_cont").html(html);
								one_time();
								gain_gz();
							}
							
						}
					}else{
						$(".more").hide()
						$("#attention_cont").html(nodata);
					}
				}else{
					alert(desc);
				}
			}
		})
	};
	
	//足球(已结束的赛事)
	var over_fun = function(){
		var overHTML="";
		var over_num=0;
		$.ajax({
			url:"/zqjc/matchs/mobile/matchs.xml?"+Math.random(),
			//url:"/zqjc/matchs/matchs.xml?"+Math.random(),
			dataType:'xml',
			cache:true,
			success:function(xml){
				var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
				var Rows = $(xml).find("Rows")
				var row = Rows.find("row")
				
				$(".kctab span:eq(1)").html("足球("+row.length+")");
				
				if(row.length){
					row.each(function(){
						var temp={};
						var gid = temp.gid = $(this).attr("gid");
						var hid = temp.hid = $(this).attr("hid");
						var gn = temp.gn = $(this).attr("gn");
						var hn = temp.hn = $(this).attr("hn");
						var gr = temp.gr = $(this).attr("gr");//客队排名
						var hr = temp.hr = $(this).attr("hr");//主队排名
						var id = temp.id = $(this).attr("id");//资料库id
						var sid = temp.sid = $(this).attr("sid");
						var mid = temp.mid = $(this).attr("mid");//主站赛事id
						var itemId = temp.mid = $(this).attr("itemId");
						var seasonId = temp.seasonId = $(this).attr("seasonId");
						var code = temp.code = $(this).attr("code");
						var ihot = temp.ihot = $(this).attr("ihot");//是否为热门比赛
						var htime = temp.htime = $(this).attr("htime");
						
						var ln = temp.ln = $(this).attr("ln");
						ln = ln.substring(0,3);
						var gsc = temp.gsc = $(this).attr("gsc");//客队比分
						var hsc = temp.hsc = $(this).attr("hsc");//主队比分
						
						var grd = temp.grd = $(this).attr("grd");//客队比分
						var hrd = temp.hrd = $(this).attr("hrd");//主队比分
						
						var halfScore = temp.halfScore = $(this).attr("halfScore");//半场比分
						var swapTeam = temp.swapTeam = $(this).attr("swapTeam");//
						
						var gscInfo = temp.gscInfo = $(this).attr("gscInfo");//客队
						var hscInfo = temp.hscInfo = $(this).attr("hscInfo");//主队近十场战绩
						
						var isRank = temp.isRank = $(this).attr("isRank");//单场排行标志  1：是单场  0：不是
						var mtime = temp.mtime = $(this).attr("mtime");//开赛时间
						
						var ktime=htime?Date.parse(new Date(htime.replace(/-/g,"/"))):0;
						st = parseInt((n_-ktime)/60000);
						if(code==1){//上
							st = st<45?st:45+"+";
						}else if(code==2){//中
							st="";
						}else if(code==3){//下
							st = st<45?45+st:"90+";
						}
						
						mtime = mtime.replace(/-/g,"/");
						var t = new Date(mtime);
						var d = t.getDate();
						var H = t.getHours();
						var M = t.getMinutes();
						var month = t.getMonth()+1
						month=month<10?"0"+month:month
						M=M<10?"0"+M:M
						var timeStr = month+"-"+d+" "+H+":"+M;
						
						zq_matchs[sid]=temp;
						
						//完场比赛
						if(code==4){
							over_num++;
							overHTML += '<a href="/gq2/jczq.html?'+id+'" sid="'+sid+'" class="'+(sids_arr.indexOf(sid)>=0?"cur":"")+'">'
							overHTML += '<u>'+ln+'</u>'
							overHTML += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
							overHTML += '<p class="mid">'
							overHTML += '<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
							overHTML += '</p>'
							overHTML += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
							overHTML += '<div class="gz"><big></big></div>'
							overHTML += '</a>'
						}
					})
					$("#over").prev().html("已结束的比赛("+over_num+")");
					$("#over").html(overHTML);
				}else{
					$("#cont_z").html(nodata);
				}
			},
			error:function(){
				//alert("网络异常");
			}
		});
	}
	
	var gain_z = function(){
		var html = "";
		//及时调用头部(5s)
		_timeId_z=setInterval(function(){
			$.ajax({
				url:"/zqjc/change/change.xml?"+Math.random(),
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Rows");
					var row = R.find("row");
					
					var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
					if(row.length){
						row.each(function(){
							var t = {};
							t.sid = $(this).attr('sid');
							//t.mid = $(this).attr('mid');
							t.statusCode = $(this).attr('code');
				    		t.hsc = $(this).attr('hsc');
				    		t.gsc = $(this).attr('gsc');
				    		t.hrd = $(this).attr('hrd');
				    		t.grd = $(this).attr('grd');
				    		var htime = t.htime = $(this).attr('htime');
				    		
				    		var mtime = zq_matchs[t.sid]?zq_matchs[t.sid].mtime:"";
		    				mtime = mtime?mtime.replace(/-/g,"/"):"";
							var date = new Date(mtime);
							var d = date.getDate();
							var H = date.getHours();
							var M = date.getMinutes();
							var month = date.getMonth()+1
							month=month<10?"0"+month:month
							M=M<10?"0"+M:M
							var timeStr = month+"-"+d+" "+H+":"+M;
							
							if(all_match_zq_list[t.sid+"a"]){
								all_match_zq_list[t.sid+"a"]["code"]=t.statusCode;
							}
							 
			    			if(t.statusCode==17 ||t.statusCode==5 ||t.statusCode==13 ||t.statusCode==14 ||t.statusCode==15){
			    				html =	'<span>'+timeStr+ stMap[t.statusCode]+'</span><b>'+"--"+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>';
							}else if(t.statusCode==8||t.statusCode==11){//加时
								html =	'<span>'+stMap[code]+'</span><b>'+t.hsc+':'+t.gsc+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>'
							}else if(t.statusCode==4){//完场
								html =	'<span>'+stMap[t.statusCode]+'</span><b>'+t.hsc+':'+t.gsc+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>'
							}else{//进行中........
								htime=htime?Date.parse(new Date(htime.replace(/-/g,"/"))):"";
								st = parseInt((n_-htime)/60000);
								if(t.statusCode==1){//上
									st=st<45?st:45+"+";
								}else if(t.statusCode==2){//中
									st="";
								}else if(t.statusCode==3){//下
									st=st<45?(45+st):(90+"+")
								}
								html =	'<span><i class="lqico"></i>'+(t.statusCode==2?"中场":st+"<em class='fen'>′</em>")+'</span><b>'+t.hsc+':'+t.gsc+'</b><span class="pater">'+(z_cyrs[t.sid]?z_cyrs[t.sid]:"0")+'人已参与</span>'
							}
				    		$("#cont_z a[sid='"+t.sid+"'] p:eq(1)").html(html);
						});
					}else{
						clearInterval(_timeId_z);//清楚定时器
					}
				}
			});
		},5000);
	};
	
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})



