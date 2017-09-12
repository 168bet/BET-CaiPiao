/*
 * Author: weige
 * Date: 2014-10-31
 */
var PollNum = localStorage.getItem('bd_sxp_PollNum');
var Bjdc_sx = {
		initial: function(){
			Bjdc_sx.add_C();//初始化添加对阵内容
			Bjdc_sx.bind_();//初始化的一些绑定事件
		},
		
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/bd/sxp.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					D.load(close);
					var R = $(xml).find('Resp');
					var pid = R.attr('pid');
					$('#expect').val(pid);//北单当前场次期号
					var rs = R.find('rows');
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
						html += '<section><div class="sfcTitle">'+addesc+'&nbsp;'+r.length+'场比赛';
						if(aa == 0 || PollNum){//第一个 或者编辑过来的显示
							html += '<em class="up"></em></div><div>';
						}else{
							html += '<em class="up down"></em></div><div style="display:none;">';
						}
						r.each(function(){
							var itemid = $(this).attr('itemid');
							var hn = $(this).attr('hn');//主队
							var gn = $(this).attr('gn');//客队
							var et = $(this).attr('et');//停售
							var mname = $(this).attr('mname').substr(0,4);//联赛名
							var cl = $(this).attr('cl');//联赛颜色
							var hm = $(this).attr('hm');//主队联赛排名
							var gm = $(this).attr('gm');//客队联赛排名
							var htn = $(this).attr('htn');//主队战绩  3胜1平6负
							var gtn = $(this).attr('gtn');//客队战绩
							var oh = $(this).attr('oh');//平均欧指 主
							var od = $(this).attr('od');//平均欧指 平
							var oa = $(this).attr('oa');//平均欧指 客
							var sxp = $(this).attr('sxp');
							var sxp_ = sxp.split(',');
							var end_time = et.substr(11,5);//停售时间
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								pc = pc.split('/');
								html += '<ul class="sfcxs jqzpk sxzpk" t="'+itemid+'" v="y" c="'+pc+'">';
								html += '<li><em>'+itemid+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
								html += '<li>';
								html += '<p class="spfzpkNum">';
								html += '<span>'+hn+'</span><span class=spfvs>VS</span><span>'+gn+'</span>';
								html += '</p>';
								html += '<p class=spfzpk>';
								var pc = '';
								$.each(PollNum_t,function(index){
									if(itemid == this){
										pc += PollNum_c[index]+',';
									}
								});
								html += '<span v=3 '+(pc.indexOf('3')>=0?'class="cur"':'')+'><b>上单</b><cite>'+sxp_[3]+'</cite></span><span v=2 '+(pc.indexOf('2')>=0?'class="cur"':'')+'><b>上双</b><cite>'+sxp_[2]+'</cite></span>';
								html += '<span v=1 '+(pc.indexOf('1')>=0?'class="cur"':'')+'><b>下单</b><cite>'+sxp_[1]+'</cite></span><span v=0 '+(pc.indexOf('0')>=0?'class="cur"':'')+'><b>下双</b><cite>'+sxp_[0]+'</cite></span>';
								
							}else{
								html += '<ul class="sfcxs jqzpk sxzpk" t="'+itemid+'">';
								html += '<li><em>'+itemid+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
								html += '<li>';
								html += '<p class="spfzpkNum">';
								html += '<span>'+hn+'</span><span class=spfvs>VS</span><span>'+gn+'</span>';
								html += '</p>';
								html += '<p class=spfzpk>';
								html += '<span v=3><b>上单</b><cite>'+sxp_[3]+'</cite></span><span v=2><b>上双</b><cite>'+sxp_[2]+'</cite></span><span v=1><b>下单</b><cite>'+sxp_[1]+'</cite></span><span v=0><b>下双</b><cite>'+sxp_[0]+'</cite></span>';
							}
							html += '</p>';
							html += '</li>';
							html += '</ul>';
							
							html += '<div class="sfcpl" style="display:none;">';
							html += '<dl><dt>平均赔率</dt><dd>'+(oh?oh:'--')+'</dd><dd>'+(od?od:'--')+'</dd><dd>'+(oa?oa:'--')+'</dd></dl>';
							html += '<dl><dt>联赛排名</dt><dd>'+(hm?hm:'--')+'</dd><dd>&nbsp;</dd><dd>'+(gm?gm:'--')+'</dd></dl>';
							html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn?htn:'--')+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn?gtn:'--')+'</dd></dl>';
							html += '<dl itemid='+pid+' qc='+itemid+' type='+17+' class="bfzb blue">详细赛事分析></dl>';
							html += '</div>';
						});
						html +='</div></section>';
					});
					jQuery('#content_').html(html);
					Bjdc_sx.my_play();
					Bjdc_sx.bind_delay();//必须有对阵之后的绑定事件
				}
			});
		},
		bind_delay: function(){
			$("#bf").click(function(){
				window.location.href="/bdjsbf/";
			});
			$('.sfcTitle').Touch(function(){
				$(this).find('em').toggleClass('down');
				$(this).next().slideToggle(300);
			});
			$('#content_ ul.sfcxs').find('li:eq(0)').Touch(function(){//联赛历史战绩
				$(this).find('i').toggleClass('xzdown');
				$(this).parent().next().slideToggle(300);
			});
			$('.sfcpl').Touch(function(){//联赛历史战绩
				$(this).prev().find('li:eq(0) i').toggleClass('xzdown');
				$(this).slideToggle(300);
			});
			$(".bfzb").bind("click",function(){
				var itemid = $(this).attr("itemid");
				var qc = $(this).attr("qc");
				var type=$(this).attr("type");
				window.location.href="/bdjsbf/dzxq.html?itemid="+itemid+"_"+qc+"&type="+type+"&qc="+qc;
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
				Bjdc_sx.my_play();
			});
		},
		my_play: function(){//已选多少场比赛
			var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
			jQuery('#c_').html(c_);
		},
		bind_: function(){
			$("#bf").click(function(){
				window.location.href="/bdjsbf/";
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
			jQuery('#wanfa_').Touch(function(){
				$(this).toggleClass('hmTit');
				$(this).next().toggle();
			});
			
			jQuery('.deleted').Touch(function(){
				jQuery('#content_ ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur');
				
				localStorage.removeItem('bd_sxp_PollNum');
				Bjdc_sx.my_play();
			});
			jQuery('#isOk_').click(function(){
				if(parseInt($('#c_').html())>0){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var dz = $(this).find('li:eq(1) p:eq(0)').html();
						var pl = $(this).find('li:eq(1) p:eq(1)').html();
						var code = $(this).attr('c');
						
		                c += '<li t="'+$(this).attr('t')+'" c="'+code+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpkNum">'+dz+'</div>';
		                c += '<div class="spfzpk">'+pl+'</div>';
		                c += '</li>';
		                
					});
					
					localStorage.setItem('bd_sxp_SelectNum',c);
					localStorage.removeItem('bd_sxp_PollNum');
					window.location.href='#class=url&xo=bjdc/sx/ture.html&pid='+$('#expect').val();
				}else{
					D.tx('请至少选择1场比赛');
				}
			});
		}
}
Bjdc_sx.initial();
