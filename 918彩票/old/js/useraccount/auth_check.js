/*Author: weige 
Date: 2014-4-21*/
var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];    // 加权因子   
var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];            // 身份证验证位值.10代表X
var flag = location.search.geParam("flag");
$(function(){
	WW.initial();
	$("#tName").val('');
	$("#tCard").val('');
	$("#tCard2").val('');
	$("#tCode").val('');
	$("#tName").bind('keyup',function(){
		var str = $(this).val();
		var reg = /^[\u4E00-\u9FA5]+$/;
		var tt = str;
		tt = tt.replace(/·/g,'');
		if(str.indexOf('.')>=0){
			str=str.replace('.','·');
			$(this).val(str);
		}
		else if(!reg.test(tt) && tt !=''){
			$('#bind p').eq(1).show();
		}else{
			$('#bind p').eq(1).hide();
		}
	});
	$("#bind div input").bind('keyup',function(){
		if($(this).val().length>0){
			$(this).next().show();
		}else{
			$(this).next().hide();
		}
	});
	$('#bind div .error').click(function(){
		$(this).prev().val('');
		$(this).hide();
	});
});

var WW = {
	initial :function(){
		checkLogin(function(){
			$.ajax({
				url : $_user.url.safe,
				type : "POST",
				dataType : "xml",
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if (code == "0") {
						var r= R.find("row");
						var rname = r.attr("rname");
						var idcard = r.attr("idcard");
						if(rname == ""){
							$("#bind").show();
							$("#success").hide();
						}else {
							$("#bind").hide();
							$("#success").show();
							$("#success p").eq(0).html('<span class="gray">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>'+rname);
							$("#success p").eq(1).html('<span class="gray">身份证号</span>'+idcard);
						}
					}else{
						D.alert(desc);
					}
					
				}
			});
		});
 	}
};
function setdata(){
	
	var card1 = $.trim($("#tCard").val());
	
	if ($.trim($("#tName").val())==""){
		D.alert('请输入您的真实姓名');
		return false;
	}
	if (card1==""){
		D.alert('请输入您的身份证号码');
		return false;
	}
	if(!IdCardValidate(card1)){
		D.alert('请输入正确的身份证');
		return false;
	}
	if (card1 != $.trim($("#tCard2").val())){
		D.alert('两次输入的身份证号码不一致');
		return false;
	}
	if ($.trim($("#tCode").val())==""){
		D.alert('请输入您的登录密码以确认您的身份');
		return false;
	}
	$.ajax({
		url : $_user.modify.name,
		type : "POST",
		dataType : "xml",
		data : $_user.key.realName + "=" + encodeURIComponent($.trim($("#tName").val()))
		+ "&" + $_user.key.idCardNo + "=" + encodeURIComponent($.trim($("#tCard").val()))
		+ "&" + $_user.key.upwd + "=" + encodeURIComponent($.trim($("#tCode").val()))
		+ "&rnd=" + Math.random(),
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			
			if (code == "0") {
				if(flag && flag=="llp"){
					
				}
				D.alert('身份证绑定成功');
				window.location.reload();
			} else {
				D.alert(desc);
			}
		}
	});
}

function IdCardValidate(idCard) {
    idCard = trim2(idCard.replace(/ /g, ""));               //去掉字符串头尾空格                     
    if (idCard.length == 15) {   
        return isValidityBrithBy15IdCard(idCard);       //进行15位身份证的验证    
    } else if (idCard.length == 18) {   
        var a_idCard = idCard.split("");                // 得到身份证数组   
        if(isValidityBrithBy18IdCard(idCard)&&isTrueValidateCodeBy18IdCard(a_idCard)){   //进行18位身份证的基本验证和第18位的验证
            return true;   
        }else {   
            return false;   
        }   
    } else {   
        return false;   
    }   
};
function isValidityBrithBy15IdCard(idCard15){   
    var year =  idCard15.substring(6,8);   
    var month = idCard15.substring(8,10);   
    var day = idCard15.substring(10,12);   
    var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));   
    // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法   
    if(temp_date.getYear()!=parseFloat(year)   
            ||temp_date.getMonth()!=parseFloat(month)-1   
            ||temp_date.getDate()!=parseFloat(day)){   
              return false;   
      }else{
      	if(idCard15.indexOf('e')!=-1){
      		return false;
      	}else{
      		if(isNaN(idCard15)){
	        		return false;
	        	}else{
	        		return true;
	        	} 
      	}
      }   
};
function isTrueValidateCodeBy18IdCard(a_idCard) {   
    var sum = 0;                             // 声明加权求和变量   
    if (a_idCard[17].toLowerCase() == 'x') {   
        a_idCard[17] = 10;                    // 将最后位为x的验证码替换为10方便后续操作   
    }   
    for ( var i = 0; i < 17; i++) {   
        sum += Wi[i] * a_idCard[i];            // 加权求和   
    }   
    valCodePosition = sum % 11;                // 得到验证码所位置   
    if (a_idCard[17] == ValideCode[valCodePosition]) {   
        return true;   
    } else {   
        return false;   
    }   
} 
function isValidityBrithBy18IdCard(idCard18){   
    var year =  idCard18.substring(6,10);   
    var month = idCard18.substring(10,12);   
    var day = idCard18.substring(12,14);   
    var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));   
    // 这里用getFullYear()获取年份，避免千年虫问题   
    if(temp_date.getFullYear()!=parseFloat(year)   
          ||temp_date.getMonth()!=parseFloat(month)-1   
          ||temp_date.getDate()!=parseFloat(day)){   
            return false;   
    }else{   
        return true;   
    }   
};
//去掉字符串头尾空格
function trim2(str) {   
    return str.replace(/(^\s*)|(\s*$)/g, "");   
};
