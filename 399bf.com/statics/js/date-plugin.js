(function() {

	var option = {
		colW: 35,

		// 设置是否限制日历选项，
		//0:不限制		 1:限制往后日历		2:限制往前日历		['...']规定可选日期,格式为年月日，如：2016-06-15, 2016/6/15, 2016,6,15	
		limit: 0,

		callback:function(date){
			$('#date-hidden').val(date).trigger('picked');
		}
	};


	var D = new Date();

	var curr_year = D.getFullYear();

	var curr_month = D.getMonth() + 1;

	var curr_day = D.getDate();


	function datePlugn(container, options) {

		this.container = container;

		//合并参数
		this.options = $.extend(option, options);

		//日期节点
		this.$today = this.container.find('.date-info .num');

		//星期节点
		this.$week = this.container.find('.date-info .week');

		//年，月 节点
		this.$date = this.container.find('.date-info .date');

		//日历项节点容器
		this.$num_content = this.container.find('#dateNum');

		this.$prev = this.container.find('button.prev');

		this.$next = this.container.find('button.next');


		//初始化
		this.init();

	}

	//获取某年某月的天数
	Date.prototype._getMonth = function(year, month) {

		return new Date(year, month, 0).getDate();
	}

	// 获取某年某月某日的星期
	Date.prototype._getWeek = function(year, month, day) {

		return new Date(month + ' ' + day + ',' + year).getDay();
	}

	datePlugn.prototype = {

		init: function() {

			this.setHtml();

			this.calendarClick();

			this.prev();

			this.next();

		},

		setHtml: function() {

			//获取日期
			this.autoDate();

			// 设置文本
			this.$today.text(this.DAY);

			this.$week.text(this.WEEK);

			this.$date.text(this.YEAR + ' ' + this.MONTH + '月');

			//清空日历容器
			this.$num_content.empty();

			//获取当前年月1号的星期
			var one_day = D._getWeek(this.YEAR, this.MONTH, 1);


			var offset_num = one_day == 0 ? 7 : one_day;

			//获取上个月日历
			var prev_num = D._getMonth(this.YEAR, (this.MONTH - 1), 0);

			for (var i = prev_num - offset_num + 1; i <= prev_num; i++) {

				var li = $('<li class="other">' + i + '</li>');

				this.$num_content.append(li);
			}

			//获取当前月份天数
			var newDay = D._getMonth(this.YEAR, this.MONTH, 0);

			for (var i = 0; i < newDay; i++) {

				var li = $('<li class="item">' + (i + 1) + '</li>');

				this.$num_content.append(li);

			}

			//日历底行补完
			for (var i = 1; i <= 30; i++) {

				var li = $('<li class="other">' + i + '</li>');

				this.$num_content.append(li);
			}

			// 如果日历表显示的是当前月份

			if (this.YEAR == curr_year && this.MONTH == curr_month) {

				this.$num_content.find('.item').eq(curr_day - 1).addClass('today on');

			}

			this.limitHander();

		},
		
		//限制处理函数
		limitHander:function(){
						
			var limit = this.options.limit;
			
			//如果limit不为0
			if(!! limit){
												
				switch(limit){
				
					case 1:
						//设置所有大于当前日期的数字设置不可选中
						if (this.YEAR > curr_year || this.MONTH > curr_month) {

							this.$num_content.find('.item').addClass('disabled');
						}

						//设置当月日历 的可选状态 
						if (this.YEAR == curr_year && this.MONTH == curr_month) {
							this.$num_content.find('.item:gt("' + (curr_day - 1) + '")').addClass('disabled');

						}
					
					break;
					
					case 2:
					
					// console.log( this.YEAR, this.MONTH,curr_year, curr_month, curr_day);
					
						//设置所有小于当前日期的数字设置不可选中
						if (this.YEAR < curr_year || ( this.YEAR == curr_year && this.MONTH < curr_month )) {

							this.$num_content.find('.item').addClass('disabled');
						}

						//设置当月日历 的可选状态 
						if (this.YEAR == curr_year && this.MONTH == curr_month) {
							this.$num_content.find('.item:lt("' + (curr_day - 1) + '")').addClass('disabled');

						}
					
					break;
					
					default:
																							
						if(limit instanceof Array){
							
							//console.log( this.YEAR,  this.MONTH, this.DAY,curr_year, curr_month, curr_day);
							
							this.$num_content.find('.item').addClass('disabled');
							
							for(var i = 0,l = limit.length;i < l;i++){
								
								//console.log(limit[i]);
								
								var dateArr = limit[i].match(/\d+/g),
									year = ~ ~dateArr[0],
									month = ~ ~dateArr[1],
									day = ~ ~dateArr[2];
								
								//console.log(year,month,day);

								if(year.toString().length>4 || month.toString().length>2 || day.toString().length>2){
									
									throw '日期格式错误'
								}
								
								if(year == this.YEAR && month == this.MONTH && day!=0){
									
									//console.log(year,month,day);
									
									this.$num_content.find('.item:eq("' + (day - 1) + '")').removeClass('disabled');
									
								}
																																
								
							}
							
							
							
						}
						
					
				}
			}
			
			
			
		},

		autoDate: function() {
			

			//年
			this.YEAR = D.getFullYear();

			//月	
			this.MONTH = D.getMonth() + 1;

			//日
			this.DAY = D.getDate();

			//星期	
			this.WEEK = this.formatWeek(D._getWeek(this.YEAR, this.MONTH, this.DAY));
			

		},

		formatWeek: function(index) {

			//星期转换
			var week = new Array(7);

			week[1] = '星期一';
			week[2] = '星期二';
			week[3] = '星期三';
			week[4] = '星期四';
			week[5] = '星期五';
			week[6] = '星期六';
			week[0] = '星期日';

			return week[index]
		},

		calendarClick: function() {

			var self = this;

			this.$num_content.on('click', '.item:not(.disabled)', function() {

				var $this = $(this);

				$this.addClass('on').siblings('.item').removeClass('on');

				var num = $this.text();

				// 设置文本
				self.$today.text(num);

				var newWeek = new Date(self.MONTH + ' ' + num + ',' + self.YEAR);

				var offset_num = newWeek.getDay();


				self.$week.text(self.formatWeek(offset_num));

				var _month = self.MONTH.toString().length < 2 ? '0' + self.MONTH.toString() : self.MONTH.toString();
				var _date = num.length < 2 ? '0' + num : num;
				var str = self.YEAR + '-' + _month + '-' + _date;


				//self.container.find(self.options.inputClass).val(str);
				
				self.dateText = str;
				
				self.options.callback(str);

			});


		},

		//上一个月
		prev: function() {

			var self = this;

			this.$prev.click(function() {

				var year = self.YEAR,
					month = self.MONTH,
					day = 1;

				// 判断是否12月，如果是则年减1，月份设置为11，ps:setMonth()方法0为1月
				if (self.MONTH == 1) {

					year -= 1;

					month = 11;

				} else {

					month -= 2;

				}

				day = month + 1 == curr_month && year == curr_year ? curr_day : 1;

				D.setFullYear(year);

				D.setMonth(month);

				D.setDate(day);

				self.autoDate();

				self.setHtml();

			});
		},

		//下一个月
		next: function() {

			var self = this;

			this.$next.click(function() {

				var year = self.YEAR,
					month = self.MONTH,
					day = 1;

				if (month == 12) {

					year += 1;

					month = 0;
				}

				day = month + 1 == curr_month && year == curr_year ? curr_day : 1;

				D.setFullYear(year);

				D.setMonth(month);

				D.setDate(day);

				self.autoDate();

				self.setHtml();

			});
		}


	}


	$.fn.datePlugn = function(options) {

		$(this).each(function() {

			new datePlugn($(this), options);



		})
	}
})(jQuery)