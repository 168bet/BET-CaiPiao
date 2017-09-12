$(function(){
    var btnNf=$('#btnNotf');
    var btnf=$('#btnf');
    $(btnNf).click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('#not-finished').css('display','block');
        $('#finished').css('display','none');
    });
    $(btnf).click(function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('#not-finished').css('display','none');
        $('#finished').css('display','block');
    });
});