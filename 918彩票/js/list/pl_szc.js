CP.PL = (function(){
	//获取内容标签下的第一个子标签的id
    var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//彩种简称 ssq|dlt  
    
    var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	
	//配置各个彩种的值
	var s = {
		'p5':{'red':9,'miniRedNum':1,'maxRedNum':11,'count':5,'lot_id':'52','name':'排列五'},
		'qxc':{'red':9,'miniRedNum':1,'maxRedNum':11,'count':7,'lot_id':'51','name':'七星彩'}
    };	
	/* 公用属性[[ */
	var last_update = 0;//摇一摇之后的时间
	var g = {
			'zhushu' : 0,//注数
			'beishu' : 1,//倍数
			'qishu' : 1,//追号期数
			'totalMoney' : 0,//投注总金额
			'zhuijia' : 2,//是否追加 追加为3 不追加为2
			'codes' : '',//投注号码
			'buyType' : 1,//1:自购 2:合买3:追号
			'loty_id' : s[lotteryType].lot_id, //彩种id
			'qihao_id' : '',//当前期号
			'hmMoney' : ''//合买应付金额
		};
	/* 公用属性]] */
	
	/* 公用方法[[ */
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
						menu:[{'name':'投注选号','url':'javascript:;','cur':true},
						      //{'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot(s[lotteryType].lot_id, 2),'cur':false},
						      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_='+s[lotteryType].lot_id,'cur':false},
						      {'name':'玩法帮助','url':'#type=url&p=wf/'+lotteryType+'.html','cur':false}],
						      style:false
					});
				}
			},
			
			//点击球方法
			clickBall:function(_this,on,lotteryType){
				$(_this).is("."+on)?$(_this).removeClass(on):$(_this).addClass(on);
				//计算金钱的方法
				o.countTotal();
			},
			
			//高亮球方法
			highLight:function(arr,dom){
				//清除高亮球
				o.clear($(dom+' b'));//清除原有高亮球
				
				//给球添加高亮
				for(var j=0,l1=_arr.length;j<l1;j++){
					$(dom+' b').eq(parseInt(_arr[j],10)-1).addClass('red');
				}
			},
			
			//清除高亮球方法
			clear:function(dom){
				dom.each(function(){$(this).removeClass();});
				
				o.countTotal();//计算注数、金额
			},
			
			/*机选[[*/
			jxNum : function(n,type){//n机选注数 type 投注列表/投注区 
				if(type){//参数type区分选号页面还是投注列表页面
					for(var i=1;i<=n;i++){
						if(lotteryType=="qxc"){
							var red = CP.math.random(0,9,7,true);//机选红球
						}else{
							var red = CP.math.random(0,9,5,true);//机选红球
						}
						
						var _code = '';//红蓝组合
							_code += red;
							o.addToList([_code, 1]);//添加到投注列表
							o.countAll();//统计总金额 注数
					}
					window.scrollTo(0,1);
					o.setLocal();
				}else{//表示选号页面
					if(lotteryType=="qxc"){
						var red = CP.Util.padArray(CP.math.random(0,9,7,true));//机选红球
					}else{
						var red = CP.Util.padArray(CP.math.random(0,9,5,true));//机选红球
					}
					
					o.clear($('#qxc .jxsscxhBall b'));//清除原有高亮球
					for(var j=0,l1=red.length;j<l1;j++){
						$('#qxc .jxsscxhBall').eq(j).find('p').find('b').eq(parseInt(red[j],10)-1).addClass('red');
					}
					o.countTotal();
				}
			},
			/*机选]]*/
			
			
			/*获取号码区号码 组合成一注 [[*/
			getCode : function(dom){
				var _arr=[];
				for(var i=0;i<dom.find("p").find('.red').length;i++){//遍历选中红球
					_arr[i] = dom.find("p").find('.red').eq(i).text();
				}
				return _arr;
			},
			/*获取号码区号码 组合成一注 ]]*/
			
			/*添加到投注列表[[*/
			addList : function(){
				if(!g.qihao_id){
					alert('期号获取失败!请刷新页面');return false;
				}else if($('#Notes').text() == '0'){//小于最小红球数
					alert('至少选择一注');
					return false;
				}else{
					var _arrRed = [];
					var _code = '';
					if(lotteryType == 'qxc'){
						//_code += CP.Util.padArray(_arrRed);
						var Q = o.getCode($('#qxc .jxsscxhBall').eq(0));
						var Q1 = o.getCode($('#qxc .jxsscxhBall').eq(1));
						var Q2 = o.getCode($('#qxc .jxsscxhBall').eq(2));
						var Q3 = o.getCode($('#qxc .jxsscxhBall').eq(3));
						var Q4 = o.getCode($('#qxc .jxsscxhBall').eq(4));
						var Q5 = o.getCode($('#qxc .jxsscxhBall').eq(5));
						var Q6 = o.getCode($('#qxc .jxsscxhBall').eq(6));
						_code = Q.join("") + ',' + Q1.join("") + ',' + Q2.join("")+ ',' +Q3.join("")+ ',' + Q4.join("")+ ',' + Q5.join("")+ ',' + Q6.join("");
					} else {
						var Q = o.getCode($('#qxc .jxsscxhBall').eq(0));
						var Q1 = o.getCode($('#qxc .jxsscxhBall').eq(1));
						var Q2 = o.getCode($('#qxc .jxsscxhBall').eq(2));
						var Q3 = o.getCode($('#qxc .jxsscxhBall').eq(3));
						var Q4 = o.getCode($('#qxc .jxsscxhBall').eq(4));
						_code = Q.join("") + ',' + Q1.join("") + ',' + Q2.join("")+ ',' +Q3.join("")+ ',' + Q4.join("");
					}
					if($('#countNotes').text() == '0'){//如果列表那边么样注数的情况清空期数倍数
						$('#tbox_qishu').val('1');
						$('#tbox_beishu').val('1');
					}
					o.addToList([_code, g.zhushu]);
					window.location.href = "#type=fun&fun=CP.PL.openList";
					o.setLocal();
				}
			},
			/*添加到投注列表]]*/
			
			/*组成号码到投注列表[[*/
			addToList : function(arr){
				var _html = '';
				_html += '<div class="ssqtzNum">';
				_html += '<cite class="errorBg"><em class="error2"></em></cite>';
				_html += '<span><em>'+arr[0].replace(/,/g,' ')+'</em>';
				_html += '</span>';
				_html += '<p>直选&nbsp;&nbsp;&nbsp;'+arr[1]+'注'+2*arr[1]+'元</p>';
				_html += '<input type="hidden" value="'+arr[1]+'" name="bet_num" class="bet-num">';
				_html += '<input type="hidden" value="'+arr[0]+'" name="bet" class="bet">';
				_html += '</div>';
				 $('#bet_list').prepend(_html);
				//o.clear($('#ball_red cite,#ball_blue cite'));//清除原有高亮球
				 o.clear($('#qxc .jxsscxhBall b'));//清除原有高亮球
				$("#Notes").text(0);//投注注数金额为0
				$("#Money").text(g.zhushu=0);//投注注数金额为0
			},
			
			//存储在本地
			setLocal : function(){
				var codes=[];
				$("#bet_list .bet:input").each(function(){
					codes.push($(this).val());
				});
				g.codes=codes.join(";");
				CP.Storage.set(lotteryType,g.codes,true); //存list(json)到sessionStorage
			},
			
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
					$('#issue_info').html('第 '+data.pid+' 期 '+ timeText +''+ et1 +'('+wk2+') 截止');
					return true;
				}else{
					return false;
				}
			},
			/*]]渲染期号信息*/
			
			
			/*请求期号接口[[*/
			getQihao:function(callback){
				if(callback){
					$.ajax({
						url:'/trade/info.go?gid='+g.loty_id,
						dataType:'xml',
						cache:true,
						async:callback?false:true,
						success: function(xml) {
							var data = {},issueInfo = [],miss_ = {};
							var R = $(xml).find('rows');
							data.pid = R.attr('pid');//期次
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
			
			
			/*获取期号数据[[*/
			getTime : function(){
				var kjhtml="";
				o.getQihao(function(data){
					var t = data.length,kjhtml='';
					for(var n=0; n<t; n++){
						var red = data[n].acode;
						//alert(red)
						red = red.replace(/,/g,' ');
						kjhtml += '<ul><li class="wb20">'+data[n].pid.substr(4,3)+'期</li><li class="wb25"><span class="red">'+red+'</span></li></ul>';
					}
					$(".k3kjlist").html(kjhtml);
				});
			},
			/*]]获取期号数据*/
			
			openList : function(){
				var grade = parseInt(localStorage.getItem("grade"))
				if(grade>0){
					$("#dobuy").html("立即预约")
				}
				
				/*设置导航左右按钮 [[*/
				$("#betball,#bethm").hide();
				$("#betlist").show();
				$('#lot_footer').removeClass('fo_basket fo_hm').addClass('fo_buy');//显示手动选号区块
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
			
			/*获取购买的各种参数 [[*/
			getArgument : function(t){
				var buy = {};
				var code = CP.Util.joinString(g.loty_id, g.codes);
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
				g.qishu=parseInt($("#tbox_qishu").val());
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
				if(t){window.location.href = "#type=fun&fun=CP.PL.doHm";}else{o.dopay();}
			},
			/*购买验证]]*/
			
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
						window.location.href = '#type=fun&fun=CP.PL.openList';
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
			
			//投注列表页面计算注数和金额
			countAll:function(){
				var zhushu = 0;
				g.beishu = $('#tbox_beishu').val();//倍数
				g.qishu = $('#tbox_qishu').val();//期数
				var codes=[];
				$('#bet_list .bet-num').each(function(e){
					zhushu += parseInt($(this).val());//计算投注区域总注数
					codes.push($(this).next().val());//获取每列的code值
				});
				g.codes=codes.join(";");
				$('#countNotes').html((g.zhushu=zhushu));
				$('#countMoney').html(g.totalMoney=g.zhushu*2* g.beishu*g.qishu);
			},
			
			//选球页面计算注数和金额
			countTotal:function(){
				var type=g.loty_id;
				var zs = 0,c1,c2,c3,c4,c5,c6,c7;
				if(type=="52"){//排5
					  c1 = $('#qxc div.jxsscxhBall:eq(0) p').find('b.red').length;
					  c2 = $('#qxc div.jxsscxhBall:eq(1) p').find('b.red').length;
					  c3 = $('#qxc div.jxsscxhBall:eq(2) p').find('b.red').length;
					  c4 = $('#qxc div.jxsscxhBall:eq(3) p').find('b.red').length;
					  c5 = $('#qxc div.jxsscxhBall:eq(4) p').find('b.red').length;
					  g.zhushu = zs = c1*c2*c3*c4*c5;
					  g.money=2*g.zhushu;
				}else{//七星彩
					  c1 = $('#qxc div.jxsscxhBall:eq(0) p').find('b.red').length;
					  c2 = $('#qxc div.jxsscxhBall:eq(1) p').find('b.red').length;
					  c3 = $('#qxc div.jxsscxhBall:eq(2) p').find('b.red').length;
					  c4 = $('#qxc div.jxsscxhBall:eq(3) p').find('b.red').length;
					  c5 = $('#qxc div.jxsscxhBall:eq(4) p').find('b.red').length;
					  c6 = $('#qxc div.jxsscxhBall:eq(5) p').find('b.red').length;
					  c7 = $('#qxc div.jxsscxhBall:eq(6) p').find('b.red').length;
					 
					  g.zhushu = zs = c1*c2*c3*c4*c5*c6*c7;
					  g.money=2*g.zhushu;
				}
				$("#Notes").html(g.zhushu);
				$("#Money").html(g.money);
				
				if(parseInt($("#Notes").html())>0){
					$("#Notes").addClass('red');
					$("#Money").addClass('red');
				} else {
					$("#Notes").removeClass('red');
					$("#Money").removeClass('red');
				}
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
			}
	};
	var bind = function () {
		o.getTime();//获取系统时间
		//$('#qxc').find('.jxsscxhBall p b').Touch({fun:function(el){alert("点击") o.clickBall(el,'red');}});
		$('#qxc').find('.jxsscxhBall p b').bind("click",function(){
			o.clickBall(this,'red');
		})
		
		$('#shake').bind(start_ev,function(){o.jxNum(1,0);});//机选1注
		
		
		$("#kj_slide").bind(start_ev,function(){//显隐开奖列表
			if($(this).find('.ssqup').hasClass('ssqdown')){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
			$(this).find('.ssqup').toggleClass('ssqdown');
		});
		
		$('#deleted').bind(start_ev,function(){o.clear($('#qxc .jxsscxhBall p b'));});//清空
		
		$('#addlist').bind("click",function(){o.addList();});//添加到投注列表
		
		$('#jxbtn').bind(start_ev,function(){o.jxNum(1,1);});//机选1注|投注列表机选
		
		$('#hand').bind(start_ev,function(){location.href='#type=url&p=list/'+lotteryType+'.html';});
		
		$('#dobuy').bind(start_ev,function(){o.dobuy();});//代购
		$('#dohm').bind(start_ev,function(){!$(this).hasClass('fqhmGray') && o.dobuy('hm');});//发起合买
		$('#hmSubmit').bind(start_ev,function(){
			if(parseInt($('#rg').val()) < g.totalMoney*0.05){return;}
			o.dopay('hm');});//提交合买
		
		$('#clearAll').bind(start_ev,function(){//清空投注列表
			$('#bet_list').html('');
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
		});
		$('#bet_list').delegate('.errorBg',end_ev,function(){//删除单注
			$(this).parent().remove();
			o.countAll();
			o.setLocal();
		});
		/*绑定倍数、期数初始值[[*/
        var buyTimes = 1;
        var zuiqishuNum = 1;
		$('#tbox_beishu').KeyBoard({
			val : buyTimes,
			max : lotteryType=="p5"?99:999,
			min : 1,
			num : 1,
			tag : '倍',
			fn  : function(){g.beishu=$(this.ts).val();o.countAll();}
		});
		$('#tbox_qishu').KeyBoard({
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
				o.clear($('#qxc .jxsscxhBall p b'));
				imitate();
				last_update = curTime;
			}
		});
		/*摇一摇]]*/
	};
	/*模拟QQ彩票摇一摇效果-*/
	var imitate = function(){
		var left_ = '5';//5%
		if(lotteryType == 'p5'){
			left_ = '17';//17%
		}
		var ratio = (90/7).toFixed(2);//球和球之间的间距
		var delay = .1;
		var tfb = delay*1000*s[lotteryType].count+500;
		var red = CP.math.random(0,s[lotteryType].red,s[lotteryType].count,true);
		for(var i=1; i<=s[lotteryType].count; i++){
			$('body').append('<div class=ssq1 style="left:'+left_+'%;-webkit-animation-delay: '+delay * i+'s;animation-delay: '+delay * i+'s;">'+red[i-1]+'</div>');
			left_ = parseFloat(left_) + parseFloat(ratio)
		}
		setTimeout(function(){
			goto_();
		},tfb);
	};
	var goto_ = function(){
		var num,l,t,this_;
		var red = [];
		$('.ssq1').each(function(aa){
			num = $(this).text();
			this_ = $('#qxc .jxsscxhBall').eq(aa);
			this_ = this_.find('b:eq('+num+')');
			red.push(num);
			t = this_.offset().top;
			l = this_.offset().left;
			$(this).animate({left:l,top:t},300);
		});
		setTimeout(function(){
			for(var s in red){
				$('#qxc .jxsscxhBall:eq('+s+') b:eq('+red[s]+')').addClass('red');
			}
			$('.ssq1').remove();
			$('.mask2').hide();
			o.countTotal();
		},.25e3);
	};
	var grade = function(){
    	var grade = parseInt(localStorage.getItem("grade"))
		if(grade>0){
			$("#dobuy").html("立即预约")
		}
    }
	/*-模拟QQ彩票摇一摇效果*/
	var init = function () {
		grade();
		o.fromLocal();
		o.pageGo.goBack();
        bind();
	};
	return {init:init,
			grade:grade,
			openList : o.openList,
			doHm : o.doHm,
			pageGo : o.pageGo
		};

})();
CP.PL.init();
function resetPage(){
	CP.PL.grade();
	CP.PL.pageGo.goBack();
	
	$("#betball").show();
	$("#betlist,#bethm").hide();
	$('#lot_footer').removeClass('fo_buy fo_hm').addClass('fo_basket');//显示手动选号区块
}