/*
 * Author: weige
 * Date: 2014-7-2
 */
var PollNum = localStorage.getItem('jczq_bf_PollNum');
var Jczq_bf = {
		initial: function(){
			Jczq_bf.add_C();//初始化添加对阵内容
			Jczq_bf.bind_();//初始化的一些绑定事件
		},
		add_C: function(){
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/data/app/jczq/cbf.xml',
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
							var cbf = $(this).attr('cbf');//比分赔率
							var cbf_ = cbf.split(',');
							var end_time = et.substr(11,5);//停售时间
							hn = hn.substr(0,5);
							gn = gn.substr(0,5);
							var qc = itemid.substring(0,6);
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								pc = pc.split('/');
								html += '<ul class="sfcxs" t="'+itemid+'" v="y" c="'+pc+'">';
							}else{
								html += '<ul class="sfcxs" t="'+itemid+'">';
							}
							html += '<li class="li_weige"><em>'+itemid.substr(-3)+'</em><p style=\'color:'+cl+'\'>'+mname+'</p><cite>'+end_time+' 截止</cite><i class="xzup xzdown"></i></li>';
							html += '<li>';
							html += '<p class="spfzpkNum"><span>'+hn+'</span><span class="spfvs">VS</span><span>'+gn+'</span></p>';
							html += '<p class="spfzpk bfpk">';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								pc = pc.split('/');
								html += '<span class="cur">';
								for(var r = 0; r<pc.length; r++){
									var ri = {'9:0':'胜其它','9:9':'平其它','0:9':'负其它'}[pc[r]]||pc[r];
									html += '<cite '+((ri == '胜其它' ||ri == '负其它' ||ri == '平其它') ?'class="sqt"':'')+'>'+ri+'</cite>';
								}
								html += '</span>';
							}else{
								html += '<span>立即投注</span>';
							}
							html += '</p></li>';
							html += '</ul>';
							html += '<div class="sfcpl" style="display:none;">';
							html += '<dl><dt>平均赔率</dt><dd>'+oh+'</dd><dd>'+od+'</dd><dd>'+oa+'</dd></dl>';
							html += '<dl><dt>联赛排名</dt><dd>'+(hm?hm:'--')+'</dd><dd>&nbsp;</dd><dd>'+(gm?gm:'--')+'</dd></dl>';
							html += '<dl><dt>近期战绩</dt><dd class="yellow">'+(htn?htn:'--')+'</dd><dd>&nbsp;</dd><dd class="yellow">'+(gtn?gtn:'--')+'</dd></dl>';
							html += '<dl itemid='+itemid+' qc='+qc+' type='+17+' class="bfzb blue">详细赛事分析></dl>';
							html += '</div>';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								html += '<div class="bfPop bf_" style="display:none;" a="c">';
							}else{
								html += '<div class="bfPop bf_" style="display:none;">';
							}
							html += '<div class="bfTitle clearfix"><p>'+hn+'<span class="right"><em>V</em></span></p><p><span class="left"><em>S</em></span>'+gn+'</p></div>';
							html += '<div style="height:17rem; overflow:auto">';
							html += '<p class="red pdTop06 pdLeft08 pdBot03">'+hn+'&nbsp;&nbsp;胜</p>';
							html += '<div class="competitions bfcom">';
							if(PollNum && PollNum_t.indexOf(itemid)>=0){
								var pc = PollNum_c[PollNum_t.indexOf(itemid)];
								html += '<span '+(pc.indexOf('1:0')>=0?'class="cur"':'')+'><strong>1:0</strong><em>'+cbf_[0]+'</em></span>';
								html += '<span '+(pc.indexOf('2:0')>=0?'class="cur"':'')+'><strong>2:0</strong><em>'+cbf_[1]+'</em></span>';
								html += '<span '+(pc.indexOf('2:1')>=0?'class="cur"':'')+'><strong>2:1</strong><em>'+cbf_[2]+'</em></span>';
								html += '<span '+(pc.indexOf('3:0')>=0?'class="cur"':'')+'><strong>3:0</strong><em>'+cbf_[3]+'</em></span>';
								html += '<span '+(pc.indexOf('3:1')>=0?'class="cur"':'')+'><strong>3:1</strong><em>'+cbf_[4]+'</em></span>';
								html += '<span '+(pc.indexOf('3:2')>=0?'class="cur"':'')+'><strong>3:2</strong><em>'+cbf_[5]+'</em></span>';
								html += '<span '+(pc.indexOf('4:0')>=0?'class="cur"':'')+'><strong>4:0</strong><em>'+cbf_[6]+'</em></span>';
								html += '<span '+(pc.indexOf('4:1')>=0?'class="cur"':'')+'><strong>4:1</strong><em>'+cbf_[7]+'</em></span>';
								html += '<span '+(pc.indexOf('4:2')>=0?'class="cur"':'')+'><strong>4:2</strong><em>'+cbf_[8]+'</em></span>';
								html += '<span '+(pc.indexOf('5:0')>=0?'class="cur"':'')+'><strong>5:0</strong><em>'+cbf_[9]+'</em></span>';
								html += '<span '+(pc.indexOf('5:1')>=0?'class="cur"':'')+'><strong>5:1</strong><em>'+cbf_[10]+'</em></span>';
								html += '<span '+(pc.indexOf('5:2')>=0?'class="cur"':'')+'><strong>5:2</strong><em>'+cbf_[11]+'</em></span>';
								html += '<span class="bflast '+(pc.indexOf('9:0')>=0?'cur':'')+'"><strong>胜其它</strong><em>'+cbf_[12]+'</em></span>';
								html += '<div class="clear"></div>';
								html += '</div>';
								html += '<p class="blue pdTop06 pdLeft08 pdBot03">打平</p>';
								html += '<div class="competitions bfcom">';
								html += '<span '+(pc.indexOf('0:0')>=0?'class="cur"':'')+'><strong>0:0</strong><em>'+cbf_[13]+'</em></span>';
								html += '<span '+(pc.indexOf('1:1')>=0?'class="cur"':'')+'><strong>1:1</strong><em>'+cbf_[14]+'</em></span>';
								html += '<span '+(pc.indexOf('2:2')>=0?'class="cur"':'')+'><strong>2:2</strong><em>'+cbf_[15]+'</em></span>';
								html += '<span '+(pc.indexOf('3:3')>=0?'class="cur"':'')+'><strong>3:3</strong><em>'+cbf_[16]+'</em></span>';
								html += '<span class="bflast '+(pc.indexOf('9:9')>=0?'cur':'')+'"><strong>平其它</strong><em>'+cbf_[17]+'</em></span>';
								html += '<div class="clear"></div>';
								html += '</div>';
								html += '<p class="green pdTop06 pdLeft08 pdBot03">'+gn+'&nbsp;&nbsp;胜</p>';
								html += '<div class="competitions bfcom">';
								html += '<span '+(pc.indexOf('0:1')>=0?'class="cur"':'')+'><strong>0:1</strong><em>'+cbf_[18]+'</em></span>';
								html += '<span '+(pc.indexOf('0:2')>=0?'class="cur"':'')+'><strong>0:2</strong><em>'+cbf_[19]+'</em></span>';
								html += '<span '+(pc.indexOf('1:2')>=0?'class="cur"':'')+'><strong>1:2</strong><em>'+cbf_[20]+'</em></span>';
								html += '<span '+(pc.indexOf('0:3')>=0?'class="cur"':'')+'><strong>0:3</strong><em>'+cbf_[21]+'</em></span>';
								html += '<span '+(pc.indexOf('1:3')>=0?'class="cur"':'')+'><strong>1:3</strong><em>'+cbf_[22]+'</em></span>';
								html += '<span '+(pc.indexOf('2:3')>=0?'class="cur"':'')+'><strong>2:3</strong><em>'+cbf_[23]+'</em></span>';
								html += '<span '+(pc.indexOf('0:4')>=0?'class="cur"':'')+'><strong>0:4</strong><em>'+cbf_[24]+'</em></span>';
								html += '<span '+(pc.indexOf('1:4')>=0?'class="cur"':'')+'><strong>1:4</strong><em>'+cbf_[25]+'</em></span>';
								html += '<span '+(pc.indexOf('2:4')>=0?'class="cur"':'')+'><strong>2:4</strong><em>'+cbf_[26]+'</em></span>';
								html += '<span '+(pc.indexOf('2:4')>=0?'class="cur"':'')+'><strong>0:5</strong><em>'+cbf_[27]+'</em></span>';
								html += '<span '+(pc.indexOf('2:4')>=0?'class="cur"':'')+'><strong>1:5</strong><em>'+cbf_[28]+'</em></span>';
								html += '<span '+(pc.indexOf('2:4')>=0?'class="cur"':'')+'><strong>2:5</strong><em>'+cbf_[29]+'</em></span>';
								html += '<span class="bflast '+(pc.indexOf('0:9')>=0?'cur':'')+'"><strong>负其它</strong><em>'+cbf_[30]+'</em></span>';
							}else{
								html += '<span><strong>1:0</strong><em>'+cbf_[0]+'</em></span>';
								html += '<span><strong>2:0</strong><em>'+cbf_[1]+'</em></span>';
								html += '<span><strong>2:1</strong><em>'+cbf_[2]+'</em></span>';
								html += '<span><strong>3:0</strong><em>'+cbf_[3]+'</em></span>';
								html += '<span><strong>3:1</strong><em>'+cbf_[4]+'</em></span>';
								html += '<span><strong>3:2</strong><em>'+cbf_[5]+'</em></span>';
								html += '<span><strong>4:0</strong><em>'+cbf_[6]+'</em></span>';
								html += '<span><strong>4:1</strong><em>'+cbf_[7]+'</em></span>';
								html += '<span><strong>4:2</strong><em>'+cbf_[8]+'</em></span>';
								html += '<span><strong>5:0</strong><em>'+cbf_[9]+'</em></span>';
								html += '<span><strong>5:1</strong><em>'+cbf_[10]+'</em></span>';
								html += '<span><strong>5:2</strong><em>'+cbf_[11]+'</em></span>';
								html += '<span class="bflast"><strong>胜其它</strong><em>'+cbf_[12]+'</em></span>';
								html += '<div class="clear"></div>';
								html += '</div>';
								html += '<p class="blue pdTop06 pdLeft08 pdBot03">打平</p>';
								html += '<div class="competitions bfcom">';
								html += '<span><strong>0:0</strong><em>'+cbf_[13]+'</em></span>';
								html += '<span><strong>1:1</strong><em>'+cbf_[14]+'</em></span>';
								html += '<span><strong>2:2</strong><em>'+cbf_[15]+'</em></span>';
								html += '<span><strong>3:3</strong><em>'+cbf_[16]+'</em></span>';
								html += '<span class="bflast"><strong>平其它</strong><em>'+cbf_[17]+'</em></span>';
								html += '<div class="clear"></div>';
								html += '</div>';
								html += '<p class="green pdTop06 pdLeft08 pdBot03">'+gn+'&nbsp;&nbsp;胜</p>';
								html += '<div class="competitions bfcom">';
								html += '<span><strong>0:1</strong><em>'+cbf_[18]+'</em></span>';
								html += '<span><strong>0:2</strong><em>'+cbf_[19]+'</em></span>';
								html += '<span><strong>1:2</strong><em>'+cbf_[20]+'</em></span>';
								html += '<span><strong>0:3</strong><em>'+cbf_[21]+'</em></span>';
								html += '<span><strong>1:3</strong><em>'+cbf_[22]+'</em></span>';
								html += '<span><strong>2:3</strong><em>'+cbf_[23]+'</em></span>';
								html += '<span><strong>0:4</strong><em>'+cbf_[24]+'</em></span>';
								html += '<span><strong>1:4</strong><em>'+cbf_[25]+'</em></span>';
								html += '<span><strong>2:4</strong><em>'+cbf_[26]+'</em></span>';
								html += '<span><strong>0:5</strong><em>'+cbf_[27]+'</em></span>';
								html += '<span><strong>1:5</strong><em>'+cbf_[28]+'</em></span>';
								html += '<span><strong>2:5</strong><em>'+cbf_[29]+'</em></span>';
								html += '<span class="bflast"><strong>负其它</strong><em>'+cbf_[30]+'</em></span>';
							}
							html += '<div class="clear"></div>';
							html += '</div>';
							html += '</div><div class="zfTrue clearfix"><a href="javascript:;" class="zfqx">取 消</a><a href="javascript:;">确 定</a></div>';
							html += '</div>';
						});
						html +='</div></section>';
					});
					jQuery('#content_').html(html);
					Jczq_bf.my_play();
					Jczq_bf.bind_delay();//必须有对阵之后的绑定事件
				}
			});
		},
		bind_delay: function(){
			$("#bf").click(function(){
				window.location.href="/jsbf/";
			});
			jQuery('.sfcTitle').Touch(function(){//星期
				$(this).find('em').toggleClass('down');
				$(this).next().slideToggle(300);
			});
			jQuery('.li_weige').Touch(function(){//联赛历史战绩
				$(this).find('i').toggleClass('xzdown');
				$(this).parent().next().slideToggle(300);
			});
			/***
			jQuery('.sfcpl').Touch(function(){//联赛历史战绩
				$(this).prev().find('li:eq(0) i').toggleClass('xzdown');
				$(this).slideToggle(300);
			});
			***/
			$(".bfzb").bind("click",function(){
				var itemid = $(this).attr("itemid");
				var qc = $(this).attr("qc");
				var type=$(this).attr("type");
				window.location.href="/jsbf/dzxq.html?itemid="+itemid+"&type="+type+"&qc="+qc;
			});
			jQuery('#content_').find('ul.sfcxs p.spfzpk span').click(function(){//打开比分选项
				var c_ = $('#content_ section').find('div:eq(1) ul[v=y]').length;
				if(c_>14){
					D.tx("最多选择15场比赛");
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
				Jczq_bf.public_bf($(this).parent().parent());
				
				jQuery('.zhezhao').hide();
				$(this).parent().parent().hide();
			});
			jQuery('.bf_').find('a:eq(1)').click(function(){//确定比分层
				jQuery('.zhezhao').hide();
				$(this).parent().parent().hide();
				
			});
			jQuery('.bf_ div.competitions span').click(function(){//选择比分
				$(this).toggleClass('cur');
				
				Jczq_bf.public_bf($(this).parent().parent().parent());
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
							m += '<cite '+((s == '胜其它' ||s == '负其它' ||s == '平其它') ?'class="sqt"':'')+'>'+s+'</cite>';
						}
					});
					
					t.prev().prev().find('li:eq(1) p:eq(1) span').html(m);
				}
				t.find('div.competitions span.cur').each(function(aa){
						var s = $(this).find('strong').html();
						s = {'胜其它':'9:0','负其它':'0:9','平其它':'9:9'}[s]||s;
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
			Jczq_bf.my_play();
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
				jQuery('#content_ ul.sfcxs[v=y]').removeAttr('v').removeAttr('c').find('.cur').removeClass('cur').html('立即投注');
				jQuery('#content_ div.bf_[a=c]').removeAttr('a').find('.cur').removeClass('cur');//清空之前比分层里面的cur
				
				localStorage.removeItem('jczq_bf_PollNum');
				Jczq_bf.my_play();
			});
			jQuery('#isOk_').click(function(){
				if(parseInt($('#c_').html())>1){
					var c = '';
					jQuery('#content_ section').find('div:eq(1) ul[v=y]').each(function(){
						var code = $(this).attr('c');//投注的内容
						var t = $(this).attr('t');//编号
						var one = $(this).find('li:eq(1) p:eq(0)').html();
						var two = $(this).find('li:eq(1) p:eq(1)').html();
						var bf_ = $(this).next().next().html();
		                c += '<li t="'+$(this).attr('t')+'" c="'+code+'" v="y">';
		                c += '<cite class="errorBg"><em class="error2"></em></cite>';
		                c += '<div class="spfzpkNum">'+one+'</div>';
		                c += '<div class="spfzpk bfpk">'+two+'</div>';
		                c += '</li>';
		                c += '<div class="bfPop bf_" style="display: none;" a="c">'+bf_+'</div>';
		                
					});
					localStorage.setItem('jczq_bf_SelectNum',c);
					localStorage.removeItem('jczq_bf_PollNum');
					window.location.href='#class=url&xo=jczq/bf/ture.html';
				}else{
					D.tx('请至少选择2场比赛');
				}
			});
		}
};
Jczq_bf.initial();