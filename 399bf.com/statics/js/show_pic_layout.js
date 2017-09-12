//计算图片
function clacImgZoomParam( maxWidth, maxHeight, width, height ){
    var param = {top:0, left:0, width:width, height:height};
    if( width>maxWidth || height>maxHeight )
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;

        if( rateWidth > rateHeight )
        {
            param.width =  maxWidth;
            param.height = Math.round(height / rateWidth);
        }else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }
    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;
}
window.onload=function(){
    var handler = $('#tiles li');

    //瀑布流调用
    handler.wookmark({
        autoResize: true,
        container: $('#main'),
        offset: 5,
        outerOffset: 10,
        itemWidth: 240
    });

    //轮播图大图自适应
    //$('.large_img img').each(function(index,item){
    //    var param=clacImgZoomParam(1000,500,$(item).width(),$(item).height());
    //    $(item).width(param.width);
    //});
    //轮播图小图自适应
    //$('.small_list img').each(function(index,item){
    //    var param=clacImgZoomParam(110,73,$(item).width(),$(item).height());
    //    $(item).width(param.width);
    //});
};