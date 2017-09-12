//判断是否选中
(function(){
    var btn=$('.checkbox');
    for(var i=0;i<btn.length;i++){
        $(btn).eq(i).click(function(){
            var bool=$(this).siblings('input').prop('checked');
            if(bool){
                $(this).css("background-image","url("+IMG_PATH+"icon-checkbox-off.png)");
                $(this).siblings('input').prop('checked',false);
                $(this).parents('div').eq(1).attr('data-select','false')
            }else{
                $(this).css("background-image","url("+IMG_PATH+"icon-checkbox-on.png)");
                $(this).siblings('input').prop('checked','checked');
                $(this).parents('div').eq(1).attr('data-select',true);
            }
        })
    }

    //选择公司
    $('#company a.odds-company').click(function(){
        $('#companyid').val($(this).data('companyid'));
        $('#search-form').submit();
    });

})();