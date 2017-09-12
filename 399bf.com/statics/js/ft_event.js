(function($){

	var $match_list = $('#match_list');

	$match_list.on('click','.list-item',function(){

		var sib_listitem = $(this).siblings('.list-item');

		$(this).addClass('active');

		sib_listitem.removeClass('active');


		$('.inner-list',this).slideDown();

		$('.inner-list',sib_listitem).slideUp();
	});


	//切换不同区域赛事
	$('.zone-item').click(function(){
		var zoneid = $(this).data('zoneid');

		$('.zone-item').children('a').removeClass('active');
		$(this).children('a').addClass('active');

		$('.guojia-m').hide();
		$('.zone-' + zoneid).show();
	});



})(jQuery);

