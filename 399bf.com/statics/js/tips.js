var ErrorTips;
ErrorTips = {
    defaultOption: {
        //提示位置
        placement: 'top',
        //消失时间
        delay: 6000,
        //位置偏移，只需填写数字即可
        offset: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        },
        //颜色
        color: '#E33244',
        jsonKey: 'responseJSON',
        //作用域，防止多个id出现的情况
        area: null
    },
    option: {},
    init: function (errors, option) {
        this.option = this.defaultOption;
        if (option) {
            this.option = $.extend({}, this.option, option);
        }
        if (errors.hasOwnProperty(this.option.jsonKey)) {
            this.show(errors[this.option.jsonKey]);
        } else {
            this.show(errors);
        }
    },
    show: function (json) {
        for (var key in json) {
            this.createTip(key, json[key][0]);
        }
    },
    createTip: function (id, message) {
        //dom
        var target = this.option.area ? $(this.option.area).find('#' + id) : $('#' + id);
        var arrow = $('<div class="etips-arrow">');
        var content = $('<div class="etips-inner">').append(message);
        var tip = $('<div class="etips">').append(content).append(arrow);
        var option = this.option;
        target.parent().prepend(tip);

        //position
        var height = {
                min: Math.min(tip.find('.etips-arrow').outerHeight(true) + tip.outerHeight(true), target.outerHeight(true)),
                max: Math.max(tip.find('.etips-arrow').outerHeight(true) + tip.outerHeight(true), target.outerHeight(true))
            },
            width = {
                min: Math.min(tip.outerWidth(true), target.outerWidth(true)),
                max: Math.max(tip.outerWidth(true), target.outerWidth(true))
            },
            css = {
                "margin-top": option.offset.top,
                "margin-right": option.offset.right,
                "margin-bottom": option.offset.bottom,
                "margin-left": option.offset.left
            };
        switch (option.placement) {
            case 'top':
                css = $.extend({}, css, {
                    'margin-top': -(height.min + option.offset.top)
                });
                break;
            case 'bottom':
                css = $.extend({}, css, {
                    'margin-top': height.max + option.offset.top
                });
                break;
            case 'left':
                css = $.extend({}, css, {
                    'margin-left': -(width.min + option.offset.left)
                });
                break;
            case 'right':
                css = $.extend({}, css, {
                    'margin-left': width.max + option.offset.right
                });
                break;
            default:
                break;
        }
        //animate
        content.css("background-color", option.color);
        arrow.css("border-" + option.placement + "-color", option.color);
        tip.addClass(option.placement).css(css);
        tip.animate({
            "opacity": 1
        }, 'slow');
        tip.bind('click', function () {
            $(this).remove();
        });
        if (option.delay > 0) {
            tip.delay(option.delay).fadeOut(function () {
                $(this).remove();
            });
        }
    }
};