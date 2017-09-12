(function(){
    //篮球资料库通用tab
    $('.tab-btn').each(function(index,item){
        $(this).click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            $('.tab-item').css('display','none');
            $('.tab-item-'+index).css('display','block');
        });
    });
    //球员技术统计单独tab
    $('.shop .shop-btn').each(function(index,item){
        $(this).click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            $('.shop-item').css('display','none');
            $('.shop-item-'+index).css('display','table');
        });
    });
})();