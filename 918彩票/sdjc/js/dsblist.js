
var agentFrom = location.search.getParam("agentFrom")
//  全局变量
var agent = {
		'username':'',
		'pn':1,
		'tp':1
};
var ag = {};
var SDXQ ={
		init:function(a){
			SDXQ.info(a);
		},
		cuter2 : function( str ){//abcd  
	        return str.replace( /\B(?=(?:\d{3})+$)/g, ',' );  
		 },
		info:function(a){
			$.ajax({
				url:'/user/query.go?flag=6',
				type:'GET',
				dataType:'xml',
				success:function(xml){
					var R = $(xml).find('Resp');
					var rows =R.find('rows')
					var r = rows.find('row');
					var c = R.attr('code');
					agent.username = r.attr('nickid')
					if(c == '0'){
						SDXQ.dataList(a,agent.username);
					}else{
						SDXQ.dataList(a);
					}
				},error : function () {
					SDXQ.dataList(a);
					remove_alert();
					alert('网络异常请刷新重试');
				}
			})
		},
		dataList:function(a,b){
			if(!(agent.clickSome)){
				(a==1 || a==5) && $('#zhing').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');//综合
				(a==2 || a==6) && $('#mzing').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');//命中
				(a==3 || a==7) && $('#hbing').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');//回报率
				(a==4 || a==8) && $('#jjing').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');//奖金
			}
			$.ajax({
				url:'/user/share_god_user_list.go',
				data:{
					flag : a,
					ps : 10,
					uid : b || '',
					pn : agent.pn
				},
				type:'POST',
				dataType : "xml",
				success: function(xml){
					var R = $(xml).find('Resp');
					var row = R.find('rows');
					agent.pn = row.attr('pn');//当前页数
					agent.tp = row.attr('tp');//总页数
					agent.ranking = row.attr('ranking');
					agent.realuid = row.attr('realuid');
					var username = row.attr('nickid');
					agent.userphoto = row.attr('userphoto');
					agent.uptype = row.attr('uptype');
					agent.projallnum = row.attr('projallnum');
					agent.projrednum = row.attr('projrednum');
					agent.shootrate = row.attr('shootrate');
					agent.buymonry = row.attr('buymonry');
					agent.winmoney = row.attr('winmoney');
					agent.returnrate = row.attr('returnrate');
					agent.unfinishnum = row.attr('unfinishnum');
					var r = row.find('row');
					var html = '';
					if(agent.pn > 1){
						(a==1 || a==5) && (html = $('#zhing').html());//综合
						(a==2 || a==6) && (html = $('#mzing').html());//命中
						(a==3 || a==7) && (html = $('#hbing').html());//回报率
						(a==4 || a==8) && (html = $('#jjing').html());//奖金
					}
					if(agent.realuid && (agent.realuid != agent.nickid)){
						agent.nickid = agent.realuid;
						html += '<li nickid='+agent.realuid+'>';
						if(agent.uptype != 0 && agent.uptype){
							if(agent.ranking == '1'){
								html +='<i class="dsb_pm dsb_pm1"><img src="img/medal.png"/></i>'
							}else if(agent.ranking == '2'){
								html +='<i class="dsb_pm dsb_pm1"><img src="img/medal1.png"/></i>'
							}else if(agent.ranking == '3'){
								html +='<i class="dsb_pm dsb_pm1"><img src="img/medal2.png"/></i>'
							}else if(agent.ranking){
								html += '<i class="dsb_pm dsb_pm4">'+agent.ranking+'</i>'
							}
						}else{
							html +='<i class="dsb_pm dsb_pm0">未上榜</i>'
						}
						if(agent.userphoto){
							html += '<span class="dsb_headimg"><img src="'+agent.userphoto+'"/>'
						}else{
							html += '<span class="dsb_headimg"><img src="img/zwtp.png"/>'
						}
						if(agent.unfinishnum != 0 && agent.unfinishnum){
							html +='<em>'+agent.unfinishnum+'</em></span>'
						}else{
							html +='</span>'
						}
						html +='<div class="dsb_listright"><p class="dsb_username">'+username+'</p>'
						if(agent.uptype != 0 && agent.uptype){
							html +='<p class="dsb_onlist"><i>'+agent.uptype+'日</i><span>'+agent.projallnum+'中'+agent.projrednum+'</span>回报率<em>'+agent.returnrate+'</em></p>'
							html +='<p class="dsb_amount">累计中奖<span>'+SDXQ.cuter2(agent.winmoney)+'元</span></p></div>'
						}else{
							html +=' <p class="dsb_noton">上榜还未成功，同志仍需努力~</p></div></li>'
						}
					}
 					if(r.length > 0){
					r.each(function(a,b){
						ag.ranking=$(this).attr('ranking');
						ag.realuid = $(this).attr('realuid');
						ag.nickid=$(this).attr('nickid');
						ag.uptype=$(this).attr('uptype');
						ag.userphoto = $(this).attr('userphoto');
						ag.projallnum=$(this).attr('projallnum');
						ag.projrednum=$(this).attr('projrednum');
						ag.shootrate=$(this).attr('shootrate');
						ag.buymonry=$(this).attr('buymonry');
						ag.winmoney=$(this).attr('winmoney');
						ag.returnrate=$(this).attr('returnrate');
						ag.unfinishnum=$(this).attr('unfinishnum');
						html += '<li nickid='+ag.realuid+'>';
						if(agent.nickid != ag.realuid){
							if(ag.ranking == '1'){
								html +='<i class="dsb_pm dsb_pm1"><img src="img/medal.png"/></i>'
							}else if(ag.ranking == '2'){
								html +='<i class="dsb_pm dsb_pm1"><img src="img/medal1.png"/></i>'
							}else if(ag.ranking == '3'){
								html +='<i class="dsb_pm dsb_pm1"><img src="img/medal2.png"/></i>'
							}else if(ag.ranking){
								html += '<i class="dsb_pm dsb_pm4">'+ag.ranking+'</i>'
							}
							if(ag.userphoto){
								html += '<span class="dsb_headimg"><img src="'+ag.userphoto+'"/>'
							}else{
								html += '<span class="dsb_headimg"><img src="img/zwtp.png"/>'
							}
							if(ag.unfinishnum != 0 && ag.unfinishnum){
								html +='<em>'+ag.unfinishnum+'</em></span>'
							}else{
								html +='</span>'
							}
							html +='<div class="dsb_listright"><p class="dsb_username">'+ag.nickid+'</p>'
							html +='<p class="dsb_onlist"><i>'+ag.uptype+'日</i><span>'+ag.projallnum+'中'+ag.projrednum+'</span>回报率<em>'+ag.returnrate+'</em></p>'
							html +='<p class="dsb_amount">累计中奖<span>'+SDXQ.cuter2(ag.winmoney)+'元</span></p></div>'
						}
					})
 					}else{
 						html ='<div class="empty_user"><p>暂无盈利大神</p></div>'
 					}
 					if(a < 5){$('#jcdsdsb_more2') && ($('#swheight section:eq('+(a-1)+') #jcdsdsb_more2').remove())}else{$('#jcdsdsb_more2') && ($('#swheight section:eq('+(a-5)+') #jcdsdsb_more2').remove())}
 					
					if(agent.pn < agent.tp){
						if(a < 5){
		 					$('#jcdsdsb_more2') && ($('#swheight section:eq('+(a-1)+') ul').after('<div class="jcdsdsb_more " id="jcdsdsb_more2">加载更多</div>'));
		 				}else{
		 					$('#jcdsdsb_more2') && ($('#swheight section:eq('+(a-5)+') ul').after('<div class="jcdsdsb_more " id="jcdsdsb_more2">加载更多</div>'));
		 				}
 					}
					if(a < 5){$('#swheight section:eq('+(a-1)+') ul').html(html);}else{$('#swheight section:eq('+(a-5)+') ul').html(html);}
					var h1 = Number($('#detail_gd').height());
						
					var h1 = 0;
					(a==1 || a==5) && (h1 = Number($('section:eq(0)').height()));//综合
					(a==2 || a==6) && (h1 = Number($('section:eq(1)').height()));//命中
					(a==3 || a==7) && (h1 = Number($('section:eq(2)').height()));//回报率
					(a==4 || a==8) && (h1 = Number($('section:eq(3)').height()));//奖金
					$('#swheight').css({'height':h1});
					SDXQ.bindEve()
					agent.clickSome =''
				},
				error : function() {
					remove_alert();
					alert('网络异常，请刷新重试');
				}
			})
		},
		checkUser:function(a){
			$.ajax({
				url:'/user/query.go?flag=2',
				type:'GET',
				dataType:'xml',
				success:function(xml){
					var R = $(xml).find('Resp');
					var c = R.attr('code');
//					var isBindIdCard = R.find('row').attr('idcard');
//					var isBindMobile = R.find('row').attr('mobbind');
					if(c == '1'){
						if(agentFrom){
							location.href="login.html?agentFrom="+agentFrom;
						}else{
							location.href="login.html"
						}							
					}else if(c == '0'){
						if(agentFrom){
							window.location.href="/sdjc/details.html?loc="+a+"&agentFrom="+agentFrom;
						}else{
							window.location.href="/sdjc/details.html?loc="+a
						}
					}
				},error : function () {
					remove_alert();
					alert('网络异常请刷新重试');
				}
			})
		},
		bindEve:function(){
			$(".jcdsdsb_more").on('touchend mousedown',function(e){
				e.preventDefault()
				agent.clickSome = '1';
				$(this).html('加载中请稍等')
				var add = $(this).attr('add');
				if(!add){
					$(this).attr('add','add');
					var i = 1;
					if($('.dsd_txt span').attr('type')){
						i = Number($('.on').index())+5;
					}else{
						i = Number($('.on').index())+1;
					}
					agent.pn ++;
					if(agent.pn <= agent.tp){
						SDXQ.init(i);
					}
				}
				
			})
			$('ul li').bind('click',function(){
				var nickid = $(this).attr('nickid');
				SDXQ.checkUser(nickid);
				/*if(agentFrom){
					window.location.href = '/sdjc/details.html?loc='+nickid+"&agentFrom="+agentFrom;
				}else{
					window.location.href = '/sdjc/details.html?loc='+nickid;
				}*/
			})
		}
}
$(function(){
	SDXQ.init(1);
	var appRet = function(scheme,pageid){
		var config = {
				 /*scheme:必须*/
	            scheme_IOS: 'caiyi9188Lotterynomal',
	            scheme_Adr: 'lotterystartapp',
	            download_url: 'http://t.9188.com  /',
	            timeout: 1000
	        };
		var now = Date.now();
	    var ifr = $('.head_btn');
	    var typefrom = location.search.getParam("type_from");
//	    alert(typefrom +' '+ browser.versions.ios + " "+(location.search.getParam("page")));
//	    if(browser.versions.android && typefrom == 'android'){
//	    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else if(browser.versions.ios && typefrom == 'ios'){
//	    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else if(typefrom == 'android' && browser.versions.ios){
//	    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else if(typefrom == 'ios' && browser.versions.android){
//	    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
//	    }else 
	    if(browser.versions.android){
	    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid)
	    }else if(browser.versions.ios){
	    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid)
	    }
	    var t = setTimeout(function() {
	        var endTime = Date.now();
	        if (Date.now() - now < config.timeout+800){
	        		window.location.href= config.download_url; 
	        }
	    }, config.timeout);
	}
	var f = true;
	var tabsSwiper = new Swiper('.swiper-container',{
		speed:300,
		autoHeight:true,
		onSlideChangeStart: function(){
			$(".tab_title h3").removeClass('on')
			$(".tab_title h3").eq(tabsSwiper.activeIndex).addClass('on')  
			}
		})
	$(".tab_title h3").on('touchend mousedown',function(e){
		e.preventDefault()
		agent.pn = 1
		var i = 1;
		if(!($(this).is('.on'))){
			if($('.dsd_txt span').attr('type')){
				i = Number($(this).index())+5;
			}else{
				i = Number($(this).index())+1;
			}
			$('#swheight section:eq('+$(this).index()+') #jcdsdsb_more2').remove()
			SDXQ.init(i);
		}
	    $(".tab_title h3").removeClass('on');
	    $(this).addClass('on')
	    tabsSwiper.slideTo($(this).index())
	})
	$(".tab_title .dsd_txt").on('click',function(e){
		agent.pn = 1
		var index = $('.on').index()
		if(f){
			$('.tab_title .dsd_txt').html('当前仅显示有进行中方案的大神<span type=a>查看全部</span>')
			var i = Number(index)+5;
			$('section:eq('+index+') ul').html('');
			$('#swheight section:eq('+index+') #jcdsdsb_more2').remove()
			SDXQ.init(i);
			f = false;
			
		}else{
			$('.tab_title .dsd_txt').html('点击切换 , 显示有进行中方案的大神<span>切换</span>');
			var i = Number(index)+1;
			$('section:eq('+index+') ul').html('');
			$('#swheight section:eq('+index+') #jcdsdsb_more2').remove()
			SDXQ.init(i);
			f = true;
		}
	    
	})
	if(!(location.search.getParam("source"))){
		$('#heah_h').addClass('height_h');
		$('.head_load').show();
	}
	$('.head_close').bind('click' ,function(){
		$('#heah_h').removeClass('height_h');
		$('.head_load').hide();
	})
	$('.head_btn').bind('click' , function(){
		try{
			var page = location.search.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	appRet(page,32);
            }
		}catch(e){}
	})
	
})