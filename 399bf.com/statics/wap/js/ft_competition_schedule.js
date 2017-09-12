$(document).ready(function () {
    // input宽度随内容自适应
    (function(){
        var inputs = document.querySelectorAll('input');
        if(inputs && typeof inputs[0] != 'undefined'){
            for(var i = inputs.length-1; i>=0; i-- ){
                inputs[i].type == 'text' && (inputs[i].size = inputs[i].value.length + 10);
            }
        }
    })(window);

    //资料库 赛程picker 下拉select
    $('#picker-ring').picker({
        toolbarTemplate: '<header class="bar bar-nav">\
		<button class="button button-link pull-right close-picker">确定</button>\
		<h1 class="title">选择</h1>\
		</header>',
        cols: [{
            textAlign: 'center',
            values: category_value,
            displayValues: category_show
        }],
        onClose: function () {
            var target = $('.picker-selected');
            if (target.attr('data-picker-value') != undefined && target.html() != '') {
                url = WAP_PATH + 'competition/' + competitionid + '/schedule/' + target.attr('data-picker-value') + '/' + target.html() + '/';
                window.location.assign(url);
            }
        },
        formatValue: function (picker, value, displayValue) {
            var show = '';
            switch (value) {
                case 'period':
                    show = displayValue + '阶段';
                    break;
                case 'group':
                    show = displayValue;
                    break;
                default:
                    show = '第' + displayValue + '轮';
                    break;
            }
            return show;
        }
    });
});