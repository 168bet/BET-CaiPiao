
CP.Game = function(){
    var $sf=[],$rq=[],$bf=[],$jq=[],$bqc=[];//对阵xml
    var dom= {
        'dg_bf':$('#dg_bf'),//比分
        'bf_s':$('#bf_scroll'),
        'money':$('#money'),//购买金额
        'buyFooter':$('.buyFooter')//合买 自购投注
    };
    var g = {
    		money : 0, //无倍投时的金额 即1倍时的
	        bet : 1, //当前选择了多少倍数
	        count : 0, //当前选择了多少注
	        spArr : [],//每一排选了几个号 用于计算注数
	        pass : [],//过关方式 如：[2,3] 表示选了2串1 3串1 
	        amount : 0, //当前投注总金额金额  不代表合买应付金额
	        hmMoney : 0,//合买应付金额
	        bonus : 0,//理论奖金范围
	        curChangCi : 0, //已选多少场次
	        buyType : 1,//1:自购 2:合买
	        codes : '',//投注code
			loty_id : '', //彩种id
			qihao_id : ''//当前期号
    };
    var lotid = {
    	'bf':'71'
    };
    var poll = {
        	'sf':'dg_spf_PollNum','rq':'dg_rqspf_PollNum','bf':'dg_bf_PollNum','jq':'dg_jq_PollNum','bqc':'dg_bqc_PollNum'
    };
    var F = {
        	'sf':'SPF','rq':'RQSPF','bf':'CBF','jq':'JQS','bqc':'BQC'
    };
    var o = {
		//页面跳转
		pageGo: {
			goBack: function () {
//				TopAnch.init({
//					title:'篮彩单关'
//				});
				$('#box_header').hide()
			}
		},
        init : function(){
        	$.ajax({
				url : CP.Data.data+'/data/app/jclq/full_jclq_hh.xml',
				type : 'get',
				dataType : 'xml',
				success:function(xml){
					var r = $(xml).find('row');
					!r.length && alert('暂无比赛数据');
					var html_bf = '', sfc;
					r.each(function(){
						var itemid = $(this).attr('itemid');
						if(itemid == '160413314'){
							console.log(itemid)
							var hn = $(this).attr('hn')//主队
							var gn = $(this).attr('gn')//客队
							var mt = $(this).attr('mt')//开赛时间
							var et = $(this).attr('et')//截止时间
							var mname = $(this).attr('mname')
							sfc = $(this).attr('sfc')//
							html_bf = '<li><div><cite>'+gn+'</cite><i>vs</i><em>'+hn+'</em></div><p>'+mname+' '+mt+'开赛</p></li>';//明天凌晨
							$('#dg_bf .gddgtitle em').eq(0).html(gn+'胜')
							$('#dg_bf .gddgtitle em').eq(1).html(hn+'胜')
							$('#gddg_bf_ p').eq(0).html(gn+' 胜')
							$('#gddg_bf_ p').eq(1).html(hn+' 胜')
							$('#content_home .bfTitle label').eq(0).html(gn+' 胜')
							$('#content_home .bfTitle label').eq(1).html(hn+' 胜')
						}
					});
					
					dom.bf_s.html(html_bf);
					sfc = sfc.split(',')
					console.info(sfc)
					var i= 0;
					$('#gddg_bf_ div em').each(function(){
						this.innerHTML = sfc[i++]
					})
					var j = 0;
					$('#dg_bf .tzxx em').each(function(){
						j = j == 3 ? '6':j;
						this.innerHTML = '赔率 '+sfc[j++]
					})
				}
			});
        },
        /*算金额[[*/
        count : function(){
        	var bs = dom.money.find('input').val()/2;
        	var t = 'bf';
        	var je = $('#money input').val();
        	

        	
        	var l = '';
        	if(t == 'bf'){
        		l = $('.bfPop').find('.cur').length;
        	}else{
        		l = $('#dg_'+t).find('.tzxx .cur').length;
        	}
        	if(je == '' || parseInt(je)<2 || l == '0'){
        		dom.buyFooter.find('a').html('猜中比赛结果即获奖');
        	}else{
        		je = parseInt(je)*l;
        		dom.buyFooter.find('a').html('立即付款   '+je+'元');
        		$("#zje").html(je);
        		dom.buyFooter.find('a').attr('v',je);
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
        	var bs = $('#money input').val()/2;
        	var _out =[]
        	$('.bfPop').find('.cur').each(function(){
        		_out.push('HH|160413314>SFC='+$(this).attr('s')+'|1*1_'+bs)
        	});
        	return _out.join(';');
        },
        
        /*发起合买页面[[*/
        doHm : function (){
			/*显示合买[[*/
			$("#dgdg").hide();
			$('#dghm').show();
			/*]]显示合买*/
			
			/*设置导航左右按钮 [[*/
			TopAnch.init({
				title:'发起合买',
				prevShow:true,
				prevFun:function(){//左侧按钮绑定事件
					window.location.href = '#type=url&p=list/gddg.html';
				},
				isBack:true,
				nextShow:false
			});
			$('#hmDet cite').html(g.amount);//总金额
			$("#rg").val(Math.ceil(g.amount*0.05));
			$("#rg_bl").html(Math.floor(($('#rg').val()/g.amount)*10000)/100+"%");
			$("#bd").removeAttr('disabled');
			$("#bd").val('0');
			$("#bd_bl").html('0%');
			o.hmDet();
        },
        /*]]发起合买页面*/
        
        /*认购保底多少[[*/
		hmDet : function () {
			var rg = parseInt($('#rg').val() || 0);
			var bd = parseInt($('#bd').val() || 0);
			var z = rg+bd;
			g.hmMoney = z;
			$('#hm_m cite:eq(0)').html(rg);//认购
			$('#hm_m cite:eq(1)').html(bd);//保底
			$('#hm_m cite:eq(2)').html(z);//总金额
		},
		/*]]认购保底多少*/
		
        /*获取购买的各种参数 [[*/
		getArgument : function(t){
			var buy = {};
			switch(t){
				/* 1:自购 2:合买  */
				case 1:
					buy = {//投注参数
							payUrl:    '/trade/jcast.go',//投注接口
							gid:       g.loty_id,//彩种id
							pid:       g.qihao_id,//期号
							codes:     g.codes,//投注内容
							muli:      g.bet,//倍数
							countMoney:g.amount,//方案金额
							orderType:'dg'//代购
					};
					break;
				case 2:
					buy = {//投注参数
						payUrl:    '/trade/jcast.go',//投注接口
						gid:       g.loty_id,//彩种id
						pid:       g.qihao_id,//期号
						codes:     g.codes,//投注内容
						muli:      g.bet,//倍数
						desc:      $('#hmDesc').val() || '快乐购彩、欧耶！',//方案宣传
						countMoney:g.amount,//方案金额
						bnum:      $('#rg').val(),//认购
						pnum:      $('#bd').val(),//保底
						oflag:     $('#isPublic .cur').attr('v') || 0,//公开状态
						wrate:     $('#ratio .cur').attr('v') || 5,//提成比例
						orderType:'hm'//代购
					};
					break;
			}
			return buy;
		},
		/*获取购买的各种参数 ]]*/
		
		/*拼凑购买弹窗需要的参数[[*/
		dopay : function(t){
			t ? g.buyType=2 : g.buyType=1;//合买、自购
			var _obj = o.getArgument(g.buyType);
			var cMoney = '';
			t ? cMoney = g.hmMoney : cMoney = g.amount;//应付金额
			var data = {//支付弹框参数
					gid:     g.loty_id,//彩种id
					cMoney:  cMoney,//需支付金额
					payPara: _obj,//jQuery.param(param)
					bonus:   g.bonus,//奖金范围
					fun : 'CP.Game.pay'
			};
			alert('提交中，请稍后！','loading');
			console.info(data)
			CP.User.info(function(options){
				!t && $('#jc_close').click();//代购的时候关闭选择过关方式的层
				remove_alert();
				if (options) {jQuery.extend(data, options);}
				CP.Popup.buybox(data);
			},function(){
				if(CP.MobileVer.android){
					window.caiyiandroid.clickAndroid(3, '');
				}
				else if(CP.MobileVer.ios || CP.MobileVer.ios7 || CP.MobileVer.ipad){
					WebViewJavascriptBridge.callHandler('clickIosLogin');
				}else {
					remove_alert();
					location.href = '#type=fun&fun=CP.Home.openLogin';
					alert('请先登录');
				}
				
			});
		},
		/*购买弹窗]]*/
		
		/*购买验证[[*/
		dobuy : function(Q){
			var t = 'bf';
        	if($('#'+t+'_scroll').html() == ''){
        		alert('暂无比赛，请稍后再试');
        	}else{
        		var je = $('#money input').val();
            	var l = '';
            	if(t == 'bf'){
            		l = $('.bfPop').find('.cur').length;
            	}
            	if(l<=0){
            		alert('请先选择一场比赛');
            	}else if(je <2){
            		alert('购买金额最少2元');
            	}else{
            		g.loty_id = lotid[t];
            		g.amount = dom.buyFooter.find('a').attr('v'); 
            		g.codes = o.href_();
            		if(Q){window.location.href = "#type=fun&fun=CP.Game.doHm";}else{o.dopay();}
            	}
        	}
		},
		/*购买验证]]*/
		
		/*单关支付[[*/
		pay : function (opt) {
			var opt_ = opt.payPara || {};
			if (opt_.orderType == 'dg') {//代购
				data = {
						gid : opt.gid,
						play : '1',
						codes : opt_.codes,
						beishu : 1,
						zhushu : 1,
						content : '自购',
						title : '自购',
						ishm : 0,
						sgtypename : '单关固赔',
						extendtype : '13',
						money : opt_.countMoney,
						ffag :0,
						muli :1,
						type : 0,
						bnum :1,
						tnum:1,
						oflag:0,
						isshow:0,
						source:CP.Data.source,
					    appversion:'4.0.9'
				};
			}else if(opt.payPara.orderType == 'hm'){//合买
				data = {
						gid :opt.gid,//彩种编号
						play:1,//玩法 复式1   单式0
						codes:opt_.codes,//投注内容
						beishu:1,
						zhushu:1,
						desc:opt_.desc,//方案宣传内容
						title:'快乐购彩',
						ishm:1,
						sgtypename : '单关固赔',
						extendtype:13,
						money:opt_.countMoney,//方案金额
						fflag:0,//是否文件上传 0  非文件上传  1 文件上传
						muli:1,
						type:'1',//方案类型0 代购   1合买
						bnum:opt_.bnum,//购买份数
						tnum:opt_.countMoney,//方案总份数
						oflag:opt_.oflag,//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
						isbaodi:0,
						pnum:opt_.pnum,//保底份数
						wrate:opt_.wrate,//提成比例
						isshow:0,
						cupacketid: opt.cupacketid,//红包id
						redpacket_money: opt.redpacket_money//使用红包金额
				};
			}
			$.ajax({
				url: CP.Data.apps+opt_.payUrl,
				type:'POST',
				data: data,
				success:function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					var r = R.find('result');
					if (code == "0") {
						var projid = '';
						if(opt_.hid){
							projid = opt_.hid;
						}else{
							projid = r.attr('projid');//方案编号
						}
						window.location.replace('#type=url&p=user/success.html?projid='+projid);
					} else {
						alert(desc);
					}
				}
			});
		}
		/*]]单关支付*/
    };
    var bind=function(){
    	//菊花初始化对阵
        o.init();
    	
        dom.buyFooter.on('touchend','a',function(){
        	o.dobuy();
        })
       $('#hmSubmit').bind(start_ev,function(){o.dopay('hm');});//提交合买
        
       
        dom.dg_bf.Touch({children:'.tzxx span',fun:function(){
    		$(this).toggleClass('cur');
        	if($(this).hasClass('cur')){
        		$('.bfPop span[s='+$(this).attr('s')+']').addClass('cur');
        	}else{
        		$('.bfPop span[s='+$(this).attr('s')+']').removeClass('cur');
        	}
        	o.count();
        }});


        dom.money.on('blur','input',function(){
        	var t = parseInt($(this).val());
        	if($(this).val() == '' || t == '0'){
        		alert('最少2元');
        		$(this).val('2');
        	}else{
        		if(t % 2 == '0'){
            		$(this).val(t);
            	}else{
            		alert('购买金额必须为双数');
            		$(this).val(t+1);
            	}
        	}
        	o.count();
        }).on('keyup','input',function(){
        	this.value=this.value.replace(/\D/g,'');
        	if(this.value>19998){
        		this.value = '19998';
        	}
        	o.count();
        }).on('touchend','em:eq(0)',function(){//减
        	var t = parseInt($('#money input').val());
        	if(t <= '3'){
        		alert('最少2元');
        	}else{
        		$('#money input').val(t-2);
        	}
        	o.count();
        }).on('touchend','em:eq(1)',function(){//加
        	var t = parseInt($('#money input').val());
        	if(t>=19998){
        		return;
        	}
        	$('#money input').val(t+2);
        	o.count();
        });
        dom.dg_bf.Touch({children:'.gddgmore span',fun:function(){//比分 更多
        	$('#zhezhao').show();
        	$('.bfPop').removeClass('bf_hidden')
        }});
        $('.bfPop').on('touchend','.zfTrue a:eq(0)',function(){//取消比分
        	$('#zhezhao').hide();
        	$('.bfPop').addClass('bf_hidden')
        }).on('touchend','.zfTrue a:eq(1)',function(){//确定比分
        	$('#zhezhao').hide();
        	$('.bfPop').addClass('bf_hidden')
        }).on(end_ev,'.competitions span',function(){//选择比分
        	
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
            		if(tmp!="1-5" && tmp!="6-10" && tmp!="11-15")
            		{			
            			html_tmp=html_tmp+tmp+"&nbsp";
            		}
            	});
            	if(num>0)
            		$(".gddgmore span").addClass("cur2");    	           	
            	if(num>4)
            		{
                	$(".gddgmore span").html("其它比分已选"+num+"项");  	
            		}
            	else
            		{$(".gddgmore span").html(html_tmp);}
          
            	if(num<=0)
            		{$(".gddgmore span").html("更多");   
            		$(".gddgmore span").removeClass("cur2");   
            		}
        });

    };
    var init=function(){
        o.pageGo.goBack();
        bind();
        CP.Data.source = '2145';
        var allcookies = document.cookie;
    	if(allcookies.indexOf('TOKEN')!='-1'){
    		setTimeout(function(){
    			allcookies = allcookies.split('&');
    			var token = '',appid = '';
    			$.each(allcookies,function(index, val){
    				if(val.indexOf('TOKEN=')>=0){
    					token = val.split('TOKEN=')[1];
    				}
    				if(val.indexOf('APPID=')>=0){
    					appid = val.split('APPID=')[1];
    				}
    			});
    			$.ajax({
    				url:'/user/swaplogin.go',
    				data:{
    					logintype:'1',
    					accesstoken:token,
    					appid:appid
    				},
    				type:'POST',
    				success:function(){
    					remove_alert();
    				},
    				error:function(){
    					alert('网络异常，请重新打开页面');
    				}
    			});
    		},300);
    	}
    };
    init();
    return {
    	dz:o.duizhen,
    	pay : o.pay,
    	doHm : o.doHm,
    	pageGo : o.pageGo};
}();
function resetPage(){//登录或合买的回调函数
	$('#content_home').show();//登录完之后显示投注层
	$('#box_header').addClass('zcHeader');
	CP.Game.pageGo.goBack();
	$('#dgdg').show();
	$('#dghm').hide();
}