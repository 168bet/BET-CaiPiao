(function(){

	$('#checkbox_all').change(function(){

		euro.checkAll(this.checked);
	});


	$('#delChecked').click(function(){

		euro.delCheked();
	});

	$('#saveChecked').click(function(){

		euro.saveCheked();
	});

	//赔率类型过滤
	$('[data-action="type-filter"]').each(function () {
		var target = $(this).data('target'),
			table = $('#' + target);
		$(this).find('li[data-value]').on('click', function () {
			var type = $(this).data('value'),
				selector = type ? '[data-type="' + type + '"]' : '[data-type]';
			table.find('tbody td div').not(selector).hide();
			table.find('tbody td div' + selector).show();
		});
	});

	//表格变化
	$('#detail-table').on('complete', function () {
		var company = [];
		$(this).find('tbody tr:visible').each(function () {
			var id = Number($(this).data('company'));
			if ($.inArray(id, company) < 0) {
				company.push(id);
			}
		});
		$('[data-action="total"]').html(company.length);
	});

	//高级筛选清除按钮
	$('[data-action="clear"]').on('click', function () {
		var target = $(this).data('target'),
			table = $('#' + target);
		table.find('input').val('');
	});

	//筛选功能
	$('[data-action="filter"]').on('click', function () {
		var target = $(this).data('target'),
			table = $('#' + target),
			input = $('[data-filter]'),
			filter = {
				homewin: {},
				guestwin: {},
				homerate: {},
				guestrate: {},
				totalrate: {},
				homekelly: {},
				guestkelly: {}
			};
		input.each(function () {
			var type = $(this).data('filter');
			$(this).find('input').each(function () {
				if ($(this).val() != '') {
					var name = $(this).attr('name');
					filter[name][type] = Number($(this).val());
				}
			})
		});
		table.find('tbody tr').each(function () {
			var tr = $(this),
				tag = 0;
			for (key in filter) {
				var range = filter[key],
					value = Number(tr.data(key)),
					max = range.hasOwnProperty('max') ? range.max : 9999,
					min = range.hasOwnProperty('min') ? range.min : 0;
				if (value <= max && value >= min) {
					tag = 1;
				} else {
					tag = -1;
					break;
				}
			}
			if (tag > 0) {
				tr.show();
			} else {
				tr.hide();
			}
		});
	});

	//全选
	$('[data-action="check-all"]').on('click', function () {
		var target = $(this).data('target'),
			elem = $('[data-name="' + target + '"]');
		$(elem).each(function (index) {
			elem[index].checked = true;
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
			$('#detail-table').find('tbody tr').each(function () {
				var tr = $(this),
					val = Number(tr.data(target));
				if ($.inArray(val, value) < 0) {
					tr.hide();
				} else {
					tr.show();
				}
			});
		} else {
			$('#detail-table').find('tr:hidden').show();
		}
		$('#detail-table').trigger('complete');
	});

	//全不选
	$('[data-action="check-clear"]').on('click', function () {
		var target = $(this).data('target'),
			elem = $('[data-name="' + target + '"]');
		$(elem).each(function (index) {
			elem[index].checked = false;
		});
	});

	//下载excel表格
	$('[data-action="excel"]').on('click', function () {
		var company_id = [],
			time = [];
		$('#detail-table').find('tbody tr:visible').each(function () {
			company_id.push($(this).data('company'));
			time.push($(this).data('time'));
		});
		if (company_id.length > 0) {
			var url = APP_PATH + 'index.php?m=sportsdata&c=basketball&a=schedule_euro_excel&scheduleid=' + ID + '&companid=' + company_id + '&time=' + time;
			window.location.assign(url);
		}
	});

})(jQuery);



var euro = {

	table:$('#detail-table'),

	checkboxs:$('#detail-table').find('tr [type="checkbox"]:not(#checkbox_all)')
}

//全选

euro.checkAll = function(checked){

	this.checkboxs.each(function(){

		this.checked = checked ? true : false;

	})

}


//删除选中
euro.delCheked = function(){

	this.checkboxs.each(function(){

		if(this.checked){
			$(this).parents('tr').hide();
		}
	});

	$('#detail-table').trigger('complete');
}

//保留选中
euro.saveCheked = function(){

	this.checkboxs.each(function(){

		if(!this.checked){

			$(this).parents('tr').hide();
		}
	});

	$('#detail-table').trigger('complete');
}