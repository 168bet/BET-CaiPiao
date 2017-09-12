/*
 * Author: weige
 * Date:  2014-06-23
 */

CP.Ahk3 = function(){
	var curTime_ = new Date().getTime();
	var fps = 1000;
	var bx_num = {//必选个数
		'hz': 1,'sth': 1,'eth': 1,'sbth': 3,'ebth': 2
	};
	var hz_jxnum = {//玩法机选
			'hz': 16,'sth': 6,'eth': 6,'sbth': 6,'ebth': 6
	};
	var enter = {
			init: function(){
				enter.tab();
				enter.bind();
				enter.issue();
			},
			issue : function(){
				$.ajax({
					url : '/trade/info.go?gid=06',
					type : "POST",
					dataType : "xml",
					success : function(xml) {
						var R = $(xml).find("rowc");//当前期
						var p = R.attr('p');//当前期次
						var a = R.attr('a');//上期开奖时间
						var t = R.attr('t');//当前期截止时间
						$('#c_expect').html(p.substr(-2));
						$('#expect').val(p);
						var n_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
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
									$('#kj_ p').html(p+'期开奖 <cite>和值: '+hz+'</cite>');
									$('#kj_ div').html(bb+'<em id=\'kjup\' class="kjup kjdown"></em>');
									
								}else{
									$('#kj_ p').html('<p class="pdLeft06">'+p+'期开奖中…</p>');
									$('#kj_ div').html('<cite class="k3time"></cite><span class="left">等待开奖</span><em id=\'kjup\' class="kjup kjdown"></em>');
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
//						    			三同号
						    			html +='<li class="wb10">-</li><li class="wb16">-</li><li class="wb10">三同</li><li class="wb16">-</li></ul>';
						    		}else if(c[0] != c[1] && c[1] != c[2]){
						    			if(c[1]-c[0] == 1 && c[2] - c[1] == 1){
//						    				三连号
						    				html +='<li class="wb10">-</li><li class="wb16">三连</li><li class="wb10">-</li><li class="wb16">-</li></ul>';
						    			}else{
//						    				三不同
						    				html +='<li class="wb10">-</li><li class="wb16">-</li><li class="wb10">-</li><li class="wb16">三不同</li></ul>';
						    			}
						    		}else{
//						    			二同号
						    			html +='<li class="wb10">二同</li><li class="wb16">-</li><li class="wb10">-</li><li class="wb16">-</li></ul>';
						    		}
								}else{
									html +='<b>-</b><b>-</b><b>-</b></li><li class="wb10">-</li>';//和值
									html +='<li class="wb10">-</li><li class="wb16">-</li><li class="wb10">-</li><li class="wb16">-</li></ul>';
								}
							}
						});
						$('#kj_code div.k3kjlist').html(html);
						enter.expect_change(n_, t);//倒计时
					},
					error : function() {
						$('#kj_code div.k3kjlist').html('网络异常！');
						return false;
					}
				});
				
			},bind:function(){
				$('#c_c').Touch(function(){
					$('#kj_code').slideToggle();
					$('#kjup').toggleClass('kjdown');
				});
				//右上角菜单显示或隐藏
				$("#pullIco").Touch(function(){
						if($("#pullText").is(':hidden')){
							$("#tm_c").show();
						}else{
							$("#tm_c").hide();
						}
						$(this).parent().toggleClass("pullHover");
						$("#pullText").toggle();
				});
				$('#tm_c').click(function(){
					$(this).toggle();
					$('#pullIco').parent().toggleClass("pullHover");
					$("#pullText").toggle();
					
				});
				$('#hz li').Touch(function(){//和值
					$(this).toggleClass('cur');
					
					enter.count('hz');
					
					enter.winner('hz');//若几吧中奖
				});
				$('#sth ul.k3xhlist li,#sth div ul').Touch(function(){//三同号
					$(this).toggleClass('cur');
					
					enter.count('sth');
					
					enter.winner('sth');
				});
				$('#eth ul:eq(0) li').Touch(function(){//二同号
					if(!$(this).hasClass('cur')){
						var m = $(this).html();
						var index_ = {'11':6,'22':7,'33':8,'44':9,'55':10,'66':11}[m];
						$('#eth li').eq(index_).removeClass('cur');
					}
					
					$(this).toggleClass('cur');
					
					enter.count('eth');
					
					enter.winner('eth');
				});
				$('#eth ul:eq(1) li').Touch(function(){
					if(!$(this).hasClass('cur')){
						var m = $(this).html();
						var index_ = {'1':0,'2':1,'3':2,'4':3,'5':4,'6':5}[m];
						$('#eth li').eq(index_).removeClass('cur');
					}
					$(this).toggleClass('cur');
					enter.count('eth');
					enter.winner('eth');
				});
				$('#eth div li').Touch(function(){
					$(this).toggleClass('cur');
					enter.count('eth');
					enter.winner('eth');
				});
				$('#sbth ul.k3xhlist li,#sbth div ul').Touch(function(){//三不同号
					$(this).toggleClass('cur');
					enter.count('sbth');
					enter.winner('sbth');
				});
				$('#ebth li').Touch(function(){//二不同号
					$(this).toggleClass('cur');
					enter.count('ebth');
					enter.winner('ebth');
				});
				$('#kj_code').Touch(function(){
					$('#kj_code').slideUp();
					$('#kjup').addClass('kjdown');
				});
				$('#pay_').on('click',function(){
					var n = $('#play_tabs span.cur').attr('val');
					var zs = parseInt($('#zs_ cite:eq(0)').html());
					if(zs == 0){
						enter.random_();
					}else{
						var code = '';
						code = enter.code(n,zs);
						localStorage.setItem('ahk3SelectNum',code);
						window.location.href = '#class=url&xo=ahk3/ture.html';
					}
				});
				$('#shake').click(function(){
					enter.random_();
				});
				$('.deleted').on('click',function(){
					enter.clean_();
				});
			},
			code:function(n,zs){
				var Ball="";
				if(n == 'hz' || n == 'ebth'){
					$("#"+n).find('li.cur').each(function(){
						Ball += (n=='hz'? $(this).find('b').html() : $(this).html()) + " ";
					});
					Ball = Ball.substring(0, Ball.length-1);
					Ball = Ball + '_' + (n=='hz'?'和值':'二不同号') + '_' + zs;
				}else if(n == 'sth'){
					var tx = '';//三同号通选
					if($("#"+n).find('div ul').hasClass('cur')){
						tx = '111 222 333 444 555 666_三同号通选_1';
						zs--;
					}
					if($("#"+n).find('ul:eq(0) li').hasClass('cur')){
						$("#"+n).find('ul:eq(0) li.cur').each(function(){
							Ball += $(this).html() + " ";
						});
						Ball = Ball.substring(0, Ball.length-1) + '_三同号单选_' + zs + (tx?';':'');
					}
					Ball = Ball + tx;
				}else if(n == 'eth'){
					var fx = '';//二同号复选
					var j = 0;
					if($("#"+n).find('div li').hasClass('cur')){
						$("#"+n).find('div li.cur').each(function(){
							fx += $(this).html() + " ";
							zs--;
							j++;
						});
						fx = fx.substring(0, fx.length-1)+'_二同号复选_'+j;
					}
					if($("#"+n).find('ul:eq(0) li').hasClass('cur') && $("#"+n).find('ul:eq(1) li').hasClass('cur')){
						$("#"+n).find('ul:eq(0) li.cur').each(function(){
							Ball += $(this).html() + ",";
						});
						Ball = Ball.substring(0, Ball.length-1);
						Ball +='|';
						$("#"+n).find('ul:eq(1) li.cur').each(function(){
							Ball += $(this).html() + ",";
						});
						Ball = Ball.substring(0, Ball.length-1) + '_二同号单选_' + zs + (fx?';':'');
					}
					Ball = Ball + fx;
				}else if(n == 'sbth'){
					var lh = '';//三连号通选
					if($("#"+n).find('div ul').hasClass('cur')){
						lh = '123 234 345 456_三连号通选_1';
						zs--;
					}
					if($("#"+n).find('ul:eq(0) li.cur').length >= 3){
						$("#"+n).find('ul:eq(0) li.cur').each(function(){
							Ball += $(this).html() + " ";
						});
						Ball = Ball.substring(0, Ball.length-1) + '_三不同号_' + zs + (lh?';':'');
					}
					Ball = Ball + lh;
				}
				return Ball; 
			},
			tab:function(){
				$('#play_tabs span').Touch(function(){
					var val_ = $(this).attr('val');
					$('#zj_detail').hide();
					if($(this).hasClass('cur')){
						return;
					}
					$(this).addClass('cur').siblings().removeClass('cur');
					$('#hz,#sth,#sbth,#eth,#ebth').hide();
					$('#'+val_).show();
					!$('#kjup').hasClass('kjdown') &&  $('#kj_code').slideUp(); $('#kjup').addClass('kjdown');
					
					enter.clean_();
					$('#bonus_ p').hide();
					var n_ = {'hz':0,'sth':1,'eth':2,'sbth':3,'ebth':4}[val_];
					$('#bonus_ p').eq(n_).show();
				});
			},
			expect_change:function(now, endtime){
				 this.now = now.getTime();
				 this.endtime_ = new Date(endtime.replace(/-/g , '/'));
				 
				 clearInterval(this.timer);
				 this.timer = setInterval(function (){
					 enter.eachClock();
				 }, fps); 
				 enter.eachClock();
			},
			eachClock:function(){
				this.now += fps;
				var diff = this.endtime_ - this.now;
				var msg = '';
				if(diff >= 0){
					timeout = enter.diffToString(diff,false);
					msg = timeout[1]+''+timeout[2]+':'+zeroStr(timeout[3],2);
					$('#ahk3>strong').html(msg);
				}else{
					msg = '已截止';
					$('#ahk3>strong').html(msg);
					clearInterval(this.timer);
					setTimeout(function(){
						enter.issue();
					},2000);
				}
				 
			},
			diffToString : function(num, iscn) {
			    var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
			    var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
			    for (var i = 0, l = unit.length; i < l; i++) {
			        date[i] = parseInt(num / unit[i]);
			        cnDate[i] = date[i] + cn[i];
			        num %= unit[i];
			    }
			    return iscn ? cnDate : date;
			},
			jz:function(n,m){
				for(var k in n){
					 if(k == m){
						 return n[k];
					 }
				};
			},
			count : function(wf){//计算注数
				var zs = 0;
				if(wf == 'eth'){//二同号比较特殊
					var one = 0, two =0;
					one = $('#'+wf).find('ul:eq(0) li.cur').length;
					two = $('#'+wf).find('ul:eq(1) li.cur').length;
					zs = $('#'+wf).find('div li.cur').length;
					zs += one*two;
				}else{
					zs = $('#'+wf).find('li.cur').length;
					zs = $_sys.C(zs,enter.jz(bx_num,wf));
					if(wf == 'sbth' || wf == 'sth'){
						if($('#'+wf).find('div ul').hasClass('cur')){
							zs += 1;
						}
					}
				}
				
				$('#zs_ cite').eq(0).html(zs);
				$('#zs_ cite').eq(1).html(zs*2);
			},
			winner :function(x){
				var msg = '';
				var arr = [];
				if(x == 'hz'){
					$('#'+x).find('li.cur').each(function(){
						arr.push($(this).attr('v'));
					});
				}else if(x == 'sth'){
					if($('#'+x).find('li.cur').length){
						arr.push('240');
					}
					if($('#'+x).find('div ul').hasClass('cur')){
						arr.push('40');
					}
					if($('#'+x).find('li.cur').length && $('#'+x).find('div ul').hasClass('cur')){
						arr.push('280');
					}
				}else if(x == 'eth'){
					var a,b;
					$('#'+x).find('div ul li').hasClass('cur') && arr.push('15');//复选
						
					a = $('#'+x).find('ul:eq(0) li.cur').length;//第一排
					b = $('#'+x).find('ul:eq(1) li.cur').length;//第二排
					if(a>=1 && b>=1){
						arr.push('80');
						$('#'+x).find('ul:eq(0) li.cur').each(function(){
							var n_ = {'11':0,'22':1,'33':2,'44':3,'55':4,'66':5}[$(this).html()];
							if($('#'+x).find('div ul li').eq(n_).hasClass('cur')){
								arr.push('95');
							}
						});
					}
				}else if(x == 'sbth'){
					if($('#'+x).find('div ul').hasClass('cur')){
						 if($('#'+x).find('ul:eq(0) li.cur').length >=3){
							 var k = '';
							 $('#'+x).find('ul:eq(0) li.cur').each(function(){
								 k += $(this).html()+'';
							 });
							 (k.indexOf('123')>=0 || k.indexOf('234')>=0 || k.indexOf('345')>=0 || k.indexOf('456')>=0) && arr.push('50');
						 }
					}
					$('#'+x).find('div ul').hasClass('cur') && arr.push('10');//三连号
					$('#'+x).find('ul:eq(0) li.cur').length >=3 && arr.push('40');
				}else if(x == 'ebth'){
					$('#'+x).find('ul:eq(0) li.cur').length >=2 && arr.push('8');
					$('#'+x).find('ul:eq(0) li.cur').length >=3 && arr.push('24');
				}
				if(arr.length){
					var a,b;
					arr.sort(function(a,b){return a-b;});
					a = arr[0],b=arr[arr.length-1];//a 最小 b最大
					
					if(a == b){
						msg = '若中奖,奖金 '+a+'元';
					}else{
						msg = '若中奖,奖金 '+a+'元~'+b+'元';
					}
					!$('#zj_detail').html() && $('#zj_detail').slideToggle('fast');
					$('#zj_detail').html(msg);
				}else{
					$('#zj_detail').html('');
					$('#zj_detail').hide();
				}
				
			},clean_ : function(){//左下角清空
				var n = $('#play_tabs span.cur').attr('val');
				$('#'+n).find('li').removeClass('cur');
				$('#'+n).find('ul').removeClass('cur');
				$('#zs_ cite').html('0');
				$('#zj_detail').html('');
				$('#zj_detail').hide();
			},random_ : function(){//机选
				curTime_2 = new Date().getTime();
				if(curTime_2-curTime_ > '800'){
					try{
						navigator.vibrate(300);
					}catch(e){};
					enter.clean_();
					var n_ = $('#play_tabs span.cur').attr('val');
					var m = enter.jz(hz_jxnum,n_);
					
					m = Random(m);
					if(n_ == 'eth'){
						$('#'+n_).find('li').eq(m[0]-1).addClass('cur');
						$('#'+n_).find('li').eq(m[3]+5).addClass('cur');
					}else if(n_ == 'ebth' || n_ == 'sbth'){
						$('#'+n_).find('li').eq(m[0]-1).addClass('cur');
						$('#'+n_).find('li').eq(m[2]-1).addClass('cur');
						n_ == 'sbth' && $('#'+n_).find('li').eq(m[4]-1).addClass('cur');
					}else{
						$('#'+n_).find('li').eq(m[0]-1).addClass('cur');
					}
					enter.count(n_);
					enter.winner(n_);
					curTime_ = new Date().getTime();
				}
			}
	};
	return {
		init:enter.init()
	};
}();
CP.enter.init();