/*
 *Author:weige
 *Date: 2014-7-24
 */
var Bjdc_kj = {
		initail: function(){
			Bjdc_kj.content();
			Bjdc_kj.bind();
		},
		bind: function(){
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
		},
		delay_bind: function(){
			jQuery('#content div.sfcTitle').Touch(function(){
				$(this).find('em').toggleClass('down');
				$(this).next().toggle();
			});
			jQuery('#content div.sfcTitle').each(function(){
				var n = $(this).next().find('ul.sfcxs').length;
				$(this).find('cite').html(n);
			});
			
		},
		content:function(){
			var data;
			data = {
					gid : '85'
			};
			$('.loading').hide();
			D.load();
			$.ajax({
				url:'/trade/list.go',
				data: data,
				type:'POST',
				DataType:'xml',
				success:function(xml){
					D.load(close);
					var R = $(xml).find('rows');
					var r = R.find('row');
					var wk=["日","一","二","三","四","五","六"];
					var rl = r.length;
					if(rl == 0){
						D.tx('亲，木有赛事哦！');
					}
					var html = '';
					var end_t = '';
					r.each(function(a){
						$('.loading').hide();
						var pid = $(this).attr('pid');//期次编号
						var mid = $(this).attr('mid');//比赛场次
						var mn = $(this).attr('mn');//主队名称
						var sn = $(this).attr('sn');//客队名称
						var ms = $(this).attr('ms');//主队进球数
						var ss = $(this).attr('ss');//客队进球数
						var hms = $(this).attr('hms');//半场主队进球数
						var hss = $(this).attr('hss');//半场客队进球数
						var lose = $(this).attr('lose');//让球数
						var mname = $(this).attr('mname');//联赛名称
						var mt = $(this).attr('mt');//比赛结束时间
						var end_time = mt.substr(0,10);//截止时间
						var tDATE = new Date(end_time);
						var wk2 = '星期'+wk[tDATE.getDay()];
						if(end_t != end_time){
							if(a != 0){
								html += '</section>';
							}
							html += '<div class="sfcTitle">'+end_time+' '+wk2+'  <cite></cite>场比赛<em class="up down"></em></div>';
							html += '<section class="jczqkj sfcopt" style="display:none;">';
						}
						var zjq,spf,bq,sxds;
						if(ms != ''){
							ms = parseInt(ms),ss = parseInt(ss),hms = parseInt(hms),hss = parseInt(hss);
							zjq = ms+ss;
							spf = (ms>ss && '<span class="red">主胜</span>')||(ms==ss && '<span class="blue">平</span>')||'<span class="green">主负</span>';
								var b = (hms>hss && '<em class="red">胜</em>')||(hms==hss && '<em class="blue">平</em>')||'<em class="green">负</em>';
								var q = (ms>ss && '<em class="red">胜</em>')||(ms==ss && '<em class="blue">平</em>')||'<em class="green">负</em>';
							bq = b+''+q;
							
								var sx,ds;
								sx = (zjq >=3 && '上')||'下';
								ds = (zjq%2 && '单')||'双';
							sxds = sx+''+ds;
						}else{
							ms = '-',ss = '-';
							zjq = '-';
							spf = '-';
							bq = '-';
							sxds = '-';
						}
						
						html += '<ul class="sfcxs">';
						html += '<li><em>'+mid+'</em><p>'+mname+'</p><cite>'+mt.substr(5,11)+'</cite></li>';
						html += '<li>';
						html += '<p class="spfzpkNum"><span>(主)'+mn.substr(0,5)+'</span><span class="spfvs">'+ms+':'+ss+'</span><span>'+sn.substr(0,5)+'(客)</span></p>';
						html += '<div>';
						html += '<p><span>胜平负('+lose+')</span><span>总进球</span><span>半全场</span><span>上下单双</span></p>';
						html += '<p>'+spf+'<span>'+zjq+'</span><span>'+bq+'</span><span>'+sxds+'</span></p>';
						html += '</div>';
						html += '</li>';
						html += '</ul>';
						
						end_t = end_time;
					});
					$('#content').html(html);
					Bjdc_kj.delay_bind();
				}
			});
		}
};
Bjdc_kj.initail();