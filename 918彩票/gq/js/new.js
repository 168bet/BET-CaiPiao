var XHC={};
XHC.load=(function(){
	
	var init = function(){
		bindEvent();
		
	};
	
	var bindEvent=function(){
		$('.pullIco').bind('click', function(){
			$('.pullDown').toggleClass('pullHover');
			$('.pullText').toggle();
		});
	};
	
	
	return {
		init:init
	};
})();

$(function(){
	XHC.load.init();
})
	var noGame  = '<div style="text-align: center; padding: 100px; background:#f2f2f2;">近7天暂无公告</div>';

if($(".link2 li").length < 1){
	$(".link2").html(noGame);
}