(function() {

	//获取表格外层容器
	var container = $('#table-content');

	$('.table-cpi .table-line:last-child').hide();
	//公司选择
	$('[data-action="company"]').on('click', function () {
		var company_id = $(this).data('id');
		$('#companyid').attr('value', company_id);
		$('#search-form').submit();
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
			$('#start-table,#end-table,#ready-table').find('tbody tr').each(function () {
				var tr = $(this),
					val = Number(tr.data(target));
				if ($.inArray(val, value) < 0) {
					tr.hide();
				} else {
					tr.show();
				}
			});
		} else {
			$('#start-table,#end-table,#ready-table').find('tr:hidden').show();
		}
	});

	//全不选
	$('[data-action="check-clear"]').on('click', function () {
		var target = $(this).data('target'),
			elem = $('[data-name="' + target + '"]');
		$(elem).each(function (index) {
			elem[index].checked = false;
		});
	});

	//切换黄牌
	$('#yellow-btn').on('click', function () {
		var yellow_card = $('[data-style="yellowcard"]');
		if (this.checked) {
			yellow_card.show();
		} else {
			yellow_card.hide();
		}
	});

	$('#rank-btn').on('click', function () {
		var rank = $('.num');
		if (this.checked) {
			rank.show();
		} else {
			rank.hide();
		}
	});

	//选中checkbox切换效果
	container.find('td [role="button"]').on('click', function() {
		BF.checkboxToggle($(this), 'checked')
	});

	//指数切换
	$('#cpi-group input[type="checkbox"]').change(function() {

		var cpiname = $(this).get(0).id;
		var checked = $(this).get(0).checked;
		BF.checkCpi($('.table-item'), cpiname, checked);
	});

	//全选、反选
	container.find('.checkbox-all').on('click', function() {

		var checkboxs = BF.getCheckAll();
		//全选
		if (!$(this).hasClass('active')) {

			$(this).addClass('active');

			$(checkboxs).each(function() {
				$(this).addClass('active');
			});

			BF.check();
			//取消
		} else {
			$(this).removeClass('active');

			$(checkboxs).each(function() {
				$(this).removeClass('active');
			});

			BF.check();
		}

	});

	//保留 删除 显示

	$('#selectControl').find('.btn').on('click', function() {
		var str = $(this).attr("name");
		BF.select(str);
	});

	//比分移入 悬浮效果
	container.find('td.score').mouseenter(function(){
		//设置定时器，当鼠标移除时，清除所有定时器取消不必要的请求
		var obj = this,

			timer = setTimeout(function() {
				BF.mouseScore(obj);
			}, 300);
		$(obj).mouseleave(function() {
			clearTimeout(timer);
			$(obj).find('#scoreDialog').remove();
		})
	});

	//指数 悬浮效果
	$('tr[ajax-odds-tag]').find('td.table-cpi').mouseenter(function(){
		//设置定时器，当鼠标移除时，清除所有定时器取消不必要的请求
		var obj = this,

			timer = setTimeout(function() {
				BF.mouseCpi(obj);
			}, 300);
		$(obj).mouseleave(function() {
			clearTimeout(timer);
			$(obj).find('#cpiPop').remove();
		})
	});

	// 生成弹窗节点层
	function createAlert(data){
		//dom节点
		var $alertBox = $('#alertBox'),
			$alertItem = $('<div class="alert-item"></div>'),
			$closeBtn = $('<i class="icon-remove" name="close" role="button"></i>'),
			$table = $('<table class="table"></table>'),
			tBody = '';

		//表头
		var tHead = "<tr><th width='60'>赛事</th><th width='100'>状态</th><th width='128' class='home'>"+data.home_team+"</th><th width='60'>VS</th><th width='128' class='away'>"+data.away_team+"</th></tr>";

		tBody = "<tr><td class='match-name'>" + data.competition_name + "</td> <td>"+ data.status +"</td><td class='home'>"+ data.home_score +"</td><td><b class='red'>:</b></td><td class='away'>"+ data.away_score +"</td></tr>" ;

		// 生成表格
		$table.html(tHead + tBody);
		//生成表格项
		$alertItem.html($closeBtn);

		$alertItem.append($table);
		$alertBox.append($alertItem);
		$alertBox.show();

		//判断哪队发生进球或红牌
		$('.' + data.goal_team,$alertItem).addClass('on');

		// 单击关闭按钮， 则删除该父元素节点
		$('[name="close"]').on('click',function(){
			$(this).parent().remove();
			// 如果 弹窗盒子无子元素，则隐藏
			//if(! $alertBox.children().length){
			//    $alertBox.hide();
			//}
		});

		// 弹窗 10S后消失
		setTimeout(function(){
			$alertBox.fadeOut(500);
			$alertBox.empty();
		},10 * 1000);
	}

	//每隔3s请求ajax_odds接口刷新指数数据
	setInterval(function(){
		var game_ids = [],
			company_id = $('input[name="companyid"]').val(),
			start_table = $('#start-table'),
		//需要提交请求的tr，通过ajax-odds-tag、ajax-status-tag判断
			need_to_request_tr = start_table.find('tr[ajax-odds-tag][ajax-status-tag]');

		//本次请求的比赛编号
		need_to_request_tr.each(function(){
			game_ids.push($(this).data('gameId'));
		});

		if (game_ids.length > 0) {
			$.ajax({
				data: {
					gameids: game_ids,
					companyid: company_id
				},
				url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_odds',
				type: 'post',
				dataType: 'json',
				success: function(result){
					if (result.state) {
						var data = result.data;
						//一级索引是比赛编号
						for (game_id in data) {
							var target = start_table.find('tr[data-game-id="' + game_id + '"]');
							//二级索引为数据类别
							for (category in data[game_id]) {
								//各数据类别需要显示的数据
								switch (category) {
									case 'asia':
										//key_arr = ['up', 'down', 'handicap'];
										key_arr = ['handicap'];
										break;
									case 'euro':
										//key_arr = ['homewin', 'awaywin', 'draw'];
										key_arr = ['draw'];
										break;
									case 'ou':
										//key_arr = ['big', 'small', 'total'];
										key_arr = ['total'];
										break;
									default:
										break;
								}
								//遍历需要显示的数据key
								$(key_arr).each(function(){
									//获取对应比赛编号的tr
									var need_to_update = target.find('[data-key="' + this + '"]'),
										value = data[game_id][category][this],
									//如果是让球的话，数值类型的数据取give
										change = Number(this == 'handicap' ? data[game_id][category].give : value) - Number(need_to_update.data('first'));
									//页面上通过data-key记录数据的对应关系（如果是大小球的总计，数据取total_ou，ftotal_ou）
									need_to_update.text(this == 'total' ? data[game_id][category][this + '_ou'] : value).data('first', this == 'handicap' ? data[game_id][category].give : value);
									//指数变动
									if (change > 0) {
										need_to_update.removeClass('odds-down').addClass('odds-up');
									} else if (change < 0) {
										need_to_update.removeClass('odds-up').addClass('odds-down');
									}
									need_to_update = value = change = null;
								});

								key_arr = null;
							}

							target = null;
						}
						setTimeout(function(){
							start_table.find('td.table-cpi').find('[data-key].odds-down,[data-key].odds-up').removeClass('odds-down odds-up');
						}, 1500);

						data = null;
					}
				}
			});
		}
	}, 1000 * 3);

	//每隔60s刷新即将开始赛事
	setInterval(function() {
		var ready_to_start = $('#ready-table').find('tr[data-status-id="0"]'),
			start_table = $('#start-table'),
			current_time = new Date().getTime();
		$(ready_to_start).each(function() {
			var start_time = $(this).data('startTime') * 1000;
			if (start_time - current_time <= 60000) {
				$(this).attr('ajax-status-tag', true);
				start_table.append($(this).detach());
			}
		});
	}, 1000 * 60);

	//每隔10s请求ajax_live_game_data接口刷新比赛基本数据
	setInterval(function(){
		var game_ids = [],
			start_table = $('#start-table'),
		//需要提交请求的tr，通过ajax-status-tag判断
			need_to_request_tr = start_table.find('tr[ajax-status-tag]');

		//本次请求的比赛编号
		need_to_request_tr.each(function(){
			game_ids.push($(this).data('gameId'));
		});

		if(game_ids.length > 0){
			$.ajax({
				data: {
					gameids: game_ids
				},
				url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_live_game_data',
				type: 'post',
				dataType: 'json',
				success: function(result){
					if (result.state) {
						var data = result.data,
							audio_tag = $('#audio-btn').get(0).checked,
							alert_tag = $('#alert-btn').get(0).checked,
							audio = $('#audio').get(0),
							end_table = $('#end-table'),
							animate = $('<img src="' + IMG_PATH + 'score-goal.gif">');
						//需要更新的数据：比赛进行时间，主队得分，客队得分，半场比分，红黄牌，角球数
							key_arr = ['time', 'homescore', 'awayscore', 'half', 'homeredcard', 'awayredcard', 'homeyellowcard', 'awayyellowcard', 'homecorner', 'awaycorner'];

						//遍历需要更新数据的tr
						$(data).each(function(){
							var target = start_table.find('tr[data-game-id="' + this.gameid + '"]'),
								value = this;

							//更新比赛状态
							target.attr('data-status-id', value.status);
							if (value.state_tag == true) {
								target.find('.table-status').addClass('add');
							} else {
								target.find('.table-status').removeClass('add');
							}

							//走地
							if (target.data('runTag') == true) {
								if (value.run_tag == true) {
									target.find('.is_run').removeClass('zd1 zd2').addClass('zd2').attr('title', '正在走地');
								} else {
									target.find('.is_run').removeClass('zd1 zd2').addClass('zd1').attr('title', '有走地赛事');
								}
							}

							//页面上通过data-key记录数据的对应关系
							$(key_arr).each(function() {
								var need_to_update = target.find('[data-key="' + this + '"]');

								//如果发生进球，进球球队高亮
								if ((need_to_update.data('target')) && (value[this] != need_to_update.eq(0).text()) && Number(value[this]) > 0) {
									//球队高亮，比分红色，进球动画
									target.find('.' + need_to_update.data('target')).addClass('has-goal');
									target.find(need_to_update.data('animate')).html(animate);
									need_to_update.addClass('score-goal');

									//如果进球音勾选，则播放音频
									if(audio_tag){
										audio.play();
									}

									//进球弹窗提示
									if(alert_tag){
										var alert_data = {
											competition_name: target.find('[competition-name]').text(),
											home_score: value.homescore,
											away_score: value.awayscore,
											status: value.time,
											home_team: target.find('.home-link').text(),
											away_team: target.find('.away-link').text(),
											goal_team: need_to_update.data('role'),
											color: target.find('[competition-name]').parents('td').css('backgroundColor')
										};
										createAlert(alert_data);
									}

									//30s后清除高亮效果
									setTimeout(function() {
										target.find('.' + need_to_update.data('target')).removeClass('has-goal');
										need_to_update.removeClass('score-goal');
									}, 1000 * 30);

									//60s后清除进球动画
									setTimeout(function () {
										target.find(need_to_update.data('animate')).empty();
									}, 1000 * 30);

								}

								//红黄牌样式
								if (need_to_update.data('style')) {
									//红黄牌0不处理
									if (value[this] != undefined && value[this] != 0) {
										need_to_update.addClass(need_to_update.data('style'));
									} else {
										value[this] = '';
									}
								}

								//填充数据
								need_to_update.text(value[this]);

								//如果比赛完场，则把本场比赛从请求中移除，不再更新数据
								if (value.is_over == true) {
									target.removeAttr('ajax-status-tag');
									end_table.append(target.detach());
								}
							});
						});

						data = alert_tag = audio_tag = audio = key_arr = null;
					}
				}
			});
		}
	},1000 * 10);

	//每隔30s请求ajax_odds接口刷新未开赛的指数数据
	setInterval(function() {
		var game_ids = [],
			company_id = $('input[name="companyid"]').val(),
			ready_table = $('#ready-table'),
		//需要提交请求的tr，通过ajax-odds-tag、data-status-id判断
			need_to_request_tr = ready_table.find('tr[data-status-id="0"][ajax-odds-tag]');

		//本次请求的比赛编号
		need_to_request_tr.each(function(){
			game_ids.push($(this).data('gameId'));
		});

		if (game_ids.length > 0) {
			$.ajax({
				data: {
					gameids: game_ids,
					companyid: company_id,
					first: true
				},
				url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_odds',
				type: 'post',
				dataType: 'json',
				success: function(result){
					if (result.state) {
						var data = result.data;
						//一级索引是比赛编号
						for (game_id in data) {
							var target = ready_table.find('tr[data-game-id="' + game_id + '"]');
							//二级索引为数据类别
							for (category in data[game_id]) {
								//各数据类别需要显示的数据
								switch (category) {
									case 'asia':
										//key_arr = ['up', 'down', 'handicap'];
										key_arr = ['handicap'];
										break;
									case 'euro':
										//key_arr = ['homewin', 'awaywin', 'draw'];
										key_arr = ['draw'];
										break;
									case 'ou':
										//key_arr = ['big', 'small', 'total'];
										key_arr = ['total'];
										break;
									default:
										break;
								}
								//遍历需要显示的数据key
								$(key_arr).each(function(){
									//获取对应比赛编号的tr
									var need_to_update = target.find('[data-key="' + this + '"]'),
										value = data[game_id][category][this],
									//如果是让球的话，数值类型的数据取give
										change = Number(this == 'handicap' ? data[game_id][category].give : value) - Number(need_to_update.data('first'));
									//页面上通过data-key记录数据的对应关系（如果是大小球的总计，数据取total_ou，ftotal_ou）
									need_to_update.text(this == 'total' ? data[game_id][category][this + '_ou'] : value).data('first', this == 'handicap' ? data[game_id][category].give : value);
									//指数变动
									if (change > 0) {
										need_to_update.removeClass('odds-down').addClass('odds-up');
									} else if (change < 0) {
										need_to_update.removeClass('odds-up').addClass('odds-down');
									}
									need_to_update = value = change = null;
								});
							}
						}
						setTimeout(function(){
							ready_table.find('td.table-cpi').find('[data-key].odds-up,[data-key].odds-down').removeClass('odds-down odds-up');
						}, 1500)
					}
				}
			});
		}
	}, 1000 * 30);

})(jQuery);



