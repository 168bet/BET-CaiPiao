var o = $({});
    $.subscribe = function () {o.on.apply(o, arguments);};
    $.unsubscribe = function () {o.off.apply(o, arguments);};
    $.publish = function () { o.trigger.apply(o, arguments);};

//    $.publish("/login/success", account);//发布
//
//$.subscribe("/login/success", o.bind);

    
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

var XHC={};
var D={
		render:function(e, opt){
			$("#tz_cont div.pdLeft1:eq(0) div.redText p:eq(1)").html("积分余额："+opt.integral);
			
			$("#tz_cont div.pdLeft1:eq(1) div.redText p:eq(1)").html("奖券余额："+opt.award);
			
		},
		
		//integral-积分  award-奖券  integral_balance-积分余额  award_balance-奖券余额
		confirm_tz:function(integral,award,fn,fn1){
			
			$('.ceng, #tz_confirm').show();
			Query.query_balance();
			$.subscribe("/login/success", D.render);
			$("#tz_cont div.pdLeft1:eq(0) div.redText p:eq(0)").html("是用"+integral+"积分报名参赛");
			$("#tz_cont div.pdLeft1:eq(1) div.redText p:eq(0)").html("是用"+award+"奖券报名参赛");
			
			$('#tz_cont div.btn_bg span:eq(0)').off().bind('click',function(){//积分充值
				if(typeof(fn) == "function"){fn();}
				$('.ceng, #tz_confirm').hide();
			});
			$('#tz_cont div.btn_bg span:eq(1)').off().bind('click',function(){//报名参赛
				if(typeof(fn1) == "function"){fn1();}
				$('.ceng, #tz_confirm').hide();
			});
			
			//关闭层
			$("#tz_confirm .ts_close").bind("click",function(){
				$('.ceng, #tz_confirm').hide();
			});
			
		}
};

var g={
		integral:0,//积分
		award:0,//奖券
		fps:1000
};

var d = new Date();
var y = d.getFullYear();
var m1 = d.getMonth()+1;
m1=m1<10?"0"+m1:m1;
var day =d.getDate();
day=day<10?"0"+day:day;
var P1 = y+""+m1+""+day;

var username = localStorage.getItem("username");//获取用户名
var mids = localStorage.getItem("mids");//获取用户名

var _timeId_z,_timeId,_timeId_gz;
var stMap={'17':'开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'};	
var z_cyrs={};//足球参与人数对象

var Query={
		//查询各种余额
		query_balance:function(){
			this.integral_balance();
		},

		//积分余额
		integral_balance:function(){
			$.ajax({
				url : '/user/mlottery.go?flag=40',
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var point = R.attr("point");//积分
					
					//奖券余额
					$.ajax({
						url : '/activity/ticket.go?flag=2&visit=3000',
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							var R=$(xml).find("Resp");
							var award = R.attr("balance");
							var opt = {
									integral:point,
									award:award
							}
							g.integral=point;
							g.award=award;
							$.publish("/login/success", opt);//发布
						}
					});
				}
			});
		},

		
}


