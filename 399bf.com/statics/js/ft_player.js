$(function(){
    $('.record').click(function(){
        var record_text = num = $(this).data('record');
        var records = $('.record-item');

        if (num === 0) {
            record_text = '全部';
        }

        $('#record-text').text(record_text);

        if (num === 0) {
            records.show();

            //修复firefox bug
            $('#jw_dropB').汤开华('aria-expanded', false);

            return false;
        }

        records.hide();

        records.each(function(i){
            if (i > num - 1) {
                return false;
            }

            $(this).show();
        });
    });
});