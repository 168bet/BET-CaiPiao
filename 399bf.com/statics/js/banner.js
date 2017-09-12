/**
 *   banner
 */


(function() {

    function banner($container, options) {

        this.$container = $container;

        this.options = $.extend({

            //是否自动播放
            isAuto: true,

            //间隔播放速度
            speed: 3000,

            //动画效果
            effect: "fade", //  fade,left,top

            //默认图片索引
            startIndex: 0,

            //大图盒子  类名
            bd: ".banner-bd",

            //小图盒子  类名
            fd: ".banner-fd",

            //图片项   类名
            item: ".xBanner-item",

            //大图标题  文本为data-name属性
            title: "title",

            //大图二级标题 文本为data-name属性
            titleInfo: "titleInfo",

            //当前图片
            // index : '.banner-index',

            //图片总计
            // count: '.count'

            prev: '.prev',

            next: '.next'



        }, options)

        this.init();
    }

    banner.prototype = {
        init: function() {

            // 定义在图盒子
            this.$bd = this.$container.find(this.options.bd);
            //定义小图盒子
            this.$fd = this.$container.find(this.options.fd);

            this.$item = this.$container.find(this.options.item);

            this.size = this.$item.size();

            //定义暂停状态
            this.paused = false;
            //判断是否自动播放
            this.options.isAuto && this.autoPlay(this.options.speed);

            /*
                初始化
            */

            this.handler(this.options.startIndex);
            this.mouse();
            this.click();
        },

        handler: function(index) {

            var $curItem = this.$item.eq(index),
                $curItemImg = $curItem.find('img'),
                imgUrl = $curItemImg.data('link'),
                curIndex = index + 1;

            //聚焦
            $curItem.addClass('active').siblings().removeClass('active');


            //图片
            $img = this.$bd.find('img')
                .attr('src', $curItemImg.data('img') || $curItemImg.attr('src'))
                .parent().attr('href', imgUrl);

            //图片标题
            $title = this.$bd.find('[name="' + this.options.title + '"]')
                .text($curItemImg.data('title'))
                .attr('href', imgUrl);


            //二级标题
            $titleInfo = this.$bd.find('[name="' + this.options.titleInfo + '"]')
                .text($curItemImg.data('titleInfo'))
                .attr('href', imgUrl);

            //图片头数字
            // this.$bd.find(this.options.index).text(curIndex);

            // this.$bd.find(this.options.count).text(this.size);


        },
        mouse: function() {
            var self = this;
            this.$item.on('mouseenter', function() {
                //执行动作
                self.handler($(this).index());

            });
        },
        click: function() {
            var self = this;

            if (!!this.options.prev && !!this.options.next) {

                this.$bd.find(this.options.prev).click(function() {

                    var index = self.$fd.find('li.active').index();

                    index = index - 1 < 0 ? self.size - 1 : index - 1;

                    self.handler(index);
                })

                this.$bd.find(this.options.next).click(function() {

                    var index = self.$fd.find('li.active').index();

                    index = index + 1 == self.size ? 0 : index + 1;

                    self.handler(index);
                })
            }


        },
        autoPlay: function(speed) {
            // 更新暂停状态
            this.setPaused();
            // 获取下一项的索引
            var index = this.options.startIndex + 1,
                self = this;

            // 声明一个定时器
            var timer = function() {

                setTimeout(function() {
                    // 判断是否暂停，如果没有暂停则执行
                    if (!self.paused) {

                        self.handler(index);

                        index++;

                        index = index == self.size ? 0 : index;

                    }

                    timer();

                }, speed);

            }

            timer();
        },
        setPaused: function() {
            var self = this;
            //更新暂停状态
            this.$container.on('mouseenter mouseleave', function(e) {
                var eventType = e.type;
                if (eventType == "mouseleave") {
                    self.paused = false;
                } else {
                    self.paused = true;
                }
            })
        }

    }

    $.fn.Xbanner = function(options) {

        this.each(function() {
            new banner($(this), options);
        })

        return this;
    }



})(jQuery)