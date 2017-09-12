(function() {


	var calendar = $('#date-plugn');

	$('#dateCut').click(function() {

		calendar.toggle();
	});

	calendar.datePlugn({

		// 设置limit为1，则限制今天以后的日历不可被选，默认为0
		limit: 0
	});

	//完整
	$('#reset').on('click', function () {

		$('#end-table').find('tr').show();
	});

	//全选
	$('[data-action="check-all"]').on('click', function () {
		var target = $(this).data('target'),
			elem = $('[data-name="' + target + '"]');
		$(elem).each(function (index) {
			elem[index].checked = true;
		});
	});

	//全不选
	$('[data-action="check-clear"]').on('click', function () {
		var target = $(this).data('target'),
			elem = $('[data-name="' + target + '"]');
		$(elem).each(function (index) {
			elem[index].checked = false;
		});
	});

	//模糊弹出层确定按钮
	$('[data-action="submit"]').on('click', function () {
		var target = $(this).data('target'),
			elem = $('[data-name="' + target + '"]:checked'),
			value = [];
		elem.each(function () {
			value.push(Number($(this).attr('value')));
		});
		if (value.length > 0) {
			$('#end-table').find('tbody tr').each(function () {
				var tr = $(this),
					val = Number(tr.data(target));
				if ($.inArray(val, value) < 0) {
					tr.hide();
				} else {
					tr.show();
				}
			});
		} else {
			$('#end-table').find('tr:hidden').show();
		}
	});

	//导航上的时间跳转
	$('#date-choose').find('li[data-url]').on('click', function () {
		window.location.assign($(this).data('url'));
	});

	$('#date-hidden').on('picked', function () {
		var date = $(this).attr('value');
		window.location.assign(APP_PATH + 'zqwanchang/?date=' + date);
	});

	//导航条上的联赛过滤
	$('[data-action="competition-filter"]').on('click', function () {
		var target = $(this).data('target'),
			id = $(this).data('id'),
			selector = '[data-' + target + '="' + id + '"]',
			table = $('#end-table');
		$(this).siblings('[data-action="competition-filter"]').removeClass('active');
		$(this).addClass('active');
		table.find('tbody tr').not(selector).hide();
		table.find('tbody tr' + selector).show();
	});

})(jQuery);