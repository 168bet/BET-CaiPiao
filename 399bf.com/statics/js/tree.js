/*

 *树形菜单
 */


(function($) {

	var option_ = {

		//获取菜单标题
		title: '[tree-title]',

		menu: '[tree-menu]',

		icon: 'i',

		type: 'name',

		toggleclass: ['icon-angle-down', 'icon-angle-right', 'icon-minus', 'icon-plus']

	};

	function tree(container, option) {

		this.container = container || {};

		this.option = $.extend(option_, option);

		this.init();
	}

	tree.prototype = {

		init: function() {

			this.title = this.container.find(this.option.title);

			this.hander(true);

			this.click();

		},

		hander: function(auto) {

			var self = this,

				icon, name;



			this.title.each(function() {

				var that = $(this),

					icon = that.find(self.option.icon),

					name = that.attr(self.option.type);

				//第一次加载初始定位active项
				if(auto && !! that.next(self.option.menu).find('.active').length){

					that.addClass('on');

					var parents = that.parents(self.option.menu);


					parents.each(function() {

						$(this).prev().addClass('on');

					});

					self.hander();

				}


				if (that.hasClass('on')) {

					that.next(self.option.menu).slideDown();

					self.toggleClass(name, icon,true);

				} else {

					that.next(self.menu).slideUp();

					self.toggleClass(name, icon,false);
				}



			});

		},
		toggleClass: function(name, icon,status) {

			var self = this,

				classs_arr = self.option.toggleclass;

			try {

				switch (name) {

					case 'one':
						status ? icon.addClass(classs_arr[0]).removeClass(classs_arr[1]):icon.addClass(classs_arr[1]).removeClass(classs_arr[0])
						break;

					case 'two':
						status ? icon.addClass(classs_arr[2]).removeClass(classs_arr[3]):icon.addClass(classs_arr[3]).removeClass(classs_arr[2])
						break;

					case 'three':
						status ? icon.addClass(classs_arr[0]).removeClass(classs_arr[1]):icon.addClass(classs_arr[1]).removeClass(classs_arr[0])
						break;
				}

			} catch (err) {

			}

		},

		click:function(){

			var self = this;

			this.title.on('click',function(){

				$(this).toggleClass('on');

				self.hander();

			})
		}
	}


	$.fn.treeCreate = function(options) {

		$(this).each(function() {

			new tree($(this), options);



		})
	}

})(jQuery)