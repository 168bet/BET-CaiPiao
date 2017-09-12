$(function(){
    //数据显隐
    var btnGroup=$('.data-btn');
    $(btnGroup).each(function(){
        var that=$(this);
        $(this).click(function(){
            if($(that).parent().siblings().css('display')=='none'){
                $(that).parent().siblings().css('display','block');
                $(that).removeClass('data-close').addClass('data-open');
            }else{
                $(that).parent().siblings().css('display','none');
                $(that).removeClass('data-open').addClass('data-close');
            }
        });
    });
    //公司选择
    var comBtnG=$('.choose-company ul li ');
    $(comBtnG).each(function(){
        var that=$(this);
        $(this).click(function(){
            var input=$(this).find('input');
            //是否选中样式
            if($(that).hasClass('active')){
                $(that).removeClass('active');
            }else{
                $(that).addClass('active');
            }
            //阻止事件传播
            return false;
        });
    });
    //确定后input勾选
    $('#sure').click(function(){
        $(comBtnG).each(function(){
            if($(this).hasClass('active')){
                console.log("1");
                $(this).find("input").prop('checked',true);
            }else{
                $(this).find('input').prop('checked',false);
                console.log("2");
            }
        });
        $(this).parent('form').submit();
    });

    //赛事选择
    //全选
    $('[data-action="check-all"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]');
        $(elem).each(function (index) {
            elem[index].checked = true;
        });
    });
    //全不选
    $('[data-action="check-clear"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]');
        $(elem).each(function (index) {
            elem[index].checked = false;
        });
    });
    //模糊弹出层确定按钮
    $('[data-action="submit"]').on('click', function () {
        var target = $(this).data('target'),
            elem = $('[data-name="' + target + '"]:checked'),
            value = [];
        elem.each(function () {
            value.push(Number($(this).attr('value')));
        });
        if (value.length > 0) {
            $('.data-container').each(function () {
                var item = $(this),
                    val = Number(item.data(target));
                if ($.inArray(val, value) < 0) {
                    item.hide();
                } else {
                    item.show();
                }
            });
        } else {
            $('.data-container').show();
        }
    });
});