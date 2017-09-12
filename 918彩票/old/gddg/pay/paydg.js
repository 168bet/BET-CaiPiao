/*
* Author: weige
* Date : 2014-07-08
*/ 


CP.Pay_dg = function(){
	var bk = decodeURIComponent(CP.Util.getParaHash("bk"));//0 自购  1 合买
	var gid = decodeURIComponent(CP.Util.getParaHash("gid"));
	var cMoney = decodeURIComponent(CP.Util.getParaHash("money"));//方案总金额
	var code_gid = {'72':'dg_spf','90':'dg_rqspf','91':'dg_bf','92':'dg_bqc','93':'dg_jq'}[gid];//单关
	var code_ = localStorage.getItem(code_gid+'_PollNum');
	
	var secondStep = function(bk,gid){
		if(bk == 0){// 自购
			$('#slideLoop p:eq(1) cite').html(cMoney);
			kaigan(cMoney);//应付金额
			$('#updownContent').hide();
		}else if(bk == 1){//合买
			var rg = decodeURIComponent(CP.Util.getParaHash("rg"));//认购金额
			var bd = decodeURIComponent(CP.Util.getParaHash("bd"));//认购金额
			
			var z = parseInt(rg)+parseInt(bd);
			$('#slideLoop p:eq(1) cite').html(z);
			$('#updownContent p:eq(0) cite').html('方案总额'+cMoney+'元,认购'+rg+'元,保底'+bd+'元');
			kaigan(z);//
		}
		thirdStep();
	};
	var thirdStep = function(){//拼投注code
		var codes = '';
		codes = code_.split('$');
		$('#newcodes').val(codes[2]);
		$('#items').val(codes[1]);//场次
		$('#codes').val(codes[0]);
	};
	var kaigan = function(r){//应付金额
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
	var use_red = function(m,r){
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
	var diao = function(m,r,hb){//m用户余额 r应付金额 hb使用红包金额
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
	var dobuy = function(rPay){
		var cupacketid = $('#cptid').val();
		var codes = $('#codes').val();
		var newcodes = $('#newcodes').val();
		var items = $('#items').val();
		gid = zeroStr(gid,2);
		var data ;
		if (bk == 0){//自购
        	data={
           			 lotid : gid,// 游戏编号
           			 expect : '',// 期次编号
       				 play : 1,// 玩法编号
       				 codes : codes,
       				 initems : 1,// 文件是否包含场次
       				 items : items,// 场次
       				 beishu : 1,// 投注倍数
       				 ishm : 0,// 方案类型
       				 title : '快乐购彩',// 方案标题
       				 content : '自购',// 方案描叙
       				 amoney : cMoney,// 方案金额
       				 allnum : 1,// 方案份数
  				     buynum : 1,// 购买份数
  				     baodinum : 0,// 保底份数
  				     isshow : 0,		// 公开标志    自购 中奖后公开方案 状态为 4 否则为 0
  				     tcbili : 0,// 提成比率
  				     comeFrom : '',// 方案来源
  				     source : CP.Data.source,// 投注来源
  				     extendtype : '11',//11单关配
      				 endTime : '', // 截止时间
       				 cupacketid : cupacketid,//红包ID
       				 redpacket_money : rPay,//红包金额
  				     newcodes : newcodes
                };	 
		}else{//合买
			var oflag = decodeURIComponent(CP.Util.getParaHash("isPublic"));//方案查权限
			var xyText = decodeURIComponent(CP.Util.getParaHash("xyText"));//方案宣言
			var bd = decodeURIComponent(CP.Util.getParaHash("bd"));//保底金额
			var wrate = decodeURIComponent(CP.Util.getParaHash("wrate"));//提成
			var bnum = decodeURIComponent(CP.Util.getParaHash("rg"));//认购金额
            data={
           			 lotid : gid,// 游戏编号
           			 expect : '',// 期次编号
       				 play : 1,// 玩法编号
 				     initems : 1,// 文件是否包含场次
 				     items : items,// 场次
 				     rand : '',
       				 codes : codes,
       				 beishu : 1,// 投注倍数
       				 ishm : 1,// 方案类型
       				 title : '合买',// 方案标题
       				 content : xyText,// 方案描叙
       				 amoney : cMoney,// 方案金额
       				 allnum : cMoney,// 方案份数
       				 buynum : bnum,// 购买份数
       				 baodinum : bd,// 保底份数
       				 isshow : oflag,// 公开标志
       				 tcbili : wrate,// 提成比率
       				 comeFrom : '',// 方案来源
       				 source : CP.Data.source,// 投注来源//6奖金优化，7dgp
       				 extendtype : '11',//11单关配
      				 endTime : '', // 截止时间
       				 cupacketid : cupacketid,//红包ID
       				 redpacket_money : rPay,//红包金额
       				 newcodes : newcodes
                };
         }
		 $.ajax({
        	 url: '/trade/jczq/project_dgp.go',
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
    				window.location.replace('#class=url&xo=success/great.html&lotid='+gid+'0&projid='+projid);
    			} else {
    				D.alert(desc);
    			}
            }
		 });
	};
	var bind = function(){
		$('#pay').click(function(){
			var rPay = parseInt($('#rPay').html());
			dobuy(rPay);//代购合买
		});
		
	};
	var init = function(){
		secondStep(bk,gid);
		bind();
		
	};
	init();
	return{};
}();
