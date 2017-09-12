(function(){
    var height=$('#table-header').offset().top;
    var autoWidth=$('.row').eq(0).width();
    $(window).scroll(function(){
        if($(document).scrollTop()>height){
            $('#table-header').css({
                position:'fixed',
                top:-15+'px',
                zIndex:10,
                width:autoWidth+'px'
            });
        }else{
            $('#table-header').css('position','static');
        }
    });
})();