/**
 * Created by xiaoxinwu
 */
//赛事直播条
(function() {

    function MatchBar($container, options) {
        this.$container = $container;
        this.options = $.extend({

            ul:'[name="content"]',

            li:'.slide-item',

            prevBtn:'.prev',

            nextBtn:'.next',

            // 动画效果
            speed: 'slow',

            // 是否鼠标滚动切换
            isMouse: false,

            // 滚动的个数
            num:1

        }, options);

        this.init();

    }

    MatchBar.prototype = {
        init: function() {

            this.$ul = this.$container.find(this.options.ul);

            this.$li = this.$ul.find(this.options.li);

            this.prevBtn = this.$container.find(this.options.prevBtn);

            this.nextBtn = this.$container.find(this.options.nextBtn);

            this.parentW = this.$ul.parent().width();


            //设置盒子最大宽度            
            this.maxWidth = this.$li.length * this.$li.outerWidth();

            this.$ul.css({
                position: "absolute",
                left: "0px",
                width: this.maxWidth + "px"
            });

            this.behaver();
        },
        behaver: function() {

            var self = this;

            try {
                if (self.options.isMouse) {

                    this.$ul.mousewheel(function(event, delta, deltaX, deltaY) {
                        //取消浏览器默认行为
                        event.preventDefault();
                        //判断鼠标上滚还是下滚
                        delta > 0 ? self.toPrev() : self.toNext();
                    });
                }

            } catch (err) {
                console.log('mousewheel is not a function');
            }

            this.prevBtn.click(function() {
                self.toPrev();
            })
            this.nextBtn.click(function() {
                self.toNext();
            })
        },
        toNext: function() {

            var left = parseFloat(this.$ul.css('left')) - this.$li.outerWidth() * this.options.num;

            left = Math.abs(left) >= this.maxWidth - this.parentW ? -(this.maxWidth - this.parentW) : left;

            this.$ul.animate({
                left: left + 'px'
            }, {
                duration: this.options.speed,
                easing: 'linear'
            })
        },

        toPrev: function() {

            var left = parseFloat(this.$ul.css('left')) + this.$li.outerWidth() * this.options.num;


            // left = Math.abs(left) >= 0 ? 0 : left;
            left = left >= 0 ? 0 : left;


            this.$ul.animate({
                left: left + 'px'
            }, {
                duration: this.options.speed,
                easing: 'linear'
            })
        }

    }


    $.fn.slideBar = function(options) {

        this.each(function() {
            new MatchBar($(this), options);
        });
        return this;
    };
})(jQuery);