$("#event").picker({
    toolbarTemplate: '<header class="bar bar-nav">\
                           <button class="button button-link pull-right close-picker">确定</button>\
                            <h1 class="title">请选择联赛阶段</h1>\
                         </header>',
    cols: [
        {
            textAlign: 'center',
            values: sclasscategoryID,
            displayValues: sclasscategory

        }
    ],
    formatValue: function (picker, value, displayValue) {
        return displayValue;
    },
    formatValue: function (picker, value, displayValue) {
        return displayValue;
    },
    onOpen: function () {
        $('.picker-item').each(function () {
            $(this).attr('id', $(this).data('pickerValue'))
        })
    },
    onClose: function () {
        //关闭picker时的回调函数
        var target = $('.picker-selected');
        $('#' + target.get(0).id).show().siblings().hide();
    } 
    
});
$("#score").picker({
    toolbarTemplate: '<header class="bar bar-nav">\
                            <button class="button button-link pull-right close-picker">确定</button>\
                            <h1 class="title">请选择</h1>\
                         </header>',
    cols: [
        {
            textAlign: 'center',
            values: ['df','tl','sf','fq','lb','zg','gm','qd','sw','fg','ls','ss'],
            displayValues: ['得分','投篮','三分','罚球','篮板','助攻','盖帽','抢断','失误','犯规','两双','三双']
        }
    ],
    formatValue: function (picker, value, displayValue) {
        return displayValue;
    },
    formatValue: function (picker, value, displayValue) {
        return displayValue;
    },
    onOpen: function () {
        $('.picker-item').each(function () {
            $(this).attr('id', $(this).data('pickerValue'))
        })
    },
    onClose: function () {
        //关闭picker时的回调函数
        var target = $('.picker-selected');
        $('#' + target.get(0).id).show().siblings().hide();
    } 
});