/**
 *	足球比分js
 */

var BF = {
	tr: $('.table-item tbody tr')
};

//刷新checkbox状态
BF.check = function() {
		//检查checkbox
		var checkboxs = BF.getCheckAll();

		$(checkboxs).each(function() {
			var $this = $(this);

			if ($this.hasClass('active')) {
				$this.addClass('checked');
				$this.parents('tr').addClass('on');
			} else {
				$this.removeClass('checked');
				$this.parents('tr').removeClass('on');
			}
		})

	}
	//获取table的所有checkbox
BF.getCheckAll = function() {
	var arr = [];
	BF.tr.each(function() {
		var checkbox = $(this).find('[role = "button"]').get(0);
		if (!!checkbox) {
			arr.push(checkbox);

		}
	});

	return arr;
};

//保留 删除 显示func
BF.select = function(enter) {

	var checkboxs = BF.getCheckAll();

	var trs = $(checkboxs).parents('tr');

	var checkeds = trs.filter('.on');


	switch (enter) {
		case 'save':
			BF.tr.each(function() {
				var $this = $(this);
				//根据选中状态进行显示隐藏
				$this.hasClass('on') ? $this.show() : $this.hide();
			});

			break;
		case 'del':
			BF.tr.each(function() {
				var $this = $(this);

				$this.hasClass('on') ? $this.hide() : $this.show();
			});

			break;
		case 'restore':
			BF.tr.show();
			break;
	}
};

