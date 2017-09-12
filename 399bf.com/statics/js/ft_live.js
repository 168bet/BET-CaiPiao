/**
 * Created by lxt on 2016/7/4.
 */
$(function(){
/*
/  代码已转移common.js
 */

    $('.date-item').on('click', function() {
        var value = $(this).data('date');
        $('#date').val(value).parents('form').submit();
    });

});