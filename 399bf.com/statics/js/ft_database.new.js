(function($) {

	var $rankBar = $('#table_siderank');

	slideRank($rankBar, true);

	// 右侧积分榜展开收起功能
	$('#toggle_btn').on('click', function() {

		var $this = $(this);



		if ($rankBar.hasClass('open')) {
			slideRank($rankBar);
			$this.html('收起更多<em class="icon-chevron-up"></em>');
			$rankBar.removeClass('open');
		} else {

			slideRank($rankBar, true);

			$this.html('展开全部<em class="icon-chevron-down"></em>');

		}


	});
})(jQuery);

function slideRank(target, falg) {


	//被卷去的对象
	var $targetTr = target.find('tr:gt(8)'),

		//被卷去的高度
		tr_h = $targetTr.length * $targetTr.height();

	if (falg) {
		target.animate({
			height: target.find('table').height() - tr_h + 'px'
		}).addClass('open');
	} else {
		target.animate({
			height: target.find('table').height() + 'px'
		});
	}

}