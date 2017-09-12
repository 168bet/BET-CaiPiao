var agentdata = {pn: 1,tp: 1};
var lo = decodeURIComponent(location.search);



//点击滑动显示
window.onload = function() {
	SDXQ.init();
	$(document).delegate('a','click' , function(){
		$('.myMore').html('加载中请稍等');
		var add = $(this).attr('add');
		if(!add){
			$(this).attr('add','add');
			agentdata.pn ++;
			if(agentdata.pn <= agentdata.tp){
				SDXQ.dataUser(1)
			}	
			
		}			 
	 })
	$(".tab_title span").on('touchend mousedown',function(e){
	    e.preventDefault()
	    $(".tab_title .active").removeClass('active');
	    $(this).addClass('active')
	    tabsSwiper.slideTo($(this).index() )
	    agentdata.pn = 1;
	    if($(this).index() == 1){
	    	if(!($(this).attr('ab'))){
	    		$(this).attr('ab','ab');
	    		$(this).siblings().removeAttr('ab');
	    		SDXQ.dataUser(1,true)
	    	}
	    }else{
	    	if(!($(this).attr('ab'))){
	    		$(this).attr('ab','ab');
	    		$(this).siblings().removeAttr('ab');
	    		SDXQ.dataUser(0,true)
	    	}
	    }
  })
	var tabsSwiper = new Swiper('.swiper-container1',{
	    onSlideChangeStart: function(){
	      $(".tab_title .active").removeClass('active')
	      $(".tab_title span").eq(tabsSwiper.activeIndex).addClass('active')  
	    }
	 })
  
  $(".tab_title span").click(function(e){
    e.preventDefault()
  })
  
}

var agentFrom = location.search.getParam("agentFrom")||"";
var locname = location.search.getParam("locname")||"";
var fflag = lo.getParam("fflag")||'';
var ent = lo.getParam("ent")||'';

