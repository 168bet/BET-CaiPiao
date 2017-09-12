$(document).ready(function () {
    //赔率类型弹窗
    $('.open-about-type').click(function () {
        $.popup('.popup-about-type');
        $('.popup-overlay.modal-overlay-visible').css('visibility', 'hidden')
    });
    $('.popup-close-type').click(function () {
        $.closeModal('.popup-about-type');
    });
    $('#type_ok').click(function () {
        var parent = $(this).parents('[data-action="table-tab"]'),
            table = $(parent.data('target')),
            type = parent.find('a[data-type].active').data('type');
        table.find('tbody[data-type]').removeClass('active');
        table.find('tbody[data-type="' + type + '"]').addClass('active');
        $.closeModal('.popup-about-type');
    });
    $('[data-action="table-tab"]').find('a[data-type]').on('click', function () {
        var parent = $(this).parents('[data-action="table-tab"]'),
            type = $(this).data('type');
        parent.find('a[data-type]').removeClass('active');
        $(this).addClass('active');
    })
});