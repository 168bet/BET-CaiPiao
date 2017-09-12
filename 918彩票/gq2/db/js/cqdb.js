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
var tmp_data = JSON.parse(localStorage.getItem("tmp_data"));
sign_up_success_param.periodid=tmp_data.periodid;
var _timeId_z,_timeId,_timeId_gz;
var stMap={'17':'开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'};	
var z_cyrs={};//足球参与人数对象

var XHC={};
XHC.DB=(function(){
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
	
	$(function(){
		get_people();
	});
	
	var init=function(){
		is_bm();
		phb();
		load_game();
		bindEvent();
	};
	
	var bindEvent=function(){
		//导航切换
		$("#qh span").bind("click",function(){
			var index = $(this).index();
			
			$(this).addClass("cur").siblings().removeClass("cur");
			
			if(index==0){
				$("#cont_z").show();
				$("#phb_list").hide();
			}else{
				$("#cont_z").hide();
				$("#phb_list").show();
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
		
		//报名成功
		$("#toSignUp").bind("click",function(){
			if(sign_up_success_param.stype==1){//积分
				if(parseInt(g.integral)<parseInt(bm_jf_jq.integral)){
					$("#lack_of_balance").show();
					return;
				}
			}
			bm_success();
		});
		
		//参与报名
		$(".cs_btn").bind("click",function(){
			var integral = bm_jf_jq.integral=tmp_data.integral ;//积分
			var ticket =bm_jf_jq.award= tmp_data.award;//奖券
			D.confirm_tz(integral,ticket);
		});
		
		//热门、完场、进行中(设置localStorage对象)
		$("#progress").delegate("a","click",function(event){
			event.preventDefault(); 
			var sid = $(this).attr("sid");
			localStorage.setItem("cur_match",JSON.stringify(all_match_zq_list[sid+"a"]));
			window.location.href="/gq2/db/jczq.html";
			return false;
		});
	};
	
	var all_match_zq_list={};//所以比赛对象
	var tree_game={};
	var zq_matchs={};
	//获取所有比赛列表
	var filter_game=function(){
		$.ajax({
			async:false,
			url:'/zqjc/matchs/mobile/compets.xml?' + new Date().getTime(),
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
	    			
	    			if(mids && cur_match.mid!=0 &&mids.indexOf(cur_match.sid)!=-1){
	    				all_match_zq_list[cur_match.sid+"a"]=cur_match;
	    			}
	    			
				});
				console.log(JSON.stringify(all_match_zq_list));
			},
		});
	};
	
	var load_game=function(){
		filter_game();
		var progressHTML="";
		if(!all_match_zq_list){
			$("#progress").html("暂无数据");
			return;
		}
		if(all_match_zq_list && all_match_zq_list != null){
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
				}else if(code==4){//完场
					tmpHTML =	'<span>'+stMap[code]+'</span><b>'+hsc+':'+gsc+'</b><span class="pater">'+(z_cyrs[sid]?z_cyrs[sid]:"0")+'人已参与</span>'
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
						clearInterval(_timeId_z);//清除定时器
					}
				}
			});
		},5000);
	};
	
	//排行榜
	var phb=function(){
		var phbHTML="";
		$.ajax({
			url : '/grounder/takeinaccout.go?flag=4&periodid='+tmp_data.periodid,
			type : "POST",
			dataType : "xml",
			success : function(xml) {
				var R=$(xml).find("Resp");
				var code=R.attr("code");
				var desc=R.attr("desc");
				var chipnum=R.attr("chipnum");//当前登录用户的剩余筹码
				var supranking=R.attr("ranking");//当前登录用户的名次
				
				
				if(code==0){
					var r=R.find("row");
					
					if(r.length){
						r.each(function(i){
							var cnickid=$(this).attr("cnickid");
							var periodid=$(this).attr("periodid");
							var chipnum=$(this).attr("chipnum");
							var quiznum=$(this).attr("quiznum");
							var hitnum=$(this).attr("hitnum");
							var tzmoney=$(this).attr("tzmoney");
							var bonus=$(this).attr("bonus");
							var profmoney=$(this).attr("profmoney");
							var ranking=$(this).attr("ranking");
							var rewardticket=$(this).attr("rewardticket");
							var jctime=$(this).attr("jctime");
							var ispj=$(this).attr("ispj");
							
							var c = i%2==0?"graybg":"";
							var e_c = "";
							if(i==0||i==1||i==2){
								e_c="cur";
							}
							
							phbHTML+='<ul class="'+c+'">';
							phbHTML+='<li><em class="'+e_c+'">'+(i+1)+'</em></li>';
							
							phbHTML+='<li>'+cnickid+'</li>';
							phbHTML+='<li>'+chipnum+'</li>';
							
									
							//var subt_sendticket=parseInt(tmp_data.sendticket.split(",")[i])*parseInt(tmp_data.currentnum)
							
							phbHTML+='<li>'+(rewardticket=="0"?"--":rewardticket)+'</li>';
							phbHTML+='</ul>';
						});
						$("#z_list").html(phbHTML);
					}else{
						$("#z_list").html("暂无数据");
					}
				}else{
					$("#ul_header").hide();
					$("#z_list").html("暂无数据");
				}
			}
		})
	}
	
	//报名成功所需参数
	var is_bm_param={
			  flag:1,//操作标识，用来判断查询的逻辑，1表示查询用户是否报名过此期次，2表示进行报名操作 
			  cnickid:username,//当前登录用户名
			  periodid:tmp_data.periodid,//当前的期次号
			  visit:3500//主要验证visit(来源)字段
	};
	
	
	var is_bm=function(){
		$.ajax({
			url : '/grounder/takeinaccout.go',
			type : "POST",
			data:is_bm_param,
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==3){//处理成功
					$(".cs_btn").hide();
				}else{
					$(".cs_btn").show();
				}
			}
		});
	}

	return {
		init:init
	};
})();

$(function(){
	XHC.DB.init();
})