XHC.DB=(function(){
	$(function(){
		get_people();
	});
	
	
	var init=function(){
		load_game();
		bindEvent();
	};
	
	var bm_jf_jq={
			integral:0,//积分
			award:0//奖券	
	}
	
	//报名成功所需参数
	var sign_up_success_param={
			  flag:2,//操作标识，用来判断查询的逻辑，1表示查询用户是否报名过此期次，2表示进行报名操作 
			  cnickid:username,//当前登录用户名
			  periodid:"",//当前的期次号
			  stype:"2",//1表示用积分报名，2表示用奖券报名
			  pointRemain:0,//表示该用户剩余的积分
			  visit:3500//主要验证visit(来源)字段
	};
	
	
	var bindEvent=function(){
		//头部导航切换
		$("#nav span").bind("click",function(){
			var index=$(this).index();
			$(this).addClass("cur");
			$(this).siblings().removeClass("cur");
			if(index==0){//进行中
				$("#progress").show();
				$("#over").hide();
				progressing();
			}else{//已结束
				$("#progress").hide();
				$("#over").show();
				overing();
			}
		});
		
		//奖券、积分切换
		$("#tz_cont div.pdLeft1").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur");
			$(this).siblings().removeClass("cur");
			if(index==0){
				sign_up_success_param.stype=1;//积分
			}else{
				sign_up_success_param.stype=2;//奖券
			}
		});
		
		//进行中报名参赛
		$("#progress").delegate(".bm","click",function(){
			if($(this).hasClass("gray")){//不能报名参赛
				return;
			}
			
			
			
			var integral = bm_jf_jq.integral= $(this).parents("li").attr("integral");//积分
			var ticket =bm_jf_jq.award= $(this).parents("li").attr("ticket");//奖券
			var periodid = sign_up_success_param.periodid = $(this).parents("li").attr("periodid");//期次编号
			
			D.confirm_tz(integral,ticket);
			
			
		});
		
		//报名成功
		$("#toSignUp").bind("click",function(){
			//sign_up_success_param.pointRemain=g.integral;
			
			if(g.integral<bm_jf_jq.integral){
				$("#lack_of_balance").show();
				return;
			}
			
			
			$.ajax({
				url : '/grounder/takeinaccout.go',
				type : "POST",
				data:sign_up_success_param,
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==200){//处理成功
						alert(desc)
						$(".ceng").hide();
						$("#tz_confirm").hide();
					}else{
						alert(desc);
					}
				}
			})
		});
		
		
		$("#progress").delegate("li","click",function(){
			var mids = $(this).attr("mids");
			localStorage.setItem("mids", mids);
			window.location.href="cqdb.html";
		});
	};
	
	
	var all_match_zq_list={};//所以比赛对象
	
	var tree_game={};
	var zq_matchs={};
	//获取所有比赛列表
	var filter_game=function(){
		$.ajax({
			async:false,
			url:'/zqjc/matchs/mobile/matchs.xml?' + new Date().getTime(),
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
	    			
	    			if(mids && mids.indexOf(cur_match.mid)>-1){
	    				all_match_zq_list[cur_match.sid+"a"]=cur_match;
	    			}
	    			
				});
				alert(JSON.stringify(all_match_zq_list));
			},
		});
	};
	
	var load_game=function(){
		filter_game();
		var progressHTML="";
		
		
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
				
				var tmpHTML = "";
				if(code==17 ||code==5 ||code==13 ||code==14 ||code==15){
					tmpHTML =	'<span>'+timeStr+ stMap[code]+'</span><b>'+"--"+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>';
				}else if(code==8||code==11){
					tmpHTML =	'<span>'+stMap[code]+'</span><b>'+(hsc+':'+gsc)+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
				}else{
					tmpHTML =	'<span><i class="lqico"></i>'+(code==2?"中场":st)+'<em class="fen">′</em></span><b>'+hsc+':'+gsc+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
				}
				progressHTML += '<a href="/gq2/jczq.html?'+id+'" sid="'+sid+'">'
				progressHTML += '<u>'+ln+'</u>'
				progressHTML += '<p><cite><img src="/gq2/zqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
				progressHTML += '<p class="mid">'+tmpHTML+'</p>'
				progressHTML += '<p><cite><img src="/gq2/zqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
				progressHTML += '<div class="gz"><big></big></div>'
				progressHTML += '</a>'
			}
			
			$("#progress").html(progressHTML);
			
			//gain_z();//更新比分
		}
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
	
	var overing=function(){};
	
	
	
	
	
	
	
	var diffToString=function(num, iscn) {
		var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
		var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
		for (var i = 0, l = unit.length; i < l; i++) {
			date[i] = parseInt(num / unit[i]);
			cnDate[i] = date[i] + cn[i];
			num %= unit[i];
		}
		return iscn ? cnDate : date;
	}
	
	var eachClock=function(){
		this.now += g.fps;
		var diff = this.endtime_ - this.now;
		var msg = '';
		if(diff >= 0){
			timeout = diffToString(diff,false);
			//msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
			msg = '<i>'+timeout[1]+'</i><i>'+timeout[1]+'</i><i>'+CP.Util.pad(timeout[3],2)+'</i>';
			$("#t_").html(msg);
		}else{
			msg = '已截止';
			$("#t_").html(msg);
			
		}
	}
	
	 var expect_change = function(now, endtime){
		this.now = now.getTime();
		this.endtime_ = new Date(endtime.replace(/-/g , '/'));
		//this.atime_ = new Date(atime.replace(/-/g , '/'));
		clearInterval(this.timer);
		this.timer = setInterval(function(){
			eachClock();
		}, g.fps); 
		eachClock();
	}
	
	//报名参赛
	var entrants=function(){
		
	}
	
	return {
		init:init
	};
})();


$(function(){
	XHC.DB.init();
})