//选中checkbox切换效果
BF.checkboxToggle = function(target, className) {

	if (!!target) {

		target.toggleClass(className);

		if (target.hasClass(className)) {
			target.parents('tr').addClass('on');
		} else {
			target.parents('tr').removeClass('on');
		}


	}
	// console.log(target.data('status'))
};

//指数切换
BF.checkCpi = function(parents, cpiname, checked) {
	var cpis = parents.find('td.table-cpi .table-line[data-name="' + cpiname + '"]');

	cpis.each(function() {
		if (checked) {
			$(this).show();
		} else {
			$(this).hide();
		}
	});

};

//比分悬浮层
BF.mouseScore = function(target) {

	//生成悬浮层
	BF.createScoreAlert(target);
};

BF.mouseCpi = function(target) {

		//生成悬浮层
		BF.createCpiAlert(target);
	};
	//积分层
BF.createScoreAlert = function(container) {
	var target_tr = $(container).parents('tr'),
		game_id = target_tr.data('gameId'),
		company_id = $('[name="companyid"]').val();

	//请求数据
	$.ajax({
		data: {
			gameid: game_id,
			companyid: company_id
		},
		url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_event_stats',
		type: 'post',
		dataType: 'json',
		success: function(result) {
			if (result.state) {

				var fhandicap = result.fhandicap;

				var titleText = '初盘参考:' + fhandicap;

				var data = result.data;

				var box = $('<div id="scoreDialog"></div>'),
					table = $('<table width="100%" class="alertTable"></table>'),
					title = $("<tr>" + "<th colspan='5'>" + titleText + "</th>" + "</tr>");

				table.append(title);

				for (var i in data) {
					//主队
					var tr = $("<tr></tr>");

					if (data[i].Type == "1") {

						console.log(1);
						tr.html("<td width='10%'><span class='blockBG " + data[i].Class + "'></span></td>" +
							"<td width='35%'>" + data[i].Pname + "</td>" +
							"<td class='minute' width='10%'>" + data[i].Minute + "<span class='status_'></span>' " + "</td>" +
							"<td width='35%'>&nbsp;</td>" +
							"<td width='10%'>&nbsp;</td>");
						//客队
					} else {

						console.log(2);
						tr.html("<td width='10%'>&nbsp;</td>" +
							"<td width='35%'>&nbsp;</td>" +
							"<td class='minute' width='10%'>" + data[i].Minute + "<span class='status_'></span>' " + "</td>" +
							"<td width='35%'>" + data[i].Pname + "</td>" +
							"<td width='10%'><span class='blockBG " + data[i].Class + "'></span></td>");
					}

					table.append(tr);

				}

				box.append(table);

				$(container).append(box);
			}
		}
	});
};


