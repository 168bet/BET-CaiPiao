/*
 * Author: weige
 * Date: 2014-7-2
 */
var PollNum = localStorage.getItem('jczq_jq_PollNum');
var Jczq_jq = {
		initial: function(){
			Jczq_jq.add_C();//初始化添加对阵内容
			
			Jczq_jq.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/jczq/jqs.xml',
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
					!rs.length && D.tx('暂无赛事可以投注');
					rs.each(function(aa){
						var addesc = $(this).attr('addesc');
						var r = $(this).find('row');
						html += '<section><div class="sfcTitle">'+addesc+'&nbsp;'+r.length+'场比赛';
						if(aa == 0 || PollNum){//第一个 或者编辑过来的全部显示
							html += '<em class="up"></em></div><div>';
						}else{
							html += '<em class="up down"></em></div><div style="display:none;">';
						}
						r.each(function(){
							var itemid = $(this).attr('itemid');
							var hn = $(this).attr('hn');//主队
							var gn = $(this).attr('gn');//客队
							var et = $(this).attr('et');//停售
//							var mt = $(this).attr('mt');//比赛
							var mname = $(this).attr('mname');//联赛名
								mname=mname.substr(0,4);
							var cl = $(this).attr('cl');//联赛颜色
							var close = $(this).attr('close');//让球数
							var hm = $(this).attr('hm');//主队联赛排名
							var gm = $(this).attr('gm');//客队联赛排名
							var htn = $(this).attr('htn');//主队战绩  3胜1平6负
							var gtn = $(this).attr('gtn');//客队战绩
							var oh = $(this).attr('oh');//平均欧指 主
							var od = $(this).attr('od');//平均欧指 平
							var oa = $(this).attr('oa');//平均欧指 客
							var qc = itemid.substring(0,6);
//							var htid = $(this).attr('htid');//主队编号
//							var gtid = $(this).attr('gtid');//客队编号
//							var spf = $(this).attr('spf');//让球胜平负赔率 0,1,3对应sp
//							var bqc = $(this).attr('bqc');//半全场赔率  胜-胜→负-负 一一对应
//							var cbf = $(this).attr('cbf');//比分赔率
							var jqs = $(this).attr('jqs');//总进球赔率  0球 → 7+球 一一对应
//							var sxp = $(this).attr('sxp');//上下单双赔率  下双, 下单, 上双,上单
//							var isale = $(this).attr('isale');//开售状态
//							var ic = $(this).attr('ic');//是否取消  1y-0n
							var jq_ = jqs.split(',');
							var end_time = et.substr(11,5);//停售时间
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								pc = pc.split('/');
								html += '<ul class="sfcxs jqzpk" t="'+itemid+'" p="'+jqs+'" v="y" c="'+pc+'">';
							}else{
								html += '<ul class="sfcxs jqzpk" t="'+itemid+'" p="'+jqs+'">';
							}
						 var itemid_display	= itemid.substr(-3);
							html += '<li class="li_weige"><em>'+itemid_display+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
							html += '<li>';
							html += '<p class="spfzpkNum"><span>'+hn.substr(0,5)+'</span><span class="spfvs">VS</span><span>'+gn.substr(0,5)+'</span></p>';
							
							html += '<p class="spfzpk">';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								html += '<span v="0" '+(pc.indexOf('0')>=0?'class="cur"':'')+'><b>0</b><cite>'+jq_[0]+'</cite></span><span v="1" '+(pc.indexOf('1')>=0?'class="cur"':'')+'><b>1</b><cite>'+jq_[1]+'</cite></span><span v="2" '+(pc.indexOf('2')>=0?'class="cur"':'')+'><b>2</b><cite>'+jq_[2]+'</cite></span><span v="3" '+(pc.indexOf('3')>=0?'class="cur"':'')+'><b>3</b><cite>'+jq_[3]+'</cite></span>';
							}else{
								html += '<span v="0"><b>0</b><cite>'+jq_[0]+'</cite></span><span v="1"><b>1</b><cite>'+jq_[1]+'</cite></span><span v="2"><b>2</b><cite>'+jq_[2]+'</cite></span><span v="3"><b>3</b><cite>'+jq_[3]+'</cite></span>'; 
							}
							html += '</p><p class="spfzpk">';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								html += '<span v="4" '+(pc.indexOf('4')>=0?'class="cur"':'')+'><b>4</b><cite>'+jq_[4]+'</cite></span><span v="5" '+(pc.indexOf('5')>=0?'class="cur"':'')+'><b>5</b><cite>'+jq_[5]+'</cite></span><span v="6" '+(pc.indexOf('6')>=0?'class="cur"':'')+'><b>6</b><cite>'+jq_[6]+'</cite></span><span v="7" '+(pc.indexOf('7')>=0?'class="cur"':'')+'><b>7+</b><cite>'+jq_[7]+'</cite></span>';
									
							}else{
								html += '<span v="4"><b>4</b><cite>'+jq_[4]+'</cite></span><span v="5"><b>5</b><cite>'+jq_[5]+'</cite></span><span v="6"><b>6</b><cite>'+jq_[6]+'</cite></span><span v="7"><b>7+</b><cite>'+jq_[7]+'</cite></span>';
							}
							html += '</p></li>';
							html += '</ul>';
							
							html += '<div class="sfcpl" style="display:none;">';
							html += '<dl><dt>平均赔率</dt><dd>'+oh+'</dd><dd>'+od+'</dd><dd>'+oa+'</dd></dl>';
							html += '<dl><dt>联赛排名</dt><dd>'+(hm?hm:'--')+'</dd><dd>&nbsp;</dd><dd>'+(gm?gm:'--')+'</dd></dl>';
							html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn?htn:'--')+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn?gtn:'--')+'</dd></dl>';
							html += '<dl itemid='+itemid+' qc='+qc+' type='+17+' class="bfzb blue">详细赛事分析></dl>';
							html += '</div>';
						});
						html +='</div></section>';
					});
					
					jQuery('#content_').html(html);
					
					$("sfcTitle").hide();
					$("sfcTitle").eq(0).show();
					
					Jczq_jq.my_play();
					Jczq_jq.bind_delay();//必须有对阵之后的绑定事件
				}
			});
		},
		bind_delay: function(){
			$("#bf").click(function(){
				window.location.href="/jsbf/";
			});
			$('.sfcTitle').Touch(function(){//星期
				$(this).find('em').toggleClass('down');
				$(this).next().slideToggle(300);
			});
			$('.li_weige').Touch(function(){//联赛历史战绩
				$(this).find('i').toggleClass('xzdown');
				$(this).parent().next().slideToggle(300);
			});
			/***
			$('.sfcpl').Touch(function(){//联赛历史战绩
				$(this).prev().find('li:eq(0) i').toggleClass('xzdown');
				$(this).slideToggle(300);
			});
			**/
			$(".bfzb").bind("click",function(){
				var itemid = $(this).attr("itemid");
				var qc = $(this).attr("qc");
				var type=$(this).attr("type");
				window.location.href="/jsbf/dzxq.html?itemid="+itemid+"&type="+type+"&qc="+qc;
			})
			$('#content_').find('ul.sfcxs p.spfzpk span').Touch(function(){
				var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
				var  n_ = 15;
				if(c_ >= n_ && !$(this).parent().parent().find('.cur').length){
					D.tx('最多选'+n_+'场');
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
				Jczq_jq.my_play();
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
				
				localStorage.removeItem('jczq_jq_PollNum');
				Jczq_jq.my_play();
			});
			jQuery('#isOk_').click(function(){
				if(parseInt($('#c_').html())>1){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var zd = $(this).find('li:eq(1) p:eq(0) span:eq(0)').html();
						var kd = $(this).find('li:eq(1) p:eq(0) span:eq(2)').html();
						var o = $(this).attr('p').split(',');//赔率
						var code = $(this).attr('c');//投注的内容
						var t = $(this).attr('t');//编号
		            
		                c += '<li t="'+t+'" c="'+code+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpkNum"><span>'+zd+'</span><span class="spfvs">VS</span><span>'+kd+'</span></div>';
		                c += '<div class="spfzpk"><span '+(code.indexOf('0')>=0?'class="cur"':'')+' v="0"><b>0</b><cite>'+o[0]+'</cite></span><span '+(code.indexOf('1')>=0?'class="cur"':'')+' v="1"><b>1</b><cite>'+o[1]+'</cite></span>';
		                c +=                     '<span '+(code.indexOf('2')>=0?'class="cur"':'')+' v="2"><b>2</b><cite>'+o[2]+'</cite></span><span '+(code.indexOf('3')>=0?'class="cur"':'')+' v="3"><b>3</b><cite>'+o[3]+'</cite></span></div>';
		                c += '<div class="spfzpk"><span '+(code.indexOf('4')>=0?'class="cur"':'')+' v="4"><b>4</b><cite>'+o[4]+'</cite></span><span '+(code.indexOf('5')>=0?'class="cur"':'')+' v="5"><b>5</b><cite>'+o[5]+'</cite></span>';
		                c +=                     '<span '+(code.indexOf('6')>=0?'class="cur"':'')+' v="6"><b>6</b><cite>'+o[6]+'</cite></span><span '+(code.indexOf('7')>=0?'class="cur"':'')+' v="7"><b>7+</b><cite>'+o[7]+'</cite></span></div>';
		                c += '</li>';
					});
					localStorage.setItem('jczq_jq_SelectNum',c);
					localStorage.removeItem('jczq_jq_PollNum');
					window.location.href='#class=url&xo=jczq/jq/ture.html';
				}else{
					D.tx('请至少选择2场比赛');
				}
			});
		}
}
Jczq_jq.initial();