$(function (){
    $('.zone-item').click(function(){
        var zoneid = $(this).data('zoneid');

        $('.zone-item').children('a').removeClass('active');
        $(this).children('a').addClass('active');

        $('.guojia-m').hide();
        $('.zone-' + zoneid).show();
    });


});