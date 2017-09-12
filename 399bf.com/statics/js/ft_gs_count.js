(function(){
    var tabItemL=$('.table-l .tabItem');
    $(tabItemL).each(function(index,el){
        $(this).click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            operation.call(this,"l",index);
        })
    });
    var tabItemR=$('.table-r .tabItem');
    $(tabItemR).each(function(index,el){
        $(this).click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            operation.call(this,"r",index);
        })
    });
    function operation(direction,index){
        $(this).parents('.table-'+direction).find('table').css('display','none');
        $(this).parents('.table-'+direction).find('table').eq(0).css('display','table');
        $(this).parents('.table-'+direction).find('table').eq(index+1).css('display','table');
    }
})();