var XHC={};


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

var sids_arr="";

var CP={}
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

var flag = localStorage.getItem("flag");
var d = new Date();
var y = d.getFullYear();
var m1 = d.getMonth()+1;
m1=m1<10?"0"+m1:m1;
var day =d.getDate();
day=day<10?"0"+day:day;
var P1 = y+""+m1+""+day;

var gz_total=0;

var z_cyrs={};
XHC.ZLK=(function(){
	
	$(function(){
		if(flag && flag=="zq"){
			clearInterval(_timeId_gz)
			clearInterval(_timeId)
			loadCont_z();
			$("#cont_z").show();
			$("#cont").hide();
			$("#attention").hide();
			$(".kctab span:eq(1)").addClass("cur");
			$(".kctab span:eq(1)").siblings().removeClass("cur");
		}else if(flag && flag=="lq"){
			clearInterval(_timeId_gz)
			clearInterval(_timeId_z)
			loadCont();
			$(".kctab span:eq(0)").addClass("cur");
			$(".kctab span:eq(0)").siblings().removeClass("cur");
			$("#cont_z").hide();
			$("#attention").hide();
			$("#cont").show();
		}else if(flag && flag=="gz"){
			clearInterval(_timeId_z)
			clearInterval(_timeId)
			attention_match();
			$(".kctab span:eq(2)").addClass("cur");
			$(".kctab span:eq(2)").siblings().removeClass("cur");
			$("#cont_z").hide();
			$("#attention").show();
			$("#cont").hide();
		}else{
			loadCont_z();
			$("#cont_z").show();
			$("#cont").hide();
			$(".kctab span:eq(1)").addClass("cur");
			$(".kctab span:eq(1)").siblings().removeClass("cur");
		}
		get_people();
		attention_sid();
		people_num();
	})
	
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
					var sids = sids_arr = gzinfo.attr("sids")
					gz_total = gzinfo.attr("total")
					
					$(".kctab span:eq(2)").html("关注("+gz_total+")");
				}
			},
			error:function(){
				sids_arr="";
				//gz_total = gzinfo.attr("total")
				
				$(".kctab span:eq(2)").html("关注(0)");
			}
		})
	}
	
	
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
						})
					}
				}
			}
		})
	}
	
	var obData = {
				
		}
		
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
		}
	
	//比赛状态
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
	var stMap={'17':'开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'}	
	
	
	/***
	//读取参与人数方法
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
	 				loadCont($(".kctab span.cur").index());
	 			}else{
	 				loadCont($(".kctab span.cur").index());
	 			}
	        }
		});
	}
	***/
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	var zq_matchs={};
	var init=function(){
		remove_header();
		//people_num();
		
		//loadCont_z();
		//loadCont();
		bindEvent();
		
		
	};

	var from = location.search.getParam("from");
	var appversion = location.search.getParam("appversion");
	appversion=appversion?parseInt(appversion.replace(/\./g,'')):"";
	
	//判断用户是否登录
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
		
		$(".kctab span").bind("click",function(){
			var index = $(this).index();
			
			$(this).addClass("cur").siblings().removeClass("cur");
			
			$("article.kcdzqd:eq("+index+")").show();
			$("article.kcdzqd:eq("+index+")").siblings("article.kcdzqd").hide();
			
			if(index==0){
				//pnum=1;
				clearInterval(_timeId_z)
				clearInterval(_timeId_gz)
				localStorage.setItem("flag","lq")
				loadCont();
				window.clearInterval(_timeId_z)
			}else if(index==1){
				
				$("#over_nav").parent().addClass("cur")
				attention_sid();
				clearInterval(_timeId)
				clearInterval(_timeId_gz)
				localStorage.setItem("flag","zq")
				loadCont_z();
				window.clearInterval(_timeId)
			}else{
				$("#attention_cont").html("");
				pnum=1;
				clearInterval(_timeId_z)
				clearInterval(_timeId)
				localStorage.setItem("flag","gz")
				attention_match();
			}
		})
		
		
		$("#hotting_nav").bind("click",function(){
			
			$(this).parent().toggleClass("cur")
		})
		
		$("#progress_nav").bind("click",function(){
			
			$(this).parent().toggleClass("cur")
		})
		
		$("#over_nav").bind("click",function(){
			//attention_sid();
			$(this).parent().toggleClass("cur");
			over_fun();
		});
		
		//进行中的比赛
		$("#progress").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
				
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
				//attention_match();
			}
			add_attention();
			return false;
		})
		
		//热门比赛
		$("#hotting").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
				//attention_match();
			}
			add_attention();
			return false;
		})
		
		//完场比赛
		$("#over").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
				//attention_match();
			}
			add_attention();
			return false;
		});
		
		//关注比赛
		$("#attention").delegate("a div.gz","click",function(event){
			event.preventDefault(); 
			var sid = attention_param.sid = $(this).parent().attr("sid");
			if($(this).parent().hasClass("cur")){
				attention_param.optype=1;
				$(this).parent().removeClass("cur")
				//add_attention()
			}else{
				attention_param.optype=0;
				$(this).parent().addClass("cur")
				//attention_match();
			}
			add_attention();//添加关注方法
			return false;
		});
		
		$(".more").bind("click",function(){
			attention_match();
		})
	}
	
	var loadCont = function(){
		var html="";
		$.ajax({
			url:"/nbajc/matchs/"+P1+"/mallmatches.json?"+Math.random(),
			dataType:'JSON',
			cache:true,
			success:function(data){
				if(data.length){
					$(".kctab span:eq(0)").html("篮球("+data.length+")");
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
						
						
						var ln = data[i]["ln"];;
						//ln = ln.substring(0,3);
						
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
							if(statusCode==100 || statusCode==110){
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
				}else{
					$("#cont").html(nodata);
				}
			},
			error:function(){
				//alert("网络异常");
			}
		});
	};
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
	}

	//足球
	var loadCont_z = function(){
		var html="";
		var newhtml="";
		
		var hottingHTML="";
		var progressHTML="";
		var overHTML="";
		
		var over_num=0;
		var progress_num=0;
		var hotting_num=0
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
						gn = gn.substring(0,5)
						var hn = temp.hn = $(this).attr("hn");
						hn = hn.substring(0,5)
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
								hotting_num++;
								hottingHTML += '<a href="/gq2/jczq.html?'+id+'" sid="'+sid+'" class="'+(sids_arr.indexOf(sid)>=0?"cur":"")+'">'
								if(isRank==1){
									hottingHTML += '<s></s>'//加奖标识
								}else{
									hottingHTML += ''
								}
								hottingHTML += '<u>'+ln+'</u>'
								hottingHTML += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
								hottingHTML += '<p class="mid">'+tmpHTML+'</p>'
								hottingHTML += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
								hottingHTML += '<div class="gz"><big></big></div>'
								hottingHTML += '</a>'
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
					})
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
					
					$("#progress").prev().html("竞猜中的比赛("+progress_num+")")
					$("#over_nav").html("已结束的比赛("+over_num+")")
					$("#progress").html(progressHTML);
					$("#hotting").html(hottingHTML);
					//$("#cont_z").html(newhtml+html);
					//$("#gj_url").show();
					gain_z();
				}else{
					$("#cont_z").html(nodata);
				}
				
			},
			error:function(){
				//alert("网络异常");
			}
		});
	};
	
	var attention_param={
			flag:1,
			utype:5,
			sid:"",
			optype:"0"
	}
	
	//添加关注
	var add_attention=function(obj){
		//var sid = $(obj).attr("sid");
		if(attention_param.optype==1){
			gz_total--
			if(gz_total<0){
				gz_total=0
			}
		}else{
			gz_total++
		}
		$.ajax({
			url:"/grounder/fgoldenbeanaccount.go",
			data:attention_param,
			dataType:'xml',
			cache:true,
			success:function(xml){
				
				//var supHTML = $(obj).parent().html();
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){
					//alert(desc)
					//attention_match();//重新加载关注内容
					$(".kctab span:eq(2)").html("关注("+gz_total+")");
				}else{
					alert(desc)
				}
			}
		})
	}
	
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
	
	}
	var gain_gz = function(){
		var html = "";
		//及时调用头部(5s)
		_timeId_gz=setInterval(one_time,5000);
		//return html;
	}
	
	var attention_num=0
	var pnum=1;
	//已经关注的比赛(查询关注方法)
	var attention_match=function(){
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
									var tmp={};
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
									
									tmp.sid=sid;
									tmp.mtime=mtime;
									zq_matchs[sid]=tmp;
									
									var ktime=mtime?Date.parse(new Date(mtime.replace(/-/g,"/"))):0;//开赛时间
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
									
									var tmpHTML="";
									if(code==17 ||code==5 ||code==13 ||code==14 ||code==15){
										tmpHTML =	'<span>'+timeStr+ stMap[code]+'</span><b>'+"--"+'</b><span class="pater">'+cyrs+'人已参与</span>';
									}else if(code==4||code==8||code==11){
										tmpHTML =	'<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+cyrs+'人已参与</span>'
									}else{
										tmpHTML =	'<span><i class="lqico"></i>'+'<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+cyrs+'人已参与</span>'
									}
									
									html+='<a href="/gq2/jczq.html?'+id+'" class="cur" sid="'+sid+'">'
									
									if (isrank==1){
										html+="<s></s>"
									}
									html+="<u>"+ln+"</u>";
									html+='<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>';
									html+='<p class="mid">';
									//html+='<span><i class="lqico"></i>50<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+cyrs+'人已参与</span>'
									html+=tmpHTML;
									html+='</p>';
									html+='<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>';
									html+='<div class="gz"><big></big></div>';
									html+='</a>';
								})
								if(tpage==pnum){
									$(".more").hide()
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
					
				}
				
			}
		})
	}
	
	
	
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
						
						
						//热门比赛
						if(code==4){
							over_num++;
							overHTML += '<a href="/gq2/jczq.html?'+id+'" sid="'+sid+'" class="'+(sids_arr.indexOf(sid)>=0?"cur":"")+'">'
							overHTML += '<u>'+ln+'</u>'
							overHTML += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
							overHTML += '<p class="mid">'
								//<span><i class="lqico"></i>30<em class="fen">′</em></span><b>3:5</b><span class="pater">8437人已参与</span>
							overHTML += '<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
							overHTML += '</p>'
							overHTML += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
							overHTML += '<div class="gz"><big></big></div>'
							overHTML += '</a>'
						}
					});
					$("#over").prev().html("已结束的比赛("+over_num+")");
					$("#over").html(overHTML);
					//$("#cont_z").html(newhtml+html);
					//$("#gj_url").show();
					//gain_z();
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
		//return html;
	}
	
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})



