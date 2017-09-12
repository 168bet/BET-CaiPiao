//日历
$(function(){
    $('#calendar').calendar({
        onChange: function(p, v, d) {

            $('#calendar').val(d);
            window.location.assign(WAP_PATH + 'lqwanchang/?date=' + d);

        },
        maxDate: maxDate
    });
});