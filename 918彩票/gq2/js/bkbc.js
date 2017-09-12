var XHC={};


var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="100%"></figure><p>暂无赛事可竞猜</p></article>';
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


var z_cyrs={};
XHC.ZLK=(function(){
	
	$(function(){
		if(flag && flag=="zq"){
			loadCont_z();
			$("#cont_z").show();
			$("#cont").hide();
			$(".kctab span:eq(1)").addClass("cur");
			$(".kctab span:eq(1)").siblings().removeClass("cur");
		}else if(flag && flag=="lq"){
			loadCont();
			$(".kctab span:eq(0)").addClass("cur");
			$(".kctab span:eq(0)").siblings().removeClass("cur");
			$("#cont_z").hide();
			$("#cont").show();
		}else{
			loadCont_z();
			$("#cont_z").show();
			$("#cont").hide();
			$(".kctab span:eq(1)").addClass("cur");
			$(".kctab span:eq(1)").siblings().removeClass("cur");
		}
		get_people();
		people_num();
	})
	
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
		    '35': '加时',
		    '40': '加时',
		    '60': '延期',
		    '61': '推迟开赛',
		    '70': '取消',
		    '80': '中断',
		    '90': '弃赛',
		    '100': '已完赛',
		    '110': '已完赛'
		};
	
	
	var _timeId_z,_timeId;
	var stMap={'17':'开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'}	
	
	var obData = {
			
	}
	
	
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
		
		loadCont_z();
		loadCont();
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
				localStorage.setItem("flag","lq")
				loadCont();
				window.clearInterval(_timeId_z)
			}else{
				localStorage.setItem("flag","zq")
				loadCont_z();
				window.clearInterval(_timeId)
			}
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
						html += '<p><cite><img src="lqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
						html += '<p class="mid">';
						if(statusCode==0){
							html +=	'<span>'+timeStr+ st_[statusCode]+'</span><b>'+"--"+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>';
						}else{
							if(statusCode==100){
								html +=	'<span>'+st_[statusCode]+'  '+(statusCode!=0?time:mtime)+'</span><b>'+(statusCode!=0?gsc+':'+hsc:"--")+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>'
							}else{
								html +=	'<span><i class="hqico"></i>'+st_[statusCode]+'  '+(statusCode!=0?time:mtime)+'</span><b>'+(statusCode!=0?gsc+':'+hsc:"--")+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>'
							}
							
						}
						
						
						html += '</p>';
						html += '<p><cite><img src="lqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
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
									html +=	'<span>'+st_[statusCode]+'  '+(statusCode!=0?time:mtime)+'</span><b>'+(statusCode!=0?gsc+':'+hsc:"--")+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>'
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
						var gn = temp.gn = $(this).attr("gn").substr(0,5);
						var hn = temp.hn = $(this).attr("hn").substr(0,5);
						var gr = temp.gr = $(this).attr("gr");//客队排名
						var hr = temp.hr = $(this).attr("hr");//主队排名
						var id = temp.id = $(this).attr("id");//资料库id
						var sid = temp.sid = $(this).attr("sid");
						var mid = temp.mid = $(this).attr("mid");//主站赛事id
						var itemId = temp.mid = $(this).attr("itemId");
						var seasonId = temp.seasonId = $(this).attr("seasonId");
						var code = temp.code = $(this).attr("code");
						
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
						
						
						if(isRank==1){
							newhtml += '<a href="/gq2/jczq.html?'+id+'" class="'+(isRank==1?"cur":"")+'" sid="'+sid+'">'
							newhtml += '<u>'+ln+'</u>'
							newhtml += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
							newhtml += '<p class="mid">';
							if(code==17 ||code==5 ||code==13 ||code==14 ||code==15){
								newhtml +=	'<span>'+timeStr+ stMap[code]+'</span><b>'+"--"+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>';
							}else if(code==4||code==8||code==11){//完场
								newhtml +=	'<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
							}else{
								newhtml +=	'<span><i class="lqico"></i>'+(code==2?"中场":st)+'<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
							}
							newhtml += '</p>';
							newhtml += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
							newhtml += '</a>';
						}else{
							html += '<a href="/gq2/jczq.html?'+id+'" class="'+(isRank==1?"cur":"")+'" sid="'+sid+'">'
							html += '<u>'+ln+'</u>'
							html += '<p><cite><img src="zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
							html += '<p class="mid">';
							if(code==17 ||code==5 ||code==13 ||code==14 ||code==15){
								html +=	'<span>'+timeStr+ stMap[code]+'</span><b>'+"--"+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>';
							}else if(code==4||code==8||code==11){//完场
								html +=	'<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
							}else{
								html +=	'<span><i class="lqico"></i>'+(code==2?"中场":st)+'<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
							}
							html += '</p>';
							html += '<p><cite><img src="zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
							html += '</a>';
						}
					})
					$("#cont_z").html(newhtml+html);
					$("#gj_url").show();
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



