(function(){



    var FixedSidebar = function(container,option){

        this.$container = container;
        var container = $('.container') || $('.content');
        this.options = $.extend({

            top: 318,

            left: container.eq(0).offset().left + 1000 + 20


        }, option);

        this.init();
    };

    FixedSidebar.prototype = {

        init: function(){
            this.$container
                .css({
                    top: this.options.top + 'px',

                    left: this.options.left + 'px'
                })
                .fadeIn();

            this.scroll();

            this.close();

        },

        scroll: function(){

            var self = this,
                scrollTop;

            $(window).scroll(function(){

                scrollTop = $(window).scrollTop();

                if(scrollTop >= self.options.top){

                    self.$container
                        .css({
                            top: 50 + 'px'
                        })
                }else{
                    self.$container
                        .css({
                            top: self.options.top + 'px'
                        })
                }

            })
        },

        close: function(){
            var self = this;

            this.$container.on('click', '.btn-close', function(e){

                self.$container.fadeOut();
            })
        }

    };

    $.fn.createFixedSidebar = function(option){

        this.each(function(){

             new FixedSidebar($(this), option);
        });

        return this
    }

})(jQuery);

+function($) {

    $('#fixedSidebar').createFixedSidebar();

}(jQuery);

