/*
 * Author: wangwei
 */

jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend( jQuery.easing,
    {
        def: 'easeOutQuad',
        easeOutCubic: function (x, t, b, c, d) {
            return c*((t=t/d-1)*t*t + 1) + b;
        },
        easeOutBounce: function (x, t, b, c, d) {
            if ((t/=d) < (1/2.75)) {
                return c*(7.5625*t*t) + b;
            } else if (t < (2/2.75)) {
                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
            } else if (t < (2.5/2.75)) {
                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
            } else {
                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
            }
        }
});

/*
 * @description 固定单关活动类
 * @name Gddg 
 */
CP.Gddg = function(){
    var $sf=[],$rq=[],$bf=[],$jq=[],$bqc=[];//对阵xml
    var dom= {
        'dg_sf':$('#dg_sf'),//胜负
        'dg_rq':$('#dg_rq'),//让分
        'dg_bf':$('#dg_bf'),//比分
        'dg_jq':$('#dg_jq'),//进球
        'dg_bqc':$('#dg_bqc'),//半全场
        'sf_s':$('#sf_scroll'),
        'rq_s':$('#rq_scroll'),
        'bf_s':$('#bf_scroll'),
        'jq_s':$('#jq_scroll'),
        'bqc_s':$('#bqc_scroll'),
        'money':$('#money'),//购买金额
        'buyFooter':$('.buyFooter')//合买 自购投注
    };
    var lotid = {
    	'sf':'72','rq':'90','bf':'91','jq':'93','bqc':'92'
    };
    var poll = {
        	'sf':'dg_spf_PollNum','rq':'dg_rqspf_PollNum','bf':'dg_bf_PollNum','jq':'dg_jq_PollNum','bqc':'dg_bqc_PollNum'
    };
    var F = {
        	'sf':'SPF','rq':'RQSPF','bf':'CBF','jq':'JQS','bqc':'BQC'
    };
    var o = {
        /*滑动[[*/
        slide : function(_obj){
            var menu = $(_obj.menu);//菜单点击滑动DOM
            var con = $(_obj.con);//内容滑动DOM
            var slideBox =$(_obj.slideBox)||'';//滑动模块DOM
            menu.click(function(){
                var index= $(this).index();//当前位置
                $('#top_con').css({'height':$('#top_con section:eq('+index+')').height()+'px'});
                var conW=  con.width();//单个内容块宽度
                /*当前tab离父元素距离+(tabkuandu +滑动块宽度)/2*/
                var w=menu.eq(index).position().left+(menu.eq(index).width()-slideBox.width())/2;
                slideBox!=''?slideBox.stop(true,false).animate({'left': w} , _obj.menuSpeed||100):'';//选项目录滑动
                $(this).addClass('cur').siblings().removeClass('cur');
                con.each(function(i){
                    $(this).stop(true,false).animate({'left': i<index ? -conW : (i>index ? conW:'') }, _obj.conSpeed||300,_obj.effect||'') ;
                    i==index?$(this).stop(true,false).animate({'left':0 } , _obj.conSpeed||300,_obj.effect||''):'' ;
                });
                o.change(index);
            });
        },
        /*滑动]]*/
        init : function(){
        	D.load();
        	$.ajax({
				url : '/data/app/jczq/new_jczq_hh.xml',
				type : 'get',
				dataType : 'xml',
				success:function(xml){
					D.load('关');
					var r = $(xml).find('row');
					!r.length && D.msg('暂无比赛数据'); 
					var html_spf = [], html_rq=[], html_bf=[],html_jq=[],html_bqc=[] ,spf_a=0,rq_a=0,bf_a=0,jq_a=0,bqc_a=0;
					r.each(function(){
						var sf = {}, rq = {}, bf = {}, jq = {}, bqc = {};
						var itemid = $(this).attr('itemid');//编号
						var hn = $(this).attr('hn').substr(0,4);//主队
						var gn = $(this).attr('gn').substr(0,4);//客队
						var mt = $(this).attr('mt');//比赛
						mt = mt.substring(0,mt.length-3);
						var mname = $(this).attr('mname').substr(0,4);//赛事
						var close = $(this).attr('close');//让球数
						var isale = $(this).attr('isale');//是否停售
						var spf = $(this).attr('spf');//胜平负赔率
						var rqspf = $(this).attr('rqspf');//让球胜平负赔率
						var cbf = $(this).attr('cbf');//猜比分赔率
						var jqs = $(this).attr('jqs');//进球数赔率
						var bqc1 = $(this).attr('bqc');//不清楚赔率
						var spfscale = $(this).attr('spfscale');//胜平负人气
						var rqspfscale = $(this).attr('rqspfscale');//让球胜平负人气
						if((512 & isale) > 0){//胜平负是否停售
							sf.itemid = itemid;//编号
    						sf.hn = hn;//主队
    						sf.gn = gn;//客队
    						sf.mt = mt;
    						sf.spf = spf;//让球胜平负赔率
    						sf.spfscale = spfscale;//人气
							if(sf.hn == '中国' || sf.gn == '中国'){
								$sf.unshift(sf);
								html_spf.unshift('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}else{
								$sf.push(sf);
								html_spf.push('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}
							spf_a++;
						}
						if((32 & isale) > 0){//让球是否停售
							rq.itemid = itemid;//编号
    						rq.hn = hn;//主队
    						rq.gn = gn;//客队
    						rq.mt = mt;
    						rq.close = close;//让球数
    						rq.rqspf = rqspf;//让球胜平负赔率
    						rq.rqspfscale = rqspfscale;//人气
							if(rq.hn == '中国' || rq.gn == '中国'){
								$rq.unshift(rq);
								html_rq.unshift('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');//明天凌晨
							}else{
								$rq.push(rq);
								html_rq.push('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');//明天凌晨
							}
							rq_a++;
						}
						if((64 & isale) > 0){//比分是否停售
							bf.itemid = itemid;//编号
    						bf.hn = hn;//主队
    						bf.gn = gn;//客队
    						bf.mt = mt;
    						bf.cbf = cbf;//让球胜平负赔率
							if(bf.hn == '中国' || bf.gn == '中国'){
								$bf.unshift(bf);
								html_bf.unshift('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}else{
								$bf.push(bf);
								html_bf.push('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}
							bf_a++;
						}
						if((256 & isale) > 0){//是否停售
							jq.itemid = itemid;//编号
    						jq.hn = hn;//主队
    						jq.gn = gn;//客队
    						jq.mt = mt;
    						jq.jqs = jqs;//让球胜平负赔率
							if(jq.hn == '中国' || jq.gn == '中国'){
								$jq.unshift(jq);
								html_jq.unshift('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}else{
								$jq.push(jq);
								html_jq.push('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}
							jq_a++;
						}
						if((128 & isale) > 0){//是否停售
							bqc.itemid = itemid;//编号
    						bqc.hn = hn;//主队
    						bqc.gn = gn;//客队
    						bqc.mt = mt;
    						bqc.bqc = bqc1;//让球胜平负赔率
							if(bqc.hn == '中国' || bqc.gn == '中国'){
								$bqc.unshift(bqc);
								html_bqc.unshift('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}else{
								$bqc.push(bqc);
								html_bqc.push('<li><div><cite>'+hn+'</cite><i>vs</i><em>'+gn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>');
							}
							bqc_a++;
						}
					});
						//自动跳转有比赛的玩法 
						if(spf_a==0&&rq_a!=0){
							$('#top_menu li').eq(1).click();
						}else if(spf_a==0&&rq_a==0&&bf_a!=0){
							$('#top_menu li').eq(2).click();
						}
						//右切换箭头取消
							$("#sfScroll .next").show();
						if(rq_a<2){
							$("#rqScroll .next").hide();
						}
						if(bf_a<2){
							$("#bfScroll .next").hide();
							}
						if(jq_a<2){
							$("#jqScroll .next").hide();
						}
						if(bqc_a<2){
							$("#bqcScroll .next").hide();
							}

					dom.sf_s.html(html_spf.join(''));
					dom.rq_s.html(html_rq.join(''));
					dom.bf_s.html(html_bf.join(''));
					dom.jq_s.html(html_jq.join(''));
					dom.bqc_s.html(html_bqc.join(''));
					GddgSlide({slideCell:"#sfScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
					GddgSlide({slideCell:"#rqScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
					GddgSlide({slideCell:"#bfScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
					GddgSlide({slideCell:"#jqScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
					GddgSlide({slideCell:"#bqcScroll",mainCell:".gddgbd ul",autoPage:true,pnLoop:"false"});
					$rq.length && o.duizhen('0','rq');
					$bf.length && o.duizhen('0','bf');
					$jq.length && o.duizhen('0','jq');
					$bqc.length && o.duizhen('0','bqc');
				}
			});
        },
        /*取玩法xml放在数组里面[[*/
        change : function(index){
        	if(index == '1'){
        		!$rq.length && D.msg('暂无比赛对阵');
        	}else if(index == '2'){
        		!$bf.length && D.msg('暂无比赛对阵');
        	}else if(index == '3'){
        		!$jq.length && D.msg('暂无比赛对阵');
        	}else if(index == '4'){
        		!$bqc.length && D.msg('暂无比赛对阵');
        	}
        	
        	$('#top_con section:eq('+index+')').find('.cur').removeClass('cur');
        	$('#money input').val('10');
        	dom.buyFooter.find('a:eq(1)').html('猜中比赛结果即获奖');
        	dom.money.find('.pdTop03').hide();
        },
        /*]]取玩法xml放在数组里面*/
        /*[[填对阵信息*/
        duizhen : function(t,xo){
        	var lot =  xo || $('#top_menu .cur').attr('v');
        	if(lot == 'sf'){
        		!$sf.length && D.msg('暂无比赛对阵');
        		var x = $sf[t].spf.split(',');
        		var x1 = x[0],x2 = x[1],x3 = x[2];
        		dom.dg_sf.find('.tzxx').attr('v',$sf[t].itemid);//编号
        		dom.dg_sf.find('.tzxx li:eq(0) span:eq(0)').attr('s',x1);//主队sp
        		dom.dg_sf.find('.tzxx li:eq(0) span:eq(1)').attr('s',x2);//平
        		dom.dg_sf.find('.tzxx li:eq(0) span:eq(2)').attr('s',x3);//客队sp
        		dom.dg_sf.find('.tzxx li:eq(0) span:eq(0) cite').html($sf[t].hn);//主队
        		dom.dg_sf.find('.tzxx li:eq(0) span:eq(2) cite').html($sf[t].gn);//客队
        		dom.dg_sf.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x1);//主胜奖金
        		dom.dg_sf.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x2);//平
        		dom.dg_sf.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x3);//客胜
        		var scale = $sf[t].spfscale.split(',');
        		var z = parseInt(scale[0]);var p = parseInt(scale[1]);var k = parseInt(scale[2]);
        		if(!isNaN(z)){
        			dom.dg_sf.find('.gddghot p:eq(0) em').html(z+'%人气');//主人气
            		dom.dg_sf.find('.gddghot p:eq(0) i').css({'height':z*5/100+'rem'});
            		dom.dg_sf.find('.gddghot p:eq(1) em').html(p+'%人气');//平
            		dom.dg_sf.find('.gddghot p:eq(1) i').css({'height':p*5/100+'rem'});
            		dom.dg_sf.find('.gddghot p:eq(2) em').html((100-z-p)+'%人气');//客
            		dom.dg_sf.find('.gddghot p:eq(2) i').css({'height':k*5/100+'rem'});
        		}
        	}else if(lot == 'rq'){
        		var x = $rq[t].rqspf.split(',');
        		var x1 = x[0],x2 = x[1],x3 = x[2];
        		dom.dg_rq.find('.tzxx').attr('v',$rq[t].itemid);
        		dom.dg_rq.find('.tzxx li:eq(0) span:eq(0)').attr('s',x1);
        		dom.dg_rq.find('.tzxx li:eq(0) span:eq(1)').attr('s',x2);
        		dom.dg_rq.find('.tzxx li:eq(0) span:eq(2)').attr('s',x3);
        		dom.dg_rq.find('.tzxx li:eq(0) span:eq(0) cite').html($rq[t].hn+'('+$rq[t].close+')');//主队
        		dom.dg_rq.find('.tzxx li:eq(0) span:eq(2) cite').html($rq[t].gn);//客队
        		dom.dg_rq.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x1);//主胜奖金
        		dom.dg_rq.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x2);//平
        		dom.dg_rq.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x3);//客胜
        		var scale = $rq[t].rqspfscale.split(',');
        		var z = parseInt(scale[0]);var p = parseInt(scale[1]);var k = parseInt(scale[2]);
        		if(!isNaN(z)){
        			dom.dg_rq.find('.gddghot p:eq(0) em').html(z+'%人气');//主人气
            		dom.dg_rq.find('.gddghot p:eq(0) i').css({'height':z*5/100+'rem'});
            		dom.dg_rq.find('.gddghot p:eq(1) em').html(p+'%人气');//平
            		dom.dg_rq.find('.gddghot p:eq(1) i').css({'height':p*5/100+'rem'});
            		dom.dg_rq.find('.gddghot p:eq(2) em').html((100-z-p)+'%人气');//客
            		dom.dg_rq.find('.gddghot p:eq(2) i').css({'height':k*5/100+'rem'});
        		}
        	}else if(lot == 'bf'){
        		dom.dg_bf.find('.gddgtitle em:eq(0)').html($bf[t].hn+'&nbsp;胜');//主队
        		dom.dg_bf.find('.gddgtitle em:eq(2)').html($bf[t].gn+'&nbsp;胜');//客队
        		var x = $bf[t].cbf.split(',');
        		dom.dg_bf.find('.tzxx').attr('v',$bf[t].itemid);//1:0
        		dom.dg_bf.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x[0]);//1:0
        		dom.dg_bf.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x[13]);//0:0
        		dom.dg_bf.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x[18]);//0:1
        		
        		dom.dg_bf.find('.tzxx li:eq(3) em:eq(0)').html('赔率'+x[1]);//2:0
        		dom.dg_bf.find('.tzxx li:eq(3) em:eq(1)').html('赔率'+x[14]);//1:1
        		dom.dg_bf.find('.tzxx li:eq(3) em:eq(2)').html('赔率'+x[19]);//0:2
        		
        		dom.dg_bf.find('.tzxx li:eq(5) em:eq(0)').html('赔率'+x[2]);//2:1
        		dom.dg_bf.find('.tzxx li:eq(5) em:eq(1)').html('赔率'+x[15]);//2:2
        		dom.dg_bf.find('.tzxx li:eq(5) em:eq(2)').html('赔率'+x[20]);//1:2
        		
        		dom.dg_bf.find('.tzxx li:eq(7) em:eq(0)').html('赔率'+x[3]);//3:0
        		dom.dg_bf.find('.tzxx li:eq(7) em:eq(1)').html('赔率'+x[16]);//3:3
        		dom.dg_bf.find('.tzxx li:eq(7) em:eq(2)').html('赔率'+x[21]);//0:3
        		
        		dom.dg_bf.find('.tzxx li:eq(9) em:eq(0)').html('赔率'+x[4]);//3:1
        		dom.dg_bf.find('.tzxx li:eq(9) em:eq(1)').html('赔率'+x[17]);//平其他
        		dom.dg_bf.find('.tzxx li:eq(9) em:eq(2)').html('赔率'+x[22]);//1:3
        		$('.bfPop .bfcom em').each(function(a){//给比分弹窗加sp
        			$(this).html(x[a]);
        		});
        		$('.bfPop .bfTitle label:eq(0)').html($bf[t].hn);//主队
        		$('.bfPop .bfTitle label:eq(1)').html($bf[t].gn);
        		$('.bfPop .red').html($bf[t].hn+'&nbsp;&nbsp;胜');//主队
        		$('.bfPop .green').html($bf[t].gn+'&nbsp;&nbsp;胜');
        	}else if(lot == 'jq'){
        		var x = $jq[t].jqs.split(',');
        		dom.dg_jq.find('.tzxx').attr('v',$jq[t].itemid);//0球
        		dom.dg_jq.find('.tzxx li:eq(0) span:eq(0)').attr('s',x[0]);//0球
        		dom.dg_jq.find('.tzxx li:eq(0) span:eq(1)').attr('s',x[1]);//
        		dom.dg_jq.find('.tzxx li:eq(0) span:eq(2)').attr('s',x[2]);//
        		dom.dg_jq.find('.tzxx li:eq(0) span:eq(3)').attr('s',x[3]);//
        		dom.dg_jq.find('.tzxx li:eq(2) span:eq(0)').attr('s',x[4]);//
        		dom.dg_jq.find('.tzxx li:eq(2) span:eq(1)').attr('s',x[5]);//
        		dom.dg_jq.find('.tzxx li:eq(2) span:eq(2)').attr('s',x[6]);//
        		dom.dg_jq.find('.tzxx li:eq(2) span:eq(3)').attr('s',x[7]);//
        		
        		dom.dg_jq.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x[0]);//0球
        		dom.dg_jq.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x[1]);//
        		dom.dg_jq.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x[2]);//
        		dom.dg_jq.find('.tzxx li:eq(1) em:eq(3)').html('赔率'+x[3]);//
        		dom.dg_jq.find('.tzxx li:eq(3) em:eq(0)').html('赔率'+x[4]);//
        		dom.dg_jq.find('.tzxx li:eq(3) em:eq(1)').html('赔率'+x[5]);//
        		dom.dg_jq.find('.tzxx li:eq(3) em:eq(2)').html('赔率'+x[6]);//
        		dom.dg_jq.find('.tzxx li:eq(3) em:eq(3)').html('赔率'+x[7]);//
        	}else if(lot == 'bqc'){
        		var x = $bqc[t].bqc.split(',');
        		dom.dg_bqc.find('.tzxx').attr('v',$bqc[t].itemid);//胜胜
        		dom.dg_bqc.find('.tzxx li:eq(0) span:eq(0)').attr('s',x[0]);//胜胜
        		dom.dg_bqc.find('.tzxx li:eq(2) span:eq(0)').attr('s',x[1]);//
        		dom.dg_bqc.find('.tzxx li:eq(4) span:eq(0)').attr('s',x[2]);//
        		dom.dg_bqc.find('.tzxx li:eq(0) span:eq(1)').attr('s',x[3]);//平-胜
        		dom.dg_bqc.find('.tzxx li:eq(2) span:eq(1)').attr('s',x[4]);//
        		dom.dg_bqc.find('.tzxx li:eq(4) span:eq(1)').attr('s',x[5]);//
        		dom.dg_bqc.find('.tzxx li:eq(0) span:eq(2)').attr('s',x[6]);//负-胜
        		dom.dg_bqc.find('.tzxx li:eq(2) span:eq(2)').attr('s',x[7]);//
        		dom.dg_bqc.find('.tzxx li:eq(4) span:eq(2)').attr('s',x[8]);//
        		
        		dom.dg_bqc.find('.tzxx li:eq(1) em:eq(0)').html('赔率'+x[0]);//胜胜
        		dom.dg_bqc.find('.tzxx li:eq(3) em:eq(0)').html('赔率'+x[1]);//
        		dom.dg_bqc.find('.tzxx li:eq(5) em:eq(0)').html('赔率'+x[2]);//
        		dom.dg_bqc.find('.tzxx li:eq(1) em:eq(1)').html('赔率'+x[3]);//平-胜
        		dom.dg_bqc.find('.tzxx li:eq(3) em:eq(1)').html('赔率'+x[4]);//
        		dom.dg_bqc.find('.tzxx li:eq(5) em:eq(1)').html('赔率'+x[5]);//
        		dom.dg_bqc.find('.tzxx li:eq(1) em:eq(2)').html('赔率'+x[6]);//负-胜
        		dom.dg_bqc.find('.tzxx li:eq(3) em:eq(2)').html('赔率'+x[7]);//
        		dom.dg_bqc.find('.tzxx li:eq(5) em:eq(2)').html('赔率'+x[8]);//
        	}
        	o.count();
        },
        /*填对阵信息]]*/
        /*算金额[[*/
        count : function(){
        	var bs = dom.money.find('input').val()/2;
        	var t = $('#top_menu .cur').attr('v');
        	var je = $('#money input').val();
        	

        	
        	var l = '';
        	if(t == 'bf'){
        		l = $('.bfPop').find('.cur').length;
        	}else{
        		l = $('#dg_'+t).find('.tzxx .cur').length;
        	}
        	if(je == '' || parseInt(je)<2 || l == '0'){
        		dom.buyFooter.find('a:eq(1)').html('猜中比赛结果即获奖');
        	}else{
        		je = parseInt(je)*l;
        		dom.buyFooter.find('a:eq(1)').html('立即付款   '+je+'元');
        		$("#zje").html(je);
        		dom.buyFooter.find('a:eq(1)').attr('v',je);
        	}
        	var max=0,min=99999;
        	if(l == '0'){//理论奖金
        		dom.money.find('.pdTop03').hide();
        	}else if(l == '1'){
        		if(t == 'bf'){
        			max = parseFloat($('.bfPop').find('.cur').find('em').html());
        		}else{
        			max = $('#dg_'+t).find('.tzxx .cur').attr('s');
        		}
        		dom.money.find('.pdTop03').show();
        		dom.money.find('.pdTop03 em').html((2*bs*max).toFixed('1'));
        	}else{
        		if(t == 'bf'){
            		$('.bfPop').find('.cur').each(function(){
            			var t = parseFloat($(this).find('em').html());
            			max = (max>t)?max:t;
            			min = (min<t)?min:t;
            		});
            	}else{
            		$('#dg_'+t).find('.tzxx .cur').each(function(){
            			var t = parseFloat($(this).attr('s'));
            			max = (max>t)?max:t;
            			min = (min<t)?min:t;
            		});
            	}
        		dom.money.find('.pdTop03').show();
        		dom.money.find('.pdTop03 em').html((2*bs*min).toFixed('1')+'~'+(2*bs*max).toFixed('1'));
        	}
        },
        /*]]算金额*/
        href_ : function(xo){
        	var t = $('#top_menu .cur').attr('v');
        	var t1 = $('#dg_'+t).find('.tzxx').attr('v');
        	var bs = $('#money input').val()/2;
        	var c = '',c1='';
        	if(t == 'bf'){
        		$('.bfPop').find('.cur').each(function(){
            		c += F[t]+'|'+ t1 +'='+ $(this).attr('v') +'|1*1_'+ bs +';';
            		c1 += $(this).attr('v') +',';
            		
            	});
        	}else{
        		$('#dg_'+t).find('.tzxx .cur').each(function(){
            		c += F[t]+'|'+ t1 +'='+ $(this).attr('v') +'|1*1_'+ bs +';';
            		c1 += $(this).attr('v') +',';
            	});
        	}
        	c1 = c1.substring(0, c1.length-1);
        	c = c.substring(0, c.length-1);
        	c = c +'$'+ t1 +'$'+ t1 + '['+ c1 +']';
        	localStorage.setItem(poll[t],c);
        	location.href = xo;
        }
    };
    var bind=function(){
    	//菊花初始化对阵
        o.init();
    	//玩法切换
        o.slide({
            'effect':'easeOutCubic',//切换效果
            'menuSpeed':200,//菜单滑动时间
            'conSpeed':350,//内容滑动时间
            'menu':'#top_menu li',//点击tab切换
            'con':'#top_con section',//对应的内容块
            'slideBox':'.downline'//滑动菜单
        });
        dom.dg_sf.on('click','.tzxx span',function(){
        	if(dom.sf_s.html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		$(this).toggleClass('cur');
            	o.count();
        	}
        });
        dom.dg_rq.on('click','.tzxx span',function(){
        	if(dom.rq_s.html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		$(this).toggleClass('cur');
            	o.count();
        	}
        });
        dom.dg_bf.on('click','.tzxx span',function(){
        	if(dom.bf_s.html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		$(this).toggleClass('cur');
            	if($(this).hasClass('cur')){
            		$('.bfPop span[s='+$(this).attr('s')+']').addClass('cur');
            	}else{
            		$('.bfPop span[s='+$(this).attr('s')+']').removeClass('cur');
            	}
            	o.count();
        	}
        	
        });
        dom.dg_jq.on('click','.tzxx span',function(){
        	if(dom.jq_s.html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		$(this).toggleClass('cur');
            	o.count();
        	}
        });
        dom.dg_bqc.on('click','.tzxx span',function(){
        	if(dom.bqc_s.html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		$(this).toggleClass('cur');
            	o.count();
        	}
        });
        dom.money.on('blur','input',function(){
        	var t = parseInt($(this).val());
        	if($(this).val() == '' || t == '0'){
        		D.alert('最少2元');
        		$(this).val('2');
        	}else{
        		if(t % 2 == '0'){
            		$(this).val(t);
            	}else{
            		D.alert('购买金额必须为双数');
            		$(this).val(t+1);
            	}
        	}
        	o.count();
        }).on('keyup','input',function(){
        	this.value=this.value.replace(/\D/g,'');
        	o.count();
        }).on('click','em:eq(0)',function(){//减
        	var t = parseInt($('#money input').val());
        	if(t <= '3'){
        		D.msg('最少2元');
        	}else{
        		$('#money input').val(t-2);
        	}
        	o.count();
        }).on('click','em:eq(1)',function(){//加
        	var t = parseInt($('#money input').val());
        	$('#money input').val(t+2);
        	o.count();
        });
        dom.dg_bf.on('click','.gddgmore span',function(){//比分 更多
        	var c = $(window).height();
			var d = $('.bfPop').height();
			var t = '-'+(c/2)+'px';
			if(c>d){
				t = '-'+(d/2)+'px';
			}
			$('.bfPop').css('marginTop',t);
        	$('.zhezhao,.bfPop').show();
        });
        $('.bfPop').on('click','.zfTrue a:eq(0)',function(){//取消比分
        	$('.zhezhao,.bfPop').hide();
        	$('.bfPop .cur').removeClass('cur');
        	dom.dg_bf.find('.cur').removeClass('cur');
        	$(".gddgmore span").html("更多");
        	$(".gddgmore span").removeClass("cur2");
        	o.count();
        }).on('click','.zfTrue a:eq(1)',function(){//确定比分
        	$('.zhezhao,.bfPop').hide();
        }).on('click','.competitions span',function(){//选择比分
        	if(dom.bf_s.html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		$(this).toggleClass('cur');
            	if($(this).hasClass('cur')){
            		dom.dg_bf.find('.tzxx span[s='+$(this).attr('s')+']').addClass('cur');
            	}else{
            		dom.dg_bf.find('.tzxx span[s='+$(this).attr('s')+']').removeClass('cur');
            	}
            	o.count();
            	var num=$(".bfPop .cur").length-$(".tzxx .cur").length;   	           	
            	var html_tmp='';
            	$(".bfPop .cur").each(function(){
            		var tmp=$(this).attr("v");
            		if(tmp!="1:0" && tmp!="2:0" && tmp!="2:1" && tmp!="0:0" &&tmp!="1:1"&&tmp!="2:2"&& tmp!="0:1"&&tmp!="0:2"&&tmp!="1:2")
            		{		if(tmp=="9:9")
            				tmp="平其它";
            			else if(tmp=="9:0")
            				tmp="胜其它";
            			else if(tmp=="0:9")
            				tmp="负其它";
            					
            			html_tmp=html_tmp+tmp+"&nbsp";
            		}
            	})
            	
            	if(num>0)
            		$(".gddgmore span").addClass("cur2");    	           	
            	if(num>3)
            		{
                	$(".gddgmore span").html("其它比分已选"+num+"项");  	
            		}
            	else
            		{$(".gddgmore span").html(html_tmp);}
          
            	if(num<=0)
            		{$(".gddgmore span").html("更多");   
            		$(".gddgmore span").removeClass("cur2");   
            		}
        	}
        });
        
        dom.buyFooter.on('click','a:eq(0)',function(){//合买
        	var t = $('#top_menu .cur').attr('v');
        	if($('#'+t+'_scroll').html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		var je = $('#money input').val();
            	var l = '';
            	if(t == 'bf'){
            		l = $('.bfPop').find('.cur').length;
            	}else{
            		l = $('#dg_'+t).find('.tzxx .cur').length;
            	}
            	if(l<=0){
            		D.msg('请先选择一场比赛');
            	}else if(je <2){
            		D.msg('购买金额最少2元');
            	}else{
            		var m = dom.buyFooter.find('a:eq(1)').attr('v');
    				o.href_('/#class=url&xo=gddg/pay/dg_fqhm.html&money='+m+'&gid='+lotid[t]);
            	}
        	}
        }).on('click','a:eq(1)',function(){//自购
        	var t = $('#top_menu .cur').attr('v');
        	if($('#'+t+'_scroll').html() == ''){
        		D.msg('暂无比赛，请稍后再试');
        	}else{
        		var je = $('#money input').val();
            	var l = '';
            	if(t == 'bf'){
            		l = $('.bfPop').find('.cur').length;
            	}else{
            		l = $('#dg_'+t).find('.tzxx .cur').length;
            	}
            	if(l<=0){
            		D.msg('请先选择一场比赛');
            	}else if(je <2){
            		D.msg('购买金额最少2元');
            	}else{
            		var m = dom.buyFooter.find('a:eq(1)').attr('v');
    				o.href_('/#class=url&xo=gddg/pay/paydg.html&money='+m+'&bk=0&gid='+lotid[t]);
            	}
        	}
        });
        
        //右上角菜单显示或隐藏
//        $("#pullIco").on('click',function(){
//        	if($("#pullText").is(':hidden')){
//        		$("#tm_c").show();
//        	}else{
//        		$("#tm_c").hide();
//        	}
//        	$(this).parent().toggleClass("pullHover");
//        	$("#pullText").toggle();
//        });
//        $('#tm_c').on('click',function(){
//        	$(this).toggle();
//        	$('#pullIco').parent().toggleClass("pullHover");
//        	$("#pullText").toggle();
//        });
    };
    var init=function(){
        bind();
        var t = decodeURIComponent(CP.Util.getParaHash("gddg"));//认购金额
        t = {'sf':'0','rq':'1','bf':'2','jq':'3','bqc':'4'}[t]||0;
        $('#top_menu li').eq(t).click();
    };
    init();
    return {dz:o.duizhen };
}();

function isEmptyObject(obj){
    for(var n in obj){return false} 
    return true; 
}
var GddgSlide = function (a) {
    a = a || {
    };
    var b = {
        slideCell: a.slideCell || '#touchSlide',
        titCell: a.titCell || '.hd li',
        mainCell: a.mainCell || '.bd',
        effect: a.effect || 'left',
        autoPlay: a.autoPlay || !1,
        delayTime: a.delayTime || 200,
        interTime: a.interTime || 2500,
        defaultIndex: a.defaultIndex || 0,
        titOnClassName: a.titOnClassName || 'cur',
        autoPage: a.autoPage || !1,
        prevCell: a.prevCell || '.prev',
        nextCell: a.nextCell || '.next',
        pageStateCell: a.pageStateCell || '.pageState',
        pnLoop: 'undefined ' == a.pnLoop ? !0 : a.pnLoop,
        startFun: a.startFun || null,
        endFun: a.endFun || null,
        switchLoad: a.switchLoad || null
    },
    c = document.getElementById(b.slideCell.replace('#', ''));
    if (!c) return !1;
    var d = function (a, b) {
        a = a.split(' ');
        var c = [
        ];
        b = b || document;
        var d = [
            b
        ];
        for (var e in a) 0 != a[e].length && c.push(a[e]);
        for (var e in c) {
            if (0 == d.length) return !1;
            var f = [
            ];
            for (var g in d) if ('#' == c[e][0]) f.push(document.getElementById(c[e].replace('#', '')));
             else if ('.' == c[e][0]) for (var h = d[g].getElementsByTagName('*'), i = 0; i < h.length; i++) {
                var j = h[i].className;
                j && - 1 != j.search(new RegExp('\\b' + c[e].replace('.', '') + '\\b')) && f.push(h[i])
            } else for (var h = d[g].getElementsByTagName(c[e]), i = 0; i < h.length; i++) f.push(h[i]);
            d = f
        }
        return 0 == d.length || d[0] == b ? !1 : d
    },
    e = function (a, b) {
        var c = document.createElement('div');
        c.innerHTML = b,
        c = c.children[0];
        var d = a.cloneNode(!0);
        return c.appendChild(d),
        a.parentNode.replaceChild(c, a),
        m = d,
        c
    },
    g = function (a, b) {
        !a || !b || a.className && - 1 != a.className.search(new RegExp('\\b' + b + '\\b')) || (a.className += (a.className ? ' ' : '') + b)
    },
    h = function (a, b) {
        !a || !b || a.className && - 1 == a.className.search(new RegExp('\\b' + b + '\\b')) || (a.className = a.className.replace(new RegExp('\\s*\\b' + b + '\\b', 'g'), ''))
    },
    i = b.effect,
    j = d(b.prevCell, c) [0],
    k = d(b.nextCell, c) [0],
    l = d(b.pageStateCell) [0],
    m = d(b.mainCell, c) [0];
    if (!m) return !1;
    var N,
    O,
    n = m.children.length,
    o = d(b.titCell, c),
    p = o ? o.length : n,
    q = b.switchLoad,
    r = parseInt(b.defaultIndex),
    s = parseInt(b.delayTime),
    t = parseInt(b.interTime),
    u = 'false' == b.autoPlay || 0 == b.autoPlay ? !1 : !0,
    v = 'false' == b.autoPage || 0 == b.autoPage ? !1 : !0,
    w = 'false' == b.pnLoop || 0 == b.pnLoop ? !1 : !0,
    x = r,
    y = null,
    z = null,
    A = null,
    B = 0,
    C = 0,
    D = 0,
    E = 0,
    G = /hp-tablet/gi.test(navigator.appVersion),
    H = 'ontouchstart' in window && !G,
    I = H ? 'touchstart' : 'mousedown',
    J = H ? 'touchmove' : '',
    K = H ? 'touchend' : 'mouseup',
    M = m.parentNode.clientWidth,
    P = n;
//    if (0 == p && (p = n), v) {
//        p = n,
//        o = o[0],
//        o.innerHTML = '';
//        var Q = '';
//        if (1 == b.autoPage || 'true' == b.autoPage) for (var R = 0; p > R; R++) Q += '<li></li>';
//         else for (var R = 0; p > R; R++) Q += b.autoPage.replace('$', R + 1);
//        o.innerHTML = Q,
//        o = o.children
//    }
    'leftLoop' == i && (P += 2, m.appendChild(m.children[0].cloneNode(!0)), m.insertBefore(m.children[n - 1].cloneNode(!0), m.children[0])),
    N = e(m, '<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'),
    m.style.cssText = 'width:' + P * M + 'px;' + 'position:relative;overflow:hidden;padding:0;margin:0;';
    for (var R = 0; P > R; R++) m.children[R].style.cssText = 'display:table-cell;vertical-align:top;width:' + M + 'px';
    var S = function () {
        'function' == typeof b.startFun && b.startFun(r, p)
    },
    T = function () {
        'function' == typeof b.endFun && b.endFun(r, p)
    },
    U = function (a) {
        var b = ('leftLoop' == i ? r + 1 : r) + a,
        c = function (a) {
            for (var b = m.children[a].getElementsByTagName('img'), c = 0; c < b.length; c++) b[c].getAttribute(q) && (b[c].setAttribute('src', b[c].getAttribute(q)), b[c].removeAttribute(q))
        };
        if (c(b), 'leftLoop' == i) switch (b) {
            case 0:
                c(n);
                break;
            case 1:
                c(n + 1);
                break;
            case n:
                c(0);
                break;
            case n + 1:
                c(1)
        }
    },
    V = function () {
        M = N.clientWidth,
        m.style.width = P * M + 'px';
        for (var a = 0; P > a; a++) m.children[a].style.width = M + 'px';
        var b = 'leftLoop' == i ? r + 1 : r;
        W( - b * M, 0)
    };
    window.addEventListener('resize', V, !1);
    var W = function (a, b, c) {
        c = c ? c.style : m.style,
        c.webkitTransitionDuration = c.MozTransitionDuration = c.msTransitionDuration = c.OTransitionDuration = c.transitionDuration = b + 'ms',
        c.webkitTransform = 'translate(' + a + 'px,0)' + 'translateZ(0)',
        c.msTransform = c.MozTransform = c.OTransform = 'translateX(' + a + 'px)'
    },
    X = function (a) {
        switch (i) {
            case 'left':
                r >= p ? r = a ? r - 1 : 0 : 0 > r && (r = a ? 0 : p - 1),
                null != q && U(0),
                W( - r * M, s),
                x = r;
                break;
            case 'leftLoop':
                null != q && U(0),
                W( - (r + 1) * M, s),
                - 1 == r ? (z = setTimeout(function () {
                    W( - p * M, 0)
                }, s), r = p - 1)  : r == p && (z = setTimeout(function () {
                    W( - M, 0)
                }, s), r = 0),
                x = r
        }
        S(),
        A = setTimeout(function () {
        	CP.Gddg.dz(r);
            T()
        }, s);
//        for (var c = 0; p > c; c++) h(o[c], b.titOnClassName),
        c == r && g(o[c], b.titOnClassName);
        0 == w && (h(k, 'nextStop'), h(j, 'prevStop'), 0 == r ? g(j, 'prevStop')  : r == p - 1 && g(k, 'nextStop')),
        l && (l.innerHTML = '<span>' + (r + 1) + '</span>/' + p)
    };
    if (X(), u && (y = setInterval(function () {
        r++,
        X()
    }, t)), o) for (var R = 0; p > R; R++) !function () {
        var a = R;
        o[a].addEventListener('click', function () {
            clearTimeout(z),
            clearTimeout(A),
            r = a,
            X()
        })
    }();
    k && k.addEventListener('click', function () {
        (1 == w || r != p - 1) && (clearTimeout(z), clearTimeout(A), r++, X())
    }),
    j && j.addEventListener('click', function () {
        (1 == w || 0 != r) && (clearTimeout(z), clearTimeout(A), r--, X())
    });
    var Y = function (a) {
        clearTimeout(z),
        clearTimeout(A),
        O = void 0,
        D = 0;
        var b = H ? a.touches[0] : a;
        B = b.pageX,
        C = b.pageY,
        m.addEventListener(J, Z, !1),
        m.addEventListener(K, $, !1)
    },
    Z = function (a) {
        if (!H || !(a.touches.length > 1 || a.scale && 1 !== a.scale)) {
            var b = H ? a.touches[0] : a;
            if (D = b.pageX - B, E = b.pageY - C, 'undefined' == typeof O && (O = !!(O || Math.abs(D) < Math.abs(E))), !O) {
                switch (a.preventDefault(), u && clearInterval(y), i) {
                    case 'left':
                        (0 == r && D > 0 || r >= p - 1 && 0 > D) && (D = 0.4 * D),
                        W( - r * M + D, 0);
                        break;
                    case 'leftLoop':
                        W( - (r + 1) * M + D, 0)
                }
                null != q && Math.abs(D) > M / 3 && U(D > - 0 ? - 1 : 1)
            }
        }
    },
    $ = function (a) {
        0 != D && (a.preventDefault(), O || (Math.abs(D) > M / 10 && (D > 0 ? r-- : r++), X(!0), u && (y = setInterval(function () {
            r++,
            X()
        }, t))), m.removeEventListener(J, Z, !1), m.removeEventListener(K, $, !1))
    };
    m.addEventListener(I, Y, !1)
};