var SDXQ = {
//		初始化init
		init:function(){
			SDXQ.dataUser(0,true);
			if(ent == 'me'){
				$('.jcds_head h1').html('我的详情')
			}
		},
		cuter2 : function( str ){//abcd  
	        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
		 },
//		接口数据解析
		dataUser: function(a,b){//a为 0 时 进行中数据 1 时 完成的数据
			try{
				var loc = lo.getParam("loc");
			}catch(e){}
			if(a == 0 && b){
				$('#detail_ing').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');
			}else if(a == 1 && b){
				$('#detail_gd').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');
			}
			$.ajax({
				url: '/user/share_user_details_new.go',
				data:{
					newValue: loc,
					qtype: a,
					pn: agentdata.pn,
					ps: 10
				},
				type : "POST",
				dataType : "xml",
				success: function(xml){ 
					var R = $(xml).find('Resp');
					var code = R.attr('code');
					if(code == 0){
					var r =R.find('rows');
					var ue = r.find('userinfo');
					if(a == 1){
						agentdata.pn = Number(r.attr('pn'));//页数
						agentdata.tp = Number(r.attr('tp'));//总页数
					}
					agentdata.nickid = ue.attr('nickid');
					agentdata.userphoto = ue.attr('userphoto');
					agentdata.rewardall = ue.attr('rewardall');
					agentdata.isowner = ue.attr('isowner');
					 
					$('.p4').html(agentdata.nickid);//用户名
					if(agentdata.rewardall > 0){
						$('.p5').html('累计收到打赏'+agentdata.rewardall+'元');//累计打赏
					}else{
						$('.p5').html('暂未收到打赏');//累计打赏
					}
					
					if(agentdata.userphoto && agentdata.userphoto != 'null'){
						$('.promoter1_h img').attr('src',agentdata.userphoto);
					}
					var gl = r.find('godlist');
						agentdata.ranking = gl.attr('ranking');//大神排名
						agentdata.projallnum = gl.attr('projallnum');//下单数
						agentdata.projrednum = gl.attr('projrednum');//红单数
						agentdata.shootrate = gl.attr('shootrate');//命中率
						agentdata.buymoney = gl.attr('buymonry');//购买金额
						agentdata.winmoney = gl.attr('winmoney');//盈利金额
						agentdata.returnrate = gl.attr('returnrate')//回报率
						agentdata.zsbl = gl.attr('zsbl');//战胜比率
						
						agentdata.winmoney30 = gl.attr('winmoney30')	 //30天中奖金额	 
						agentdata.follownum30 = gl.attr('follownum30')	 //30天跟买人数	 
						agentdata.followmoney30 = gl.attr('followmoney30')	 //30天跟买金额	 
						agentdata.combo = gl.attr('combo')	 //连红
						agentdata.shootrate7 = gl.attr('shootrate7')	 //7日命中率	 
						agentdata.returnrate7 = gl.attr('returnrate7')	 //7日回报率	 
						agentdata.shootrate15 = gl.attr('shootrate15')	 //15日命中率	 
						agentdata.returnrate15 = gl.attr('returnrate15')	 //15日回报率	
						agentdata.shootrate30 = gl.attr('shootrate30')	 //30日命中率	
						agentdata.returnrate30 = gl.attr('returnrate30')	 //30日回报率	
						agentdata.showData = gl.attr('showData')	 //是否展示
					if(agentdata.showData == 1 && a == 0 && $('#line_swip').css('display') == 'none'){
						SDXQ.render(1);
						var swiper = new Swiper('.swiper-container', {
							pagination: '.swiper-pagination',
							paginationClickable: true,
							loop : true,
							autoplay : 3000,
							speed:300,
							autoplayDisableOnInteraction : false
						});
					}
						var  ro = r.find('row');
						var html = '';
						if(agentdata.pn > 1){
							html = $('#detail_gd').html();
						}
						if(ro.length > 0){
							ro.each(function(i,w){
								agentdata.projid = $(this).attr('projid');//方案编号
								agentdata.tmoney = $(this).attr('tmoney');//下单金额
								agentdata.mintmoney = $(this).attr('mintmoney');//最小投注金额
								agentdata.wrate = $(this).attr('wrate');//打赏比率
								agentdata.matchnum = $(this).attr('matchnum');// 比赛场次
								agentdata.guoguan = SDXQ.guoguan($(this).attr('guoguan'));// 过关方式
								agentdata.follownums = $(this).attr('follownums');// 跟买人数	 
								agentdata.endtime = $(this).attr('endtime');// 截止时间
								agentdata.bonus = $(this).attr('bonus');//单子中奖金额
								agentdata.flag = $(this).attr('flag');	 //命中标记
								agentdata.followrate = $(this).attr('followrate');
								agentdata.yczs = $(this).attr('yczs');
									html +='<li class=clearfix ftype='+agentdata.projid+'>';
									html +='<div class="jcds_dsblit clearfix">'
									if(fflag){
										if(!locname){
											if(agentdata.isowner == 0){
												if(parseFloat(agentdata.followrate) >= parseFloat('100%') && a == 0){
													html += '<p class="jcds_dsbp1">已满额</p>'
												}
											}
										}
									}
									if(a == 0){
										html += '<p class="jcds_dsbp3">'+agentdata.endtime+'截止</p>'
									}
									html += '</div>'
									html += '<div class="jcds_dsblic clearfix">'
									html += '<p class="jcds_dsbp4">'+SDXQ.cuter2(agentdata.tmoney)+'元</p>'
									html += '<p class="jcds_dsbp5"><em>起投</em><span>'+SDXQ.cuter2(agentdata.mintmoney)+'元</span><i>打赏'+agentdata.wrate+'</i></p>'
				                    html += '</div>'
				                    html += '<div class="jcds_dsblib clearfix">'
				                    html += '<p class="jcds_dsbp6">发单人购买</p>'
				                    html += '<p class="jcds_dsbp7">'+agentdata.matchnum+'场 '
				                    if(agentdata.yczs == '1'){
				                    	html += agentdata.guoguan+'一场制胜'+'</p>'
				                    }else{
				                    	html += agentdata.guoguan+'</p>'
				                    }
				                    
				                    if(agentdata.follownums != '0'){
				                    	 html += '<p class="jcds_dsbp8">'+agentdata.follownums+'人跟买</p>'
				                    }
									if(agentdata.flag == 1 && a== 1){
										html +='<div class="zhong_div zhong_div_small"></div>'
									}
									html += '</div></li>'
								/*else{
									html +='<li class="clearfix" ftype='+agentdata.projid+'>'
									html +='<div class="jcds_dsblit clearfix">'
										
										
									html +='<div class="div5"><p class="p6">'+SDXQ.cuter2(agentdata.tmoney)+'元</p><p class="p7">发单人购买</p></div>'
									html +='<div class="div6"><p class="p8"><span class="span15">起投</span>'
									html +='<span class="span16">'+SDXQ.cuter2(agentdata.mintmoney)+'元</span>'
									html +='<span class="span17">打赏 '+agentdata.wrate+'</span></p><p class="p7">'+agentdata.matchnum+'场 '+agentdata.guoguan+'</p></div>'
									if(agentdata.follownums != '0'){
										html +='<div class="div7">'+agentdata.follownums+'人跟买</div>'
									}
									if(agentdata.flag == 1){
										html +='<div class="zhong_div_fang"></div>'
									}
										html +='</li>'
								}*/
							})
							a == 0?($('#detail_ing').html(html)):($('#detail_gd').html(html));
							}
						}else if(code == '1'){
							if(agentFrom){
								location.href="login.html?agentFrom="+agentFrom;
							}else{
								location.href="login.html";
							}
						}
						var len1 = $('#detail_ing').find('li').length;//进行中
						var len2 = $('#detail_gd').find('li').length;//完成
						if(len1 <= 0 && a == 0){
							$('#detail_ing').html('<div class="empty_user"><p>暂无进行中方案</p></div>')
						}
						if(a == 1){
							$('.myMore') && ($('.myMore').remove());
							if(agentdata.pn < agentdata.tp){
								$('#detail_gd').after('<a  class="myMore" id="mymore" style="border-bottom: none;">查看更多</a>');
							}
						}
						if(len2 <= 0 && a == 1){
							$('#detail_gd').html('<div class="empty_user"><p>暂无已完成方案</p></div>')
						}
						if(a == 0){
							var h = $('#detail_ing').height();
							$('#swheight').css({'height':h});
						}
						if(a == 1){
							var h1 = Number($('#detail_gd').height());
							if($('#mymore')){
								var hh = Number($('#mymore').height());
								$('#swheight').css({'height':(h1+hh)});
							}else{
								$('#swheight').css({'height':h1});
							}
						}
							
				},
				error : function() {
					alert('网络异常，请刷新重试');
					return false;
				}
			})
		},
//		过关方式解析
		guoguan: function(g){
			var gg = g.split(',');
			var html = '';
			if(gg.length >= 1){
				for(var i=0;i<gg.length;i++){
					if(gg[i] == '1*1'){
						html += '单关';
					}else{
						var num = gg[i].split('*');
						html += num[0]+'串'+num[1]+' '
					}
				}	
				return html
			}
		},
//		数据渲染
		render: function(a){
			if(a == 1){ //1 轮播渲染
				var text = '<div class="swiper-wrapper">'	 
				text += '<div class="swiper-slide swiper-slide1">'
				text += '<div class="swiper_l">'
				text += '<p class="p3">'+ agentdata.winmoney30+'元</p><p><span class="span7">30日</span><span>累计中奖</span></p></div>'
				text += '<div class="swiper_r"><p>累计<span>'+agentdata.follownum30+'</span>人已跟买</p><p>跟买总额<span>'+agentdata.followmoney30+'</span>元</p></div>'
				text += '</div>'
							 
				text += '<div class="swiper-slide swiper-slide1">'
				text +='<ul class="swiper_ul4 clearfix">';
				text +='<li><p class="p_top">7日命中率</p>'
				if(agentdata.shootrate7 && parseFloat(agentdata.shootrate7) > parseFloat('0%')){
				text +='<p class="p_bottom">'+agentdata.shootrate7+'</p></li>'
				}else{
				text +='<p class="p_bottom gray">暂无</p></li>'
				}
				text +='<li><p class="p_top">15日命中率</p>'
				if(agentdata.shootrate15 && parseFloat(agentdata.shootrate15) > parseFloat('0%')){
				text +='<p class="p_bottom">'+agentdata.shootrate15+'</p></li>'
				}else{
				text +='<p class="p_bottom gray">暂无</p></li>'
				}
				text +='<li><p class="p_top">30日命中率</p>'
				if(agentdata.shootrate30 && parseFloat(agentdata.shootrate30) > parseFloat('0%')){
				text +='<p class="p_bottom">'+agentdata.shootrate30+'</p></li>'
				}else{
						 text +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 text +='<li><p class="p_top">最近连红</p>'
						 if(agentdata.combo !=0){
						 text +='<p class="p_bottom">'+agentdata.combo+'连红</p>'
						 }else{
						 text +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 text +='</ul>'
						 text +='</div>'
							 
						 text +='<div class="swiper-slide swiper-slide1">'
					     text +='<ul class="swiper_ul3 clearfix">'
						 text +='<li><p class="p_top">7日回报率</p>'
						 if(agentdata.returnrate7 && parseFloat(agentdata.returnrate7) > parseFloat('0%')){
						 text +='<p class="p_bottom">'+agentdata.returnrate7+'</p></li>'
						 }else{
						 text +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 text +='<li><p class="p_top">15日回报率</p>'
						 if(agentdata.returnrate15 && parseFloat(agentdata.returnrate15) > parseFloat('0%')){
						 text +='<p class="p_bottom">'+agentdata.returnrate15+'</p></li>'
						 }else{
						 text +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 text +='<li><p class="p_top">30日回报率</p>'
						 if(agentdata.returnrate30 && parseFloat(agentdata.returnrate30) > parseFloat('0%')){
						 text +='<p class="p_bottom">'+agentdata.returnrate30+'</p></li>'
						 }else{
						 text +='<p class="p_bottom gray">暂无</p></li>'
						 }
						 text +='</ul>'
						 text +='</div>'
						 text +='</div>'
						 text+='<div class="swiper-pagination"></div>'
				$('#line_swip').html(text);
				var mm = agentdata.winmoney30.split('.')[0].length;
				if(mm <= 4){
					$('.p3').css({'font-size':'1.875rem'})
				}else if(mm >4 && mm <= 6){
					$('.p3').css({'font-size':'1.5rem'})
				}else if(mm >6 && mm <= 9){
					$('.p3').css({'font-size':'1.2rem'})
				}
				$('#line_swip').show();
			}
		}
}
var appRet = function(scheme,pageid,extend){
	var config = {
			 /*scheme:必须*/
            scheme_IOS: 'caiyi9188Lotterynomal',
            scheme_Adr: 'lotterystartapp',
            download_url: 'http://t.9188.com  /',
            timeout: 1000
        };
	var now = Date.now();
    var ifr = $('.head_btn');
    var typefrom = lo.getParam("type_from");
//    alert(typefrom +' '+ browser.versions.ios + " "+(lo.getParam("page")));
    if(browser.versions.android && typefrom == 'android'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios && typefrom == 'ios'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'android' && browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'ios' && browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }
    /*ifr.style.display = 'none';
    document.body.appendChild(ifr);*/
    var t = setTimeout(function() {
        var endTime = Date.now();
        if (Date.now() - now < config.timeout+800){
//        	document.body.removeChild(ifr);
        		window.location.href= config.download_url; 
        }
    }, config.timeout);
}

$(function(){
//	page
	$('.head_btn').bind('click' , function(){
		try{
			var page = lo.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	appRet(page,33,lo.getParam("loc"));
            }
			
		}catch(e){}
	})
	$('#swheight').delegate('li','click' , function(){
		var ftype = $(this).attr('ftype')
		
		if(lo.getParam("fflag")){
			if(lo.getParam("locname")){
				if(agentFrom){
					location.href="/sdjc/buy.html?hid="+ftype+'&page='+lo.getParam("page")+'&type_from='+lo.getParam("type_from")+"&agentFrom="+agentFrom+'&shareUserId='+locname+'&fflag='+fflag;
				}else{
					location.href="/sdjc/buy.html?hid="+ftype+'&page='+lo.getParam("page")+'&type_from='+lo.getParam("type_from")+'&shareUserId='+locname+'&fflag='+fflag;
				}
			}else{
				if(agentFrom){
					location.href="/sdjc/buy.html?hid="+ftype+'&page='+lo.getParam("page")+'&type_from='+lo.getParam("type_from")+"&agentFrom="+agentFrom+'&fflag='+fflag;
				}else{
					location.href="/sdjc/buy.html?hid="+ftype+'&page='+lo.getParam("page")+'&type_from='+lo.getParam("type_from")+'&fflag='+fflag;
				}
			}
		}else{
			if(agentFrom){
				location.href="/sdjc/buy.html?hid="+ftype+"&agentFrom="+agentFrom;
			}else{
				location.href="/sdjc/buy.html?hid="+ftype;
			}
			
		}
	})
	document.addEventListener('touchmove', function(event){ //微信出现遮罩层后禁止冒泡
        		/* document.documentElement.style.height = window.innerHeight + 'px'; */
        		if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 && ($("#downloadDiv").css('display') == 'block')){
        			var ev = event || window.event;
   				 	ev.preventDefault();
   				 	document.body.style.overflow=" hidden";
            	}
	})
})

