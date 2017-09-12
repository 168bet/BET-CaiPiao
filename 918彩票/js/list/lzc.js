CP.LZC = (function () {
	var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//彩种
	var s = {
			'sfc': {name:'胜负彩',lotid:'80',tx:'猜中14场一等奖,13场二等奖',max:'14'},
			'r9': {name:'任九',lotid:'81',tx:'猜中任意9场即中奖',max:'9'}
	};
	var lzcData = {};//老足彩对阵信息
	var param = [];//投注code
	var spArr = [];//每一排选了多少个 算注数用的
	var g = {
			count : 0,//注数
			bet : 1,//倍数
			amount : 0,//总金额
			hmMoney : 0,//合买应付
			buyType : '',//1自购 2合买
			qihao_id : ''
	}
	var o = {
			//页面跳转
	        pageGo: {
	            goBack: function () {
	            	TopAnch.init({
	            		title:s[lotteryType].name,
	            		prevShow:true,
	            		prevFun:function(){//左侧按钮绑定事件
	            			window.location.href = '#type=index';
	            		},
	            		menu:[{'name':'选择比赛','url':'javascript:;','cur':true},
	            		      //{'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot(s[lotteryType].lotid, 2),'cur':false},
	            		      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_='+s[lotteryType].lotid,'cur':false},
	            		      {'name':'玩法帮助','url':'#type=url&p=wf/'+lotteryType+'.html','cur':false}],
	            		      style:false
	            	});
	            }
	        },
	        /*认购保底多少[[*/
			hmDet : function () {
				var rg = parseInt($('#rg').val() || 0);
				var bd = parseInt($('#bd').val() || 0);
				var z = rg+bd;
				g.hmMoney = z;
				$('#hm_m cite:eq(0)').html(rg);//认购
				$('#hm_m cite:eq(1)').html(bd);//保底
				$('#hm_m cite:eq(2)').html(z);//总金额
			},
			/*]]认购保底多少*/
			
	        doHm : function () {
				/*显示合买[[*/
	        	$("#betball, #jc_footer, #jczq_mask").hide();
				$('#bethm').show();
				/*]]显示合买*/
				
				/*设置导航左右按钮 [[*/
				TopAnch.init({
					title:'发起合买',
					prevShow:true,
					prevFun:function(){//左侧按钮绑定事件
						window.location.href = '#type=url&p=list/'+lotteryType+'.html';
					},
					isBack:true,
					nextShow:false,
					style:false
				});
				
				$('#hmDet cite').eq(0).html(g.count);//注数
				$('#hmDet cite').eq(1).html(g.bet);//倍数
				$('#hmDet cite').eq(2).html(g.amount);//总金额
				
				$("#rg").val(Math.ceil(g.amount*0.05));
				$("#rg_bl").html(Math.floor(($('#rg').val()/g.amount)*10000)/100+"%");
				$("#bd").removeAttr('disabled');
				$("#bd").val('0');
				$("#bd_bl").html('0%');
				o.hmDet();
			},
	        //渲染对阵
	        render : function (pid) {
	        	g.qihao_id = pid;
	        	var opt_ = lzcData[pid];
	        	var et = opt_.et;
	        	var time_ = et.substr(11,5);//10:24
				var calendar_ = et.substr(0,10);//1991 10 24
				var date_ = et.substr(5,6);//10 24
				var datediff = CP.Util.DateDiff(opt_.severtime, calendar_);
				datediff = {'0':'今天','1':'明天','2':'后天'}[datediff]||date_;
	        	var out_ = [];
	        	out_.push('<div class="sfcTitle clearfix"><span class="left"><cite class="red">'+datediff+''+time_+'</cite> 截止</span>');
	        	out_.push('<span class="right">'+s[lotteryType].tx+'</span></div>');
	        	for (var Q in opt_.arr) {
	        		var Q1 = opt_.arr[Q];
	        		var oh_ = '--', od_ = '--', oa_ = '--';
					if(Q1.oh != '' && Q1.od != '' && Q1.oa != ''){
						var f = 1/(1/Q1.oh+1/Q1.od+1/Q1.oa);
						oh_ = Math.round((f/Q1.oh)*100);
						od_ = Math.round((f/Q1.od)*100);
						oa_ = (100-oh_-od_)+'%';
						oh_ = oh_+'%';
						od_ = od_+'%';
					}
	        		out_.push('<ul class="sfcxs">\
	        				<li class=wangwei><em>'+Q1.xid+'</em><p style="color:'+Q1.cl+'">'+Q1.mname+'</p><cite>'+Q1.mtime+'</cite><i class="up down"></i></li><li>\
	        				<p class="spfzpk spfzpk2"><span my-data="3"><em>'+Q1.hn+'</em><cite>胜</cite></span><span class="spfvs" my-data="1"><em>VS</em><cite>平</cite></span><span my-data="0"><em>'+Q1.gn+'</em><cite>胜</cite></span></p>\
	        				<p class="spfpl"><span>概率'+oh_+'</span><span class="spfvs">概率'+od_+'</span><span>概率'+oa_+'</span></p>\
	        				</li>\
	        				</ul>\
	        				<div class="sfcpl" style="display:none;">\
	        				<dl><dt>平均赔率</dt><dd>'+(Q1.oh == ""?"-":Q1.oh)+'</dd><dd>'+(Q1.od == ""?"-":Q1.od)+'</dd><dd>'+(Q1.oa == ""?"-":Q1.oa)+'</dd></dl>\
	        				<dl><dt>联赛排名</dt><dd>'+(Q1.hm == ""?"-":Q1.hm)+'</dd><dd>&nbsp;</dd><dd>'+(Q1.gm == ""?"-":Q1.gm)+'</dd></dl>\
	        				<dl><dt>近期战绩</dt><dd class="yellow">'+(Q1.htn == ""?"-":Q1.htn)+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(Q1.gtn == ""?"-":Q1.gtn)+'</dd></dl>\
	        				</div>');
	        	}
	        	$('#item').html(out_.join(''));
	        	o.bind_();
	        },
	        //初始化获取当前期基本信息
			init : function (tag) {//tag 不为undefined的时候 代表正在获取预售期信息
				var pid_ = '';
				!!tag && (pid_ = '?pid='+tag);
				$.ajax({
					url:CP.Data.apps+'/trade/queryZucai.go'+pid_,
					type:'POST',
					DataType:'XML',
					success: function(xml){
						var severtime=new Date(arguments[2].getResponseHeader("Date"));//服务器时间
						severtime = severtime.getFullYear()+'-'+CP.Util.pad(severtime.getMonth()+1,2)+'-'+CP.Util.pad(severtime.getDate(),2);
						var R = $(xml).find('rows');//节点
						var pid = R.attr('pid');//当前期次
						!lzcData[pid] && (lzcData[pid] = {});
						lzcData[pid].pid = pid;
						lzcData[pid].severtime = severtime;
						lzcData[pid].et = R.attr('et');//复试截止时间
						lzcData[pid].fet = R.attr('fet');//单式截止时间
						lzcData[pid].sale = R.attr('sale');//是否在售
						var r = R.find('row');//节点集
						var rp = R.find('rowp');//节点
						var pids = rp.attr('pids')||'';//预售期列表
						var Q1 = pids.split(',');
						if(Q1.length > 1){
							if(jQuery('#qici_lzc').html() == ''){
								jQuery('#qici_lzc').html('<li v="'+Q1[0]+'" class="cur">当前期'+Q1[0]+'</li><li v="'+Q1[1]+'">预售期'+Q1[1]+'</li>');
							}
						}else{
							jQuery('#qici_lzc').hide();
						}
						var arr = [];
						r.each(function(){
							var Q = {};
							Q.xid = $(this).attr('xid');	  //编号
							Q.hn = $(this).attr('hn').replace(/\s+/g, "");      //主队
							Q.gn = $(this).attr('gn').replace(/\s+/g, "");      //客队
							Q.mname = $(this).attr('mname');//联赛名称
							Q.cl = $(this).attr('cl');      //联赛颜色
							Q.mtime = $(this).attr('mtime').substr(5,11);//比赛时间
							Q.hm = $(this).attr('hm');      //主队联赛排名
							Q.gm = $(this).attr('gm');      //客队联赛排名
							Q.htn = $(this).attr('htn');    //主队战绩
							Q.gtn = $(this).attr('gtn');    //客队战绩
							Q.oh = $(this).attr('oh');      //平均欧指 主
							Q.od = $(this).attr('od');      //平均欧指 平
							Q.oa = $(this).attr('oa');      //平均欧指 客
							Q.htid = $(this).attr('htid');  //主队编号
							Q.gtid = $(this).attr('gtid');  //客队编号
							arr.push(Q);
						});
						lzcData[pid].arr = arr;
						o.render(pid);
					}
				});
			},
			//计算注数
			getCount : function () {
				g.count = CP.math.N1(spArr, s[lotteryType].max);
				$('#lot_cur_zhushu').html(g.count);
				g.amount = 2*g.count*g.bet
				$('#lot_cur_money').html(g.amount);
			},
			clear_ : function () {
				$('#item').find('.cur').removeClass('cur');
				o.field_();
				g.bet = 1;
				g.count = 0;
				g.amount = 0;
			},
			next : function () {
				var Q = parseInt($('#lot_cur_match').html());
				if (Q < s[lotteryType].max) {
					alert('至少选择'+s[lotteryType].max+'场');
				} else {
					$('#jc_bs').val(g.bet);
					$('#lot_cur').html(Q);//已选多少场
    				$('#jczq_mask').show();
					$('#jc_footer').addClass('jc_footer');
					o.getCount();
				}
			},
			//已选多少场
			field_ : function () {
				var Q1 = 0;//多少场
				spArr = [];
				param = [].slice.call($('#item ul')).map(function (o) {
					var Q = $(o).find('.cur').length || '#';
					if (Q != '#') {
						spArr.push($(o).find('.cur').length);
						Q1++;
						Q = [].slice.call($(o).find('.cur')).map(function (t) {
							return $(t).attr('my-data');
						}).join('');
					}
					return Q;
				});
				$('#lot_cur_match').html(Q1);
			},
			bind_ : function () {
				//投注选项
				$('#item').off().Touch({children:"span[my-data]", fun:function(el) {
						$(el).toggleClass('cur');
						o.field_();//已选多少场
					}
				});
				$('#item').Touch({children:"li.wangwei", fun:function(el) {
					$(el).parent().next().slideToggle();
					$(el).find('i').toggleClass('down');
					}
				});
				o.clear_();
			},
			bind : function () {
				$('#dobuy').bind(start_ev,function(){o.dobuy();});//代购
				$('#dohm').bind(start_ev,function(){o.dobuy('hm');});//发起合买
				$('#hmSubmit').bind(start_ev,function(){
					if(parseInt($('#rg').val()) < g.totalMoney*0.05){return;}
					o.dopay('hm');});//提交合买
				$('#jc_next').on(start_ev, 'em', function (){//清空
					o.clear_();
				}).on(start_ev, 'a', function () {//下一步
					$('#jczq_mask').one('click', function () {
	    				$('#jczq_mask, #chuan_point').hide();
	    				$('#jc_footer').removeClass('jc_footer');
					});
					o.next();
				});
				//切换当前期&预售期
				$('#qici_lzc').delegate('li', start_ev, function () {
					if($(this).is('.cur')){
						return
					}
					$(this).addClass('cur').siblings().removeClass('cur');
					$('#item').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em><div style="text-align: center; padding: 10px;">加载对阵中，请稍候</div></div>');
					var Q = $(this).attr('v');
					if (!lzcData[Q]) {
						o.init(Q);
					} else {
						o.render(Q);
					}
				});
				$('#jc_bs').KeyBoard({
					val : 1,
					max : 50000,
					min : 1,
					num : 1,
					tag : '倍',
					fn  : function(){g.bet=$(this.ts).val();o.getCount();}
				});
				$('#jc_close').bind('click', function () {//X按钮
					$('#jc_footer').removeClass('jc_footer');
					$('#jczq_mask').hide();
				});
				/*合买事件[[*/
				$('#rg').on('keyup',function(){//认购 
					var bd_ = parseInt($('#bd').val());
					if($(this).val() >= g.amount){
						$(this).val(g.amount);
						$("#rg_bl").html("100%");
					}else{
						if($(this).val() == ''){
							$("#rg_bl").html("0%");
						}else{
							$("#rg_bl").html(Math.floor((parseInt($('#rg').val())/g.amount)*10000)/100+"%");
						}
					}
					if(!$("#chk").hasClass("nocheck") || parseInt($(this).val())+bd_>g.amount){
						if($(this).val() == ''){
							$('#bd').val(g.amount);
							$("#bd_bl").html('100%');
						}else{
							$('#bd').val(g.amount-parseInt($(this).val()));
							$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
						}
					}
					o.hmDet();
				}).on('change',function(){//认购 小于5% 提示
					var t = $(this).val();
					if(t == ''){t=0;}
					if(parseInt(t) < g.amount*0.05){
						alert('认购金额不能小于5%');
						$(this).val(Math.ceil(g.amount*0.05));
						$("#rg_bl").html(Math.floor((parseInt($("#rg").val())/g.amount)*10000)/100+"%");
					}
					if(!$("#chk").hasClass("nocheck")){
						$('#bd').val(g.amount-parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
					}
					o.hmDet();
				});
				$('#bd').on('keyup',function(){//保底 
					var rg_ = parseInt($('#rg').val());
					(parseInt($(this).val()) > g.amount-rg_) && $(this).val(g.amount-rg_);
					if($(this).val() == ''){
						$("#bd_bl").html("0%");
					}else{
						$(this).val(parseInt($(this).val()));
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
					}
					o.hmDet();
				}).on('change',function(){//保底等于空
					if($(this).val() == ''){
						$(this).val('0');
						$("#bd_bl").html("0%");
						o.hmDet();
					}
				});
				$('#chk').bind(start_ev,function(){
					var rg_ = parseInt($('#rg').val());
					$(this).toggleClass('nocheck');
					if(!$("#chk").hasClass("nocheck")){//全额保底
						$("#bd").attr('disabled',true);
						$("#bd").val(g.amount-rg_);
						$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.amount)*10000)/100+"%");
					}else{
						$("#bd").removeAttr('disabled');
					}
					o.hmDet();
				});
				$('#ratio li,#isPublic li').on(start_ev, function(){//提成   是否公开 点击事件
					!$(this).hasClass('cur') && $(this).toggleClass('cur');
					$(this).siblings().removeClass('cur');
				});
				/*]]合买事件*/
				
				/*摇一摇[[*/
				Shake.run(function(){});
				/*摇一摇]]*/
			},
			/*获取购买的各种参数 [[*/
			getArgument : function(t){
				var buy = {};
				switch(t){
					/* 1:自购 2:合买  */
					case 1:
						buy = {//投注参数
								payUrl:    '/trade/pcast.go',//投注接口
								gid:       s[lotteryType].lotid,//彩种id
								pid:       g.qihao_id,//期号
								codes:     param+':1:1',//投注内容
								muli:      g.bet,//倍数
								countMoney:g.amount,//方案金额
								orderType:'dg'//代购
						};
						break;
					case 2:
						buy = {//投注参数
							payUrl:    '/trade/pcast.go',//投注接口
							gid:       s[lotteryType].lotid,//彩种id
							pid:       g.qihao_id,//期号
							codes:     param+':1:1',//投注内容
							muli:      g.bet,//倍数
							desc:      $('#hmDesc').val() || '快乐购彩、欧耶！',//方案宣传
							countMoney:g.amount,//方案金额
							bnum:      $('#rg').val(),//认购
							pnum:      $('#bd').val(),//保底
							oflag:     $('#isPublic .cur').attr('v') || 0,//公开状态
							wrate:     $('#ratio .cur').attr('v') || 5,//提成比例
							orderType:'hm'//代购
						};
						break;
				}
				return buy;
			},
			/*获取购买的各种参数 ]]*/
			
			/*拼凑购买弹窗需要的参数[[*/
			dopay : function(t){
				t ? g.buyType=2 : g.buyType=1;//合买、自购
				var _obj = o.getArgument(g.buyType);
				var cMoney = '';
				t ? cMoney = g.hmMoney : cMoney = g.amount;//应付金额
				var data = {//支付弹框参数
						gid:     s[lotteryType].lotid,//彩种id
						cMoney:  cMoney,//需支付金额
						payPara: _obj//jQuery.param(param)
				};
				alert('提交中，请稍后！','loading');
				CP.User.info(function(options){
					!t && $('#jc_close').click();//代购的时候关闭选择过关方式的层
					remove_alert();
					if (options) {jQuery.extend(data, options);}
					CP.Popup.buybox(data);
				});
			},
			/*购买弹窗]]*/
			
			/*购买验证[[*/
			dobuy : function(t){
				var info = '';
				if($('#jc_bs').val()<1){
					info = '请输入倍数';
				}
				if(info!=''){alert(info);return;}
				if(t){window.location.href = "#type=fun&fun=CP.LZC.doHm";}else{o.dopay();}
			}
			/*购买验证]]*/
			
	};
	var grade = function(){
    	var grade = parseInt(localStorage.getItem("grade"))
		if(grade>0){
			$("#dobuy").html("立即预约")
		}
    }
	var init = function () {
		grade();
		o.pageGo.goBack();
		o.init();
		o.bind();
	};
	return {
		grade:grade,
		init : init,
		pageGo : o.pageGo,
		doHm : o.doHm
	};
})();
function resetPage(){//登录或合买的回调函数
	$('#content_home').show();//登录完之后显示投注层
	$('#box_header').addClass('zcHeader');
	CP.LZC.pageGo.goBack();
	CP.LZC.grade();
	$("#betball, #jc_footer, #jczq_mask").show();
	$('#bethm').hide();
}
$(function () {
	CP.LZC.init();
});
