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