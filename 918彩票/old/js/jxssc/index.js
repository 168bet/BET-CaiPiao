/*
 * Author: weige
 * Date:  2014-06-23
 */
var navScroll;
CP.Jxssc = function(){
	var c_ = '<div id="c" style="position: absolute; z-index: 99999; top: 454px;  background: none repeat scroll 0% 0% rgb(240, 61, 61); opacity: 0.15; width:2rem; line-height:2rem; border-radius:2rem; -webkit-border-radius:2rem; -moz-border-radius:2rem"></div>';
	var speed_ = '200';
	var f_Wobble = '0';
	var curTime_ = new Date().getTime();
	var fps = 1000;
	var exhz = {
			'0': 1,'1': 1,'2': 2,'3': 2,'4': 3,'5': 3,'6': 4,'7': 4,'8': 5,'9': 5,'10': 5,'11': 4,'12': 4,'13': 3,'14': 3,'15': 2,'16': 2,'17': 1,'18': 1
	};
	var wf_name = {//玩法
			'dxds': '大小单双','yzx': '一星直选','ezx': '二星直选','szx': '三星直选','wzx': '五星直选','wtx': '五星通选','ezux': '二星组选',
			'szs': '三星组三','szl': '三星组六','ehz': '二星和值'
	};
	var max_length = {//对应玩法最多选球个数
			'yzx': 4,//一星直选
			'ezux': 6,//二星组六
			'szl': 8//三星组六
	};
	var enter = {
		init : function(){
			topNavInit();
			enter.issue();
			enter.tab();
			enter.bind();
		},
		issue : function(){
			$.ajax({
				url : '/trade/info.go?gid=20',
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
									bb +='<b '+(n==c.length-1?'class="red"':'')+'>'+c[n]+'</b>';
								}
								$('#kj_ div').attr('class','jxsscball pdTop03 clearfix');
								$('#kj_ p').html(p+'期开奖 <cite>一星直选</cite>');
								$('#kj_ div').html(bb+'<em id=\'kjup\' class="kjup kjdown"></em>');
								
							}else{
								$('#kj_ div').attr('class','pdTop03 k3waitkj clearfix');
								$('#kj_ p').html('<p class="pdLeft06">'+p+'期开奖中…</p>');
								$('#kj_ div').html('<cite class="k3time"></cite><span class="left">等待开奖</span><em id=\'kjup\' class="kjup kjdown"></em>');
							}
						}else{
							html +='<ul><li class="wb20">'+p+'期</li>';
							html +='<li class="jxsscdice jxsscwb18">';
							if(c!=''){
								c = c.split(',');
								var decade,unit,hundreds,a,bb,c1;
								a = c[2];//百位
								bb = c[3];//十位
								c1 = c[4];//个位
								
								for(var n = 0; n<c.length; n++){
									html +='<b '+(n==c.length-1?'class="red"':'')+'>'+c[n]+'</b>';
								}
								decade = enter.c_(bb);
								unit = enter.c_(c1);
								hundreds = enter.cc_(a,bb,c1);
								html +='</li><li class="wb21">'+decade+'</li><li class="wb21">'+unit+'</li><li class="wb19">'+hundreds+'</li></ul>';
							}else{
								html +='<b>-</b><b>-</b><b>-</b><b>-</b><b>-</b></li><li class="wb21">-</li>';
								html +='<li class="wb21">-</li><li class="wb19">-</li></ul>';
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
			$('#c_c').click(function(){
				$('#kj_code').slideToggle();
				$('#kjup').toggleClass('kjdown');
			});
			$('#kj_code').click(function(){
				$('#kj_code').slideUp();
				$('#kjup').addClass('kjdown');
			});
			//右上角菜单显示或隐藏
			$("#pullIco").click(function(){
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
			$('#shake').click(function(){enter.random_();});
			
			
			$('#dxds div.jxsscxhBall div:eq(0) b').click(function(){//大小单双
				var o = $(this),g = 'dxds',
				b = $('#dxds li:eq(0)');
				if($(this).hasClass('red')){
					$(this).removeClass('red');
					
					enter.remove_(o, b ,g);
				}else{
					$(this).parent().parent().find('.red').removeClass('red');
					$(this).addClass('red');
					
					enter.move_(o, b, g);
				}
				enter.count('dxds');
			});
			$('#dxds div.jxsscxhBall div:eq(1) b').click(function(){
				var o = $(this),g = 'dxds',
				b = $('#dxds li:eq(1)');
				if($(this).hasClass('red')){
					$(this).removeClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).parent().parent().find('.red').removeClass('red');
					$(this).addClass('red');
					
					enter.move_(o, b, g);
				}
				enter.count('dxds');
			});
			$('#yzx div.jxsscxhBall p b').click(function(){//一星直选
				var n = enter.jz(max_length,'yzx');
				if(!$(this).hasClass('red') && $('#yzx div.jxsscxhBall').find('.red').length>=n){
					D.tx('亲,一星直选最多只能选择'+n+'个号码!');
					return ;
				}
				var o = $(this),g = 'yzx',
				b = $('#yzx li:eq(4)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				
				enter.count('yzx');
			});
			$('#ezx div:eq(0) b').click(function(){//二星直选
				var o = $(this),g = 'ezx',
				b = $('#ezx li:eq(3)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('ezx');
			});
			$('#ezx div:eq(1) b').click(function(){
				var o = $(this),g = 'ezx',
				b = $('#ezx li:eq(4)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('ezx');
			});
			$('#szx div:eq(0) b').click(function(){//三星直选
				var o = $(this),g = 'szx',
				b = $('#szx li:eq(2)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('szx');
			});
			$('#szx div:eq(1) b').click(function(){
				var o = $(this),g = 'szx',
				b = $('#szx li:eq(3)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('szx');
			});
			$('#szx div:eq(2) b').click(function(){
				var o = $(this),g = 'szx',
				b = $('#szx li:eq(4)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('szx');
			});
			$('#wzx div:eq(0) b').click(function(){//五星直选
				var o = $(this),g = 'wzx',
				b = $('#wzx li:eq(0)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wzx');
			});
			$('#wzx div:eq(1) b').click(function(){
				var o = $(this),g = 'wzx',
				b = $('#wzx li:eq(1)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wzx');
			});
			$('#wzx div:eq(2) b').click(function(){
				var o = $(this),g = 'wzx',
				b = $('#wzx li:eq(2)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wzx');
			});
			$('#wzx div:eq(3) b').click(function(){
				var o = $(this),g = 'wzx',
				b = $('#wzx li:eq(3)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wzx');
			});
			$('#wzx div:eq(4) b').click(function(){
				var o = $(this),g = 'wzx',
				b = $('#wzx li:eq(4)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wzx');
			});
			$('#wtx div:eq(0) b').click(function(){//五星通选
				var o = $(this),g = 'wtx',
				b = $('#wtx li:eq(0)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wtx');
			});
			$('#wtx div:eq(1) b').click(function(){
				var o = $(this),g = 'wtx',
				b = $('#wtx li:eq(1)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wtx');
			});
			$('#wtx div:eq(2) b').click(function(){
				var o = $(this),g = 'wtx',
				b = $('#wtx li:eq(2)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wtx');
			});
			$('#wtx div:eq(3) b').click(function(){
				var o = $(this),g = 'wtx',
				b = $('#wtx li:eq(3)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wtx');
			});
			$('#wtx div:eq(4) b').click(function(){
				var o = $(this),g = 'wtx',
				b = $('#wtx li:eq(4)');
				if($(this).hasClass('red')){
					$(this).toggleClass('red');
					enter.remove_(o, b, g);
				}else{
					$(this).toggleClass('red');
					enter.move_(o, b, g);
				}
				enter.count('wtx');
			});
			$('#ezux b').click(function(){//二星组选
				var n = enter.jz(max_length,'ezux');
				if(!$(this).hasClass('red') && $('#ezux').find('.red').length>=n){
					D.tx('亲,二星组选最多只能选择'+n+'个号码!');
					return ;
				}
				$(this).toggleClass('red');
				enter.count('ezux');
			});
			$('#szs b').click(function(){//三星组三
				$(this).toggleClass('red');
				enter.count('szs');
			});
			$('#szl b').click(function(){//三星组六
				var n = enter.jz(max_length,'szl');
				if(!$(this).hasClass('red') && $('#szl').find('.red').length>=n){
					D.tx('亲,三星组六最多只能选择'+n+'个号码!');
					return ;
				}
				$(this).toggleClass('red');
				enter.count('szl');
			});
			$('#ehz b').click(function(){//二星和值
				$(this).toggleClass('red');
				enter.count('ehz');
			});
			$('#pay_').on('click',function(){
				var n = $('#play_tabs li.cur').attr('v');
				var zs = parseInt($('#zs_ cite:eq(0)').html());
				var zs1 = $('#'+n).find('b.red').length;
				if(zs == 0 || zs1 == 0){
					enter.random_();
				}else{
					var code = '';
					code = enter.code(n,zs);
					localStorage.setItem('jxsscSelectNum',code);
					location.href = '#class=url&xo=jxssc/ture.html';
				}
			});
			$('#tx_c').click(function(){
				$(this).slideUp();
			});
			$('.deleted').on('click',function(){
				enter.clean_();
			});
		},code:function(n,zs){//投注的local
			var Ball="";
			if(n == 'dxds'){
				Ball += $("#"+n).find('div.jxsscxhBall').find('div:eq(0)').find('.red').html()+' ';
				Ball += $("#"+n).find('div.jxsscxhBall').find('div:eq(1)').find('.red').html();
				Ball += '_大小单双_' + zs;
			}else if(n == 'yzx'){
				$("#"+n).find('b.red').each(function(){
					Ball += $(this).html()+' ';
				});
				Ball = Ball.substring(0,Ball.length-1);
				Ball += '_一星直选_' + zs;
			}else if(n == 'ezx'){
				$("#"+n).find('div:eq(0)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(1)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += '_二星直选_' + zs;
			}else if(n == 'szx'){
				$("#"+n).find('div:eq(0)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(1)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(2)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += '_三星直选_' + zs;
			}else if(n == 'wzx' || n == 'wtx'){
				$("#"+n).find('div:eq(0)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(1)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(2)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(3)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += ' ';
				$("#"+n).find('div:eq(4)').find('.red').each(function(){
					Ball += $(this).html()+'';
				});
				Ball += (n =='wzx'?'_五星直选_':'_五星通选_') + zs;
			}else if(n == 'ezux'){
				$("#"+n).find('b.red').each(function(){
					Ball += $(this).html()+' ';
				});
				Ball = Ball.substring(0,Ball.length-1);
				Ball += '_二星组选_' + zs;
			}else if(n == 'szs'){
				$("#"+n).find('b.red').each(function(){
					Ball += $(this).html()+' ';
				});
				Ball = Ball.substring(0,Ball.length-1);
				Ball += '_三星组三_' + zs;
			}else if(n == 'szl'){
				$("#"+n).find('b.red').each(function(){
					Ball += $(this).html()+' ';
				});
				Ball = Ball.substring(0,Ball.length-1);
				Ball += '_三星组六_' + zs;
			}else if(n == 'ehz'){
				$("#"+n).find('b.red').each(function(){
					Ball += $(this).html()+' ';
				});
				Ball = Ball.substring(0,Ball.length-1);
				Ball += '_二星和值_' + zs;
			}
			return Ball;
		},tab:function(){
			$('#play_tabs li').click(function(){
				var v = $(this).attr('v');
				if($(this).hasClass('cur')){
					return;
				}
				$(this).addClass('cur').siblings().removeClass('cur');
				$('#dxds,#yzx,#ezx,#szx,#wzx,#wtx,#ezux,#szs,#szl,#ehz').hide();
				$('#'+v).show();
				!$('#kjup').hasClass('kjdown') &&  $('#kj_code').slideUp(); $('#kjup').addClass('kjdown');
				
				enter.clean_();
				$('#bonus_ div').hide();
				var n_ = {'dxds':0,'yzx':1,'ezx':2,'szx':3,'wzx':4,'wtx':5,'ezux':6,'szs':7,'szl':8,'ehz':9}[v];
				var o = $(this).prev() .length ? $(this).prev() .last() [0] : $(this)[0];
				navScroll.scrollToElement(o,1500);
				$('#bonus_ div').eq(n_).show();
				enter.color_();
			});
		},expect_change:function(now, endtime){
			 this.now = now.getTime();
			 this.endtime_ = new Date(endtime.replace(/-/g , '/'));
			 
			 clearInterval(this.timer);
			 this.timer = setInterval(function (){
				 enter.eachClock();
			 }, fps); 
			 enter.eachClock();
		},eachClock:function(){//Countdown
			this.now += fps;
			var diff = this.endtime_ - this.now;
			var msg = '';
			if(diff >= 0){
				timeout = enter.diffToString(diff,false);
				msg = timeout[1]+''+timeout[2]+':'+zeroStr(timeout[3],2);
				$('#jxssc>strong').html(msg);
			}else{
				msg = '已截止';
				$('#jxssc>strong').html(msg);
				clearInterval(this.timer);
				setTimeout(function(){
					issue();
				},2000);
			}
			 
		},diffToString : function(num, iscn) {
		    var unit = [8.64E+7,3.6E+6,6E+4,1E+3,1], date = [], cnDate = [];
		    var cn = '\u5929,\u65f6,\u5206,\u79d2,\u6beb\u79d2'.split(',');
		    for (var i = 0, l = unit.length; i < l; i++) {
		        date[i] = parseInt(num / unit[i]);
		        cnDate[i] = date[i] + cn[i];
		        num %= unit[i];
		    }
		    return iscn ? cnDate : date;
		},jz:function(n,m){
			for(var k in n){
				 if(k == m){
					 return n[k];
				 }
			};
		},
		count : function(wf){//计算注数
			var zs = 0;
			if(wf == 'dxds'){//大小单双
				var one = 0, two =0;
				one = $('#'+wf).find('div.jxsscxhBall div:eq(0)').find('.red').length;
				two = $('#'+wf).find('div.jxsscxhBall div:eq(1)').find('.red').length;
				if(one && two)zs = 1;
			}else if(wf == 'yzx'){
				zs = $('#'+wf).find('div.jxsscxhBall').find('.red').length;
			}else if(wf == 'ezx' || wf == 'szx' ||  wf == 'wzx' ||  wf == 'wtx'){
				var one = 0, two = 0, three = 0, four = 0, five = 0;
				one = $('#'+wf).find('div:eq(0)').find('.red').length;
				two = $('#'+wf).find('div:eq(1)').find('.red').length;
				if(wf == 'szx'){
					three = $('#'+wf).find('div:eq(2)').find('.red').length;
					zs = one*two*three;
				}else if(wf == 'wzx' ||  wf == 'wtx'){
					three = $('#'+wf).find('div:eq(2)').find('.red').length;
					four = $('#'+wf).find('div:eq(3)').find('.red').length;
					five = $('#'+wf).find('div:eq(4)').find('.red').length;
					zs = one*two*three*four*five;
				}else{
					zs = one*two;
				}
			}else if(wf == 'ezux' || wf == 'szs' || wf == 'szl'){
				var n = $('#'+wf).find('.red').length;
				if(wf == 'ezux'){
					if(n==2){
						zs = 1;
					}else if(n>2){
						zs = $_sys.C(n,2)+n;
					}
				}else if(wf == 'szs'){
					if(n>=2){
						zs = $_sys.C(n,2)*2;
					}
				}else{
					if(n>=3){
						zs = $_sys.C(n,3);
					}
				}
			}else if(wf == 'ehz'){
				var n = $('#'+wf).find('.red');
				n.each(function(){
					zs += enter.jz(exhz,$(this).html());
				});
			}
			
			$('#zs_ cite').eq(0).html(zs);
			$('#zs_ cite').eq(1).html(zs*2);
		},move_: function(star,end,g){
			$('#c').show();
			var w = star.width();
			var h = star.height();
			var o = star.offset();
			var t = parseInt(o.top);
			var l = parseInt(o.left);
			$('body').append(c_);
			$('#c').css({left:l,top:t,width:w,height:h});
			
			//-------------------------------------------------
			var w_ = end.width();
			var h_ = end.height();
			var o_ = end.offset();
			var t_ = parseInt(o_.top);
			var l_ = parseInt(o_.left);
			t_ += (h_-h);
			l_ += (w_-w)/2;
			$('#c').animate({left:l_,top:t_},speed_,function(){
				$('#c').remove();
				if(g == 'dxds'){
						end.attr('class','cur2');
						end.find('span').html(star.html());
				}else{
					var red = star.parent().find('.red');
					var cl_ = red.length;
					cl_ = (cl_>8 && 'cur2 jxssclist3')||(cl_>4 && 'cur2 jxssclist2')||(cl_>0 && 'cur2')||'cur';
					end.attr('class',cl_);
					var html = '';
					red.each(function(){
						html+='<em>'+$(this).html()+'</em>';
					});
					end.find('span').html(html);
				}
			});
		},remove_: function(star,end,g){
			if(g == 'dxds'){
				end.attr('class','cur');
				end.find('span').html(end.attr('v'));
			}else{
				var red = star.parent().find('.red');
				var cl_ = red.length;
				cl_ = (cl_>8 && 'cur2 jxssclist3')||(cl_>4 && 'cur2 jxssclist2')||(cl_>0 && 'cur2')||'cur';
				end.attr('class',cl_);
				if(!red.length){
					end.find('span').html(end.attr('v'));
				}else{
					var html = '';
					red.each(function(){
						html+='<em>'+$(this).html()+'</em>';
					});
					end.find('span').html(html);
				}
			}
		},c_: function(x){
			var a = '';
			if(x>4){
				if(x%2 == 0){
					a = '大双';
				}else{
					a = '大单';
				}
			}else{
				if(x%2 == 0){
					a = '小双';
				}else{
					a = '小单';
				}
			}
			return a;
		},cc_: function(x,o,y){
			var a = '';
			if(x == o && x == y && o == y){
				a = '豹子';
			}else{
				if(x == o || x == y || o == y){
					a = '组三';
				}else{
					a = '组六';
				}
			}
			return a;
		},color_: function(){//切换的时候改版开奖号码的颜色
			var n = $('#play_tabs li.cur').attr('v');
			$('#kj_code div.k3kjlist ul').each(function(){
				$(this).find('li.jxsscdice').find('b').each(function(aa){
					if(n == 'dxds' || n == 'ezx' || n == 'ezux' || n == 'ehz'){//2
						if(aa == 3 || aa == 4){
							!$(this).hasClass('red') && $(this).addClass('red');
						}else{
							$(this).hasClass('red') && $(this).removeClass('red');
						}
					}else if(n == 'yzx'){//1
						if(aa == 4){
							!$(this).hasClass('red') && $(this).addClass('red');
						}else{
							$(this).hasClass('red') && $(this).removeClass('red');
						}
					}else if(n == 'szx' || n == 'szs' || n == 'szl'){//3
						if(aa == 2 || aa == 3 || aa == 4){
							!$(this).hasClass('red') && $(this).addClass('red');
						}else{
							$(this).hasClass('red') && $(this).removeClass('red');
						}
					}else if(n == 'wzx' || n == 'wtx'){//5
						!$(this).hasClass('red') && $(this).addClass('red');
					}
				});
			});
			$('#kj_ div.jxsscball b').each(function(aa){
				if(n == 'dxds' || n == 'ezx' || n == 'ezux' || n == 'ehz'){//2
					if(aa == 3 || aa == 4){
						!$(this).hasClass('red') && $(this).addClass('red');
					}else{
						$(this).hasClass('red') && $(this).removeClass('red');
					}
				}else if(n == 'yzx'){//1
					if(aa == 4){
						!$(this).hasClass('red') && $(this).addClass('red');
					}else{
						$(this).hasClass('red') && $(this).removeClass('red');
					}
				}else if(n == 'szx' || n == 'szs' || n == 'szl'){//3
					if(aa == 2 || aa == 3 || aa == 4){
						!$(this).hasClass('red') && $(this).addClass('red');
					}else{
						$(this).hasClass('red') && $(this).removeClass('red');
					}
				}else if(n == 'wzx' || n == 'wtx'){//5
					!$(this).hasClass('red') && $(this).addClass('red');
				}
			});
			
			$('#kj_ p cite').html(enter.jz(wf_name, n));
		},clean_ : function(){//左下角清空
			var n = $('#play_tabs li.cur').attr('v');
			$('#'+n).find('b').removeClass('red');
			$('#'+n).find('b').removeClass('red');
			$('#'+n).find('li[m=y]').each(function(){
				$(this).find('span').html($(this).attr('v'));
				$(this).attr('class','cur');
			});
			
			$('#zs_ cite').html('0');
		},random_ : function(){//机选
			curTime_2 = new Date().getTime();
			var n = $('#play_tabs li.cur').attr('v');
			sp = {'dxds':'1000','yzx':'500','ezx':'1000','szx':'1500','wzx':'2500','wtx':'2500'}[n]||'500';
			if(curTime_2-curTime_ > sp || f_Wobble == '0'){
				f_Wobble++;
				try{
					navigator.vibrate(300);
				}catch(e){};
				enter.clean_();
				var n_ = $('#play_tabs li.cur').attr('v'),
				m1,m2,m3,m4,m5;
				if(n_ == 'dxds'){
					m1 = Random(2)[0]-1;
					m2 = Random(2)[0]-1;
					m3 = Random(2)[1]-1;
					$('#'+n_).find('div.jxsscxhBall').find('div:eq(0)').find('p:eq('+m3+')').find('b:eq('+m2+')').click();
					setTimeout(function(){
						$('#'+n_).find('div.jxsscxhBall').find('div:eq(1)').find('p:eq('+m1+')').find('b:eq('+m3+')').click();
					},500);
				}else if(n_ == 'yzx'){
					m1 = Random(10)[5]-1;
					$('#'+n_).find('div b').eq(m1).click();
				}else if(n_ == 'ezx'){
					m1 = Random(10)[5]-1;
					m2 = Random(10)[7]-1;
					$('#'+n_).find('div:eq(0)').find('b').eq(m1).click();
					setTimeout(function(){
						$('#'+n_).find('div:eq(1)').find('b').eq(m2).click();
					},500);
				}else if(n_ == 'szx'){
					m1 = Random(10)[5]-1;
					m2 = Random(10)[7]-1;
					m3 = Random(10)[2]-1;
					$('#'+n_).find('div:eq(0)').find('b').eq(m1).click();
					setTimeout(function(){
						$('#'+n_).find('div:eq(1)').find('b').eq(m2).click();
					},500);
					setTimeout(function(){
						$('#'+n_).find('div:eq(2)').find('b').eq(m3).click();
					},1000);
				}else if(n_ == 'wzx' || n_ == 'wtx'){
					m1 = Random(10)[5]-1;
					m2 = Random(10)[7]-1;
					m3 = Random(10)[2]-1;
					m4 = Random(10)[9]-1;
					m5 = Random(10)[3]-1;
					$('#'+n_).find('div:eq(0)').find('b').eq(m1).click();
					setTimeout(function(){
						$('#'+n_).find('div:eq(1)').find('b').eq(m2).click();
					},500);
					setTimeout(function(){
						$('#'+n_).find('div:eq(2)').find('b').eq(m3).click();
					},1000);
					setTimeout(function(){
						$('#'+n_).find('div:eq(3)').find('b').eq(m3).click();
					},1500);
					setTimeout(function(){
						$('#'+n_).find('div:eq(4)').find('b').eq(m4).click();
					},2000);
					setTimeout(function(){
						$('#'+n_).find('div:eq(5)').find('b').eq(m5).click();
					},2500);
				}else if(n_ == 'ezux' || n_ == 'szs'){
					m1 = Random(10);
					m2 = m1[4]-1;
					m3 = m1[7]-1;
					$('#'+n_).find('b').eq(m2).addClass('red');
					$('#'+n_).find('b').eq(m3).addClass('red');
				}else if(n_ == 'szl'){
					m1 = Random(10);
					m2 = m1[4]-1;
					m3 = m1[7]-1;
					m4 = m1[2]-1;
					$('#'+n_).find('b').eq(m2).addClass('red');
					$('#'+n_).find('b').eq(m3).addClass('red');
					$('#'+n_).find('b').eq(m4).addClass('red');
				}else if(n_ == 'ehz'){
					m1 = Random(19)[5]-1;
					$('#'+n_).find('b').eq(m1).addClass('red');
				}
				enter.count(n_);
				curTime_ = new Date().getTime();
			}
		}
	};
	return {
		init:enter.init()
	};
}();
function topNavInit() {
	setTimeout(function(){
		 var k = $('#secNav ul');
		    var f = 0;
		    $('#secNav li') .each(function () {
		        f += $(this) .width() + parseInt($(this).css('margin-left') .replace('px', ''))*2+2;
		    });
		    k.width(f);
		    navScroll = new iScroll('secNav', {
		        snap: 'li',
		        hScrollbar: false,
		        hScroll: true,
		        vScroll: false
		    });
	},100 );
}
CP.Jxssc.init();