/*
* Author: weige
* Date : 2014-04-28
*/ 
var hid = decodeURIComponent(CP.Util.getParaHash("hid"));
var rmoney = decodeURIComponent(CP.Util.getParaHash("rm"));
(function(){
	var kaigan,diao,inital,bind,zfb_pay,zhifu;
	checkLocastion = function(h,r){
		if(hid != '' && rmoney != ''){
			kaigan(h,r);
		}else{
			history.go(-1);
		}
	};
	diao = function(m,r,hb){//m用户余额 r应付金额 hb使用红包金额
		$('#rPay').html(hb);//红包支付
		$('#mPay').html(r-hb);//账户支付
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
	kaigan = function(h,r){
		var gid = parseInt(h.substring(0,2),10);
		$('.downHover p').eq(0).html($_sys.getlotname(gid)+'-合买认购');
		$('.downHover p').eq(1).html('应付金额&nbsp;&nbsp;<cite class="yellow">'+r+'</cite>&nbsp;&nbsp;元');
		
		$.ajax({
	        url: $_user.url.base,
	        success:function (data){
	        	var R = $(data).find("Resp");
	        	var U = R.find("row");
	        	var rb = U.attr("ipacketmoney");
	        	if(rb>0){
	        		$('#redPacket').show();
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
		$('#pay').click(function(){
			var rPay = parseInt($('#rPay').html());
			zhifu(rPay);
		});
	};
	zhifu = function(rPay){
		var gid = hid.substring(0,2);
		var money = parseInt($('.downHover p:eq(1) cite').html());
		var data = {};
		
		if(rPay == 0){
			data = {
	             	gid:gid,
	             	hid:hid,
	             	bnum:money
	             };
		}else{
			data = {
		         	gid:gid,
		         	hid:hid,
		         	bnum:money,
		         	cupacketid: $('#cptid').val(),
		         	redpacket_money:rPay
		         };
		}
		 $.ajax({
        	 url: $_trade.url.pjoin,
             type:'POST',
             data: data,
             success:function(xml){
            	var R = $(xml).find("Resp");
    			var code = R.attr("code");
    			var desc = R.attr("desc"); 
    			if (code == "0") {
    				var r = R.find('result');
    				var gid = hid.substring(0,2);
    				window.location.replace('#class=url&xo=hm/great.html&lotid='+gid+'&projid='+hid);
    			} else {
    				D.alert(desc);
    			}
            }
		 }); 
	};
	use_red = function(m,r){
		var gid = hid.substring(0,2);
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
						var itid = $(this).attr('itid');//4  无限制
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
	checkLocastion(hid,parseInt(rmoney));
})();
