//日历
$(document).on("pageInit", function() {

    $('#calendar').calendar({
        onChange: function(p, v, d) {

            $('#calendar').val(d);
            window.location.assign(WAP_PATH + 'zqsaicheng/?date=' + d);

        }
    })
});