// 指数层
BF.createCpiAlert = function(container) {
	var target_tr = $(container).parents('tr'),
		game_id = [target_tr.data('gameId')],
		company_id = $('[name="companyid"]').val();
	//请求数据
	$.ajax({
		data: {
			gameids: game_id,
			companyid: company_id
		},
		url: APP_PATH + 'index.php?m=sportsdata&c=football&a=ajax_odds',
		type: 'post',
		dataType: 'json',
		success: function(result) {
			if (result.state) {

				var data = result.data;
				var box = $('<div id="cpiPop"></div>'),
					title = $('<div class="cpi-title"></div>'),
					table = "<table id='cpiTable' Class='alertTable' width='100%'>",
					str = "<td class='meta'>即时指数</td>",
					str_ = "<td class='meta'>初盘指数</td>";

				table = table + "<tr>" +
					"<td width='75'></td>" +
					"<td width='165px' colspan='3'><span>亚</span>走势</td>" +
					"<td width='165px' class='middle' colspan='3'><span>欧</span>走势</td>" +
					"<td width='165px' colspan='3'><span>大</span>走势</td>" +
					"</tr>";

				//一级索引是比赛编号
				for (game_id in data) {
					//二级索引为数据类别
					for (category in data[game_id]) {
						//各数据类别需要显示的数据
						switch (category) {
							case 'asia':
								key_arr = ['up', 'handicap', 'down'];
								break;
							case 'euro':
								key_arr = ['homewin', 'draw', 'awaywin'];
								break;
							case 'ou':
								key_arr = ['big', 'total_ou', 'small'];
								break;
							default:
								break;
						}
						//遍历需要显示的数据key
						$(key_arr).each(function() {
							//获取对应比赛编号的tr
							var target = $('tr[data-game-id="' + game_id + '"]'),
								value = data[game_id][category][this],
								first = data[game_id][category]['f' + this],
								change = data[game_id][category][this + '_change'],
								first_td = '<td>' + first + '</td>';
							//指数变动
							if (change > 0) {
								now_td = '<td class="odds-up">' + value + '</td>';
							} else if (change < 0) {
								now_td = '<td class="odds-down">' + value + '</td>';
							} else {
								now_td = '<td>' + value + '</td>';
							}

							str += now_td;
							str_ += first_td;
						});
					}
				}

				table = table + "<tr>" + str_ + "</tr>";
				table = table + "<tr>" + str + "</tr>";

				table = table + "</table>";
				title.html(target_tr.find('.home-link').text() + "<span class='pdL5 pdR5'>VS</span>" + target_tr.find('.away-link').text());

				box.empty();
				box.append(title);
				box.append(table);

				$(container).append(box);

				console.log(box)
			}
		}
	});
};