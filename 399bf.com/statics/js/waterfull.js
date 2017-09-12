/**
 * Created by lxt on 2016/4/19.
 */

var iLimit = 5;//测试用

$(window).on('load', function () {
    waterfull();
});

//监听滚动
$(window).on('scroll', function () {
    var bTag = isOver();
    if (bTag && iLimit > 0) {
        waterfull();
        iLimit--;
    }
    if (iLimit <= 0) {
        $('#pagination-section').removeClass('hidden');
    }
});

//是否触发瀑布流获取数据
function isOver() {
    var oItems = $('.picture-item'),
        iMaxHeight = Math.floor(oItems.last().offset().top + (oItems.last().outerHeight()) / 2),
        iScrollHeight = $(window).scrollTop() + $(document).height();
    return iMaxHeight < iScrollHeight;
}

//数组随机排序，测试用
function randomSort(a, b) {
    return Math.random()>0.5 ? -1 : 1;
}

//瀑布流布局
function waterfull() {
    var oData = ODATA,
        oCols = $('.waterfull-col').toArray(),
        iNumber = oData.data.length;

    //打乱数组 ，测试用
    oData.data = oData.data.sort(randomSort);

    for (var i = 0; i < iNumber; i++) {
        var oCol = oCols.shift(),
            oImg = oData.data.shift(),
            oPictureItem = $('<div>').addClass('picture-item'),
            oPictureBox = $('<div>').addClass('picture-box'),
            oPicture = $('<a href="' + oImg.link + '" target="_blank"><img class="img-responsive" src="' + oImg.src + '" alt="' + oImg.title + '"></a>'),
            oPictureInfo = $('<div>').addClass('picture-info'),
            oPictureLink = $('<a>').addClass('picture-title').attr('href', oImg.link).html(oImg.title),
            oPictureTime = $('<span>').addClass('text-muted').html(oImg.time),
            oPictureTimeBox = $('<div>').addClass('picture-time');

        oPictureBox.append(oPicture);
        oPictureTimeBox.append(oPictureTime);
        oPictureInfo.append(oPictureLink, oPictureTimeBox);
        oPictureItem.append(oPictureBox, oPictureInfo);
        $(oCol).append(oPictureItem);
        oCols.push(oCol);
    }
}
