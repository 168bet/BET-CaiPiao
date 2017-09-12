/*
 * Author: weige
 * Date: 2014-7-22
 */
var PollNum = localStorage.getItem('jclq_rfsf_PollNum');
var Jclq = {
		initial: function(){
			Jclq.add_C();//初始化添加对阵内容
			
			Jclq.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/jclq/rfsf.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					D.load(close);
					var R = $(xml).find('Resp');
					var pid = R.attr('pid');
					$('#expect').val(pid);//北单当前场次期号
					
					var rs = R.find('rows');

					!rs.length && D.tx('暂无赛事可以投注');
					var html ='';
					
					var PollNum_t = [],PollNum_c = [];//t 编号  c 投注内容
					if(PollNum){
						var PollNum1 = PollNum.split('|')[0].split(',');
						for(var n = 0; n<PollNum1.length; n++){
							PollNum_t[n] = PollNum1[n].split('=')[0];
							PollNum_c[n] = PollNum1[n].split('=')[1];
						}
					}
					rs.each(function(aa){
						var addesc = $(this).attr('addesc');
						var r = $(this).find('row');
						html += '<section class="jclqVs"><div class="sfcTitle">'+addesc+'&nbsp;'+r.length+'场比赛';
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
							var rfsf = $(this).attr('rfsf');//让分胜负赔率 1.65,1.75
							var isale = $(this).attr('isale');//开售状态
							rfsf = rfsf.split(',');
							var k_sf = rfsf[0];
							var z_sf = rfsf[1];
							var end_time = et.substr(11,5);//停售时间
							if(mname == 'WNBA'){
								hn = Count.n(hn);
								gn = Count.n(gn);
							}else{
								hn = hn.substr(0,5);
								gn = gn.substr(0,5);
							}
							if((2 & isale) > 0){
								if(PollNum && PollNum_t.indexOf(itemid)>=0){
									var pc = PollNum_c[PollNum_t.indexOf(itemid)];
									pc = pc.split('/');
									html += '<ul class="sfcxs" t="'+itemid+'" p="'+rfsf+'" v="y" c="'+pc+'">';
								}else{
									html += '<ul class="sfcxs" t="'+itemid+'" p="'+rfsf+'">';
								}
								html += '<li><em>'+name.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite></li>';
								html += '<li><p class="spfzpk spfzpk2">';
								if(close.indexOf('-')>=0)
									var tmp_close='<i class="blue">'+(close=='0'?'':'('+(close.indexOf('-')>=0?close:'+'+close)+')');
									else 
									var tmp_close='<i class="red">'+(close=='0'?'':'('+(close.indexOf('-')>=0?close:''+close)+')');
								
								if(PollNum && PollNum_t.indexOf(itemid)>=0){
									var pc = PollNum_c[PollNum_t.indexOf(itemid)];
									html += '<span v="0" sp="'+k_sf+'" '+(pc.indexOf('0')>=0?'class="cur"':'')+'><em>'+gn+'</em><cite>胜</cite></span><b>VS</b><span v="3" sp="'+z_sf+'" '+(pc.indexOf('3')>=0?'class="cur"':'')+'><em>'+hn+tmp_close+'</i></em><cite>胜</cite></span>';
								}else{
									html += '<span v="0" sp="'+k_sf+'"><em>'+gn+'</em><cite>胜</cite></span><b>VS</b><span v="3" sp="'+z_sf+'"><em>'+hn+tmp_close+'</i></em><cite>胜</cite></span>';
								}
								html += '</p><p class="spfpl"><span>赔率'+k_sf+'</span><span>赔率'+z_sf+'</span></p>';
								html += '</li></ul>';
							}
						});
						html +='</div></section>';
					});
					
					jQuery('#content_').html(html);
					
					Jclq.my_play();
					Jclq.bind_delay();//必须有对阵之后的绑定事件
				}
			});
			
			
		},
		bind_delay: function(){
			$('#content_').find('section').each(function(){
				var t = $(this).find('div:eq(1) ul').length;
				if(!t){
					$(this).find('div:eq(0)').hide();
				}else{
					$(this).find('div:eq(0) label').html(t);
				}
			});
			$('.sfcTitle').Touch(function(){//星期
				$(this).find('em').toggleClass('down');
				$(this).next().slideToggle(300);
			});
			$('#content_').find('ul.sfcxs p.spfzpk span').Touch(function(){
				var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
				var  n_ = 15;
				if(c_ >= n_ && !$(this).parent().find('.cur').length){
					D.tx('最多选'+n_+'场');
					return;
				}
				
				$(this).toggleClass('cur');
				
				if($(this).parent().find('span').hasClass('cur')){//当前场次有选择时进来
					var c = '';
					$(this).parent().find('span.cur').each(function(){
						c += $(this).attr('v')+',';
					});
					c = c.substring(0, c.length-1);
					$(this).parent().parent().parent().attr('v','y');//ul
					$(this).parent().parent().parent().attr('c',c);
				}else{
					$(this).parent().parent().parent().removeAttr('v');//ul
					$(this).parent().parent().parent().removeAttr('c');//ul
				}
				Jclq.my_play();
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
				jQuery('#content_ ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
				
				localStorage.removeItem('jclq_rfsf_PollNum');
				Jclq.my_play();
			});
			jQuery('#isOk_').click(function(){
				if(parseInt($('#c_').html())>1){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var dz = $(this).find('li:eq(1) p:eq(0)').html();
						var sp = $(this).find('li:eq(1) p:eq(1)').html();
						var code = $(this).attr('c');
						
		                c += '<li t="'+$(this).attr('t')+'" c="'+code+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpk spfzpk2">'+dz+'</div>';
		                c += '<div class="spfpl">'+sp+'</div>';
		                c += '</li>';
					});
					
					localStorage.setItem('jclq_rfsf_SelectNum',c);
					localStorage.removeItem('jclq_rfsf_PollNum');
					window.location.href='#class=url&xo=jclq/ture.html';
				}else{
					D.tx('请至少选择2场比赛');
				}
			});
		}
}
Jclq.initial();