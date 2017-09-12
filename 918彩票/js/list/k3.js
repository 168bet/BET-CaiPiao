CP.K3 = (function () {
	var g = {
			cur:0,
			jiang : {//玩法对应的奖金
				0:'<em class=gray>猜中开奖号码之和即中奖</em>',
				1:'[单选]猜中开奖号码即中奖，奖金<em class="yellow">240</em>元',
				2:'[单选]选择同号与不同号的组合，奖金<em class="yellow">80</em>元',
				3:'[单选]至少选3个号，猜中开奖号即中奖<em class="yellow">40</em>元',
				4:'至少选择2个号码，猜中开奖号码即中奖<em class="yellow">8</em>元'
			},
			fps :1000,
			gid : '06',
			zhushu : 0,//选号页面注数
			money : 0,//选号页面总金额
			totalMoney : 0,//列表页面总金额
			count_zs : 0,//列表页面总金额
			beishu : 1,
			qishu : 1,
			buyType : 1,
			codes : '',
			qihao_id : '',//当前期号
			wf : {'0':'和值','1':'三同号单选','2':'二同号单选','3':'三不同号','4':'二不同号','5':'三同号通选','6':'二同号复选','7':'三不同号通选'}//玩法对应的数字和名称
	};
	var o = {
			pageGo: {
				goBack: function () {
					TopAnch.init({
						title:'快3',
						prevShow:true,
						prevFun:function(){//左侧按钮绑定事件
							window.location.href = '#type=index';
						},
						menu:[{'name':'投注选号','url':'javascript:;','cur':true},
						      {'name':'开奖结果','url':'#type=url&p=kj/result.html?in_=06','cur':false},
						      {'name':'玩法帮助','url':'#type=url&p=wf/ahk3.html','cur':false}],
						      style:false
					});
				}
			},
			 /*滑动[[*/
	        slide : function(_obj){
	            var menu = $(_obj.menu);//菜单点击滑动DOM
	            var con = $(_obj.con);//内容滑动DOM
	            var cur = _obj.cur || g.cur;//默认第一个选中(注意11选五只有0到2)
	            var Q = $(window).width();//单个内容块宽度
	            $('#bonus_ em.gray').html(g.jiang[cur]);
	            con.each(function(i){
	            	$(this).show();
                    $(this).css({'left': i<cur ? -Q : (i>cur ? Q:'') }) ;
                    i==cur?$(this).css({'left':0 }):'' ;
                });
 	            menu.click(function(){
	                var index= $(this).index();//当前位置
	                var conW=  con.width();//单个内容块宽度
	                $(this).addClass('cur').siblings().removeClass('cur');
	                con.each(function(i){
	                	if(g.cur == i){//上一次
	                		$(this).stop(true,false).animate({'left': i<index ? -conW : (i>index ? conW:'') }, _obj.conSpeed||300,_obj.effect||'');
	                	}else if(i!=index){
	                		$(this).css({'left':i<index ? -conW : (i>index ? conW:'')});
	                	}else{
	                		$(this).stop(true,false).animate({'left':0 } , _obj.conSpeed||300,_obj.effect||'')
	                	}
	                });
	                g.cur = index;
	                o.change(index);
	            });
	        },
	        change : function (index) {
				$('#bonus_ em.gray').html(g.jiang[index]);
				o.clear();
			},
	        /*滑动]]*/

			/*点击球[[*/
			clickBall : function(_this,on){
				if($(_this).is('.'+on)){
					$(_this).removeClass(on);
				}else{
					if(g.cur == '2'){//二同号 奇葩点 上下不能共存 单独判断
						if($(_this).html().indexOf('*')<0){
							var Q = $(_this).index();
							$('#eth .k3xhlist').each(function(a){
								a<2 && $(this).find('li').eq(Q).removeClass(on);
							});
						}
					}
					$(_this).addClass(on);
				}
				o.countTotal();//计算注数、金额
			},
			/*点击球]]*/
			
			clear : function(){
				$('#content_kp').find('.cur').removeClass('cur');
				o.countTotal();//计算注数、金额
			},
			
			//选球页面统计
			countTotal : function(){
				if(g.cur=='0'){//和值
					g.zhushu = $('#hz .k3xhlist').find('.cur').length;
				}else if(g.cur=='1'){//三同号
					g.zhushu = $('#sth').find('.cur').length;
				}else if(g.cur=='2'){//二同号
					g.zhushu = $('#eth ul.k3xhlist').eq(0).find('.cur').length * $('#eth ul.k3xhlist').eq(1).find('.cur').length + $('#eth ul.k3xhlist').eq(2).find('.cur').length;
				}else if(g.cur=='3'){//三不同号
					g.zhushu = CP.math.C($('#sbth ul.k3xhlist').find('.cur').length, 3)+$('#sbth div.k3tx').find('.cur').length;//计算注数 cp.math.c(已选球数,最低球数)
				}else if(g.cur=='4'){//二不同号
					g.zhushu = CP.math.C($('#ebth ul.k3xhlist').find('.cur').length, 2);
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

			/*高亮球 [[*/
			highLight : function(_arr,dom){
				o.clear();//清除原有高亮球
				for(var j=0,l1=_arr.length;j<l1;j++){
					$(dom+' li').eq(parseInt(_arr[j],10)-1).addClass('cur');
				}
			},
			/*高亮球 ]]*/
			
			/*机选[[*/
			jxNum : function(n,type){//n机选注数 type true投注列表/false选球区 
				if(type){
					for(var i=1;i<=n;i++){
						var _code = '';
						if(g.cur=='0'){
							_code = CP.math.random(3, 18, 1)+'';
						}else if(g.cur=='1'){
							_code = CP.math.random(1, 6, 1)+'';
							var Q = {'1':'111','2':'222','3':'333','4':'444','5':'555','6':'666'}
							_code = Q[_code];
						}else if(g.cur=='2'){
							var Q = CP.math.random(1, 6, 2, false);
							_code = Q[0]+''+Q[0]+'|'+Q[1];
						}else if(g.cur=='3'){
							_code= CP.math.random(1, 6, 3, false)+'';
						}else if(g.cur=='4'){
							_code= CP.math.random(1, 6, 2, false)+'';
						}
						o.addToList([_code, 1]);//添加到投注列表
						o.countAll();//统计总金额 注数
					}
					window.scrollTo(0,1);
					o.setLocal();
				}else{//选球区 
					var Q;
					if(g.cur == '0'){//和值
						Q = CP.math.random(1, 16, 1);
						o.highLight(Q,'#hz .k3xhlist');//高亮红球
					}else if(g.cur == '1'){//三同号
						Q = CP.math.random(1, 6, 1);
						o.highLight(Q,'#sth .k3xhlist');//高亮红球
					}else if(g.cur == '2'){//二同号 特效处理
						Q = CP.math.random(1, 6, 2, false);
						$('#eth').find('.cur').removeClass('cur');
						$('#eth .k3xhlist:eq(0) li').eq(parseInt(Q[0],10)-1).addClass('cur');
						$('#eth .k3xhlist:eq(1) li').eq(parseInt(Q[1],10)-1).addClass('cur');
					}else if(g.cur == '3'){//三不同号
						Q = CP.math.random(1, 6, 3, false);
						o.highLight(Q,'#sbth .k3xhlist');//高亮红球
					}else if(g.cur == '4'){//二不同号
						Q = CP.math.random(1, 6, 2, false);
						o.highLight(Q,'#ebth .k3xhlist');//高亮红球
					}
					o.countTotal();
				}
			},
			/*机选]]*/
			
			/*获取号码区号码 组合成一注 [[*/
			getCode : function(dom){
				var _arr=[];
				for(var i=0;i<dom.find('.cur').length;i++){//遍历选中红球
					_arr[i] = dom.find('.cur').eq(i).text();
				}
				return _arr;
			},
			/*获取号码区号码 组合成一注 ]]*/
			
			/*添加到投注列表[[*/
			addList : function(){
				if(!g.qihao_id){
					alert('期号获取失败!请刷新页面');return false;
				}else if(g.zhushu == '0'){//小于最小红球数
					alert('至少选择一注');
					return false;
				}else{
					var _code = '',_arrRed = [];
					if ( g.cur == '0' ){//和值
						for(var i=0,l = $('#hz .k3xhlist').find('.cur').length;i<l;i++){//遍历选中红球
							_arrRed[i] = $('#hz .k3xhlist').find('.cur').eq(i).find('b').text();
						}
						_code = _arrRed+'';
						o.addToList([_code, g.zhushu]);
					} else if ( g.cur == '1' ){//三同号
						var Q4 = g.zhushu;
						var Q2 = $('#sth .k3tx').find('.cur').length;
						if(Q2){
							o.addToList(['111,222,333,444,555,666', '1'], g.wf[5], '5');
						}
						if(Q2 != Q4){
							for(var i=0,l = $('#sth .k3xhlist').find('.cur').length;i<l;i++){//遍历选中红球
								_arrRed[i] = $('#sth .k3xhlist').find('.cur').eq(i).text();
							}
							_code = _arrRed+'';
							Q4 -= Q2;
							o.addToList([_code, Q4]);
						}
					} else if ( g.cur == '2' ){//二同号
						var Q4 = g.zhushu;
						var Q2 = $('#eth .k3xhlist:eq(2)').find('.cur').length;
						if(Q2){//复选有选的话
							var Q3 = [];
							for(var i=0;i<Q2;i++){//遍历选中红球
								Q3[i] = $('#eth .k3xhlist:eq(2)').find('.cur').eq(i).text();
							}
							Q3 +='';
							o.addToList([Q3, Q2], g.wf[6], '6');
						}
						if(Q2 != Q4){
							var Q=[],Q1=[];
							for(var i=0,l = $('#eth .k3xhlist:eq(0)').find('.cur').length;i<l;i++){//遍历选中红球
								Q[i] = $('#eth .k3xhlist:eq(0)').find('.cur').eq(i).text();
							}
							for(var i=0,l = $('#eth .k3xhlist:eq(1)').find('.cur').length;i<l;i++){//遍历选中红球
								Q1[i] = $('#eth .k3xhlist:eq(1)').find('.cur').eq(i).text();
							}
							_code = Q+'|'+Q1;
							Q4 -= Q2;
							o.addToList([_code, Q4]);
						}
					} else if ( g.cur == '3' ){//三不同号
						var Q4 = g.zhushu;
						var Q2 = $('#sbth .k3tx').find('.cur').length;
						if(Q2){
							o.addToList(['123,234,345,456', 1], g.wf[7], '7');
						}
						if(Q2 != Q4){
							for(var i=0,l = $('#sbth .k3xhlist').find('.cur').length;i<l;i++){//遍历选中红球
								_arrRed[i] = $('#sbth .k3xhlist').find('.cur').eq(i).text();
							}
							_code = _arrRed+'';
							Q4 -= Q2;
							o.addToList([_code, Q4]);
						}
					} else if ( g.cur == '4' ){//二不同号
						for(var i=0,l = $('#ebth .k3xhlist').find('.cur').length;i<l;i++){//遍历选中红球
							_arrRed[i] = $('#ebth .k3xhlist').find('.cur').eq(i).text();
						}
						_code = _arrRed+'';
						o.addToList([_code, g.zhushu]);
					}
					window.location.href = "#type=fun&fun=CP.K3.openList";
					o.setLocal();
				}
			},
			/*添加到投注列表]]*/
			
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
				$('#Money').html(g.zhushu=0);//投注注数金额为0
			},
			/*]]组成号码到投注列表*/
			
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
			
			openList : function(){
				/*设置导航左右按钮 [[*/
				$("#betball").hide();
				$("#betlist").show();
				$('#lot_footer').removeClass('fo_basket').addClass('fo_buy');//显示购买区块

				/*设置导航左右按钮 [[*/
				TopAnch.init({
					title:'投注列表',
					prevShow:true,
					prevFun:function(){//左侧按钮绑定事件					
						window.location.href = '#type=url&p=list/ahk3.html';
					},
					isBack:true,
					nextShow:false,
					style:false
				});
				o.countAll();//统计总金额 注数
				window.scrollTo(0,1);
			},
			
			//存储在本地
			setLocal : function(){
				var codes=[];
				$("#bet_list .bet:input").each(function(){
					codes.push($(this).val());
				});
				g.codes=codes.join(";");
				CP.Storage.set('ahk3',g.codes,true); //存list(json)到sessionStorage
			},
			//sessionStorage数据恢复到投注列表
			fromLocal : function(){
				var _json = CP.Storage.get('ahk3',true);
				if(_json)
				{
					try{
						g.codes = _json;
						var codes = _json.split(";");

						for(var i=0,l=codes.length;i<l;i++)
						{
							var Q = codes[i].split('_');
							var Q1 = '';
							if(Q[0] == '0'||Q[0] == '1'||Q[0] == '6'){//和值 & 三同号单选 & 二同号复选
								Q1 = Q[1].split(',').length;
							}else if(Q[0] == '2'){//二同号单选
								Q1 = Q[1].split('|');
								Q1 = Q1[0].split(',').length * Q1[1].split(',').length;
							}else if(Q[0] == '3'){//三不同号
								Q1 = Q[1].split(',').length;
								Q1 = CP.math.C(Q[1].split(',').length, 3);
							}else if(Q[0] == '4'){//二不同号
								Q1 = Q[1].split(',').length;
								Q1 = CP.math.C(Q[1].split(',').length, 2);
							}else if(Q[0] == '5'||Q[0] == '7'){//三同号通选 & 三不同号通选
								Q1 = '1';
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
			
	        //获取期次信息
	        info : function () {
	        	function main(){
	        		$.ajax({
						url : CP.Data.apps+'/trade/info.go?gid=06',
						type : "POST",
						dataType : "xml",
						success : function(xml) {
							var R = $(xml).find("rowc");//当前期
							var p = R.attr('p');//当前期次
							var t = R.attr('t');//当前期截止时间
							g.qihao_id = p;
							$('#ahk3').html('<p>距'+p.substr(9)+'期截止</p><strong></strong>');
							var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
							expect_change(n_, t);//n_当前时间  a截止时间
							
							var r = $(xml).find('row');
							var dice = ['onedice','twodice','threedice','fourdice','fivedice','sixdice'];
							var html = '';
							r.each(function(aa) {
								var tn = $(this).attr('tn');//10 成功且中奖 9成功未中奖 6成功未开奖 8失败且中奖 7 失败未中奖 5失败未开奖 0 用户未投注
								var p = $(this).attr('p');//期号
								var t = $(this).attr('t');//截止时间
								var c = $(this).attr('c');//开奖号码
								p = p.substr(-2);
								
								if(aa == 0){
									if(c != ''){
										var hz = 0, bb ='';
										c = c.split(',');
										for(var n = 0; n<c.length; n++){
											hz += parseInt(c[n]);
											bb +='<b class="'+dice[(c[n]-1)]+'"></b>';
										}
										$('#kj_').html('<p>'+p+'期开奖 <cite>和值: '+hz+'</cite></p>\
												<div class="pdTop03 k3waitkj clearfix kjdice">'+bb+'<em id=\'kjup\' class="kjup kjdown"></em></div>');
									}else{
										$('#kj_').html('<p><p class="pdLeft06">'+p+'期开奖中…</p></p>\
												<cite class="k3time"></cite><span class="left">等待开奖</span><em id=\'kjup\' class="kjup kjdown"></em>');
									}
									
								}else{
									html +='<ul><li class="wb20">'+p+'期</li>';
									html +='<li class="kjdice listdice">';
									var hz = 0;
									if(c!=''){
										c = c.split(',');
										for(var n = 0; n<c.length; n++){
											hz += parseInt(c[n]);
											html +='<b class="'+dice[(c[n]-1)]+'"></b>';
										}
										html +='</li><li class="wb10">'+hz+'</li>';//和值
										c.sort();//开奖号码排序sort排序
							    		if(c[0] == c[1] && c[1] == c[2]){
							    			//三同号
							    			html +='<li class="wb10">-</li><li class="wb16">-</li><li class="wb10">三同</li><li class="wb16">-</li></ul>';
							    		}else if(c[0] != c[1] && c[1] != c[2]){
							    			if(c[1]-c[0] == 1 && c[2] - c[1] == 1){
							    				//三连号
							    				html +='<li class="wb10">-</li><li class="wb16">三连</li><li class="wb10">-</li><li class="wb16">-</li></ul>';
							    			}else{
							    				//三不同
							    				html +='<li class="wb10">-</li><li class="wb16">-</li><li class="wb10">-</li><li class="wb16">三不同</li></ul>';
							    			}
							    		}else{
							    			//二同号
							    			html +='<li class="wb10">二同</li><li class="wb16">-</li><li class="wb10">-</li><li class="wb16">-</li></ul>';
							    		}
									}else{
										html +='<b>-</b><b>-</b><b>-</b></li><li class="wb10">-</li>';//和值
										html +='<li class="wb10">-</li><li class="wb16">-</li><li class="wb10">-</li><li class="wb16">-</li></ul>';
									}
								}
							});
							$('#kj_code div.k3kjlist').html(html);
						},
						error : function() {
							alert('网络异常，请刷新重试');
							return false;
						}
					});
	        	}
				
				function diffToString(num, iscn) {
					var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
					var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
					for (var i = 0, l = unit.length; i < l; i++) {
						date[i] = parseInt(num / unit[i]);
						cnDate[i] = date[i] + cn[i];
						num %= unit[i];
					}
					return iscn ? cnDate : date;
				}
				function eachClock(){
					this.now += g.fps;
					var diff = this.endtime_ - this.now;
					var msg = '';
					if(diff >= 0){
						timeout = diffToString(diff,false);
						msg = timeout[1]+''+timeout[2]+':'+CP.Util.pad(timeout[3],2);
						$('#ahk3>strong').html(msg);
					}else{
						msg = '已截止';
						$('#ahk3>strong').html(msg);
						clearInterval(this.timer);
						setTimeout(function(){
							o.info();
						},2000);
					}
				}
				function expect_change(now, endtime){
					this.now = now.getTime();
					this.endtime_ = new Date(endtime.replace(/-/g , '/'));
					clearInterval(this.timer);
					this.timer = setInterval(function (){
						eachClock();
					}, g.fps); 
					eachClock();
				}
				main();
			},
	        init : function () {
	        	o.info();//获取期次 遗漏
	        },
	        /*获取购买的各种参数 [[*/
			getArgument : function(t){
				var buy = {};
				var code = CP.Util.joinString('06', g.codes);
				switch(t){
					/* 1:自购 3:追号 */
					case 1:
						buy = {//投注参数
								payUrl:    '/trade/pcast.go',//投注接口
								gid:       '06',//彩种id
								pid:       g.qihao_id,//期号
								codes:     code,//投注内容
								muli:      g.beishu,//倍数
								countMoney:g.totalMoney,//方案金额
								orderType:'dg'//代购
						};
						break;
					case 3:
						var muli = '', pid = g.qihao_id;
						for(var i=0;i<g.qishu;i++){muli += g.beishu+',';pid += ',';}
						pid = pid.substring(0, pid.length-1);
						muli = muli.substring(0, muli.length-1);
						buy = {//投注参数
							payUrl:    '/trade/zcast.go',//投注接口
							gid:       '06',//彩种id
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
			dopay : function(){
				g.qishu=parseInt($('#tbox_qishu').val());
				g.qishu>1? g.buyType=3 : g.buyType=1;//追号、自购
				var _obj = o.getArgument(g.buyType);
				var cMoney = g.totalMoney;
				var data = {//支付弹框参数
						gid:     '06',//彩种id
						cMoney:  cMoney,//需支付金额
						payPara: _obj//jQuery.param(param)
				};
				alert('提交中，请稍后！','loading');
				CP.User.info(function(options){
					remove_alert();
					if (options) {jQuery.extend(data, options);}
					CP.Popup.buybox(data);
				});
				sessionStorage.removeItem('ank3');//购买的时候情况sessionstorage
			},
			/*购买弹窗]]*/
			
			/*购买验证[[*/
			dobuy : function(){
				var info = '';
				if(g.count_zs<1){//投注列表没有内容
					info = '请至少选择一注彩票';
				}else if(!g.qishu){
					info = '请输入期数';
				}else if(!g.beishu){
					info = '请输入倍数';
				}
				if(info!=''){alert(info);return}
				o.dopay();
			}
			/*购买验证]]*/
	};
	var bind = function(){
		$('#content_kp').find('ul.k3xhlist li').Touch({fun:function(el){ o.clickBall(el,'cur');}});//点击球
		$('#content_kp').find('div.k3tx ul').Touch({fun:function(el){ o.clickBall(el,'cur');}});//通选好么
		$('#deleted').bind(start_ev,function(){o.clear();});//清空
		$('#shake').bind(start_ev,function(){o.jxNum(1,0);});//机选1注
		$('#jxbtn').bind(start_ev,function(){o.jxNum(1,1);});//机选1注|投注列表机选
		$('#addlist').bind("click",function(){o.addList();});//添加到投注列表
		$('#hand').bind(start_ev,function(){location.href='#type=url&p=list/ahk3.html';});
		$('#dobuy').bind(start_ev,function(){o.dobuy();});//代购
		$('#clearAll').bind(start_ev,function(){//清空投注列表
			$('#bet_list').html('');
			$("#tbox_qishu").val("1");
			$("#tbox_beishu").val("1");
			CP.Storage.remove('ahk3',true);
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
			max : 999,
			min : 1,
			num : 1,
			tag : '倍',
			fn  : function(){g.beishu=$(this.ts).val();o.countAll();}
		});
		$('#tbox_qishu').KeyBoard({
			val : zuiqishuNum,
			max : 50,
			min : 1,
			num : 1,
			tag : '期',
			fn  : function(){
				g.qishu=$(this.ts).val();
				g.qishu>1 ? $('.zjStop').show() : $('.zjStop').hide();
				o.countAll();
			}
		});
		/*]]绑定倍数、期数初始值*/
		
		$('.zjStop').bind(start_ev, function () {
			$(this).find('em').toggleClass('nocheck check');
		});
		
		/*显示历史开奖[[*/
		$('.k3kj').bind(start_ev, function(){
			$(this).find('.kjup').toggleClass('kjdown');
			$('#kj_code').slideToggle();
		});
		$('#kj_code').bind(start_ev, function(){
			$(this).slideToggle();
			$('.k3kj').find('.kjup').toggleClass('kjdown');
		});
        /*]]显示历史开奖*/
		
		/*摇一摇[[*/
		Shake.run(function(){
			o.jxNum(1,0);
		});
		 /*]]摇一摇*/
	};
	var grade = function(){
    	var grade = parseInt(localStorage.getItem("grade"))
		if(grade>0){
			$("#dobuy").html("立即预约")
		}
    }
	var init = function(){
		grade();
		o.fromLocal();
		o.pageGo.goBack();
		//玩法切换
        o.slide({
            'effect':'swing',//切换效果
            'menuSpeed':200,//菜单滑动时间
            'conSpeed':350,//内容滑动时间
            'menu':'#play_tabs span',//点击tab切换
            'con':'#content_kp article'//对应的内容块
        });
        o.init();
        bind();
	};
	return {init:init,
		grade:grade,
		openList : o.openList,
		pageGo : o.pageGo,
		clear : o.clear
		};
})();
CP.K3.init();
function resetPage(){
	CP.K3.grade();
	CP.K3.pageGo.goBack();
	
	CP.K3.clear();
	
	$("#betball").show();
	$("#betlist").hide();
	$('#lot_footer').removeClass('fo_buy').addClass('fo_basket');//显示手动选号区块
}