/*
 * Author: weige Q:1617634
 * Date: 2014-7-2
 */
var PollNum = localStorage.getItem('jczq_hh_PollNum');
var Jczq_hh = {
		initial: function(){
			Jczq_hh.add_C();//初始化添加对阵内容
			Jczq_hh.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/jczq/new_jczq_hh.xml',
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
							var xo = PollNum1[n].split('>');
							PollNum_t[n] = xo[0];
							PollNum_c[n] = xo[1];
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
							var isale = $(this).attr('isale');//主队
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
							var spf = $(this).attr('spf');//让球胜平负赔率 0,1,3对应sp
							var rqspf = $(this).attr('rqspf');//让球胜平负赔率 0,1,3对应sp
							var spf_ = spf.split(',');
							var rqspf_ = rqspf.split(',');
							var end_time = et.substr(11,5);//停售时间
							var qc = itemid.substring(0,6)
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)],
								r,d;
								pc = pc.split('+');
								if(pc.length == '2'){
									r = pc[0].split('=')[1].split('/');
									d = pc[1].split('=')[1].split('/');
								}else{
									if(pc.indexOf('RQSPF')!='-1'){
										r = pc[0].split('=')[1].split('/');
										d = '';
									}else{
										r = '';
										d = pc[0].split('=')[1].split('/');
									}
								}
								
								
								html += '<ul class="sfcxs hhzpk" isale="'+isale+'" hn="'+hn+'" gn="'+gn+'" t="'+itemid+'" v="y" c="'+r+'" d="'+d+'" p="'+spf+'" rp="'+rqspf+'" close="'+close+'">';
							}else{
								html += '<ul class="sfcxs hhzpk" isale="'+isale+'" hn="'+hn+'" gn="'+gn+'" t="'+itemid+'"  p="'+spf+'" rp="'+rqspf+'" close="'+close+'">';
							}
							html += '<li class="li_weige"><em>'+itemid.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
							html += '<li>';
							
							if(close.indexOf('-')>=0)
							html += '<p class="spfzpkNum"><span>'+hn.substr(0,5)+'<em class="blue">('+close+')</em></span>'
							else
							html += '<p class="spfzpkNum"><span>'+hn.substr(0,5)+'<em class="red">('+'+'+close+')</em></span>'
								
							
							html += '<span class="spfvs">VS</span>'
							html += '<span>'+gn.substr(0,5)+'</span></p>';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)],
								r,d;
								pc = pc.split('+');
								if(pc.length == '2'){
									r = pc[0].split('=')[1].split('/');
									d = pc[1].split('=')[1].split('/');
								}else{
									if(pc.indexOf('RQSPF')!='-1'){
										r = pc[0].split('=')[1].split('/');
										d = '';
									}else{
										r = '';
										d = pc[0].split('=')[1].split('/');
									}
								}
								 html += '<p class="spfzpk"><em>非让球</em><span v="3" '+(r.indexOf('3')>=0?'class="cur"':'')+'>'+(spf_[0]?"胜 "+ spf_[0]:"--")+'</span><span v="1" '+(r.indexOf('1')>=0?'class="cur"':'')+'">'+(spf_[1]?"平 "+ spf_[1]:"未开售")+'</span><span v="0" '+(r.indexOf('0')>=0?'class="cur"':'')+'>'+(spf_[2]?"胜 "+ spf_[2]:"--")+'</span></p>'
								 html += '<p class="spfzpk"><em class="rq">让球</em><span v="3" '+(d.indexOf('3')>=0?'class="cur"':'')+'>胜 '+rqspf_[0]+'</span><span v="1" '+(d.indexOf('1')>=0?'class="cur"':'')+'">平'+rqspf_[1]+' </span><span v="0" '+(d.indexOf('0')>=0?'class="cur"':'')+'>胜 '+rqspf_[2]+'</span></p>'
							}else{
								html += '<p class="spfzpk">';
								html+='<em>非让球</em><span v="3">'+(spf_[0]?"胜 "+ spf_[0]:"--")+'</span><span v="1">'+(spf_[1]?"平  "+spf_[1]:"未开售")+'</span><span v="0">'+(spf_[2]?"胜  "+spf_[2]:"--")+'</span>'
								html += '</p><p class="spfzpk">';
								html+='<em class="rq">让球</em><span v="3">'+(rqspf_[0]?"胜 "+ rqspf_[0]:"--")+'</span><span v="1">'+(rqspf_[1]?"平  "+rqspf_[1]:"未开售")+'</span><span v="0">'+(rqspf_[2]?"胜  "+rqspf_[2]:"--")+'</span>'
								html += '</p>'
							}
							html += '</li></ul>';
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
					Jczq_hh.my_play();
					Jczq_hh.bind_delay();//必须有对阵之后的绑定事件
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
			//历史战绩列表
			$('.li_weige').Touch(function(){//联赛历史战绩
				$(this).find('i').toggleClass('xzdown');
				$(this).parent().next().slideToggle(300);
			});
			/**
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
			});
			$('#content_').find('ul.sfcxs p.spfzpk span').Touch(function(){
				var t = $(this).text();
				var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
				var  n_ = 15;
				if(c_ >= n_ && !$(this).parent().parent().find('.cur').length){
					D.tx('最多选'+n_+'场');
					return;
				}
				if(t=="--" || t=="未开售"){
					return ;
				}else{
					$(this).toggleClass('cur');
				}
				if($(this).parent().parent().find('span').hasClass('cur')){//当前场次有选择时进来
					var c = '',d = '';
					//非让球
					$(this).parent().parent().find('p:eq(1)').find('span.cur').each(function(){
						c += $(this).attr('v')+',';
					});
					
					c = c.substr(0,c.length-1);
					$(this).parent().parent().find('p:eq(2)').find('span.cur').each(function(){
						d += $(this).attr('v')+',';
					});
					d = d.substr(0,d.length-1);
					$(this).parent().parent().parent().attr('v','y');//ul
					$(this).parent().parent().parent().attr('c',c);
					$(this).parent().parent().parent().attr('d',d);
				}else{
					$(this).parent().parent().parent().removeAttr('v');//ul
					$(this).parent().parent().parent().removeAttr('c');// 让分
					$(this).parent().parent().parent().removeAttr('d');// 大小分
				}
				Jczq_hh.my_play();
			});
		},
		//选择的场次根据有v=y的ul标签的个数来决定
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
				Jczq_hh.my_play();
			});
			jQuery('#isOk_').click(function(){
				if(parseInt($('#c_').html())>1){
					var str = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var close = $(this).attr("close")
						var zd = $(this).attr("hn");
						var kd = $(this).attr("gn");
						var o = $(this).attr('p').split(',');//赔率
						var rp = $(this).attr('rp').split(',');//赔率
						var c = $(this).attr('c');//非让球投注的内容
						var d = $(this).attr('d');//非让球投注的内容
						var t = $(this).attr('t');//编号
						var hn = $(this).attr('hn');//编号
						var gn = $(this).attr('gn');//编号
		                str += '<li t="'+t+'" c="'+c+'" d="'+d+'" v="y" close="'+close+'">';
		                str += '<cite class="errorBg"><em class="error2"></em></cite>';
		                if(close.indexOf('-')>=0)
		                str += '<div class="spfzpkNum"><span>'+hn+'<em class="blue">('+close+')</em></span><span class="spfvs">VS</span><span>'+gn+'</span></div>';
		                else
		                str += '<div class="spfzpkNum"><span>'+hn+'<em class="red">('+'+'+close+')</em></span><span class="spfvs">VS</span><span>'+gn+'</span></div>';
		                	
		                str += '<div class="spfzpk"><em>非让球</em><span v="3" '+(c.indexOf('3')>=0?'class="cur"':'')+'>'+(!!o[0]?'胜 <cite>'+o[0]+'</cite>':'--')+'</span><span v="1" '+(c.indexOf('1')>=0?'class="cur"':'')+'">'+(!!o[1]?'平<cite>'+o[1]+'</cite>':'未开售')+'</span><span v="0" '+(c.indexOf('0')>=0?'class="cur"':'')+'>'+(!!o[2]?'胜 <cite>'+o[2]+'</cite>':'--')+'</span></div>'
		                str += '<div class="spfzpk"><em class="rq">让球</em><span v="3" '+(d.indexOf('3')>=0?'class="cur"':'')+'>胜<cite> '+rp[0]+'</cite></span><span v="1" '+(d.indexOf('1')>=0?'class="cur"':'')+'">平<cite> '+rp[1]+'</cite> </span><span v="0" '+(d.indexOf('0')>=0?'class="cur"':'')+'>胜 <cite>'+rp[2]+'</cite></span></div>'
		                str += '</li>';
					});
					localStorage.setItem('jc_hh_SelectNum',str);
					window.location.href='#class=url&xo=jczq/hh/ture.html';
				}else{
					D.tx('请至少选择两场比赛');
				}
			});
		}
}
Jczq_hh.initial();