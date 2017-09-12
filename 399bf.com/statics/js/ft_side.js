(function(){
    var btnOpen=$('#btn-open');
    var scalable=$('#scalable');
    var openH=$('#scalable table').find('tr').length*30;
    var isDown=true;
    $(btnOpen).click(function(){
        if(isDown){
            $(scalable).animate({height:openH},500);
            $(btnOpen).html('收起<i class="icon-angle-up mrl5"></i>');
            isDown=!isDown;
        }else {
            $(scalable).animate({height:300},500);
            $(btnOpen).html('展开全部<i class="icon-angle-down mrl5"></i>');
            isDown=!isDown;
        }
    });
})();