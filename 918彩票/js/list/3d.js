CP.SD = (function(){
	var lotteryType = $('#content_home').children().eq(0).attr('id').replace('buy_','');//彩种简称 
	var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	var s = {
		'3d':{'lot_id':'03','name':'福彩3D'},
		'p3':{'lot_id':'53','name':'排列三'}
	};
	var g = {
		cur : 0,//默认显示第一个玩法 有11个玩法
		fps :1000,
		gid : s[lotteryType].lot_id,
		zhushu : 0,//选号页面注数
		money : 0,//选号页面总金额
		totalMoney : 0,//列表页面总金额
		count_zs : 0,//列表页面总注数
		beishu : 1,
		hmMoney : 0,//合买需支付金额
		qishu : 1,
		buyType : 1,
		codes : '',
		qihao_id : '',//当前期号
		jiang : {//各玩法的奖金
				0 : '分别猜中百位、十位、个位，奖金<em class="yellow">1040</em>元',
				1 : '<p>选择同号与不同号的组合，奖金<em class="yellow">346</em>元</p><p>例:选号22,3,若开奖号码223或232或322,即中奖</p>',
				2 : '猜中开奖号码之和,奖金<em class="yellow">1040</em>元',
				3 : '<p>选2个号,猜中组三号码,奖金<em class="yellow">346</em>元</p><p>组三:3个号码中有2个相同,如353</p>',
				4 : '<p>选3个号,猜中后3位组六号码,奖金<em class="yellow">173</em>元</p><p>组六:3个号码各不相同,如865</p>'
		},
		hz : {'0': 1,'1': 3,'2': 6,'3': 10,'4': 15,'5': 21,'6': 28,'7': 36,'8': 45,'9': 55,'10': 63,'11': 69,'12': 73,'13': 75,'14': 75,
			'15': 73,'16': 69,'17': 63,'18': 55,'19': 45,'20': 36,'21': 28,'22': 21,'23': 15,'24': 10,'25': 6,'26': 3,'27': 1},//和值对应注数
		wf : {'0':'直选','1':'组三','2':'直选和值','3':'组三包号','4':'组六包号'}//玩法对应的最小选球个数
	};
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
						      //{'name':'合买跟单','url':'#type=url&p=user/hallhm.html?in='+CP.Util.lot(g.gid, 2),'cur':false},
						      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_='+s[lotteryType].lot_id,'cur':false},
						      {'name':'玩法帮助','url':'#type=url&p=wf/'+lotteryType+'.html','cur':false}],
						      style:false
					});
				}
			},
			/*滑动[[*/
	        slide : function(_obj){
	            var menu = $(_obj.menu);//菜单点击滑动DOM
	            var con = $(_obj.con);//内容滑动DOM
	            var cur = _obj.cur || g.cur;//默认第一个选中(注意11选五只有0到2)
	            var slideBox =$(_obj.slideBox)||'';//滑动模块DOM
	            var Q = $(window).width();//单个内容块宽度
	            $('#bonus_').html(g.jiang[cur]);
	            con.each(function(i){
	            	$(this).show();
                    $(this).css({'left': i<cur ? -Q : (i>cur ? Q:'') });
                    i==cur?$(this).css({'left':0 }):'' ;
                });
 	            menu.click(function(){
	                var index= $(this).index();//当前位置
	                if(index == '0' || index == '2'){
	                	$('#bonus_').removeClass('jxssctitle');
	                }else{
	                	$('#bonus_').addClass('jxssctitle');
	                }
	                var conW=  con.width();//单个内容块宽度
	                var w=menu.eq(index).position().left+(menu.eq(index).width()-slideBox.width())/2;
	                slideBox!=''?slideBox.stop(true,false).animate({'left': w} , _obj.menuSpeed||100):'';//选项目录滑动
	                $(this).addClass('cur').siblings().removeClass('cur');
	                con.each(function(i){
	                    if(g.cur == i){//上一次
	                		$(this).stop(true,false).animate({'left': i<index ? -conW : (i>index ? conW:'') }, _obj.conSpeed||300,_obj.effect||'');
	                	}else if(i!=index){//除去当期和上一次的
	                		$(this).css({'left':i<index ? -conW : (i>index ? conW:'')});
	                	}else{//当前的
	                		$(this).stop(true,false).animate({'left':0 } , _obj.conSpeed||300,_obj.effect||'')
	                	}
	                });
	                g.cur = index;
	                o.change(index);
	            });
	        },
	        change : function (index) {
	        	$('#bonus_').html(g.jiang[index]);
				o.clear();
			},
	        /*滑动]]*/
	        
			/*高亮球 [[*/
			highLight : function(_arr,dom){
				for(var j=0,l1=_arr.length;j<l1;j++){
					$(dom+' b').eq(parseInt(_arr[j],10)-1).addClass('red');
				}
			},
			/*高亮球 ]]*/
			
			/*机选[[*/
			jxNum : function(n,type){//n机选注数 type 投注列表/投注区 
				if(type){
					for(var i=1;i<=n;i++){
						var Q = 1;
						var _code = '';
						if(g.cur=='0'){
							_code = CP.math.random(0, 9, 3,true).join(',');
						}else if(g.cur=='1'){
							_code = CP.math.random(0, 9, 2,false);
							_code = _code[0]+','+_code[0]+','+_code[1];
						}else if(g.cur=='2'){
							_code = CP.math.random(0, 27, 1).join('');
							Q = g.hz[_code];
						}else if(g.cur=='3'){
							Q = 2;
							_code = CP.math.random(0, 9, 2,false).join(',');
						}else if(g.cur=='4'){
							_code = CP.math.random(0, 9, 3,false).join(',');
						}
						o.addToList([_code, Q]);//添加到投注列表
						o.countAll();//统计总金额 注数
					}
					window.scrollTo(0,1);
					o.setLocal();
				}else{
//					var red = CP.Util.padArray(CP.math.random(1,s[lotteryType]['red'],s[lotteryType]['miniRedNum'],false)).sort(function(a,b){return a-b;});//机选红球
//					var blue = CP.Util.padArray(CP.math.random(1,s[lotteryType]['blue'],s[lotteryType]['miniBlueNum'],false)).sort(function(a,b){return a-b;});//机选蓝球
//					o.highLight(red,'#ball_red');//高亮红球
//					o.highLight(blue,'#ball_blue');//高亮蓝球
					o.clear();//清除原有高亮球
					var Q;
					if(g.cur == '0'){//直选
						Q = CP.math.random(0, 9, 3, true);
						$('#zx .jxsscxhBall').each(function(a){
							$(this).find('b:eq('+Q[a]+')').addClass('red');
						});
					}else if(g.cur == '1'){//组三
						Q = CP.math.random(0, 9, 2, false);
						$('#zs .jxsscxhBall').each(function(a){
							$(this).find('b:eq('+Q[a]+')').addClass('red');
						});
					}else if(g.cur == '2'){//和值
						Q = CP.math.random(0, 27, 1);
						o.highLight(Q,'#hz .jxsscxhBall');//高亮红球
					}else if(g.cur == '3'){//组三包号
						Q = CP.math.random(0, 9, 2,false);
						o.highLight(Q,'#zsbh .jxsscxhBall');//高亮红球
					}else if(g.cur == '4'){//组六包号
						Q = CP.math.random(0, 9, 3,false);
						o.highLight(Q,'#zlbh .jxsscxhBall');//高亮红球
					}					
					o.countTotal();
				}
			},
			/*机选]]*/
			
			/*获取号码区号码 组合成一注 [[*/
			getCode : function(dom){
				var _arr=[];
				for(var i=0;i<dom.find('.red').length;i++){//遍历选中红球
					_arr[i] = dom.find('.red').eq(i).text();
				}
				return _arr;
			},
			/*获取号码区号码 组合成一注 ]]*/
			
			/*组成号码到投注列表[[*/
			/*param arr  第一个是code 第二个是注数（不可空）
			 *param wf   玩法名（可为空）
			 *param cur  玩法对应tab的index()（可为空）
			 *param Q    默认不填是false true是用append添加 false用prepend（可为空）
			 */
			addToList : function(arr, wf, cur, Q){
				var _html = '';
				_html = '<div class="ssqtzNum">';
				_html += '<cite class="errorBg"><em class="error2"></em></cite>';
				_html += '<span><em>'+arr[0].replace(/,/g,' ')+'</em>';
				_html += '</span><p>'+(wf || g.wf[g.cur])+'&nbsp;&nbsp;&nbsp;'+arr[1]+'注'+2*arr[1]+'元</p>';
				_html += '<input type="hidden" value="'+arr[1]+'" name="bet_num" class="bet-num">';
				_html += '<input type="hidden" value="'+(cur || g.cur)+'_'+arr[0]+'" name="bet" class="bet">';
				_html += '</div>';
				!Q && $('#bet_list').prepend(_html) || $('#bet_list').append(_html);
				$('#Notes').html(0);//投注注数金额为0
				$('#Money').html(g.zhushu=0);//初始化选号界面的注数
			},
			/*]]组成号码到投注列表*/
			
			/*添加到投注列表[[*/
			addList : function(){
				if(!g.qihao_id){
					alert('期号获取失败!请刷新页面');return false;
				}else if(!g.zhushu){
					alert('你至少选择一注');
				}else{
					var _code = [];
					if(g.cur == '0'){//直选
						_code.push(o.getCode($('#zx .jxsscxhBall:eq(0)')).join(''));
						_code.push(o.getCode($('#zx .jxsscxhBall:eq(1)')).join(''));
						_code.push(o.getCode($('#zx .jxsscxhBall:eq(2)')).join(''));
						_code = _code.join(',');
					}else if(g.cur == '1'){//组三
						var Q = $('#zs .jxsscxhBall:eq(0)').find('.red').text().substr(-1);
						_code.push(Q);
						_code.push(Q);
						_code.push($('#zs .jxsscxhBall:eq(1)').find('.red').text());
						_code = _code.join(',');
					}else if(g.cur == '2'){//和值
						_code = o.getCode($('#hz .jxsscxhBall')).join(',');
					}else if(g.cur == '3'){//组三包号
						_code = o.getCode($('#zsbh .jxsscxhBall')).join(',');
					}else if(g.cur == '4'){//组六包号
						_code = o.getCode($('#zlbh .jxsscxhBall')).join(',');
					}		
					if($('#countNotes').text() == '0'){//如果列表那边么样注数的情况清空期数倍数
						$('#tbox_qishu').val('1');
						$('#tbox_beishu').val('1');
					}
					o.addToList([_code, g.zhushu]);
					window.location.href = "#type=fun&fun=CP.SD.openList";
					o.setLocal();
				}
			},
			/*添加到投注列表]]*/
			
	        /*点击球[[*/
			clickBall : function(_this,on){
				if($(_this).hasClass(on)){
					$(_this).removeClass(on);
				}else{
					if(g.cur == '1'){//组三 上下不能共存
						var Q = $(_this).index();
						$(_this).parent().find('b').removeClass(on);
						$('#zs .jxsscxhBall').each(function(){
							$(this).find('b').eq(Q).removeClass(on);
						});
					}
					$(_this).addClass(on);
				}
				o.countTotal();//计算注数、金额
			},
			/*点击球]]*/
			
			clear : function(){
				$('#content_3d').find('.red').removeClass('red');
				o.countTotal();//计算注数、金额
			},
			
			//选球页面统计
			countTotal : function(){
				g.zhushu = 0;
				if(g.cur=='0'){//直选
					g.zhushu = $('#zx .jxsscxhBall').eq(0).find('.red').length * $('#zx .jxsscxhBall').eq(1).find('.red').length * $('#zx .jxsscxhBall').eq(2).find('.red').length;
				}else if(g.cur=='1'){//组三
					var Q = $('#zs').find('.red').length;
					g.zhushu = {'2':'1'}[Q]||0;
				}else if(g.cur=='2'){//和值
					$('#hz .red').each(function(){
						g.zhushu += g.hz[$(this).text()];
					});
				}else if(g.cur=='3'){//组三包号
					g.zhushu = 2*CP.math.C($('#zsbh b.red').length, 2);
				}else if(g.cur=='4'){//组六包号
					g.zhushu = CP.math.C($('#zlbh b.red').length, 3);
				}
				g.money = 2*g.zhushu;
				$('#Notes').html(g.zhushu);
				$('#Money').html(g.money);
				
				if(g.zhushu){
					$('#Notes').addClass('red');
					$('#Money').addClass('red');
				} else {
					$('#Notes').removeClass('red');
					$('#Money').removeClass('red');
				}
			},
			
			/*列表页面统计总金额 总注数[[*/
			countAll : function(){
				var zhushu = 0;
				g.beishu = $('#tbox_beishu').val();
				g.qishu = $('#tbox_qishu').val();
				var codes=[];
				$('#bet_list .bet-num').each(function(e){
					zhushu += parseInt($(this).val());//计算投注区域总注数
					codes.push($(this).next().val());
				});
				g.codes=codes.join(";");
				$('#countNotes').html((g.count_zs=zhushu));
				$('#countMoney').html(g.totalMoney=g.count_zs*2* g.beishu*g.qishu);
			},
			/*统计总金额 总注数]]*/
			
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
							var Q = codes[i].split('_');
							var Q1 = 0;
							if(Q[0] == '0'){
								Q1 = Q[1].split(',');
								Q1 = Q1[0].split('').length * Q1[1].split('').length * Q1[2].split('').length;
							}else if(Q[0] == '1'){
								Q1 = 1;
							}else if(Q[0] == '2'){
								$.each(Q[1].split(','), function(index, el){
									Q1 += g.hz[el];
								});
							}else if(Q[0] == '3'){
								Q1 = 2*CP.math.C(Q[1].split(',').length, 2);
							}else if(Q[0] == '4'){
								Q1 = CP.math.C(Q[1].split(',').length, 3);
							}
							/*param [Q[1], Q1]  第一个是code 第二个是注数
							 *param g.wf[Q[0]]  玩法名
							 *param Q[0]        玩法对应tab的index()
							 *param true        默认不填是false true是用append添加 false用prepend
							 */
							o.addToList([Q[1], Q1], g.wf[Q[0]], Q[0], true);
						}
						o.countAll();
					}
					catch(e){
						sessionStorage.removeItem('ahk3');
					}
				}
			},
			
			openList : function(){
				var grade = parseInt(localStorage.getItem("grade"))
				if(grade>0){
					$("#dobuy").html("立即预约")
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
						window.location.href = '#type=fun&fun=CP.SD.openList';
					},
					isBack:true,
					nextShow:false,
					style:false
				});
				
				$('#hmDet cite').eq(0).html(g.count_zs);//注数
				$('#hmDet cite').eq(1).html(g.beishu);//倍数
				$('#hmDet cite').eq(2).html(g.totalMoney);//总金额
				
				$("#rg").val(Math.ceil(g.totalMoney*0.05));
				$("#rg_bl").html(Math.floor(($('#rg').val()/g.totalMoney)*10000)/100+"%");
				$("#bd").removeAttr('disabled');
				$("#bd").val('0');
				$("#bd_bl").html('0%');
				o.hmDet();
			},
			
			/*获取购买的各种参数 [[*/
			getArgument : function(t){
				var buy = {};
				var code = CP.Util.joinString(g.gid, g.codes);
				switch(t){
					/* 1:自购 2:合买 3:追号 */
					case 1:
						buy = {//投注参数
								payUrl:    '/trade/pcast.go',//投注接口
								gid:       g.gid,//彩种id
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
							gid:       g.gid,//彩种id
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
							gid:       g.gid,//彩种id
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
				g.qishu=parseInt($('#tbox_qishu').val());
				g.qishu>1? g.buyType=3: (t ? g.buyType=2 : g.buyType=1);//追号、合买、自购
				var _obj = o.getArgument(g.buyType);
				var cMoney = '';
				t ? cMoney = g.hmMoney : cMoney = g.totalMoney;
				var data = {//支付弹框参数
						gid:     g.gid,//彩种id
						cMoney:  cMoney,//需支付金额
						payPara: _obj//jQuery.param(param)
				};
				alert('提交中，请稍后！','loading');
				CP.User.info(function(options){
					remove_alert();
					if (options) {jQuery.extend(data, options);}
					CP.Popup.buybox(data);
				});
				sessionStorage.removeItem(lotteryType);//购买的时候情况sessionstorage
			},
			/*购买弹窗]]*/
			
			/*购买验证[[*/
			dobuy : function(t){
				var info = '';
				if(g.count_zs<1){//投注列表没有内容
					info = '请至少选择一注彩票';
				}else if(!g.qishu){
					info = '请输入期数';
				}else if(!g.beishu){
					info = '请输入倍数';
				}
				if(info!=''){alert(info);return}
				if(t){window.location.href = "#type=fun&fun=CP.SD.doHm";}else{o.dopay();}
			},
			/*购买验证]]*/
			
	        /*请求期号接口[[*/
			getQihao:function(callback){
				if(callback){
					$.ajax({
						url:CP.Data.apps+'/trade/info.go?gid='+g.gid,
						dataType:'xml',
						success: function(xml) {
							var data = {},issueInfo = [];
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
							callback(issueInfo);
						},
						error:function(){
							$('#issue_info').html('网络不通畅，请点击刷新');
							$('#issue_info').bind(end_ev,function(){
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
					$('#issue_info').html('第 '+data.pid+' 期 '+ timeText +''+ et1 +'('+wk2+') 截止');
					return true;
				}else{
					return false;
				}
			},
			/*]]渲染期号信息*/
			
			/*获取期号数据[[*/
			getTime : function(){
				o.getQihao(function(data){
					var kjhtml=[];
					for(var i=0,l=data.length; i<l; i++){
						var p = data[i].pid;//期号
						var c = data[i].acode;//开奖号码
						c = c.replace(/,/g,'  ');
						p = p.substr(-3);
						kjhtml.push('<ul><li class="wb20">'+p+'期</li>');
						kjhtml.push('<li class="wb16 red">'+c+'</li>');
						var t = '';
						if(c){
							var c = c.split('  ');
							if(c[0] == c[1] && c[0] == c[2] && c[1] == c[2]){
								t = '豹子';
							}else if(c[0] == c[1] || c[0] == c[2] || c[1] == c[2]){
								t = '组三';
							}else{
								t = '组六';
							}
						}
						kjhtml.push('<li class="wb21">'+t+'</li></ul>');
						
					}
					$('#kj_slide').next().find('.k3kjlist').html(kjhtml.join(''));
				});
			},
			/*]]获取期号数据*/
			init : function(){
				o.getTime();//获取系统时间
			}
	};
	var bind = function(){
		$('#content_3d').Touch({children:'.jxsscxhBall b',fun:function(el){o.clickBall(el,'red');}});//选球
		$('#kj_slide').bind(start_ev,function(){//显隐开奖列表
			if($(this).find('.ssqup').hasClass('ssqdown')){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
			$(this).find('.ssqup').toggleClass('ssqdown');
		});
		$('#shake').bind(start_ev,function(){o.jxNum(1,0);});//机选1注
		$('#jxbtn').bind(start_ev,function(){o.jxNum(1,1);});//机选1注|投注列表机选
		$('#deleted').bind(start_ev,function(){o.clear();});//清空
		$('#addlist').bind("click",function(){o.addList();});//添加到投注列表
		$('#hand').bind(start_ev,function(){location.href='#type=url&p=list/'+lotteryType+'.html';});//切换到手动选号
		$('#clearAll').bind(start_ev,function(){
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
		});//清空投注列表
		$('#bet_list').delegate('.errorBg',end_ev,function(){
			$(this).parent().remove();
			o.countAll();
			o.setLocal();
		});//删除单注
		$('#dobuy').bind(start_ev,function(){o.dobuy();});//代购
		$('#dohm').bind(start_ev,function(){!$(this).hasClass('fqhmGray') && o.dobuy('hm');});//发起合买
		$('#hmSubmit').bind(start_ev,function(){
			if(parseInt($('#rg').val()) < g.totalMoney*0.05){return;}
			o.dopay('hm');});//提交合买
		/*绑定倍数、期数初始值[[*/
        var buyTimes = 1;
        var zuiqishuNum = 1;
		$('#tbox_beishu').KeyBoard({
			val : buyTimes,
			max : 99,
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
			o.jxNum(1,0);
		});
		/*摇一摇]]*/
	
	};
	var grade = function(){
    	var grade = parseInt(localStorage.getItem("grade"));
		if(grade==2){
			//alert("3D")
			$("#dobuy").html("立即预约")
		}
    };
	var init = function(){
		grade();
		o.fromLocal();
		o.pageGo.goBack();
		//玩法切换
        o.slide({
            'effect':'swing',//切换效果
            'menuSpeed':200,//菜单滑动时间
            'conSpeed':350,//内容滑动时间
            'menu':'#play_tabs li',//点击tab切换
            'con':'#content_3d article',//对应的内容块
            'slideBox':'.downline'
            	
        });
        o.init();
        bind();
	}
	return {init:init,
		grade:grade,
		openList : o.openList,
		pageGo : o.pageGo,
		clear : o.clear,
		doHm : o.doHm
	};
})();
CP.SD.init();

function resetPage(){
	CP.SD.grade();
	CP.SD.pageGo.goBack();
	
	CP.SD.clear();
	$("#betball").show();
	$("#betlist").hide();
	$('#lot_footer').removeClass('fo_buy').addClass('fo_basket');//显示手动选号区块
}
