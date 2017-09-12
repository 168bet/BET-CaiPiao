/*
 * Author: weige Q:1617634
 * Date: 2014-7-2
 */
var PollNum = localStorage.getItem('rqspf_PollNum');
var Jczq_rq = {
		initial: function(){
			Jczq_rq.add_C();//初始化添加对阵内容
			Jczq_rq.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/jczq/rqspf.xml',
				type:'GET',
				DataType:'XML',
				success: function(xml){
					D.load(close);
					var R = $(xml).find('Resp');
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
//							var mt = $(this).attr('mt');//比赛
							var mname = $(this).attr('mname').substr(0,4);//联赛名
							var cl = $(this).attr('cl');//联赛颜色
							var close = $(this).attr('close');//让球数
							var hm = $(this).attr('hm');//主队联赛排名
							var gm = $(this).attr('gm');//客队联赛排名
							var htn = $(this).attr('htn');//主队战绩  3胜1平6负
							var gtn = $(this).attr('gtn');//客队战绩
							var oh = $(this).attr('oh');//平均欧指 主
							var od = $(this).attr('od');//平均欧指 平
							var oa = $(this).attr('oa');//平均欧指 客
//							var htid = $(this).attr('htid');//主队编号
//							var gtid = $(this).attr('gtid');//客队编号
							var spf = $(this).attr('rqspf');//让球胜平负赔率 0,1,3对应sp
							var itemid = $(this).attr('itemid');//让球胜平负赔率 0,1,3对应sp
							var qc = itemid.substring(0,6)
//							var bqc = $(this).attr('bqc');//半全场赔率  胜-胜→负-负 一一对应
//							var cbf = $(this).attr('cbf');//比分赔率
//							var jq = $(this).attr('jq');//总进球赔率  0球 → 7+球 一一对应
//							var sxp = $(this).attr('sxp');//上下单双赔率  下双, 下单, 上双,上单
//							var isale = $(this).attr('isale');//开售状态
//							var ic = $(this).attr('ic');//是否取消  1y-0n
							var spf_ = spf.split(',');
							var z_s = spf_[0];//主胜sp
							var p = spf_[1];
							var k_s = spf_[2];
							var end_time = et.substr(11,5);//停售时间
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								pc = pc.split('/');
								html += '<ul class="sfcxs" t="'+itemid+'" v="y" c="'+pc+'">';
							}else{
								html += '<ul class="sfcxs" t="'+itemid+'">';
							}
							html += '<li class="li_weige"><em>'+itemid.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
							html += '<li>';
							html += '<p class="spfzpk spfzpk2">';
							
							if(close.indexOf('-')>=0)
							var tmp_close='<i class="blue">'+(close=='0'?'':'('+(close.indexOf('-')>=0?close:'+'+close)+')');
							else 
							var tmp_close='<i class="red">'+(close=='0'?'':'('+(close.indexOf('-')>=0?close:'+'+close)+')');
							
							
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								html += '<span v="3" '+(pc.indexOf('3')>=0?'class="cur"':'')+' sp="'+z_s+'"><em>'+hn.substr(0,5)+tmp_close+'</i></em><cite>胜</cite></span><span class="spfvs '+(pc.indexOf('1')>=0?'cur':'')+'" v="1" sp="'+p+'"><em>VS</em><cite>平</cite></span><span v="0" '+(pc.indexOf('0')>=0?'class="cur"':'')+' sp="'+k_s+'"><em>'+gn.substr(0,5)+'</em><cite>胜</cite></span>';
							}else{
								html += '<span v="3" sp="'+z_s+'"><em>'+hn.substr(0,5)+tmp_close+'</i></em><cite>胜</cite></span><span class="spfvs" v="1" sp="'+p+'"><em>VS</em><cite>平</cite></span><span v="0" sp="'+k_s+'"><em>'+gn.substr(0,5)+'</em><cite>胜</cite></span>';
							}
							html += '</p><p class="spfpl"><span>赔率'+z_s+'</span><span class="spfvs">赔率'+p+'</span><span>赔率'+k_s+'</span></p>';
							html += '</li>';
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
					
					Jczq_rq.my_play();
					Jczq_rq.bind_delay();//必须有对阵之后的绑定事件
				}
			});
		},
		bind_delay: function(){
			$("#bf").click(function(){
				window.location.href="/jsbf/";
			})
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
			/***
			$('.sfcpl').Touch(function(){//联赛历史战绩
				$(this).prev().find('li:eq(0) i').toggleClass('xzdown');
				$(this).slideToggle(300);
			});
			***/
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
				Jczq_rq.my_play();
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
				localStorage.removeItem('rqspf_PollNum');
				Jczq_rq.my_play();
			});
			jQuery('#isOk_').click(function(e){
				if(parseInt($('#c_').html())>1){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var dz = $(this).find('li:eq(1) p:eq(0)').html();
						var pl = $(this).find('li:eq(1) p:eq(1)').html();
						var code = $(this).attr('c');
						
		                c += '<li t="'+$(this).attr('t')+'" c="'+code+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpk spfzpk2">'+dz+'</div>';
		                c += '<div class="spfpl">'+pl+'</div>';
		                c += '</li>';
					});
					localStorage.setItem('rqspf_SelectNum',c);
					localStorage.removeItem('rqspf_PollNum');
					window.location.href='#class=url&xo=jczq/rqspf/ture.html';
				}else{
					D.tx('请至少选择2场比赛');
				}
			});
		}
}
Jczq_rq.initial();