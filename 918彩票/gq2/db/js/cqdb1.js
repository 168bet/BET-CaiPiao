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

var z_cyrs={};//足球参与人数对象

var XHC={};
XHC.DB=(function(){
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
	
	$(function(){
		people_num();
	});
	
	var obData = {};
	
	var init=function(){
		is_bm();
		phb();
		loadCont();
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
		
		/***
		//热门、完场、进行中(设置localStorage对象)
		$("#progress").delegate("a","click",function(event){
			event.preventDefault(); 
			var sid = $(this).attr("sid");
			localStorage.setItem("cur_match",JSON.stringify(all_match_zq_list[sid+"a"]));
			window.location.href="/gq2/db/jczq.html";
			return false;
		});
		***/
	};
	
	var all_match_zq_list={};//所以比赛对象
	var tree_game={};
	var zq_matchs={};
	
	
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
					
				if(mids.indexOf(mid)!=-1){
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
					
					html += '<a href="jclq.html?'+id+'" class="'+(isRank==1?"cur":"")+'" id="'+id+'">'
					html += '<u>'+ln+'</u>'
					html += '<p><cite><img src="/gq2/lqlogo/t_'+(gid?gid:"00000")+'.jpg"></cite><strong>'+gn+'</strong></p>'
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
					html += '<p><cite><img src="/gq2/lqlogo/t_'+(hid?hid:"00000")+'.jpg"></cite><strong>'+hn+'</strong></p>'
					html += '</a>';
				$("#progress").html(html);
				}
					//gain();
				}		
				}else{
					$("#progress").html(nodata);
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
				    		$("#progress a[id='"+t.id+"'] p:eq(1)").html(html);
						});
						
					}else{
						clearInterval(_timeId);//清楚定时器
					}
				}
			});
		},5000);
		return html;
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
							
							//var subt_sendticket=parseInt(tmp_data.sendticket.split(",")[i])*parseInt(tmp_data.currentnum)
							
							var c = i%2==0?"graybg":"";
							
							var e_c = "";
							if(i==0||i==1||i==2){
								e_c="cur";
							}
							
							phbHTML+='<ul class="'+c+'">';
							phbHTML+='<li><em class="'+e_c+'">'+(i+1)+'</em></li>';
							
							phbHTML+='<li>'+cnickid+'</li>';
							phbHTML+='<li>'+chipnum+'</li>';
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
		});
	}; 
	
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

