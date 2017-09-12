var SDJC={}



var age = {pn:1,tp:1};
SDJC.userList=(function(){
	var init=function(a){
		try{
			var lo = decodeURIComponent(location.search);
			var loc = lo.getParam("loc");
		}catch(e){}
		if(a == 1){
			$('#line_user').html('<div style="padding-top:50px;height:200px"><em class="rotate_load" style="margin:auto"></em></div>');
		}
		$.ajax({
			url: '/user/queryGodFollowList.go',
			data:{
				 newValue: loc, 
				 pn: age.pn,
				 ps: 10
			},
			type : "POST",
			dataType : "xml",
			success: function(xml){
				var R = $(xml).find('Resp');
				var code = R.attr('code');
				var des = R.attr('desc');
				if(code == 0){
					var fol = R.find('followlist');
					var fl = fol.find('followUser');
					var ba = R.find('baseInfo');
					age.tmoney = ba.attr('tmoney');//总金额
					age.followNum = ba.attr('followNum');//总人数
					age.finish = ba.attr('finish');//是否命中
					$('.sp1').html(age.followNum);
					$('.sp2').html(age.tmoney);
					age.tp = Number(ba.attr('tp'));
					age.pn = Number(ba.attr('pn'));
					var html = '';
					
					if(age.pn > 1){
						html = $('#line_user').html();
					}
					age.finish > 0 && $(".table_title span:eq(2)").html("奖金")
					if(fl.length > 0){
						fl.each(function(i){
							age.uid = $(this).attr('uid');
							age.buymoney = $(this).attr('buymoney');
							age.addtime = $(this).attr('addtime');
							age.imgUrl = $(this).attr('imgUrl');
							age.bonus = $(this).attr('bonus');
							html += '<li class=line_gray ftype='+age.uid+'>'
							if(age.imgUrl){
								html += '<div class=div1><img src='+age.imgUrl+'>'
							}else{
								html += '<div class=div1><img src=img/zwtp.png>'
							}
							html += '<span>'+age.uid+'</span></div>'
							html += '<div class=div2>'+age.buymoney+'元</div><div class='+(age.finish>0?"red":"div3")+'>'+(age.finish>0?(age.bonus+'元'):age.addtime)+'</div>'
							html += '</li>'
						})
						$('#line_user').html(html);
					}
					if($('#line_user').find('li').length > 0){
						$('.myMore') && ($('.myMore').remove());
						if(age.pn < age.tp){
							$('#line_user').after('<a class="myMore" style="border-bottom: none;">查看更多</a>');
						}
					}else{
						$('#line_user').html('<div class=empty_user></div>')
					}

					$(".myMore").bind('click' , function(){
					$('.myMore').html('加载中请稍等');
					age.pn ++;
					if(age.pn <= age.tp){
						SDJC.userList.init(0);
					}			 
					})
				}else{
					alert(des);
					$('#line_user').html('<div class=empty_user></div>')
				}
			},
			error : function() {
				alert('网络异常，请刷新重试');
				return false;
			}
		})
	}

	var render=function(){
	}
	
	return {
		init:init
	}
})()

$(function(){
	SDJC.userList.init(1);
})