/*
 * @Author:wangwei
 * @date ： 	
 */

/*
 * @description 固定单关活动类
 */

CP.Gddg = {};

CP.Gddg.Jq = function(){
	var dom = {
			item : jQuery('#item'),
			downline: jQuery('.downline')
	};
	var PollNum = localStorage.getItem('dg_jq_PollNum');
	var w = {
			dz : function(){
				$.ajax({
					url:'/data/app/jczq/jqs.xml',
					type:'GET',
					DataType:'XML',
					success: function(xml){
						$('.loading').hide();
						var R = $(xml).find('Resp');
						var rs = R.find('rows');
						if(!rs.length){
							D.msg('暂无比赛对阵');
						}
						var html ='';
						var PollNum_t = [],PollNum_c = [];//t 编号  c 投注内容
						if(!!PollNum){
							var PollNum1 = PollNum.split('$')[2].split('/');
							for(var n = 0; n<PollNum1.length; n++){
								var t = PollNum1[n].split('[');
								PollNum_t[n] = t[0];
								PollNum_c[n] = t[1];
							}
						}
						rs.each(function(aa){
							var addesc = $(this).attr('addesc');
							var r = $(this).find('row');
							html += '<section><div class="sfcTitle">'+addesc+'&nbsp;<label>'+r.length+'</label>场比赛';
//							if(aa == 0 || PollNum){//第一个 或者编辑过来的全部显示
								html += '<em class="up"></em></div><div>';
//							}else{
//								html += '<em class="up down"></em></div><div style="display:none;">';
//							}
							r.each(function(){
								var itemid = $(this).attr('itemid');
								var hn = $(this).attr('hn').substr(0,5);//主队
								var gn = $(this).attr('gn').substr(0,5);//客队
								var et = $(this).attr('et');//停售
								var mname = $(this).attr('mname');//联赛名
									mname=mname.substr(0,4);
								var cl = $(this).attr('cl');//联赛颜色
								var isale = $(this).attr('isale');//是否停售
								var hm = $(this).attr('hm');//主队联赛排名
								var gm = $(this).attr('gm');//客队联赛排名
								var htn = $(this).attr('htn');//主队战绩  3胜1平6负
								var gtn = $(this).attr('gtn');//客队战绩
								var oh = $(this).attr('oh');//平均欧指 主
								var od = $(this).attr('od');//平均欧指 平
								var oa = $(this).attr('oa');//平均欧指 客
								var qc = itemid.substring(0,6);
								var jqs = $(this).attr('jqs');//总进球赔率  0球 → 7+球 一一对应
								var jq_ = jqs.split(',');
								var end_time = et.substr(11,5);//停售时间
								var itemid_display	= itemid.substr(-3);
								if((256 & isale) > 0){//是否停售
									if(PollNum && PollNum_t.indexOf(itemid)>=0){
										html += '<ul class="sfcxs jqzpk" t="'+itemid+'" p="'+hn+'  vs  '+gn+'" v="y">';
										html += '<li class="li_weige"><em>'+itemid_display+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
										html += '<li>';
										html += '<p class="spfzpkNum"><span>'+hn+'</span><span class="spfvs">VS</span><span>'+gn+'</span></p>';
										html += '<p class="spfzpk">';
										
										var pc = '';
										$.each(PollNum_t,function(index){
											if(itemid == this){
												pc += PollNum_c[index]+',';
											}
										});
										html += '<span v="0" '+(pc.indexOf('0')>=0?'class="cur"':'')+'><b>0</b><cite>'+jq_[0]+'</cite></span>'+
										'<span v="1" '+(pc.indexOf('1')>=0?'class="cur"':'')+'><b>1</b><cite>'+jq_[1]+'</cite></span>'+
										'<span v="2" '+(pc.indexOf('2')>=0?'class="cur"':'')+'><b>2</b><cite>'+jq_[2]+'</cite></span>'+
										'<span v="3" '+(pc.indexOf('3')>=0?'class="cur"':'')+'><b>3</b><cite>'+jq_[3]+'</cite></span>';
										html += '</p><p class="spfzpk">';
										html += '<span v="4" '+(pc.indexOf('4')>=0?'class="cur"':'')+'><b>4</b><cite>'+jq_[4]+'</cite></span>'+
										'<span v="5" '+(pc.indexOf('5')>=0?'class="cur"':'')+'><b>5</b><cite>'+jq_[5]+'</cite></span>'+
										'<span v="6" '+(pc.indexOf('6')>=0?'class="cur"':'')+'><b>6</b><cite>'+jq_[6]+'</cite></span>'+
										'<span v="7" '+(pc.indexOf('7')>=0?'class="cur"':'')+'><b>7+</b><cite>'+jq_[7]+'</cite></span>';
									}else{
										html += '<ul class="sfcxs jqzpk" t="'+itemid+'" p="'+hn+'  vs  '+gn+'">';
										html += '<li class="li_weige"><em>'+itemid_display+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
										html += '<li>';
										html += '<p class="spfzpkNum"><span>'+hn+'</span><span class="spfvs">VS</span><span>'+gn+'</span></p>';
										html += '<p class="spfzpk">';
										html += '<span v="0"><b>0</b><cite>'+jq_[0]+'</cite></span><span v="1"><b>1</b><cite>'+jq_[1]+'</cite></span><span v="2"><b>2</b><cite>'+jq_[2]+'</cite></span><span v="3"><b>3</b><cite>'+jq_[3]+'</cite></span>'; 
										html += '</p><p class="spfzpk">';
										html += '<span v="4"><b>4</b><cite>'+jq_[4]+'</cite></span><span v="5"><b>5</b><cite>'+jq_[5]+'</cite></span><span v="6"><b>6</b><cite>'+jq_[6]+'</cite></span><span v="7"><b>7+</b><cite>'+jq_[7]+'</cite></span>';
									}
									html += '</p></li>';
									html += '</ul>';
									html += '<div class="sfcpl" style="display:none;">';
									html += '<dl><dt>平均赔率</dt><dd>'+(oh?oh:'--')+'</dd><dd>'+(od?od:'--')+'</dd><dd>'+(oa?oa:'--')+'</dd></dl>';
									html += '<dl><dt>联赛排名</dt><dd>'+(hm?hm:'--')+'</dd><dd>&nbsp;</dd><dd>'+(gm?gm:'--')+'</dd></dl>';
									html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn?htn:'--')+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn?gtn:'--')+'</dd></dl>';
									html += '<dl itemid='+itemid+' qc='+qc+' type='+17+' class="bfzb blue">详细赛事分析></dl>';
									html += '</div>';
								}
							});
							html +='</div></section>';
						});
						dom.item.html(html);
						$("sfcTitle").hide();
						$("sfcTitle").eq(0).show();
						
						w.my_play();
						w.bind_delay();//必须有对阵之后的绑定事件
					}
				});
			},
			bind_delay: function(){
				dom.item.find('section').each(function(){
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
				$('.li_weige').Touch(function(){//联赛历史战绩
					$(this).find('i').toggleClass('xzdown');
					$(this).parent().next().slideToggle(300);
				});
				$(".bfzb").bind("click",function(){
					var itemid = $(this).attr("itemid");
					var qc = $(this).attr("qc");
					var type=$(this).attr("type");
					window.location.href="/jsbf/dzxq.html?itemid="+itemid+"&type="+type+"&qc="+qc;
				})
				dom.item.find('ul.sfcxs p.spfzpk span').Touch(function(){
					var c_ = $('#item section').find('div:eq(1) ul[v=y]').length;
					var  n_ = 15;
					if(c_ >= n_ && !$(this).parent().parent().find('.cur').length){
						D.msg('最多选'+n_+'场');
						return;
					}
					
					$(this).toggleClass('cur');
					
					if($(this).parent().parent().find('span').hasClass('cur')){//当前场次有选择时进来
						var c = '';
						$(this).parent().parent().find('span.cur').each(function(){
							c += $(this).attr('v')+',';
							
						});
						c = c.substring(0, c.length-1);
						$(this).parent().parent().parent().attr('v','y');//ul
						$(this).parent().parent().parent().attr('c',c);
					}else{
						$(this).parent().parent().parent().removeAttr('v');//ul
						$(this).parent().parent().parent().removeAttr('c');//ul
					}
					w.my_play();
				});
			},
			my_play: function(){//已选多少场比赛
				var c_ = $('#item section').find('div:eq(1) ul[v=y]').length;
				jQuery('#c_').html(c_);
			}
			
	};
	var bind = function(){
//		//右上角菜单显示或隐藏
//		$("#pullIco").Touch(function(){
//				if($("#pullText").is(':hidden')){
//					$("#tm_c").show();
//				}else{
//					$("#tm_c").hide();
//				}
//				$(this).parent().toggleClass("pullHover");
//				$("#pullText").toggle();
//		});
//		$('#tm_c').click(function(){
//			$(this).toggle();
//			$('#pullIco').parent().toggleClass("pullHover");
//			$("#pullText").toggle();
//			
//		});
		jQuery('#wanfa_').Touch(function(){
			$(this).toggleClass('hmTit');
			$(this).next().toggle();
		});
		
		jQuery('.deleted').Touch(function(){
			jQuery('#item ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
			
			localStorage.removeItem('dg_jq_PollNum');
			w.my_play();
		});
		jQuery('#isOk_').click(function(){
			if(parseInt($('#c_').html())>=1){
				var c = '';
				jQuery('#item section').find('div:eq(1) ul[v=y]').each(function(){
					c += '<article t='+$(this).attr('t')+' v="y">';
					c += '<p><span>'+$(this).attr('p')+'</span><cite>奖金</cite></p>';
					$(this).find('.cur').each(function(){
						var t = $(this).find('b').html();//选中的队名
						var v = $(this).attr('v');//选中的队名
						var sp = $(this).find('cite').html();
						c += '<div class="jjyhbuy"><strong class="cur" v='+v+' sp='+sp+'><em>'+t+'</em><cite>'+sp+'</cite></strong><div class="jjyhdouble clearfix">';
						c += '<cite>买</cite><span><em class=jian>-</em><input type="text" value="2" maxlength=6><em class=jia>+</em></span><cite>元</cite></div><i class="red">'+sp*2+'</i></div>';
						c += '<ul class="ssqzh clearfix" style="display:none;">';
						c += '<li v=10><em>10元</em><cite>新手最爱</cite></li>';
						c += '<li v=20><em>20元</em><cite>牛刀小试</cite></li>';
						c += '<li v=50><em>50元</em><cite>试试运气</cite></li>';
						c += '<li v=100><em>100元</em><cite>一场制胜</cite></li>';
						c += '<li v=500><em>500元</em><cite>坐等派奖</cite></li>';
						c += '</ul>';
					});
					c += '</article>';
				});
				localStorage.setItem('dg_jq_SelectNum',c);
				localStorage.removeItem('dg_jq_PollNum');
				window.location.href='#class=url&xo=gddg/jq/ture.html';
			}else{
				D.msg('请至少选择1场比赛');
			}
		});
	};
	var init = function(){
		dom.downline.animate({left:'61.5%'},500);
		w.dz();
		bind();
	};
	init();
}();