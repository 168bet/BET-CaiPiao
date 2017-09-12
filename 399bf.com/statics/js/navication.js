$(document).ready(function () {
    //移入
    $('[data-action="nav-menu"]').on('mouseover', function () {
        var child = $(this).find('.children:first'),
            link = $(this).find('a:first');
        child.show();
        link.css({
            borderRadius: '10px 10px 0 0'
        }).addClass('active');
    });
    //移出
    $('[data-action="nav-menu"]').on('mouseout', function () {
        var child = $(this).find('.children:first'),
            link = $(this).find('a:first');
        child.hide();
        link.css({
            borderRadius: '10px'
        }).removeClass('active');
    });
});