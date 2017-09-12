/**
 * Created by Administrator on 2017/5/16.
 */
(function(win,factory){
    if (typeof define === 'function' && define.amd)
        define(['Zepto'], factory);
    else if (typeof exports === 'object')
        module.exports = factory;
    else
        win.waterfall = factory(Zepto);
})(this,function($){


    var waterfall = {};
    var that = waterfall;
    waterfall.init = function(opts){


        that.opts = $.extend({
            container:'', //zepto对象
            pin:'', // string
            col:2, //瀑布列数
            offset:10  //偏移，视情况调整
        },opts);




        that.container = that.opts.container || null;

        that.layout();


    };

    waterfall.layout = function(){
        var opts = that.opts;
        if(!that.container){
            return false
        }

        var pin = that.container.find(opts.pin);
        var wholeWidth = $( window ).width();
        var num = opts.col;
        var  w = Math.floor( wholeWidth / num );
        pin.width(w);
        that.container.css({
            'width:' : wholeWidth,
            'margin': '0 auto'
        });
        pin.find('img').css("width",w - opts.offset);

        var pinHArr=[];

        pin.each( function( index, value ){
            var pinH = pin.eq( index ).height();
            if( index < num ){
                pinHArr[ index ] = pinH;
            }else{
                var minH = Math.min.apply( null, pinHArr );
                var minHIndex = $.inArray( minH, pinHArr );
                $( value ).css({
                    'position': 'absolute',
                    'top': minH ,
                    'left': pin.eq( minHIndex ).position().left
                });
                pinHArr[ minHIndex ] += pin.eq( index ).height();
            }

        });
        var height = pin.last().outerHeight()+parseInt(pin.last().css("top"));
        that.container.height(height)
    };



    return waterfall;

});