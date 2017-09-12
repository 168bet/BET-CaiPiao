
/**
 * 滚球游戏
 * Author : weige
 * Date : 2015-3-16
 * ***********************************/
/**
 * 定义全局事件
 */
var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var end_ev = ('ontouchend' in window ) ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';


var Wei = {};//无耻的用下自己的名字(*^__^*)
/**
 * @description 获取数据类型
 * @return {String} 如：null
 */
Wei.getType = function (o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
};
/*
 * 触屏版touch插件
 * @param {Object} [children:".ball",fun:function(){}];
 $("body").Touch(function(){
 $('#lot_title').html('你好')
 })
 */
$.fn.Touch = function (obj) {
	var moveEvent = move_ev;
	if (Wei.getType(obj) == 'function') {
		obj.fun = obj;
	}

	this.each(function () {
		var $dom = $(this).eq(0);//转为dom对象
		var ifMove = false;
		var t = 0;
		$dom.on(moveEvent, function () {
			ifMove = true;
			clearTimeout(t);
			t = setTimeout(function () {
				ifMove = false;
			}, 250);
		});
		if (obj.children) {
			$dom.on(end_ev, obj.children, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return false;
				}
				obj.fun.call(this, this);
			});
		}
		else {
			$dom.on(end_ev, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return 0;
				}
				obj.fun.apply(this, [this, e]);
			});
		}
	});
};
/***
//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 1e3);
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
***/
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
var m = d.getMonth+1
var m1 = d.getMonth+1
m1=m1<10?"0"+m1:m1;
var day =d.getDate();
day=day<10?"0"+day:day;
var P = y+""+m+""+day;
var P1 = y+""+m1+""+day;


