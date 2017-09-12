$("#picker1").picker({
    toolbarTemplate: '<header class="bar bar-nav">\
                            <button class="button button-link pull-left">按钮</button>\
                            <button class="button button-link pull-right close-picker">确定</button>\
                            <h1 class="title">请选择公司</h1>\
                         </header>',
    cols: [{
        textAlign: 'center',
        values: companyIdArr,
        displayValues:companyNameArr
    }],
    onClose: function () {
        var target = $('.picker-selected');
        if (target.attr('data-picker-value') != undefined && target.html() != '') {
            url = WAP_PATH + 'lqodds/?companyid='+target.attr('data-picker-value');
            window.location.assign(url);
        }
    },
    formatValue: function (picker, value, displayValue) {
        return displayValue;
    }
});
$("#picker2").picker({
    toolbarTemplate: '<header class="bar bar-nav">\
                            <button class="button button-link pull-left">按钮</button>\
                            <button class="button button-link pull-right close-picker">确定</button>\
                            <h1 class="title">请选择公司</h1>\
                         </header>',
    cols: [
        {
            textAlign: 'center',
            values: sclassIdArr,
            displayValues: sclassNameArr
        }
    ],
    onClose: function () {
        var target = $('.picker-selected');
        $('.sclass').css({
            display:'none'
        });
        $('.'+target.attr('data-picker-value')).css({
            display:'block'
        });
    },
    formatValue: function (picker, value, displayValue) {
        return displayValue;
    }
});
