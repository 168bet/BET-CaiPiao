/*
* Author: weige
* Date : 2014-04-28
*/ 
(function(){
	var inital,payOk,operation;
	inital = function(){
		$('#card input:eq(0)').val('');
		$('#card input:eq(1)').val('');
		$('#cSize').val('');
		$('#cType').val('');
		 $("#card input:eq(0)").keyup(function(){//卡号
			 this.value=this.value.replace(/\D/g,''); //只能输数字
			 this.value =this.value.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");//四位数字一空格
			 $('#stepTwo p:eq(2) cite').html(this.value);
		 });
		 $('#card input:eq(1)').keyup(function(){//卡密
			 this.value=this.value.replace(/\D/g,''); //只能输数字
			 this.value =this.value.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");//四位数字一空格
			 
			 $('#stepTwo p:eq(3) cite').html(this.value);
		 }); 
		$('#cardType div').click(function(){//选择充值卡类型
			$('#cardSize div').find('i').attr('class','');
			$('#cSize').val('');
			if($(this).find('i').attr('class') == 'cur'){
				$(this).find('i').attr('class','');
				$('#cType').val('');
			}else{
				$('#stepTwo p:eq(0) cite').html($(this).attr('cName'));
				if($(this).attr('cardT') == 'CMJFK'){//移动
					$('#cardSize div').eq(0).show();
				}else{//联通
					$('#cardSize div').eq(0).hide();
				}
				$('#cType').val($(this).attr('cardT'));
				$('#cardType div').find('i').attr('class','');
				$(this).find('i').attr('class','cur');
			}
//			$(this).find('i').toggleClass('cur');
		});
		$('#cardSize div').click(function(){//选择充值卡金额
			if($(this).find('i').attr('class') == 'cur'){
				$(this).find('i').attr('class','');
				$('#cSize').val('');
			}else{
				$('#stepTwo p:eq(1) cite:eq(0)').html($(this).attr('cardS'));
				$('#stepTwo p:eq(1) cite:eq(1)').html($(this).find('cite').html());
				$('#cSize').val($(this).attr('cardS'));
				$('#cardSize div').find('i').attr('class','');
				$(this).find('i').attr('class','cur');
			}
		});
		$('#payOk').click(function(){
			payOk();
		});
		$('#operation a:eq(0)').click(function(){
			$('#stepOne').show();
			$('#stepTwo').hide();
		});
		$('#operation a:eq(1)').click(function(){
			operation();
		});
//		$('#cardType div').touchstart(function(){//
//			$(this).find('cite').css('color','black');
//		});
//		$('#cardType div').touchend(function(){
//			$(this).find('cite').css('color','#A4A4A4');
//		});
//		$('#cardSize div').touchstart(function(){
//			$(this).find('cite').css('color','black');
//		});
//		$('#cardSize div').touchend(function(){
//			$(this).find('cite').css('color','#A4A4A4');
//		});
	};
	payOk = function(){
		var cardNum = $.trim($('#card input:eq(0)').val());
		var cardPW = $.trim($('#card input:eq(1)').val());
		if($('#cType').val() == ''){
			D.alert('请选择充值卡类型！');
			return false;
		}else if($('#cSize').val() == ''){
			D.alert('请选择充值金额！');
			return false;
		}else if(cardNum == ''){
			D.alert('请输入卡号！');
			return false;
		}else if(cardPW == ''){
			D.alert('请输入密码！');
			return false;
		}else{
			$('#stepOne').hide();
			$('#stepTwo').show();
		}
 	};
	operation = function(){
		var cardNum = $.trim($('#card input:eq(0)').val().replace(/\s+/g,""));
		var cardPW = $.trim($('#card input:eq(1)').val().replace(/\s+/g,""));
		var data = {
				bankid: '9009',
				addmoney: $('#cSize').val(),
				tkMoney: $('#cSize').val(),
				cardnum: cardNum,
				cardpass: cardPW,
				dealid: $('#cType').val(),
				rnd: Math.random()
		};
		
		
		$.ajax({
			url : '/user/addmoney.go',
			type : "POST",
			dataType : "xml",
			data : data,
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if (code == "0") {
					$('#success').show();
					$('#zhezhao').show();
					$('#success').css({left:parseInt(document.documentElement.clientWidth/2-$("#success").width()/2),top:parseInt(document.documentElement.clientHeight/2-$("#success").height())});
				} else {
					D.alert(desc);
				}
			},
			error : function() {
				D.alert('您所请求的页面有异常！');
				return false;
			}
		});	
	};
	inital();
	
	
	
	
})();