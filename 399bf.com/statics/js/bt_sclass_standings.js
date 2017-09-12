$(document).ready(function () {
    $('#treeMenu').treeCreate();
    //赛季
    $('[data-action="link"]').on('click', function () {
        window.location.assign($(this).data('url'));
    });
});