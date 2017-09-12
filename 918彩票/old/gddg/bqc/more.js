/*
 * @Author:wangwei
 * @date ： 	
 */

/*
 * @description 固定单关活动类
 */

CP.Gddg = {};

CP.Gddg.Bqc = function(){
	var bqcObj = {
			"3-3":"胜胜",
			"3-1":"胜平",
			"3-0":"胜负",
			"1-3":"平胜",
			"1-1":"平平",
			"1-0":"平负",
			"0-3":"负胜",
			"0-1":"负平",
			"0-0":"负负"
	};
	var dom = {
			item : jQuery('#item'),
			downline: jQuery('.downline')
	};
	var PollNum = localStorage.getItem('dg_bqc_PollNum');
	var w = {
			dz : function(){
				$.ajax({
					url:'/data/app/jczq/bqc.xml',
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
								PollNum_c[n] = t[1].split(']')[0];
							}
						}
						rs.each(function(aa){
							var addesc = $(this).attr('addesc');
							var r = $(this).find('row');
							html += '<section><div class="sfcTitle">'+addesc+'&nbsp;<label>'+r.length+'</label>场比赛';
//							if(aa == 0 || PollNum){//第一个 或者编辑过来的显示
								html += '<em class="up"></em></div><div>';
//							}else{
//								html += '<em class="up down"></em></div><div style="display:none;">';
//							}
							r.each(function(){
								var itemid = $(this).attr('itemid');
								var hn = $(this).attr('hn').substr(0,5);//主队
								var gn = $(this).attr('gn').substr(0,5);//客队
								var et = $(this).attr('et');//停售
								var mname = $(this).attr('mname').substr(0,4);//联赛名
								var cl = $(this).attr('cl');//联赛颜色
								var close = $(this).attr('close');//让球数
								var isale = $(this).attr('isale');//是否停售
								var hm = $(this).attr('hm');//主队联赛排名
								var gm = $(this).attr('gm');//客队联赛排名
								var htn = $(this).attr('htn');//主队战绩  3胜1平6负
								var gtn = $(this).attr('gtn');//客队战绩
								var oh = $(this).attr('oh')?$(this).attr('oh'):"--";//平均欧指 主
								var od = $(this).attr('od')?$(this).attr('od'):"--";//平均欧指 平
								var oa = $(this).attr('oa')?$(this).attr('oa'):"--";//平均欧指 客
								var bqc = $(this).attr('bqc');//比分赔率
								var bqc_ = bqc.split(',');
								var end_time = et.substr(11,5);//停售时间
								var qc = itemid.substring(0,6);
								if((128 & isale) > 0){//是否停售
									if(PollNum && PollNum_t.indexOf(itemid)>=0){
										html += '<ul class="sfcxs" t="'+itemid+'" v="y" p="'+hn+'  vs  '+gn+'">';
										html += '<li class="li_weige"><em>'+itemid.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
										html += '<li>';
										html += '<p class="spfzpkNum"><span>'+hn+'</span><span class="spfvs">VS</span><span>'+gn+'</span></p>';
										html += '<p class="spfzpk bfpk">';
										var pc = '';
										$.each(PollNum_t,function(index){
											if(itemid == this){
												pc += PollNum_c[index]+',';
											}
										});
										pc = pc.substring(0, pc.length-1);
										pc = pc.split(',');
										var t = pc.length;
										html += '<span class="cur">';
										if(t<7){
											for(var r = 0; r<t; r++){
												var ri = bqcObj[pc[r]]||pc[r];
												html += '<cite>'+ri+'</cite>';
											}
										}else{
											html += '已选'+t+'项';
										}
										html += '</span>';
										html += '</p></li>';
										html += '</ul>';
										html += '<div class="sfcpl" style="display:none;">';
										html += '<dl><dt>平均赔率</dt><dd>'+(oh?oh:'--')+'</dd><dd>'+(od?od:'--')+'</dd><dd>'+(oa?oa:'--')+'</dd></dl>';
										html += '<dl><dt>联赛排名</dt><dd>'+(hm?hm:'--')+'</dd><dd>&nbsp;</dd><dd>'+(gm?gm:'--')+'</dd></dl>';
										html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn?htn:'--')+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn?gtn:'--')+'</dd></dl>';
										html += '<dl itemid='+itemid+' qc='+qc+' type='+17+' class="bfzb blue">详细赛事分析></dl>';
										html += '</div>';
										html += '<div class="bfPop bf_" style="display:none" a="c">';
										html += '<div class="bfTitle clearfix"><p>'+hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+gn+'</p></div>';
										html+='<p class="gray mgTop03">［例］胜负：上半场主胜 且 全场主负</p>';
										html += '<div class="competitions bqccom"  style="margin-top:.4rem">';
										html += '<span value="3-3" '+(pc.indexOf('3-3')>=0?'class="cur"':'')+'><strong>胜胜</strong><em>'+bqc_[0]+'</em></span>';
										html += '<span value="3-1" '+(pc.indexOf('3-1')>=0?'class="cur"':'')+'><strong>胜平</strong><em>'+bqc_[1]+'</em></span>';
										html += '<span value="3-0" '+(pc.indexOf('3-0')>=0?'class="cur"':'')+'><strong>胜负</strong><em>'+bqc_[2]+'</em></span>';
										html += '<span value="1-3" '+(pc.indexOf('1-3')>=0?'class="cur"':'')+'><strong>平胜</strong><em>'+bqc_[3]+'</em></span>';
										html += '<span value="1-1" '+(pc.indexOf('1-1')>=0?'class="cur"':'')+'><strong>平平</strong><em>'+bqc_[4]+'</em></span>';
										html += '<span value="1-0" '+(pc.indexOf('1-0')>=0?'class="cur"':'')+'><strong>平负</strong><em>'+bqc_[5]+'</em></span>';
										html += '<span value="0-3" '+(pc.indexOf('0-3')>=0?'class="cur"':'')+'><strong>负胜</strong><em>'+bqc_[6]+'</em></span>';
										html += '<span value="0-1" '+(pc.indexOf('0-1')>=0?'class="cur"':'')+'><strong>负平</strong><em>'+bqc_[7]+'</em></span>';
										html += '<span value="0-0" '+(pc.indexOf('0-0')>=0?'class="cur"':'')+'><strong>负负</strong><em>'+bqc_[8]+'</em></span>';
										html += '<div class="clear"></div>';
									}else{
										html += '<ul class="sfcxs" t="'+itemid+'" p="'+hn+'  vs  '+gn+'">';
										html += '<li class="li_weige"><em>'+itemid.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
										html += '<li>';
										html += '<p class="spfzpkNum"><span>'+hn+'</span><span class="spfvs">VS</span><span>'+gn+'</span></p>';
										html += '<p class="spfzpk bfpk">';
										html += '<span>立即投注</span>';
										html += '</p></li>';
										html += '</ul>';
										html += '<div class="sfcpl" style="display:none;">';
										html += '<dl><dt>平均赔率</dt><dd>'+(oh?oh:'--')+'</dd><dd>'+(od?od:'--')+'</dd><dd>'+(oa?oa:'--')+'</dd></dl>';
										html += '<dl><dt>联赛排名</dt><dd>'+(hm?hm:'--')+'</dd><dd>&nbsp;</dd><dd>'+(gm?gm:'--')+'</dd></dl>';
										html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn?htn:'--')+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn?gtn:'--')+'</dd></dl>';
										html += '<dl itemid='+itemid+' qc='+qc+' type='+17+' class="bfzb blue">详细赛事分析></dl>';
										html += '</div>';
										html += '<div class="zfPop bfPop bf_" style="display:none">';
										html += '<div class="bfTitle clearfix"><p>'+hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+gn+'</p></div>';
										html+='<p class="gray mgTop03">［例］胜负：上半场主胜 且 全场主负</p>';
										html += '<div class="competitions bqccom"  style="margin-top:.4rem">';
										html += '<span value="3-3"><strong>胜胜</strong><em>'+bqc_[0]+'</em></span>';
										html += '<span value="3-1"><strong>胜平</strong><em>'+bqc_[1]+'</em></span>';
										html += '<span value="3-0"><strong>胜负</strong><em>'+bqc_[2]+'</em></span>';
										html += '<span value="1-3"><strong>平胜</strong><em>'+bqc_[3]+'</em></span>';
										html += '<span value="1-1"><strong>平平</strong><em>'+bqc_[4]+'</em></span>';
										html += '<span value="1-0"><strong>平负</strong><em>'+bqc_[5]+'</em></span>';
										html += '<span value="0-3"><strong>负胜</strong><em>'+bqc_[6]+'</em></span>';
										html += '<span value="0-1"><strong>负平</strong><em>'+bqc_[7]+'</em></span>';
										html += '<span value="0-0"><strong>负负</strong><em>'+bqc_[8]+'</em></span>';
										html += '<div class="clear"></div>';
									}
									html += '</div>';
									html += '<div class="zfTrue clearfix"><a href="javascript:;" class="zfqx">取 消</a><a href="javascript:;">确 定</a></div>';
									html += '</div>';
								}
							});
							html +='</div></section>';
						});
						dom.item.html(html);
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
				jQuery('.sfcTitle').Touch(function(){//星期
					$(this).find('em').toggleClass('down');
					$(this).next().slideToggle(300);
				});
				jQuery('.li_weige').Touch(function(){//联赛历史战绩
					$(this).find('i').toggleClass('xzdown');
					$(this).parent().next().slideToggle(300);
				});
				$(".bfzb").bind("click",function(){
					var itemid = $(this).attr("itemid");
					var qc = $(this).attr("qc");
					var type=$(this).attr("type");
					window.location.href="/jsbf/dzxq.html?itemid="+itemid+"&type="+type+"&qc="+qc;
				});
				dom.item.find('ul.sfcxs p.spfzpk span').click(function(){//打开比分选项
					var c_ = $('#item section').find('div:eq(1) ul[v=y]').length;
					if(c_>14 && !$(this).hasClass('cur')){
						D.msg("最多选择15场比赛");
						return false;
					}
					var c = $(window).height();
					var d = $(this).parent().parent().parent().next().next().height();
					var t = '-'+(c/2)+'px';
					if(c>d){
						t = '-'+(d/2)+'px';
					}
					
					$(this).parent().parent().parent().next().next().css('marginTop',t);
					$(this).parent().parent().parent().next().next().show();
					jQuery('.zhezhao').show();
					
				});
				jQuery('.bf_').find('a:eq(0)').click(function(){//取消比分层
					$(this).parent().parent().find('.cur').removeClass('cur');
					w.public_bf($(this).parent().parent());
					
					jQuery('.zhezhao').hide();
					$(this).parent().parent().hide();
				});
				jQuery('.bf_').find('a:eq(1)').click(function(){//确定比分层
					jQuery('.zhezhao').hide();
					$(this).parent().parent().hide();
					
				});
				jQuery('.bf_ div.competitions span').click(function(){//选择比分
					$(this).toggleClass('cur');
					
					w.public_bf($(this).parent().parent());
				});
			},
			public_bf: function(t){
				var l = t.find('div.competitions span.cur').length;
				var n = 6 , k = '';
				if(l){//有选择的时候
					t.attr('a','c');//比分的div
					t.prev().prev().attr('v','y');//ul
					t.prev().prev().find('li:eq(1) p:eq(1) span').addClass('cur');
					if(l>n){
						t.prev().prev().find('li:eq(1) p:eq(1) span').html('已选'+l+'项');
					}else{
						var m = '';
						t.find('div.competitions span.cur').each(function(aa){
							if(aa<n){
								var s = $(this).find('strong').html();
								m += '<cite>'+s+'</cite>';
							}
						});
						
						t.prev().prev().find('li:eq(1) p:eq(1) span').html(m);
					}
					t.find('div.competitions span.cur').each(function(aa){
							var s = $(this).attr("value");
							k += s+',';
					});
					k = k.substr(0,k.length-1);
					t.prev().prev().attr('c',k);
				}else{//没选择的时候
					t.removeAttr('a');
					t.prev().prev().removeAttr('v');//ul 当前行是否有投注
					t.prev().prev().removeAttr('c');//ul 投注内容
					t.prev().prev().find('li:eq(1) p:eq(1) span').html('立即投注');
					t.prev().prev().find('li:eq(1) p:eq(1) span').removeClass('cur');
				}
				w.my_play();
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
			jQuery('#item ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur').html('立即投注');
			jQuery('#item div.bf_[a=c]').removeAttr('a').find('.cur').removeClass('cur');//清空之前比分层里面的cur
			
			localStorage.removeItem('dg_bqc_PollNum');
			w.my_play();
		});
		jQuery('#isOk_').click(function(){
			if(parseInt($('#c_').html())>=1){
				var c = '';
				jQuery('#item section').find('div:eq(1) ul[v=y]').each(function(){
					c += '<article t='+$(this).attr('t')+' v="y">';
					c += '<p><span>'+$(this).attr('p')+'</span><cite>奖金</cite></p>';
					$(this).next().next().find('.cur').each(function(){
						var t = $(this).find('strong').html();//选中的队名
						var sp = $(this).find('em').html();
						var v = $(this).attr('v');//投注选项
						c += '<div class="jjyhbuy"><strong class="cur" v='+t+' sp='+sp+'><em>'+t+'</em><cite>'+sp+'</cite></strong><div class="jjyhdouble clearfix">';
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
				localStorage.setItem('dg_bqc_SelectNum',c);
				localStorage.removeItem('dg_bqc_PollNum');
				window.location.href='#class=url&xo=gddg/bqc/ture.html';
			}else{
				D.msg('请至少选择1场比赛');
			}
		});
	};
	var init = function(){
		dom.downline.animate({left:'81.5%'},500);
		w.dz();
		bind();
	};
	init();
}();