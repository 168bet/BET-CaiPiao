CP.SZC = (function(){
	var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//彩种简称 
	var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	var s = {
		'ssq':{'red':33,'blue':16,'miniRedNum':6,'maxRedNum':20,'miniBlueNum':1,'count':5,'lot_id':'01','name':'双色球'},
		'dlt':{'red':35,'blue':12,'miniRedNum':5,'maxRedNum':20,'miniBlueNum':2,'count':5,'lot_id':'50','name':'大乐透'},
		'qlc':{'red':30,'blue':0,'miniRedNum':7,'maxRedNum':30,'miniBlueNum':0,'count':5,'lot_id':'07','name':'七乐彩'}
	};
	var last_update = 0;//摇一摇之后的时间
	var g = {
		'zhushu' : 0,//注数
		'beishu' : 1,//倍数
		'qishu' : 1,//追号期数
		'totalMoney' : 0,//投注总金额
		'zhuijia' : 2,//是否追加 追加为3 不追加为2
		'codes' : '',//投注号码
		'buyType' : 1,//1:自购 2:合买3:追号
		'loty_id' : s[lotteryType]['lot_id'], //彩种id
		'qihao_id' : '',//当前期号
		'hmMoney' : ''//合买应付金额
	};
	var $dom = {
		$ballRed : $('#ball_red'),//红球区域
		$ballBlue : $('#ball_blue'),//蓝球区域
		$btnRandom : $('#shake'),//机选一注|选号区
		$btnRandom1 : $('#jxbtn'),//机选一注|投注列表区
		$clearAll : $('#clearAll'),//清空投注列表区
		$curCount : $('#Notes'),//注数
		$curAmount : $('#Money'),//金额
		$clearBall : $('#deleted'),//清空高亮
		$totalCount : $('#countNotes'),//总注数
		$totalAmount : $('#countMoney'),//总金额
		$issueInfo : $('#issue_info'),//当前期号
		$kjslide : $('#kj_slide'),//开奖列表
		$addList : $('#addlist'),//添加到投注列表
		$betList : $('#bet_list'),//投注列表
		$lotFooter : $('#lot_footer'),//购买区域
		$tboxBeishu : $('#tbox_beishu'),//倍数
		$tboxQishu : $('#tbox_qishu'),//期数
		$hand : $('#hand'),//切换到手动选号
		$dobuy : $('#dobuy'),//代购按钮
		$dohm : $('#dohm'),//发起合买按钮
		$hmSubmit : $('#hmSubmit')//提交合买按钮
	};
	var o = {
		/*点击球[[*/
		clickBall : function(_this,on){
			$(_this).is('.'+on)?$(_this).removeClass():$(_this).addClass(on).addClass('ball_scale');//添加类名
			o.countTotal();//计算注数、金额
		},
		/*点击球]]*/

		/*高亮球 [[*/
		highLight : function(_arr,dom){
			o.clear($(dom+' cite'));//清除原有高亮球
			for(var j=0,l1=_arr.length;j<l1;j++){
				$(dom+' cite').eq(parseInt(_arr[j],10)-1).addClass('cur');
			}
		},
		/*高亮球 ]]*/

		/*清楚所有选号[[*/
		clear : function(dom){
			dom.each(function(){$(this).removeClass();});
			o.countTotal();//计算注数、金额
		},
		/*清楚所有选号]]*/

		/*机选[[*/
		jxNum : function(n,type){//n机选注数 type 投注列表/投注区 
			if(type){
				for(var i=1;i<=n;i++){
					var red = CP.Util.padArray(CP.math.random(1,s[lotteryType]['red'],s[lotteryType]['miniRedNum'],false)).sort(function(a,b){return a-b;});//机选红球
					var _code = '';//红蓝组合
					if(lotteryType == 'qlc'){
						_code += red;
					} else {
						var blue = CP.Util.padArray(CP.math.random(1,s[lotteryType]['blue'],s[lotteryType]['miniBlueNum'],false)).sort(function(a,b){return a-b;});//机选蓝球
						_code = red + '|' + blue;
					}
					o.addToList([_code, 1]);//添加到投注列表
					o.countAll();//统计总金额 注数
				}
				window.scrollTo(0,1);
				o.setLocal();
			}else{
				var red = CP.Util.padArray(CP.math.random(1,s[lotteryType]['red'],s[lotteryType]['miniRedNum'],false)).sort(function(a,b){return a-b;});//机选红球
				var blue = CP.Util.padArray(CP.math.random(1,s[lotteryType]['blue'],s[lotteryType]['miniBlueNum'],false)).sort(function(a,b){return a-b;});//机选蓝球
				o.highLight(red,'#ball_red');//高亮红球
				o.highLight(blue,'#ball_blue');//高亮蓝球
				o.countTotal();
			}
		},
		/*机选]]*/

		/*添加到投注列表[[*/
		addList : function(){
			var red = $dom.$ballRed.find('.cur').length;//红球数
			var blue = $dom.$ballBlue.find('.cur').length;//蓝球数
			if(!g.qihao_id){
				alert('期号获取失败!请刷新页面');return false;
			}else if(red<s[lotteryType]['miniRedNum']){//小于最小红球数
				if(lotteryType == "ssq"){
					alert('请至少选择6个红球');
				} else if(lotteryType == "dlt"){
					alert('至少选择5个红球，2个蓝球');
				} else if(lotteryType == "qlc"){
					alert('请至少选择7个球');
				}
				return false;
			}else if(red>s[lotteryType]['maxRedNum']){//大于最多红球数
				if(lotteryType == "ssq"){
					alert('最多投注20个红球');
				} else if(lotteryType == "dlt"){
					alert("最多投注20个前区号码");
				}
				return false;
			}else if(blue<s[lotteryType]['miniBlueNum']){//小于最小蓝球数
				if(lotteryType == "ssq"){
					alert('请至少选择1个蓝球');
				} else if(lotteryType == "dlt"){
					alert("至少选择5个红球，2个蓝球");
				}
				return false;
			}else{
				var _arrRed = o.getCode($dom.$ballRed);
				var _code = '';
				if(lotteryType == 'qlc'){
					_code += CP.Util.padArray(_arrRed);
				} else {
					var _arrBlue = o.getCode($dom.$ballBlue);
					_code = CP.Util.padArray(_arrRed) + '|' + CP.Util.padArray(_arrBlue);//组合红球蓝球 为投注格式
				}
				if($('#countNotes').text() == '0'){//如果列表那边么样注数的情况清空期数倍数
					$('#tbox_qishu').val('1');
					$('#tbox_beishu').val('1');
				}
				o.addToList([_code, g.zhushu]);
				window.location.href = "#type=fun&fun=CP.SZC.openList";
				o.setLocal();
			}
		},
		/*添加到投注列表]]*/

		/*获取号码区号码 组合成一注 [[*/
		getCode : function(dom){
			var _arr=[];
			for(var i=0;i<dom.find('.cur').length;i++){//遍历选中红球
				_arr[i] = dom.find('.cur').eq(i).text();
			}
			return _arr;
		},
		/*获取号码区号码 组合成一注 ]]*/

		/*组成号码到投注列表[[*/
		addToList : function(arr){
			var _html = '';
			_html = '<div class="ssqtzNum">';
			_html += '<cite class="errorBg"><em class="error2"></em></cite>';
			_html += '<span><em>'+arr[0].split('|')[0].replace(/,/g,' ')+'</em>';
			if(lotteryType != 'qlc'){
				_html += '<cite>'+arr[0].split('|')[1].replace(/,/g,' ')+'</cite>';
			}
			_html += '</span><p>普通投注&nbsp;&nbsp;&nbsp;'+arr[1]+'注'+2*arr[1]+'元</p>';
			_html += '<input type="hidden" value="'+arr[1]+'" name="bet_num" class="bet-num">';
			_html += '<input type="hidden" value="'+arr[0]+'" name="bet" class="bet">';
			_html += '</div>';
			$dom.$betList.prepend(_html);
			o.clear($('#ball_red cite,#ball_blue cite'));//清除原有高亮球
			$dom.$curCount.text(0);//投注注数金额为0
			$dom.$curAmount.text(g.zhushu=0);//投注注数金额为0
		},
		openList : function(){
			var grade = parseInt(localStorage.getItem("grade"))
			if(grade>0){
				$("#dobuy").html("立即预约")
			}
			if($(".cp-lot").length == 0){
				window.history.back();
				return 0;
			}
			/*设置导航左右按钮 [[*/
			$("#betball,#bethm").hide();
			$("#betlist").show();
			$('#lot_footer').removeClass('fo_basket fo_hm').addClass('fo_buy');//显示购买区块

			/*设置导航左右按钮 [[*/
			TopAnch.init({
				title:'投注列表',
				prevShow:true,
				prevFun:function(){//左侧按钮绑定事件	
					window.location.href = '#type=url&p=list/'+lotteryType+'.html';
				},
				isBack:true,
				nextShow:false,
				style:false
			});
			o.countAll();//统计总金额 注数
			window.scrollTo(0,1);
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
		doHm : function(){
			/*显示合买[[*/
			$("#betball,#betlist").hide();
			$('#bethm').show();
			$('#lot_footer').removeClass('fo_basket fo_buy').addClass('fo_hm');//显示购买区块
			/*]]显示合买*/
			
			/*设置导航左右按钮 [[*/
			TopAnch.init({
				title:'发起合买',
				prevShow:true,
				prevFun:function(){//左侧按钮绑定事件					
					window.location.href = '#type=fun&fun=CP.SZC.openList';
				},
				isBack:true,
				nextShow:false,
				style:false
			});
			
			$('#hmDet cite').eq(0).html(g.zhushu);//注数
			$('#hmDet cite').eq(1).html(g.beishu);//倍数
			$('#hmDet cite').eq(2).html(g.totalMoney);//总金额
			
			$("#rg").val(Math.ceil(g.totalMoney*0.05));
			$("#rg_bl").html(Math.floor(($('#rg').val()/g.totalMoney)*10000)/100+"%");
			$("#bd").removeAttr('disabled');
			$("#bd").val('0');
			$("#bd_bl").html('0%');
			o.hmDet();
		},
		//选球页面统计
		countTotal : function(){
			var red = 0,blue = 0;
			red = $dom.$ballRed.find('.cur').length;
			blue = $dom.$ballBlue.find('.cur').length;
			g.zhushu = CP.math.C(red,s[lotteryType]['miniRedNum'])*CP.math.C(blue,s[lotteryType]['miniBlueNum']);//计算注数 cp.math.c(已选球数,最低球数)
			g.money = g.zhushu*g.zhuijia;      //选球页面的金额
			$dom.$curCount.text(g.zhushu);     //显示注数数到页面
			$dom.$curAmount.text(g.money);     //显示投注金额数到页面
			if(g.zhushu){
				$dom.$curCount.addClass('red');
				$dom.$curAmount.addClass('red');
			} else {
				$dom.$curCount.removeClass('red');
				$dom.$curAmount.removeClass('red');
			}
		},
		/*列表页面统计总金额 总注数[[*/
		countAll : function(){
			var zhushu = 0;
			g.beishu = $dom.$tboxBeishu.val();
			g.qishu = $dom.$tboxQishu.val();
			var codes=[];
			$('#bet_list .bet-num').each(function(e){
				zhushu += parseInt($(this).val());//计算投注区域总注数
				codes.push($(this).next().val());
			});
			g.codes=codes.join(";");
			$dom.$totalCount.html((g.zhushu=zhushu));
			$dom.$totalAmount.html(g.totalMoney=g.zhushu*g.zhuijia* g.beishu*g.qishu);
		},
		/*统计总金额 总注数]]*/

		/*获取购买的各种参数 [[*/
		getArgument : function(t){
			var buy = {};
			var code = CP.Util.joinString(g.loty_id, g.codes);//code值拼接
			switch(t){
				/* 1:自购 2:合买 3:追号 */
				case 1:
					buy = {//投注参数
							payUrl:    '/trade/pcast.go',//投注接口
							gid:       g.loty_id,//彩种id
							pid:       g.qihao_id,//期号
							codes:     code,//投注内容
							muli:      g.beishu,//倍数
							countMoney:g.totalMoney,//方案金额
							orderType:'dg'//代购
					};
					break;
				case 2:
					buy = {//投注参数
						payUrl:    '/trade/pcast.go',//投注接口
						gid:       g.loty_id,//彩种id
						pid:       g.qihao_id,//期号
						codes:     code,//投注内容
						muli:      g.beishu,//倍数
						desc:      $('#hmDesc').val() || '快乐购彩、欧耶！',//方案宣传
						countMoney:g.totalMoney,//方案金额
						bnum:      $('#rg').val(),//认购
						pnum:      $('#bd').val(),//保底
						oflag:     $('#isPublic .cur').attr('v') || 0,//公开状态
						wrate:     $('#ratio .cur').attr('v') || 5,//提成比例
						orderType:'hm'//代购
					};
					break;
				case 3:
					var muli = '', pid = g.qihao_id;
					for(var i=0;i<g.qishu;i++){muli += g.beishu+',';pid += ',';}
					pid = pid.substring(0, pid.length-1);
					muli = muli.substring(0, muli.length-1);
					buy = {//投注参数
						payUrl:    '/trade/zcast.go',//投注接口
						gid:       g.loty_id,//彩种id
						pid:       pid,//期号串
						codes:     code,//投注内容
						muli:      muli,//倍数串
						countMoney:g.totalMoney,//追号总金额
						zflag : $('.zjStop em').hasClass('nocheck')? '0' : '1',//中奖标识0  中奖不停止  1  中奖停止  3 盈利停止
						orderType:'zh'//追号
					};
					break;
			}
			return buy;
		},
		/*获取购买的各种参数 ]]*/

		/*拼凑购买弹窗需要的参数[[*/
		dopay : function(t){
			g.qishu=parseInt($dom.$tboxQishu.val());
			g.qishu>1? g.buyType=3: (t ? g.buyType=2 : g.buyType=1);//追号、合买、自购
			var _obj = o.getArgument(g.buyType);
			var cMoney = '';
			t ? cMoney = g.hmMoney : cMoney = g.totalMoney;
			var data = {//支付弹框参数
					gid:     g.loty_id,//彩种id
					cMoney:  cMoney,//需支付金额
					payPara: _obj//jQuery.param(param)
			};
			alert('提交中，请稍后！','loading');
			CP.User.info(function(options){
				remove_alert();
				if (options) {jQuery.extend(data, options);}
				CP.Popup.buybox(data);
			});
			sessionStorage.removeItem(lotteryType);
		},
		/*购买弹窗]]*/
		
		/*购买验证[[*/
		dobuy : function(t){
			var info = '';
			if(g.zhushu<1){//投注列表没有内容
				info = '请至少选择一注彩票';
			}else if(!g.qishu){
				info = '请输入期数';
			}else if(!g.beishu){
				info = '请输入倍数';
			}
			if(info!=''){alert(info);return}
			if(t){window.location.href = "#type=fun&fun=CP.SZC.doHm";}else{o.dopay();}
		},
		/*购买验证]]*/
		
		//存储在本地
		setLocal : function(){
			var codes=[];
			$("#bet_list .bet:input").each(function(){
				codes.push($(this).val());
			});
			g.codes=codes.join(";");
			CP.Storage.set(lotteryType,g.codes,true); //存list(json)到sessionStorage
		},
		//sessionStorage数据恢复到投注列表
		fromLocal : function(){
			var _json = CP.Storage.get(lotteryType,true);
			if(_json)
			{
				try{
					g.codes = _json;
					var codes = _json.split(";");

					for(var i=0,l=codes.length;i<l;i++)
					{
						var _arr =  codes[i].split('|');
						o.addToList([codes[i], CP.math.C(_arr[0].split(',').length,s[lotteryType]['miniRedNum'])*CP.math.C(_arr[1].split(',').length,s[lotteryType]['miniBlueNum'])]);
					}
					o.countAll();
				}
				catch(e){
					sessionStorage.removeItem(lotteryType);
				}
			}
		},
		/*请求期号接口[[*/
		getQihao:function(callback){
			if(callback){
				$.ajax({
					url:CP.Data.apps+'/trade/info.go?gid='+g.loty_id,
					dataType:'xml',
					cache:true,
//					async:callback?false:true,
					success: function(xml) {
						var data = {},issueInfo = [],miss_ = {};
						var R = $(xml).find('rows');
						data.pid = R.attr('pid');//
						data.atime = R.attr('atime');//开奖时间
						data.tn = R.attr('tn');//购买状态
						data.now = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
						o.renderQihao(data);
						var rp = R.find('rowp');
						rp.each(function(a){
							var t = {};
							t.pid = $(this).attr('pid');//期号
							t.acode = $(this).attr('acode');//开奖号码
							t.tn = $(this).attr('tn');//认购状态
							issueInfo[a] = t;
						});
						if(lotteryType == 'ssq' || lotteryType == 'dlt'){//双色球和大乐透遗漏
							var r = R.find('row');
							r.each(function(){
								var color = $(this).attr('color');
								var curyl = $(this).attr('curyl');
								if(color == 'red'){
									miss_.red = curyl;
								}else{
									miss_.blue = curyl;
								}
							});
							o.miss(miss_);
							$('#yl').bind(start_ev,function(){
								if($(this).find('.omitico').hasClass('omitico2')){
									$(this).removeClass('red').addClass('gray');
									$dom.$ballRed.find('.omitnum').hide();
									$dom.$ballBlue.find('.omitnum').hide();
								}else{
									$(this).removeClass('gray').addClass('red');
									$dom.$ballRed.find('.omitnum').show();
									$dom.$ballBlue.find('.omitnum').show();
								}
								$(this).find('.omitico').toggleClass('omitico2');
							});
						}
						callback(issueInfo);
					},
					error:function(){
						$dom.$issueInfo.html('网络不通畅，请点击刷新');
						$dom.$issueInfo.bind(end_ev,function(){
							window.location.reload();
						});
					}
				});
			}else{
				return false;
			}
		},
		/*]]请求期号接口*/

		/*渲染期号信息[[*/
		renderQihao:function(data){
			g.qihao_id=data.pid;  //设置当前期号
			var wk=["日","一","二","三","四","五","六"];
			var now = CP.calcTime(data.now,'+8');
			var et = data.atime;
			var severtime = now.getFullYear()+'-'+CP.Util.pad(now.getMonth()+1,2)+'-'+CP.Util.pad(now.getDate(),2);
			var et1 = et.substr(11,5),et2 = et.substr(0,10),et3 = et.substr(5,6);
			var timeText = '';
			timeText = CP.Util.dateDiff(severtime,et2);
			timeText = {'0':'今天','1':'明天','2':'后天'}[timeText]||et3;
			var tDATE = et.substr(0,10);
			tDATE = new Date(tDATE);
			var wk2 = '周'+wk[tDATE.getDay()];
			if(timeText!=''){
				$dom.$issueInfo.html('第 '+data.pid+' 期 '+ timeText +''+ et1 +'('+wk2+') 截止');
				return true;
			}else{
				return false;
			}
		},
		/*]]渲染期号信息*/

		/*遗漏[[*/
		miss: function(data){//data.red红球遗漏 -data.blue篮球遗漏
			var redcuryl = data.red.split(',');
			var bluecuryl = data.blue.split(',');
			for(var n=0,rl=redcuryl.length; n<rl; n++){
				$dom.$ballRed.find('.omitnum cite').eq(n).html(redcuryl[n]);
			}
			for(var n=0,bl=bluecuryl.length; n<bl; n++){
				$dom.$ballBlue.find('.omitnum cite').eq(n).html(bluecuryl[n]);
			}
		},
		/*]]遗漏*/
		
		/*获取期号数据[[*/
		getTime : function(){
			o.getQihao(function(data){
				var t = data.length,kjhtml='';
				for(var n=0; n<t; n++){
					var red = data[n].acode.split('|')[0];
					var blue = data[n].acode.split('|')[1];
					red = red.replace(/,/g,' ');
					blue = blue.replace(/,/g,' ');
					kjhtml += '<ul><li class="first">'+data[n].pid.substr(4,3)+'期</li><li><span class="red">'+red+'</span>&nbsp;<span class="blue">'+blue+'</span></li></ul>';
				}
				$dom.$kjslide.next().html(kjhtml);
			});
		},
		/*]]获取期号数据*/
		
		//重新设置style
		reStyle:function(){
			var winHeight = $(window).height();//获取window高度
			var box_header_height = $(".tzHeader").height();//title高度
			var buyFooterHeight = $(".buyFooter").height();//buyFooter的高度
			var tmpHeight = winHeight -46;
			alert(buyFooterHeight+"~~~")
			
			$(".cp-lot").height(tmpHeight);
			$("#content_home").height(tmpHeight);
			$(".absolutmain").height(tmpHeight-buyFooterHeight)
			$(".absolutmain").css("bottom",buyFooterHeight)
			//$(".buyFooter").css("height",buyFooterHeight);
		}
	};
	var bind = function(){
		o.getTime();//获取系统时间
		$dom.$ballRed.find('div:eq(0) cite').Touch({fun:function(el){ o.clickBall(el,'cur');}});
		$dom.$ballBlue.find('div:eq(0) cite').Touch({fun:function(el){o.clickBall(el,'cur');}});
		$dom.$btnRandom.bind(start_ev,function(){o.jxNum(1,0);});//机选1注
		$dom.$btnRandom1.bind(start_ev,function(){o.jxNum(1,1);});//机选1注|投注列表机选
		$dom.$clearBall.bind(start_ev,function(){o.clear($('#ball_red cite'));o.clear($('#ball_blue cite'));});//清空
		$dom.$kjslide.bind(start_ev,function(){//显隐开奖列表
			if($(this).find('.ssqup').hasClass('ssqdown')){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
			$(this).find('.ssqup').toggleClass('ssqdown');
		});
		$dom.$addList.bind("click",function(){o.addList();});//添加到投注列表
		$dom.$hand.bind(start_ev,function(){location.href='#type=url&p=list/'+lotteryType+'.html';});//切换到手动选号
		$dom.$clearAll.bind(start_ev,function(){
			$dom.$betList.html('');
			$("#tbox_qishu").val("1");
			$("#tbox_beishu").val("1");
			CP.Storage.remove(lotteryType,true);
			o.countAll();//统计总金额 注数
			if(g.qishu>1){
				$('#dohm').addClass('fqhmGray');
				$('.zjStop').show();
			}else{
				$('#dohm').removeClass('fqhmGray');
				$('.zjStop').hide();
			}
		});//清空投注列表
		$dom.$dobuy.bind(start_ev,function(){o.dobuy();});//代购
		$dom.$dohm.bind(start_ev,function(){!$(this).hasClass('fqhmGray') && o.dobuy('hm');});//发起合买
		$dom.$hmSubmit.bind(start_ev,function(){
			if(parseInt($('#rg').val()) < g.totalMoney*0.05){return;}
			o.dopay('hm');});//提交合买
		$dom.$betList.delegate('.errorBg',end_ev,function(){
			var del = $(this).parent();
			del.addClass('del');
			setTimeout(function(){
				del.remove();
				o.countAll();
				o.setLocal();
			},400);
			
		});//删除单注    
		/*绑定倍数、期数初始值[[*/
        var buyTimes = 1;
        var zuiqishuNum = 1;
		$dom.$tboxBeishu.KeyBoard({
			val : buyTimes,
			max : 999,
			min : 1,
			num : 1,
			tag : '倍',
			fn  : function(){g.beishu=$(this.ts).val();o.countAll();}
		});
		$dom.$tboxQishu.KeyBoard({
			val : zuiqishuNum,
			max : 10,
			min : 1,
			num : 1,
			tag : '期',
			fn  : function(){
				g.qishu=$(this.ts).val();
				if(g.qishu>1){
					$('#dohm').addClass('fqhmGray');
					$('.zjStop').show();
				}else{
					$('#dohm').removeClass('fqhmGray');
					$('.zjStop').hide();
				}
				o.countAll();
			}
		});
		$('.zjStop').bind(start_ev, function () {
			$(this).find('em').toggleClass('nocheck check');
		});
		/*合买事件[[*/
		$('#rg').on('keyup',function(){//认购 
			var bd_ = parseInt($('#bd').val());
			if($(this).val() >= g.totalMoney){
				$(this).val(g.totalMoney);
				$("#rg_bl").html("100%");
			}else{
				if($(this).val() == ''){
					$("#rg_bl").html("0%");
				}else{
					$("#rg_bl").html(Math.floor((parseInt($('#rg').val())/g.totalMoney)*10000)/100+"%");
				}
			}
			if(!$("#chk").hasClass("nocheck") || parseInt($(this).val())+bd_>g.totalMoney){
				if($(this).val() == ''){
					$('#bd').val(g.totalMoney);
					$("#bd_bl").html('100%');
				}else{
					$('#bd').val(g.totalMoney-parseInt($(this).val()));
					$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.totalMoney)*10000)/100+"%");
				}
			}
			o.hmDet();
		}).on('change',function(){//认购 小于5% 提示
			var t = $(this).val();
			if(t == ''){t=0;}
			if(parseInt(t) < g.totalMoney*0.05){
				alert('认购金额不能小于5%');
				$(this).val(Math.ceil(g.totalMoney*0.05));
				$("#rg_bl").html(Math.floor((parseInt($("#rg").val())/g.totalMoney)*10000)/100+"%");
			}
			if(!$("#chk").hasClass("nocheck")){
				$('#bd').val(g.totalMoney-parseInt($(this).val()));
				$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.totalMoney)*10000)/100+"%");
			}
			o.hmDet();
		});
		$('#bd').on('keyup',function(){//保底 
			var rg_ = parseInt($('#rg').val());
			(parseInt($(this).val()) > g.totalMoney-rg_) && $(this).val(g.totalMoney-rg_);
			if($(this).val() == ''){
				$("#bd_bl").html("0%");
			}else{
				$(this).val(parseInt($(this).val()));
				$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.totalMoney)*10000)/100+"%");
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
				$("#bd").val(g.totalMoney-rg_);
				$("#bd_bl").html(Math.ceil((parseInt($("#bd").val())/g.totalMoney)*10000)/100+"%");
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
		Shake.run(function(){
			var curTime = new Date().getTime();
			if ((curTime - last_update) > 1500 && $('#betball').is(':visible')) {
				$('.mask2').show();
				o.clear($('#ball_red cite'));
				o.clear($('#ball_blue cite'));
				imitate();
				last_update = curTime;
			}
		});
		/*摇一摇]]*/
	};
	/*模拟QQ彩票摇一摇效果-*/
	var imitate = function(){
		var left_ = 5;
		var ratio = (90/7).toFixed(2);
		var delay = .1;
		var tfb = delay*1000*7+500;
		var red = CP.math.random(1,s[lotteryType]['red'],s[lotteryType]['miniRedNum'],false).sort(function(a,b){return a-b;});
		
		for(var i=1; i<=s[lotteryType]['miniRedNum']; i++){
			$('body').append('<div class=ssq1 style="left:'+left_+'%;-webkit-animation-delay: '+delay * i+'s;animation-delay: '+delay * i+'s;">'+CP.Util.pad(red[i-1],2)+'</div>');
			left_ += parseFloat(ratio);
		}
		if(lotteryType != 'qlc'){//七乐彩没篮球
			var blue = CP.math.random(1,s[lotteryType]['blue'],s[lotteryType]['miniBlueNum'],false).sort(function(a,b){return a-b;});
			for(var i=1; i<=s[lotteryType]['miniBlueNum']; i++){
				$('body').append('<div class="ssq1 ssqblue" style="left:'+left_+'%;-webkit-animation-delay: '+delay*(i+6)+'s;animation-delay: '+delay*(i+6)+'s;">'+CP.Util.pad(blue[i-1],2)+'</div>');
				left_ += parseFloat(ratio);
			}
		}
		setTimeout(function(){
			goto_();
		},tfb);
	};
	var goto_ = function(){
		var num,l,t,this_;
		var red = [],blue=[];
		$('.ssq1').each(function(aa){
			num = parseInt($(this).text(),'10');
			num -= 1;
			if(aa<s[lotteryType]['miniRedNum']){
				this_ = $('#ball_red cite').eq(num);
				red.push(num);
			}else{
				this_ = $('#ball_blue cite').eq(num);
				blue.push(num);
			}
			t = this_.offset().top;
			l = this_.offset().left;
			$(this).animate({left:l,top:t},300);
		});
		setTimeout(function(){
			for(var s in red){
				$('#ball_red cite').eq(red[s]).addClass('cur');
			}
			for(var s in blue){
				$('#ball_blue cite').eq(blue[s]).addClass('cur');
			}
			$('.ssq1').remove();
			$('.mask2').hide();
			o.countTotal();
		},.25e3);
	};
	/*-模拟QQ彩票摇一摇效果*/
	var init = function(){
		o.fromLocal();
		TopAnch.init({
			title:s[lotteryType]['name'],
			prevShow:true,
			prevFun:function(){//左侧按钮绑定事件
				window.location.href = '#type=index';
			},
			menu:[{'name':'投注选号','url':'javascript:;','cur':true},
			      //{'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot(s[lotteryType].lot_id, 2),'cur':false},
			      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_='+s[lotteryType].lot_id,'cur':false},
			      {'name':'玩法帮助','url':'#type=url&p=wf/'+lotteryType+'.html','cur':false}],
			      style:false
		});
		bind();
	};
	//荣耀墙随机出的号获取
	var getGloryDatd=function(){
		var getDajiangfudi=sessionStorage.getItem('BigMoney');
		if(getDajiangfudi!=''&&getDajiangfudi!=null){
			var data=getDajiangfudi.split(',');
			for(var i in data ){if(i!=(data.length-1)){
				$(".ssqBall").not('.ssqblueBall').find('cite:contains("'+data[i]+'")').trigger("touchend")
			}else{
				$(".ssqBall.ssqblueBall").find('cite:contains("'+data[i]+'")').trigger("touchend")
			}}
			sessionStorage.removeItem('BigMoney')
		}
	}
	return {
		openList : o.openList,
		doHm : o.doHm,
		s : s,
		lotteryType:lotteryType,
		init:init,
		getGloryDatd:getGloryDatd
	};
})();
function resetPage(){
	TopAnch.init({
		title:CP.SZC.s[CP.SZC.lotteryType]['name'],
		prevShow:true,
		prevFun:function(){//左侧按钮绑定事件
			window.location.href = '#type=index';
		},
		menu:[{'name':'投注选号','url':'javascript:;','cur':true},
		      {'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot(CP.SZC.s[CP.SZC.lotteryType].lot_id, 2),'cur':false},
		      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_='+CP.SZC.s[CP.SZC.lotteryType].lot_id,'cur':false},
		      {'name':'玩法帮助','url':'#type=url&p=wf/'+CP.SZC.lotteryType+'.html','cur':false}],
		      style:false
	});
	$("#betball").show();
	$("#betlist,#bethm").hide();
	$('#lot_footer').removeClass('fo_buy fo_hm').addClass('fo_basket');//显示手动选号区块
}

$(function(){
	CP.SZC.init();

	CP.SZC.getGloryDatd()
});