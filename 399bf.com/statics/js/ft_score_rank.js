
$(document).ready(function(){
    $('body').addClass('event-integral');
    streak($('[role="streak"]'));
    showDiolog($("#pathNav"));
    hideDiolog();
    $(window).scroll(function(){
        tabFixed($('#fixedTable'), 480);

    });
    //onChange="location=this.options[this.selectedIndex].value;"
    $('#matchCheck').change(function(){
        $('#type').val($(this).val());
        $('#matchSelect').submit();
    });

    //返回顶部
    $(window).returnTop();
});