//-----------------初始化绑定事件---------------------
Wei.load = (function(){
	var MID=""
	var socket = io.connect('210.14.67.5:8185');
	//var item = location.search.getParam("item");
	//socket.emit('changeMid',MID);//64991
	var noGame  = '<div style="text-align: center; padding: 50px;">暂无比赛</div>';
	var zbTime,tjTime;
	var o = {//公用的对象
			_tab : $('.tab'),//tab切换层
			_ct : $('#content'),//中间内容层
			_act0 : $('#studio'),//直播
			_act1 : $('#statistics'),//统计
			_act2 : $('#quiz'),//竞猜
			mtype:'4',//终端类型
			appversion:'',//客户端版本号
			cperiodid:'',//期次编号emit方法中的第二个参数
			mid:"",
			z : '勇士',//主队
			k : '快船',//客队
			gr: '',
			hr: '',
			node : function(){
				socket.on('loadMatch', function(arr){//拉取单场全部赔率(主队请求)
					quiz.render(arr);
				});
				socket.on('changeNode', function(data){//有变化的单节赔率(被动推送)
					var data = data;
					changeText(data);
				});
				socket.on('stopNode', function(data){//单节有截止的赔率(被动推送)
					var data = data;
				});
				socket.on('startNode', function(data){//单节开始的赔率(被动推送)
					var data = data;
				});
				socket.on('resultNode', function(data){//单节赛果(被动推送)
					var data = data;
				});

			    }
	};
	
	var st={
	    '0': '开赛',
	    '13': '第一节',
	    '14': '第二节',
	    '15': '第三节',
	    '16': '第四节',
	    '20': '进行中',
	    '30': '暂停',
	    '31': '第一节结束',
	    '32': '中场',
	    '33': '第三节结束',
	    '34': '加时',
	    '40': '加时',
	    '60': '延期',
	    '90': '弃赛',
	    '100': '完场',
	    '110': '完场'
	};
	var acc_info={
			golden:0,//金豆
			integral:0//积分
	};
	
	
	//投注所需要的参数对象
	var dodata={
			mtype:o.mtype,//终端类型 no
			appversion:o.appversion,//客户端版本号，触屏可为空
			ccodes:"",//投注内容
			code:"",
			cperiodid:65885,//期次编号
			cquizname:"",//竞猜名称
			itmoney:10,//投注金额
			od_remark:[],//投注描述
			oddsid:"",//盘口赔率表id
			opt:"",
			sp:"",
			name:"",
			section:5,//投注节数 第1，2，3，4节，或5-全场
			type:2,//玩法让分 1，总分 2，奇偶 3
			hTName:"",//主队名
			vTName:""//客队名称
	};
	var _info={
			getGodlenIntegral:function(){
				$.ajax({
					url:"http://t2014.9188.com  /grounder/goldenbeanaccount.go?flag=0&qtype=3",
					dataType:'xml',
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code==0){
							var row = R.find("row");
							var balance = row.attr("balance");//账户余额
							var daward = row.attr("daward");//当日盈利
							var taward = row.attr("taward");//总盈利
							var dpm = row.attr("dpm");//当日排名
							var tpm = row.attr("tpm");//总排行
							var isqd = row.attr("isqd");//是否签到
							var point = row.attr("point");//是否签到
							acc_info.golden=balance;
							acc_info.integral=point;
							$("#jdyue").html(balance);
						}else{
							alert(desc);
						}
					}
				});
			}
	}
	
	//加载头部下拉列表内容
	var loadHead=function(){
		var tmpArr=[];
		var ob
		var listHTML = "";
		var d1 = new Date();
		var y1 = d1.getFullYear();
		var m1 = d1.getMonth()+1
		m1=m1<10?"0"+m1:m1;
		var day1 =d1.getDate();
		day1=day1<10?"0"+day1:day1;
		var P1 = y1+""+m1+""+day1;
		var sTime
		$.ajax({
			url:"/nbajc/matchs/"+P1+"/allmatches.json?"+Math.random(),
			dataType:'JSON',
			cache:true,
			success:function(data){
				for(var i=0;i<data.length;i++){
					var gid = data[i]["gid"];
					var hid = data[i]["gid"];
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
					
					var mtime = data[i]["mtime"];//开赛时间
					var t = new Date(mtime);
					var d = t.getDate();
					var H = t.getHours();
					var M = t.getMinutes();
					M=M<10?"0"+M:M
					var timeStr = d+"日"+" "+H+":"+M;
					var statusCode = data[i]["statusCode"];//比赛的状态码
					var statusName = data[i]["statusName"];//比赛的状态
					if(statusCode==0 || statusCode==60 || statusCode==90|| statusCode==100 || statusCode==110){
						listHTML+='<p hn="'+hn+'" gn="'+gn+'" gr="'+gr+'" mid="'+mid+'" zid="'+id+'"><span>'+timeStr+' '+gn+' <em>vs</em> '+hn+'</span><cite>'+st[statusCode]+'</cite></p>'
					}else{//进行
						listHTML+='<p hn="'+hn+'" gn="'+gn+'" hr="'+hr+'" mid="'+mid+'" zid="'+id+'"><span>'+timeStr+' '+gn+' <em class="red">'+gsc+':'+hsc+'</em> '+hn+'</span><cite class="red">'+st[statusCode]+'</cite></p>'
						//tmpArr.push(data[i]);
					}
				}
				
					ob = data[0];
					var gn = ob["gn"];
					var hn = ob["hn"];
					var gr = ob["gr"];//客队排名
					var hr = ob["hr"];//主队排名
					var id = ob["id"];//资料库id
					var mid = ob["mid"];//主站赛事id
					var gid = ob["gid"];
					$(".hmHeader").html("<h1>"+gn+"vs"+hn+"</h1>")
					o.z=hn;
					o.k=gn;
					o.gr=gr;
					o.hr=hr;
					socket.emit('changeMid',mid);//64991
					changeHead(id);//改变比分
					studio.gain(id);//直播
					quiz.load_bf(id);//竞猜信息
					statistics.gain(id);//数据统计
				
				$("#listcont").html(listHTML);
			}
		})
	};
	
	
	//*********竞猜************
	var quiz = {
			//渲染竞彩页面
			render : function(arr){
				if(arr && arr.length){//不为空
					
					var ks = [], ts = [];
					ks.push('<article id="options">');
					ts.push('<article>');
					for(var s in arr){
						var obj_ = arr[s];
						
						var color = obj_.color;//盘口颜色
						var gro = obj_.gro;//客队让分赔率
						var gzo = obj_.gzo;//客队总分赔率
						var hro = obj_.hro;//主队让分赔率
						var hzo = obj_.hzo;//主队总分赔率
						var id1 = obj_.id1;//让分，基数赔率id
						var id2 = obj_.id2;//大小赔率id
						var mid = obj_.mid;//比赛id
						var node = obj_.node;//当前节 5：全场
						var playName = obj_.playName;//第几节
						var rf = obj_.rf;//盘口
						var status = obj_.status;//当前是否可以购买
						var type = obj_.type;//2 当前节截止（1-让分[奇偶] 2-大小分）
						var zf = obj_.zf;//大小分
						
//						var vtScore = obj_.vtScore;//客队比分
//						var htScore = obj_.htScore;//主队比分
						
//						var result1 = obj_.result1;//让分赛果 3 0
//						var result2 = obj_.result2;//大小
//						var result3 = obj_.result3;//奇偶
//						var curRst = obj_.curRst;//当前开的赛果类型1 2 3
						
						
//						0 0 没开始卖 1 0 全部开卖 1 1 截止了让分、奇偶 1 2 截止了大小 0 2、0 1 全部截止
						var jie = '';
						if(node == 5){
							jie = '全场';
						}else{
							jie = '【第<em>'+node+'</em>节】';
						}
						if(status == 0){//全部截止
							if(type == 0){//未开售
								
								
							}else{
								ts.unshift('<article class="'+( node != 5 && 'mgbd' )+'">\
										<ul class="long">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li><div class="spfzpk"><span>两队总分之和</span><cite class="red">xx</cite></div><i></i></li>\
					        		</ul>\
										<ul class="long">\
					            		<li>'+jie+'<cite>让分胜负</cite></li>\
					                    <li><div class="spfzpk"><span>'+o.k+'vs'+o.z+'</span><cite class="red">xx</cite></div><i></i></li>\
					        		</ul>\
					        		<ul class="long">\
				            		<li>'+jie+'<cite>总分奇偶</cite></li>\
				                    <li><div class="spfzpk"><span>两队总分奇偶</span><cite class="red">xx</cite></div><i></i></li>\
				        		</ul>\
					            		</article>');
							}						
						}else if(status == 1){//有开售的
							if(type == 0){// 全开售
								ks.push('<article class="'+( node != 5 && 'mgbd' )+'">\
										<ul  node="'+node+'" oddsid="'+id2+'" code="'+zf+'" typename="2">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li  opt="3" class="spfzpk"><span>总分&gt;<em class="zf">'+zf+'</em></span><cite>'+gzo+'</cite></li>\
					                    <li  opt="0" class="spfzpk"><span>总分&lt;<em class="zf">'+zf+'</em></span><cite>'+hzo+'</cite></li>\
					        		</ul>\
						            	<ul  node="'+node+'" oddsid="'+id1+'" code="'+rf+'" typename="1">\
						            		<li>'+jie+'<cite>让分胜负</cite></li>\
						                    <li opt="0" class="spfzpk"><span>'+o.k+'</span><cite>胜'+gro+'</cite></li>\
						                    <li opt="3" class="spfzpk"><span>'+o.z+'<em class="'+color+' rf">('+rf+')</em></span><cite>胜'+hro+'</cite></li>\
						        		</ul>\
						                <ul  node="'+node+'" oddsid="'+id2+'" code="'+zf+'" typename="3">\
						            		<li>'+jie+'<cite>总分奇偶</cite></li>\
						                    <li opt="3" class="spfzpk"><span>奇数</span><cite><em >1.80</em></cite></li>\
						                    <li opt="0" class="spfzpk"><span>偶数</span><cite><em>1.80</em></cite></li>\
						        		</ul>\
						              </article>');
							}else if(type == 1){//截止了让分、奇偶
								ks.push('<article class="'+( node != 5 && 'mgbd' )+'">\
										<ul node="'+node+'" oddsid="'+id1+'" code="'+zf+'" typename="2">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li opt="3" class="spfzpk"><span>总分&gt;<em class="zf">'+zf+'</em></span><cite>'+gzo+'</cite></li>\
					                    <li opt="0" class="spfzpk"><span>总分&lt;<em class="zf">'+zf+'</em></span><cite>'+hzo+'</cite></li>\
					            		</ul>\
						              </article>');
								ts.unshift('<article class="mgbd">\
										<ul class="long">\
					            		<li>'+jie+'<cite>让分胜负</cite></li>\
					                    <li><div class="spfzpk"><span>'+o.k+'vs'+o.z+'</span><cite class="red">xx</cite></div><i></i></li>\
					        		</ul>\
					                    <ul class="long">\
					            		<li>'+jie+'<cite>总分奇偶</cite></li>\
					                    <li><div class="spfzpk"><span>两队总分奇偶</span><cite class="red">xx</cite></div><i></i></li>\
					        		</ul>\
						                </article>');
							}else if(type == 2){//截止了大小
								ks.push('<article class="mgbd">\
										<ul  node="'+node+'" oddsid="'+id2+'" code="'+zf+'" typename="1">\
					            		<li>'+jie+'<cite>让分胜负</cite></li>\
					                    <li opt="0" class="spfzpk"><span>'+o.k+'</span><cite>胜'+gro+'</cite></li>\
					                    <li opt="3" class="spfzpk"><span>'+o.z+'<em class="'+color+' rf">('+rf+')</em></span><cite>胜 '+hro+'</cite></li>\
					            		</ul>\
						                <ul node="'+node+'" oddsid="'+id2+'" code="'+zf+'" typename="3">\
						            		<li>'+jie+'<cite>总分奇偶</cite></li>\
						                    <li opt="3" class="spfzpk"><span>奇数</span><cite>1.80</cite></li>\
						                    <li opt="0" class="spfzpk"><span>偶数</span><cite>1.80</cite></li>\
						        		</ul>\
						              </article>');
								ts.unshift('<article class="mgbd">\
										<ul class="long">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li><div class="spfzpk"><span>两队总分之和</span><cite class="red">xx</cite></div><i></i></li>\
					            		</ul>\
					            		</article>');
							}
						}
					}
					ks.push('</article>');
					ts.push('</article>');
					var html = ks.join('')+'<p class="mgbd pdbt095">已截止的竞猜</p>'+ts.join('');
					$('#odds').html(html);
					
					$("#options").delegate("ul li.spfzpk","click",function(){
						dodata.node=$(this).parent("ul").attr("node");
						dodata.code=$(this).parent("ul").attr("code");
						dodata.oddsid=$(this).parent("ul").attr("oddsid");
						dodata.typename=$(this).parent("ul").attr("typename");
					
						return;
						var opt = dodata.opt = $(this).attr("opt");
						var code = $(this).parent("ul").attr("code");
						
						
						var sptxt = $(this).find("cite").text();
						if(sptxt.indexOf("胜")!=-1){
							sptxt=sptxt.substring(1);
						}
						dodata.sp = sptxt;
						dodata.name = $(this).prev().text();
						
						var type = $(this).parent().attr("typename");
						
						if(type == 1){
							dodata.od_remark.push(o.z);
							dodata.od_remark.push('(');
							dodata.od_remark.push(code);
							dodata.od_remark.push(')');
							if(opt == 3){
								dodata.od_remark.push('胜');
							}else{
								dodata.od_remark.push('负');
							}
						}else if(type == 2){
							if(opt == 3){
								dodata.od_remark.push('大分');
							}else{
								dodata.od_remark.push('小分');
							}
							dodata.od_remark.push('(');
							dodata.od_remark.push(code);
							dodata.od_remark.push(')');
						}else{
							if(opt == 3){
								dodata.od_remark.push('奇数');
							}else{
								dodata.od_remark.push('偶数');
							}
						}
						dodata.od_remark = dodata.od_remark.join('');
						
						dodata.oddsid=$(this).parent().attr("oddsid");
						dodata.section=$(this).parent().attr("node");
						dodata.type=$(this).parent().attr("typename");
						
						quiz.tc($(this))
						var bsid = $(this).parent("ul").attr("bsid");
						var js = $(this).prev().find("em").html();
						$("#pkCont").attr("bsid",bsid);
						$("#pkCont").attr("js",js);
						$("#pop").show();
						$("#zhezhao").show();
						});
				}else{
					alert('error');
				}
			},
			/***
			 * 未完成,需要及时调用的
			 */
			//比分变化
			load_bf:function(item){
				$.ajax({
					url:'/nbajc/matchs/'+P+'/'+item+'.json',
					type:'get',
					dataType:"json",
					success: function(data){
						$("#jcbf li:eq(1) span").html(data["gn"]);
						$("#jcbf li:eq(1) cite:eq(0)").html(data["g1"])
						$("#jcbf li:eq(1) cite:eq(1)").html(data["g2"])
						$("#jcbf li:eq(1) cite:eq(2)").html(data["g3"])
						$("#jcbf li:eq(1) cite:eq(3)").html(data["g4"])
						
						$("#jcbf li:eq(2) span").html(data["hn"]);
						$("#jcbf li:eq(2) cite:eq(0)").html(data["h1"])
						$("#jcbf li:eq(2) cite:eq(1)").html(data["h2"])
						$("#jcbf li:eq(2) cite:eq(2)").html(data["h3"])
						$("#jcbf li:eq(2) cite:eq(3)").html(data["h4"])
						
						
						$(".dzqd ul li:eq(0)").html('<p><img src="img/ico.png"></p><span><strong>'+data["gn"]+'</strong>['+data["gr"]+']</span>')
						$(".dzqd ul li:eq(1)").html('<span>'+st[data["statusCode"]]+'  '+data["time"]+'</span><b>'+data["gsc"]+':'+data["hsc"]+'</b>')
						$(".dzqd ul li:eq(2)").html('<p><img src="img/ico.png"></p><span><strong>'+data["hn"]+'</strong>['+data["hr"]+']</span>');
					}
				})
			},
			
			//选好比赛以后的弹层
			tc:function(obj){
				var wfhtml = $(obj).html();//玩法内容
				//var plhtml = $(obj).html();//赔率内容
				
				$("#pkCont").html(''+wfhtml);
				//$("#pkCont cite").html(' <em class="">'+plhtml+'</em>');
			},
			//确认竞猜
			confirmQuiz:function(){
				dodata.ccodes= dodata.opt+"|"+dodata.code+"|"+dodata.sp;
				dodata.cquizname = o.z+dodata.name;
				
				var data={
						mtype:o.mtype,//终端类型 no
						appversion:"",//客户端版本号，触屏可为空
						ccodes:dodata.ccodes,//投注内容
						cperiodid:65490,//期次编号
						cquizname:dodata.cquizname,//竞猜名称
						itmoney:10,//投注金额
						od_remark:dodata.od_remark,//投注描述
						oddsid:dodata.oddsid,//盘口赔率表id
						section:dodata.section,//投注节数 第1，2，3，4节，或5-全场
						type:dodata.typename,//玩法让分 1，总分 2，奇偶 3
						hTName:o.z,//主队名
						vTName:o.k//客队名称
				};
				$.ajax({
					url:"/grounder/buyviagoldenbean.go",
					dataType:'xml',
					data:data,
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code==0){//投注成功
							alert("成功")
						}else{
							alert(desc);
						}
					}
				});
			},
			single_section:function(item){//单节有截止的赔率
				
			}
			
	};
	
	//改变头部比分信息
	var changeHead=function(item){
		window.timeId=setInterval(function(){
			$.ajax({
				url:"/nbajc/matchs/change.xml?"+Math.random(),
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Rows");
					var code = R.attr("code");
					var desc = R.attr("desc");
					var row = R.find("row")
					row.each(function(){
						var id = $(this).attr('id');
			    		var mid = $(this).attr('mid');
			    		var code = $(this).attr('code');
			    		var hs = $(this).attr('hs');
			    		var gs = $(this).attr('gs');
			    		var hsc = $(this).attr('hsc');
			    		var gsc = $(this).attr('gsc');
			    		var time = $(this).attr('time');
			    		if(item==id){//改变当前比赛的比分
			    			
			    			$(".dzqd ul li:eq(0)").find("span").html('<strong>'+o.k+'</strong>['+o.gr+']')
			    			$(".dzqd ul li:eq(1)").html('<span>'+st[code]+'  '+time+'</span><b>'+gsc+':'+hsc+'</b></li>');
			    			$(".dzqd ul li:eq(2)").find("span").html('<strong>'+o.z+'</strong>['+o.hr+']')
			    		}
					})
			    		
			    		//changeBfStyle(row,oldData);  //改变比赛状态
			    		//allMatches[row.id] = oldData;
				}
			});
		},5000)
	}
	
	var changeText=function(data){
		$('#options ul[node="'+data.node+'"] .zf').text(data.zf);
		$('#option ul[node="'+data.node+'"] .rf').text("("+data.rf+")");
		$('#option ul[node="'+data.node+'"] .rf').removeClass('red green').addClass(data.color);
		$('#option>ul[node="'+data.node+'"][typename="2"]').attr('code', data.zf);//总分
		$('#option>ul[node="'+data.node+'"][typename="1"]').attr('code', data.rf);//让分
		$('#option>ul[node="'+data.node+'"][typename="2"]').attr('oddsid', data.id2);
		$('#option>ul[node="'+data.node+'"][typename="1"]').attr('oddsid', data.id1);
		$('#option>ul[node="'+data.node+'"][typename="3"]').attr('oddsid', data.id1);//奇偶
		$('#option>ul[node="'+data.node+'"][typename="2"] em:eq(0)').text(data.gzo);
		$('#option>ul[node="'+data.node+'"][typename="2"] em:eq(1)').text(data.hzo);
		$('#option>ul[node="'+data.node+'"][typename="1"] em:eq(0)').text(data.gro);
		$('#option>ul[node="'+data.node+'"][typename="1"] em:eq(1)').text(data.hro);
	}
	//********直播***********
	var studio = {
			zb_index : 0,//当前直播行数下标
			//*******获取信息**********
			gain : function(item){
				$.ajax({
					url:'/nbajc/live/'+item+'.txt',
					type:'get',
					success: function(txt){
						var zb = txt.split('$');
						$('.zbj').html('');
						$('.spinner3').hide();
						var zb_length = zb.length;
						if(zb_length>0 && zb){
							$.each(zb, function(index, val){
								var info_txt = val.split('!');
								studio.render(info_txt);
							});
							//*********
							//及时调用方法(实时改变直播数据的方法)
							//zbTime = setInterval(studio.change, 5e3);
							//tjTime = setInterval(statistics.gain, 30e3);
						}else{
							$('.zbj').html(noGame);
						}
					},error:function(){
						//alert('网络异常，请刷新页面');
					}
				});
			},
			//渲染直播dom
			render:function(txt,cg){
				zb_index = cg && zb_index || txt.length-2;
				for(var i=0,l=txt.length; i<l; i++){
					var txt_ = txt[i];
					if(txt_){
						var c = txt_.split('^');
						/**
						 * c
						 * 0 时间 1 主/客 2 比分 3 比分 4 文字直播 5  6 下标 
						 * */
						var c1 = {'1':'主','2':'客'}[c[1]] || '';
						if((cg && c[6] > zb_index) || (!cg && c[0])){
							var _out = [];
							_out.push('<li>');
							_out.push('<cite>'+c[0].substr(0,5)+'</cite>');
							_out.push('<em>'+c1+'</em><span>'+c[4]+'<label style="color:blue">('+c[2]+':'+c[3]+')</label></span>');
							_out.push('</li>');
							$('.zbj').prepend(_out.join(''));
							if(cg && c[6] > zb_index){
								zb_index++;
							}
						}
						studio.suona(c[4]);
					}
				}
			},
			change : function(){
				$.ajax({
					url: '/nbajc/live/'+item+'Cg.txt',
					success:function(txt){
						studio.render(txt.split('!'), true);
					}
				});
			},
			suona : function(txt_){
				
				
			}
	};
	//**********统计球员信息***********
	var statistics = {
			//获取信息内容
			gain : function(item){
				$.ajax({
					url:'/nbajc/tech/'+'js_'+item+'.txt',
					type:'get',
					success: function(txt){
						var txt_ = txt;
						var tj = txt_.split('$');
						$('#teamMember').html('');
						if(tj.length>0 && tj){
							statistics.render(tj);
						}else{
							$('#teamMember').html(noGame);
						}
					},error:function(){
						//alert('网络异常，请刷新页面');
					}
				});
			},
			/**
			 * 渲染  队员数据
			 * @param txt
			 * txt 是个数组
			 * txt[0] 直接无视
			 * txt[1] 主 - 队员
			 * txt[2] 客 - 队员
			 * **********************************/
			render : function(txt){
				$.each(txt,function(i, v){
					var _out = [];
					if(i != 0){
						var v1 = v.split('!');
						
						var dy = '';//队员
						var dysj = '';//队员的数据
						var html_ = '';
						
						html = '<article class="touch clearfix">\
				            	<cite class="left">'+(i==1 && o.z ||o.k)+'</cite>\
					            </article>\
					            <div class="clearfix">';
						dy = '<ul class="sjtjqy"><li>球员</li>';
						dysj = '<article class="qytext wscroll"><ul class="clearfix">';
						dysj += '<li><cite>得分</cite><cite>篮板</cite><cite>助攻</cite><cite>抢断</cite><cite>盖帽</cite><cite>时间</cite><cite>失误</cite><cite>犯规</cite><cite>投篮</cite><cite>3分</cite><cite>罚球</cite><cite>前场板</cite><cite>后场板</cite></li>';
						for(var s=0,m=v1.length; s<m-2; s++){
							var txt_ = v1[s];
							var t = txt_.split('^');
							/**
							 * @param t
							 * 0 1 队员名 2 3 4 5 位置 6 时间 7 投篮 8 投篮 9 3分 10 3分 11 罚球 12 罚球 13 篮板-进攻 
							 * 14 篮板-防守 15 篮板-总 16 助攻 17 犯规 18 抢断 19 失误 20 盖帽 21 得分
							 * */
							if(t[5] != '?' && t[5] != 0){
								dy += '<li>'+t[1]+'</li>';
							}else{
								dy += '<li class="gray">'+t[1]+'</li>';
							}
							dysj += '<li><cite>'+t[21]+'</cite><cite>'+t[15]+'</cite><cite>'+t[16]+'</cite><cite>'+t[18]+'</cite><cite>'+t[20]+'</cite><cite>'+t[6]+'</cite><cite>'+t[19]+'</cite><cite>'+t[17]+'</cite><cite>'+t[7]+'/'+t[8]+'</cite><cite>'+t[9]+'/'+t[10]+'</cite><cite>'+t[11]+'/'+t[12]+'</cite><cite>'+t[13]+'</cite><cite>'+t[14]+'</cite></li>';
						}
						dy += '</ul>';
						dysj += '</ul></article>';
						
						html = html + dy + dysj;
						html += '</div>';
						
						$('#teamMember').prepend(html);
					}
				});
			},
			
			/***
			 * autor:ahu
			 */
			//及时改变球员数据的方法
			change:function(){
				$.ajax({
					url: '/nbajc/live/'+item+'Cg.txt',
					success:function(txt){
						statistics.render(txt.split('!'), true);
					}
				});
			}
	};
	
	
	var init = function(){
		loadHead();
		_info.getGodlenIntegral();
		quiz.load_bf();
		studio.gain();//初始化直播
		statistics.gain();//初始化统计
		o.node();
		bind();
	};
	
	var bind = function(){
		o._tab.Touch({children:'li',fun:function(el){
			if($(el).hasClass('cur')){
				return;
			}
			$(el).addClass('cur').siblings().removeClass('cur');
			var act = [o._act0, o._act1, o._act2];
			for(var s in act){
				act[s].hide();
			}
			act[$(el).index()].show();
		}});
		

		$('.pullIco').bind('click', function(){
			$('.pullDown').toggleClass('pullHover');
			$('.pullText').toggle();
		});
		//关闭购买层
		$("#close").bind("click",function(){
			$("#pop").hide();
			$("#zhezhao").hide();
		});
		
		//积分切换
		$("#tzCont ul li").bind("click",function(){
			var v = $(this).html();
			v=v=="全压"?$("#jdyue").html():v;
			$(this).addClass("cur").siblings().removeClass("cur")
			$("#in_golden").val(v);
		});
		
		//返还值
		$("#in_golden").keyup(function(){
			alert(1)
		})
		
		//确认竞猜
		$(".ture").bind("click",function(){
			quiz.confirmQuiz();
		});
		
		//头部下拉列表
		$(".hmHeader").delegate("h1","click",function(){
			$("#listcont").toggle();
		});
		
		$("#listcont").delegate("p","click",function(){
			$("#listcont").hide();
			
			var hn = $(this).attr("hn");
			var gn = $(this).attr("gn");
			var gr = $(this).attr("gr");
			var hr = $(this).attr("hr");
			var mid = $(this).attr("mid");
			var zid = $(this).attr("zid");
			o.z=hn
			o.k=gn
			o.gr=gr
			o.hr=hr
			socket.emit('changeMid',mid);//64991
			studio.gain(zid);//直播
			quiz.load_bf(zid);//竞猜信息
			statistics.gain(zid);//数据统计
			changeHead(zid)
		});
	};
	init();
})();


