$(function(){
    var btn=$('.checkbox');
    for(var i=0;i<btn.length;i++){
        $(btn).eq(i).click(function(){
            var bool=$(this).siblings('input').prop('checked');
            if(bool){
                $(this).removeClass('checkbox-on').addClass('checkbox-off');
                $(this).siblings('input').prop('checked',false);
            }else{
                $(this).removeClass('checkbox-off').addClass('checkbox-on');
                $(this).siblings('input').prop('checked',true);
            }
        })
    }

    var liArr=$('.member-info li');
    $(liArr).each(function(){
        var that=$(this);
        $(this).hover(function(){
            $(that).find('a').find('div').css({'backgroundColor':'rgba(253,176,66,0.8)'})
        },function(){
            $(that).find('a').find('div').css({'backgroundColor':'rgba(0,0,0,0.8)'})
        })
    });
});

function technic(value) {
    selector = $('#technic' + value);
    season   = $('#season' + value);
    check = selector.attr('class');

    if (check == 'checkbox checkbox-on') {
        season.hide();
    } else if (check == 'checkbox checkbox-off') {
        season.show();
    }
}

function cat(obj)
{
    var bool = $(obj).siblings('input').prop('checked');
    var class_name = $(obj).data('classname');

    bool ? $('.' + class_name).hide() : $('.' + class_name).show();;
}