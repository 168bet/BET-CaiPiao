/*
 * Author: weige
 * Date: 2014-7-22
 */
var PollNum = localStorage.getItem('jclq_hh_PollNum');
var Jclq_hh = {
		initial: function(){
			Jclq_hh.add_C();//初始化添加对阵内容
			
			Jclq_hh.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/jclq/new_jclq_hh.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					D.load(close);
					var R = $(xml).find('Resp');
					
					var rs = R.find('rows');
					!rs.length && D.tx('暂无赛事可以投注');
					
					var html ='';
					
					var PollNum_t = [],PollNum_c = [];//t 编号  c 投注内容
					if(PollNum){
						var PollNum1 = PollNum.split('|')[0].split(',');
						for(var n = 0; n<PollNum1.length; n++){
							var xo = PollNum1[n].split('>');
							PollNum_t[n] = xo[0];
							PollNum_c[n] = xo[1];
						}
					}
					rs.each(function(aa){
						var addesc = $(this).attr('addesc');
						var r = $(this).find('row');
						html += '<section class="jclqhh"><div class="sfcTitle">'+addesc+'&nbsp;'+r.length+'场比赛';
						if(aa == 0 || PollNum){//第一个 或者编辑过来的显示
							html += '<em class="up"></em></div><div>';
						}else{
							html += '<em class="up down"></em></div><div style="display:none;">';
						}
						r.each(function(){
							var itemid = $(this).attr('itemid');
							var mid = $(this).attr('mid');
							var hn = $(this).attr('hn');//主队
							var gn = $(this).attr('gn');//客队
							var et = $(this).attr('et');//停售
							var mt = $(this).attr('mt');//比赛
							var mname = $(this).attr('mname');//联赛名
							var cl = $(this).attr('cl');//联赛颜色
							var close = $(this).attr('close');//让球数
							var zclose = $(this).attr('zclose');//150.5
							var name = $(this).attr('name');//周二301
							var bet3 = $(this).attr('bet3');//平均欧指 主
							var bet0 = $(this).attr('bet0');//平均欧指 平
							var isale = $(this).attr('isale');//开售状态
							var sf = $(this).attr('sf');//胜负赔率 1.65,1.75
							var rfsf = $(this).attr('rfsf');//胜负赔率 1.65,1.75
							var dxf = $(this).attr('dxf');//胜负赔率 1.65,1.75
							var sfc = $(this).attr('sfc');//胜负赔率 3.95,4.1,7.7,14.0,28.0,38.0,4.0,4.2,7.8,15.5,30.0,40.0
							rfsf = rfsf.split(',');
							var k_sf = rfsf[0];
							var z_sf = rfsf[1];
							dxf = dxf.split(',');
							var k_dxf = dxf[0];
							var z_dxf = dxf[1];
							var end_time = et.substr(11,5);//停售时间
							if(mname == 'WNBA'){
								hn = Count.n(hn);
								gn = Count.n(gn);
							}else{
								hn = hn.substr(0,5);
								gn = gn.substr(0,5);
							}
							
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)],
								r,d;
								pc = pc.split('+');
								if(pc.length == '2'){
									r = pc[0].split('=')[1].split('/');
									d = pc[1].split('=')[1].split('/');
								}else{
									if(pc.indexOf('RFSF')!='-1'){
										r = pc[0].split('=')[1].split('/');
										d = '';
									}else{
										r = '';
										d = pc[0].split('=')[1].split('/');
									}
								}
								html += '<ul class="sfcxs hhzpk" t="'+itemid+'" v="y" r="'+r+'" d="'+d+'">';
							}else{
								html += '<ul class="sfcxs hhzpk" t="'+itemid+'">';
							}
							html += '<li><em>'+name.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite></li>';
							html += '<li>';
							if(close.indexOf('-')>=0)
								var tmp_close='<i class="blue">('+close+')</i>';
								else 
							var tmp_close='<i class="red">('+close+')</i>';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)],
								r,d;
								pc = pc.split('+');
								if(pc.length == '2'){
									r = pc[0].split('=')[1].split('/');
									d = pc[1].split('=')[1].split('/');
								}else{
									if(pc.indexOf('RFSF')!='-1'){
										r = pc[0].split('=')[1].split('/');
										d = '';
									}else{
										r = '';
										d = pc[0].split('=')[1].split('/');
									}
								}
								html += '<p class="spfzpk"><em class="rq">让分</em><span v="0" '+(r.indexOf('0')>=0?'class="cur"':'')+'><b>'+gn+'</b><cite>'+k_sf+'</cite></span><span v="3" '+(r.indexOf('3')>=0?'class="cur"':'')+'><b>'+hn+tmp_close+'</b><cite>'+z_sf+'</cite></span></p>';
								html += '<p class="spfzpk"><em>猜总分</em><span v="3"  '+(d.indexOf('3')>=0?'class="cur"':'')+'><b>&gt;'+zclose+'分</b><cite>'+k_dxf+'</cite></span><span v="0" '+(d.indexOf('0')>=0?'class="cur"':'')+'><b>&lt;'+zclose+'分</b><cite>'+z_dxf+'</cite></span></p>';
							}else{
								html += '<p class="spfzpk"><em class="rq">让分</em><span v="0"><b>'+gn+'</b><cite>'+k_sf+'</cite></span><span v="3"><b>'+hn+tmp_close+'</b><cite>'+z_sf+'</cite></span></p>';
								html += '<p class="spfzpk"><em>猜总分</em><span v="3"><b>&gt;'+zclose+'分</b><cite>'+k_dxf+'</cite></span><span v="0"><b>&lt;'+zclose+'分</b><cite>'+z_dxf+'</cite></span></p>';
							}
							html += '</li></ul>';
						});
						html +='</div></section>';
					});
					
					jQuery('#content_').html(html);
					
					Jclq_hh.my_play();
					Jclq_hh.bind_delay();//必须有对阵之后的绑定事件
				}
			});
			
			
		},
		bind_delay: function(){
			$('.sfcTitle').Touch(function(){//星期
				$(this).find('em').toggleClass('down');
				$(this).next().slideToggle(300);
			});
			$('#content_').find('ul.sfcxs p.spfzpk span').Touch(function(){
				var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
				var  n_ = 15;
				if(c_ >= n_ && !$(this).parent().parent().find('.cur').length){
					D.tx('最多选'+n_+'场');
					return;
				}
				
				$(this).toggleClass('cur');
				
				if($(this).parent().parent().find('span').hasClass('cur')){//当前场次有选择时进来
					var r = '',d = '';
					$(this).parent().parent().find('p:eq(0)').find('span.cur').each(function(){
						r += $(this).attr('v')+',';
					});
					r = r.substr(0,r.length-1);
					$(this).parent().parent().find('p:eq(1)').find('span.cur').each(function(){
						d += $(this).attr('v')+',';
					});
					d = d.substr(0,d.length-1);
					$(this).parent().parent().parent().attr('v','y');//ul
					$(this).parent().parent().parent().attr('r',r);
					$(this).parent().parent().parent().attr('d',d);
				}else{
					$(this).parent().parent().parent().removeAttr('v');//ul
					$(this).parent().parent().parent().removeAttr('r');// 让分
					$(this).parent().parent().parent().removeAttr('d');// 大小分
				}
				Jclq_hh.my_play();
			});
		},
		my_play: function(){//已选多少场比赛
			var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
			jQuery('#c_').html(c_);
		},
		bind_: function(){
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
			jQuery('#wanfa_').Touch(function(){
				$(this).toggleClass('hmTit');
				$(this).next().toggle();
			});
			
			jQuery('.deleted').Touch(function(){
				jQuery('#content_ ul.sfcxs[v=y]').removeAttr('v').removeAttr('r').removeAttr('d').find('.cur').removeClass('cur');
				
				localStorage.removeItem('jclq_hh_PollNum');
				Jclq_hh.my_play();
			});
			jQuery('#isOk_').click(function(){
				if(parseInt($('#c_').html())>1){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var rf = $(this).find('li:eq(1) p:eq(0)').html();
						var dx = $(this).find('li:eq(1) p:eq(1)').html();
//						var o = $(this).attr('p').split(',');//赔率
						var r = $(this).attr('r');//让分胜负
						var d = $(this).attr('d');//大小分
						
		                c += '<li t="'+$(this).attr('t')+'" d="'+d+'" r="'+r+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpk">'+rf+'</div>';
		                c += '<div class="spfzpk">'+dx+'</div>';
		                c += '</li>';
					});
					
					localStorage.setItem('jclq_hh_SelectNum',c);
					localStorage.removeItem('jclq_hh_PollNum');
					window.location.href='#class=url&xo=jclq/hh/ture.html';
				}else{
					D.tx('请至少选择2场比赛');
				}
			});
		}
}
Jclq_hh.initial();