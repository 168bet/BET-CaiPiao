angular.module('cpApp')
.directive('homeSlider', [function () {
	return {
		restrict: 'E',
		transclude: true,
		link: function (scope, element, tattr, ngModelCtrl) {
			   var swiper = new Swiper(element.children()[0], {
			        pagination: '.swiper-pagination',
			        slidesPerView: 1,
			        paginationClickable: true,
			        spaceBetween: 30,
			        autoplay: false,
			        speed: 300,
			        keyboardControl: true,
			        nextButton: '.swiper-button-next',
			        prevButton: '.swiper-button-prev',
			    });
		},
		templateUrl: templateBaseURI + '/directives/homeSlider.html'
	};
}])
.directive('submitDirty', [function () {
	return {
		restrict: 'A',
		scope: {
			submitDirty: '='
		},
		link: function (scope, element, attrs, ngModelCtrl) {
			var requiredFields = [];
			scope.$watch(function () {
				return scope.submitDirty.$error.required;
			}, function (required) {
				if (required) {
					requiredFields = required;
				}
			});
			
			element[0].addEventListener('click', function() {
				if (requiredFields) {
					angular.forEach(scope.submitDirty.$error.required, function (field) {
						field.$setViewValue(field.$viewValue);
					});
				}
			});
		},
	};
}])
.directive('laydate', ['$timeout', function ($timeout) {
	return {
		restrict: 'A',
		require: 'ngModel',
		scope: {
			ngModel:'=',
			maxDate: '@',
			minDate: '@',
			format: '@'
		},
		link: function (scope, element, attr, ngModel) {
			 // 渲染模板完成后执行
            $timeout(function(){
            	var _date = null;
                var _config = {
                	elem: element[0],
                	format: scope.format ? scope.format: "YYYY-MM-DD",
                	min: scope.minDate ? scope.minDate: '',
                	max: scope.maxDate ? scope.maxDate: '',
                    istime: true,
                	choose: function (dates) {
                		ngModel.$setViewValue(dates);
                	},
                	clear: function() {
                		ngModel.$setViewValue(null);
                	}
                };
            	_date = laydate(_config);
                // 模型值同步到视图上
                ngModel.$render = function() {
                    element.val(ngModel.$viewValue || '');
                };

                // 监听元素上的事件
                element.on('blur keyup change', function() {
                    scope.$apply(setVeiwValue);
                });

                setVeiwValue();

                // 更新模型上的视图值
                function setVeiwValue() {
                    var val = element.val();
                    ngModel.$setViewValue(val);
                }
            });
		}
	};
}])
.directive('appMarquee', ['$timeout', '$interval', function($timeout, $interval) {
	var animateCls = 'marquee-wap-animate';
	return {
		restrict: 'E',
		scope: {
			items: '=',
			speed: '@',
			direction: '@' // v: 垂直运动, h: 水平运动
		},
		link: function(scope, element, attrs, ctrl) {
			var contentEl = element[0].children[0];
			var definitionTimer, stepTimer;

			function startAnimate(animateElement, speed, direction, step){
				if (definitionTimer) {
					$interval.cancel(definitionTimer);
					definitionTimer = null;
				}
				function animateIt() {
					var height = animateElement.offsetHeight;
					var marginTop = animateElement.style['margin-top'].replace('px', '')*1;
					if (marginTop + height - step <= 0) {
						marginTop = 0;
						angular.element(animateElement).removeClass(animateCls);
						animateElement.style['margin-top'] = '0px';
					}
					else {
						angular.element(animateElement).addClass(animateCls);
						animateElement.style['margin-top'] = ( marginTop - step ) + 'px';
					}
				}

				if (direction == 'v') {
					definitionTimer = $interval(function () {
						animateIt();
					}, 2000);
				}
			}

			scope.$watch('items', function (newval) {
				if (!newval) return ;
				$timeout(function () {
					if (contentEl.children[0]) {
						var step = element[0].offsetHeight;
						startAnimate(contentEl, scope.speed, scope.direction, step);
					}
				}, 0);
			});

		},
		templateUrl: templateBaseURI + '/directives/marquee.html',
	};
}])
.directive('codeTable', ['$rootScope', '$timeout' , function ($rootScope, $timeout) {

	return {
		restrict: 'E',
		scope: {
			'codeRange': '=',
			'data': '='
		},
		link: function (scope, element, attrs, ctrl) {
			var qsRange = [];
			for (var index in scope.data) {
				var item = scope.data[index];
				if (qsRange.indexOf(item['y']) == -1 ) {
					qsRange.push(item['y']);
				}
			}
			scope.qsRange = qsRange;
			
			scope.getItemWithY = function (y) {
				var items = [];
				for (var index in scope.data) {
					if (scope.data[index]['y'] == y) items.push(scope.data[index]);
				}
				return items;
 			};
			
			scope.$watch('qsRange', function (newval) {
				$timeout(function() {
					scope.initCanvas();
				});
			});
			
			scope.initCanvas = function () {
				var table = element[0].getElementsByTagName('table')[0],
					thead = element[0].getElementsByTagName('thead')[0],
					tfoot = element[0].getElementsByTagName('tfoot')[0];
				var canvas = element[0].getElementsByTagName('canvas')[0];
				canvas.height = table.offsetHeight - thead.offsetHeight - tfoot.offsetHeight;
				canvas.width = tfoot.offsetWidth - tfoot.getElementsByTagName('tr')[0].children[0].offsetWidth;
				canvas.style.left = thead.getElementsByTagName('tr')[0].children[0].offsetWidth + 'px';
				canvas.style.top = thead.offsetHeight + 'px';
				
				var pointObj = {
					width: table.getElementsByTagName('tbody')[0].getElementsByTagName('tr')[0].children[1].offsetWidth,
					height: table.getElementsByTagName('tbody')[0].getElementsByTagName('tr')[0].children[1].offsetHeight
				};
				var points = [];
				
				var pureData = [];
				for (var index in scope.data) {
					if (isNaN(scope.data[index]['data'])) continue;
					pureData.push(scope.data[index]);
				}
				for (var index in pureData) {
					var item = pureData[index];
					index *= 1;
					if (index > 0) {
						var preitem = pureData[index - 1];
						if (item['x'] < preitem['x']) {
							points.push([( item['x']*1 + 1 ) *pointObj.width, (index + 0.2 ) *pointObj.height  ]);
						}
						else {
							points.push([item['x']*pointObj.width, (index + 0.2 ) *pointObj.height  ]);
						}
					}
					if (index < pureData.length - 1) {
						var nextItem = pureData[index + 1];
						if (item['x'] > nextItem['x']) {
							points.push([item['x'] * pointObj.width, (index + 0.8)*pointObj.height ]);
						}
						else {
							points.push([( item['x'] + 1 ) * pointObj.width, (index + 0.8)*pointObj.height ]);
						}
					}
				}
				
				var ctx = canvas.getContext('2d');
				for (var i = 0; i < points.length; i += 2) {
					var p1 = points[i];
					var p2 = points[i + 1];
					ctx.beginPath();
					ctx.moveTo(p1[0], p1[1]);
					ctx.lineTo(p2[0], p2[1]);
					ctx.strokeStyle = '#ff2e2e';
					ctx.stroke();
				}
			};
		},
		templateUrl: templateBaseURI + '/directives/codeTable.html',
	};
}])
.directive('chartNum', ['$rootScope', function ($rootScope) {
	
	return {
		restrict: 'A',
		link: function (scope, element, attrs, ctrl) {
			
			var text = element.html();
			
		},
	};
}])
.directive('ball', ['$rootScope', function ($rootScope) {
	var colors_default = {
			red: [1,2,7,8,12, 13, 18, 19, 23, 24, 29, 30, 34, 35, 40, 45, 46, '红波'],
			blue: [3, 4, ,9, 10, 14, 15, 20, 25, 26, 31, 36, 37, 41, 42, 47, 48, '蓝波'],
			green: [5, 6, 11, 16, 17, 21, 22, 27, 28, 32, 33, 38, 39, 43, 44, 49, '绿波'],
	};
	var colors_pcegg = {
			gray: [0, 13, 14, 27],
			green: [1, 4, 7, 10, 16, 19, 22, 25],
			blue: [2, 8, 5, 11, 17, 20, 23, 26],
			red: [3, 6, 9, 12, 15, 18, 21, 24],
			dgray: ['大', '小'],
			purple: ['边', '中'],
			dblue: ['双', '单'],
	};
	var colors_kk = {
			'kk-color1': [1],
			'kk-color2': [2],
			'kk-color3': [3],
			'kk-color4': [4],
			'kk-color5': [5],
			'kk-color6': [6],
			'kk-color7': [7],
			'kk-color8': [8],
			'kk-color9': [9],
			'kk-color10': [10],
	};
	var colors_pcegg_history = {
			'pc-gray': [0, 13, 14, 27],
			'pc-green': [1, 4, 7, 10, 16, 19, 22, 25],
			'pc-blue': [2, 8, 5, 11, 17, 20, 23, 26],
			'pc-red': [3, 6, 9, 12, 15, 18, 21, 24],
	};
	
	function linkFunc (scope, element, attr, controller) {
		var number = parseInt(scope.number);
		var type = scope.type;
		var colors = colors_default;
		if (type == 'pcegg') {
			colors = colors_pcegg;
		}
		else if (type == 'pcegg_history') {
			colors = colors_pcegg_history;
		}
		else if (type == 'kk') {
			colors = colors_kk;
		}
		for (var color in colors) {
			if (isNaN(number)) {
				if (colors[color].indexOf(scope.number) != -1) {
					scope.color = 'rec-'+color;
					break;
				}
				scope.color = 'rec';
			}
			else {
				if (colors[color].indexOf(number) != -1) {
					scope.color = color;
					break;
				}
			}
		}
	}
	
	return {
		restrict: 'E',
		transclude: true,
		scope: {
			number: '=number',
			type: '@type'
		},
		compile: function (element, attributes) {
			return function (scope, telem, tattr, ngModelCtrl) {
				scope.$watch('number',function (newval) {
					linkFunc( scope, telem, tattr, ngModelCtrl);
				});
				linkFunc( scope, telem, tattr, ngModelCtrl);
			};
		},
		template: function (element, attrs) {
			return '<span ng-class="[\'ball\', \'ball-\'+color]">{{number < 10 ? number: number}}</span>';
		}
	};
}])
.directive('fullPager', ['$rootScope', function($rootScope) {
	return {
		restrict: 'E',
		scope: {
			'pageConf': '=' // {totalPage, pageSize, totalCount, pageChange: function (page, pageSize)} }
		},
		link: function (scope, element, attrs, ctrl) {
			// input 输入的分页页码
			scope.pageNo = 1;
			// 当前分页页码
			scope.crtPage = 1;
			scope.pageNums = [];
			scope.fun = {
				prev: function() {
					var page = scope.crtPage*1 - 1 < 1 ? 1: scope.crtPage*1 - 1;
					scope.crtPage = page;
					crtPageNums();
					scope.pageConf.pageChange(scope.crtPage, scope.pageConf.pageSize);
				},
				next: function() {
					var page = scope.crtPage*1 + 1 > scope.pageConf.totalPage ? scope.pageConf.totalPage: scope.crtPage*1 + 1;
					scope.crtPage = page;
					crtPageNums();
					scope.pageConf.pageChange(scope.crtPage, scope.pageConf.pageSize);
				},
				goPage: function(page) {
					scope.crtPage = page*1;
					scope.pageNo = scope.crtPage;
					crtPageNums();
					scope.pageConf.pageChange(scope.crtPage, scope.pageConf.pageSize);
				}
			};
			
			scope.$watch('pageConf', function () {
				scope.crtPage = 1;
				crtPageNums();
				scope.pageConf.pageChange = scope.pageConf.pageChange || function () {};
				scope.pageConf.totalPage *= 1;
			}, true);
			
			function crtPageNums() {
				scope.pageNums = [];
				if (scope.crtPage <= 1) {
					for (var i = 1; i < 4; i ++) {
						if (i <= scope.pageConf.totalPage) {
							scope.pageNums.push(i);
						}
					}
				}
				else if (scope.crtPage + 1 >= scope.pageConf.totalPage) {
					for (var i = scope.pageConf.totalPage - 2; i <= scope.pageConf.totalPage; i++) {
						if (i > 0) {
							scope.pageNums.push(i);
						}
					}
				}
				else {
					for (var i = scope.crtPage - 1; i < scope.crtPage + 2; i++) {
						if (i > 0 && i <= scope.pageConf.totalPage) {
							scope.pageNums.push(i);
						}
					}
				}
			}
			
		},
		templateUrl: templateBaseURI + '/directives/fullPager.html',
	};
}])
.directive('scrollHereClass', ['$timeout', '$window','$rootScope', function($timeout, $window, $rootScope) {
	
	function removeClassNames(element, names) {
		angular.forEach(names, function(clsName){
			element.removeClass(clsName);
		});
	}
	
	function addClassNames(element, names){
		angular.forEach(names, function(clsName){
			element.addClass(clsName);
		});
	}
	
	function hasAddedClassNames(element, names) {
		var yes = false;
		angular.forEach(names, function (clsName) {
			yes = element.hasClass(clsName);
		});
		
		return yes;
	}
	
	return {
		restrict: 'A',
		scope: {},
		link: function (scope, element, attrs) {
			var clsNames = attrs['scrollHereClass'].split(" ");
			var lastOffsetTop;
			scope.$watch(function () {
				return element[0].offsetTop;
			}, function (newval) {
				lastOffsetTop = newval;
				bindScrollEvent();
			});
			
			function bindScrollEvent() {
				angular.element($window).bind('scroll', function () {
					var scrollTop = window.document.body.scrollTop;
					if (scrollTop >= lastOffsetTop) {
						addClassNames(element, clsNames);
					}
					else {
						removeClassNames(element, clsNames);
					}
				});
			}
			
			var originPaddingLeft = element[0].style.paddingLeft.replace('px', '')*1;
			var listenerPadding = $rootScope.$on('ngDialog.setPadding', function (e, padding) {
				removeClassNames(element, clsNames);
			});
			var listenerClose = $rootScope.$on('ngDialog.closed', function (e) {
				if (hasAddedClassNames(element, clsNames)) {
					addClassNames(element, clsNames);
				}
			});
		}
	};
}])
.directive('openNumber', [function () {
	
	return {
		restrict: 'E',
		scope: {
			game: '=',
			numbers: '=' // 用逗号隔开
		},
		link: function (scope, element, attrs, model) {
			scope.data = {};
			scope.$watch('numbers', function (newval) {
				if (newval){
					scope.data = {
						numbers: scope.numbers.split(","),
						game: scope.game
					};
					console.log(scope.data);
				}
			});
		},
		templateUrl: templateBaseURI + '/directives/openNumbers.html',
	};
}])
.directive('bankSelector', ['$interval', function () {
	
	return {
		restrict: 'E',
		require: 'ngModel',
		scope: {
			banks: '=',
		},
		link: function (scope, element, attrs, modelCtrl) {
			console.log(modelCtrl);
			scope.data = {
				selectedBankName: '- 请选择我的银行卡 -',
				showBankItems: false,
				selectedBank: '',
			};
			
			scope.fun = {
				showSubBanks: function () {
					scope.data.showBankItems = !scope.data.showBankItems;
				},
				setCrtBank: function (bank) {
					scope.data.selectedBank = bank['id'];
					console.log(scope.data.selectedBank);
					scope.fun.showSubBanks();
					scope.data.selectedBankName = '<i class="ico-bank '+bank['bankCode'].toUpperCase()+'" id="selectBank" style="display: inline-block; width: 131px; text-align: center;"></i>';
					
					modelCtrl.$setViewValue(scope.data.selectedBank);
				}
			};
		},
		templateUrl: templateBaseURI + '/directives/bankSelector.html',
		
	};
}])
.directive('scrollToTop', ['$interval', '$window', function($interval, $window) {
    return {
      restrict: 'AE',
      link: function(scope, iElement, iAttrs) {
        scope.position = -60;
        scope.bottom = 0;
        scope.showRocket = false;
        var scrollTarget = document.querySelector("#scrollTop");
        if(document.body.scrollTop<600){
          scope.showRocket = false;
        }else{
          scope.showRocket = true;
        }
        var scrollFun =  function() {
          if (scrollTarget.scrollTop+document.body.scrollTop < 600) {
            scope.showRocket = false;
            scope.$apply();
          } else {
            scope.showRocket = true;
            scope.$apply();
          }
        };
        $window.onscroll = scrollFun;
        scope.goTop = function() {
          $window.onscroll = null;
          var delay = 100;
          var interval = $interval(function() {
            scope.position -= 60;
            scope.bottom += 100;
            delay -= 10;
            if (delay <= 10) {
              delay = 10;
            }
            scrollTarget.offsetTop -= 60;
            $window.scrollTo(0, scrollTarget.offsetTop);
            if (scope.position <= -240) {
              scope.position = -240;
            }
            // console.log(scrollTarget.offsetTop);
            if (scrollTarget.offsetTop <= 0) {

              $interval.cancel(interval);
              scope.bottom = 0;
              scope.position = -60;
              scope.showRocket = false;
              $window.onscroll = scrollFun;
            }
          }, delay);
        };
      },
      templateUrl: templateBaseURI + '/directives/scrollToTop.html',
    };
  }]);

