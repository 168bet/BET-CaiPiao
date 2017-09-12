$("#picker2").picker({
    toolbarTemplate: '<header class="bar bar-nav">\
                           <button class="button button-link pull-right close-picker">确定</button>\
                            <h1 class="title">请选择赛季</h1>\
                         </header>',
    cols: [
        {
            textAlign: 'center',
            values: ['16-17赛季']
        }
    ]
});
$("#picker1").picker({
    toolbarTemplate: '<header class="bar bar-nav">\
                            <button class="button button-link pull-left">按钮</button>\
                            <button class="button button-link pull-right close-picker">确定</button>\
                            <h1 class="title">请选择联赛阶段</h1>\
                         </header>',
    cols: [
        {
            textAlign: 'center',
            values: ['preseason','regular'],
            displayValues: ['季前赛','常规赛']
        }
    ],
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
