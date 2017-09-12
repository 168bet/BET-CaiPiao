;(function($){



	//二维码登录
	$('#code_login').click(function(){

		var $codeDiv = $('#code');

		$codeDiv.show();

		$('#pc_login').click(function(){

			$codeDiv.hide();
		})
	})


	//getpwd tab 
	$('#tab').on('change','[type="radio"]',function(){

		$('#'+$(this).val()).addClass('active').siblings().removeClass('active');
	});



	// input-control:focus时边框变色
	$('.input-control').on('focus','input',function(){

		$(this).parents('.input-control').css({
			borderColor:'#ffa21d'
		});

		$(this).blur(function(){
			$(this).parents('.input-control').css({
				borderColor:'#cccccc'
			});
		})
	})



})(jQuery);


