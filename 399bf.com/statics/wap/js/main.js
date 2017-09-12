$(function() {
	'use strict';

	//通用跳转链接
	$('[data-action="link"]').on('click', function () {
		window.location.assign($(this).data('url'));
	});

	//赛季
	$(document).on('click', '.open-about-race', function () {
		$.popup('.popup-about-race');
		$('.popup-overlay.modal-overlay-visible').css('visibility', 'hidden')
	});

	$('.popup-close-race').click(function () {
		$.closeModal('.popup-about-race');
	});

	$('#race_ok').click(function () {
		$.closeModal('.popup-about-race');
	});

	$.init();
});

//图片加载失败，使用默认图
function imgLoadFail(imgs,url){

	if(imgs && url){
		for(var i = imgs.length-1; i >= 0; i--){
			var img = imgs[i];
			if (!img.complete || typeof imgs[i].naturalWidth == "undefined" || imgs[i].naturalWidth == 0) {
			    img.src = url
			}

		}
	}


}

// ios下禁止用户缩放
(function () {
	document.addEventListener('touchstart',function (event) {
		if(event.touches.length>1){
			event.preventDefault();
		}
	});
	var lastTouchEnd=0;
	document.addEventListener('touchend',function (event) {
		var now=(new Date()).getTime();
		if(now-lastTouchEnd<=1){
			event.preventDefault();
		}
		lastTouchEnd=now;
	},false)
})();

//默认图替换
var ft_match = $('img.competition-photo'),
	ft_team = $('img.team-photo'),
	ft_player = $('img.player-photo'),
	bt_match = $('img.bt-competition-photo'),
	bt_team = $('img.bt-team-photo'),
	bt_player = $('img.bt-player-photo');

/*足球部分*/
if (ft_match.length) {
	imgLoadFail(ft_match, IMG_PATH + 'default-match.png');
}

if (ft_team.length) {
	imgLoadFail(ft_team, IMG_PATH + 'default-team.png');
}

if (ft_player.length) {
	imgLoadFail(ft_player, IMG_PATH + 'default-player.png');
}

/*篮球部分*/
if (bt_match.length) {
	imgLoadFail(bt_match, IMG_PATH + 'bt_default_match.png');
}

if (bt_team.length) {
	imgLoadFail(bt_team, IMG_PATH + 'bt_default_team.png');
}

if (bt_player.length) {
	imgLoadFail(bt_player, IMG_PATH + 'bt_default_player.png');
}

//回到顶部
+function($){
	var content = $('.page-current .content');

	content.on('click', '#toTop', function(e){

		if(e.liveFired != 'undefined'){
			//e.liveFired.scrollTop = 0;
			setTime(e.liveFired);
		}
	},false);

	function setTime(content,scrollTop){

		scrollTop = content.scrollTop || 0;

		var speed = 20;
		// 设置滚动条递减的次数（20），然后获取每次应该减去的数值。
		speed = (scrollTop/speed);


		if(typeof scrollTop == 'number' && scrollTop > 0){

			var t = setInterval(function(){
				scrollTop = scrollTop - speed;

				content.scrollTop = scrollTop;

				if(content.scrollTop <= 0){
					clearInterval(t)
				}
			},13);

		}
	}
}(Zepto);