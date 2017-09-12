var HC={};
var CP={};

var hasTouch = 'ontouchstart' in window;
var start_ev = hasTouch ? 'touchstart' : 'mousedown';
var end_ev = hasTouch ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';

CP.getType = function (o) {
	var _t;
	return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
};
$.fn.Touch = function (obj) {
	var moveEvent = move_ev;
	if (CP.getType(obj) == 'function') {
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
				ifMove = false
			}, 250);
		})
		if (obj.children) {
			$dom.on(end_ev, obj.children, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return false;
				}
				obj.fun.call(this, this);
			})
		}
		else {
			$dom.on(end_ev, function (e) {
				if (ifMove && end_ev == 'touchend') {
					ifMove = false;
					e.stopPropagation();
					return 0;
				}
				obj.fun.apply(this, [this, e]);
			})
		}
	});
};


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

HC.gq=(function(){
	var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
	var d = new Date();
	var y = d.getFullYear();
	var m1 = d.getMonth()+1;
	m1=m1<10?"0"+m1:m1;
	var day =d.getDate();
	day=day<10?"0"+day:day;
	var P1 = y+""+m1+""+day;
	var game_info = {
			hn:'',//主
			gn:'',
			mid:'',
			id:''
			
	};
	var zb_index = 0;
	var url = window.location.href;
	var it = "";
	
	
	var init=function(){
		var myDate = new Date();
		//var today = myDate.toLocaleDateString();
		var DataTime = myDate.getFullYear();
		//today = today.split("/")[1]+today.split("/")[2];
		$("#suona span").each(function(i){
			var miao = 3600 * 48 * 1000;
			var span = new Date(DataTime + '-' + $(this).html());
			if((myDate - span) > miao){
				$(this).parent().parent().remove();
			}
			if($("#suona li").length < 1){
				$(".public").hide();
			}
		});
		if($("#suona li").length < 1){
			$(".public").hide();
		}else{
			$(".public").show();
		}
		if($("#suona li").length > 1){
			gundong();
		}
   // 	$("#gonggao").find('span').hide();
		
		if(CP.MobileVer.android){//android
			try {
				dodata.mtype=1;
			} catch (e){
				
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			try {
				dodata.mtype=2;
			} catch (e){
				
			}
		}else if(CP.MobileVer.wp){//ios
			try {
				dodata.mtype=3;
			} catch (e){
				
			}
		}else{//4g
			dodata.mtype=4;
		}
		//比分直播
		if(url.indexOf("#")!=-1){
			it=url.split("#")[1];
			if(it){
				P_fn.load_nav_info(it);
			}else{
				P_fn.load_nav_info();
			}
		}else{
			P_fn.load_nav_info();
		}
		//P_fn.load_nav_info();
		bindEvent();
		//studio.gain();
	};
	
	var socket = io.connect('192.168.1.240:8185');//210.14.67.5:8185  192.168.1.240:8185
	var o = {//公用的对象
		node : function(){
			socket.on('loadMatch', function(arr){//拉取单场全部赔率(主队请求)
				quiz.render(arr);
			});
			socket.on('changeNode', function(data){//有变化的单节赔率(被动推送)
				if(data.mid == game_info.mid){
					//console.log('data:' + data.node +'-'+data.gzo+'-'+data.hzo);
					changeText(data);
				}
			});
			socket.on('stopNode', function(data){//单节有截止的赔率(被动推送)
				var data = data;
				if(data.mid == game_info.mid){
					stopNode(data);	
				}
			});
			socket.on('startNode', function(data){//单节开始的赔率(被动推送)
				var data = data;
				if(data.mid == game_info.mid){
					startNode(data);	
				}
			});
			socket.on('resultNode', function(data){//单节赛果(被动推送)
				var data = data;
				if(data.mid == game_info.mid){
					resultNode(data)
				}
			});
			
			socket.on('differenceNode', function(mid){//单节赛果(被动推送)
				if(mid == game_info.mid){
					socket.emit('changeMid', mid);
				}
			});
			
			
			socket.on('reLoadNode', function(arr){
				/***
				if(arr[0].mid == matchs.mid){
					$('#option').empty();
					$('#endOption').empty();
					option.load(arr);
					option.odds = arr;
				}
				***/
				quiz.render(arr);
			})
			
		    }
		};
	
	//赔率有改变时
	var changeText=function(data){
		
		var rf1=0;
		var rf2=0;
		var base = Math.abs(data.rf);
		
		if (parseFloat(data.rf) > 0) {
			rf1 = '-' + base;
			rf2 = '+' + base;
			color1 = 'green';
			color2 = 'red';
		} else {
			rf1 = '+' + base;
			rf2 = '-' + base;
			color1 = 'red';
			color2 = 'green';
		}
		
		$('#options ul[node="'+data.node+'"] .zf').text(data.zf);//更新总分
		//$('#options ul[node="'+data.node+'"] .rf').text("("+data.rf+")");//跟新让分
		$('#options ul[node="'+data.node+'"] li[opt="0"] .rf').text("("+rf1+")");//跟新让分
		$('#options ul[node="'+data.node+'"] li[opt="3"] .rf').text("("+rf2+")");//跟新让分
		//$('#options ul[node="'+data.node+'"] .rf').removeClass('red green').addClass(data.color);
		
		$('#options ul[node="'+data.node+'"] li[opt="3"] .rf').removeClass('red green').addClass(color2);
		$('#options ul[node="'+data.node+'"] li[opt="0"] .rf').removeClass('red green').addClass(color1);
		
		$('#options ul[node="' + data.node + '"][typename="2"]').attr('code', data.zf);
        $('#options ul[node="' + data.node + '"][typename="1"]').attr('code', '('+data.rf+')');
        $('#options ul[node="' + data.node + '"][typename="2"]').attr('oddsid', data.id2);
        $('#options ul[node="' + data.node + '"][typename="1"]').attr('oddsid', data.id1);
        $('#options ul[node="' + data.node + '"][typename="3"]').attr('oddsid', data.id1);
        //console.log('change:' + data.node +'-'+data.gzo+'-'+data.hzo);
        $('#options ul[node="' + data.node + '"][typename="2"] li[opt="3"] cite').text(data.hzo);
        $('#options ul[node="' + data.node + '"][typename="2"] li[opt="0"] cite').text(data.gzo);
        $('#options ul[node="' + data.node + '"][typename="1"] li[opt="3"] cite').html("胜"+data.hro);
        $('#options ul[node="' + data.node + '"][typename="1"] li[opt="0"] cite').html("胜"+data.gro);
		
	};
	
	//让分截止
	var differenceNode=function(data) {
		$('#options ul[typeName="1"]').remove().map(function(){
			var node=$(this).attr("node");
			
			if(node == 5){
				jie = '全场';
			}else{
				jie = '【第<em>'+node+'</em>节】';
			}
			
			//var difference = data.difference;
			var m1=m2=m3="等待开奖";
			var c="";
			var c1="";
			if(htScore){
				var hsc = data["htScore"];
				var gsc = data["vtScore"];
				
				m1=gsc+":"+hsc;
				m2=parseInt(hsc)+parseInt(gsc);
				c="<i></i>";
				c1="red";
			}
			$('#endOption').append('<ul class="long" node="'+node+'">\
	        		<li>'+jie+'<cite>让分胜负</cite></li>\
	                <li><div class="spfzpk"><span>'+game_info.gn+'vs'+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li>\
	    		</ul>')
		});

	};
	//单节截止了让分,基偶,大小
	var stopNode=function(data){
		
		if(data.node == 5){
			jie = '全场';
		}else{
			jie = '【第<em>'+data.node+'</em>节】';
		}
		
		var htScore = data.htScore;
		var m1=m2=m3="等待开奖";
		var c="";
		var c1="";
		if(htScore){
			var hsc = data["htScore"];
			var gsc = data["vtScore"];
			
			m1=gsc+":"+hsc;
			m2=parseInt(hsc)+parseInt(gsc);
			m3=m2%2==0?"偶":"奇";
			c="<i></i>";
			c1="red";
		}
		
		if(data.type == 1){//截止了让分、基偶
			$('#options ul[node="'+data.node+'"][typename!="2"]').remove();//截止了让分
			
			
			$('#endOption').append('<ul class="long" node="'+data.node+'">\
            		<li>'+jie+'<cite>让分胜负</cite></li>\
                    <li><div class="spfzpk"><span>'+game_info.gn+'vs'+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li>\
        		</ul>');
			
			$('#endOption').append('<ul class="long" node="'+data.node+'">\
            		<li>'+jie+'<cite>总分奇偶</cite></li>\
                    <li><div class="spfzpk"><span>两队总分奇偶</span><cite class="'+c1+'">'+m3+'</cite></div>'+c+'</li>\
        		</ul>');
			
		}else{
			$('#options ul[node="'+data.node+'"][typename="2"]').remove();//截止了大小
			
			$('#endOption').append('<ul class="long" node="'+data.node+'" oddsid="'+data.id2+'" typename="2" code="'+data.zf+'">\
            		<li>'+jie+'<cite>总分大小</cite></li>\
                    <li><div class="spfzpk"><span>两队总分之和</span><cite class="'+c1+'">'+m2+'</cite></div>'+c+'</li>\
            		</ul>');
		}
		
		
		$('#options ul').length || $('#options').hide();
		//$('#endOption ul').unbind('click');
	};
	//单节开始
	var startNode=function(data){
		//data.playName = data.nodeName = '全场';
		var difference = data.difference;
		if(data.node == 5){
			jie = '全场';
		}else{
			jie = '【第<em>'+data.node+'</em>节】';
		}
		
		
		var rf1=0;
		var rf2=0;
		var base = Math.abs(data.rf)
		
		if (parseFloat(data.rf) > 0) {
			rf1 = '-' + base;//客队
			rf2 = '+' + base;
			color1 = 'green';
			color2 = 'red';
		} else {
			rf1 = '+' + base;
			rf2 = '-' + base;
			color1 = 'red';
			color2 = 'green';
		}

		
		
		/***
		if(data.node < 5){
			data.nodeName = '【第' + data.node + '节】';
			data.playName = '【第<i class="red">' + data.node + '</i>节<label></label>】';
		}
		***/
		$('#options').prepend('<ul  node="'+data.node+'" oddsid="'+data.id1+'" typename="3">\
        		<li>'+jie+'<cite>总分奇偶</cite></li>\
                <li opt="3" class="spfzpk"><span>奇数</span><cite><em >'+data.hzo+'</em></cite></li>\
                <li opt="0" class="spfzpk"><span>偶数</span><cite><em>'+data.gzo+'</em></cite></li>\
    		</ul>');
		
		if(difference){
			$('#options ul[node="'+data.node+'"][typename="1"]').remove();//截止了让分
		}else{
			$('#options').prepend('<ul  node="'+data.node+'" oddsid="'+data.id1+'" code="'+data.rf+'" typename="1">\
	        		<li>'+jie+'<cite>让分胜负</cite></li>\
	                <li opt="0" class="spfzpk"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+data.gro+'</cite></li>\
	                <li opt="3" class="spfzpk"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜'+data.hro+'</cite></li>\
	    		</ul>');
		}
		
		$('#options').prepend('<ul  node="'+data.node+'" oddsid="'+data.id2+'" typename="2" code="'+data.zf+'">\
        		<li>'+jie+'<cite>总分大小</cite></li>\
                <li  opt="3" class="spfzpk"><span>总分&gt;<em class="zf">'+data.zf+'</em></span><cite>'+data.hzo+'</cite></li>\
                <li  opt="0" class="spfzpk"><span>总分&lt;<em class="zf">'+data.zf+'</em></span><cite>'+data.gzo+'</cite></li>\
    		</ul>');
		
		
		pn_fun();
	};
	//单节赛果
	var pn_fun=function(){
		/**
		$("#options").off().Touch({children:"ul li.spfzpk", fun:function(el) {}
		})
		**/

		//$("#options").delegate("ul li.spfzpk","click",function(){
		$("#options").delegate("ul li.spfzpk","click",function(){
			
			
			dodata.section=$(this).parent("ul").attr("node");//节数
			dodata.oddsid=$(this).parent("ul").attr("oddsid");//盘口赔率	表id  如:13477
			dodata.ccodes = $(this).attr("opt");//投注内容    如:3  0
			dodata.type = $(this).parent("ul").attr("typename");
			var typename=$(this).parent("ul").find("li:eq(0)").text();
			var wfhtml="";
			if(dodata.section==4){
				//$("#js").show();
				wfhtml = $(this).html()+"<i>(第4节投注含加时)</i>";//玩法内容
			}else{
				//$("#js").hide();
				wfhtml = $(this).html()
			}
			
			/***
			 * 解决比赛过期问题
			 */
			$("#tzCont").attr("type",dodata.type);
			$("#tzCont").attr("opt",dodata.ccodes);
			$("#tzCont").attr("node",dodata.section);
			
			dodata.cperiodid=game_info.mid;
			dodata.cquizname=encodeURIComponent(game_info.hn+""+typename);
			dodata.hTName=encodeURIComponent(game_info.hn);
			dodata.vTName=encodeURIComponent(game_info.gn);
			//var wfhtml = $(this).html()+"<em>(第4节投注含加时)</em>";//玩法内容
			$("#pkCont").html(''+wfhtml);
			$.ajax({
				url:"/grounder/goldenbeanaccount.go?flag=0&qtype=3",
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					
					if(code==0){//查询成功
						var r = R.find("row");
						var balance = r.attr("balance");//金豆账户余额
						var daward = r.attr("daward");//当日盈亏
						var taward = r.attr("taward");//总盈利
						var dpm = r.attr("dpm");//当日排名
						var tpm = r.attr("tpm");//总排名
						var isqd = r.attr("isqd");//是否签到
						var nickid = r.attr("nickid")||"用户名";//用户名
						
						
						$("#jdyue").html(balance);
						
						$("#pop").show();
						//$("#tzCont ul li").click();
						$("#zhezhao").show();
						
						var newnum = parseInt($("#in_golden").val())||0;
						var pl = $("#pkCont cite").text();
						pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
						pl=parseFloat(pl);
						
						$("#fh").html(Math.ceil(newnum*pl));
					
					}else{//未登录
						var url = window.location.href;
						if(url.indexOf("?")!=-1){
							var it = url.split("?")[1];
							if(it){
								window.location.href="login.html"+"?"+it;
							}else{
								window.location.href="login.html";
							}
						}else{
							window.location.href="login.html";
						}
						//window.location.href="login.html";
					}
					
				}
			})
		})
			
	}
	var resultNode=function(data){
		//$('#endOption ul[node="'+data.node+'"]>p').append();
		
		var hsc = data["htScore"];
		var gsc = data["vtScore"];
		 
		var t = hsc+gsc;
		
		$('#options ul[node="'+data.node+'"][typename="1"] cite').html(gsc+":"+hsc);//截止了让分
		
		$('#options ul[node="'+data.node+'"][typename="2"] cite').html(t);//截止了让分
		
		$('#options ul[node="'+data.node+'"][typename="3"] cite').html(t%2==0?"偶":"奇");//截止了让分
		
		
	};
	var zbTime="";
	var tjime=""
	//初始化比分直播页面(模块)
	var studio = {
//			zb_index : 0,//当前直播行数下标
			//*******获取信息**********
			gain : function(item){
				$.ajax({
					url:'/nbajc/live/'+item+'.txt',
					type:'get',
					success: function(txt){
						if(txt){
							var zb = txt.split('$');//$符号分割 节数
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
								zbTime = setInterval(function(){studio.change(item)}, 5e3);
								//tjTime = setInterval(function(){statistics.gain(item)}, 30e3);
							}
						}else{
							$('.spinner3').hide();
							$('.zbj').html(noGame);
						}
						
					},error:function(){
						//alert('网络异常,请刷新后重试3');
					}
				});
			},
			//渲染直播dom
			render:function(txt,cg){
				if(cg){
					zb_index = zb_index;
				}else{
					var q = txt.length-2;
					zb_index += q;
				}
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
							_out.push('<em>'+c1+'</em><span>'+c[4]+'<label style="font-weight:bold">&nbsp;['+c[3]+':'+c[2]+']</label></span>');
							_out.push('</li>');
							$('.zbj').prepend(_out.join(''));
							if(cg && c[6] > zb_index){//cg进来的时候才会累加
								zb_index++;
							}
						}
						//studio.suona(c[4]);
					}
				}
			},
			change : function(item){
				$.ajax({
					url: '/nbajc/live/'+item+'Cg.txt',
					success:function(txt){
						studio.render(txt.split('!'), true);
					}
				});
			},
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
						//$('#teamMember').remove(noGame);
						//$("#jcbf2").show();
						var v1 = v.split('!');
						
						var dy = '';//队员
						var dysj = '';//队员的数据
						var html_ = '';
						
						html = '<article class="touch clearfix">\
				            	<cite class="left">'+(i==1 && game_info.hn ||game_info.gn)+'</cite>\
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
								dy += '<li>'+t[1].substring(0,6)+'</li>';
							}else{
								dy += '<li class="gray">'+t[1].substring(0,6)+'</li>';
							}
							dysj += '<li><cite>'+t[21]+'</cite><cite>'+t[15]+'</cite><cite>'+t[16]+'</cite><cite>'+t[18]+'</cite><cite>'+t[20]+'</cite><cite>'+t[6]+'</cite><cite>'+t[19]+'</cite><cite>'+t[17]+'</cite><cite>'+t[7]+'/'+t[8]+'</cite><cite>'+t[9]+'/'+t[10]+'</cite><cite>'+t[11]+'/'+t[12]+'</cite><cite>'+t[13]+'</cite><cite>'+t[14]+'</cite></li>';
						}
						dy += '</ul>';
						dysj += '</ul></article>';
						
						html = html + dy + dysj;
						html += '</div>';
						
						$('#teamMember').prepend(html);
					}else{
						//$("#jcbf2").hide();
						//$('#teamMember').prepend(noGame);
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
	}
	
	//竞猜信息(模块)
	var quiz = {
			//渲染竞彩页面
			render : function(arr){
				if(arr && arr.length){//不为空
					
					var ks = [], ts = [];
					ks.push('<article id="options">');
					ts.push('<article id="endOption">');
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
						var difference = obj_.difference;//第几节
						var rf = obj_.rf;//盘口
						var status = obj_.status;//当前是否可以购买
						var type = obj_.type;//2 当前节截止（1-让分[奇偶] 2-大小分）
						var zf = obj_.zf;//大小分
						
						
						var color1="";
						var color2="";
						var rf1=0;
						var rf2=0;
						var base = Math.abs(rf)
						
						if (parseFloat(rf) > 0) {
							rf1 = '-' + base;
							rf2 = '+' + base;
							color1 = 'green';
							color2 = 'red';
						} else {
							rf1 = '+' + base;
							rf2 = '-' + base;
							color1 = 'red';
							color2 = 'green';
						}

						
						var htScore = obj_.htScore;
						
						
						var m1=m2=m3="等待开奖";
						var c="";
						var c1=""
						if(htScore){
							var hsc = obj_["htScore"];
							var gsc = obj_["vtScore"];
							
							m1=gsc+":"+hsc;
							m2=parseInt(hsc)+parseInt(gsc);
							m3=m2%2==0?"偶":"奇";
							c="<i></i>";
							c1="red"
						}
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
								ts.unshift('<ul class="long">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li><div class="spfzpk"><span>两队总分之和</span><cite class="'+c1+'">'+m2+'</cite></div>'+c+'</li>\
					        		</ul>\
										<ul class="long">\
					            		<li>'+jie+'<cite>让分胜负</cite></li>\
					                    <li><div class="spfzpk"><span>'+game_info.gn+'vs'+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li>\
					        		</ul>\
					        		<ul class="long">\
				            		<li>'+jie+'<cite>总分奇偶</cite></li>\
				                    <li><div class="spfzpk"><span>两队总分奇偶</span><cite class="'+c1+'">'+m3+'</cite></div>'+c+'</li>\
				        		</ul>\
					            		');
							}						
						}else if(status == 1){//有开售的
							if(type == 0){// 全开售
								ks.push('<ul  node="'+node+'" oddsid="'+id2+'" typename="2" code="'+zf+'">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li  opt="3" class="spfzpk"><span>总分&gt;<em class="zf">'+(zf?zf:"0")+'</em></span><cite>'+(hzo?hzo:"")+'</cite></li>\
					                    <li  opt="0" class="spfzpk"><span>总分&lt;<em class="zf">'+(zf?zf:"0")+'</em></span><cite>'+(gzo?gzo:"")+'</cite></li>\
					        		</ul>')
					             if(difference){
										ts.unshift('<ul class="long" node="'+node+'" oddsid="'+id1+'" code="'+rf+'" typename="1"><li>'+jie+'<cite>让分胜负</cite></li><li><div class="spfzpk"><span>'+game_info.gn+'vs'+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li></ul>')
									}else{
										ks.push('<ul  node="'+node+'" oddsid="'+id1+'" typename="1" code="'+rf+'"><li>'+jie+'<cite>让分胜负</cite></li><li opt="0" class="spfzpk"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+gro+'</cite></li>\<li opt="3" class="spfzpk"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜 '+hro+'</cite></li></ul>')
									}
						          ks.push('<ul  node="'+node+'" oddsid="'+id1+'" typename="3">\
						            		<li>'+jie+'<cite>总分奇偶</cite></li>\
						                    <li opt="3" class="spfzpk"><span>奇数</span><cite><em >1.80</em></cite></li>\
						                    <li opt="0" class="spfzpk"><span>偶数</span><cite><em>1.80</em></cite></li>\
						        		</ul>\
						              ');
							}else if(type == 1){//截止了让分、奇偶
								ks.push('<ul node="'+node+'" oddsid="'+id2+'" typename="2" code="'+zf+'">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li opt="3" class="spfzpk"><span>总分&gt;<em class="zf">'+zf+'</em></span><cite>'+hzo+'</cite></li>\
					                    <li opt="0" class="spfzpk"><span>总分&lt;<em class="zf">'+zf+'</em></span><cite>'+gzo+'</cite></li>\
					            		</ul>\
						              ');
								ts.unshift('<ul class="long" node="'+node+'" oddsid="'+id1+'" code="'+rf+'" typename="1">\
					            		<li>'+jie+'<cite>让分胜负</cite></li>\
					                    <li><div class="spfzpk"><span>'+game_info.gn+'vs'+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li>\
					        		</ul>\
					                    <ul class="long" node="'+node+'" oddsid="'+id1+'" typename="3">\
					            		<li>'+jie+'<cite>总分奇偶</cite></li>\
					                    <li><div class="spfzpk"><span>两队总分奇偶</span><cite class="'+c1+'">'+m2+'</cite></div>'+c+'</li>\
					        		</ul>\
						                ');
							}else if(type == 2){//截止了大小
								if(difference){
									ts.unshift('<ul class="long" node="'+node+'" oddsid="'+id1+'" code="'+rf+'" typename="1"><li>'+jie+'<cite>让分胜负</cite></li><li><div class="spfzpk"><span>'+game_info.gn+'vs'+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li></ul>')
								}else{
									ks.push('<ul  node="'+node+'" oddsid="'+id1+'" typename="1" code="'+rf+'"><li>'+jie+'<cite>让分胜负</cite></li><li opt="0" class="spfzpk"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+gro+'</cite></li>\<li opt="3" class="spfzpk"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜 '+hro+'</cite></li></ul>')
								}
								
						        
								ks.push('<ul node="'+node+'" oddsid="'+id1+'" typename="3"><li>'+jie+'<cite>总分奇偶</cite></li><li opt="3" class="spfzpk"><span>奇数</span><cite>1.80</cite></li><li opt="0" class="spfzpk"><span>偶数</span><cite>1.80</cite></li></ul>');
								ts.unshift('<ul class="long" node="'+node+'" oddsid="'+id2+'" typename="2" code="'+zf+'">\
					            		<li>'+jie+'<cite>总分大小</cite></li>\
					                    <li><div class="spfzpk"><span>两队总分之和</span><cite class="'+c1+'">'+m1+'</cite></div>'+c+'</li>\
					            		</ul>\
					            		');
							}
						}
					}
					ks.push('</article>');
					ts.push('</article>');
					var html = ks.join('')+'<p class="mgbd pdbt095">已截止的竞猜</p>'+ts.join('');
					$('#odds').html(html);
					
					//arr[0]['difference']&&differenceNode();
					//differenceNode(obj_);
					pn_fun();
					
				}else{
					alert('error');
				}
			},
			//选好比赛以后的弹层
			/***
			tc:function(obj){
				var wfhtml = $(obj).html();//玩法内容
				$("#pkCont").html(''+wfhtml);
			},
			***/
			//确认竞猜
			confirmQuiz:function(){
				var data=dodata;
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
							alert("参与竞猜成功");
							$("#in_golden").val("50");
							
							var pl = $("#pkCont cite").text();
							pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
							pl=parseFloat(pl);
							
							$("#fh").html(50*pl);
							$("#tzCont ul.clearfix li").removeClass("cur");
							$("#sjd").hide();
							$("#pop").hide();
							$("#zhezhao").hide();
							$("#qrjc").html("确认竞猜");
						}else if(code==1){
							window.location.href="login.html";
						}else{
							alert(desc);
						}
					}
				});
			}
	};
	
	
	
	//当前比分的部分信息
	var game_info={
		mid:"",//主站的赛事id
		id:"",//资料库id
		hn:"",//主队名
		gn:"",//客队名
		hr:"",//主队排名
		gr:"",//客队排名
	    statusCode:"",//比赛状态码
	    time:"",//比赛剩余时间
	    hsc:"",//主队得分
	    gsc:"",//客队得分
	    gid:"",
	    hid:"",
	    statusCode:"",
	    mtime:"",//比赛开始时间
		gs:"",//当前节比分
		hs:""
	};
	
	//比赛状态
	var st={
		    '0': '未开赛',
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
	
	
	
	var ongoing=[];//进行中的比赛数组
	var nogoing=[];//没有进行中的比赛数组
	
	
	var allMatchs=[];//存放所有比赛数组
	var _timeId="";
	var P_fn={
			//加载导航(导航信息引出头部,直播,数据统计,竞猜等信息)
			load_nav_info:function(tag){
				var listHTML=""
				$.ajax({
					url:"/nbajc/matchs/"+P1+"/allmatches.json?"+Math.random(),
					dataType:'JSON',
					cache:true,
					success:function(data){
						if(jQuery.isEmptyObject(data)){
							$(".hmHeader").html('<div style="width:5.2rem;margin:0 auto; padding-top: 3.6rem;font-size:.8rem;">今日无竞猜</div>');
							$("#jcbf1,#studio,#jcbf2").hide();
							$('#teamMember').html(noGame);
							$('.spinner3').hide();
							$('.zbj').html(noGame);

							return;
						} 
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
							
							var isRank = data[i]["isRank"];
							
							
							var mtime = data[i]["mtime"];//开赛时间
							mtime = mtime.replace(/-/g,"/");
							var t = new Date(mtime);
							var d = t.getDate();
							var H = t.getHours();
							var M = t.getMinutes();
							M=M<10?"0"+M:M
							var timeStr = d+"日"+" "+H+":"+M;
							
							
							allMatchs.push(data[i]);
							
							var statusCode = data[i]["statusCode"];//比赛的状态码
							var statusName = data[i]["statusName"];//比赛的状态
							if(statusCode==0 || statusCode==60 || statusCode==90|| statusCode==100 || statusCode==110){//完场，中断，延期
								listHTML+='<p isRank="'+isRank+'" mtime="'+mtime+'" statusCode="'+statusCode+'" gid="'+gid+'" hid="'+hid+'" time="'+time+'" hsc="'+hsc+'" gsc="'+gsc+'" code="'+statusCode+'" hn="'+hn+'" gn="'+gn+'" hr="'+hr+'" gr="'+gr+'" mid="'+mid+'" zid="'+id+'"><span>'+timeStr+' '+gn+' <em>vs</em> '+hn+'</span><cite>'+st[statusCode].substring(0,3)+'</cite></p>'
								nogoing.push(data[i])
							}else{//进行中
								listHTML+='<p isRank="'+isRank+'" mtime="'+mtime+'" statusCode="'+statusCode+'" gid="'+gid+'" hid="'+hid+'" time="'+time+'" hsc="'+hsc+'" gsc="'+gsc+'" code="'+statusCode+'" hn="'+hn+'" gn="'+gn+'" hr="'+hr+'" gr="'+gr+'" mid="'+mid+'" zid="'+id+'"><span>'+timeStr+' '+gn+' <em class="red">'+gsc+':'+hsc+'</em> '+hn+'</span><cite class="red">'+st[statusCode].substring(0,3)+'</cite></p>'
								ongoing.push(data[i])
							}
						}
						$("#listcont").html(listHTML);
						var item = '';
						if(!tag){
							if(ongoing.length){//取数组中的第一个值作为默认比赛
								item = ongoing[0]["id"];//资料库id
								if(ongoing[0]["isRank"]==1){
									$(".bcjj").show()
								}else{
									$(".bcjj").hide()
								}
								$(".bcjj").attr("mid",ongoing[0]["mid"])
								$(".bcjj").attr("gn",ongoing[0]["gn"])
								$(".bcjj").attr("hn",ongoing[0]["hn"])
								//window.location.href="/gq/"+"#"+item;
							}else{
								item = nogoing[0]["id"];//资料库id
								if(nogoing[0]["isRank"]==1){
									$(".bcjj").show();
								}else{
									$(".bcjj").hide();
								}
								$(".bcjj").attr("mid",nogoing[0]["mid"])
								$(".bcjj").attr("gn",nogoing[0]["gn"])
								$(".bcjj").attr("hn",nogoing[0]["hn"])
								//window.location.href="/gq/"+"#"+item;
							}
						}else{
							item = tag;
							
							window.location.href="/gq/"+"?"+item;
						}
						
						var url = window.location.href;
						if(url.indexOf("?")!=-1){
							var it = url.split("?")[1];
							if(it){
								P_fn.load_bf(it);
								studio.gain(it);
								statistics.gain(it);
								
								if($("#listcont p[zid='"+it+"']").attr("isRank")==1){
									$(".bcjj").show();
								}else{
									$(".bcjj").hide();
								}
								$(".bcjj").attr("mid",$("#listcont p[zid='"+it+"']").attr("mid"));
								$(".bcjj").attr("hn",$("#listcont p[zid='"+it+"']").attr("hn"));
								$(".bcjj").attr("gn",$("#listcont p[zid='"+it+"']").attr("gn"));
							}
						}else{
							P_fn.load_bf(item);
							studio.gain(item);
							statistics.gain(item);
							if($("#listcont p[zid='"+item+"']").attr("isRank")==1){
								$(".bcjj").show();
							}else{
								$(".bcjj").hide();
							}
							$(".bcjj").attr("mid",$("#listcont p[zid='"+item+"']").attr("mid"));
							$(".bcjj").attr("hn",$("#listcont p[zid='"+it+"']").attr("hn"));
							$(".bcjj").attr("gn",$("#listcont p[zid='"+it+"']").attr("gn"));
						}
					},
					error:function(){
					//	alert("网络异常,请刷新后重试1")
					}
				});
			},
			
			
			load_bf:function(item){
				clearInterval(_timeId);
				//比分发生变化时，改变当前比赛的比分
					$.ajax({
						url:"/nbajc/matchs/"+P1+"/"+item+".json?"+Math.random(),
						dataType:'json',
						cache:true,
						success:function(data){
							var t_ ={};
							var g1 = data["g1"];
							var g2 = data["g2"];
							var g3 = data["g3"];
							var g4 = data["g4"];
							var h1 = data["h1"];
							var h2 = data["h2"];
							var h3 = data["h3"];
							var h4 = data["h4"];
							var gjs = data["gjs"];//客队加时阶段比分
							var hjs = data["hjs"];//主队加时阶段比分
							var mtime = data["mtime"];//开始时间
							var mid = data["mid"];//主站赛事id
							var gr = data["gr"];//客队排名
							var hr = data["hr"];//主队排名
							var gn = data["gn"];//客队名称
							var hn = data["hn"];//主队名称
							var gid = data["gid"];//客队id
							var hid = data["hid"];//主队id
							
							t_.statusCode = data["statusCode"];
							t_.hsc = data["hsc"];//主队比分
							t_.gsc = data["gsc"];//客队比分
							t_.id = data["id"];//比赛id
							t_.mtime = data["mtime"];//倒计时器
							t_.time = data["time"];//倒计时器
							P_fn.gain(t_);
							
							game_info.hn=hn;
							game_info.gn=gn;
							game_info.mid=mid
							game_info.id=t_.id;
							socket.emit('changeMid',game_info.mid);//建立网络连接
							o.node();
							$("#jcbf1 li:eq(1) span").html(game_info.gn);//客队名称
							$("#jcbf1 li:eq(2) span").html(game_info.hn);//客队名称
							$(".dzqd ul li:eq(0)").html('<p><img src="nbalogo/t_'+gid+'.png"></p><span><strong>'+gn+'</strong>'+(gr?"["+gr+"]":"")+'</span>');
							$(".dzqd ul li:eq(2)").html('<p><img src="nbalogo/t_'+hid+'.png"><i></i></p><span><strong>'+hn+'</strong>'+(hr?"["+hr+"]":"")+'</span>')
							$("#jcbf1 li:eq(1) cite:eq(0)").html(g1?g1:"&nbsp;");
							$("#jcbf1 li:eq(2) cite:eq(0)").html(h1?h1:"&nbsp;");
							$("#jcbf1 li:eq(1) cite:eq(1)").html(g2?g2:"&nbsp;");
							$("#jcbf1 li:eq(2) cite:eq(1)").html(h2?h2:"&nbsp;");
							$("#jcbf1 li:eq(1) cite:eq(2)").html(g3?g3:"&nbsp;");
							$("#jcbf1 li:eq(2) cite:eq(2)").html(h3?h3:"&nbsp;");
							$("#jcbf1 li:eq(1) cite:eq(3)").html(g4?g4:"&nbsp;");
							$("#jcbf1 li:eq(2) cite:eq(3)").html(h4?h4:"&nbsp;");
							$("#jcbf1 li:eq(1) cite:eq(5)").html(t_.gsc?t_.gsc:"&nbsp;");
							$("#jcbf1 li:eq(2) cite:eq(5)").html(t_.hsc?t_.hsc:"&nbsp;");
							
							
							
							
							
							$("#jcbf2 li:eq(1) span").html(game_info.gn);//客队名称
							$("#jcbf2 li:eq(2) span").html(game_info.hn);//客队名称
							//$(".dzqd ul li:eq(0)").html('<p><img src="nbalogo/t_'+gid+'.png"></p><span><strong>'+gn+'</strong>'+(gr?"["+gr+"]":"")+'</span>');
							//$(".dzqd ul li:eq(2)").html('<p><img src="nbalogo/t_'+hid+'.png"><i></i></p><span><strong>'+hn+'</strong>'+(hr?"["+hr+"]":"")+'</span>')
							$("#jcbf2 li:eq(1) cite:eq(0)").html(g1?g1:"&nbsp;");
							$("#jcbf2 li:eq(2) cite:eq(0)").html(h1?h1:"&nbsp;");
							$("#jcbf2 li:eq(1) cite:eq(1)").html(g2?g2:"&nbsp;");
							$("#jcbf2 li:eq(2) cite:eq(1)").html(h2?h2:"&nbsp;");
							$("#jcbf2 li:eq(1) cite:eq(2)").html(g3?g3:"&nbsp;");
							$("#jcbf2 li:eq(2) cite:eq(2)").html(h3?h3:"&nbsp;");
							$("#jcbf2 li:eq(1) cite:eq(3)").html(g4?g4:"&nbsp;");
							$("#jcbf2 li:eq(2) cite:eq(3)").html(h4?h4:"&nbsp;");
							$("#jcbf2 li:eq(1) cite:eq(5)").html(t_.gsc?t_.gsc:"&nbsp;");
							$("#jcbf2 li:eq(2) cite:eq(5)").html(t_.hsc?t_.hsc:"&nbsp;");
							
							
							if(gjs || hjs){
								$("#jcbf1").addClass("sjtj1");
								$("#jcbf2").addClass("sjtj1");
								
								
								$("#jcbf1 li:eq(0) cite:eq(4)").show();
								$("#jcbf1 li:eq(1) cite:eq(4)").show();
								$("#jcbf1 li:eq(2) cite:eq(4)").show();
								
								$("#jcbf1 li:eq(1) cite:eq(4)").html(gjs?gjs:"&nbsp;");
								$("#jcbf1 li:eq(2) cite:eq(4)").html(hjs?hjs:"&nbsp;");
								
								$("#jcbf2 li:eq(1) cite:eq(4)").html(gjs?gjs:"&nbsp;");
								$("#jcbf2 li:eq(2) cite:eq(4)").html(hjs?hjs:"&nbsp;");
								
								$("#jcbf2 li:eq(0) cite:eq(4)").show();
								$("#jcbf2 li:eq(1) cite:eq(4)").show();
								$("#jcbf2 li:eq(2) cite:eq(4)").show();
							}else{
								$("#jcbf2 li:eq(0) cite:eq(4)").hide();
								$("#jcbf2 li:eq(1) cite:eq(4)").hide();
								$("#jcbf2 li:eq(2) cite:eq(4)").hide();
								

								$("#jcbf1 li:eq(0) cite:eq(4)").hide();
								$("#jcbf1 li:eq(1) cite:eq(4)").hide();
								$("#jcbf1 li:eq(2) cite:eq(4)").hide();
								
								$("#jcbf1").removeClass("sjtj1");
								$("#jcbf2").removeClass("sjtj1");
							}
							
							
							$(".hmHeader h1").html(gn+"vs"+hn)
							
							if(t_.statusCode!=100){
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
					    				    		if(item==t.id){//改变当前比赛的比分
						    							t.mid = $(this).attr('mid');
						    							t.statusCode = $(this).attr('code');
						    							t.hs = $(this).attr('hs');//当前节主队比分
						    				    		t.gs = $(this).attr('gs');
						    				    		t.hsc = $(this).attr('hsc');
						    				    		t.gsc = $(this).attr('gsc');
						    				    		t.time = $(this).attr('time');//倒计时器
					    								if(t.statusCode==100){
					    									clearInterval(_timeId);//清楚定时器
					    								}else{
					    									P_fn.gain(t);
					    									
					    									var tt = {13:'0',14:'1',15:'2',16:'3',40:"4"}[t.statusCode];
					    									if(t.statusCode==40){
					    										$("#jcbf1").addClass("sjtj1");
					    										$("#jcbf2").addClass("sjtj1");
					    										
					    										
					    										$("#jcbf1 li:eq(0) cite:eq(4)").show();
					    										$("#jcbf1 li:eq(1) cite:eq(4)").show();
					    										$("#jcbf1 li:eq(2) cite:eq(4)").show();
					    										
					    										$("#jcbf2 li:eq(0) cite:eq(4)").show();
					    										$("#jcbf2 li:eq(1) cite:eq(4)").show();
					    										$("#jcbf2 li:eq(2) cite:eq(4)").show();
					    									}
					    									$("#jcbf1 li:eq(1) cite:eq("+tt+")").html(t.gs?t.gs:"&nbsp;");
					    									$("#jcbf1 li:eq(2) cite:eq("+tt+")").html(t.hs?t.hs:"&nbsp;");
					    									$("#jcbf1 li:eq(1) cite:eq(5)").html(t.gsc?t.gsc:"&nbsp;");
					    									$("#jcbf1 li:eq(2) cite:eq(5)").html(t.hsc?t.hsc:"&nbsp;");
					    									
					    									$("#jcbf2 li:eq(1) cite:eq("+tt+")").html(t.gs?t.gs:"&nbsp;");
					    									$("#jcbf2 li:eq(2) cite:eq("+tt+")").html(t.hs?t.hs:"&nbsp;");
					    									$("#jcbf2 li:eq(1) cite:eq(5)").html(t.gsc?t.gsc:"&nbsp;");
					    									$("#jcbf2 li:eq(2) cite:eq(5)").html(t.hsc?t.hsc:"&nbsp;");
					    								}
					    				    		}
					    						})
				    						}
				    					}
				    				});
				    			},5000)
							}
						},
						error:function(){
						//	alert("网络异常,请刷新后重试2")
						}
					});
			},
			gain : function(game_info){
				//初始化头部
				if(game_info.statusCode==0){
					$(".dzqd ul li:eq(1)").html('<b>VS</b><span>'+st[game_info.statusCode].substring(0,3)+'</span>');
				}else{
					$(".dzqd ul li:eq(1)").html('<b>'+game_info.gsc+':'+game_info.hsc+'</b><span>'+st[game_info.statusCode].substring(0,3)+'  '+game_info.time+'</span>');
				}
			}
	};
	
	var fomatStr = function(s,type) {
		    if (/[^0-9\.]/.test(s)){return "0";};
		    if (s == null || s == ""){return "0";};
		    s = s.toString().replace(/^(\d*)$/, "$1.");
		    s = (s + "00").replace(/(\d*\.\d\d)\d*/, "$1");
		    s = s.replace(".", ",");
		    var re = /(\d)(\d{3},)/;
		    while(re.test(s))
		    {
		        s = s.replace(re, "$1,$2"); 
		    }
		    s = s.replace(/,(\d\d)$/, ".$1");  
		    if (type == 0) 
		    {
		        var a = s.split(".");
		        if (a[1] == "00") 
		        {
		            s = a[0];
		        }
		    }
		    return s;
		}
	var delFH = function(str){
		str = str.replace(/,/g,'');
		return str;
	}

	
	
	//投注所需要的参数对象
	var dodata={
			mtype:4,//终端类型 no
			appversion:"",//客户端版本号，触屏可为空
			ccodes:3,//投注内容  3/0
			cperiodid:"",//期次编号
			cquizname:"",//竞猜名称
			itmoney:0,//投注金额
			oddsid:"",//盘口赔率表id
			section:5,//投注节数 第1，2，3，4节，或5-全场
			type:2,//玩法让分 1，总分 2，奇偶 3
			hTName:game_info.hn,//主队名
			vTName:game_info.gn//客队名称
	};
	var gundong = function(){
      	//公告滚动
    	setInterval(function(){
    		$("#gonggao").find("ul:first").animate({
    			marginTop:"-20px"
    		},300,function(){
    			$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
    		});
    	},5000);
	}
	
	//事件绑定
	var bindEvent=function(){
		//头部下拉列表
		$(".hmHeader").delegate("h1","click",function(){
			$("#pop").hide();
			$("#zhezhao").hide();
			$("#listcont").toggle();
			$(".mask").toggle();
			$(".hmHeader").toggleClass("h1Down");
		});
		
		//直播，数据统计，竞猜切换
		$(".tab ul li").bind("click",function(){
			var index = $(this).index();
			
			$(this).addClass("cur").siblings().removeClass("cur");
			
			$("#content").children("article:eq('"+index+"')").show()
			$("#content").children("article:eq('"+index+"')").siblings().hide();
		});
		
		//右侧下拉框
		$('.pullIco').bind('click', function(){
			$('.pullDown').toggleClass('pullHover');
			$('.pullText').toggle();
		});
		
		

		
		
		
		//积分切换
		$("#tzCont ul li:not(:first)").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur")
			setTimeout(function(){
				$("#tzCont ul li").removeClass("cur")
			},100);
			var num = parseInt($("#in_golden").val())||0;
			var remain_jd = parseInt(delFH($("#jdyue").html()));
			var v = $(this).html();
			if(v=="全押"){
				if(remain_jd>200000){
					alert("单次竞猜最大投入200000金豆");
					$("#in_golden").val(200000);
				}else{
					$("#in_golden").val(remain_jd);
				}
				
				$("#sjd").hide();
			}else{
				if(parseInt(v)+num>200000){
					alert("单次竞猜最大投入200000金豆");
					$("#in_golden").val(200000);
				}else{
					if(remain_jd>parseInt(v)+num){
						$("#in_golden").val(parseInt(v)+num);
						$("#sjd").hide();
					}else{
						$("#in_golden").val(parseInt(v)+num);
						$("#sjd").show();
					}
				}
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			
			if(newnum>200000){
				alert("单次竞猜最大投入200000金豆");
				return;
			}
			
			var pl = $("#pkCont cite").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));

			
			
		});
		
		
		$(".bcjj").bind("click",function(){
			var mid = $(this).attr("mid");
			var hn = $(this).attr("hn");
			var gn = $(this).attr("gn");
			window.location.href="dcph.html?mid="+mid+"&gn="+gn+"&hn="+hn;
		})
		
		//切换比赛
		$("#listcont").delegate("p","click",function(){
			var zid = $(this).attr("zid");
			var mid = $(this).attr("mid");
			var isRank = $(this).attr("isRank")
			
			if(isRank==1){
				$(".bcjj").show();
			}else{
				$(".bcjj").hide();
			}
			$(".bcjj").attr("mid",mid);
			
			
			clearInterval(zbTime);
			$(".zhezhao").hide();
			$("#listcont").hide();
			
			
			//P_fn.load_head_info(item);//根据比赛id加载头部信息
			P_fn.load_nav_info($(this).attr('zid'));
			
			var ur = window.location.href;
			var t = ur.split("#")[1];
			if(t){
				$("#listcont p[zid='"+t+"']").addClass("cur")
			}
		});
		
		//关闭购买层
		$("#close").bind("click",function(){
			$("#in_golden").val("50");
			
			var pl = $("#pkCont cite").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			
			$("#fh").html(Math.ceil(50*pl));
			$("#ulCont li").removeClass("cur");
			$("#sjd").hide();
			$("#pop").hide();
			$("#zhezhao").hide();
			
		});
		
		
		//确认竞猜
		$(".ture").bind("click",function(){
			var remain_jd = delFH($("#jdyue").html());
			var tMoney=parseInt($("#in_golden").val())||0;
			
			/***
			 * oddsid变化时
			 */
			
			var type = $("#tzCont").attr("type");
			var opt = $("#tzCont").attr("opt");
			var node = $("#tzCont").attr("node");
			 var oddsid = $('#options ul[node="' +node + '"][typename="'+type+'"]').attr('oddsid');
			dodata.oddsid=oddsid;
			
			
			//盘口
			var pkv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"]');
			var plv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"]');
			
			if(type==2){//总分
				var pkv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] .zf').html();
				var plv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] cite').html();
				
				var oldpkv = $("#pkCont .zf").html();
				var oldplv = $("#pkCont cite").html();
				
				if(pkv != oldpkv || plv != oldplv){
					//$("#js").hide();
					$("#bh").show();
					setTimeout(function(){
						$("#bh").hide();
					},3000)
					$("#pkCont .zf").html(pkv);
					$("#pkCont cite").html(plv);
					return;
				}else{
					$("#bh").hide();
				}
			}else if(type==1){
				var pkv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] .rf').html();
				var plv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] cite').html();
				
				var oldpkv = $("#pkCont .rf").html();
				var oldplv = $("#pkCont cite").html();
				
				if(pkv != oldpkv || plv != oldplv){
					$("#js").hide();
					$("#bh").show();
					setTimeout(function(){
						$("#bh").hide();
					},3000)
					$("#pkCont .rf").html(pkv);
					$("#pkCont cite").html(plv);
					return;
				}else{
					$("#bh").hide();
				}
			}
			
			
			dodata.itmoney=tMoney;
			
			if(!tMoney){
				alert("输入金豆");
				return;
			}
			
			if(tMoney<50){
				alert("请至少输入50个金豆")
				return;
			}
			
			if(remain_jd>=tMoney){
				quiz.confirmQuiz();
			}else{
				$("#sjd").show();
			}
			
			
		});
		
		/***
		$("#in_golden").focus(function(){
			var v = $(this).val();
			if(v==this.defaultValue){
				$(this).val("");
				//$(this).next().hide();
			}
		});
		***/

		$("#in_golden").blur(function(){
			var v = $(this).val();
			if(!v || v==""){
				$(this).val(50);
				//$(this).next().hide();
			}
		});
		
		//返还值
		$("#in_golden").keyup(function(){
			var v = parseInt($(this).val())||0;
			var pl = $("#pkCont cite").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			if(!v){
				$("fh").html(0);
			}else if(v>200000){
				$("#in_golden").val(200000)
				alert("单次竞猜最大投入200000金豆");
			}else{
				$("#fh").html(Math.ceil(v*pl));
				$("#sjd").hide();
			}
		})
	};
	return {
		init:init
	};
})()
$(function(){
	HC.gq.init();
})




