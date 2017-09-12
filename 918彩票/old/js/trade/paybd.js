/*
* Author: weige
* Date : 2014-07-08
*/ 
var bk = decodeURIComponent(CP.Util.getParaHash("bk"));//0 自购  1 合买
var gid = decodeURIComponent(CP.Util.getParaHash("gid"));
var pid = decodeURIComponent(CP.Util.getParaHash("pid"));
var code_gid = {'85':'bd_spf','86':'bd_bf','87':'bd_bqc','88':'bd_sxp','89':'bd_jq',//北单
		'71':'jclq_hh','94':'jclq_sf','95':'jclq_rfsf','97':'jclq_dxf',//篮彩
		'84':'sfgg','90':'rqspf','72':'spf','91':'jczq_bf','92':'jczq_bqc','70':'jczq_hh','80':'sfgg','93':'jczq_jq'}[gid];//竞彩 胜负过关
var code_ = localStorage.getItem(code_gid+'_PollNum');

(function(){
	var checkLocastion,kaigan,diao,inital,bind,zfb_pay,zhifu,firstStep,secondStep,thirdStep,dobuy;
	checkLocastion = function(){
		if(bk != '' && gid != ''){
			secondStep(bk,gid,pid);
		}else{
			history.go(-1);
		}
		 $("#slideLoop").bind("click",function(){
			 $(this).toggleClass("downHover");
			 $("#updownContent").slideToggle(400);
		 }); 
	};
	secondStep = function(bk,gid,pid){
		//?notes=13&pid=140703&isPublic=2&countMoney=26&bs=1&rg=2&bd=4&xyText=快乐购彩&wrate=10&bk=1&gid=85
		
		var notes = decodeURIComponent(CP.Util.getParaHash("notes"));//注数
		var multiple = decodeURIComponent(CP.Util.getParaHash("bs"));//倍数
		var cMoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));//方案总金额
		
		$('#slideLoop p:eq(0) cite:eq(0)').html($_sys.getlotname(gid));
		if(bk == 0){// 自购
			$('#slideLoop p:eq(1) cite').html(cMoney);
			if(gid == '85'||gid == '86'||gid == '87'||gid == '88'||gid == '89'||gid == '92'){
				if(pid){
					$('#slideLoop p:eq(0) cite:eq(1)').show().html('第'+pid+'期');
				}else{
					$('#slideLoop p:eq(0) cite:eq(1)').hide()
				}
				
			}
			$('#updownContent p:eq(0) cite').html(notes+'注'+multiple+'倍');
			kaigan(cMoney);//应付金额
		}else if(bk == 1){//合买
			var rg = decodeURIComponent(CP.Util.getParaHash("rg"));//认购金额
			var bd = decodeURIComponent(CP.Util.getParaHash("bd"));//认购金额
			
			var z = parseInt(rg)+parseInt(bd);
			$('#slideLoop p:eq(1) cite').html(z);
			if(gid == '85'||gid == '86'||gid == '87'||gid == '88'||gid == '89'||gid == '92'){
				//$('#slideLoop p:eq(0) cite:eq(1)').show().html('第'+pid+'期');
				if(pid){
					$('#slideLoop p:eq(0) cite:eq(1)').show().html('第'+pid+'期');
				}else{
					$('#slideLoop p:eq(0) cite:eq(1)').hide()
				}
			}
			$('#updownContent p:eq(0) cite').html('方案总额'+cMoney+'元,认购'+rg+'元,保底'+bd+'元('+notes+'注'+multiple+'倍)');
			kaigan(z);//
		}
		var gg = code_.split('|')[1];
		gg = gg.replace(/\*/g,'串').replace('1串1','单关');;
		$('#mp_content').html('&nbsp;'+gg);
		
		thirdStep();
		
		
		$('#pay').click(function(){
			var rPay = parseInt($('#rPay').html());
			zhifu(rPay,pid);
		});
	};
	thirdStep = function(){//拼投注code
		var codes = '';
		var t = {'85':'SPF','86':'CBF','87':'BQC','88':'SXP','89':'JQS'//北单
			,'71':'HH','94':'SF','95':'RFSF','97':'DXF'//篮彩
			,'90':'RQSPF','72':'SPF','91':'CBF','70':'HH','80':'SF','84':'SF','92':'BQC','93':'JQS'}[gid];//竞彩 胜负过关
		codes = t+'|'+code_;
		$('#codes').val(codes);
	};
	diao = function(m,r,hb){//m用户余额 r应付金额 hb使用红包金额
		$('#rPay').html(hb);//红包支付
		$('#mPay').html(r-hb);//账户支付
		hb = parseFloat(hb);
		r = parseFloat(r);
		if((m+hb)<r){
			var ce = Math.ceil(r-(m+hb));
    		$('#chae').parent().show();
    		$('#chae').html(ce);//差额
    		$('.moneyNum').val(ce);
    		$('#cz').show();
    		$('#pay').hide();
    	}else{
    		$('#chae').parent().hide();
    		$('#pay').show();
    		$('#cz').hide();
    		$('#recharge').hide();
    	}
	};
	kaigan = function(r){//应付金额
		
		$.ajax({
	        url: $_user.url.base,
	        success:function (data){
	        	var R = $(data).find("Resp");
	        	var U = R.find("row");
	        	var rb = U.attr("ipacketmoney");
	        	if(rb>0 && bk!=2){
	        		$('.zfMoney').show();
	        	}
	        	var m = parseFloat(U.attr("usermoeny"));
	        	$('#yue').html(m);//账户余额
	        	diao(m,r,0);
	        }
		});
		
		$('#redPacket').click(function(){
			var m = parseFloat($('#yue').html());
			use_red(m,r);
		});
		$('#cz').click(function(){
			$(this).hide();
			$('#recharge').show();
		});
	};
	zhifu = function(rPay,pid){
			dobuy(rPay,pid);//代购合买
	};
	dobuy = function(rPay,pid){
		var cupacketid = $('#cptid').val();
		var codes = $('#codes').val();
		var muli = decodeURIComponent(CP.Util.getParaHash("bs"));
		var countMoney = decodeURIComponent(CP.Util.getParaHash("countMoney"));//方案总金额
		var data = {};
		gid = zeroStr(gid,2);
		if(bk == 0){//代购
			data = {
	             	gid:     gid,//彩种编号
	             	pid:     pid,//期号
	             	play:    '1',//玩法 复式1   单式0
	             	codes:   codes,//投注内容
	             	muli:    muli,//方案倍数
	             	fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
	             	type:    '0 ',//方案类型0 代购   1合买
	             	name:    '自购',//方案宣传标题
	             	desc:    '自购',//方案宣传内容
	             	money:   countMoney,//方案金额
	             	tnum:    '1',//方案总份数
	             	bnum:    '1',//购买份数
	             	pnum:    '0',//保底份数
	             	oflag:   '0',//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
	             	wrate:   '0',//提成比例
	             	comeFrom:'',//用户来源
	             	source:  CP.Data.source,//方案来源 
//	             	comboid: '1',
	             	endTime: '',//方案截止时间
	             	upay:    '',//是否订单支付
	             	cupacketid: cupacketid,//红包id
	             	redpacket_money: rPay//使用红包金额
	             };
		}else if(bk == 1){//合买
			var oflag = decodeURIComponent(CP.Util.getParaHash("isPublic"));//方案查权限
			var xyText = decodeURIComponent(CP.Util.getParaHash("xyText"));//方案宣言
			var bd = decodeURIComponent(CP.Util.getParaHash("bd"));//保底金额
			var wrate = decodeURIComponent(CP.Util.getParaHash("wrate"));//提成
			
			var bnum = decodeURIComponent(CP.Util.getParaHash("rg"));//认购金额
			data = {
					gid:     gid,//彩种编号
	             	pid:     pid,//期号
	             	play:    '1',//玩法 复式1   单式0
	             	codes:   codes,//投注内容
	             	muli:    muli,//方案倍数
	             	fflag:   '0',//是否文件上传 0  非文件上传  1 文件上传
	             	type:    '1',//方案类型0 代购   1合买
	             	name:    '合买',//方案宣传标题
	             	desc:    xyText,//方案宣传内容
	             	money:   countMoney,//方案金额
	             	tnum:    countMoney,//方案总份数
	             	bnum:    bnum,//购买份数
	             	pnum:    bd,//保底份数
	             	oflag:   oflag,//方案查权限0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开
	             	wrate:   wrate,//提成比例
	             	comeFrom:'',//用户来源
	             	source:  CP.Data.source,//方案来源
//	             	comboid: '1',
	             	endTime: '',//方案截止时间
	             	upay:    '',//是否订单支付
	             	cupacketid: cupacketid,//红包id
	             	redpacket_money: rPay//使用红包金额
		         };
		}
		 $.ajax({
        	 url: $_trade.url.jcast,
             type:'POST',
             data: data,
             success:function(xml){
            	var R = $(xml).find("Resp");
    			var code = R.attr("code");
    			var desc = R.attr("desc");
    			var r = R.find('result');
    			if (code == "0") {
					localStorage.removeItem(code_gid+'_PollNum');
					localStorage.removeItem(code_gid+'_SelectNum');
    				var projid = r.attr('projid');
    				window.location.replace('#class=url&xo=success/great.html&lotid='+gid+'&projid='+projid);
    			} else {
    				D.alert(desc);
    			}
            }
		 });
	};
	use_red = function(m,r){
		if($('#packet div.zfRed').html() == ''){
			$.ajax({
				url:'/user/queryRpinfo.go',
				type:'post',
				dataType:'xml',
				data:{
					trade_gameid:gid,
					trade_imoney:parseInt($('#mPay').html()),
					trade_isource:'0'
				},
				success:function(xml){
					var R = $(xml).find('rows');
					var r = R.find('row');
					var html = '';
					r.each(function(i){
						var cptid = $(this).attr('cptid');//红包编号
//						var itid = $(this).attr('itid');//4  无限制
						var crpname = $(this).attr('crpname');//红包名
						var irmoney = $(this).attr('irmoney');//红包余额
						var cddate = $(this).attr('cddate');//红包过期时间
						var kymoney = $(this).attr('kymoney');//可用红包
						if(kymoney == ''){
							kymoney ='0';
						}
						html += '<div class="clearfix pdLeft08">';
						html += '<em kymoney="'+kymoney+'" cptid="'+cptid+'" id="checkbtn" class="left '+(i==0? 'check' : 'nocheck' )+'"></em>';
						html += '<div class="left w15"><p>【'+crpname+'】余额'+irmoney+'元，本次可用<cite class="yellow">'+kymoney+'</cite>元</p><p class="pdTop03">过期时间：'+(cddate == '' ? '无限制':cddate)+'</p></div></div>';
					});
					$('#packet div.zfRed').html(html);
					$('#packet div.zfRed div.clearfix').click(function(){
						if($(this).find('em').attr('class').indexOf('nocheck') != '-1'){
							$('#packet div.zfRed div.clearfix em').attr('class','left nocheck');
							$(this).find('em').attr('class','left check');
						}else{
							$(this).find('em').attr('class','left nocheck');
						}
					});
				}
			});
		}
		$('#packet').show();
		$('#zhezhao').show();
		$('#packet').css({left:parseInt(document.documentElement.clientWidth/2-$("#packet").width()/2),top:parseInt(document.documentElement.clientHeight/2-$("#packet").height())});
	
		$('#packet div.zfTrue a:eq(0)').click(function(){//取消
			$('#packet').hide();
			$('#zhezhao').hide();
		});
		$('#packet div.zfTrue a:eq(1)').click(function(){//确定
			var rb = $(".zfRed em.check").attr('kymoney');
			var cptid = $(".zfRed em.check").attr('cptid');
			
			if(rb == undefined){
				rb = '0';
				cptid = '';
			}else{
				rb = parseFloat(rb);
			}
			$('#cptid').val(cptid);//红包编号存在隐藏域里面
			$('#packet').hide();
			$('#zhezhao').hide();
			diao(m,r,rb);
		});
	};
	checkLocastion();
})();
